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
        $round_num = $current_round - $i;
        $r = get_ladder_result($round_num);
        $r['round'] = $round_num;
        $results[] = $r;
    }
    return $results;
}

$result = get_ladder_result($current_round);
$recent_results = get_recent_results($current_round, 10);

// 사다리 베팅 테이블 자동 생성
$ladder_table = $g5['write_prefix'] . 'game_ladder_bet';
$check_table = sql_query("SHOW TABLES LIKE '{$ladder_table}'");
if (sql_num_rows($check_table) == 0) {
    sql_query("CREATE TABLE IF NOT EXISTS `{$ladder_table}` (
        `lb_id` int(11) NOT NULL AUTO_INCREMENT,
        `mb_id` varchar(20) NOT NULL DEFAULT '',
        `mb_nick` varchar(40) NOT NULL DEFAULT '',
        `lb_round` int(11) NOT NULL DEFAULT 0,
        `lb_bet_type` varchar(20) NOT NULL DEFAULT '',
        `lb_bet_value` varchar(20) NOT NULL DEFAULT '',
        `lb_amount` int(11) NOT NULL DEFAULT 0,
        `lb_odds` decimal(5,2) NOT NULL DEFAULT 0,
        `lb_status` enum('pending','win','lose') NOT NULL DEFAULT 'pending',
        `lb_win_amount` int(11) NOT NULL DEFAULT 0,
        `lb_datetime` datetime NOT NULL,
        PRIMARY KEY (`lb_id`),
        KEY `idx_mb_id` (`mb_id`),
        KEY `idx_lb_round` (`lb_round`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

// 과거 pending 베팅 자동 처리
$pending_sql = sql_query("SELECT * FROM {$ladder_table} WHERE mb_id = '{$member['mb_id']}' AND lb_status = 'pending' AND lb_round < {$current_round}");
while ($bet = sql_fetch_array($pending_sql)) {
    $bet_result = get_ladder_result($bet['lb_round']);
    $is_win = false;

    if ($bet['lb_bet_type'] == 'start') {
        $is_win = ($bet['lb_bet_value'] == '0' && $bet_result['start'] == 0) ||
                  ($bet['lb_bet_value'] == '1' && $bet_result['start'] == 1);
    } else if ($bet['lb_bet_type'] == 'oe') {
        $is_win = ($bet['lb_bet_value'] == '1' && $bet_result['odd_even'] == 1) ||
                  ($bet['lb_bet_value'] == '0' && $bet_result['odd_even'] == 0);
    } else if ($bet['lb_bet_type'] == 'line') {
        $is_win = ($bet['lb_bet_value'] == '3' && $bet_result['lines'] == 3) ||
                  ($bet['lb_bet_value'] == '4' && $bet_result['lines'] == 4);
    }

    if ($is_win) {
        $win_amount = floor($bet['lb_amount'] * $bet['lb_odds']);
        sql_query("UPDATE {$ladder_table} SET lb_status = 'win', lb_win_amount = {$win_amount} WHERE lb_id = {$bet['lb_id']}");
        sql_query("UPDATE {$g5['member_table']} SET mb_point = mb_point + {$win_amount} WHERE mb_id = '{$member['mb_id']}'");
        $member_point += $win_amount;

        // 게임 로그
        $profit = $win_amount - $bet['lb_amount'];
        sql_query("INSERT INTO {$g5['write_prefix']}game_log SET
            mb_id = '{$member['mb_id']}', mb_nick = '".addslashes($member['mb_nick'])."',
            gl_game = 'ladder', gl_bet_type = '{$bet['lb_bet_type']}:{$bet['lb_bet_value']}',
            gl_bet_amount = {$bet['lb_amount']}, gl_result = 'win', gl_win_amount = {$win_amount},
            gl_profit = {$profit}, gl_datetime = '{$bet['lb_datetime']}'");
    } else {
        sql_query("UPDATE {$ladder_table} SET lb_status = 'lose' WHERE lb_id = {$bet['lb_id']}");
        sql_query("INSERT INTO {$g5['write_prefix']}game_log SET
            mb_id = '{$member['mb_id']}', mb_nick = '".addslashes($member['mb_nick'])."',
            gl_game = 'ladder', gl_bet_type = '{$bet['lb_bet_type']}:{$bet['lb_bet_value']}',
            gl_bet_amount = {$bet['lb_amount']}, gl_result = 'lose', gl_win_amount = 0,
            gl_profit = -{$bet['lb_amount']}, gl_datetime = '{$bet['lb_datetime']}'");
    }
}

// 내 베팅 내역 조회
$my_bets = [];
$my_bets_sql = sql_query("SELECT * FROM {$ladder_table} WHERE mb_id = '{$member['mb_id']}' ORDER BY lb_datetime DESC LIMIT 20");
while ($row = sql_fetch_array($my_bets_sql)) {
    $my_bets[] = $row;
}

// 베팅 라벨
$bet_type_labels = ['start' => '출발점', 'oe' => '홀짝', 'line' => '줄수'];
$bet_value_labels = ['0' => '좌/짝', '1' => '우/홀', '3' => '3줄', '4' => '4줄'];
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700;900&family=Orbitron:wght@700;900&display=swap');

* { box-sizing: border-box; }

.ladder-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 30px 20px;
    background: linear-gradient(135deg, #0f0c29 0%, #1a1a3e 50%, #24243e 100%);
    min-height: 100vh;
    font-family: 'Noto Sans KR', sans-serif;
    position: relative;
}

/* 배경 효과 */
.ladder-page::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background:
        radial-gradient(ellipse at 20% 20%, rgba(120, 80, 200, 0.15) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 80%, rgba(80, 120, 200, 0.1) 0%, transparent 50%),
        radial-gradient(ellipse at 50% 50%, rgba(255, 215, 0, 0.05) 0%, transparent 60%);
    pointer-events: none;
}

/* 메인 레이아웃 */
.ladder-main {
    display: grid;
    grid-template-columns: 520px 320px;
    gap: 24px;
    justify-content: center;
    position: relative;
    z-index: 1;
}

/* 패널 스타일 - 프리미엄 다크 */
.panel-frame {
    position: relative;
    background: linear-gradient(165deg, rgba(30, 30, 60, 0.95) 0%, rgba(20, 20, 45, 0.98) 100%);
    border: 2px solid transparent;
    border-radius: 20px;
    box-shadow:
        0 20px 60px rgba(0,0,0,0.5),
        0 0 0 1px rgba(255,255,255,0.05),
        inset 0 1px 0 rgba(255,255,255,0.1);
    overflow: visible;
    backdrop-filter: blur(10px);
}

/* 골드 테두리 효과 */
.panel-frame::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, #ffd700 0%, #b8860b 25%, #ffd700 50%, #b8860b 75%, #ffd700 100%);
    border-radius: 22px;
    z-index: -1;
    opacity: 0.8;
}

.panel-frame::after {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,215,0,0.5), transparent);
}

.corner-bl, .corner-br { display: none; }

/* 게임 패널 */
.game-panel {
    padding: 24px 28px 28px;
}

/* 헤더 */
.game-header {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(255,215,0,0.2);
}

.game-header h2 {
    margin: 0;
    font-size: 13px;
    font-weight: 600;
    color: #a0a0c0;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.game-header .current-time {
    font-family: 'Orbitron', sans-serif;
    font-size: 22px;
    font-weight: 700;
    color: #ffd700;
    margin-top: 6px;
    text-shadow: 0 0 20px rgba(255,215,0,0.3);
}

/* 프리미엄 사다리 영역 */
.ladder-game {
    position: relative;
    max-width: 440px;
    margin: 0 auto;
    padding: 20px 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.1) 100%);
    border-radius: 16px;
    border: 1px solid rgba(255,215,0,0.1);
}

