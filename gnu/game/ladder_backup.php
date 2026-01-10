<?php
/**
 * 스피드 사다리 게임 - 프리미엄 버전
 */
include_once('./_common.php');

if (!$is_member) {
    alert('로그인이 필요합니다.', G5_BBS_URL.'/login.php');
}

$g5['title'] = '스피드 사다리';
include_once(G5_PATH.'/head.php');

$member_point = $member['mb_point'];

// 회차 설정 (30초)
$round_interval = 30;
$current_time = time();
$today_start = strtotime(date('Y-m-d'));
$seconds_today = $current_time - $today_start;
$today_round = floor($seconds_today / $round_interval) + 1;
$current_round = floor($current_time / $round_interval);
$round_end = ($current_round + 1) * $round_interval;
$remaining = $round_end - $current_time;
$betting_close = 8;

// 결과 생성
function get_ladder_result($round) {
    $secret = 'speed_ladder_secret_2024';
    $hash = hash('sha256', $round . $secret);

    $start = hexdec(substr($hash, 0, 8)) % 2;
    $odd_even = hexdec(substr($hash, 8, 8)) % 2;
    $lines = (hexdec(substr($hash, 16, 8)) % 2 == 0) ? 3 : 4;

    return [
        'start' => $start,
        'odd_even' => $odd_even,
        'lines' => $lines,
    ];
}

function get_recent_results($current_round, $count = 10) {
    $results = [];
    for ($i = 1; $i <= $count; $i++) {
        $r = get_ladder_result($current_round - $i);
        $results[] = $r;
    }
    return $results;
}

$result = get_ladder_result($current_round);
$recent_results = get_recent_results($current_round, 10);
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700;900&display=swap');

* { box-sizing: border-box; }

.ladder-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px;
    background: linear-gradient(180deg, #f5f0e6 0%, #ebe5d8 100%);
    min-height: 100vh;
    font-family: 'Noto Sans KR', sans-serif;
}

/* 메인 레이아웃 */
.ladder-main {
    display: grid;
    grid-template-columns: 480px 300px;
    gap: 20px;
    justify-content: center;
}

/* 패널 스타일 */
.panel-frame {
    position: relative;
    background: linear-gradient(145deg, #faf7f0 0%, #f0ebe0 100%);
    border: 4px solid #8b7355;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12);
    overflow: hidden;
}

/* 모서리 장식 */
.panel-frame::before,
.panel-frame::after {
    content: '';
    position: absolute;
    width: 28px;
    height: 28px;
    background: #8b7355;
    z-index: 5;
}
.panel-frame::before {
    top: -4px; left: -4px;
    clip-path: polygon(0 0, 100% 0, 0 100%);
}
.panel-frame::after {
    top: -4px; right: -4px;
    clip-path: polygon(0 0, 100% 0, 100% 100%);
}
.corner-bl, .corner-br {
    position: absolute;
    width: 28px;
    height: 28px;
    background: #8b7355;
    z-index: 5;
}
.corner-bl {
    bottom: -4px; left: -4px;
    clip-path: polygon(0 0, 0 100%, 100% 100%);
}
.corner-br {
    bottom: -4px; right: -4px;
    clip-path: polygon(100% 0, 0 100%, 100% 100%);
}

/* 게임 패널 */
.game-panel {
    padding: 20px 25px 25px;
}

/* 헤더 */
.game-header {
    text-align: center;
    margin-bottom: 15px;
}
.game-header h2 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #4a4a4a;
}
.game-header .current-time {
    font-size: 18px;
    font-weight: 800;
    color: #2d2d2d;
    margin-top: 4px;
}

/* 프리미엄 사다리 영역 */
.ladder-game {
    position: relative;
    max-width: 400px;
    margin: 0 auto;
    padding: 15px 0;
}

/* 시작점 영역 */
.start-points {
    display: flex;
    justify-content: space-between;
    padding: 0 50px;
    margin-bottom: 15px;
}

