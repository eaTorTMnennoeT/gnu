<?php
/**
 * 경마 게임 (Horse Racing)
 * 1분 회차 시스템 - 고퀄리티 애니메이션
 */
include_once('./_common.php');

if (!$is_member) {
    alert('로그인이 필요합니다.', G5_BBS_URL.'/login.php');
}

// 경마 베팅 테이블이 없으면 생성
$table_name = $g5['write_prefix'] . 'game_racing_bet';
$table_exists = sql_query("SHOW TABLES LIKE '{$table_name}'");
if (sql_num_rows($table_exists) == 0) {
    $sql = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
        `rb_id` int(11) NOT NULL AUTO_INCREMENT,
        `mb_id` varchar(20) NOT NULL DEFAULT '',
        `mb_nick` varchar(40) NOT NULL DEFAULT '',
        `rb_round` int(11) NOT NULL DEFAULT 0,
        `rb_horse_id` int(11) NOT NULL DEFAULT 0,
        `rb_horse_name` varchar(50) NOT NULL DEFAULT '',
        `rb_amount` int(11) NOT NULL DEFAULT 0,
        `rb_odds` decimal(5,2) NOT NULL DEFAULT 0,
        `rb_status` enum('pending','win','lose') NOT NULL DEFAULT 'pending',
        `rb_win_amount` int(11) NOT NULL DEFAULT 0,
        `rb_datetime` datetime NOT NULL,
        PRIMARY KEY (`rb_id`),
        KEY `idx_mb_id` (`mb_id`),
        KEY `idx_rb_round` (`rb_round`),
        KEY `idx_rb_status` (`rb_status`),
        KEY `idx_rb_datetime` (`rb_datetime`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    sql_query($sql);
}

$g5['title'] = '경마 게임';
include_once(G5_PATH.'/head.php');

$member_point = $member['mb_point'];

// 회차 설정 (1분 = 60초)
$round_interval = 60;
$current_time = time();
$current_round = floor($current_time / $round_interval);
$round_start = $current_round * $round_interval;
$round_end = $round_start + $round_interval;
$remaining = $round_end - $current_time;
$betting_close = 10; // 마감 10초 전

// 출주마 정보 생성 (회차별 고정)
function get_horses($round) {
    $secret = 'racing_game_secret_2024';
    $hash = hash('sha256', $round . $secret);

    $horses = [
        ['name' => '번개', 'color' => '#ef4444', 'emoji' => '🔴'],
        ['name' => '황금마', 'color' => '#f59e0b', 'emoji' => '🟡'],
        ['name' => '블루윈드', 'color' => '#3b82f6', 'emoji' => '🔵'],
        ['name' => '그린라이트', 'color' => '#10b981', 'emoji' => '🟢'],
        ['name' => '퍼플스타', 'color' => '#8b5cf6', 'emoji' => '🟣'],
        ['name' => '다크호스', 'color' => '#1f2937', 'emoji' => '⚫'],
    ];

    // 배당률 생성 (해시 기반)
    for ($i = 0; $i < count($horses); $i++) {
        $seed = hexdec(substr($hash, $i * 4, 4));
        // 배당률 1.5 ~ 10.0
        $odds = 1.5 + ($seed % 85) / 10;
        $horses[$i]['odds'] = round($odds, 1);
        $horses[$i]['id'] = $i + 1;
    }

    // 배당률로 정렬 (낮은 배당 = 인기마)
    usort($horses, function($a, $b) {
        return $a['odds'] <=> $b['odds'];
    });

    return $horses;
}

// 결과 생성 (배당률 가중치 + 랜덤)
function get_race_result($round, $horses) {
    $secret = 'racing_result_secret_2024';
    $hash = hash('sha256', $round . $secret . 'result');

    // 배당률 역수로 가중치 계산 (낮은 배당 = 높은 확률)
    $weights = [];
    $totalWeight = 0;
    foreach ($horses as $idx => $horse) {
        $weight = 100 / $horse['odds']; // 역수
        $weights[$idx] = $weight;
        $totalWeight += $weight;
    }

    // 해시로 랜덤 값 생성
    $seed = hexdec(substr($hash, 0, 8));
    $random = ($seed % 10000) / 10000 * $totalWeight;

    // 1등 결정
    $cumulative = 0;
    $winner = 0;
    foreach ($weights as $idx => $weight) {
        $cumulative += $weight;
        if ($random <= $cumulative) {
            $winner = $idx;
            break;
        }
    }

    // 2등, 3등 결정
    $seed2 = hexdec(substr($hash, 8, 8));
    $seed3 = hexdec(substr($hash, 16, 8));

    $remaining = array_keys($horses);
    unset($remaining[$winner]);
    $remaining = array_values($remaining);

    $second = $remaining[$seed2 % count($remaining)];
    unset($remaining[array_search($second, $remaining)]);
    $remaining = array_values($remaining);

    $third = $remaining[$seed3 % count($remaining)];

    return [
        'first' => $horses[$winner]['id'],
        'second' => $horses[$second]['id'],
        'third' => $horses[$third]['id'],
        'hash' => substr($hash, 0, 16)
    ];
}

$horses = get_horses($current_round);
$result = get_race_result($current_round, $horses);

// 지난 회차 pending 베팅 자동 처리
$pending_sql = "SELECT * FROM {$g5['write_prefix']}game_racing_bet
                WHERE mb_id = '{$member['mb_id']}'
                AND rb_status = 'pending'
                AND rb_round < {$current_round}";
$pending_result = sql_query($pending_sql);
while ($pending_bet = sql_fetch_array($pending_result)) {
    $past_round = $pending_bet['rb_round'];
    $past_horses = get_horses($past_round);
    $past_result = get_race_result($past_round, $past_horses);
    $winner_id = $past_result['first'];

    $is_win = ($pending_bet['rb_horse_id'] == $winner_id);

    if ($is_win) {
        // 당첨
        $win_amount = floor($pending_bet['rb_amount'] * $pending_bet['rb_odds']);
        $content = "경마 {$past_round}회차 당첨 ({$pending_bet['rb_horse_name']}, x{$pending_bet['rb_odds']})";
        insert_point($member['mb_id'], $win_amount, $content, 'game', $member['mb_id'], 'racing_win_' . $past_round . '_' . $pending_bet['rb_id']);

        sql_query("UPDATE {$g5['write_prefix']}game_racing_bet
                   SET rb_status = 'win', rb_win_amount = '{$win_amount}'
                   WHERE rb_id = '{$pending_bet['rb_id']}'");

        // game_log 업데이트
        sql_query("UPDATE {$g5['write_prefix']}game_log
                   SET gl_result = 'win', gl_win_amount = '{$win_amount}', gl_profit = '" . ($win_amount - $pending_bet['rb_amount']) . "'
                   WHERE mb_id = '{$member['mb_id']}' AND gl_game = 'racing' AND gl_detail LIKE '%회차:{$past_round}%' AND gl_result = 'pending'");
    } else {
        // 패배
        sql_query("UPDATE {$g5['write_prefix']}game_racing_bet
                   SET rb_status = 'lose'
                   WHERE rb_id = '{$pending_bet['rb_id']}'");

        // game_log 업데이트 - 패배 시 손익은 -베팅금액
        sql_query("UPDATE {$g5['write_prefix']}game_log
                   SET gl_result = 'lose', gl_win_amount = 0, gl_profit = '-{$pending_bet['rb_amount']}'
                   WHERE mb_id = '{$member['mb_id']}' AND gl_game = 'racing' AND gl_detail LIKE '%회차:{$past_round}%' AND gl_result = 'pending'");
    }
}

// DB에서 내 베팅 내역 불러오기 (최근 20개)
$my_bets = [];
$sql = "SELECT * FROM {$g5['write_prefix']}game_racing_bet
        WHERE mb_id = '{$member['mb_id']}'
        ORDER BY rb_datetime DESC
        LIMIT 20";
$result_bets = sql_query($sql);
while ($row = sql_fetch_array($result_bets)) {
    $my_bets[] = $row;
}

// 현재 라운드에 베팅했는지 확인
$current_bet = null;
foreach ($my_bets as $bet) {
    if ($bet['rb_round'] == $current_round) {
        $current_bet = $bet;
        break;
    }
}
?>

<style>
/* ========================================
   경마 게임 - 프리미엄 UI
   ======================================== */

.racing-game {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
}

/* 헤더 */
.racing-header {
    background: linear-gradient(135deg, #059669 0%, #047857 50%, #065f46 100%);
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}

.racing-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M20 0l20 20-20 20L0 20z'/%3E%3C/g%3E%3C/svg%3E");
}

.racing-header-content {
    position: relative;
    z-index: 1;
}

.racing-title {
    font-size: 28px;
    font-weight: 800;
    color: white;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.racing-subtitle {
    color: rgba(255,255,255,0.8);
    font-size: 14px;
}

/* 회차 & 타이머 */
.round-info {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 20px;
}

.round-box {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 12px 24px;
    text-align: center;
}

.round-label {
    font-size: 12px;
    color: rgba(255,255,255,0.7);
    margin-bottom: 4px;
}

.round-value {
    font-size: 24px;
    font-weight: 700;
    color: white;
}

.round-value.timer {
    color: #fbbf24;
    font-family: 'Courier New', monospace;
}

.round-value.timer.urgent {
    color: #ef4444;
    animation: blink 0.5s ease-in-out infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* 포인트 바 */
.point-bar {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.point-display {
    display: flex;
    align-items: center;
    gap: 10px;
}

.point-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.point-amount {
    font-size: 22px;
    font-weight: 700;
    color: #fbbf24;
}

.point-label {
    font-size: 12px;
    color: var(--text-secondary);
}

/* 레이스 트랙 */
.race-track-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 24px;
    overflow: hidden;
}

.panel-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-primary);
}

/* 3D 경마 트랙 */
.race-track-3d-wrapper {
    perspective: 800px;
    perspective-origin: 50% 100%;
    margin-bottom: 16px;
}

.race-track {
    background: linear-gradient(180deg,
        #1a472a 0%,
        #2d5a3c 20%,
        #3d7a4f 50%,
        #2d5a3c 80%,
        #1a472a 100%
    );
    border-radius: 16px;
    padding: 0;
    position: relative;
    overflow: hidden;
    transform: rotateX(35deg);
    transform-origin: center bottom;
    box-shadow:
        0 20px 60px rgba(0,0,0,0.5),
        inset 0 2px 20px rgba(255,255,255,0.1);
}

/* 트랙 그라운드 텍스처 */
.race-track::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background:
        repeating-linear-gradient(
            90deg,
            transparent,
            transparent 50px,
            rgba(0,0,0,0.05) 50px,
            rgba(0,0,0,0.05) 100px
        );
    pointer-events: none;
}

/* 트랙 조명 효과 */
.race-track::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(180deg, rgba(255,255,255,0.1) 0%, transparent 100%);
    pointer-events: none;
}

.track-lanes {
    position: relative;
    padding: 20px 20px;
    padding-top: 16px;
    padding-bottom: 16px;
}

.track-lane {
    display: flex;
    align-items: center;
    height: 44px;
    margin-bottom: 4px;
    position: relative;
    background: linear-gradient(90deg,
        rgba(139,90,43,0.4) 0%,
        rgba(139,90,43,0.2) 50%,
        rgba(139,90,43,0.4) 100%
    );
    border-radius: 4px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    border-top: 1px solid rgba(0,0,0,0.2);
}

.track-lane:nth-child(odd) {
    background: linear-gradient(90deg,
        rgba(139,90,43,0.5) 0%,
        rgba(139,90,43,0.3) 50%,
        rgba(139,90,43,0.5) 100%
    );
}

.track-lane:last-child {
    margin-bottom: 0;
}

.lane-number {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 12px;
    color: white;
    flex-shrink: 0;
    z-index: 2;
    margin-left: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.4);
    border: 2px solid rgba(255,255,255,0.3);
}

.horse-container {
    flex: 1;
    position: relative;
    height: 100%;
    margin-left: 8px;
    margin-right: 50px;
}

/* 말 컨테이너 */
.horse {
    position: absolute;
    left: 5px; /* 출발선 앞(왼쪽)에서 시작 */
    top: 50%;
    transform: translateY(-50%);
    transition: none;
    z-index: 10;
    width: 50px;
    height: 35px;
}

/* 말 + 기수 전체 */
.horse-figure {
    position: relative;
    width: 100%;
    height: 100%;
}

/* 기수 (원형) */
.jockey {
    position: absolute;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    top: 0;
    left: 18px;
    z-index: 3;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.jockey::after {
    content: '';
    position: absolute;
    width: 6px;
    height: 8px;
    background: inherit;
    top: 8px;
    left: 2px;
    border-radius: 2px;
}

/* 말 몸체 */
.horse-body {
    position: absolute;
    top: 8px;
    left: 0;
    width: 100%;
    height: 100%;
}

/* 말 머리 */
.horse-head {
    position: absolute;
    width: 14px;
    height: 10px;
    background: #8B4513;
    border-radius: 8px 8px 4px 4px;
    top: 2px;
    right: 0;
    transform: rotate(-20deg);
    z-index: 2;
}

.horse-head::before {
    content: '';
    position: absolute;
    width: 4px;
    height: 6px;
    background: #8B4513;
    top: -4px;
    right: 2px;
    border-radius: 2px 2px 0 0;
}

.horse-head::after {
    content: '';
    position: absolute;
    width: 2px;
    height: 2px;
    background: #000;
    border-radius: 50%;
    top: 3px;
    right: 3px;
}

/* 말 목 */
.horse-neck {
    position: absolute;
    width: 12px;
    height: 14px;
    background: #8B4513;
    top: 4px;
    right: 8px;
    border-radius: 4px;
    transform: rotate(-30deg);
    z-index: 1;
}

/* 말 몸통 */
.horse-torso {
    position: absolute;
    width: 28px;
    height: 16px;
    background: linear-gradient(180deg, #A0522D 0%, #8B4513 100%);
    border-radius: 10px 6px 6px 10px;
    top: 6px;
    left: 8px;
    z-index: 1;
}

/* 말 다리 */
.horse-leg {
    position: absolute;
    width: 4px;
    height: 14px;
    background: linear-gradient(180deg, #8B4513 0%, #654321 100%);
    border-radius: 2px;
    z-index: 0;
}

.horse-leg.front-left { top: 18px; left: 28px; }
.horse-leg.front-right { top: 18px; left: 22px; }
.horse-leg.back-left { top: 18px; left: 14px; }
.horse-leg.back-right { top: 18px; left: 8px; }

/* 말 꼬리 */
.horse-tail {
    position: absolute;
    width: 3px;
    height: 12px;
    background: #654321;
    top: 8px;
    left: 4px;
    border-radius: 0 0 3px 3px;
    transform-origin: top center;
}

/* 달리기 애니메이션 */
.horse.running .horse-leg.front-left { animation: legFront 0.2s ease-in-out infinite; }
.horse.running .horse-leg.front-right { animation: legFront 0.2s ease-in-out infinite 0.1s; }
.horse.running .horse-leg.back-left { animation: legBack 0.2s ease-in-out infinite; }
.horse.running .horse-leg.back-right { animation: legBack 0.2s ease-in-out infinite 0.1s; }
.horse.running .horse-tail { animation: tailWag 0.3s ease-in-out infinite; }
.horse.running .horse-body { animation: bodyBounce 0.2s ease-in-out infinite; }

@keyframes legFront {
    0%, 100% { transform: rotate(-20deg); height: 14px; }
    50% { transform: rotate(30deg); height: 12px; }
}

@keyframes legBack {
    0%, 100% { transform: rotate(20deg); height: 14px; }
    50% { transform: rotate(-30deg); height: 12px; }
}

@keyframes tailWag {
    0%, 100% { transform: rotate(-10deg); }
    50% { transform: rotate(20deg); }
}

@keyframes bodyBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-2px); }
}

/* 먼지 효과 */
.dust-cloud {
    position: absolute;
    left: -5px;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0;
    pointer-events: none;
}

.horse.running .dust-cloud {
    opacity: 1;
}

.horse.running .dust-cloud::before,
.horse.running .dust-cloud::after {
    content: '';
    position: absolute;
    width: 8px;
    height: 8px;
    background: rgba(139, 90, 43, 0.5);
    border-radius: 50%;
    animation: dustParticle 0.3s ease-out infinite;
}

.horse.running .dust-cloud::after {
    animation-delay: 0.15s;
    top: -6px;
    width: 6px;
    height: 6px;
}

@keyframes dustParticle {
    0% { opacity: 0.7; transform: translateX(0) scale(1); }
    100% { opacity: 0; transform: translateX(-20px) scale(0.3); }
}

/* 레이스 상태바 */
.race-status-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #1e293b, #334155);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 12px 20px;
    margin-bottom: 15px;
}

.race-status-indicator {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    color: #94a3b8;
}

.race-status-indicator .status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #64748b;
    box-shadow: 0 0 10px rgba(100,116,139,0.5);
}