/* 시작점 영역 */
.start-points {
    display: flex;
    justify-content: space-between;
    padding: 0 60px;
    margin-bottom: 20px;
}

.start-point {
    width: 64px;
    height: 64px;
    background: linear-gradient(180deg, #2a2a50 0%, #1a1a35 100%);
    border: 3px solid #3a3a60;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 900;
    color: #6a6a90;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow:
        0 4px 15px rgba(0,0,0,0.3),
        inset 0 2px 4px rgba(255,255,255,0.05);
    position: relative;
}

.start-point::after {
    content: '';
    position: absolute;
    inset: 4px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 0%, transparent 60%);
}

.start-point.left-active {
    background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
    border-color: #60a5fa;
    color: #fff;
    box-shadow:
        0 0 40px rgba(59, 130, 246, 0.6),
        0 0 80px rgba(59, 130, 246, 0.3),
        inset 0 2px 4px rgba(255,255,255,0.2);
    transform: scale(1.15);
    animation: pulseBlue 1.5s ease-in-out infinite;
}

.start-point.right-active {
    background: linear-gradient(180deg, #ef4444 0%, #b91c1c 100%);
    border-color: #f87171;
    color: #fff;
    box-shadow:
        0 0 40px rgba(239, 68, 68, 0.6),
        0 0 80px rgba(239, 68, 68, 0.3),
        inset 0 2px 4px rgba(255,255,255,0.2);
    transform: scale(1.15);
    animation: pulseRed 1.5s ease-in-out infinite;
}

@keyframes pulseBlue {
    0%, 100% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.6), 0 0 80px rgba(59, 130, 246, 0.3); }
    50% { box-shadow: 0 0 50px rgba(59, 130, 246, 0.8), 0 0 100px rgba(59, 130, 246, 0.4); }
}

@keyframes pulseRed {
    0%, 100% { box-shadow: 0 0 40px rgba(239, 68, 68, 0.6), 0 0 80px rgba(239, 68, 68, 0.3); }
    50% { box-shadow: 0 0 50px rgba(239, 68, 68, 0.8), 0 0 100px rgba(239, 68, 68, 0.4); }
}

/* 사다리 캔버스 영역 */
.ladder-canvas-wrap {
    position: relative;
    height: 220px;
    margin: 0 75px;
    background: linear-gradient(180deg, rgba(255,215,0,0.02) 0%, rgba(255,215,0,0.05) 100%);
    border-radius: 12px;
    border: 1px solid rgba(255,215,0,0.1);
}

#ladderCanvas {
    width: 100%;
    height: 100%;
    display: block;
}

/* 사다리 타는 공 - 골드 프리미엄 */
.ladder-ball {
    position: absolute;
    width: 36px;
    height: 36px;
    background: radial-gradient(circle at 30% 30%, #fffacd, #ffd700, #daa520);
    border-radius: 50%;
    box-shadow:
        0 0 30px rgba(255, 215, 0, 0.8),
        0 0 60px rgba(255, 215, 0, 0.4),
        0 4px 15px rgba(0,0,0,0.4),
        inset 0 -4px 8px rgba(0,0,0,0.2),
        inset 0 4px 8px rgba(255,255,255,0.6);
    transform: translate(-50%, -50%);
    z-index: 20;
    opacity: 0;
    transition: opacity 0.3s;
}

.ladder-ball.visible {
    opacity: 1;
    animation: ballGlow 0.5s ease-in-out infinite alternate;
}

@keyframes ballGlow {
    from { box-shadow: 0 0 30px rgba(255, 215, 0, 0.8), 0 0 60px rgba(255, 215, 0, 0.4); }
    to { box-shadow: 0 0 40px rgba(255, 215, 0, 1), 0 0 80px rgba(255, 215, 0, 0.6); }
}

/* 도착점 영역 */
.end-points {
    display: flex;
    justify-content: space-between;
    padding: 0 60px;
    margin-top: 20px;
}

.end-point {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.end-marker {
    width: 64px;
    height: 64px;
    background: linear-gradient(180deg, #2a2a50 0%, #1a1a35 100%);
    border: 3px solid #3a3a60;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 900;
    color: #6a6a90;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow:
        0 4px 15px rgba(0,0,0,0.3),
        inset 0 2px 4px rgba(255,255,255,0.05);
    position: relative;
}

.end-marker::after {
    content: '';
    position: absolute;
    inset: 4px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 0%, transparent 60%);
}

.end-marker.odd-active {
    background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
    border-color: #60a5fa;
    color: #fff;
    box-shadow:
        0 0 40px rgba(59, 130, 246, 0.6),
        0 0 80px rgba(59, 130, 246, 0.3),
        inset 0 2px 4px rgba(255,255,255,0.2);
    transform: scale(1.15);
    animation: pulseBlue 1.5s ease-in-out infinite;
}

.end-marker.even-active {
    background: linear-gradient(180deg, #ef4444 0%, #b91c1c 100%);
    border-color: #f87171;
    color: #fff;
    box-shadow:
        0 0 40px rgba(239, 68, 68, 0.6),
        0 0 80px rgba(239, 68, 68, 0.3),
        inset 0 2px 4px rgba(255,255,255,0.2);
    transform: scale(1.15);
    animation: pulseRed 1.5s ease-in-out infinite;
}

.end-label {
    font-size: 11px;
    font-weight: 700;
    color: #6a6a90;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* 카운트다운 - 프리미엄 */
.countdown-area {
    margin-top: 24px;
    display: flex;
    justify-content: center;
}

.countdown-box {
    background: linear-gradient(180deg, rgba(30,30,60,0.9) 0%, rgba(20,20,45,0.95) 100%);
    border: 2px solid rgba(255,215,0,0.3);
    border-radius: 30px;
    padding: 14px 40px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #c0c0e0;
    font-size: 14px;
    font-weight: 700;
    box-shadow:
        0 8px 30px rgba(0,0,0,0.4),
        inset 0 1px 0 rgba(255,255,255,0.05);
}

.countdown-time {
    font-family: 'Orbitron', sans-serif;
    color: #ffd700;
    font-size: 26px;
    font-weight: 900;
    text-shadow: 0 0 20px rgba(255,215,0,0.5);
    min-width: 70px;
    text-align: center;
}

.countdown-box.urgent {
    background: linear-gradient(180deg, rgba(180,30,30,0.9) 0%, rgba(120,20,20,0.95) 100%);
    border-color: #ef4444;
    animation: urgentPulse 0.5s ease-in-out infinite alternate;
}

.countdown-box.urgent .countdown-time {
    color: #ff6b6b;
    text-shadow: 0 0 20px rgba(255,100,100,0.7);
}

@keyframes urgentPulse {
    from { transform: scale(1); box-shadow: 0 8px 30px rgba(239,68,68,0.3); }
    to { transform: scale(1.03); box-shadow: 0 8px 40px rgba(239,68,68,0.5); }
}

/* 결과 모달 - 프리미엄 스타일 */
.result-modal {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.85);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s;
    border-radius: 16px;
}

.result-modal.show {
    opacity: 1;
    visibility: visible;
}

.result-modal-content {
    background: linear-gradient(165deg, rgba(30,30,60,0.98) 0%, rgba(15,15,35,0.99) 100%);
    border: 2px solid transparent;
    border-radius: 20px;
    padding: 28px 40px;
    text-align: center;
    box-shadow:
        0 20px 60px rgba(0,0,0,0.6),
        inset 0 1px 0 rgba(255,255,255,0.1);
    transform: scale(0.8) rotateX(10deg);
    transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
}

.result-modal-content::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, #ffd700 0%, #b8860b 50%, #ffd700 100%);
    border-radius: 22px;
    z-index: -1;
}

.result-modal.show .result-modal-content {
    transform: scale(1) rotateX(0);
}

.result-modal-title {
    font-family: 'Orbitron', sans-serif;
    font-size: 20px;
    font-weight: 900;
    color: #ffd700;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(255,215,0,0.3);
    text-shadow: 0 0 20px rgba(255,215,0,0.4);
}

.result-modal-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 10px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    gap: 30px;
}

.result-modal-row:last-child {
    border-bottom: none;
}

.result-modal-label {
    font-size: 16px;
    font-weight: 700;
    color: #a0a0c0;
}

.result-modal-value {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 900;
    color: #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    position: relative;
}

.result-modal-value::after {
    content: '';
    position: absolute;
    inset: 3px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.3) 0%, transparent 60%);
}

