<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_PATH.'/head.sub.php');



// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
/*
if( $subIdx == "" ) {
	$sql = "SELECT * FROM drama_etc WHERE wr_10 = '{$view['wr_10']}'  ORDER BY keycode DESC LIMIT 1";
} else {
	$sql = "SELECT * FROM drama_etc WHERE wr_10 = '{$view['wr_10']}'  AND idx='{$subIdx}'";
}
$sRes = sql_query($sql);
$sRow = sql_fetch_array($sRes);
*/
//echo $sql;
if( $bo_table == "ani" ) {
	if( strpos($view['wr_homepage'], "tv.wiki") > -1 ) {
		if( $subIdx == "" ) {
			$sql = "SELECT *, idx as wr_id, vidthumb as thumb, name as wr_subject FROM drama_etc WHERE wr_10 = '{$view['wr_10']}'  ORDER BY idx DESC LIMIT 1";
		} else {
			$sql = "SELECT *, idx as wr_id, vidthumb as thumb, name as wr_subject FROM drama_etc WHERE wr_10 = '{$view['wr_10']}'  AND idx='{$subIdx}'";
		}
	} else {
		if( $subIdx == "" ) {
			$sql = "SELECT * FROM {$write_table}_l WHERE wr_10 = '{$view['wr_parent']}'  ORDER BY length(wr_subject) DESC, wr_subject DESC LIMIT 1";
		} else {
			$sql = "SELECT * FROM {$write_table}_l WHERE wr_10 = '{$view['wr_parent']}'  AND wr_id='{$subIdx}'";
		}
	}
} else {
	if( $subIdx == "" ) {
		$sql = "SELECT *, idx as wr_id, vidthumb as thumb, name as wr_subject FROM drama_etc WHERE wr_10 = '{$view['wr_10']}'  ORDER BY idx DESC LIMIT 1";
	} else {
		$sql = "SELECT *, idx as wr_id, vidthumb as thumb, name as wr_subject FROM drama_etc WHERE wr_10 = '{$view['wr_10']}'  AND idx='{$subIdx}'";
	}
}

	$sRes = sql_query($sql);
	$sRow = sql_fetch_array($sRes);

	$book_check = false;
	if (!$is_member)
	{
		$historyStr = $bo_table."|".$write['wr_id'];
		$tmpH = get_cookie("my_view_history");

		if( $tmpH != "" ) {
			$tmpArr = explode("^", $tmpH);
			if( !in_array($historyStr, $tmpArr) ) {
				$book_check = false;
			} else {
				$book_check = true;
			}
		}
	} else {
		$mb_id = $member['mb_id'];
		$sql = " select count(*) as cnt from {$g5['scrap_table']}
							where mb_id = '{$mb_id}'
							and bo_table = '$bo_table'
							and wr_id = '$wr_id' ";
		$row = sql_fetch($sql);
		if (isset($row['cnt']) && $row['cnt']) $book_check =  true;
	}


	if( $book_check ){
			$book_css = ' style="color:#3fdf3d"';
	} else {
			$book_css = "";
	}
	
if( $bo_table == "ani" ) {
	if( strpos($view['wr_homepage'], "tv.wiki") > -1 )
		$sql = "SELECT *, idx as wr_id, vidthumb as thumb, name as wr_subject, regdate as wr_datetime FROM drama_etc WHERE wr_10 = '{$view['wr_10']}'  ORDER BY idx DESC";
	else
		$sql = "SELECT *, wr_id as idx FROM {$write_table}_l WHERE wr_10 = '{$view['wr_parent']}'  ORDER BY length(wr_subject) DESC, wr_subject DESC";
	//echo $sql;
} else {
	$sql = "SELECT *, idx as wr_id, vidthumb as thumb, name as wr_subject, regdate as wr_datetime FROM drama_etc WHERE wr_10 = '{$view['wr_10']}'  ORDER BY idx DESC";
	//$sql = "SELECT * FROM drama_etc WHERE wr_10 = '{$view['wr_10']}'  ORDER BY keycode DESC";
}
//echo $sql;

$sRes2 = sql_query($sql);
$sRowCnt = sql_num_rows($sRes2);
?>


<!--<link rel="stylesheet" type="text/css" href="/css/board.css" />-->
<link rel="stylesheet" type="text/css" href="/css/video.skin.css?ver=1002" />	
<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<style>
#bo_v_act_good, #bo_v_act_nogood, #bo_v_act_book {display:none;position:absolute;top:30px;left:50%;width:200px;padding:20px;font-weight:normal;text-align:center;background:#f63941;z-index:9999;
-webkit-transform: translateX(-50%);
-ms-transform: translateX(-50%);
transform: translateX(-50%);
}

</style>

<style>
@media screen and (max-width:960px) {
ul.banner {display:block;}
ul.banner li {width:33.33%;margin:0;}
ul.banner li:nth-child(3n) {margin:0;}
ul.banner li.full {width:100%;margin:0;}
}
</style>

<!-- 플레이어 선택 버튼 스타일 -->
<style>
/* 플레이어 로딩 오버레이 - 깔끔한 디자인 */
.player-loading {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    display: none;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    z-index: 1000;
    border-radius: 10px;
    opacity: 0;
    transition: opacity 0.2s ease;
}
.player-loading.active {
    display: flex;
    opacity: 1;
}
.player-loading-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}
.player-loading-spinner {
    width: 48px;
    height: 48px;
    border: 3px solid rgba(255, 255, 255, 0.2);
    border-top-color: #6366f1;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.player-loading-text {
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.5px;
}
.embed-container {
    position: relative;
}