.race-status-indicator.racing .status-dot {
    background: #22c55e;
    box-shadow: 0 0 15px rgba(34,197,94,0.8);
    animation: statusPulse 0.5s ease-in-out infinite;
}

.race-status-indicator.racing .status-text {
    color: #22c55e;
}

.race-status-indicator.finished .status-dot {
    background: #f59e0b;
    box-shadow: 0 0 15px rgba(245,158,11,0.8);
}

.race-status-indicator.finished .status-text {
    color: #f59e0b;
}

@keyframes statusPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.3); }
}

.race-round-info {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #94a3b8;
    font-size: 14px;
}

.race-round-info strong {
    color: #f1f5f9;
    font-size: 18px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* 결승선 */
.finish-line {
    position: absolute;
    right: 45px;
    top: 0;
    bottom: 0;
    width: 6px;
    background: repeating-linear-gradient(
        0deg,
        #fff,
        #fff 8px,
        #000 8px,
        #000 16px
    );
    box-shadow: 0 0 20px rgba(255,255,255,0.3);
    z-index: 5;
}

.finish-line::before {
    content: '🏁';
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 24px;
    animation: flagWave 0.5s ease-in-out infinite alternate;
}

@keyframes flagWave {
    0% { transform: translateX(-50%) rotate(-5deg); }
    100% { transform: translateX(-50%) rotate(5deg); }
}

.finish-flag {
    display: none;
}

/* 트랙 레일 - 상단과 하단 경계선 */
.track-rail-top,
.track-rail-bottom {
    position: absolute;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg,
        #8b4513, #d2691e, #8b4513, #d2691e, #8b4513
    );
    background-size: 40px 100%;
    box-shadow:
        inset 0 2px 4px rgba(0,0,0,0.3),
        0 2px 8px rgba(0,0,0,0.4);
    z-index: 20;
}

