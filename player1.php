<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-Type: text/html; charset=utf-8');

/* =========================================================
   1) Referrer 체크
========================================================= */
$allowed_referrers = [
  'https://tvmon16.org/',
  'https://tvhot.store/',
  'https://tvmon.site/',
  'https://tvwiki4.net/'
];

$referer = $_SERVER['HTTP_REFERER'] ?? '';
$valid = false;
foreach ($allowed_referrers as $allowed) {
  if (stripos($referer, $allowed) === 0) { $valid = true; break; }
}
if (!$valid) {
  header("HTTP/1.1 403 Forbidden");
  echo "하단 고객센터로 문의주세요";
  exit;
}

/* =========================================================
   2) 파라미터
========================================================= */
$s      = isset($_GET['s']) ? (string)$_GET['s'] : '';
$type   = isset($_GET['type']) ? (string)$_GET['type'] : '';
$src_in = isset($_REQUEST['src']) ? (string)$_REQUEST['src'] : '';
$option = isset($_GET['option']) ? (string)$_GET['option'] : '';
$srt    = isset($_REQUEST['srt']) ? (string)$_REQUEST['srt'] : '';
$p      = isset($_REQUEST['p']) ? (string)$_REQUEST['p'] : '';

/* =========================================================
   3) 서버 선택
========================================================= */
switch ($s) {
  case '2': $base_url = 'every2.poorcdn.com'; break;
  case '3': $base_url = 'every3.poorcdn.com'; break;
  case '4': $base_url = 'every4.poorcdn.com'; break;
  case '5': $base_url = 'every5.poorcdn.com'; break;
  case '6': $base_url = 'every6.poorcdn.com'; break;
  case '7': $base_url = 'every7.poorcdn.com'; break;
  case '8': $base_url = 'every8.poorcdn.com'; break;
  default:  $base_url = 'every1.poorcdn.com'; break;
}

/* =========================================================
   4) AES 설정
========================================================= */
$k = "0123456789abcdef0123456789abcdef";  // hex key (16 bytes)
$i = "abcdef9876543210abcdef9876543210";  // hex iv  (16 bytes)
$key = hex2bin($k);
$iv  = hex2bin($i);

function encrypt_data($data, $key, $iv) {
  return bin2hex(openssl_encrypt($data, "aes-128-cbc", $key, OPENSSL_RAW_DATA, $iv));
}
function safe_hex2bin($hex) {
  if ($hex === '' || (strlen($hex) % 2) !== 0 || preg_match('/[^0-9a-fA-F]/', $hex)) return false;
  return hex2bin($hex);
}

/* =========================================================
   5) src 복호화 + 경로 정규화
========================================================= */
$src_hex = isset($_GET['src']) ? (string)$_GET['src'] : '';
$src_bin = safe_hex2bin($src_hex);
if ($src_bin === false) {
  header("HTTP/1.1 400 Bad Request");
  echo "잘못된 src";
  exit;
}

$src_dec = openssl_decrypt($src_bin, "aes-128-cbc", $key, OPENSSL_RAW_DATA, $iv);
if ($src_dec === false || $src_dec === '') {
  header("HTTP/1.1 400 Bad Request");
  echo "src 복호화 실패";
  exit;
}

/* src_dec → path만 뽑기 */
$src_path = $src_dec;
if (preg_match('#^https?://#i', $src_dec)) {
  $u = parse_url($src_dec);
  $src_path = $u['path'] ?? '';
}
$src_path = ltrim((string)$src_path, '/'); // "dir/file.m3u8"

/* 디렉토리만 */
$dir_path = preg_replace('#/[^/]+\.(m3u8|mp4)(\?.*)?$#i', '', $src_path);
$dir_path = trim((string)$dir_path, '/'); // "dir"

/* =========================================================
   ✅ srt URL
========================================================= */
$srt_url = '';
if (!empty($srt)) {
  $srt_url = rtrim($referer, "/") . "/" . ltrim($srt, "/");
}

/* =========================================================
   6) 토큰 + 최종 c.html URL 생성
========================================================= */
$secret_key = "VERY_COOL_SECRET";
$expires = time() + 20; // 20초 유효
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$token = strtr(base64_encode(hash_hmac('sha1', "{$expires}::{$ip}", $secret_key, true)), '+/', '-_');

if ($s === '5' || $s === '6') {
  $fileURL = "https://{$base_url}/{$dir_path}/c.html?c29";
} else {
  $fileURL = "https://{$base_url}/{$dir_path}/c.html?token={$token}&expires={$expires}";
}

/* (JS에서 복호화해서 쓸) 재생 URL 암호화 */
$myurl = encrypt_data($fileURL, $key, $iv);

/* =========================================================
   ✅ P2P swarmId = 토큰 없는 안정값
========================================================= */
$swarm_id = "{$base_url}/{$dir_path}";
if ($dir_path === '') $swarm_id = $base_url;