.player-select {
    display: flex;
    gap: 12px;
    padding: 16px 0;
    margin: 0 0 10px 0;
    justify-content: center;
}
.player-select .player-btn {
    padding: 12px 24px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.05);
    color: rgba(255, 255, 255, 0.8);
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-width: 140px;
    position: relative;
    overflow: hidden;
}
.player-select .player-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s;
}
.player-select .player-btn:hover::before {
    left: 100%;
}
.player-select .player-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.3);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}
.player-select .player-btn.active {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-color: #6366f1;
    color: #fff;
    box-shadow: 0 4px 20px rgba(99, 102, 241, 0.5);
    transform: translateY(-2px);
}
.player-select .player-btn.active:hover {
    box-shadow: 0 6px 25px rgba(99, 102, 241, 0.6);
}
.player-select .player-btn i {
    font-size: 18px;
    width: 20px;
    text-align: center;
}
.player-select .player-btn .btn-text {
    font-weight: 500;
    letter-spacing: 0.5px;
}
@media screen and (max-width: 768px) {
    .player-select {
        gap: 10px;
        padding: 12px 0;
    }
    .player-select .player-btn {
        padding: 10px 18px;
        font-size: 13px;
        min-width: 120px;
    }
    .player-select .player-btn i {
        font-size: 16px;
        width: 18px;
    }
}
</style>

<?php if( substr( $_SERVER['REMOTE_ADDR'] , 0, 6 ) == "66.249" ) { ?>
<h1><?php 
    if (strpos($sRow['origin'], 'tv.wiki') !== false) {
        echo get_text($sRow['title']) . ' ';
        $wrSubject = get_text($sRow['wr_subject']);
        preg_match('/(\d+화)\s*(다시보기)?/', $wrSubject, $matches);
        if (!empty($matches)) {
            echo $matches[1];
            if (empty($matches[2])) {
                echo ' 다시보기';
            }
        } else {
            echo ' 다시보기';
        }
    } else {
        echo get_text($sRow['wr_subject']) . ' 다시보기';
    }
?></h1>
<?php } ?>

<form id="bf" method="post" action="/bbs/scrap_check.php">
	<input type="hidden" name="bo_table" value="<?= $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?= $wr_id ?>">
	<input type="hidden" name="retUrl" value="<?= $_SERVER["REQUEST_URI"] ?>">
</form>


<?php
session_start();
$ip = $_SERVER['REMOTE_ADDR'];
$secret_key = "VERY_SECURE_SECRET";

// 🔥 1. 토큰 생성 (고유한 해시 값)
$random_bytes = bin2hex(random_bytes(16));
$timestamp = microtime(true); // 현재 시간 (밀리초 포함)
$token_data = hash('sha256', $random_bytes . $timestamp); // 고유한 해시 생성
$expires = time() + 20;  // 20초 후 만료

?>

<?php
$k = "0123456789abcdef0123456789abcdef";  // 암호화 키
$i = "abcdef9876543210abcdef9876543210"; // IV

$key = hex2bin($k);
$iv = hex2bin($i);

// $sRow 배열이 설정되어 있다고 가정합니다.
$vid = $sRow['vidsrc'];  // 기존 방식대로 값을 할당
$thm = $sRow['vidthumb'];   // 문자열 값도 암호화 가능

// 암호화 함수 정의
function encrypt_data($data, $key, $iv) {
    return bin2hex(openssl_encrypt($data, "aes-128-cbc", $key, OPENSSL_RAW_DATA, $iv));
}

// vidsrc와 vidthumb 암호화하기
$vidsrc_encrypted = encrypt_data($vid, $key, $iv);
$vidthumb_encrypted = encrypt_data($thm, $key, $iv);

?>

<?php
// 플레이어 1과 플레이어 2의 iframe URL 생성
$current_player = isset($_GET['player']) ? $_GET['player'] : '1';
$is_player2 = ($current_player == '2');

// 플레이어 1 URL (기본 player.bunny-frame.online)
if ($bo_table == "ani" && strpos($view['wr_homepage'], "tv.wiki") === false) {
    $player1_iframe_url = "https://player.bunny-frame.online/c.php?s=" . $sRow['SERVER'] . "&vtt=" . $sRow['vtt'] . "&t=" . urlencode(get_text($sRow['wr_subject'])) . "&p=/" . $sRow['vidthumb'] . "&option=" . urlencode(get_text($sRow['type'])) . "&type=cf&srt=" . urlencode(get_text($sRow['srt'])) . "&src=v/" . $sRow['vid_url'];
} elseif ($bo_table == "ani" && strpos($view['wr_homepage'], "tv.wiki") > -1) {
    $player1_iframe_url = "https://player.bunny-frame.online/?s=" . $sRow['SERVER'] . "&vtt=" . $sRow['vtt'] . "&srt=" . urlencode(get_text($sRow['srt'])) . "&src=" . urlencode($sRow['vidsrc']) . "&t=" . urlencode(get_text($sRow['wr_subject'])) . "&option=" . urlencode(get_text($sRow['type'])) . "&p=" . urlencode($sRow['vidthumb']);
} else {
    $player1_iframe_url = "https://player.bunny-frame.online/?s=" . $sRow['SERVER'] . "&vtt=" . $sRow['vtt'] . "&option=" . urlencode(get_text($sRow['type'])) . "&srt=" . urlencode(get_text($sRow['srt'])) . "&src=" . $vidsrc_encrypted . "&t=" . urlencode(htmlspecialchars(get_text($sRow['wr_subject']), ENT_QUOTES, 'UTF-8')) . "&p=" . $vidthumb_encrypted;
}