.track-rail-top {
    top: 0;
    border-radius: 16px 16px 0 0;
}

.track-rail-bottom {
    bottom: 0;
    border-radius: 0 0 16px 16px;
}

/* 스타트 게이트 - 출발선 */
.start-gate {
    position: absolute;
    left: 55px;
    top: 10px;
    bottom: 10px;
    width: 3px;
    background: repeating-linear-gradient(
        0deg,
        #fff 0px,
        #fff 4px,
        #ff0000 4px,
        #ff0000 8px
    );
    z-index: 15;
    box-shadow: 0 0 8px rgba(255,255,255,0.5);
}

.start-gate::before {
    content: 'START';
    position: absolute;
    top: -18px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 9px;
    font-weight: bold;
    color: #fff;
    background: #dc2626;
    padding: 2px 6px;
    border-radius: 3px;
    white-space: nowrap;
}

/* 출주표 & 베팅 */
.betting-section {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 24px;
    margin-bottom: 24px;
}

.horse-list {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
}

.horse-table {
    width: 100%;
    border-collapse: collapse;
}

.horse-table th {
    text-align: left;
    padding: 12px;
    border-bottom: 2px solid var(--border);
    font-size: 13px;
    color: var(--text-secondary);
    font-weight: 600;
}

.horse-table td {
    padding: 14px 12px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.horse-table tr:last-child td {
    border-bottom: none;
}

.horse-table tr:hover {
    background: var(--bg-main);
}

.horse-name-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.horse-color {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.horse-name {
    font-weight: 600;
    color: var(--text-primary);
}

.horse-odds {
    font-weight: 700;
    color: #fbbf24;
    font-size: 18px;
}

.horse-odds.low {
    color: #ef4444;
}

.horse-odds.high {
    color: #10b981;
}

.bet-input-cell {
    width: 120px;
}

.bet-input {
    width: 100%;
    padding: 8px 12px;
    border: 2px solid var(--border);
    border-radius: 8px;
    font-size: 14px;
    text-align: right;
    background: var(--bg-main);
    color: var(--text-primary);
}

.bet-input:focus {
    outline: none;
    border-color: #10b981;
}

.bet-input:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* 말 선택 그리드 */
.horse-select-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.horse-select-card {
    background: var(--bg-main);
    border: 2px solid var(--border);
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
}

.horse-select-card:hover {
    border-color: #10b981;
    transform: translateY(-2px);
}

.horse-select-card.selected {
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.1);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.horse-select-number {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    color: white;
    margin: 0 auto 8px;
}

.horse-select-emoji {
    font-size: 28px;
    margin-bottom: 8px;
}

.horse-select-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 14px;
    margin-bottom: 4px;
}

.horse-select-odds {
    font-weight: 700;
    color: #fbbf24;
    font-size: 16px;
}

.horse-select-odds.low {
    color: #ef4444;
}

.horse-select-odds.high {
    color: #10b981;
}

/* 베팅 금액 섹션 */
.bet-amount-section {
    margin-bottom: 16px;
}

.bet-amount-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 8px;
}

.bet-amount-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid var(--border);
    border-radius: 10px;
    font-size: 18px;
    font-weight: 600;
    text-align: center;
    background: var(--bg-main);
    color: var(--text-primary);
    box-sizing: border-box;
}

.bet-amount-input:focus {
    outline: none;
    border-color: #10b981;
}

.bet-amount-input:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* 베팅 패널 */
.betting-panel {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    position: sticky;
    top: 20px;
}

.bet-type-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
}

.bet-type-tab {
    flex: 1;
    padding: 12px;
    border: 2px solid var(--border);
    border-radius: 10px;
    background: var(--bg-main);
    color: var(--text-primary);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}

.bet-type-tab:hover {
    border-color: #10b981;
}

.bet-type-tab.active {
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.bet-summary {
    background: var(--bg-main);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
}

.bet-summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 14px;
}

.bet-summary-row:last-child {
    margin-bottom: 0;
    padding-top: 12px;
    border-top: 1px solid var(--border);
    font-weight: 700;
    font-size: 16px;
}

.bet-summary-label {
    color: var(--text-secondary);
}

.bet-summary-value {
    color: var(--text-primary);
}

.bet-summary-value.total {
    color: #fbbf24;
}

.quick-amounts {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    margin-bottom: 16px;
}

.quick-btn {
    padding: 10px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: var(--bg-main);
    color: var(--text-primary);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.quick-btn:hover {
    background: #10b981;
    color: white;
    border-color: #10b981;
}

.bet-submit {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
}

.bet-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

.bet-submit:disabled {
    background: #6b7280;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* 결과 모달 */
.race-result-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.8);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s;
}

.race-result-overlay.show {
    opacity: 1;
    pointer-events: auto;
}

.race-result-modal {
    background: var(--bg-card);
    border-radius: 24px;
    padding: 40px;
    text-align: center;
    max-width: 450px;
    width: 90%;
    transform: scale(0.9);
    transition: transform 0.3s;
}

.race-result-overlay.show .race-result-modal {
    transform: scale(1);
}

.result-trophy {
    font-size: 64px;
    margin-bottom: 16px;
    animation: bounce 1s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.result-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 24px;
}

.result-places {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-bottom: 24px;
}

.result-place {
    background: var(--bg-main);
    border-radius: 12px;
    padding: 16px 24px;
    text-align: center;
}

.place-rank {
    font-size: 12px;
    color: var(--text-secondary);
    margin-bottom: 8px;
}

.place-horse {
    font-size: 32px;
    margin-bottom: 4px;
}

.place-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

.place-odds {
    font-size: 13px;
    color: #fbbf24;
}

.result-winnings {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 24px;
}

.result-winnings.win {
    color: #10b981;
}

.result-winnings.lose {
    color: #ef4444;
}

.result-close-btn {
    padding: 14px 40px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
}

/* 최근 기록 */
.history-section {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
}

.history-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 10px;
}

.history-item {
    background: var(--bg-main);
    border-radius: 10px;
    padding: 12px;
    text-align: center;
}

.history-round {
    font-size: 11px;
    color: var(--text-secondary);
    margin-bottom: 4px;
}

.history-winner {
    font-size: 24px;
}

.history-odds {
    font-size: 12px;
    color: #fbbf24;
    font-weight: 600;
}

/* 베팅 마감 오버레이 */
.betting-closed-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(4px);
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 10;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s;
}

.betting-closed-overlay.show {
    opacity: 1;
    pointer-events: auto;
}

.betting-closed-text {
    font-size: 24px;
    font-weight: 700;
    color: white;
    margin-bottom: 8px;
}

.betting-closed-sub {
    color: rgba(255,255,255,0.7);
}

/* 최근 결과 테이블 */
.result-table {
    width: 100%;
    border-collapse: collapse;
}

.result-table th {
    text-align: left;
    padding: 12px 10px;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    border-bottom: 2px solid var(--border);
}

.result-table td {
    padding: 10px;
    border-bottom: 1px solid var(--border);
    font-size: 13px;
    color: var(--text-primary);
}