/* =========================================================
   HTML에 안전하게 박기
========================================================= */
$swarm_id_js = json_encode($swarm_id, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$myurl_js    = json_encode($myurl,    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$k_js        = json_encode($k,        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$i_js        = json_encode($i,        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$srt_js      = json_encode($srt_url,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

/* =========================================================
   CSS 캐시 버스팅 (파일 수정 시간 기반)
========================================================= */
$css_file = __DIR__ . '/player.css';
$css_version = file_exists($css_file) ? filemtime($css_file) : time();
?>
<!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="referrer" content="origin" />

  <!-- CSS with cache busting based on file modification time -->
  <link rel="stylesheet" href="player.css?v=<?= $css_version ?>">

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/hls.js@~1/dist/hls.min.js"></script>

  <script type="importmap">
    {
      "imports": {
        "p2p-media-loader-core": "https://cdn.jsdelivr.net/npm/p2p-media-loader-core@^1/dist/p2p-media-loader-core.es.min.js",
        "p2p-media-loader-hlsjs": "https://cdn.jsdelivr.net/npm/p2p-media-loader-hlsjs@^1/dist/p2p-media-loader-hlsjs.es.min.js"
      }
    }
  </script>

  <script type="module" src="https://cdn.jsdelivr.net/npm/vidstack@next/cdn/vidstack.js"></script>
</head>

<body>
  <div class="wrap">
    <media-player id="player" playsinline class="text-white" data-swarm-id="<?= htmlspecialchars($swarm_id, ENT_QUOTES, 'UTF-8') ?>">
      <media-provider></media-provider>

      <!-- Tap Layer -->
      <div id="tapLayer" class="absolute inset-0 z-10"></div>

      <!-- Center Controls -->
      <div id="centerControls">
        <div class="center-btns">
          <button id="centerBack" class="center-btn" aria-label="Back 10s">
            <svg viewBox="0 0 24 24"><path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/></svg>
            <span class="skip-label">10</span>
          </button>

          <button id="bigPlay" class="center-btn play-btn" aria-label="Toggle">
            <svg id="icoBigPlay" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            <svg id="icoBigPause" class="hidden" viewBox="0 0 24 24"><path d="M6 4h4v16H6zM14 4h4v16h-4z"/></svg>
          </button>

          <button id="centerFwd" class="center-btn" aria-label="Forward 10s">
            <svg viewBox="0 0 24 24"><path d="M12 5V1l5 5-5 5V7c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6h2c0 4.42-3.58 8-8 8s-8-3.58-8-8 3.58-8 8-8z"/></svg>
            <span class="skip-label">10</span>
          </button>
        </div>
      </div>

      <!-- Buffering -->
      <div id="buffering">
        <div class="w-12 h-12 rounded-full border-2 border-white/30 border-t-white animate-spin"></div>
      </div>

      <!-- Top Bar -->
      <div id="topBar" class="absolute top-0 left-0 right-0 z-30 flex items-center justify-between transition-opacity duration-200">
        <div class="text-sm font-medium truncate max-w-[70%]"></div>

        <div class="flex items-center gap-1">
          <!-- CC Button -->
          <button id="ccBtn" class="ctrl-btn hidden" aria-label="Captions" aria-pressed="false" title="자막">
            <svg viewBox="0 0 24 24">
              <path d="M19 4H5c-1.11 0-2 .9-2 2v12c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 7H9.5v-.5h-2v3h2V13H11v1c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-4c0-.55.45-1 1-1h3c.55 0 1 .45 1 1v1zm7 0h-1.5v-.5h-2v3h2V13H18v1c0 .55-.45 1-1 1h-3c-.55 0-1-.45-1-1v-4c0-.55.45-1 1-1h3c.55 0 1 .45 1 1v1z"/>
            </svg>
          </button>

          <!-- Cast Button (Android/Desktop) -->
          <media-google-cast-button id="castBtn" class="ctrl-btn" aria-label="Cast">
            <svg viewBox="0 0 24 24">
              <path d="M21 3H3c-1.1 0-2 .9-2 2v3h2V5h18v14h-7v2h7c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM1 18v3h3c0-1.66-1.34-3-3-3zm0-4v2c2.76 0 5 2.24 5 5h2c0-3.87-3.13-7-7-7zm0-4v2c4.97 0 9 4.03 9 9h2c0-6.08-4.93-11-11-11z"/>
            </svg>
          </media-google-cast-button>

          <!-- AirPlay Button (iOS only) -->
          <button id="airplayBtn" class="ctrl-btn hidden" aria-label="AirPlay" title="AirPlay">
            <svg viewBox="0 0 24 24">
              <path d="M6 22h12l-6-6-6 6zM21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4v-2H3V5h18v12h-4v2h4c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
            </svg>
          </button>

          <!-- Settings Button -->
          <button id="settingsBtn" class="ctrl-btn" aria-label="Settings">
            <svg viewBox="0 0 24 24">
              <path d="M19.14 12.94c.04-.31.06-.63.06-.94 0-.31-.02-.63-.06-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Settings Panel -->
      <div id="settingsPanel" class="panel hidden absolute z-40">
        <!-- Main Menu -->
        <div id="settingsMain">
          <div>설정</div>

          <div>
            <button id="speedRow" type="button" class="w-full flex items-center justify-between text-white">
              <span class="text-sm">재생 속도</span>
              <div class="flex items-center gap-2">
                <span id="speedValue" class="text-sm text-white/70">보통</span>
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="white"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
              </div>
            </button>

            <button id="capRow" type="button" class="w-full flex items-center justify-between text-white">
              <span class="text-sm">자막</span>
              <div class="flex items-center gap-2">
                <span id="capValue" class="text-sm text-white/70">사용 안함</span>
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="white"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
              </div>
            </button>
          </div>
        </div>

        <!-- Speed Menu -->
        <div id="speedMenu" class="hidden">
          <button id="speedBack" type="button" class="w-full flex items-center gap-3 text-white">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="white"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            <span class="text-sm font-medium">재생 속도</span>
          </button>
          <div id="speedList" class="speed-grid"></div>
        </div>

        <!-- Captions Menu -->
        <div id="capMenu" class="hidden">
          <button id="capBack" type="button" class="w-full flex items-center gap-3 text-white">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="white"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            <span class="text-sm font-medium">자막</span>
          </button>
          <div id="capList" class="speed-grid"></div>
        </div>
      </div>

      <!-- Bottom Controls -->
      <div id="bottomBar" class="absolute left-0 right-0 bottom-0 z-30 transition-opacity duration-200">
        <input id="seek" type="range" min="0" max="1000" value="0" class="w-full" />

        <div class="mt-2 flex items-center gap-1">
          <button id="playBtn" class="ctrl-btn" aria-label="Play/Pause">
            <svg id="icoPlay" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            <svg id="icoPause" class="hidden" viewBox="0 0 24 24"><path d="M6 4h4v16H6zM14 4h4v16h-4z"/></svg>
          </button>

          <button id="backBtn" class="ctrl-btn" aria-label="Back 10s">
            <svg viewBox="0 0 24 24"><path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/></svg>
          </button>

          <button id="fwdBtn" class="ctrl-btn" aria-label="Forward 10s">
            <svg viewBox="0 0 24 24"><path d="M12 5V1l5 5-5 5V7c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6h2c0 4.42-3.58 8-8 8s-8-3.58-8-8 3.58-8 8-8z"/></svg>
          </button>

          <!-- YouTube-Style Volume -->
          <div class="vol-container" id="volContainer">
            <button id="volBtn" class="ctrl-btn" aria-label="Volume">
              <svg id="icoVol" viewBox="0 0 24 24">
                <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
              </svg>
              <svg id="icoMute" class="hidden" viewBox="0 0 24 24">
                <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/>
              </svg>
            </button>
            <div class="vol-slider-wrap">
              <div class="vol-track">
                <div class="vol-progress" id="volProgress"></div>
              </div>
              <input id="volSlider" type="range" min="0" max="1" step="0.01" value="1" class="vol-slider">
            </div>
          </div>

          <div id="time" class="min-w-[90px] px-2 whitespace-nowrap shrink-0">
            0:00 / 0:00
          </div>

          <div class="flex-1"></div>

          <button id="pipBtn" class="ctrl-btn" aria-label="PIP">
            <svg viewBox="0 0 24 24">
              <path d="M19 7h-8v6h8V7zm2-4H3c-1.1 0-2 .9-2 2v14c0 1.1.9 1.98 2 1.98h18c1.1 0 2-.88 2-1.98V5c0-1.1-.9-2-2-2zm0 16.01H3V4.98h18v14.03z"/>
            </svg>
          </button>

          <button id="fsBtn" class="ctrl-btn" aria-label="Fullscreen">
            <svg viewBox="0 0 24 24">
              <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
            </svg>
          </button>
        </div>
      </div>
    </media-player>
  </div>

  <script type="module">
    import { HlsJsP2PEngine } from "p2p-media-loader-hlsjs";

    // ===== Configuration =====
    const DEBUG = false;
    const _log = console.log.bind(console);
    console.log = (...args) => { if (DEBUG) _log(...args); };

    const SWARM_ID = <?= $swarm_id_js ?>;
    const ENC_URL = <?= $myurl_js ?>;
    const HEX_KEY = <?= $k_js ?>;
    const HEX_IV = <?= $i_js ?>;
    const SUB_URL = <?= $srt_js ?>;

    // ===== Utility Functions =====
    const $ = (id) => document.getElementById(id);
    const clamp = (v, min, max) => Math.max(min, Math.min(max, v));
    const clamp01 = (v) => clamp(Number(v) || 0, 0, 1);
    const pad2 = (n) => String(n).padStart(2, "0");

    function fmtTime(sec) {
      sec = Math.max(0, Number(sec) || 0);
      const h = Math.floor(sec / 3600);
      const m = Math.floor((sec % 3600) / 60);
      const s = Math.floor(sec % 60);
      return h > 0 ? `${h}:${pad2(m)}:${pad2(s)}` : `${m}:${pad2(s)}`;
    }

    function fmtBytes(n) {
      n = Number(n) || 0;
      if (n <= 0) return "0B";
      const units = ["B", "KB", "MB", "GB", "TB"];
      let i = 0;
      while (n >= 1024 && i < units.length - 1) { n /= 1024; i++; }
      return (i === 0 ? n.toFixed(0) : n.toFixed(2)) + units[i];
    }

    function blurActive() {
      const el = document.activeElement;
      if (el && el !== document.body && typeof el.blur === "function") el.blur();
    }

    // ===== Decryption =====
    function decryptHexAesCbc(hexCipher) {
      const CryptoJS = window.CryptoJS;
      const ciphertext = CryptoJS.enc.Hex.parse(hexCipher);
      const key = CryptoJS.enc.Hex.parse(HEX_KEY);
      const iv = CryptoJS.enc.Hex.parse(HEX_IV);
      const decrypted = CryptoJS.AES.decrypt({ ciphertext }, key, {
        iv,
        padding: CryptoJS.pad.Pkcs7,
        mode: CryptoJS.mode.CBC
      });
      return decrypted.toString(CryptoJS.enc.Utf8);
    }

    const PLAY_URL = decryptHexAesCbc(ENC_URL);

    // ===== Player Setup =====
    const HlsWithP2P = HlsJsP2PEngine.injectMixin(window.Hls);
    const player = $("player");
    const source = { src: PLAY_URL, type: "application/x-mpegurl" };

    // ===== DOM Elements =====
    const elements = {
      tapLayer: $("tapLayer"),
      centerControls: $("centerControls"),
      bigPlay: $("bigPlay"),
      centerBack: $("centerBack"),
      centerFwd: $("centerFwd"),
      icoBigPlay: $("icoBigPlay"),
      icoBigPause: $("icoBigPause"),
      buffering: $("buffering"),
      playBtn: $("playBtn"),
      backBtn: $("backBtn"),
      fwdBtn: $("fwdBtn"),
      seek: $("seek"),
      time: $("time"),
      pipBtn: $("pipBtn"),
      fsBtn: $("fsBtn"),
      settingsBtn: $("settingsBtn"),
      settingsPanel: $("settingsPanel"),
      settingsMain: $("settingsMain"),
      speedRow: $("speedRow"),
      speedBack: $("speedBack"),
      speedList: $("speedList"),
      speedValue: $("speedValue"),
      capRow: $("capRow"),
      capBack: $("capBack"),
      capList: $("capList"),
      capValue: $("capValue"),
      speedMenu: $("speedMenu"),
      capMenu: $("capMenu"),
      volBtn: $("volBtn"),
      volContainer: $("volContainer"),
      volSlider: $("volSlider"),
      volProgress: $("volProgress"),
      ccBtn: $("ccBtn"),
      castBtn: $("castBtn"),
      airplayBtn: $("airplayBtn"),
      icoPlay: $("icoPlay"),
      icoPause: $("icoPause"),
      icoVol: $("icoVol"),
      icoMute: $("icoMute")
    };

    // ===== Resume System =====
    const ResumeManager = {
      KEY: `resume:${SWARM_ID}`,
      INTERVAL: 5000,
      MIN_SEC: 3,
      END_RATIO: 0.98,
      lastSaved: 0,
      restored: false,

      read() {
        try {
          const raw = localStorage.getItem(this.KEY);
          if (!raw) return null;
          const obj = JSON.parse(raw);
          return (obj && typeof obj.t === "number") ? obj : null;
        } catch { return null; }
      },

      write(t, dur) {
        try {
          localStorage.setItem(this.KEY, JSON.stringify({ t, dur, at: Date.now() }));
        } catch {}
      },

      clear() {
        try { localStorage.removeItem(this.KEY); } catch {}
      },

      save(force = false) {
        const now = Date.now();
        if (!force && (now - this.lastSaved) < this.INTERVAL) return;

        const t = Number(player.currentTime || 0);
        const dur = Number(player.duration || 0);

        if (!isFinite(t) || t < this.MIN_SEC) return;

        if (isFinite(dur) && dur > 0 && (t / dur) >= this.END_RATIO) {
          this.clear();
          this.lastSaved = now;
          return;
        }

        this.write(t, dur);
        this.lastSaved = now;
      },

      restore() {
        if (this.restored) return;
        const data = this.read();
        if (!data) { this.restored = true; return; }

        const dur = Number(player.duration || 0);
        const target = Number(data.t || 0);

        if (target > this.MIN_SEC) {
          try {
            if (isFinite(dur) && dur > 0) {
              player.currentTime = Math.min(Math.max(0, target), Math.max(0, dur - 1));
            } else {
              player.currentTime = target;
            }
          } catch {}
        }
        this.restored = true;
      }
    };

    // ===== Stats Tracking =====
    const Stats = {
      http: 0, p2p: 0, up: 0, peers: 0,
      lastHttp: 0, lastP2P: 0, lastUp: 0,
      timer: null,

      start() {
        this.stop();
        this.timer = setInterval(() => {
          const dh = this.http - this.lastHttp;
          const dp = this.p2p - this.lastP2P;
          const du = this.up - this.lastUp;
          this.lastHttp = this.http;
          this.lastP2P = this.p2p;
          this.lastUp = this.up;
          console.log(`[P2P/HTTP 3s] peers=${this.peers} | +http=${fmtBytes(dh)} +p2p=${fmtBytes(dp)} +up=${fmtBytes(du)}`);
        }, 3000);
      },

      stop() {
        if (this.timer) { clearInterval(this.timer); this.timer = null; }
      },

      reset() {
        this.http = this.p2p = this.up = this.peers = 0;
        this.lastHttp = this.lastP2P = this.lastUp = 0;
      }
    };

    // ===== Subtitle System =====
    const SubtitleManager = {
      wanted: !!(SUB_URL && String(SUB_URL).trim()),
      track: null,
      loaded: false,

      getVideo() {
        return player?.querySelector?.("video") || null;
      },

      getExtension(url) {
        url = String(url || "").toLowerCase().split("?")[0];
        if (url.endsWith(".vtt")) return "vtt";
        if (url.endsWith(".srt")) return "srt";
        return "";
      },

      parseTime(t, format) {
        t = String(t || "").trim().replace(",", ".");

        if (format === "srt") {
          const m = t.match(/^(\d{1,2}):(\d{2}):(\d{2})\.(\d{1,3})$/);
          if (!m) return null;
          let ms = m[4].padEnd(3, "0");
          return Number(m[1]) * 3600 + Number(m[2]) * 60 + Number(m[3]) + Number(ms) / 1000;
        }

        // VTT format
        let m = t.match(/^(\d{1,2}):(\d{2})\.(\d{1,3})$/);
        if (m) {
          let ms = m[3].padEnd(3, "0");
          return Number(m[1]) * 60 + Number(m[2]) + Number(ms) / 1000;
        }

        m = t.match(/^(\d{1,2}):(\d{2}):(\d{2})\.(\d{1,3})$/);
        if (m) {
          let ms = m[4].padEnd(3, "0");
          return Number(m[1]) * 3600 + Number(m[2]) * 60 + Number(m[3]) + Number(ms) / 1000;
        }

        return null;
      },

      parseBlocks(text, format) {
        text = String(text || "").replace(/^\uFEFF/, "");
        if (format === "vtt") {
          text = text.replace(/^WEBVTT[^\n]*\r?\n/, "");
          text = text.replace(/\r?\nNOTE[\s\S]*?(?=\r?\n\r?\n|$)/g, "\n");
        }

        const blocks = text.split(/\r?\n\r?\n+/);
        const cues = [];

        for (const b of blocks) {
          const lines = b.split(/\r?\n/).map(x => x.trimEnd()).filter(x => x);
          if (!lines.length) continue;

          let idx = 0;
          if (!lines[0].includes("-->") && lines.length >= 2 && lines[1].includes("-->")) idx = 1;
          else if (/^\d+$/.test(lines[0].trim())) idx = 1;

          const timeLine = (lines[idx] || "").trim();
          if (!timeLine.includes("-->")) continue;

          const parts = timeLine.split("-->").map(x => x.trim().split(/\s+/)[0]);
          const st = this.parseTime(parts[0], format);
          const en = this.parseTime(parts[1], format);
          if (st == null || en == null || en <= st) continue;

          const textContent = lines.slice(idx + 1).join("\n").trim();
          if (textContent) cues.push({ start: st, end: en, text: textContent });
        }

        return cues;
      },

      createCue(start, end, text) {
        try {
          const cue = new VTTCue(start, end, text);
          cue.line = -3;
          cue.position = 50;
          cue.align = "center";
          return cue;
        } catch {
          try { return new TextTrackCue(start, end, text); } catch { return null; }
        }
      },

      ensureTrack() {
        const v = this.getVideo();
        if (!v) return null;
        if (this.track) return this.track;

        try {
          this.track = v.addTextTrack("captions", "Korean", "ko");
          this.track.mode = this.wanted ? "showing" : "hidden";
          return this.track;
        } catch {
          return null;
        }
      },

      async load(url) {
        const v = this.getVideo();
        if (!v || this.loaded) return;
        this.loaded = true;

        const track = this.ensureTrack();
        if (!track) { this.loaded = false; return; }

        try {
          const res = await fetch(url, { mode: "cors", credentials: "omit" });
          if (!res.ok) throw new Error("HTTP " + res.status);
          const text = await res.text();
          const format = this.getExtension(url) || "srt";
          const cues = this.parseBlocks(text, format);

          for (const c of cues) {
            const cue = this.createCue(c.start, c.end, c.text);
            if (cue) try { track.addCue(cue); } catch {}
          }

          this.applyMode();
          UIManager.updateCaptions();
        } catch {
          this.loaded = false;
        }
      },

      applyMode() {
        const v = this.getVideo();
        if (!v) return;

        try {
          const tracks = v.textTracks;
          for (let i = 0; i < tracks.length; i++) {
            const t = tracks[i];
            if (t.kind === "captions" || t.kind === "subtitles") {
              t.mode = this.wanted ? "showing" : "hidden";
            }
          }
        } catch {}

        if (this.track) {
          this.track.mode = this.wanted ? "showing" : "hidden";
        }

        elements.ccBtn?.classList.toggle("cc-active", this.wanted);
        elements.ccBtn?.setAttribute("aria-pressed", this.wanted ? "true" : "false");
      },

      toggle() {
        if (!SUB_URL) return;
        this.wanted = !this.wanted;
        this.applyMode();
        UIManager.updateCaptions();
      },

      init() {
        if (!SUB_URL) {
          elements.ccBtn?.classList.add("hidden");
          return;
        }
        elements.ccBtn?.classList.remove("hidden");
        this.load(SUB_URL);
      },

      scheduleInit() {
        this.init();
        setTimeout(() => this.init(), 300);
        setTimeout(() => this.init(), 900);
        setTimeout(() => this.init(), 1800);
      }
    };

    // ===== UI Manager =====
    const UIManager = {
      barsTimer: null,
      barsVisible: true,
      isSeeking: false,
      lastNonZeroVol: 1,
      playbackRate: 1,
      speedButtons: [],
      capButtons: [],
      speedBuilt: false,
      capBuilt: false,

      isPaused() {
        try {
          if (player?.state && typeof player.state.paused === "boolean") return player.state.paused;
        } catch {}
        return !!player.paused;
      },

      isMuted() {
        try {
          if (player?.state && typeof player.state.muted === "boolean" && player.state.muted) return true;
        } catch {}
        return !!player.muted || Number(player.volume || 0) <= 0.0001;
      },

      isSettingsOpen() {
        return !elements.settingsPanel.classList.contains("hidden");
      },

      setBarsHidden(hidden) {
        player.classList.toggle("ui-hidden", !!hidden);
      },

      applyBars() {
        if (this.isPaused() || this.isSettingsOpen()) {
          this.setBarsHidden(false);
          return;
        }
        this.setBarsHidden(!this.barsVisible);
      },

      showBars(ms = 3000) {
        this.barsVisible = true;
        this.applyBars();
        if (this.barsTimer) clearTimeout(this.barsTimer);
        this.barsTimer = setTimeout(() => {
          this.barsVisible = false;
          this.applyBars();
        }, ms);
      },

      renderPlayIcon() {
        const paused = this.isPaused();
        elements.icoPlay.classList.toggle("hidden", !paused);
        elements.icoPause.classList.toggle("hidden", paused);
        elements.icoBigPlay.classList.toggle("hidden", !paused);
        elements.icoBigPause.classList.toggle("hidden", paused);
      },

      renderVolIcon() {
        const muted = this.isMuted();
        elements.icoVol.classList.toggle("hidden", muted);
        elements.icoMute.classList.toggle("hidden", !muted);
      },

      updateVolSlider() {
        const muted = this.isMuted();
        const v = muted ? 0 : clamp01(player.volume || 0);
        const percent = v * 100;
        if (elements.volProgress) {
          elements.volProgress.style.width = `${percent}%`;
        }
      },

      updateTime() {
        const cur = Number(player.currentTime || 0);
        const dur = Number(player.duration || 0);
        elements.time.textContent = `${fmtTime(cur)} / ${dur ? fmtTime(dur) : "0:00"}`;
        if (!this.isSeeking && dur > 0) {
          elements.seek.value = String(Math.round((cur / dur) * 1000));
          elements.seek.style.setProperty("--seek-percent", `${(cur / dur) * 100}%`);
        }
      },

      showBuffering() {
        elements.buffering.classList.add("show");
      },

      hideBuffering() {
        elements.buffering.classList.remove("show");
      },

      closeSettings() {
        elements.settingsPanel.classList.add("hidden");
        elements.settingsMain?.classList.remove("hidden");
        elements.speedMenu?.classList.add("hidden");
        elements.capMenu?.classList.add("hidden");
      },

      openSettingsMain() {
        elements.settingsMain?.classList.remove("hidden");
        elements.speedMenu?.classList.add("hidden");
        elements.capMenu?.classList.add("hidden");
        this.updateSpeed();
        this.updateCaptions();
      },

      openSpeedMenu() {
        this.buildSpeedButtons();
        elements.settingsMain?.classList.add("hidden");
        elements.speedMenu?.classList.remove("hidden");
        elements.capMenu?.classList.add("hidden");
        this.updateSpeed();
      },

      openCapMenu() {
        this.buildCapButtons();
        elements.settingsMain?.classList.add("hidden");
        elements.speedMenu?.classList.add("hidden");
        elements.capMenu?.classList.remove("hidden");
        this.updateCaptions();
      },

      buildSpeedButtons() {
        if (this.speedBuilt || !elements.speedList) return;
        this.speedBuilt = true;
        elements.speedList.innerHTML = "";

        const speeds = [0.25, 0.5, 0.75, 1, 1.25, 1.5, 1.75, 2];
        const labels = ["0.25", "0.5", "0.75", "보통", "1.25", "1.5", "1.75", "2"];
        speeds.forEach((sp, i) => {
          const btn = document.createElement("button");
          btn.type = "button";
          btn.className = "speed-pill";
          btn.dataset.rate = String(sp);
          btn.innerHTML = `
            <span class="speed-check">
              <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            </span>
            <span class="speed-label">${labels[i]}</span>
          `;

          btn.addEventListener("pointerup", (e) => {
            e.preventDefault();
            e.stopPropagation();
            blurActive();
            this.setPlaybackRate(sp);
          }, { passive: false });

          this.speedButtons.push(btn);
          elements.speedList.appendChild(btn);
        });

        this.updateSpeed();
      },

      buildCapButtons() {
        if (this.capBuilt || !elements.capList) return;
        this.capBuilt = true;
        elements.capList.innerHTML = "";

        const items = [{ mode: "off", label: "사용 안함" }, { mode: "on", label: "한국어" }];
        items.forEach(it => {
          const btn = document.createElement("button");
          btn.type = "button";
          btn.className = "speed-pill";
          btn.dataset.mode = it.mode;
          btn.innerHTML = `
            <span class="speed-check">
              <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            </span>
            <span class="speed-label">${it.label}</span>
          `;

          btn.addEventListener("pointerup", (e) => {
            e.preventDefault();
            e.stopPropagation();
            blurActive();
            if (!SUB_URL) {
              SubtitleManager.wanted = false;
              SubtitleManager.applyMode();
              this.updateCaptions();
              return;
            }
            SubtitleManager.wanted = (it.mode === "on");
            SubtitleManager.applyMode();
            this.updateCaptions();
          }, { passive: false });

          this.capButtons.push(btn);
          elements.capList.appendChild(btn);
        });

        this.updateCaptions();
      },

      getPlaybackRate() {
        const r = Number(this.playbackRate || player.playbackRate || 1);
        return (isFinite(r) && r > 0) ? r : 1;
      },

      setPlaybackRate(rate) {
        rate = Number(rate);
        if (!isFinite(rate) || rate <= 0) rate = 1;

        this.playbackRate = rate;
        this.updateSpeed();

        try { player.playbackRate = rate; } catch {}
        try {
          const v = SubtitleManager.getVideo();
          if (v) v.playbackRate = rate;
        } catch {}

        setTimeout(() => {
          try {
            const v = SubtitleManager.getVideo();
            if (v && Math.abs((v.playbackRate || 1) - rate) > 0.001) v.playbackRate = rate;
            if (Math.abs((player.playbackRate || 1) - rate) > 0.001) player.playbackRate = rate;
          } catch {}
          this.updateSpeed();
        }, 0);

        if (this.isSettingsOpen()) this.showBars(999999);
      },

      stepSpeed(delta) {
        const speeds = [0.25, 0.5, 0.75, 1, 1.25, 1.5, 1.75, 2];
        const cur = this.getPlaybackRate();
        let bestI = 0, bestD = Infinity;
        for (let i = 0; i < speeds.length; i++) {
          const d = Math.abs(speeds[i] - cur);
          if (d < bestD) { bestD = d; bestI = i; }
        }
        const newI = clamp(bestI + delta, 0, speeds.length - 1);
        this.setPlaybackRate(speeds[newI]);
        this.showBars(3000);
      },

      updateSpeed() {
        const cur = this.getPlaybackRate();
        const labels = { 0.25: "0.25", 0.5: "0.5", 0.75: "0.75", 1: "보통", 1.25: "1.25", 1.5: "1.5", 1.75: "1.75", 2: "2" };
        if (elements.speedValue) {
          elements.speedValue.textContent = labels[cur] || `${cur}x`;
        }

        for (const b of this.speedButtons) {
          const r = Number(b.dataset.rate || 0);
          b.classList.toggle("active", Math.abs(cur - r) < 0.001);
        }
      },

      updateCaptions() {
        if (!elements.capValue) return;
        elements.capValue.textContent = !SUB_URL ? "사용 안함" : (SubtitleManager.wanted ? "한국어" : "사용 안함");

        for (const b of this.capButtons) {
          const mode = b.dataset.mode;
          const on = (mode === "on") ? SubtitleManager.wanted : !SubtitleManager.wanted;
          b.classList.toggle("active", on);
        }
      },

      syncVolUI() {
        const v = clamp01(player.volume || 0);
        const muted = this.isMuted();
        if (v > 0.0001) this.lastNonZeroVol = v;
        try { elements.volSlider.value = String(muted ? 0 : v); } catch {}
        this.updateVolSlider();
        this.renderVolIcon();
      },

      setVolume(v) {
        v = clamp01(v);
        try { player.volume = v; } catch {}
        try { player.muted = (v <= 0.0001); } catch {}
        if (v > 0.0001) this.lastNonZeroVol = v;
        this.syncVolUI();
        this.showBars(3000);
      },

      toggleMute() {
        const curVol = clamp01(player.volume || 0);
        
        if (player.muted) {
          // 뮤트 해제
          player.muted = false;
          if (curVol <= 0.0001) {
            player.volume = this.lastNonZeroVol > 0.0001 ? this.lastNonZeroVol : 1;
          }
        } else {
          // 뮤트
          if (curVol > 0.0001) this.lastNonZeroVol = curVol;
          player.muted = true;
        }
        this.syncVolUI();
        this.showBars(3000);
      },

      closeAllPanels() {
        if (this.isSettingsOpen()) this.closeSettings();
      }
    };

    // ===== Player Controls =====
    const PlayerControls = {
      async safePlay() {
        try { await player.play(); return true; } catch {}
        try {
          const v = SubtitleManager.getVideo();
          if (v) { await v.play(); return true; }
        } catch {}
        return false;
      },

      safePause() {
        try { player.pause(); return true; } catch {}
        try {
          const v = SubtitleManager.getVideo();
          if (v) { v.pause(); return true; }
        } catch {}
        return false;
      },

      async togglePlay() {
        if (UIManager.isPaused()) await this.safePlay();
        else this.safePause();
      },

      seekRel(delta) {
        const cur = Number(player.currentTime || 0);
        const dur = Number(player.duration || 0) || Infinity;
        player.currentTime = Math.min(dur, Math.max(0, cur + delta));
      },

      getStateSafe(key, fallback = false) {
        try {
          if (player?.state && key in player.state) return !!player.state[key];
        } catch {}
        return fallback;
      },

      async togglePip() {
        try {
          const isPip = this.getStateSafe("pictureInPicture", !!document.pictureInPictureElement);
          const canPip = this.getStateSafe("canPictureInPicture", true);
          if (!canPip) return;

          if (isPip) {
            if (typeof player.exitPictureInPicture === "function") await player.exitPictureInPicture();
            else if (document.exitPictureInPicture) await document.exitPictureInPicture();
          } else {
            if (typeof player.enterPictureInPicture === "function") await player.enterPictureInPicture();
            else {
              const v = SubtitleManager.getVideo();
              if (v?.requestPictureInPicture) await v.requestPictureInPicture();
            }
          }
        } catch {}
      },

      async toggleFullscreen() {
        try {
          const isFs = this.getStateSafe("fullscreen", !!document.fullscreenElement);
          const canFs = this.getStateSafe("canFullscreen", true);
          if (!canFs) return;

          if (isFs) {
            if (typeof player.exitFullscreen === "function") await player.exitFullscreen();
            else if (document.exitFullscreen) await document.exitFullscreen();
          } else {
            if (typeof player.enterFullscreen === "function") await player.enterFullscreen();
            else if (typeof player.requestFullscreen === "function") await player.requestFullscreen();
          }
        } catch {}
      }
    };

    // ===== Event Handlers =====
    function hookBtn(el, fn) {
      if (!el) return;
      let lastTap = 0;
      const handler = (e) => {
        const now = Date.now();
        if (now - lastTap < 300) return; // 중복 방지
        lastTap = now;
        e.preventDefault();
        e.stopPropagation();
        blurActive();
        fn(e);
      };
      el.addEventListener("click", handler, { passive: false });
      el.addEventListener("touchend", handler, { passive: false });
    }

    function initEventListeners() {
      hookBtn(elements.playBtn, async () => {
        UIManager.closeAllPanels();
        await PlayerControls.togglePlay();
        UIManager.showBars(3000);
      });

      hookBtn(elements.bigPlay, async () => {
        UIManager.closeAllPanels();
        await PlayerControls.togglePlay();
        UIManager.showBars(3000);
      });

      hookBtn(elements.centerBack, () => {
        PlayerControls.seekRel(-10);
        UIManager.showBars(3000);
      });

      hookBtn(elements.centerFwd, () => {
        PlayerControls.seekRel(10);
        UIManager.showBars(3000);
      });

      // 가운데 버튼 터치 시 tapLayer로 전파 방지
      [elements.bigPlay, elements.centerBack, elements.centerFwd].forEach(btn => {
        if (!btn) return;
        btn.addEventListener("touchstart", (e) => {
          e.stopPropagation();
        }, { passive: true });
      });

      hookBtn(elements.backBtn, () => {
        PlayerControls.seekRel(-10);
        UIManager.showBars(3000);
      });

      hookBtn(elements.fwdBtn, () => {
        PlayerControls.seekRel(10);
        UIManager.showBars(3000);
      });

      elements.seek.addEventListener("mousedown", () => {
        UIManager.isSeeking = true;
        UIManager.showBars(3000);
      }, { passive: true });

      elements.seek.addEventListener("mouseup", () => {
        UIManager.isSeeking = false;
        UIManager.showBars(3000);
      }, { passive: true });

      elements.seek.addEventListener("touchstart", () => {
        UIManager.isSeeking = true;
        UIManager.showBars(3000);
      }, { passive: true });

      elements.seek.addEventListener("touchend", () => {
        UIManager.isSeeking = false;
        UIManager.showBars(3000);
      }, { passive: true });

      elements.seek.addEventListener("input", (e) => {
        e.stopPropagation();
        const dur = Number(player.duration || 0);
        if (!dur || !isFinite(dur)) return;
        const v = Number(elements.seek.value || 0) / 1000;
        player.currentTime = dur * v;
        elements.seek.style.setProperty("--seek-percent", `${v * 100}%`);
        UIManager.showBars(3000);
      });

      hookBtn(elements.pipBtn, async () => {
        UIManager.closeAllPanels();
        await PlayerControls.togglePip();
        UIManager.showBars(3000);
      });

      hookBtn(elements.fsBtn, async () => {
        UIManager.closeAllPanels();
        await PlayerControls.toggleFullscreen();
        UIManager.showBars(3000);
      });

      hookBtn(elements.settingsBtn, () => {
        elements.settingsPanel.classList.toggle("hidden");
        if (!elements.settingsPanel.classList.contains("hidden")) {
          UIManager.openSettingsMain();
          UIManager.applyBars();
          UIManager.showBars(999999);
        } else {
          UIManager.applyBars();
          if (!UIManager.isPaused()) UIManager.showBars(3000);
        }
      });

      hookBtn(elements.speedRow, () => UIManager.openSpeedMenu());
      hookBtn(elements.speedBack, () => UIManager.openSettingsMain());

      hookBtn(elements.capRow, () => UIManager.openCapMenu());
      hookBtn(elements.capBack, () => UIManager.openSettingsMain());
      hookBtn(elements.ccBtn, () => SubtitleManager.toggle());

      hookBtn(elements.volBtn, () => {
        UIManager.toggleMute();
      });

      elements.volSlider?.addEventListener("input", (e) => {
        e.preventDefault();
        e.stopPropagation();
        UIManager.setVolume(Number(elements.volSlider.value || 0));
      }, { passive: false });

      // player 영역 클릭/터치 시 재생/일시정지 (컨트롤 영역 제외)
      let lastPlayerTap = 0;
      const handlePlayerTap = async (e) => {
        const now = Date.now();
        if (now - lastPlayerTap < 300) return;
        
        const path = e.composedPath ? e.composedPath() : [];
        
        for (const el of path) {
          if (!el || !el.tagName) continue;
          const tag = el.tagName.toLowerCase();
          
          if (tag === 'button' || tag === 'input' || tag === 'media-google-cast-button') {
            return;
          }
          
          if (el.id === 'bottomBar' || el.id === 'topBar' || el.id === 'settingsPanel') {
            return;
          }
          
          if (el.classList && (el.classList.contains('center-btn') || el.classList.contains('ctrl-btn'))) {
            return;
          }
        }
        
        lastPlayerTap = now;
        e.preventDefault();
        blurActive();
        UIManager.closeAllPanels();
        await PlayerControls.togglePlay();
        UIManager.showBars(3000);
      };
      
      player.addEventListener("click", handlePlayerTap, { passive: false });
      player.addEventListener("touchend", handlePlayerTap, { passive: false });
      
      // iOS 감지 - Google Cast 미지원, AirPlay 사용
      const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) || 
                    (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
      const castBtn = $('castBtn');
      const airplayBtn = $('airplayBtn');
      
      if (isIOS) {
        // iOS: Chromecast 숨기고 AirPlay 표시
        if (castBtn) castBtn.style.display = 'none';
        if (airplayBtn) airplayBtn.classList.remove('hidden');
        
        // AirPlay 버튼 클릭 이벤트
        hookBtn(airplayBtn, () => {
          const video = SubtitleManager.getVideo();
          if (video && video.webkitShowPlaybackTargetPicker) {
            video.webkitShowPlaybackTargetPicker();
          }
          UIManager.showBars(3000);
        });
        
        // AirPlay 상태 감지
        const setupAirPlayEvents = () => {
          const video = SubtitleManager.getVideo();
          if (!video) return;
          
          // AirPlay 가용성 체크
          video.addEventListener('webkitplaybacktargetavailabilitychanged', (e) => {
            if (e.availability === 'available') {
              airplayBtn?.classList.remove('hidden');
            } else {
              airplayBtn?.classList.add('hidden');
            }
          });
          
          // AirPlay 연결 상태 변경
          video.addEventListener('webkitcurrentplaybacktargetiswirelesschanged', () => {
            if (video.webkitCurrentPlaybackTargetIsWireless) {
              airplayBtn?.classList.add('cc-active');
            } else {
              airplayBtn?.classList.remove('cc-active');
            }
          });
        };
        
        // 비디오 요소가 준비되면 이벤트 설정
        player.addEventListener('loadedmetadata', setupAirPlayEvents);
        setTimeout(setupAirPlayEvents, 1000);
      } else {
        // Android/Desktop: AirPlay 숨기고 Chromecast 표시
        if (airplayBtn) airplayBtn.classList.add('hidden');
      }

      document.addEventListener("click", (e) => {
        const path = e.composedPath?.() || [];

        if (UIManager.isSettingsOpen()) {
          if (!path.includes(elements.settingsPanel) && !path.includes(elements.settingsBtn)) {
            UIManager.closeSettings();
            UIManager.applyBars();
            if (!UIManager.isPaused()) UIManager.showBars(3000);
          }
        }
      }, true);

      ["mousemove", "touchstart"].forEach(evt => {
        player.addEventListener(evt, () => {
          if (!UIManager.isPaused() && !UIManager.isSettingsOpen()) {
            UIManager.showBars(3000);
          }
        }, { passive: true });
      });
    }

    // ===== Keyboard Shortcuts =====
    function initKeyboard() {
      const KEY_SEEK = 10;
      const KEY_VOL = 0.05;

      function isTyping() {
        const el = document.activeElement;
        if (!el) return false;
        const tag = (el.tagName || "").toLowerCase();
        if (tag === "input" || tag === "textarea" || tag === "select") return true;
        return el.isContentEditable;
      }

      document.addEventListener("keydown", async (e) => {
        if (e.altKey || e.ctrlKey || e.metaKey || e.isComposing || isTyping()) return;

        const k = e.key;

        if (k === "<" || k === ",") {
          e.preventDefault();
          UIManager.stepSpeed(-1);
          return;
        }
        if (k === ">" || k === ".") {
          e.preventDefault();
          UIManager.stepSpeed(1);
          return;
        }

        if (/^[0-9]$/.test(k)) {
          e.preventDefault();
          const d = Number(k);
          const dur = Number(player.duration || 0);
          if (isFinite(dur) && dur > 0) {
            player.currentTime = clamp(dur * (d / 10), 0, dur - 1);
            UIManager.showBars(3000);
          }
          return;
        }

        if (k === " " || k === "Spacebar") {
          e.preventDefault();
          await PlayerControls.togglePlay();
          UIManager.showBars(3000);
          return;
        }

        if (k === "f" || k === "F") {
          e.preventDefault();
          await PlayerControls.toggleFullscreen();
          UIManager.showBars(3000);
          return;
        }

        if (k === "ArrowLeft") {
          e.preventDefault();
          PlayerControls.seekRel(-KEY_SEEK);
          UIManager.showBars(3000);
          return;
        }
        if (k === "ArrowRight") {
          e.preventDefault();
          PlayerControls.seekRel(KEY_SEEK);
          UIManager.showBars(3000);
          return;
        }
        if (k === "ArrowUp") {
          e.preventDefault();
          UIManager.setVolume(clamp01(player.volume || 0) + KEY_VOL);
          return;
        }
        if (k === "ArrowDown") {
          e.preventDefault();
          UIManager.setVolume(clamp01(player.volume || 0) - KEY_VOL);
          return;
        }
      }, { passive: false });
    }

    // ===== Player Events =====
    function initPlayerEvents() {
      player.addEventListener("loadedmetadata", () => ResumeManager.restore());
      player.addEventListener("playing", () => { if (!ResumeManager.restored) ResumeManager.restore(); });
      player.addEventListener("time-update", () => ResumeManager.save(false));
      player.addEventListener("pause", () => ResumeManager.save(true));
      player.addEventListener("seeking", () => ResumeManager.save(true));
      player.addEventListener("ended", () => ResumeManager.clear());

      player.addEventListener("play", () => {
        UIManager.closeSettings();
        UIManager.renderPlayIcon();
        UIManager.applyBars();
        UIManager.hideBuffering();
        SubtitleManager.scheduleInit();
        UIManager.showBars(3000);
      });

      player.addEventListener("playing", () => {
        UIManager.renderPlayIcon();
        UIManager.applyBars();
        UIManager.hideBuffering();
        SubtitleManager.scheduleInit();
      });

      player.addEventListener("pause", () => {
        UIManager.renderPlayIcon();
        UIManager.barsVisible = true;
        if (UIManager.barsTimer) { clearTimeout(UIManager.barsTimer); UIManager.barsTimer = null; }
        UIManager.setBarsHidden(false);
        SubtitleManager.scheduleInit();
      });

      player.addEventListener("time-update", () => UIManager.updateTime());
      player.addEventListener("duration-change", () => UIManager.updateTime());
      
      player.addEventListener("waiting", () => UIManager.showBuffering());
      player.addEventListener("playing", () => UIManager.hideBuffering());
      player.addEventListener("canplay", () => UIManager.hideBuffering());
      player.addEventListener("canplaythrough", () => UIManager.hideBuffering());

      player.addEventListener("volume-change", () => UIManager.syncVolUI());
    }

    // ===== Provider Setup =====
    player.addEventListener("provider-change", (event) => {
      const provider = event.detail;
      if (provider?.type === "hls") {
        provider.library = HlsWithP2P;
        provider.config = {
          enableWorker: true,
          lowLatencyMode: false,
          backBufferLength: 60,
          maxBufferLength: 180,
          maxMaxBufferLength: 300,
          fragLoadingTimeOut: 60000,
          fragLoadingMaxRetry: 10,
          fragLoadingRetryDelay: 500,
          manifestLoadingTimeOut: 10000,
          manifestLoadingMaxRetry: 4,
          levelLoadingTimeOut: 15000,
          levelLoadingMaxRetry: 4,

          p2p: {
            core: {
              swarmId: SWARM_ID,
              announceTrackers: [
                "wss://tracker.openwebtorrent.com",
                "wss://tracker.linkwang.org"
              ]
            },
            rtcConfig: {
              iceServers: [
                { urls: "stun:stun.l.google.com:19302" },
                { urls: "stun:stun1.l.google.com:19302" },
                { urls: "stun:global.stun.twilio.com:3478" }
              ]
            },
            cachedSegmentsCount: 2000,
            cachedSegmentExpiration: 216000000,
            requiredSegmentsPriority: 4,
            p2pDownloadMaxPriority: 150,
            httpDownloadMaxPriority: 1500,
            simultaneousHttpDownloads: 3,
            simultaneousP2PDownloads: 6,
            httpDownloadProbabilitySkipIfNoPeers: true,

            onHlsJsCreated: (hls) => {
              Stats.reset();

              try {
                const eng = hls?.p2pEngine;
                if (eng?.addEventListener) {
                  eng.addEventListener("onPeerConnect", () => { Stats.peers = Math.max(Stats.peers, 0) + 1; });
                  eng.addEventListener("onPeerClose", () => { Stats.peers = Math.max(Stats.peers - 1, 0); });
                  eng.addEventListener("onChunkDownloaded", (bytesLength, downloadSource) => {
                    const src = String(downloadSource || "").toLowerCase();
                    const b = Number(bytesLength || 0);
                    if (!isFinite(b) || b <= 0) return;
                    if (src === "p2p") Stats.p2p += b;
                    else Stats.http += b;
                  });
                  eng.addEventListener("onChunkUploaded", (bytesLength) => {
                    const b = Number(bytesLength || 0);
                    if (isFinite(b) && b > 0) Stats.up += b;
                  });
                }
              } catch {}

              Stats.start();
              SubtitleManager.scheduleInit();
            }
          }
        };
      }
      SubtitleManager.scheduleInit();
    });

    player.addEventListener("loadedmetadata", () => SubtitleManager.scheduleInit());
    player.addEventListener("playing", () => SubtitleManager.scheduleInit());

    // ===== Initialize =====
    function init() {
      UIManager.setBarsHidden(false);
      UIManager.barsVisible = true;

      try { player.volume = 1; player.muted = false; } catch {}
      UIManager.lastNonZeroVol = 1;
      UIManager.playbackRate = 1;

      try { player.playbackRate = 1; } catch {}
      try {
        const v = SubtitleManager.getVideo();
        if (v) v.playbackRate = 1;
      } catch {}

      UIManager.renderPlayIcon();
      UIManager.updateTime();
      UIManager.buildSpeedButtons();
      UIManager.updateSpeed();
      UIManager.buildCapButtons();
      UIManager.updateCaptions();

      if (!SUB_URL && elements.ccBtn) elements.ccBtn.classList.add("hidden");
      SubtitleManager.applyMode();
      UIManager.syncVolUI();

      SubtitleManager.scheduleInit();
      Stats.start();

      initEventListeners();
      initKeyboard();
      initPlayerEvents();
    }

    player.src = source;
    try { player.setAttribute("src", PLAY_URL); } catch {}

    window.addEventListener("beforeunload", () => {
      ResumeManager.save(true);
      Stats.stop();
    });

    init();
  </script>
</body>
</html>