// 플레이어 2 URL (플레이어 1과 동일한 구조, 도메인은 그대로 경로만 index2.php로 변경)
if ($bo_table == "ani" && strpos($view['wr_homepage'], "tv.wiki") === false) {
    $player2_iframe_url = "https://player.bunny-frame.online/index2.php?s=" . $sRow['SERVER'] . "&vtt=" . $sRow['vtt'] . "&t=" . urlencode(get_text($sRow['wr_subject'])) . "&p=/" . $sRow['vidthumb'] . "&option=" . urlencode(get_text($sRow['type'])) . "&type=cf&srt=" . urlencode(get_text($sRow['srt'])) . "&src=v/" . $sRow['vid_url'];
} elseif ($bo_table == "ani" && strpos($view['wr_homepage'], "tv.wiki") > -1) {
    $player2_iframe_url = "https://player.bunny-frame.online/index2.php?s=" . $sRow['SERVER'] . "&vtt=" . $sRow['vtt'] . "&srt=" . urlencode(get_text($sRow['srt'])) . "&src=" . urlencode($sRow['vidsrc']) . "&t=" . urlencode(get_text($sRow['wr_subject'])) . "&option=" . urlencode(get_text($sRow['type'])) . "&p=" . urlencode($sRow['vidthumb']);
} else {
    $player2_iframe_url = "https://player.bunny-frame.online/index2.php?s=" . $sRow['SERVER'] . "&vtt=" . $sRow['vtt'] . "&option=" . urlencode(get_text($sRow['type'])) . "&srt=" . urlencode(get_text($sRow['srt'])) . "&src=" . $vidsrc_encrypted . "&t=" . urlencode(htmlspecialchars(get_text($sRow['wr_subject']), ENT_QUOTES, 'UTF-8')) . "&p=" . $vidthumb_encrypted;
}
?>