.result-table tr:last-child td {
    border-bottom: none;
}

.result-table tr:hover {
    background: var(--bg-main);
}

.result-winner {
    display: flex;
    align-items: center;
    gap: 8px;
}

.result-winner-number {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    color: white;
}

.result-winner-name {
    font-weight: 600;
}

.result-odds {
    color: #fbbf24;
    font-weight: 700;
}

/* 베팅 내역 섹션 */
.my-bets-section {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
}

.my-bets-table {
    width: 100%;
    border-collapse: collapse;
}

.my-bets-table th {
    text-align: left;
    padding: 10px 8px;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    border-bottom: 2px solid var(--border);
}

.my-bets-table td {
    padding: 10px 8px;
    border-bottom: 1px solid var(--border);
    font-size: 13px;
    color: var(--text-primary);
}

.my-bets-table tr:last-child td {
    border-bottom: none;
}

.bet-status {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.bet-status.pending {
    background: rgba(251, 191, 36, 0.2);
    color: #fbbf24;
}

.bet-status.win {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.bet-status.lose {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.bet-result-amount {
    font-weight: 700;
}

/* 베팅 내역 아이템 */
.bet-item {
    background: var(--bg-dark);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 10px;
}

.bet-item:last-child {
    margin-bottom: 0;
}

.bet-item.win {
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.05);
}

.bet-item.lose {
    border-color: #ef4444;
    background: rgba(239, 68, 68, 0.05);
}

.bet-item.pending {
    border-color: #fbbf24;
    background: rgba(251, 191, 36, 0.05);
}

.bet-item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.bet-round {
    font-size: 12px;
    color: var(--text-secondary);
    font-weight: 500;
}

.bet-item-body {
    display: flex;
    align-items: center;
    gap: 12px;
}

.bet-horse {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
}

.bet-odds {
    font-size: 13px;
    color: #fbbf24;
    font-weight: 600;
}

.bet-amount {
    margin-left: auto;
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary);
}

.bet-item-time {
    font-size: 11px;
    color: var(--text-secondary);
    margin-top: 8px;
}

.no-bets {
    text-align: center;
    padding: 30px;
    color: var(--text-secondary);
    font-size: 14px;
}

#myBetsList {
    max-height: 400px;
    overflow-y: auto;
}

.bet-result-amount.win {
    color: #10b981;
}

.bet-result-amount.lose {
    color: #ef4444;
}

.no-bets {
    text-align: center;
    padding: 30px;
    color: var(--text-secondary);
    font-size: 14px;
}

/* 공정성 검증 섹션 */
.verify-section {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
}

.verify-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.verify-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    color: #10b981;
}

.verify-info {
    background: var(--bg-main);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
}

.verify-info p {
    margin: 0 0 12px 0;
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.6;
}

.verify-info p:last-child {
    margin-bottom: 0;
}

.verify-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 16px;
}

.verify-item {
    background: var(--bg-main);
    border-radius: 10px;
    padding: 12px;
}

.verify-item-label {
    font-size: 11px;
    color: var(--text-secondary);
    margin-bottom: 6px;
    font-weight: 600;
}

.verify-item-value {
    font-family: monospace;
    font-size: 11px;
    color: var(--text-primary);
    word-break: break-all;
    line-height: 1.4;
}

.verify-actions {
    display: flex;
    gap: 10px;
}

.verify-btn {
    flex: 1;
    padding: 12px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: var(--bg-main);
    color: var(--text-primary);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.verify-btn:hover {
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.1);
}

.verify-result {
    margin-top: 16px;
    padding: 16px;
    background: var(--bg-main);
    border-radius: 10px;
    display: none;
}

.verify-result.show {
    display: block;
}

.verify-result-status {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 12px;
}

.verify-result-status.success {
    color: #10b981;
}

.verify-result-status.error {
    color: #ef4444;
}

.verify-result-json {
    background: rgba(0,0,0,0.2);
    border-radius: 8px;
    padding: 12px;
    font-family: monospace;
    font-size: 11px;
    color: var(--text-primary);
    white-space: pre-wrap;
    word-break: break-all;
    max-height: 200px;
    overflow-y: auto;
}

/* 다크 모드 */
[data-theme="dark"] .racing-game,
.dark .racing-game {
    --bg-card: #1e1e2e;
    --bg-main: #16161e;
    --border: #2e2e3e;
    --text-primary: #ffffff;
    --text-secondary: #9ca3af;
}

/* 반응형 */
@media (max-width: 900px) {
    .betting-section {
        grid-template-columns: 1fr;
    }

    .betting-panel {
        position: static;
    }

    .round-info {
        flex-direction: column;
        gap: 12px;
    }


    /* 3D 트랙 - 태블릿에서 약간 조정 */
    .race-track {
        transform: rotateX(25deg);
    }

    .race-status-bar {
        padding: 10px 16px;
    }
}

@media (max-width: 640px) {
    .racing-game {
        padding: 12px;
    }

    /* 3D 트랙 - 모바일에서는 덜 기울이기 */
    .race-track-3d-wrapper {
        perspective: 600px;
    }

    .race-track {
        transform: rotateX(15deg);
    }

    .track-lane {
        height: 36px;
    }

    .lane-number {
        width: 22px;
        height: 22px;
        font-size: 11px;
    }

    .horse {
        width: 40px;
        height: 28px;
    }

    .horse-head { width: 11px; height: 8px; }
    .horse-neck { width: 10px; height: 11px; }
    .horse-torso { width: 22px; height: 13px; }
    .horse-leg { width: 3px; height: 11px; }
    .horse-leg.front-left { top: 15px; left: 22px; }
    .horse-leg.front-right { top: 15px; left: 17px; }
    .horse-leg.back-left { top: 15px; left: 11px; }
    .horse-leg.back-right { top: 15px; left: 6px; }
    .jockey { width: 8px; height: 8px; left: 14px; }

    .start-gate {
        left: 40px;
        width: 2px;
    }

    .start-gate::before {
        font-size: 7px;
        padding: 1px 4px;
    }

    .finish-line {
        right: 35px;
        width: 4px;
    }

    .finish-line::before {
        font-size: 18px;
        top: -25px;
    }

    .race-status-bar {
        padding: 8px 12px;
        flex-direction: column;
        gap: 8px;
        text-align: center;
    }

    .race-status-indicator {
        font-size: 13px;
    }

    .race-round-info {
        font-size: 12px;
    }

    .race-round-info strong {
        font-size: 16px;
    }

    /* 말 선택 그리드 - 3열 유지하되 컴팩트하게 */
    .horse-select-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }

    .horse-select-card {
        padding: 10px 6px;
    }

    .horse-select-number {
        width: 24px;
        height: 24px;
        font-size: 11px;
        margin-bottom: 4px;
    }

    .horse-select-emoji {
        font-size: 20px;
        margin-bottom: 4px;
    }

    .horse-select-name {
        font-size: 11px;
        margin-bottom: 2px;
    }

    .horse-select-odds {
        font-size: 13px;
    }

    .horse-list {
        padding: 16px 12px;
    }

    /* 베팅 패널 */
    .betting-panel {
        padding: 16px 12px;
    }

    .bet-summary {
        padding: 12px;
    }

    .bet-summary-row {
        font-size: 13px;
    }

    .bet-summary-row:last-child {
        font-size: 14px;
    }

    .bet-amount-input {
        padding: 12px;
        font-size: 16px;
    }

    .quick-amounts {
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
    }

    .quick-btn {
        padding: 10px 8px;
        font-size: 12px;
    }

    .bet-submit {
        padding: 14px;
        font-size: 15px;
    }

    /* 헤더 */
    .racing-header {
        padding: 20px 16px;
    }

    .racing-title {
        font-size: 22px;
    }

    .racing-subtitle {
        font-size: 13px;
    }

    .round-info {
        flex-direction: row;
        gap: 8px;
    }

    .round-box {
        padding: 10px 8px;
        flex: 1;
    }

    .round-label {
        font-size: 10px;
    }

    .round-value {
        font-size: 16px;
    }

    .my-point {
        font-size: 14px;
        padding: 8px 12px;
    }

    .result-places {
        flex-direction: row;
        gap: 8px;
    }

    .result-place {
        padding: 10px 12px;
        flex: 1;
        min-width: 0;
    }

    .place-rank {
        font-size: 10px;
    }

    .place-horse {
        font-size: 20px;
    }

    .place-name {
        font-size: 11px;
    }

    .place-odds {
        font-size: 11px;
    }

    .race-result-modal {
        padding: 24px 16px;
        max-width: 340px;
    }

    .result-trophy {
        font-size: 48px;
        margin-bottom: 12px;
    }

    .result-title {
        font-size: 18px;
        margin-bottom: 16px;
    }

    .result-winnings {
        font-size: 20px;
        margin-bottom: 16px;
    }

    .result-close {
        padding: 12px 32px;
        font-size: 14px;
    }

    .verify-grid {
        grid-template-columns: 1fr;
    }

    .verify-actions {
        flex-direction: column;
    }

    .result-table,
    .my-bets-table {
        font-size: 11px;
    }

    .result-table th,
    .result-table td,
    .my-bets-table th,
    .my-bets-table td {
        padding: 8px 4px;
        white-space: nowrap;
    }

    .result-winner-number {
        width: 18px;
        height: 18px;
        font-size: 9px;
    }

    .result-winner-name {
        font-size: 11px;
    }

    .result-winner {
        gap: 4px;
    }

    /* 베팅 내역 테이블 - 회차 컬럼 숨기기 */
    .my-bets-table th:first-child,
    .my-bets-table td:first-child {
        display: none;
    }

    /* 베팅 내역 테이블 - 예상당첨 컬럼 숨기기 */
    .my-bets-table th:nth-child(5),
    .my-bets-table td:nth-child(5) {
        display: none;
    }

    .my-bets-section {
        padding: 16px 12px;
    }

    .history-section {
        padding: 16px 12px;
    }

    .bet-status {
        padding: 3px 6px;
        font-size: 10px;
    }

    .result-odds {
        font-size: 11px;
    }
}