.start-point {
    width: 56px;
    height: 56px;
    background: linear-gradient(180deg, #e8e4dc 0%, #d4d0c8 100%);
    border: 3px solid #b8b4ac;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 900;
    color: #888;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow:
        0 4px 12px rgba(0,0,0,0.1),
        inset 0 2px 4px rgba(255,255,255,0.8);
}

.start-point.left-active {
    background: linear-gradient(180deg, #60a5fa 0%, #3b82f6 100%);
    border-color: #2563eb;
    color: #fff;
    box-shadow:
        0 0 30px rgba(59, 130, 246, 0.5),
        0 8px 20px rgba(59, 130, 246, 0.3);
    transform: scale(1.1);
}

.start-point.right-active {
    background: linear-gradient(180deg, #f87171 0%, #ef4444 100%);
    border-color: #dc2626;
    color: #fff;
    box-shadow:
        0 0 30px rgba(239, 68, 68, 0.5),
        0 8px 20px rgba(239, 68, 68, 0.3);
    transform: scale(1.1);
}

/* 사다리 캔버스 영역 */
.ladder-canvas-wrap {
    position: relative;
    height: 200px;
    margin: 0 65px;
    background: linear-gradient(180deg, rgba(139,115,85,0.03) 0%, rgba(139,115,85,0.08) 100%);
    border-radius: 8px;
}

#ladderCanvas {
    width: 100%;
    height: 100%;
    display: block;
}

/* 사다리 타는 공 */
.ladder-ball {
    position: absolute;
    width: 32px;
    height: 32px;
    background: radial-gradient(circle at 30% 30%, #fff9c4, #ffd54f, #ff8f00);
    border-radius: 50%;
    box-shadow:
        0 0 20px rgba(255, 143, 0, 0.6),
        0 4px 15px rgba(0,0,0,0.3),
        inset 0 -3px 6px rgba(0,0,0,0.2),
        inset 0 3px 6px rgba(255,255,255,0.6);
    transform: translate(-50%, -50%);
    z-index: 20;
    opacity: 0;
    transition: opacity 0.3s;
}

.ladder-ball.visible {
    opacity: 1;
}

/* 도착점 영역 */
.end-points {
    display: flex;
    justify-content: space-between;
    padding: 0 50px;
    margin-top: 15px;
}

.end-point {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}

.end-marker {
    width: 56px;
    height: 56px;
    background: linear-gradient(180deg, #e8e4dc 0%, #d4d0c8 100%);
    border: 3px solid #b8b4ac;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 900;
    color: #888;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow:
        0 4px 12px rgba(0,0,0,0.1),
        inset 0 2px 4px rgba(255,255,255,0.8);
}

.end-marker.odd-active {
    background: linear-gradient(180deg, #60a5fa 0%, #3b82f6 100%);
    border-color: #2563eb;
    color: #fff;
    box-shadow:
        0 0 30px rgba(59, 130, 246, 0.5),
        0 8px 20px rgba(59, 130, 246, 0.3);
    transform: scale(1.1);
}

.end-marker.even-active {
    background: linear-gradient(180deg, #f87171 0%, #ef4444 100%);
    border-color: #dc2626;
    color: #fff;
    box-shadow:
        0 0 30px rgba(239, 68, 68, 0.5),
        0 8px 20px rgba(239, 68, 68, 0.3);
    transform: scale(1.1);
}

.end-label {
    font-size: 12px;
    font-weight: 700;
    color: #888;
}

/* 카운트다운 */
.countdown-area {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

.countdown-box {
    background: linear-gradient(180deg, #5d4e3d 0%, #4a3f32 100%);
    border-radius: 25px;
    padding: 12px 35px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    box-shadow:
        0 6px 20px rgba(0,0,0,0.2),
        inset 0 1px 0 rgba(255,255,255,0.1);
}

.countdown-time {
    color: #e8c96d;
    font-size: 22px;
    font-weight: 900;
    font-family: 'Courier New', monospace;
    text-shadow: 0 2px 6px rgba(0,0,0,0.4);
    min-width: 60px;
    text-align: center;
}

.countdown-box.urgent {
    background: linear-gradient(180deg, #c0392b 0%, #96281b 100%);
    animation: urgentPulse 0.6s ease-in-out infinite alternate;
}

@keyframes urgentPulse {
    from { transform: scale(1); }
    to { transform: scale(1.02); }
}

/* 결과 모달 - 사다리 영역 위에만 표시 */
.result-modal {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.75);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
    border-radius: 8px;
}

.result-modal.show {
    opacity: 1;
    visibility: visible;
}

.result-modal-content {
    background: linear-gradient(145deg, #faf7f0 0%, #f0ebe0 100%);
    border: 3px solid #8b7355;
    border-radius: 16px;
    padding: 20px 30px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(0,0,0,0.4);
    transform: scale(0.8);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
}

.result-modal.show .result-modal-content {
    transform: scale(1);
}

.result-modal-title {
    font-size: 18px;
    font-weight: 900;
    color: #333;
    margin-bottom: 15px;
    padding-bottom: 12px;
    border-bottom: 2px solid #d4c8b8;
}

.result-modal-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 5px;
    border-bottom: 1px dashed #e0d8ca;
    gap: 25px;
}

.result-modal-row:last-child {
    border-bottom: none;
}

.result-modal-label {
    font-size: 18px;
    font-weight: 700;
    color: #555;
}

.result-modal-value {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 900;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}

.result-modal-value.odd {
    background: linear-gradient(180deg, #60a5fa 0%, #2563eb 100%);
}
.result-modal-value.even {
    background: linear-gradient(180deg, #f87171 0%, #dc2626 100%);
}
.result-modal-value.line {
    background: linear-gradient(180deg, #374151 0%, #1f2937 100%);
    font-size: 18px;
}

/* 결과 패널 */
.result-panel-inner {
    padding: 0;
}

.result-header {
    padding: 28px 20px;
    text-align: center;
    background: linear-gradient(180deg, #f8f4eb 0%, #f0ebe0 100%);
}

.result-header h3 {
    margin: 0;
    font-size: 28px;
    font-weight: 900;
    color: #333;
}

.result-table-head {
    background: linear-gradient(180deg, #7a5d45 0%, #6b5040 100%);
    display: grid;
    grid-template-columns: 1fr 1fr;
}

.result-table-head span {
    padding: 14px;
    text-align: center;
    color: #fff;
    font-weight: 700;
    font-size: 16px;
}

.result-list {
    max-height: 500px;
    overflow-y: auto;
    background: #f8f4eb;
}

.result-item {
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    padding: 14px 20px;
    border-bottom: 1px solid #e5dfd2;
    transition: background 0.2s;
}

.result-item:hover {
    background: #f0ebe0;
}

.result-round {
    font-size: 14px;
    font-weight: 700;
    color: #666;
}

.result-value {
    display: flex;
    justify-content: center;
}

.result-badge {
    position: relative;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    font-weight: 900;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.result-badge.odd {
    background: linear-gradient(180deg, #60a5fa 0%, #2563eb 100%);
}

.result-badge.even {
    background: linear-gradient(180deg, #f87171 0%, #dc2626 100%);
}

.result-badge .line-num {
    position: absolute;
    top: -5px;
    left: -5px;
    width: 22px;
    height: 22px;
    background: #1f2937;
    border-radius: 50%;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #f8f4eb;
}

.result-waiting {
    color: #a09585;
    font-size: 15px;
    font-weight: 700;
}

/* 베팅 섹션 */
.betting-area {
    margin-top: 30px;
    background: #fff;
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}

.betting-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.betting-title {
    font-size: 22px;
    font-weight: 900;
    color: #333;
}

.my-points {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    padding: 12px 24px;
    border-radius: 12px;
    color: #fff;
    font-weight: 800;
    font-size: 16px;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
}

.bet-options {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

.bet-group {
    background: #f9f9f9;
    border-radius: 16px;
    padding: 20px;
}

.bet-group-title {
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    color: #888;
    margin-bottom: 14px;
}

.bet-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.bet-btn {
    padding: 16px 10px;
    border: 3px solid #e8e8e8;
    border-radius: 12px;
    background: #fff;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}

.bet-btn:hover {
    border-color: #fbbf24;
    transform: translateY(-2px);
}

.bet-btn.selected {
    border-color: #10b981;
    background: linear-gradient(180deg, rgba(16,185,129,0.1) 0%, rgba(16,185,129,0.05) 100%);
    box-shadow: 0 0 0 4px rgba(16,185,129,0.15);
}

.bet-btn-name {
    font-size: 18px;
    font-weight: 900;
    margin-bottom: 6px;
}

.bet-btn-name.blue { color: #2563eb; }
.bet-btn-name.red { color: #dc2626; }
.bet-btn-name.teal { color: #0d9488; }
.bet-btn-name.pink { color: #db2777; }

.bet-btn-odds {
    font-size: 13px;
    color: #f59e0b;
    font-weight: 700;
}

.bet-submit-row {
    display: flex;
    gap: 14px;
    align-items: center;
}

.bet-amount {
    width: 160px;
    padding: 14px 18px;
    border: 3px solid #e8e8e8;
    border-radius: 12px;
    font-size: 18px;
    font-weight: 700;
    text-align: right;
}

.bet-amount:focus {
    outline: none;
    border-color: #fbbf24;
}

.quick-amounts {
    display: flex;
    gap: 8px;
}

.quick-btn {
    padding: 12px 16px;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    background: #fff;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}

.quick-btn:hover {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #fff;
    border-color: #fbbf24;
}

.submit-btn {
    margin-left: auto;
    padding: 14px 36px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 18px;
    font-weight: 800;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    transition: all 0.2s;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.submit-btn:disabled {
    background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* 베팅 마감 */
.betting-area.closed {
    position: relative;
    pointer-events: none;
}

.betting-area.closed::after {
    content: '베팅 마감';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.8);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: 900;
    color: #fff;
}

/* 반응형 */
@media (max-width: 960px) {
    .ladder-main {
        grid-template-columns: 1fr;
    }
    .bet-options {
        grid-template-columns: 1fr;
    }
    .bet-submit-row {
        flex-wrap: wrap;
    }
    .submit-btn {
        width: 100%;
        margin-left: 0;
        margin-top: 14px;
    }
}

/* 다크모드 */
[data-theme="dark"] .ladder-page {
    background: linear-gradient(180deg, #1a1a1a 0%, #121212 100%);
}
[data-theme="dark"] .panel-frame {
    background: linear-gradient(145deg, #2a2a2a 0%, #222 100%);
    border-color: #444;
}
[data-theme="dark"] .panel-frame::before,
[data-theme="dark"] .panel-frame::after,
[data-theme="dark"] .corner-bl,
[data-theme="dark"] .corner-br {
    background: #444;
}
[data-theme="dark"] .game-header h2,
[data-theme="dark"] .game-header .current-time,
[data-theme="dark"] .result-header h3 {
    color: #e0e0e0;
}
[data-theme="dark"] .ladder-canvas-wrap {
    background: rgba(255,255,255,0.03);
}
[data-theme="dark"] .start-point,
[data-theme="dark"] .end-marker {
    background: linear-gradient(180deg, #3a3a3a 0%, #2a2a2a 100%);
    border-color: #555;
}
[data-theme="dark"] .end-label {
    color: #aaa;
}
[data-theme="dark"] .betting-area {
    background: #2a2a2a;
}
[data-theme="dark"] .betting-title {
    color: #e0e0e0;
}
[data-theme="dark"] .bet-group {
    background: #1a1a1a;
}
[data-theme="dark"] .bet-btn {
    background: #2a2a2a;
    border-color: #444;
}
[data-theme="dark"] .bet-amount {
    background: #1a1a1a;
    border-color: #444;
    color: #e0e0e0;
}
[data-theme="dark"] .quick-btn {
    background: #1a1a1a;
    border-color: #444;
    color: #e0e0e0;
}
[data-theme="dark"] .result-modal-content {
    background: linear-gradient(145deg, #2a2a2a 0%, #222 100%);
    border-color: #555;
}
[data-theme="dark"] .result-modal-title,
[data-theme="dark"] .result-modal-label {
    color: #e0e0e0;
}
</style>

<div class="ladder-page">
    <div class="ladder-main">
        <!-- 게임 패널 -->
        <div class="panel-frame">
            <div class="corner-bl"></div>
            <div class="corner-br"></div>
            <div class="game-panel">
                <div class="game-header">
                    <h2>스피드 사다리 현재 시간</h2>
                    <div class="current-time" id="currentTime"><?php echo date('Y.m.d - H:i:s'); ?></div>
                </div>

                <div class="ladder-game">
                    <!-- 시작점 -->
                    <div class="start-points">
                        <div class="start-point" id="startLeft">좌</div>
                        <div class="start-point" id="startRight">우</div>
                    </div>

                    <!-- 캔버스 사다리 -->
                    <div class="ladder-canvas-wrap">
                        <canvas id="ladderCanvas"></canvas>
                        <div class="ladder-ball" id="ladderBall"></div>
                    </div>

                    <!-- 도착점 -->
                    <div class="end-points">
                        <div class="end-point">
                            <div class="end-marker" id="endOdd">홀</div>
                            <span class="end-label">ODD</span>
                        </div>
                        <div class="end-point">
                            <div class="end-marker" id="endEven">짝</div>
                            <span class="end-label">EVEN</span>
                        </div>
                    </div>

                    <!-- 결과 모달 (사다리 영역 위) -->
                    <div class="result-modal" id="resultModal">
                        <div class="result-modal-content">
                            <div class="result-modal-title"><span id="modalRound"><?php echo $today_round; ?></span>회차 결과</div>
                            <div class="result-modal-row">
                                <span class="result-modal-label">홀짝</span>
                                <div class="result-modal-value" id="modalOddEven">홀</div>
                            </div>
                            <div class="result-modal-row">
                                <span class="result-modal-label">줄수</span>
                                <div class="result-modal-value line" id="modalLines">3</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 카운트다운 -->
                <div class="countdown-area">
                    <div class="countdown-box" id="countdownBox">
                        <span class="countdown-time" id="countdown">00:00</span>
                        <span>후 <strong id="nextRound"><?php echo $today_round; ?></strong>회차 추첨</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 결과 패널 -->
        <div class="panel-frame">
            <div class="corner-bl"></div>
            <div class="corner-br"></div>
            <div class="result-panel-inner">
                <div class="result-header">
                    <h3>회차별 결과</h3>
                </div>
                <div class="result-table-head">
                    <span>회차</span>
                    <span>결과</span>
                </div>
                <div class="result-list" id="resultList">
                    <div class="result-item" id="currentRoundItem">
                        <div class="result-round"><?php echo date('n월 j일'); ?> - <span id="currentRoundNum"><?php echo $today_round; ?></span></div>
                        <div class="result-value">
                            <span class="result-waiting" id="currentRoundResult">대기 중</span>
                        </div>
                    </div>
                    <?php
                    $dr = $today_round - 1;
                    foreach ($recent_results as $r):
                    ?>
                    <div class="result-item">
                        <div class="result-round"><?php echo date('n월 j일'); ?> - <?php echo $dr; ?></div>
                        <div class="result-value">
                            <span class="result-badge <?php echo $r['odd_even'] == 1 ? 'odd' : 'even'; ?>">
                                <?php echo $r['odd_even'] == 1 ? '홀' : '짝'; ?>
                                <span class="line-num"><?php echo $r['lines']; ?></span>
                            </span>
                        </div>
                    </div>
                    <?php $dr--; endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 베팅 섹션 -->
    <div class="betting-area" id="bettingArea">
        <div class="betting-header">
            <div class="betting-title">🎯 베팅하기</div>
            <div class="my-points">💰 <span id="myPoint"><?php echo number_format($member_point); ?></span>P</div>
        </div>

        <div class="bet-options">
            <div class="bet-group">
                <div class="bet-group-title">출발점</div>
                <div class="bet-buttons">
                    <button class="bet-btn" data-type="start" data-value="0" onclick="selectBet(this)">
                        <div class="bet-btn-name blue">◀ 좌</div>
                        <div class="bet-btn-odds">x1.95</div>
                    </button>
                    <button class="bet-btn" data-type="start" data-value="1" onclick="selectBet(this)">
                        <div class="bet-btn-name red">우 ▶</div>
                        <div class="bet-btn-odds">x1.95</div>
                    </button>
                </div>
            </div>
            <div class="bet-group">
                <div class="bet-group-title">홀/짝</div>
                <div class="bet-buttons">
                    <button class="bet-btn" data-type="oe" data-value="1" onclick="selectBet(this)">
                        <div class="bet-btn-name blue">홀</div>
                        <div class="bet-btn-odds">x1.95</div>
                    </button>
                    <button class="bet-btn" data-type="oe" data-value="0" onclick="selectBet(this)">
                        <div class="bet-btn-name red">짝</div>
                        <div class="bet-btn-odds">x1.95</div>
                    </button>
                </div>
            </div>
            <div class="bet-group">
                <div class="bet-group-title">줄 수</div>
                <div class="bet-buttons">
                    <button class="bet-btn" data-type="line" data-value="3" onclick="selectBet(this)">
                        <div class="bet-btn-name teal">3줄</div>
                        <div class="bet-btn-odds">x1.95</div>
                    </button>
                    <button class="bet-btn" data-type="line" data-value="4" onclick="selectBet(this)">
                        <div class="bet-btn-name pink">4줄</div>
                        <div class="bet-btn-odds">x1.95</div>
                    </button>
                </div>
            </div>
        </div>

        <div class="bet-submit-row">
            <input type="number" class="bet-amount" id="betAmount" value="100" min="10" max="5000">
            <div class="quick-amounts">
                <button class="quick-btn" onclick="setAmount(100)">100</button>
                <button class="quick-btn" onclick="setAmount(500)">500</button>
                <button class="quick-btn" onclick="setAmount(1000)">1K</button>
                <button class="quick-btn" onclick="setAmount('max')">MAX</button>
            </div>
            <button class="submit-btn" id="submitBtn" onclick="placeBet()">베팅하기</button>
        </div>
    </div>
</div>

<script>
const ROUND_INTERVAL = <?php echo $round_interval; ?>;
const BETTING_CLOSE = <?php echo $betting_close; ?>;
let currentRound = <?php echo $current_round; ?>;
let todayRound = <?php echo $today_round; ?>;
let RESULT = {
    start: <?php echo $result['start']; ?>,
    odd_even: <?php echo $result['odd_even']; ?>,
    lines: <?php echo $result['lines']; ?>
};

let currentPoint = <?php echo $member_point; ?>;
let isBettingClosed = <?php echo ($remaining <= $betting_close) ? 'true' : 'false'; ?>;
let isAnimating = false;
let animationComplete = false;  // 이번 라운드 애니메이션 완료 여부
let animationStarted = false;   // 이번 라운드 애니메이션 시작 여부
let selectedBets = { start: null, oe: null, line: null };
let lastRound = currentRound;

// 캔버스 설정
const canvas = document.getElementById('ladderCanvas');
const ctx = canvas.getContext('2d');
let ladderPath = [];
let rungPositions = [];

function initCanvas() {
    const wrap = canvas.parentElement;
    const dpr = window.devicePixelRatio || 1;
    canvas.width = wrap.offsetWidth * dpr;
    canvas.height = wrap.offsetHeight * dpr;
    canvas.style.width = wrap.offsetWidth + 'px';
    canvas.style.height = wrap.offsetHeight + 'px';
    ctx.scale(dpr, dpr);
    drawLadder();
}

function drawLadder() {
    const w = canvas.offsetWidth;
    const h = canvas.offsetHeight;
    const padding = 30;
    const leftX = padding;
    const rightX = w - padding;
    const lines = RESULT.lines;

    ctx.clearRect(0, 0, w, h);

    // 세로선 그라데이션
    const gradient = ctx.createLinearGradient(0, 0, 0, h);
    gradient.addColorStop(0, '#c9c5bc');
    gradient.addColorStop(0.5, '#a8a49c');
    gradient.addColorStop(1, '#c9c5bc');

    ctx.strokeStyle = gradient;
    ctx.lineWidth = 8;
    ctx.lineCap = 'round';

    // 왼쪽 세로선
    ctx.beginPath();
    ctx.moveTo(leftX, 0);
    ctx.lineTo(leftX, h);
    ctx.stroke();

    // 오른쪽 세로선
    ctx.beginPath();
    ctx.moveTo(rightX, 0);
    ctx.lineTo(rightX, h);
    ctx.stroke();

    // 가로선 (발판)
    rungPositions = [];
    const spacing = h / (lines + 1);

    ctx.lineWidth = 6;

    for (let i = 0; i < lines; i++) {
        const y = spacing * (i + 1);
        rungPositions.push(y);

        ctx.beginPath();
        ctx.moveTo(leftX, y);
        ctx.lineTo(rightX, y);
        ctx.stroke();
    }

    // 경로 계산
    calculatePath(leftX, rightX, h);
}

function calculatePath(leftX, rightX, height) {
    ladderPath = [];

    let currentX = RESULT.start === 0 ? leftX : rightX;
    ladderPath.push({ x: currentX, y: 0 });

    // 목표 도착점 (홀=왼쪽, 짝=오른쪽)
    const targetX = RESULT.odd_even === 1 ? leftX : rightX;

    // 총 이동 횟수 결정 (시작점에서 도착점까지)
    // 시작과 도착이 같으면 짝수번, 다르면 홀수번 이동 필요
    const needOddMoves = (currentX !== targetX);

    // 무조건 매 가로줄마다 좌우로 이동 (왔다갔다)
    // 단, 마지막에 올바른 결과에 도착하도록 조정
    let totalMoves = rungPositions.length;

    // 이동 횟수가 홀수/짝수인지 확인하고, 목표와 맞지 않으면 조정
    if ((totalMoves % 2 === 1) !== needOddMoves) {
        // 마지막 한 번은 이동하지 않음
        totalMoves--;
    }

    for (let i = 0; i < rungPositions.length; i++) {
        const y = rungPositions[i];
        ladderPath.push({ x: currentX, y: y });

        // 이동해야 하는 횟수 내에서만 좌우 이동
        if (i < totalMoves) {
            currentX = currentX === leftX ? rightX : leftX;
            ladderPath.push({ x: currentX, y: y });
        }
    }

    ladderPath.push({ x: currentX, y: height });
}

function animateLadder() {
    if (isAnimating || animationStarted) return;
    isAnimating = true;
    animationStarted = true;

    const ball = document.getElementById('ladderBall');
    const wrap = canvas.parentElement;

    ball.classList.add('visible');

    // 시작점 활성화
    if (RESULT.start === 0) {
        document.getElementById('startLeft').classList.add('left-active');
    } else {
        document.getElementById('startRight').classList.add('right-active');
    }

    let step = 0;
    const stepDuration = 300;

    function animate() {
        if (step >= ladderPath.length) {
            showFinalResult();
            return;
        }

        const point = ladderPath[step];
        const xPercent = (point.x / wrap.offsetWidth) * 100;
        const yPercent = (point.y / wrap.offsetHeight) * 100;

        ball.style.left = xPercent + '%';
        ball.style.top = yPercent + '%';
        ball.style.transition = `all ${stepDuration}ms ease-in-out`;

        step++;
        setTimeout(animate, stepDuration);
    }

    // 시작 위치
    const startPoint = ladderPath[0];
    ball.style.left = (startPoint.x / wrap.offsetWidth * 100) + '%';
    ball.style.top = '0%';
    ball.style.transition = 'none';

    setTimeout(animate, 200);
}

function showFinalResult() {
    if (RESULT.odd_even === 1) {
        document.getElementById('endOdd').classList.add('odd-active');
    } else {
        document.getElementById('endEven').classList.add('even-active');
    }

    setTimeout(() => {
        const modal = document.getElementById('resultModal');
        const modalOddEven = document.getElementById('modalOddEven');
        const modalLines = document.getElementById('modalLines');

        document.getElementById('modalRound').textContent = todayRound;

        const isOdd = RESULT.odd_even === 1;
        if (isOdd) {
            modalOddEven.textContent = '홀';
            modalOddEven.className = 'result-modal-value odd';
        } else {
            modalOddEven.textContent = '짝';
            modalOddEven.className = 'result-modal-value even';
        }

        modalLines.textContent = RESULT.lines;
        modal.classList.add('show');

        // 오른쪽 결과 패널 업데이트
        const resultEl = document.getElementById('currentRoundResult');
        resultEl.className = 'result-badge ' + (isOdd ? 'odd' : 'even');
        resultEl.innerHTML = (isOdd ? '홀' : '짝') + '<span class="line-num">' + RESULT.lines + '</span>';

        // 애니메이션 완료 표시
        isAnimating = false;
        animationComplete = true;
    }, 600);
}

function updateTime() {
    const now = new Date();
    document.getElementById('currentTime').textContent =
        now.getFullYear() + '.' +
        String(now.getMonth() + 1).padStart(2, '0') + '.' +
        String(now.getDate()).padStart(2, '0') + ' - ' +
        String(now.getHours()).padStart(2, '0') + ':' +
        String(now.getMinutes()).padStart(2, '0') + ':' +
        String(now.getSeconds()).padStart(2, '0');
}

function updateTimer() {
    const now = Math.floor(Date.now() / 1000);
    const newRound = Math.floor(now / ROUND_INTERVAL);
    const roundEnd = (newRound + 1) * ROUND_INTERVAL;
    const remaining = roundEnd - now;

    document.getElementById('countdown').textContent =
        String(Math.floor(remaining / 60)).padStart(2, '0') + ':' +
        String(remaining % 60).padStart(2, '0');

    const box = document.getElementById('countdownBox');

    // 라운드 전환 감지 - 애니메이션 완료 후에만 전환
    if (newRound !== lastRound) {
        if (animationComplete) {
            lastRound = newRound;
            currentRound = newRound;
            todayRound++;
            animationComplete = false;
            animationStarted = false;
            fetchNewResult();
            return;
        }
    }

    if (remaining <= BETTING_CLOSE && !isBettingClosed) {
        closeBetting();
    }

    if (remaining <= 10) {
        box.classList.add('urgent');
    } else {
        box.classList.remove('urgent');
    }

    // remaining이 5초가 되면 애니메이션 시작
    if (remaining <= 5 && !animationStarted && !animationComplete) {
        animateLadder();
    }
}

function fetchNewResult() {
    fetch('<?php echo G5_URL; ?>/game/game_api.php?action=get_ladder_result&round=' + currentRound)
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                RESULT = data.result;
                resetForNewRound();
            }
        })
        .catch(() => {
            // 실패 시 페이지 새로고침
            location.reload();
        });
}

function resetForNewRound() {
    // 애니메이션 상태 초기화
    isAnimating = false;
    isBettingClosed = false;
    animationComplete = false;
    animationStarted = false;

    // UI 초기화
    const ball = document.getElementById('ladderBall');
    ball.classList.remove('visible');
    ball.style.left = '0';
    ball.style.top = '0';

    // 시작점/도착점 활성화 해제
    document.getElementById('startLeft').classList.remove('left-active');
    document.getElementById('startRight').classList.remove('right-active');
    document.getElementById('endOdd').classList.remove('odd-active');
    document.getElementById('endEven').classList.remove('even-active');

    // 모달 숨기기
    document.getElementById('resultModal').classList.remove('show');

    // 배팅창 다시 열기
    document.getElementById('bettingArea').classList.remove('closed');
    document.getElementById('submitBtn').disabled = false;

    // 배팅 선택 초기화
    document.querySelectorAll('.bet-btn').forEach(b => b.classList.remove('selected'));
    selectedBets = { start: null, oe: null, line: null };

    // 카운트다운 박스 상태 초기화
    document.getElementById('countdownBox').classList.remove('urgent');

    // 회차 표시 업데이트
    document.getElementById('nextRound').textContent = todayRound;
    document.getElementById('currentRoundNum').textContent = todayRound;
    document.getElementById('currentRoundResult').innerHTML = '대기 중';
    document.getElementById('currentRoundResult').className = 'result-waiting';

    // 사다리 경로 재계산
    calculateLadderPath();

    // 캔버스 다시 그리기
    initCanvas();
}

function closeBetting() {
    isBettingClosed = true;
    document.getElementById('bettingArea').classList.add('closed');
    document.getElementById('submitBtn').disabled = true;
}

function selectBet(el) {
    if (isBettingClosed) return;
    const type = el.dataset.type;
    document.querySelectorAll(`.bet-btn[data-type="${type}"]`).forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');
    selectedBets[type] = el.dataset.value;
}

function setAmount(val) {
    document.getElementById('betAmount').value = val === 'max' ? Math.min(currentPoint, 5000) : val;
}

function placeBet() {
    if (isBettingClosed) return alert('베팅이 마감되었습니다.');

    const hasSelection = selectedBets.start !== null || selectedBets.oe !== null || selectedBets.line !== null;
    if (!hasSelection) return alert('베팅 항목을 선택해주세요.');

    const amount = parseInt(document.getElementById('betAmount').value);
    if (amount < 10 || amount > 5000) return alert('베팅 금액은 10~5000P입니다.');
    if (amount > currentPoint) return alert('포인트가 부족합니다.');

    let betCount = [selectedBets.start, selectedBets.oe, selectedBets.line].filter(v => v !== null).length;
    if (amount * betCount > currentPoint) return alert('총 베팅액이 보유 포인트를 초과합니다.');

    fetch('<?php echo G5_URL; ?>/game/game_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=ladder_bet&round=${currentRound}&start=${selectedBets.start||''}&oe=${selectedBets.oe||''}&line=${selectedBets.line||''}&amount=${amount}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            currentPoint = data.point;
            document.getElementById('myPoint').textContent = currentPoint.toLocaleString();
            alert('베팅 완료!');
            document.querySelectorAll('.bet-btn').forEach(b => b.classList.remove('selected'));
            selectedBets = { start: null, oe: null, line: null };
        } else {
            alert(data.message || '베팅 실패');
        }
    })
    .catch(() => alert('오류가 발생했습니다.'));
}

// 초기화
window.addEventListener('load', function() {
    initCanvas();

    // 페이지 로드 시 남은 시간 확인
    const now = Math.floor(Date.now() / 1000);
    const roundEnd = (currentRound + 1) * ROUND_INTERVAL;
    const remaining = roundEnd - now;

    // 만약 페이지 로드 시 이미 5초 이상 남아있으면, 아직 애니메이션 전
    // 5초 이하면 애니메이션 시작됨
    if (remaining <= 5 && remaining > 0) {
        // 5초 이하지만 아직 라운드가 안 끝남 - 바로 애니메이션 시작
        animateLadder();
    } else if (remaining <= 0) {
        // 라운드가 이미 끝남 - 이전 결과 건너뛰고 새 라운드로
        animationComplete = true;
    }
});
window.addEventListener('resize', initCanvas);
setInterval(updateTime, 1000);
setInterval(updateTimer, 1000);
updateTime();
updateTimer();
</script>

<?php include_once(G5_PATH.'/tail.php'); ?>