<div id="bo_v">
	<div class="bo_v_mov">
	<?php if( $bo_table == "ani" && strpos($view['wr_homepage'], "tv.wiki") === false ) { ?>
		<div class="embed-container">
			<iframe id="view_iframe" scrolling="no" width="560" height="315" src="<?= $is_player2 ? $player2_iframe_url : $player1_iframe_url ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			<div class="player-loading" id="playerLoading">
				<div class="player-loading-content">
					<div class="player-loading-spinner"></div>
					<div class="player-loading-text">로딩 중...</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if( $bo_table == "ani" && strpos($view['wr_homepage'], "tv.wiki") > -1 ) { ?>
		<div class="embed-container">
			<iframe id="view_iframe" scrolling="no" width="560" height="315" src="<?= $is_player2 ? $player2_iframe_url : $player1_iframe_url ?>" title="<?= get_text($sRow['name']) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			<div class="player-loading" id="playerLoading">
				<div class="player-loading-content">
					<div class="player-loading-spinner"></div>
					<div class="player-loading-text">로딩 중...</div>
				</div>
			</div>
		</div>
	<?php } ?>


		<?php if ($bo_table !== "ani"): ?> <!-- 애니x --><!--<?= $token_data ?>-->
			<div class="embed-container">
			<?php if (get_text($sRow['is_dl']) === "1"): ?>
		<iframe 
			id="view_iframe" 
			width="560" 
			height="315" 
			scrolling="no" 
			src="<?= $is_player2 ? $player2_iframe_url : $player1_iframe_url ?>" 
			frameborder="0" 
			allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
			allowfullscreen>
		</iframe>
		<div class="player-loading" id="playerLoading">
			<div class="player-loading-particles">
				<div class="player-loading-particle"></div>
				<div class="player-loading-particle"></div>
				<div class="player-loading-particle"></div>
				<div class="player-loading-particle"></div>
			</div>
			<div class="player-loading-content">
				<div class="player-loading-spinner-wrapper">
					<div class="player-loading-spinner">
						<div class="player-loading-spinner-inner"></div>
					</div>
				</div>
				<div class="player-loading-text">플레이어 로딩 중</div>
			</div>
		</div>

		<?php else: ?>

			<div style="font-size: 24px; color: white;">
				<br><br><br><br><br><br><br>
				<center>
					<p style="font-size: 50px; color: white;">동영상 업로드중 입니다. <br><br><br>잠시후 다시 시도해주세요.</p>
				</center>
			</div>
		<?php endif; ?>
		</div>
	<?php endif; ?>

	<!-- 플레이어 선택 버튼 -->
	<div class="player-select">
		<a href="javascript:void(0);" class="player-btn <?= !$is_player2 ? 'active' : '' ?>" onclick="switchPlayer(1, '<?= htmlspecialchars($player1_iframe_url, ENT_QUOTES, 'UTF-8') ?>', this)">
			<i class="fa-solid fa-play-circle"></i>
			<span class="btn-text">플레이어 1</span>
		</a>
		<a href="javascript:void(0);" class="player-btn <?= $is_player2 ? 'active' : '' ?>" onclick="switchPlayer(2, '<?= htmlspecialchars($player2_iframe_url, ENT_QUOTES, 'UTF-8') ?>', this)">
			<i class="fa-solid fa-play-circle"></i>
			<span class="btn-text">플레이어 2</span>
		</a>
	</div>
	<!-- 플레이어 선택 버튼 끝 -->

	<?php if( $_COOKIE['display_cover'] != "N" ) { ?>
		<div class="over" id="viewCover">
			<div class="over_cont">
				<strong>불편을 드려 죄송합니다 아래 내용을 반드시 확인해주세요</strong>
				<p>최근 잦은 도메인차단으로 인해 불편함을 최소화 하고자 아래 차단우회 가이드를 한번씩 꼭 정독 부탁드립니다.<br>아래 가이드 내용을 이미 숙지하고 계시다면 <u>동영상재생</u> 을 클릭하시면 재생이 가능합니다 불편을 드려 정말 죄송합니다.</p>
				<a href="javascript:;" onclick="playGo()" class="btn btn_normal">동영상 재생하기</a>
				<a href="https://t.me/tvwiki_url" class="btn btn_act" target="_blank">주소차단 가이드 확인하기</a>
			</div>
		</div>
	<?php } ?>
	</div>
<!--
        <div class="layer-footer">
            <a href="https://1.live/" target="_blak" class="layer-button">1</a>
        </div>
-->
<style>
.layer-footer {
    width: 100%; /* 부모 요소 가득 채우기 */
    display: flex; /* 내부 요소를 유연하게 배치 */
    margin-bottom: 10px; /* 하단 여백 추가 */
}

.layer-button {
    flex: 1; /* 버튼이 가득 차도록 설정 */
    display: block; /* 블록 요소로 변환 */
    text-align: center; /* 텍스트 중앙 정렬 */
    padding: 12px 0; /* 위아래 패딩 */
    background-color: #007bff; /* 파란색 배경 */
    color: white; /* 흰색 글씨 */
    text-decoration: none; /* 밑줄 제거 */
    font-size: 16px; /* 글씨 크기 */
    font-weight: bold; /* 글씨 굵게 */
    border-radius: 5px; /* 모서리 둥글게 */
}

.layer-button:hover {
    background-color: #0056b3; /* 마우스 호버 시 색 변경 */
}

  .pc-only {
    display: block; /* 기본적으로 보임 */
    margin-bottom: 10px; /* 하단에 5px 간격 */
  }

  .mobile-only {
    display: none; /* 기본적으로 숨김 */
    margin-bottom: 7px; /* 하단에 5px 간격 */
  }

  @media screen and (max-width: 768px) {
    /* 모바일 (화면 너비 768px 이하) 설정 */
    .pc-only {
      display: none; /* PC 전용 숨김 */
    }

    .mobile-only {
      display: block; /* 모바일 전용 보임 */
    }
  }

  .pc-only img, .mobile-only img {
    width: 100%; /* 가로 100% */
    height: auto; /* 비율 유지 */
  }
</style>


<ul>
<?php
$bRes = sql_query("SELECT * FROM g5_banner WHERE bn_border=1 ORDER BY rand()");

$banners_pc = array();
$banners_mobile = array();
while( $bRow = sql_fetch_array($bRes) ) {
	$bimg_pc = G5_DATA_PATH.'/banner/'.$bRow['bn_id'].'_pc';
	$bimg_mobile = G5_DATA_PATH.'/banner/'.$bRow['bn_id'].'_mobile';
	
	if(file_exists($bimg_pc)) {
		
		for( $i = 0 ; $i < $bRow['bn_order'] ; $i++ ) {
			$banners_pc[] = array(
								"url" => $bRow['bn_url'],
								"bn_id" => $bRow['bn_id'],
								"bn_alt" => $bRow['bn_alt'],
							);
		}
	}
	
	if(file_exists($bimg_mobile)) {
		for( $i = 0 ; $i < $bRow['bn_order'] ; $i++ ) {
			$banners_mobile[] = array(
								"url" => $bRow['bn_url'],
								"bn_id" => $bRow['bn_id'],
								"bn_alt" => $bRow['bn_alt'],
							);
		}
	}
	
}

shuffle($banners_pc);
shuffle($banners_mobile);

$banners_pc_tmp = array_unique($banners_pc, SORT_REGULAR);
$banners_mobile_tmp = array_unique($banners_mobile, SORT_REGULAR);

$banners_pc = array_slice($banners_pc_tmp, 0, 3);
$banners_mobile = array_slice($banners_mobile_tmp, 0, 3);


// PC용 배너
for( $i = 0 ; $i < count($banners_pc) ; $i++ ) {
	$bRow = $banners_pc[$i];
	$bn_img = '<img src="'.G5_DATA_URL.'/banner/'.$bRow['bn_id'].'_pc" alt="'.get_text($bRow['bn_alt']).'">';
?>
	<li class="full pc-only"><a href="<?= $bRow['url'] ?>" target="_blank"><?= $bn_img ?></a></li>
<?php
}

// Mobile용 배너
for( $i = 0 ; $i < count($banners_mobile) ; $i++ ) {
	$bRow = $banners_mobile[$i];
	$bn_img = '<img src="'.G5_DATA_URL.'/banner/'.$bRow['bn_id'].'_mobile" alt="'.get_text($bRow['bn_alt']).'">';
?>
	<li class="full mobile-only"><a href="<?= $bRow['url'] ?>" target="_blank"><?= $bn_img ?></a></li>
<?php
}
?>

</ul>


<?php if( $sRowCnt > 1 ) { ?>
	<ul class="bo_v_nb_mobile">
	<?php if( $prev_href != "" ) { ?>
		<li class="btn_prv"><a href="<?= $prev_href ?>"><span class="circle"><i class="fa-solid fa-caret-left"></i></span> 이전화</a></li>
	<?php } else { ?>
		<li class="btn_prv"><a href="javascript:alert('이전 회차가 없습니다.');"><span class="circle"><i class="fa-solid fa-caret-left"></i></span> 이전화</a></li>
	<?php } ?>
	<?php if( $next_href != "" ) { ?>
		<li class="btn_next"><a href="<?= $next_href ?>">다음화 <span class="circle"><i class="fa-solid fa-caret-right"></i></span></a></li>
	<?php } else { ?>
		<li class="btn_next"><a href="javascript:alert('다음 회차가 없습니다.');">다음화 <span class="circle"><i class="fa-solid fa-caret-right"></i></span></a></li>
	<?php } ?>
	</ul>
<?php } ?>


	<header>
		<h2 id="bo_v_title"><span class="bo_v_tit">
		<?php
		if (strpos($sRow['origin'], 'tv.wiki') !== false) {
			echo get_text($sRow['title']) . ' ';

			$wrSubject = get_text($sRow['wr_subject']);
			preg_match('/(\d+화)\s*(다시보기)?/', $wrSubject, $matches);
			if (!empty($matches)) {
				echo $matches[1];
				if (empty($matches[2])) {
					echo ' 다시보기';
				}
			}
		} else {
			echo get_text($sRow['wr_subject']) . ' 다시보기';
		}
		?>
		</span></h2>

		<div id="bo_v_info">
			<h2>페이지 정보</h2>
			<div class="profile_info_ct">
				<ul>
<?php
if ($bo_table !== "ani") {
    $dateStr = $sRow['regdate'];

    // 날짜 형식 확인 및 파싱
    $format = (count(explode('.', $dateStr)) === 3 && strlen(explode('.', $dateStr)[0]) === 2) ? 'd.m.Y' : 'Y.m.d';
    $date = DateTime::createFromFormat($format, $dateStr);

    // 날짜 포맷이 올바른 경우에만 출력
    if ($date) {
        echo '<li>등록된 날짜 : ' . $date->format('Y.m.d') . '</li>';
    } else {
        // 잘못된 날짜 형식인 경우, 'uptime' 사용
        $uptimeStr = $sRow['uptime'];
        $uptime = DateTime::createFromFormat('Y-m-d H:i:s', $uptimeStr);

        // 'uptime'의 날짜 부분만 출력
        if ($uptime) {
            echo '<li>등록된 날짜 : ' . $uptime->format('Y-m-d') . '</li>';
        } else {
            echo '<li></li>';
        }
    }
}
?>

				</ul>
			</div>
		</div>

		<div id="bo_v_act">
			<ul>
				<li><span class="bo_v_act_gng"><a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="bo_v_good"><i class="fa-regular fa-heart"></i>좋아요 <?php echo number_format($view['wr_good']) ?></a></span></li>
				<!--<li><a href="javascript:<?php if( $member['mb_id'] != "" ) { ?>$('#modal_sns').show();<?php } else { ?>alert_new('로그인 후 공유가 가능합니다.');<?php } ?>"><i class="fa-solid fa-share"></i>공유</a></li>-->
				<li><a href="javascript:$('#modal_sns').show();"><i class="fa-solid fa-share"></i>공유</a></li>
				<li><a href="javascript:<?php if( $member['mb_id'] != "" ) { ?>$('#modal_singo').show();<?php } else { ?>alert_new('로그인 후 신고 가능합니다.');<?php } ?>"><i class="fa-solid fa-bell"></i>신고</a></li>
				<li><span class="bo_v_act_book"><a href="javascript:;" onclick="<?php if( $member['mb_id'] != "" ) { ?>execute_book();<?php } else { ?>alert_new('로그인 후 스크랩이 가능합니다.');<?php } ?>" <?= $book_css ?>><i class="fa-regular fa-bookmark"></i>스크랩</a><b id="bo_v_act_book"></b></span></li>
			</ul>	
		</div>
	</header>

	<div id="bo_v_atc">
		<h2 id="bo_v_atc_title">줄거리</h2>
		<div id="bo_v_con">
				<?= ($sRow['wr_content'])?$sRow['wr_content']:$view['wr_content'] ?>

		</div>
	</div>	

<?php
if( $bo_table == "ani" ) {
	if($view['thumb']) {
		$img = $view['thumb'];
	} else {
		$img = G5_IMG_URL.'/no3.png';
		$thumb['alt'] = '이미지가 없습니다.';
	}
} else {
	if($view['wr_4']) {
		$img = $view['wr_4'];
	} else {
		$img = G5_IMG_URL.'/no3.png';
		$thumb['alt'] = '이미지가 없습니다.';
	}
}

$img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" onerror="this.src=\'/img/no3.png\';">';
$view['wr_5'] = (float)$view['wr_5']; // 소수점을 포함한 실수로 변환


if( $view['wr_3'] != "" && $view['wr_2'] != "" && $view['wr_1'] != "" && $view['wr_6'] != "" && $view['wr_8'] != "" ) {
?>	
	<div id="bo_v_atc">
<style>
/* PC 환경에서 이미지 크기 고정 */
@media (min-width: 768px) { /* PC 해상도 조건 */
    #bo_v_poster img {
        width: 300px; /* 고정된 가로 크기 */
        height: 450px; /* 고정된 세로 크기 */
        object-fit: cover; /* 이미지 비율 유지하면서 잘림 방지 */
    }
}

</style>

<div id="bo_v_poster">
    <?= $img_content ?>
    <?php if( $view['wr_5'] != "" && is_numeric($view['wr_5']) ) { ?>
        <label>
            <i class="fa-solid fa-star"></i> <?= number_format($view['wr_5'], 1) ?>
        </label>
    <?php } ?>
</div>



		<div id="bo_v_movinfo">
			<h3><?= get_text($view['wr_subject']) ?>
				<?php if( $view['wr_3'] != "" ) { ?>
				<span class="ori_title">원제 : <?= ($view['wr_3'])?$view['wr_3']:"정보없음" ?></span>
				<?php } ?>
			</h3>

			<dl class="bo_v_info">
			<?php if( $view['wr_2'] != "" ) { ?>
				<dd>국가: <?= ($view['wr_2'])?$view['wr_2']:"정보없음" ?></dd>
			<?php } ?>
			<?php if( $view['wr_8'] != "" ) { ?>
				<dd>언어: <?= ($view['wr_8'])?$view['wr_8']:"정보없음" ?></dd>
			<?php } ?>
			<?php if( $view['wr_6'] != "" ) { ?>
				<dd>개봉년도: <?= ($view['wr_6'])?$view['wr_6']:"정보없음" ?></dd>
			<?php } ?>
			</dl>

			<dl class="tags">
			<?php 
				$tagArr = explode(",", $view['wr_1']);
				for( $i = 0 ; $i < count($tagArr) ; $i++ ) {
					echo '<dd><a href="javascript:;">'.trim($tagArr[$i]).'</a></dd>';
				}
			?>
			<!--
				<dd><a href="">Horror</a></dd>
				<dd><a href="">Thriller</a></dd>
				<dd><a href="">Mystery</a></dd>
			-->
			<?php if( strpos($view['wr_9'], "http") > -1 ) { ?>
        <dd>
            <a href="<?= $view['wr_9'] ?>" target="_blank" class="btn_watch" onclick="openLayer(this.href); return false;">트레일러 보기</a>
        </dd>
			<?php } ?>
			</dl>
<!-- 레이어 모달 -->
<div id="layerModal" class="layer-modal">
    <div class="layer-content">
        <div class="layer-header">
            <span class="layer-title">트레일러</span>
            <button class="layer-close" onclick="closeLayer()">×</button>
        </div>
        <iframe id="layerIframe" src="" frameborder="0" allowfullscreen></iframe>
    </div>
</div>

<!-- CSS -->
<style>
    /* 레이어 배경 */
    .layer-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    /* 레이어 콘텐츠 */
    .layer-content {
        position: relative;
        width: 90%;
        max-width: 800px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
    }

    /* 레이어 헤더 */
    .layer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background: #333;
        color: #fff;
    }

    .layer-title {
        font-size: 16px;
        font-weight: bold;
    }

    .layer-close {
        background: none;
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
    }

    .layer-close:hover {
        color: #ff0000;
    }

    /* 트레일러 Iframe */
    #layerIframe {
        width: 100%;
        height: 450px;
        border: none;
    }

    /* 반응형 */
    @media (max-width: 600px) {
        .layer-content {
            width: 95%;
        }

        #layerIframe {
            height: 300px;
        }
    }