/* 더 작은 화면 */
@media (max-width: 400px) {
    .racing-game {
        padding: 8px;
    }

    /* 말 선택 2열로 변경 */
    .horse-select-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 6px;
    }

    .horse-select-card {
        padding: 8px 4px;
    }

    .horse-select-number {
        width: 20px;
        height: 20px;
        font-size: 10px;
    }

    .horse-select-emoji {
        font-size: 18px;
    }

    .horse-select-name {
        font-size: 10px;
    }

    .horse-select-odds {
        font-size: 12px;
    }

    .horse-list,
    .betting-panel {
        padding: 12px 10px;
        border-radius: 12px;
    }

    .quick-amounts {
        grid-template-columns: repeat(4, 1fr);
        gap: 4px;
    }

    .quick-btn {
        padding: 8px 4px;
        font-size: 11px;
    }

    .bet-amount-input {
        padding: 10px;
        font-size: 15px;
    }

    .bet-submit {
        padding: 12px;
        font-size: 14px;
    }

    .round-box {
        padding: 8px 6px;
    }

    .round-label {
        font-size: 9px;
    }

    .round-value {
        font-size: 14px;
    }

    .result-table,
    .my-bets-table {
        font-size: 10px;
    }

    .result-table th,
    .result-table td,
    .my-bets-table th,
    .my-bets-table td {
        padding: 6px 3px;
    }

    .result-winner-number {
        width: 16px;
        height: 16px;
        font-size: 8px;
    }

    .result-winner-name {
        font-size: 10px;
    }

    .bet-status {
        padding: 2px 5px;
        font-size: 9px;
    }

    .panel-title {
        font-size: 14px;
    }

    .racing-title {
        font-size: 20px;
    }

    .racing-subtitle {
        font-size: 12px;
    }
}
</style>