.result-modal-value.odd {
    background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
    box-shadow: 0 0 25px rgba(59, 130, 246, 0.5);
}
.result-modal-value.even {
    background: linear-gradient(180deg, #ef4444 0%, #b91c1c 100%);
    box-shadow: 0 0 25px rgba(239, 68, 68, 0.5);
}
.result-modal-value.line {
    background: linear-gradient(180deg, #ffd700 0%, #b8860b 100%);
    color: #1a1a2e;
    font-size: 20px;
    box-shadow: 0 0 25px rgba(255, 215, 0, 0.5);
}

/* 결과 패널 - 프리미엄 다크 */
.result-panel-inner {
    padding: 0;
    overflow: hidden;
    border-radius: 18px;
}

.result-header {
    padding: 16px 20px;
    text-align: center;
    background: linear-gradient(180deg, rgba(40,40,70,0.9) 0%, rgba(25,25,50,0.95) 100%);
    border-bottom: 1px solid rgba(255,215,0,0.2);
}

.result-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 900;
    color: #ffd700;
    text-shadow: 0 0 15px rgba(255,215,0,0.3);
    letter-spacing: 2px;
}

.result-table-head {
    background: linear-gradient(180deg, rgba(255,215,0,0.15) 0%, rgba(255,215,0,0.08) 100%);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    border-bottom: 1px solid rgba(255,215,0,0.2);
}

.result-table-head span {
    padding: 10px 0;
    color: #ffd700;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.result-table-head span:first-child {
    text-align: left;
}

.result-table-head span:last-child {
    text-align: right;
}

.result-list {
    overflow-y: auto;
    background: linear-gradient(180deg, rgba(20,20,45,0.95) 0%, rgba(15,15,35,0.98) 100%);
}

.result-list::-webkit-scrollbar {
    width: 6px;
}

.result-list::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.05);
}

.result-list::-webkit-scrollbar-thumb {
    background: rgba(255,215,0,0.3);
    border-radius: 3px;
}

.result-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    transition: all 0.2s;
}

.result-item:hover {
    background: rgba(255,215,0,0.05);
}

.result-round {
    font-size: 13px;
    font-weight: 700;
    color: #8080a0;
    text-align: left;
}

.result-value {
    display: flex;
    justify-content: flex-end;
}

.result-badge {
    position: relative;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 900;
    color: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    flex-shrink: 0;
}

.result-badge::after {
    content: '';
    position: absolute;
    inset: 3px;
    border-radius: 50%;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.2) 0%, transparent 60%);
}

.result-badge.odd {
    background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
}

.result-badge.even {
    background: linear-gradient(180deg, #ef4444 0%, #b91c1c 100%);
}

.result-badge .line-num {
    position: absolute;
    top: -3px;
    left: -3px;
    width: 20px;
    height: 20px;
    background: linear-gradient(180deg, #ffd700 0%, #b8860b 100%);
    border-radius: 50%;
    font-size: 10px;
    color: #1a1a2e;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(30,30,60,0.9);
    font-weight: 900;
}

.result-waiting {
    color: #ffd700;
    font-size: 11px;
    font-weight: 700;
    padding: 8px 14px;
    background: rgba(255,215,0,0.1);
    border-radius: 16px;
    border: 1px dashed rgba(255,215,0,0.3);
    animation: waitingPulse 1.5s ease-in-out infinite;
}

@keyframes waitingPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* 베팅 섹션 - 컴팩트 프리미엄 */
.betting-section {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 20px;
    margin-top: 24px;
    position: relative;
    z-index: 1;
}

/* 모바일 전용 요소 PC에서 숨김 */
.mobile-slip-header { display: none; }
.mobile-slip-content { display: contents; }

.betting-area {
    background: linear-gradient(165deg, rgba(30, 30, 60, 0.95) 0%, rgba(20, 20, 45, 0.98) 100%);
    border: 2px solid transparent;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.4);
    position: relative;
}

.betting-area::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, #ffd700 0%, #b8860b 50%, #ffd700 100%);
    border-radius: 18px;
    z-index: -1;
    opacity: 0.6;
}