</style>

<!-- JavaScript -->
<script>
function openLayer(url) {
    try {
        // YouTube embed URL 변환
        const videoId = new URL(url).searchParams.get('v'); // URL에서 v 파라미터 추출
        if (!videoId) {
            alert("잘못된 YouTube URL입니다.");
            return;
        }

        const embedUrl = `https://www.youtube.com/embed/${videoId}`;

        const modal = document.getElementById('layerModal');
        const iframe = document.getElementById('layerIframe');
        iframe.src = embedUrl; // 변환된 URL 설정
        modal.style.display = 'flex'; // 레이어 표시
    } catch (error) {
        alert("URL 처리 중 오류가 발생했습니다.");
        console.error(error);
    }
}

function closeLayer() {
    const modal = document.getElementById('layerModal');
    const iframe = document.getElementById('layerIframe');
    iframe.src = ''; // iframe 비우기
    modal.style.display = 'none'; // 레이어 숨기기
}

// 바깥쪽 클릭 시 닫기
window.onload = function () {
    const modal = document.getElementById('layerModal');
    modal.addEventListener('click', function (event) {
        // 클릭된 요소가 모달 콘텐츠가 아니라면 닫기
        if (event.target === modal) {
            closeLayer();
        }
    });
};

</script>

<p style="
    margin: 0 0 24px 0;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 4;
    line-height: 1.5;
    max-height: calc(1.5em * 4); /* 최대 4줄 */
    min-height: calc(1.5em * 3); /* 최소 높이 고정 */
    ">
    <?= ($sRow['wr_content']) ? $sRow['wr_content'] : $view['wr_content'] ?>