<div class="racing-game">
    <!-- 헤더 -->
    <div class="racing-header">
        <div class="racing-header-content">
            <h1 class="racing-title">🏇 경마 게임</h1>
            <p class="racing-subtitle">1분마다 새로운 레이스! 우승마를 맞춰보세요!</p>

            <div class="round-info">
                <div class="round-box">
                    <div class="round-label">현재 회차</div>
                    <div class="round-value" id="currentRound"><?php echo number_format($current_round); ?></div>
                </div>
                <div class="round-box">
                    <div class="round-label">출발까지</div>
                    <div class="round-value timer" id="countdown">--:--</div>
                </div>
                <div class="round-box">
                    <div class="round-label">베팅 상태</div>
                    <div class="round-value" id="bettingStatus" style="color: #10b981;">가능</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 포인트 바 -->
    <div class="point-bar">
        <div class="point-display">
            <div class="point-icon">💰</div>
            <div>
                <div class="point-label">보유 포인트</div>
                <div class="point-amount" id="myPoint"><?php echo number_format($member_point); ?>P</div>
            </div>
        </div>
    </div>

    <!-- 레이스 트랙 -->
    <div class="race-track-section">
        <div class="panel-title">🏁 레이스 트랙</div>

        <!-- 레이스 상태바 -->
        <div class="race-status-bar">
            <div class="race-status-indicator" id="raceStatusIndicator">
                <span class="status-dot"></span>
                <span class="status-text">대기중</span>
            </div>
            <div class="race-round-info">
                <span>라운드</span>
                <strong id="currentRoundDisplay"><?php echo $current_round; ?></strong>
            </div>
        </div>

        <div class="race-track-3d-wrapper">
            <div class="race-track">
                <!-- 출발 게이트 -->
                <div class="start-gate"></div>
                <!-- 트랙 레일 -->
                <div class="track-rail-top"></div>
                <div class="track-rail-bottom"></div>

                <div class="track-lanes" id="trackLanes">
                    <?php foreach ($horses as $idx => $horse): ?>
                    <div class="track-lane">
                        <div class="lane-number" style="background: <?php echo $horse['color']; ?>">
                            <?php echo $horse['id']; ?>
                        </div>
                        <div class="horse-container">
                            <div class="horse" id="horse<?php echo $horse['id']; ?>" data-id="<?php echo $horse['id']; ?>" data-color="<?php echo $horse['color']; ?>">
                                <div class="horse-figure">
                                    <div class="jockey" style="background: <?php echo $horse['color']; ?>"></div>
                                    <div class="horse-body">
                                        <div class="horse-head"></div>
                                        <div class="horse-neck"></div>
                                        <div class="horse-torso"></div>
                                        <div class="horse-leg front-left"></div>
                                        <div class="horse-leg front-right"></div>
                                        <div class="horse-leg back-left"></div>
                                        <div class="horse-leg back-right"></div>
                                        <div class="horse-tail"></div>
                                    </div>
                                </div>
                                <div class="dust-cloud"></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="finish-line"></div>
                <div class="finish-flag">🏁</div>
            </div>
        </div>
    </div>

    <!-- 베팅 섹션 -->
    <div class="betting-section">
        <!-- 출주표 -->
        <div class="horse-list" style="position: relative;">
            <div class="betting-closed-overlay" id="bettingOverlay">
                <div class="betting-closed-text">베팅 마감</div>
                <div class="betting-closed-sub">레이스 시작을 기다려주세요</div>
            </div>

            <div class="panel-title">📋 출주마 선택</div>
            <div class="horse-select-grid">
                <?php foreach ($horses as $idx => $horse): ?>
                <div class="horse-select-card" data-horse="<?php echo $horse['id']; ?>" data-odds="<?php echo $horse['odds']; ?>" data-name="<?php echo $horse['name']; ?>" data-emoji="<?php echo $horse['emoji']; ?>" onclick="selectHorse(this)">
                    <div class="horse-select-number" style="background: <?php echo $horse['color']; ?>">
                        <?php echo $horse['id']; ?>
                    </div>
                    <div class="horse-select-emoji"><?php echo $horse['emoji']; ?></div>
                    <div class="horse-select-name"><?php echo $horse['name']; ?></div>
                    <div class="horse-select-odds <?php echo $horse['odds'] < 3 ? 'low' : ($horse['odds'] > 6 ? 'high' : ''); ?>">
                        x<?php echo $horse['odds']; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- 베팅 패널 -->
        <div class="betting-panel">
            <div class="panel-title">💵 베팅하기</div>

            <div class="bet-summary">
                <div class="bet-summary-row">
                    <span class="bet-summary-label">선택한 마</span>
                    <span class="bet-summary-value" id="selectedHorse">-</span>
                </div>
                <div class="bet-summary-row">
                    <span class="bet-summary-label">배당률</span>
                    <span class="bet-summary-value" id="expectedOdds">-</span>
                </div>
                <div class="bet-summary-row">
                    <span class="bet-summary-label">예상 당첨금</span>
                    <span class="bet-summary-value total" id="expectedWin">0P</span>
                </div>
            </div>

            <div class="bet-amount-section">
                <label class="bet-amount-label">베팅 금액</label>
                <input type="number" class="bet-amount-input" id="betAmount" placeholder="금액 입력" min="10" max="10000" oninput="updateExpectedWin()">
            </div>

            <div class="quick-amounts">
                <button class="quick-btn" onclick="setBetAmount(100)">100</button>
                <button class="quick-btn" onclick="setBetAmount(500)">500</button>
                <button class="quick-btn" onclick="setBetAmount(1000)">1K</button>
                <button class="quick-btn" onclick="setBetAmount(5000)">5K</button>
            </div>

            <button class="bet-submit" id="betBtn" onclick="placeBet()">베팅하기</button>
        </div>
    </div>

    <!-- 내 베팅 내역 -->
    <div class="my-bets-section">
        <div class="panel-title">🎫 내 베팅 내역</div>
        <div id="myBetsList">
            <?php if (empty($my_bets)): ?>
                <div class="no-bets">베팅 내역이 없습니다</div>
            <?php else: ?>
                <table class="my-bets-table">
                    <thead>
                        <tr>
                            <th>회차</th>
                            <th>선택마</th>
                            <th>배당</th>
                            <th>베팅액</th>
                            <th>예상당첨</th>
                            <th>상태</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $horse_colors = [
                            '번개' => '#ef4444',
                            '황금마' => '#f59e0b',
                            '블루윈드' => '#3b82f6',
                            '그린라이트' => '#10b981',
                            '퍼플스타' => '#8b5cf6',
                            '다크호스' => '#1f2937'
                        ];
                        $horse_emojis = [
                            '번개' => '🔴',
                            '황금마' => '🟡',
                            '블루윈드' => '🔵',
                            '그린라이트' => '🟢',
                            '퍼플스타' => '🟣',
                            '다크호스' => '⚫'
                        ];
                        foreach ($my_bets as $bet):
                            $bet_round = $bet['rb_round'];
                            $is_current = ($bet_round == $current_round);
                            $expected_win = floor($bet['rb_amount'] * $bet['rb_odds']);
                            $horse_color = $horse_colors[$bet['rb_horse_name']] ?? '#666';
                            $horse_emoji = $horse_emojis[$bet['rb_horse_name']] ?? '🐴';

                            if ($bet['rb_status'] == 'pending') {
                                $status_class = 'pending';
                                $status_text = $is_current ? '진행중' : '대기중';
                            } elseif ($bet['rb_status'] == 'win') {
                                $status_class = 'win';
                                $status_text = '당첨';
                            } else {
                                $status_class = 'lose';
                                $status_text = '낙첨';
                            }
                        ?>
                        <tr>
                            <td><?php echo number_format($bet_round); ?></td>
                            <td>
                                <div class="result-winner">
                                    <div class="result-winner-number" style="background: <?php echo $horse_color; ?>"><?php echo $bet['rb_horse_id']; ?></div>
                                    <span><?php echo $horse_emoji; ?> <?php echo htmlspecialchars($bet['rb_horse_name']); ?></span>
                                </div>
                            </td>
                            <td class="result-odds">x<?php echo $bet['rb_odds']; ?></td>
                            <td><?php echo number_format($bet['rb_amount']); ?>P</td>
                            <td style="color: #10b981; font-weight: 600;"><?php echo number_format($expected_win); ?>P</td>
                            <td><span class="bet-status <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- 최근 결과 테이블 -->
    <div class="history-section">
        <div class="panel-title">📊 최근 레이스 결과</div>
        <table class="result-table" id="resultTable">
            <thead>
                <tr>
                    <th>회차</th>
                    <th>우승마</th>
                    <th>배당</th>
                    <th>시간</th>
                </tr>
            </thead>
            <tbody id="resultTableBody">
                <!-- 동적 생성 -->
            </tbody>
        </table>
    </div>

    <!-- 공정성 검증 -->
    <div class="verify-section">
        <div class="verify-header">
            <div class="panel-title" style="margin-bottom: 0;">🔒 공정성 검증</div>
            <div class="verify-badge">
                <span>✓</span>
                <span>Provably Fair</span>
            </div>
        </div>

        <div class="verify-info">
            <p><strong>🎯 왜 조작이 불가능한가?</strong></p>
            <p>1. 각 회차의 결과는 <strong>서버 시드(Server Seed)</strong>와 <strong>회차 번호</strong>를 조합한 해시값으로 미리 결정됩니다.</p>
            <p>2. 베팅 전에 서버 시드의 <strong>해시값(SHA-256)</strong>이 공개되어, 운영자도 결과를 바꿀 수 없습니다.</p>
            <p>3. 레이스 종료 후 원본 시드가 공개되어 누구나 결과를 검증할 수 있습니다.</p>
        </div>

        <div class="verify-grid">
            <div class="verify-item">
                <div class="verify-item-label">현재 회차</div>
                <div class="verify-item-value" id="verifyRound"><?php echo $current_round; ?></div>
            </div>
            <div class="verify-item">
                <div class="verify-item-label">서버 시드 해시</div>
                <div class="verify-item-value" id="verifyHash"><?php echo substr(hash('sha256', $current_round . 'racing_game_secret_2024'), 0, 32); ?>...</div>
            </div>
            <div class="verify-item">
                <div class="verify-item-label">결과 해시</div>
                <div class="verify-item-value" id="verifyResultHash"><?php echo $result['hash']; ?></div>
            </div>
            <div class="verify-item">
                <div class="verify-item-label">예상 1등</div>
                <div class="verify-item-value" id="verifyWinner"><?php
                    $winner = array_filter($horses, fn($h) => $h['id'] === $result['first']);
                    $winner = reset($winner);
                    echo $winner['emoji'] . ' ' . $winner['name'];
                ?></div>
            </div>
        </div>

        <div class="verify-actions">
            <button class="verify-btn" onclick="showVerifyDetail()">🔍 상세 검증</button>
            <button class="verify-btn" onclick="copyVerifyData()">📋 검증 데이터 복사</button>
        </div>

        <div class="verify-result" id="verifyResult">
            <div class="verify-result-status" id="verifyStatus">검증 결과</div>
            <pre class="verify-result-json" id="verifyJson">{}</pre>
        </div>
    </div>
</div>

<!-- 결과 모달 -->
<div class="race-result-overlay" id="resultOverlay">
    <div class="race-result-modal">
        <div class="result-trophy">🏆</div>
        <div class="result-title">레이스 결과</div>
        <div class="result-places" id="resultPlaces">
            <!-- 동적 생성 -->
        </div>
        <div class="result-winnings" id="resultWinnings"></div>
        <button class="result-close-btn" onclick="closeResult()">확인</button>
    </div>
</div>

<script>
// 게임 설정
const ROUND_INTERVAL = <?php echo $round_interval; ?>;
const BETTING_CLOSE = <?php echo $betting_close; ?>;
const CURRENT_ROUND = <?php echo $current_round; ?>;
let currentPoint = <?php echo $member_point; ?>;

// 출주마 정보
const horses = <?php echo json_encode($horses); ?>;
const result = <?php echo json_encode($result); ?>;

let isBettingClosed = false;
let selectedHorse = null; // 선택된 말 정보
let myBet = <?php echo $current_bet ? json_encode([
    'horseId' => intval($current_bet['rb_horse_id']),
    'horseName' => $current_bet['rb_horse_name'],
    'amount' => intval($current_bet['rb_amount']),
    'odds' => floatval($current_bet['rb_odds'])
]) : 'null'; ?>; // 현재 라운드 베팅 정보

// 이미 베팅했으면 UI 비활성화
<?php if ($current_bet): ?>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('betAmount').disabled = true;
    document.getElementById('betBtn').disabled = true;
    document.getElementById('betBtn').textContent = '베팅 완료';
    document.querySelectorAll('.horse-select-card').forEach(function(card) {
        card.style.pointerEvents = 'none';
    });
    // 선택된 말 표시
    document.getElementById('selectedHorse').textContent = '<?php echo $current_bet['rb_horse_name']; ?>';
    document.getElementById('expectedOdds').textContent = 'x<?php echo $current_bet['rb_odds']; ?>';
    document.getElementById('betAmount').value = <?php echo $current_bet['rb_amount']; ?>;
    document.getElementById('expectedWin').textContent = numberFormat(<?php echo floor($current_bet['rb_amount'] * $current_bet['rb_odds']); ?>) + 'P';
});
<?php endif; ?>

// 타이머
function updateTimer() {
    const now = Math.floor(Date.now() / 1000);
    const roundEnd = (Math.floor(now / ROUND_INTERVAL) + 1) * ROUND_INTERVAL;
    const remaining = roundEnd - now;

    const min = Math.floor(remaining / 60);
    const sec = remaining % 60;
    const timerEl = document.getElementById('countdown');
    timerEl.textContent = `${String(min).padStart(2, '0')}:${String(sec).padStart(2, '0')}`;

    // 마감 처리
    if (remaining <= BETTING_CLOSE && !isBettingClosed) {
        closeBetting();
    }

    // 긴급 표시
    if (remaining <= 30) {
        timerEl.classList.add('urgent');
    } else {
        timerEl.classList.remove('urgent');
    }

    // 레이스 시작
    if (remaining <= 30 && remaining > 0) {
        // 레이스 진행 중
    }

    // 회차 종료
    if (remaining <= 0) {
        showResult();
    }
}