.betting-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(255,215,0,0.2);
}

.betting-title {
    font-size: 16px;
    font-weight: 900;
    color: #ffd700;
    text-shadow: 0 0 10px rgba(255,215,0,0.3);
}

.my-points {
    background: linear-gradient(135deg, #ffd700 0%, #b8860b 100%);
    padding: 8px 16px;
    border-radius: 20px;
    color: #1a1a2e;
    font-weight: 900;
    font-size: 13px;
    box-shadow: 0 3px 12px rgba(255,215,0,0.3);
}

.bet-options {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}

.bet-group {
    flex: 1;
    background: linear-gradient(180deg, rgba(40,40,70,0.5) 0%, rgba(25,25,50,0.7) 100%);
    border: 1px solid rgba(255,215,0,0.15);
    border-radius: 12px;
    padding: 12px 10px;
}

.bet-group-title {
    text-align: center;
    font-size: 11px;
    font-weight: 800;
    color: #ffd700;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.bet-buttons { display: flex; gap: 8px; }

.bet-btn {
    flex: 1;
    padding: 10px 6px;
    border: 2px solid rgba(255,215,0,0.15);
    border-radius: 10px;
    background: linear-gradient(180deg, rgba(40,40,70,0.4) 0%, rgba(25,25,50,0.6) 100%);
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
    position: relative;
}

.bet-btn:hover {
    border-color: rgba(255,215,0,0.4);
    background: linear-gradient(180deg, rgba(255,215,0,0.1) 0%, rgba(255,215,0,0.03) 100%);
}

.bet-btn.selected {
    border-color: #ffd700;
    background: linear-gradient(180deg, rgba(255,215,0,0.2) 0%, rgba(255,215,0,0.08) 100%);
    box-shadow: 0 0 20px rgba(255,215,0,0.3);
}

.bet-btn.selected::after {
    content: '✓';
    position: absolute;
    top: -6px;
    right: -6px;
    width: 18px;
    height: 18px;
    background: linear-gradient(135deg, #ffd700 0%, #b8860b 100%);
    border-radius: 50%;
    font-size: 10px;
    font-weight: 900;
    color: #1a1a2e;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(255,215,0,0.5);
    animation: checkPop 0.2s ease-out;
}

@keyframes checkPop {
    0% { transform: scale(0); }
    100% { transform: scale(1); }
}

.bet-btn-icon {
    font-size: 20px;
    margin-bottom: 4px;
    display: block;
}

.bet-btn-name {
    font-size: 14px;
    font-weight: 900;
    margin-bottom: 4px;
}
.bet-btn-name.blue { color: #60a5fa; }
.bet-btn-name.red { color: #f87171; }
.bet-btn-name.teal { color: #2dd4bf; }
.bet-btn-name.pink { color: #f472b6; }

.bet-btn.selected .bet-btn-name { color: #ffd700 !important; }

.bet-btn-odds {
    font-family: 'Orbitron', sans-serif;
    font-size: 10px;
    color: #ffd700;
    font-weight: 700;
}

.bet-submit-row { display: flex; gap: 12px; align-items: stretch; }

.bet-amount-wrapper {
    position: relative;
    flex: 1;
}

.bet-amount-label {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
}

.bet-amount {
    width: 100%;
    padding: 12px 40px 12px 70px;
    border: 2px solid rgba(255,215,0,0.2);
    border-radius: 10px;
    background: rgba(20,20,40,0.8);
    font-size: 16px;
    font-weight: 800;
    text-align: right;
    color: #fff;
}

.bet-amount:focus {
    outline: none;
    border-color: #ffd700;
    box-shadow: 0 0 15px rgba(255,215,0,0.2);
}

.bet-amount-suffix {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    font-weight: 800;
    color: #ffd700;
}

.quick-amounts { display: flex; gap: 6px; }

.quick-btn {
    padding: 12px 10px;
    border: 1px solid rgba(255,215,0,0.2);
    border-radius: 8px;
    background: rgba(255,215,0,0.1);
    font-weight: 700;
    font-size: 12px;
    color: #ffd700;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.quick-btn:hover {
    background: linear-gradient(135deg, #ffd700 0%, #b8860b 100%);
    color: #1a1a2e;
    border-color: #ffd700;
}

.submit-btn {
    padding: 12px 24px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 900;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    transition: all 0.2s;
    white-space: nowrap;
}

.submit-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5); }
.submit-btn:disabled { background: #4b5563; cursor: not-allowed; transform: none; box-shadow: none; }

/* 베팅 패널 */
.betting-panel {
    background: linear-gradient(180deg, #1a1a1a 0%, #0d0d0d 100%);
    border: 1px solid rgba(255,215,0,0.15);
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,215,0,0.05);
    height: fit-content;
}

.panel-title {
    font-size: 13px;
    font-weight: 700;
    color: #ffd700;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255,215,0,0.15);
    display: flex;
    align-items: center;
    gap: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bet-summary {
    background: linear-gradient(180deg, rgba(255,215,0,0.05) 0%, rgba(0,0,0,0.3) 100%);
    border: 1px solid rgba(255,215,0,0.1);
    border-radius: 10px;
    padding: 14px;
}

.bet-summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    font-size: 12px;
}

.bet-summary-row:last-child {
    margin-bottom: 0;
    padding-top: 10px;
    border-top: 1px solid rgba(255,215,0,0.1);
    font-weight: 700;
}

.bet-summary-label { color: #888; font-weight: 600; }
.bet-summary-value { color: #fff; font-weight: 700; }
.bet-summary-value.highlight { color: #ffd700; }
.bet-summary-value.total {
    color: #10b981;
    font-size: 16px;
    text-shadow: 0 0 8px rgba(16,185,129,0.3);
}

.selected-items-list {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    justify-content: flex-end;
}

.selected-item-chip {
    background: rgba(255,215,0,0.15);
    border: 1px solid rgba(255,215,0,0.3);
    color: #ffd700;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
}

/* 베팅 내역 섹션 */
.my-bets-section {
    display: block;
    margin-top: 20px;
    background: linear-gradient(165deg, rgba(30, 30, 60, 0.95) 0%, rgba(20, 20, 45, 0.98) 100%);
    border: 2px solid transparent;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.4);
    position: relative;
    z-index: 1;
}

.my-bets-section::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, #ffd700 0%, #b8860b 50%, #ffd700 100%);
    border-radius: 18px;
    z-index: -1;
    opacity: 0.5;
}

.my-bets-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.my-bets-table thead th { padding: 10px 6px; text-align: left; color: #888; font-weight: 600; border-bottom: 1px solid rgba(255,215,0,0.1); font-size: 10px; text-transform: uppercase; }
.my-bets-table tbody tr { border-bottom: 1px solid rgba(255,255,255,0.03); }
.my-bets-table tbody tr:hover { background: rgba(255,215,0,0.03); }
.my-bets-table tbody td { padding: 10px 6px; color: #ccc; }

.bet-type-badge { display: inline-block; padding: 3px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; }
.bet-type-badge.start { background: rgba(96,165,250,0.15); color: #60a5fa; }
.bet-type-badge.oe { background: rgba(248,113,113,0.15); color: #f87171; }
.bet-type-badge.line { background: rgba(45,212,191,0.15); color: #2dd4bf; }

.bet-status { display: inline-block; padding: 3px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; }
.bet-status.pending { background: rgba(255,215,0,0.15); color: #ffd700; }
.bet-status.win { background: rgba(16,185,129,0.15); color: #10b981; }
.bet-status.lose { background: rgba(239,68,68,0.15); color: #ef4444; }

.no-bets { text-align: center; padding: 30px; color: #666; font-size: 13px; }

/* 새 베팅 행 애니메이션 */
.new-bet-row {
    animation: newRowFade 0.5s ease-out;
    background: rgba(16,185,129,0.1) !important;
}

@keyframes newRowFade {
    0% {
        opacity: 0;
        transform: translateY(-10px);
        background: rgba(16,185,129,0.3);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
        background: rgba(16,185,129,0.1);
    }
}

/* 토스트 메시지 */
.bet-toast {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
    color: #fff;
    padding: 14px 24px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.5);
    z-index: 9999;
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.bet-toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

.bet-toast.success {
    border: 1px solid rgba(16,185,129,0.5);
    box-shadow: 0 8px 30px rgba(16,185,129,0.2);
}

.bet-toast.success span {
    width: 22px;
    height: 22px;
    background: #10b981;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.bet-toast.error {
    border: 1px solid rgba(239,68,68,0.5);
    box-shadow: 0 8px 30px rgba(239,68,68,0.2);
}

.bet-toast.error span {
    width: 22px;
    height: 22px;
    background: #ef4444;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

/* 베팅 마감 */
.betting-area.closed { position: relative; }
.betting-area.closed::after {
    content: '베팅 마감';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.85);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 900;
    color: #fff;
}

/* 반응형 - 태블릿 */
@media (max-width: 1200px) {
    .ladder-main { grid-template-columns: 1fr 280px; gap: 16px; }
    .betting-section { grid-template-columns: 1fr 240px; gap: 16px; }
}

@media (max-width: 960px) {
    .ladder-page { padding: 12px; }
    .ladder-main { grid-template-columns: 1fr; gap: 16px; }
    .betting-section { grid-template-columns: 1fr; gap: 16px; }
    .bet-options { flex-wrap: wrap; }
    .bet-group { flex: 1 1 calc(50% - 6px); min-width: 140px; }
    .bet-submit-row { flex-wrap: wrap; }
    .amount-input { flex: 1; min-width: 100px; }
    .submit-btn { flex: 1; min-width: 120px; }
    .my-bets-table { font-size: 11px; }
    .my-bets-table thead th, .my-bets-table tbody td { padding: 8px 4px; }
}

/* 반응형 - 모바일 */
@media (max-width: 640px) {
    .ladder-page { padding: 8px; padding-bottom: 140px; }

    .ladder-main { gap: 10px; }
    .panel-frame { border-radius: 12px; }
    .game-panel { padding: 12px 14px 14px; }

    .game-header { text-align: center; margin-bottom: 12px; padding-bottom: 10px; }
    .game-header h2 { font-size: 11px; }
    .game-header .current-time { font-size: 18px; margin-top: 4px; }

    /* 사다리 게임 영역 모바일 */
    .ladder-game { padding: 12px 0; }
    .start-points, .end-points { padding: 0 30px; }
    .start-point, .end-marker { width: 44px; height: 44px; font-size: 16px; }
    .ladder-canvas-wrap { height: 160px; margin: 0 45px; }
    .end-label { font-size: 9px; }

    .countdown-area { margin-top: 14px; }
    .countdown-box { padding: 10px 24px; font-size: 12px; gap: 8px; }
    .countdown-time { font-size: 20px; min-width: 50px; }

    /* 결과 패널 모바일 - 컴팩트 */
    .result-panel-inner { border-radius: 12px; }
    .result-header { padding: 10px 14px; }
    .result-header h3 { font-size: 13px; letter-spacing: 1px; }
    .result-table-head { padding: 0 12px; }
    .result-table-head span { font-size: 10px; padding: 6px 0; }
    .result-item { padding: 5px 12px; }
    .result-round { font-size: 11px; }
    .result-badge { width: 32px; height: 32px; font-size: 11px; }
    .result-badge .line-num { width: 16px; height: 16px; font-size: 9px; top: -2px; left: -2px; }

    /* 모바일 레이아웃 - flex로 순서 조정: 게임 → 베팅내역 → 결과 */
    .ladder-main {
        display: flex;
        flex-direction: column;
    }
    /* 게임 패널 (첫번째) */
    .ladder-main > .panel-frame:first-of-type {
        order: 1;
    }
    /* 베팅 내역 (두번째 - 게임 바로 아래) */
    .my-bets-section {
        display: block !important;
        order: 2;
        margin-top: 10px;
        padding: 10px;
        border-radius: 10px;
        overflow: hidden;
    }
    /* 결과 패널 (세번째 - 베팅내역 아래) */
    .ladder-main > .panel-frame.result-panel {
        order: 3;
    }
    .my-bets-section::before { display: none; }
    .my-bets-section .panel-title { font-size: 11px; margin-bottom: 6px; padding-bottom: 4px; }
    .my-bets-table thead th { font-size: 8px; padding: 4px 2px; }
    .my-bets-table tbody td { font-size: 9px; padding: 4px 2px; }
    .my-bets-table tbody tr:nth-child(n+6) { display: none; } /* 5개만 표시 */
    .bet-type-badge, .bet-status { padding: 2px 4px; font-size: 7px; }

    /* 결과 패널 모바일 - 5개만 표시, 스크롤 없음 */
    .result-panel-inner { overflow: hidden; }
    .result-header { padding: 8px 12px; }
    .result-header h3 { font-size: 11px; }
    .result-table-head { display: none; }
    .result-list { overflow: hidden; }
    .result-list .result-item:nth-child(n+7) { display: none; } /* 현재+5개만 표시 */

    /* 베팅 섹션 모바일 - 하단 고정 버튼 토글 방식 */
    .betting-section {
        display: block !important;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(180deg, #1a1a1a 0%, #0d0d0d 100%);
        border-top: 1px solid rgba(255,215,0,0.2);
        border-radius: 16px 16px 0 0;
        padding: 0;
        margin: 0;
        z-index: 1000;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.5);
        grid-template-columns: 1fr;
    }

    /* 토글 헤더 */
    .mobile-slip-header {
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        padding: 10px 14px;
        cursor: pointer;
        border-bottom: 1px solid rgba(255,215,0,0.1);
    }

    .mobile-slip-title {
        font-size: 13px;
        font-weight: 800;
        color: #ffd700;
    }

    .mobile-slip-toggle {
        background: rgba(255,215,0,0.15);
        border: 1px solid rgba(255,215,0,0.3);
        color: #ffd700;
        padding: 6px 12px;
        border-radius: 16px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .mobile-slip-toggle:active {
        background: rgba(255,215,0,0.3);
    }

    /* 베팅 컨텐츠 영역 - 기본 숨김 */
    .mobile-slip-content {
        display: none;
    }

    .betting-section.expanded .mobile-slip-content {
        display: block;
    }


    .betting-area {
        padding: 10px 12px 12px;
        background: transparent;
        border: none;
        box-shadow: none;
    }

    .betting-area::before { display: none; }

    .betting-header { display: none; }

    .bet-options {
        display: flex;
        gap: 6px;
        margin-bottom: 8px;
    }

    /* 모바일: 줄수 그룹 숨김 */
    .bet-group:last-child { display: none; }

    .bet-group {
        flex: 1;
        background: none;
        border: none;
        padding: 0;
    }

    .bet-group-title { display: none; }

    .bet-buttons {
        display: flex;
        gap: 6px;
    }

    .bet-btn {
        flex: 1;
        padding: 8px 4px;
        border-radius: 8px;
        border-width: 2px;
    }

    .bet-btn-icon { font-size: 18px; margin-bottom: 2px; }
    .bet-btn-name { font-size: 12px; margin-bottom: 1px; font-weight: 900; }
    .bet-btn-odds { font-size: 9px; }

    .bet-btn.selected::after {
        width: 16px; height: 16px; font-size: 9px;
        top: -5px; right: -5px;
    }

    .bet-submit-row {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
    }

    .bet-amount-wrapper {
        flex: 0 0 80px;
        min-width: 80px;
    }
    .bet-amount-label { display: none; }
    .bet-amount {
        width: 100%;
        padding: 10px 22px 10px 8px;
        font-size: 14px;
        border-radius: 8px;
        text-align: right;
    }
    .bet-amount-suffix { font-size: 11px; right: 6px; }

    .quick-amounts { display: flex; gap: 3px; flex: 1; }
    .quick-btn { padding: 10px 6px; font-size: 9px; border-radius: 8px; flex: 1; }

    .submit-btn {
        padding: 10px 16px;
        font-size: 13px;
        border-radius: 8px;
        white-space: nowrap;
    }

    /* 베팅 패널 모바일에서 숨김 */
    .betting-panel { display: none; }

    /* 토스트 모바일 */
    .bet-toast {
        bottom: 70px;
        padding: 10px 16px;
        font-size: 12px;
    }

    .betting-section.expanded ~ .bet-toast {
        bottom: 200px;
    }

    /* 베팅 마감 오버레이 모바일 */
    .betting-area.closed::after {
        content: '베팅 마감';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.9);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        color: #ffd700;
        z-index: 10;
    }

    /* 결과 모달 모바일 */
    .result-modal-content { padding: 20px 28px; }
    .result-modal-title { font-size: 16px; margin-bottom: 14px; padding-bottom: 12px; }
    .result-modal-row { padding: 10px 6px; gap: 20px; }
    .result-modal-label { font-size: 14px; }
    .result-modal-value { width: 42px; height: 42px; font-size: 14px; }
}

/* 아주 작은 화면 */
@media (max-width: 380px) {
    .ladder-page { padding-bottom: 70px; }
    .bet-btn { padding: 6px 3px; }
    .bet-btn-icon { font-size: 16px; }
    .bet-btn-name { font-size: 11px; }
    .quick-btn { padding: 8px 6px; font-size: 9px; }
    .submit-btn { padding: 8px 12px; font-size: 12px; }
    .countdown-time { font-size: 18px; }
    .result-badge { width: 28px; height: 28px; font-size: 10px; }
    .result-badge .line-num { width: 14px; height: 14px; font-size: 8px; }
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

        <!-- 내 베팅 내역 - ladder-main 안에서 순서 조정 가능 -->
        <div class="my-bets-section">
            <div class="panel-title">🎫 내 베팅 내역</div>
            <?php if (empty($my_bets)): ?>
                <div class="no-bets">베팅 내역이 없습니다</div>
            <?php else: ?>
                <table class="my-bets-table">
                    <thead>
                        <tr>
                            <th>회차</th>
                            <th>유형</th>
                            <th>선택</th>
                            <th>금액</th>
                            <th>배당</th>
                            <th>예상당첨</th>
                            <th>상태</th>
                        </tr>
                    </thead>
                    <tbody id="myBetsBody">
                        <?php foreach ($my_bets as $bet):
                            $type_label = $bet_type_labels[$bet['lb_bet_type']] ?? $bet['lb_bet_type'];
                            $value_label = '';
                            if ($bet['lb_bet_type'] == 'start') {
                                $value_label = $bet['lb_bet_value'] == '0' ? '좌' : '우';
                            } else if ($bet['lb_bet_type'] == 'oe') {
                                $value_label = $bet['lb_bet_value'] == '1' ? '홀' : '짝';
                            } else if ($bet['lb_bet_type'] == 'line') {
                                $value_label = $bet['lb_bet_value'] . '줄';
                            }
                            $status_label = $bet['lb_status'] == 'pending' ? '대기' : ($bet['lb_status'] == 'win' ? '당첨' : '낙첨');
                            $expected = floor($bet['lb_amount'] * $bet['lb_odds']);
                        ?>
                        <tr>
                            <td><?php echo number_format($bet['lb_round']); ?></td>
                            <td><span class="bet-type-badge <?php echo $bet['lb_bet_type']; ?>"><?php echo $type_label; ?></span></td>
                            <td><?php echo $value_label; ?></td>
                            <td><?php echo number_format($bet['lb_amount']); ?>P</td>
                            <td>x<?php echo $bet['lb_odds']; ?></td>
                            <td style="color: #10b981;"><?php echo number_format($expected); ?>P</td>
                            <td><span class="bet-status <?php echo $bet['lb_status']; ?>"><?php echo $status_label; ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- 결과 패널 -->
        <div class="panel-frame result-panel">
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
                        <div class="result-round"><span id="currentRoundNum"><?php echo number_format($current_round); ?></span>회차</div>
                        <div class="result-value">
                            <span class="result-waiting" id="currentRoundResult">대기</span>
                        </div>
                    </div>
                    <?php foreach ($recent_results as $r): ?>
                    <div class="result-item">
                        <div class="result-round"><?php echo number_format($r['round']); ?>회차</div>
                        <div class="result-value">
                            <span class="result-badge <?php echo $r['odd_even'] == 1 ? 'odd' : 'even'; ?>">
                                <?php echo $r['odd_even'] == 1 ? '홀' : '짝'; ?>
                                <span class="line-num"><?php echo $r['lines']; ?></span>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- 베팅 섹션 - 경마 스타일 -->
    <div class="betting-section" id="bettingSection">
        <!-- 모바일 토글 헤더 -->
        <div class="mobile-slip-header" onclick="toggleBettingSlip(event)">
            <span class="mobile-slip-title">🎯 베팅하기 · <span id="myPointMobile"><?php echo number_format($member_point); ?></span>P</span>
            <span class="mobile-slip-toggle" id="slipToggleBtn">열기 ▲</span>
        </div>
        <div class="mobile-slip-content">
        <div class="betting-area" id="bettingArea">
            <div class="betting-header">
                <div class="betting-title">🎯 베팅하기</div>
                <div class="my-points">💰 <span id="myPoint"><?php echo number_format($member_point); ?></span>P</div>
            </div>

            <div class="bet-options">
                <div class="bet-group">
                    <div class="bet-group-title">🎯 출발점</div>
                    <div class="bet-buttons">
                        <button class="bet-btn" data-type="start" data-value="0" onclick="selectBet(this)">
                            <span class="bet-btn-icon">◀</span>
                            <div class="bet-btn-name blue">좌</div>
                            <div class="bet-btn-odds">x1.95</div>
                        </button>
                        <button class="bet-btn" data-type="start" data-value="1" onclick="selectBet(this)">
                            <span class="bet-btn-icon">▶</span>
                            <div class="bet-btn-name red">우</div>
                            <div class="bet-btn-odds">x1.95</div>
                        </button>
                    </div>
                </div>
                <div class="bet-group">
                    <div class="bet-group-title">🔢 홀/짝</div>
                    <div class="bet-buttons">
                        <button class="bet-btn" data-type="oe" data-value="1" onclick="selectBet(this)">
                            <span class="bet-btn-icon">🔵</span>
                            <div class="bet-btn-name blue">홀</div>
                            <div class="bet-btn-odds">x1.95</div>
                        </button>
                        <button class="bet-btn" data-type="oe" data-value="0" onclick="selectBet(this)">
                            <span class="bet-btn-icon">🔴</span>
                            <div class="bet-btn-name red">짝</div>
                            <div class="bet-btn-odds">x1.95</div>
                        </button>
                    </div>
                </div>
                <div class="bet-group">
                    <div class="bet-group-title">📊 줄 수</div>
                    <div class="bet-buttons">
                        <button class="bet-btn" data-type="line" data-value="3" onclick="selectBet(this)">
                            <span class="bet-btn-icon">≡</span>
                            <div class="bet-btn-name teal">3줄</div>
                            <div class="bet-btn-odds">x1.95</div>
                        </button>
                        <button class="bet-btn" data-type="line" data-value="4" onclick="selectBet(this)">
                            <span class="bet-btn-icon">☰</span>
                            <div class="bet-btn-name pink">4줄</div>
                            <div class="bet-btn-odds">x1.95</div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bet-submit-row">
                <div class="bet-amount-wrapper">
                    <span class="bet-amount-label">베팅금액</span>
                    <input type="number" class="bet-amount" id="betAmount" value="100" min="10" max="5000">
                    <span class="bet-amount-suffix">P</span>
                </div>
                <div class="quick-amounts">
                    <button class="quick-btn" onclick="setAmount(100)">+100</button>
                    <button class="quick-btn" onclick="setAmount(500)">+500</button>
                    <button class="quick-btn" onclick="setAmount(1000)">+1,000</button>
                    <button class="quick-btn" onclick="setAmount('max')">MAX</button>
                </div>
                <button class="submit-btn" id="submitBtn" onclick="placeBet()">🎲 베팅하기</button>
            </div>
        </div>
        </div><!-- /.mobile-slip-content -->

        <!-- 베팅 요약 패널 -->
        <div class="betting-panel">
            <div class="panel-title">📋 베팅 정보</div>
            <div class="bet-summary">
                <div class="bet-summary-row">
                    <span class="bet-summary-label">선택 항목</span>
                    <span class="bet-summary-value" id="selectedItems">-</span>
                </div>
                <div class="bet-summary-row">
                    <span class="bet-summary-label">배당률</span>
                    <span class="bet-summary-value" id="totalOdds">-</span>
                </div>
                <div class="bet-summary-row">
                    <span class="bet-summary-label">예상 당첨금</span>
                    <span class="bet-summary-value total" id="expectedWin">0P</span>
                </div>
            </div>
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

        isAnimating = false;

        // 4초간 결과 표시 후 완료 처리 및 베팅 재개
        setTimeout(() => {
            animationComplete = true;
            // 애니메이션 완료 후 베팅 다시 열기
            openBetting();
        }, 4000);
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

    // 라운드 전환 감지 - 0초가 되면 사다리 애니메이션 시작
    if (newRound !== lastRound) {
        if (!animationStarted && !animationComplete) {
            // 0초 됨 - 사다리 애니메이션 시작 (이전 라운드 결과로)
            animateLadder();
        } else if (animationComplete) {
            // 애니메이션 완료 후 다음 라운드로 전환
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

function openBetting() {
    isBettingClosed = false;
    document.getElementById('bettingArea').classList.remove('closed');
    document.getElementById('submitBtn').disabled = false;
}

function selectBet(el) {
    if (isBettingClosed) return;
    const type = el.dataset.type;
    document.querySelectorAll(`.bet-btn[data-type="${type}"]`).forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');
    selectedBets[type] = el.dataset.value;
    updateBetSummary();
}

function updateBetSummary() {
    const amount = parseInt(document.getElementById('betAmount').value) || 0;
    const odds = 1.95;

    // 선택 항목 리스트
    const items = [];
    const labels = {
        start: { '0': '좌', '1': '우' },
        oe: { '0': '짝', '1': '홀' },
        line: { '3': '3줄', '4': '4줄' }
    };

    if (selectedBets.start !== null) items.push(labels.start[selectedBets.start]);
    if (selectedBets.oe !== null) items.push(labels.oe[selectedBets.oe]);
    if (selectedBets.line !== null) items.push(labels.line[selectedBets.line]);

    const selectedItemsEl = document.getElementById('selectedItems');
    if (items.length === 0) {
        selectedItemsEl.innerHTML = '<span style="color:#64748b;">-</span>';
    } else {
        selectedItemsEl.innerHTML = items.map(item =>
            `<span class="selected-item-chip">${item}</span>`
        ).join('');
    }

    // 배당률 및 예상 당첨금
    const betCount = items.length;
    const totalOddsEl = document.getElementById('totalOdds');
    const expectedWinEl = document.getElementById('expectedWin');

    if (betCount > 0) {
        totalOddsEl.innerHTML = `<span class="bet-summary-value highlight">x${odds} × ${betCount}건</span>`;
        const expectedWin = Math.floor(amount * odds * betCount);
        expectedWinEl.textContent = expectedWin.toLocaleString() + 'P';
    } else {
        totalOddsEl.innerHTML = '<span style="color:#64748b;">-</span>';
        expectedWinEl.textContent = '0P';
    }
}

function setAmount(val) {
    const input = document.getElementById('betAmount');
    if (val === 'max') {
        input.value = Math.min(currentPoint, 5000);
    } else {
        input.value = (parseInt(input.value) || 0) + val;
        if (input.value > 5000) input.value = 5000;
    }
    updateBetSummary();
}

// 금액 입력 시 실시간 업데이트
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('betAmount');
    if (amountInput) {
        amountInput.addEventListener('input', updateBetSummary);
    }
});

function placeBet() {
    if (isBettingClosed) return alert('베팅이 마감되었습니다.');

    const hasSelection = selectedBets.start !== null || selectedBets.oe !== null || selectedBets.line !== null;
    if (!hasSelection) return alert('베팅 항목을 선택해주세요.');

    const amount = parseInt(document.getElementById('betAmount').value);
    if (amount < 10 || amount > 5000) return alert('베팅 금액은 10~5000P입니다.');
    if (amount > currentPoint) return alert('포인트가 부족합니다.');

    let betCount = [selectedBets.start, selectedBets.oe, selectedBets.line].filter(v => v !== null).length;
    if (amount * betCount > currentPoint) return alert('총 베팅액이 보유 포인트를 초과합니다.');

    // 버튼 비활성화
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.textContent = '처리중...';

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

            // 베팅 내역 실시간 갱신
            addBetToHistory(data.bets || []);

            // 선택 초기화
            document.querySelectorAll('.bet-btn').forEach(b => b.classList.remove('selected'));
            selectedBets = { start: null, oe: null, line: null };
            updateBetSummary();

            // 성공 메시지
            showToast('베팅이 완료되었습니다!', 'success');
        } else {
            alert(data.message || '베팅 실패');
        }
    })
    .catch(() => alert('오류가 발생했습니다.'))
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = '🎲 베팅하기';
    });
}

// 베팅 내역에 새 베팅 추가
function addBetToHistory(bets) {
    const tbody = document.getElementById('myBetsBody');
    if (!tbody) {
        // 테이블이 없으면 생성
        const section = document.querySelector('.my-bets-section');
        const noData = section.querySelector('.no-bets');
        if (noData) {
            noData.remove();
            section.innerHTML += `
                <table class="my-bets-table">
                    <thead>
                        <tr>
                            <th>회차</th>
                            <th>베팅유형</th>
                            <th>선택</th>
                            <th>베팅액</th>
                            <th>배당</th>
                            <th>예상당첨</th>
                            <th>상태</th>
                        </tr>
                    </thead>
                    <tbody id="myBetsBody"></tbody>
                </table>
            `;
        }
    }

    const tableBody = document.getElementById('myBetsBody');
    if (!tableBody) return;

    const typeLabels = { 'start': '출발점', 'oe': '홀짝', 'line': '줄수' };
    const valueLabels = {
        'start': { '0': '좌', '1': '우' },
        'oe': { '0': '짝', '1': '홀' },
        'line': { '3': '3줄', '4': '4줄' }
    };

    // 새 베팅들을 앞에 추가
    bets.forEach(bet => {
        const row = document.createElement('tr');
        row.className = 'new-bet-row';
        const typeLabel = typeLabels[bet.type] || bet.type;
        const valueLabel = valueLabels[bet.type] ? valueLabels[bet.type][bet.value] : bet.value;
        const expected = Math.floor(bet.amount * bet.odds);

        row.innerHTML = `
            <td>${Number(bet.round).toLocaleString()}</td>
            <td><span class="bet-type-badge ${bet.type}">${typeLabel}</span></td>
            <td>${valueLabel}</td>
            <td>${Number(bet.amount).toLocaleString()}P</td>
            <td>x${bet.odds}</td>
            <td style="color: #10b981;">${expected.toLocaleString()}P</td>
            <td><span class="bet-status pending">대기</span></td>
        `;

        tableBody.insertBefore(row, tableBody.firstChild);
    });

    // 20개 초과 시 뒤에서 삭제
    while (tableBody.children.length > 20) {
        tableBody.removeChild(tableBody.lastChild);
    }
}

// 토스트 메시지
function showToast(message, type = 'info') {
    const existing = document.querySelector('.bet-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'bet-toast ' + type;
    toast.innerHTML = `<span>${type === 'success' ? '✓' : 'ℹ'}</span> ${message}`;
    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// 모바일 베팅 슬립 토글
function toggleBettingSlip(e) {
    if (e) e.stopPropagation();
    const bettingSection = document.getElementById('bettingSection');
    const toggleBtn = document.getElementById('slipToggleBtn');
    console.log('toggleBettingSlip called', bettingSection);
    if (bettingSection) {
        const isExpanded = bettingSection.classList.contains('expanded');
        if (isExpanded) {
            bettingSection.classList.remove('expanded');
            if (toggleBtn) toggleBtn.textContent = '열기 ▲';
        } else {
            bettingSection.classList.add('expanded');
            if (toggleBtn) toggleBtn.textContent = '닫기 ▼';
        }
        console.log('expanded:', bettingSection.classList.contains('expanded'));
    }
}

// 초기화
window.addEventListener('load', function() {
    initCanvas();
});
window.addEventListener('resize', initCanvas);
setInterval(updateTime, 1000);
setInterval(updateTimer, 1000);
updateTime();
updateTimer();
</script>

<?php include_once(G5_PATH.'/tail.php'); ?>