</p>

<style>
/* 모바일에서 이미지 세로 길이 제한 */
.slider_act .img img {

    object-fit: cover; /* 이미지 비율 유지하며 자르기 */
    width: auto; /* 가로 크기 자동 조정 */
}

/* 반응형 디자인: 모바일 화면에서 동작 */
@media (max-width: 768px) {
    .slider_act .img img {
        max-height: 100px; /* 모바일에서 세로 길이 더 작게 설정 */
    }
}
</style>
			<div class="slider_act owl-carousel owl-theme">
			<?php
			$itemArr = explode(",", $view['wr_name']);
			for( $i = 0 ; $i < count($itemArr) ; $i++ ) {
				$tmpArr = explode("[", $itemArr[$i]);
				$name = $tmpArr[0];
				$imgsrc = "https://image.tmdb.org/t/p/w185/".trim(str_replace("]","",$tmpArr[1]));
			?>
			<div class="item"><a href="" class="img"><img src="<?= $imgsrc ?>" onerror="this.src='/img/no3.png';"></a><div class="name"><?= $name ?></div></div>
			<?php
			}
			?>
			</div>
		</div>

	</div>
<?php } ?>
<!--
	<div id="other_list">
		<h2>전체회차
			<div class="ep_search">
				<input type="text" name="" id="" value="" class="input" placeholder="에피소드를 검색해주세요">
				<button type="submit" id="" name=""><i class="xi-search xi-x"></i></button>
			</div>
		</h2>