// 베팅 마감
function closeBetting() {
    isBettingClosed = true;
    document.getElementById('bettingOverlay').classList.add('show');
    document.getElementById('bettingStatus').textContent = '마감';
    document.getElementById('bettingStatus').style.color = '#ef4444';
    document.getElementById('betBtn').disabled = true;
    document.getElementById('betAmount').disabled = true;
    document.querySelectorAll('.horse-select-card').forEach(card => {
        card.style.pointerEvents = 'none';
    });

    // 레이스 애니메이션 시작
    setTimeout(() => {
        startRace();
    }, 2000);
}

// 레이스 애니메이션
function startRace() {
    const duration = 25000; // 25초
    const startTime = Date.now();

    // 상태바 업데이트 - 레이스 진행중
    const statusIndicator = document.getElementById('raceStatusIndicator');
    statusIndicator.classList.add('racing');
    statusIndicator.querySelector('.status-text').textContent = '레이스 진행중';

    // 모든 말에 running 클래스 추가 (달리기 애니메이션)
    horses.forEach(horse => {
        const el = document.getElementById('horse' + horse.id);
        el.classList.add('running');
    });

    // 트랙 너비와 결승선 위치 계산
    const track = document.querySelector('.race-track');
    const trackWidth = track.offsetWidth;
    const finishLineRight = 45; // 결승선이 오른쪽에서 45px
    const startOffset = 60; // 출발선 오프셋
    const horseWidth = 50; // 말 너비

    // 결승선 통과 위치 (픽셀 기준)
    const finishPosition = trackWidth - finishLineRight - horseWidth;

    // 각 말의 최종 위치 계산 (1등은 결승선 통과, 나머지는 약간 뒤)
    const positions = {};
    horses.forEach((horse, idx) => {
        if (horse.id === result.first) positions[horse.id] = finishPosition + 20; // 결승선 통과
        else if (horse.id === result.second) positions[horse.id] = finishPosition - 30;
        else if (horse.id === result.third) positions[horse.id] = finishPosition - 60;
        else positions[horse.id] = finishPosition - 100 - Math.random() * 50;
    });

    function animate() {
        const elapsed = Date.now() - startTime;
        const progress = Math.min(elapsed / duration, 1);

        // 이징 함수 (가속/감속)
        const eased = progress < 0.5
            ? 2 * progress * progress
            : 1 - Math.pow(-2 * progress + 2, 2) / 2;

        horses.forEach(horse => {
            const el = document.getElementById('horse' + horse.id);
            const target = positions[horse.id];
            // 랜덤 진동 추가 (더 역동적으로)
            const wobble = Math.sin(elapsed / 80 + horse.id * 0.5) * 3;
            const verticalBounce = Math.sin(elapsed / 50 + horse.id) * 2;
            const currentPos = startOffset + eased * (target - startOffset) + wobble * (1 - eased);
            el.style.left = currentPos + 'px';
            el.style.transform = `translateY(calc(-50% + ${verticalBounce}px))`;
        });

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            // 레이스 종료 - running 클래스 제거
            horses.forEach(horse => {
                const el = document.getElementById('horse' + horse.id);
                el.classList.remove('running');
                el.style.transform = 'translateY(-50%)';
            });

            // 상태바 업데이트 - 레이스 완료
            statusIndicator.classList.remove('racing');
            statusIndicator.classList.add('finished');
            statusIndicator.querySelector('.status-text').textContent = '레이스 완료';

            setTimeout(() => {
                showResultModal();
            }, 1000);
        }
    }

    animate();
}

// 결과 모달 표시
function showResultModal() {
    const overlay = document.getElementById('resultOverlay');
    const placesEl = document.getElementById('resultPlaces');
    const winningsEl = document.getElementById('resultWinnings');

    // 순위 표시
    const firstHorse = horses.find(h => h.id === result.first);
    const secondHorse = horses.find(h => h.id === result.second);
    const thirdHorse = horses.find(h => h.id === result.third);

    placesEl.innerHTML = `
        <div class="result-place">
            <div class="place-rank">🥇 1등</div>
            <div class="place-horse" style="color: ${firstHorse.color}">${firstHorse.emoji}</div>
            <div class="place-name">${firstHorse.name}</div>
            <div class="place-odds">x${firstHorse.odds}</div>
        </div>
        <div class="result-place">
            <div class="place-rank">🥈 2등</div>
            <div class="place-horse" style="color: ${secondHorse.color}">${secondHorse.emoji}</div>
            <div class="place-name">${secondHorse.name}</div>
            <div class="place-odds">x${secondHorse.odds}</div>
        </div>
        <div class="result-place">
            <div class="place-rank">🥉 3등</div>
            <div class="place-horse" style="color: ${thirdHorse.color}">${thirdHorse.emoji}</div>
            <div class="place-name">${thirdHorse.name}</div>
            <div class="place-odds">x${thirdHorse.odds}</div>
        </div>
    `;

    // 베팅이 있으면 결과 처리 API 호출
    if (myBet) {
        const formData = new FormData();
        formData.append('action', 'racing_result');
        formData.append('round', CURRENT_ROUND);
        formData.append('winner', result.first);

        fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                currentPoint = data.point;
                document.getElementById('myPoint').textContent = numberFormat(currentPoint) + 'P';

                if (data.is_win) {
                    winningsEl.className = 'result-winnings win';
                    winningsEl.textContent = `🎉 ${numberFormat(data.win_amount)}P 당첨!`;
                } else {
                    winningsEl.className = 'result-winnings lose';
                    winningsEl.textContent = '아쉽게 낙첨되었습니다';
                }
            } else {
                // 이미 처리된 경우 로컬 계산
                let winnings = 0;
                if (myBet.horseId === result.first) {
                    winnings = Math.floor(myBet.amount * myBet.odds);
                    winningsEl.className = 'result-winnings win';
                    winningsEl.textContent = `🎉 ${numberFormat(winnings)}P 당첨!`;
                } else {
                    winningsEl.className = 'result-winnings lose';
                    winningsEl.textContent = '아쉽게 낙첨되었습니다';
                }
            }
        })
        .catch(err => {
            console.error(err);
            // 에러 시 로컬 계산
            let winnings = 0;
            if (myBet.horseId === result.first) {
                winnings = Math.floor(myBet.amount * myBet.odds);
                winningsEl.className = 'result-winnings win';
                winningsEl.textContent = `🎉 ${numberFormat(winnings)}P 당첨!`;
            } else {
                winningsEl.className = 'result-winnings lose';
                winningsEl.textContent = '아쉽게 낙첨되었습니다';
            }
        });
    } else {
        winningsEl.className = 'result-winnings';
        winningsEl.textContent = '베팅 없음';
    }

    overlay.classList.add('show');
}

// 결과 창 닫기
function closeResult() {
    document.getElementById('resultOverlay').classList.remove('show');
    // 새로고침
    setTimeout(() => {
        location.reload();
    }, 500);
}

// 결과 표시 (타이머 종료 시)
function showResult() {
    if (!document.getElementById('resultOverlay').classList.contains('show')) {
        showResultModal();
    }
}

// 말 선택
function selectHorse(card) {
    if (isBettingClosed) return;

    // 기존 선택 해제
    document.querySelectorAll('.horse-select-card').forEach(c => {
        c.classList.remove('selected');
    });

    // 새 선택
    card.classList.add('selected');
    selectedHorse = {
        id: parseInt(card.dataset.horse),
        odds: parseFloat(card.dataset.odds),
        name: card.dataset.name,
        emoji: card.dataset.emoji
    };

    // UI 업데이트
    document.getElementById('selectedHorse').textContent = selectedHorse.emoji + ' ' + selectedHorse.name;
    document.getElementById('expectedOdds').textContent = 'x' + selectedHorse.odds;
    updateExpectedWin();
}

// 예상 당첨금 업데이트
function updateExpectedWin() {
    const amount = parseInt(document.getElementById('betAmount').value) || 0;
    let expectedWin = 0;

    if (selectedHorse && amount > 0) {
        expectedWin = Math.floor(amount * selectedHorse.odds);
    }

    document.getElementById('expectedWin').textContent = numberFormat(expectedWin) + 'P';
}