-->

<?php
// $link_url2 변수 생성
$link_url2 = get_pretty_url($bo_table, $wr_id);
?>



<style>
.img-container {
  width: 100%; /* 모바일 화면에서도 잘 보이게 하려면 폭을 100%로 설정하세요 */
  height: 0; /* 패딩 비율을 이용해 높이를 설정할 것이므로 여기서는 높이를 0으로 설정합니다 */
  padding-bottom: 46.875%; /* 90/192 = 약 0.46875, 이 값을 백분율로 표현하면 46.875%입니다 */
  overflow: hidden;
  position: relative; /* img가 이 컨테이너를 기준으로 위치를 잡을 수 있게 relative로 설정합니다 */
}

.img-container img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* 데스크톱 화면에서는 원하는 크기인 192px * 90px로 설정합니다 */
@media (min-width: 768px) { /* 768px는 일반적인 브레이크포인트입니다. 필요에 따라 조절하세요 */
  .img-container {
    width: 192px;
    height: 90px;
    padding-bottom: 0; /* 높이가 고정되었으므로 패딩을 0으로 설정합니다 */
  }
}
</style>
<style>
.clamp {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
  font-size: 14px; /* 폰트 크기는 예시입니다. 필요에 따라 조정하세요. */
  line-height: 1.5; /* 줄 간격은 예시입니다. 필요에 따라 조정하세요. */
  height: 3em; /* 2줄 높이를 설정하세요. 이 예시에서는 폰트 크기와 줄 간격을 고려하여 설정됩니다. */
}
</style>

	<div id="other_list">
		<h2>전체회차
			<div class="ep_search">
				<input type="text" name="" id="subSearch" value="" class="input" placeholder="에피소드를 검색해주세요">
				<button type="button" id="" name=""><i class="xi-search xi-x"></i></button>
			</div>
		</h2>
		<ul>
<?php

while( $sRow = sql_fetch_array($sRes2) ) {
	$link_url = get_pretty_url($bo_table,$wr_id) . "/" . $sRow['idx'];

	if( $qstr != "" ) $link_url .= "?".$qstr
?>

			<li class="searchText <?= get_text($sRow['wr_subject']) ?>">
				<a href="<?= $link_url ?>" class="img">
	
<?php
$domain = '';
//echo "aa=".$sRow['SERVER'];
switch ($sRow['SERVER']) {
        case 1:
            $domain = 'img-requset1.digitalorio3nx.com';
            break;
        case 2:
            $domain = 'img-requset2.digitalorio3nx.com';
            break;
        case 3:
            $domain = 'img-requset3.digitalorio3nx.com';
            break;
        case 4:
            $domain = 'img-requset4.digitalorio3nx.com';
            break;
        case 5:
            $domain = 'img-requset5.digitalorio3nx.com';
            break;
        case 6:
            $domain = 'img-requset6.digitalorio3nx.com';
            break;
        case 7:
            $domain = 'img-requset7.digitalorio3nx.com';
            break;
        case 8:
            $domain = 'img-requset8.digitalorio3nx.com';
            break;
        case 9:
            $domain = 'img-requset2.digitalorio3nx.com';
            break;

        default:
            $domain = 'germany-cdn9398.bunny-cdn-player.online';
            break;
    }


//echo "<img src=\"https://{$domain}/{$sRow['vidthumb']}\">";
echo '<img class="lazy" data-src="https://'.$domain.'/'.$sRow['vidthumb'].'" data-original="https://'.$domain.'/'.$sRow['vidthumb'].'" src="/img/lazyloader.svg?ver=1" >';
?>
				</a>
				<a href="<?= $link_url ?>" class="title on"><?= get_text($sRow['wr_subject']) ?></a>
<?php if (!empty($sRow['wr_content'])): ?>
    <p><?= get_text($sRow['wr_content']) ?></p>
<?php else: ?>
    <p>등록된 줄거리가 없습니다.</p>
<?php endif; ?>

			</li>
<?php 
}
?>

		</ul>
	</div>

<script src="/js/jquery.lazy.min.js"></script>
<script>

$(document).ready(function() {

$('.slider_act').owlCarousel({
	items:7,
	autoplay: false,
	margin:20,
	loop:false,
	nav:true,
	dots:false,
	navText: [
		'<span aria-label="Previous"><i class="xi-angle-left-thin xi-x"></i></span>',
		'<span aria-label="Next"><i class="xi-angle-right-thin xi-x"></i></span>'
	],
	responsive:{
        0:{
            items:5,
			margin:10,
        },
        760:{
            items:5,
			margin:10,
        },
        960:{
            items:6,
			margin:10,
        },
        1250:{
            items:7,
			margin:20,
        }
    }
});

	$("img.lazy").Lazy({
		scrollDirection: 'vertical',
		effect: 'fadeIn',
		visibleOnly: true
	});
});