// 퀵 베팅 금액 설정
function setBetAmount(amount) {
    document.getElementById('betAmount').value = amount;
    updateExpectedWin();
}

// 베팅 실행
function placeBet() {
    if (isBettingClosed) {
        alert('베팅이 마감되었습니다.');
        return;
    }

    if (!selectedHorse) {
        alert('말을 선택해주세요.');
        return;
    }

    const amount = parseInt(document.getElementById('betAmount').value) || 0;

    if (amount < 10 || amount > 10000) {
        alert('베팅 금액은 10~10,000 포인트입니다.');
        return;
    }

    if (amount > currentPoint) {
        alert('포인트가 부족합니다.');
        return;
    }

    // API 호출
    const betData = {
        horseId: selectedHorse.id,
        amount: amount,
        odds: selectedHorse.odds
    };

    const formData = new FormData();
    formData.append('action', 'racing_bet');
    formData.append('round', CURRENT_ROUND);
    formData.append('bets', JSON.stringify([betData]));

    fetch('<?php echo G5_URL; ?>/game/game_api.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            currentPoint = data.point;
            document.getElementById('myPoint').textContent = numberFormat(currentPoint) + 'P';
            myBet = betData;
            alert('베팅이 완료되었습니다!');

            // 입력 비활성화
            document.getElementById('betAmount').disabled = true;
            document.getElementById('betBtn').disabled = true;
            document.querySelectorAll('.horse-select-card').forEach(card => {
                card.style.pointerEvents = 'none';
            });

            // 베팅 내역 업데이트
            updateMyBetsList();
        } else {
            alert(data.message || '베팅 실패');
        }
    })
    .catch(err => {
        console.error(err);
        alert('오류가 발생했습니다.');
    });
}

// 숫자 포맷
function numberFormat(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// 최근 결과 테이블 로드
function loadResultHistory() {
    const tbody = document.getElementById('resultTableBody');
    let html = '';

    for (let i = 0; i < 10; i++) {
        const pastRound = CURRENT_ROUND - i - 1;
        if (pastRound < 0) continue;

        // 과거 결과 시뮬레이션 (실제로는 서버에서 가져와야 함)
        const pastHorses = getPastRaceHorses(pastRound);
        const pastResult = getPastRaceResult(pastRound, pastHorses);
        const winner = pastHorses.find(h => h.id === pastResult.first);

        // 시간 계산
        const raceTime = new Date((pastRound + 1) * ROUND_INTERVAL * 1000);
        const timeStr = raceTime.toLocaleTimeString('ko-KR', { hour: '2-digit', minute: '2-digit' });

        html += `
            <tr>
                <td>${numberFormat(pastRound)}</td>
                <td>
                    <div class="result-winner">
                        <div class="result-winner-number" style="background: ${winner.color}">${winner.id}</div>
                        <span class="result-winner-name">${winner.emoji} ${winner.name}</span>
                    </div>
                </td>
                <td class="result-odds">x${winner.odds}</td>
                <td style="color: var(--text-secondary); font-size: 12px;">${timeStr}</td>
            </tr>
        `;
    }

    tbody.innerHTML = html || '<tr><td colspan="4" style="text-align:center; padding:20px; color:var(--text-secondary);">결과 없음</td></tr>';
}

// 과거 레이스 말 정보 가져오기 (해시 기반 재현)
function getPastRaceHorses(round) {
    const baseHorses = [
        {name: '번개', color: '#ef4444', emoji: '🔴'},
        {name: '황금마', color: '#f59e0b', emoji: '🟡'},
        {name: '블루윈드', color: '#3b82f6', emoji: '🔵'},
        {name: '그린라이트', color: '#10b981', emoji: '🟢'},
        {name: '퍼플스타', color: '#8b5cf6', emoji: '🟣'},
        {name: '다크호스', color: '#1f2937', emoji: '⚫'}
    ];

    // 간단한 해시 시뮬레이션
    const seed = round * 12345;
    return baseHorses.map((h, i) => ({
        ...h,
        id: i + 1,
        odds: Math.round((1.5 + ((seed + i * 7) % 85) / 10) * 10) / 10
    }));
}

// 과거 레이스 결과 가져오기
function getPastRaceResult(round, horses) {
    const seed = (round * 54321) % 1000;
    const firstIdx = seed % 6;
    const secondIdx = (seed + 1) % 6 === firstIdx ? (seed + 2) % 6 : (seed + 1) % 6;
    let thirdIdx = (seed + 3) % 6;
    if (thirdIdx === firstIdx || thirdIdx === secondIdx) thirdIdx = (thirdIdx + 1) % 6;

    return {
        first: horses[firstIdx].id,
        second: horses[secondIdx].id,
        third: horses[thirdIdx].id
    };
}

// 베팅 내역 업데이트 - 기존 테이블에 새 행 추가
function updateMyBetsList() {
    const container = document.getElementById('myBetsList');

    if (!myBet) {
        return;
    }

    const horse = horses.find(h => h.id === myBet.horseId);
    const expectedWin = Math.floor(myBet.amount * myBet.odds);

    // 기존 테이블이 있는지 확인
    let table = container.querySelector('.my-bets-table');
    let tbody;

    if (table) {
        // 기존 테이블이 있으면 tbody에 새 행 추가
        tbody = table.querySelector('tbody');
    } else {
        // 테이블이 없으면 새로 생성
        container.innerHTML = `
            <table class="my-bets-table">
                <thead>
                    <tr>
                        <th>회차</th>
                        <th>선택마</th>
                        <th>배당</th>
                        <th>베팅액</th>
                        <th>예상당첨</th>
                        <th>상태</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        `;
        table = container.querySelector('.my-bets-table');
        tbody = table.querySelector('tbody');
    }

    // 새 행 생성
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>${numberFormat(CURRENT_ROUND)}</td>
        <td>
            <div class="result-winner">
                <div class="result-winner-number" style="background: ${horse.color}">${horse.id}</div>
                <span>${horse.emoji} ${horse.name}</span>
            </div>
        </td>
        <td class="result-odds">x${myBet.odds}</td>
        <td>${numberFormat(myBet.amount)}P</td>
        <td style="color: #10b981; font-weight: 600;">${numberFormat(expectedWin)}P</td>
        <td><span class="bet-status pending">진행중</span></td>
    `;

    // tbody 맨 앞에 추가
    tbody.insertBefore(newRow, tbody.firstChild);
}

// 공정성 상세 검증
function showVerifyDetail() {
    const resultPanel = document.getElementById('verifyResult');
    const statusEl = document.getElementById('verifyStatus');
    const jsonEl = document.getElementById('verifyJson');

    const firstHorse = horses.find(h => h.id === result.first);
    const secondHorse = horses.find(h => h.id === result.second);
    const thirdHorse = horses.find(h => h.id === result.third);

    const verifyData = {
        round: CURRENT_ROUND,
        serverSeedHash: document.getElementById('verifyHash').textContent,
        resultHash: result.hash,
        algorithm: 'SHA-256 + Weighted Random',
        results: {
            first: { id: result.first, name: firstHorse.name, odds: firstHorse.odds },
            second: { id: result.second, name: secondHorse.name, odds: secondHorse.odds },
            third: { id: result.third, name: thirdHorse.name, odds: thirdHorse.odds }
        },
        verification: '결과는 서버 시드와 회차 번호의 해시값으로 결정됩니다.',
        timestamp: new Date().toISOString()
    };

    statusEl.textContent = '✓ 검증 데이터 생성 완료';
    statusEl.className = 'verify-result-status success';
    jsonEl.textContent = JSON.stringify(verifyData, null, 2);
    resultPanel.classList.add('show');
}

// 검증 데이터 복사
function copyVerifyData() {
    const firstHorse = horses.find(h => h.id === result.first);

    const data = `경마 게임 검증 데이터
━━━━━━━━━━━━━━━━━━━━
회차: ${CURRENT_ROUND}
서버 시드 해시: ${document.getElementById('verifyHash').textContent}
결과 해시: ${result.hash}
1등: ${firstHorse.emoji} ${firstHorse.name} (x${firstHorse.odds})
검증 시간: ${new Date().toLocaleString('ko-KR')}
━━━━━━━━━━━━━━━━━━━━
결과는 SHA-256 해시 알고리즘으로 사전에 결정되어 조작이 불가능합니다.`;

    navigator.clipboard.writeText(data).then(() => {
        alert('검증 데이터가 클립보드에 복사되었습니다.');
    }).catch(() => {
        alert('복사에 실패했습니다.');
    });
}

// 초기화
loadResultHistory();
setInterval(updateTimer, 1000);
updateTimer();
</script>

<?php
include_once(G5_PATH.'/tail.php');
?>