$('#subSearch').on('keypress keyup change', function() {
	console.log( $(this).val() );
	if( $(this).val() != "" ) {
		$('.searchText').hide();
		$('li[class*="' + $(this).val() + '"]').show();
	} else {
		$('.searchText').show();
	}
});
</script>



    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
	?>
	
		</div>

<?php if( $sRowCnt > 1 ) { ?>
	<ul class="bo_v_nb">
	<?php if( $prev_href != "" ) { ?>
		<li class="btn_prv"><a href="<?= $prev_href ?>"><span><i class="xi-caret-up xi-rotate-270"></i></span><p>이전화</p></a></li>
	<?php } else { ?>
		<li class="btn_prv"><a href="javascript:alert('이전 회차가 없습니다.');"><span><i class="xi-caret-up xi-rotate-270"></i></span><p>이전화</p></a></li>
	<?php } ?>
	<?php if( $next_href != "" ) { ?>
		<li class="btn_next"><a href="<?= $next_href ?>"><span><i class="xi-caret-up xi-rotate-90"></i></span><p>다음화</p></a></li>
	<?php } else { ?>
		<li class="btn_next"><a href="javascript:alert('다음 회차가 없습니다.');"><span><i class="xi-caret-up xi-rotate-90"></i></span><p>다음화</p></a></li>
	<?php } ?>
	</ul>
<?php } ?>

</div>
<script>
function playGo() {
	set_cookie("display_cover","N",24);
	$('#viewCover').hide();
}

$(document).ready(function() {	
	$(".btn_share").on("click", function() {
		$("#sharebox").fadeToggle();
		return false;
	});
	$(".btn_share_close").on("click", function() {
		$("#sharebox").fadeOut();
		return false;
	});
});

$('.slider').owlCarousel({
	items:7,
	autoplay: false,
	margin:20,
	loop:true,
	nav:false,
	dots:false,
	navText: [
		'<span aria-label="Previous"><i class="xi-angle-left-thin xi-x"></i></span>',
		'<span aria-label="Next"><i class="xi-angle-right-thin xi-x"></i></span>'
	],
	responsive:{
        0:{
            items:3,
        },
        980:{
            items:4,
        },
        1000:{
            items:7,
        }
    }
});

//공유링크 복사 함수
function copyItemLink(){
	var copyText = document.getElementById("copy_link");
	copyText.select();
	copyText.setSelectionRange(0, 99999)
	document.execCommand("copy");
	alert("공유링크가 복사되었습니다.");
}
</script>
<!-- } 게시글 읽기 끝 -->


<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
// 플레이어 전환 함수
function switchPlayer(playerNum, playerUrl, btnElement) {
    // 로딩 표시
    var loading = document.getElementById('playerLoading');
    if (loading) {
        loading.classList.add('active');
    }
    
    // iframe의 src 변경
    var iframe = document.getElementById('view_iframe');
    if (iframe) {
        // iframe 로드 완료 이벤트 리스너 추가
        iframe.onload = function() {
            // 로딩 숨김
            if (loading) {
                loading.classList.remove('active');
            }
        };
        
        // src 변경 (로딩 시작)
        iframe.src = playerUrl;
    }
    
    // 모든 버튼에서 active 클래스 제거
    document.querySelectorAll('.player-btn').forEach(function(btn) {
        btn.classList.remove('active');
    });
    
    // 클릭한 버튼에 active 클래스 추가
    if (btnElement) {
        btnElement.classList.add('active');
    }
}

$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
	<?php if( $member['mb_id'] == "" ) { ?>
		alert_new('로그인 후 추천 가능합니다.');
		return false;
	<?php } else { ?>
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
	<?php } ?>
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
					alert('이 글을 추천하셨습니다.');
					location.reload();
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}

function execute_book() {
    $.post(
        "/bbs/scrap_check.php",
        { wr_id: "<?= $wr_id ?>", bo_table: "<?= $bo_table ?>" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.msg) {
				if( data.chk == "on" ) {
					$('.bo_v_act_book').find('a').css('color','#3fdf3d');
					$('.bo_v_act_bool').find('i').removeClass('xi-bookmark');
					$('.bo_v_act_bool').find('i').removeClass('xi-bookmark-o');
					$('.bo_v_act_bool').find('i').addClass('xi-bookmark-o');
				} else {
					$('.bo_v_act_book').find('a').css('color','#fff');
					$('.bo_v_act_bool').find('i').removeClass('xi-bookmark');
					$('.bo_v_act_bool').find('i').removeClass('xi-bookmark-o');
					$('.bo_v_act_bool').find('i').addClass('xi-bookmark');
				}
				
                $("#bo_v_act_book").text(data.msg);
                $("#bo_v_act_book").fadeIn(200).delay(2500).fadeOut(200);
            }
        }, "json"
    );
}

$(window).scroll(function() {
	if ($(window).scrollTop() > 120) {
		$('.bo_v_nb').addClass('bo_v_nb_sticky');
		/*$('.header_mobile').addClass('hide');*/
	} else {
		$('.bo_v_nb').removeClass('bo_v_nb_sticky');
		/*$('.header_mobile').removeClass('hide');*/
	}
});
</script>
<!-- } 게시글 읽기 끝 -->
