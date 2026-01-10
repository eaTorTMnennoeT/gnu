<?php
/**
 * BTC 예측 게임 - 고퀄리티 버전
 * 미니 캔들차트, 실시간 가격, 라운드 히스토리
 */
include_once('./_common.php');

if (!$is_member) {
    alert('로그인 후 이용해주세요.', G5_URL);
    exit;
}

$g5['title'] = 'BTC Predict';
include_once(G5_PATH.'/head.php');

$member_point = $member['mb_point'];

// DB에서 사용자의 BTC 배팅 내역 조회 (최근 20개)
$game_log_table = $g5['write_prefix'] . 'game_log';
$sql = "SELECT gl_id, gl_bet_type, gl_bet_amount, gl_result, gl_win_amount, gl_profit, gl_detail, gl_datetime
        FROM {$game_log_table}
        WHERE mb_id = '{$member['mb_id']}' AND gl_game = 'btc'
        ORDER BY gl_id DESC
        LIMIT 20";
$result = sql_query($sql);

$db_bet_history = [];
while ($row = sql_fetch_array($result)) {
    // gl_detail 파싱: "베팅:UP, 잠금:$97000.00, 마감:$97500.00, 결과:UP"
    $detail = $row['gl_detail'];
    $lockPrice = 0;
    $endPrice = 0;
    $actualResult = '';

    if (preg_match('/잠금:\$([0-9.]+)/', $detail, $m)) {
        $lockPrice = floatval($m[1]);
    }
    if (preg_match('/마감:\$([0-9.]+)/', $detail, $m)) {
        $endPrice = floatval($m[1]);
    }
    if (preg_match('/결과:(UP|DOWN)/i', $detail, $m)) {
        $actualResult = strtolower($m[1]);
    }

    $isWin = ($row['gl_result'] == 'win');

    $db_bet_history[] = [
        'id' => $row['gl_id'],
        'prediction' => strtolower($row['gl_bet_type']),
        'betAmount' => intval($row['gl_bet_amount']),
        'lockPrice' => $lockPrice,
        'endPrice' => $endPrice,
        'actualResult' => $actualResult,
        'isWin' => $isWin,
        'profit' => intval($row['gl_profit']),
        'datetime' => $row['gl_datetime']
    ];
}
$db_bet_history_json = json_encode($db_bet_history);

// Binance API에서 BTC 가격 가져오기 (USDT)
$btc_price = 0; // WebSocket 연결 후 설정
$btc_api_url = 'https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT';

$context = stream_context_create([
    'http' => [
        'timeout' => 2,
        'header' => 'Accept: application/json'
    ]
]);

$btc_response = @file_get_contents($btc_api_url, false, $context);
if ($btc_response) {
    $btc_data = json_decode($btc_response, true);
    if (isset($btc_data['price'])) {
        $btc_price = floatval($btc_data['price']);
    }
}
?>

<style>
/* ========================================
   BTC PREDICT GAME - 라이트/다크 테마 지원
   ======================================== */

/* 모바일에서 바깥 배경 노출/가로 스크롤 방지 */
html, body {
    overflow-x: hidden;
}

.btc-container {
    max-width: 900px;
    margin: 20px auto;
    padding: 15px;
}

/* ========================================
   라이트 모드 기본
   ======================================== */
.btc-game {
    background: var(--bg-card, #ffffff);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    border: 1px solid var(--border, #e0e0e0);
}

/* ========================================
   다크 모드 - 프리미엄 테마
   ======================================== */
[data-theme="dark"] .btc-game,
.dark .btc-game {
    background: linear-gradient(180deg, #0f0f1a 0%, #1a1a2e 100%);
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    border: 1px solid rgba(255,255,255,0.05);
}

/* 헤더 - 라이트 모드 */
.btc-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: linear-gradient(135deg, #f7931a 0%, #ffab40 100%);
    border-bottom: 1px solid var(--border, #e0e0e0);
}

/* 헤더 - 다크 모드 */
[data-theme="dark"] .btc-header,
.dark .btc-header {
    background: rgba(0,0,0,0.3);
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.btc-logo {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* 라이트 모드 - 헤더 아이콘 */
.btc-icon {
    width: 44px;
    height: 44px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 900;
    color: #f7931a;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

[data-theme="dark"] .btc-icon,
.dark .btc-icon {
    background: linear-gradient(135deg, #f7931a, #ffab40);
    color: white;
    box-shadow: 0 4px 20px rgba(247, 147, 26, 0.4);
}

.btc-title h1 {
    font-size: 22px;
    font-weight: 800;
    color: white;
    margin: 0;
}

.btc-title .subtitle {
    font-size: 12px;
    color: rgba(255,255,255,0.8);
}

[data-theme="dark"] .btc-title .subtitle,
.dark .btc-title .subtitle {
    color: rgba(255,255,255,0.5);
}

/* 포인트 표시 - 라이트 모드 */
.btc-point-display {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(0,0,0,0.15);
    padding: 10px 20px;
    border-radius: 12px;
}

[data-theme="dark"] .btc-point-display,
.dark .btc-point-display {
    background: rgba(255,255,255,0.1);
}

.btc-point-display .amount {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    text-shadow: 0 1px 2px rgba(255,255,255,0.3);
}

[data-theme="dark"] .btc-point-display .amount,
.dark .btc-point-display .amount {
    color: #fbbf24;
    text-shadow: none;
}

.btc-point-display .unit {
    color: rgba(0,0,0,0.5);
    font-size: 14px;
    font-weight: 600;
}

[data-theme="dark"] .btc-point-display .unit,
.dark .btc-point-display .unit {
    color: rgba(255,255,255,0.5);
}

/* 가격 표시 - 라이트 모드 */
.price-section {
    padding: 24px;
    background: var(--bg-main, #f5f5f5);
}

[data-theme="dark"] .price-section,
.dark .price-section {
    background: rgba(0,0,0,0.2);
}

.current-price-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.current-price {
    text-align: left;
}

.price-label {
    font-size: 12px;
    color: var(--text-secondary, #666);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 4px;
}

[data-theme="dark"] .price-label,
.dark .price-label {
    color: rgba(255,255,255,0.5);
}

.price-value {
    font-size: 42px;
    font-weight: 900;
    color: var(--text-primary, #1a1a1a);
    font-family: 'Courier New', monospace;
    display: flex;
    align-items: baseline;
    gap: 8px;
}

[data-theme="dark"] .price-value,
.dark .price-value {
    color: white;
}

.price-value .currency {
    font-size: 20px;
    color: var(--text-secondary, #666);
}

[data-theme="dark"] .price-value .currency,
.dark .price-value .currency {
    color: rgba(255,255,255,0.5);
}

.price-change {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 700;
}

.price-change.up {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.price-change.down {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.price-change .arrow {
    font-size: 20px;
}

/* 라운드 타이머 */
.round-timer-section {
    display: flex;
    align-items: center;
    gap: 20px;
}

.round-info {
    text-align: right;
}

.round-number {
    font-size: 12px;
    color: var(--text-secondary, #666);
}

[data-theme="dark"] .round-number,
.dark .round-number {
    color: rgba(255,255,255,0.5);
}

.round-phase {
    font-size: 14px;
    font-weight: 600;
    color: #10b981;
}

.round-phase.locked {
    color: #f59e0b;
}

.round-phase.ended {
    color: #ef4444;
}

.timer-circle {
    position: relative;
    width: 70px;
    height: 70px;
}

.timer-circle svg {
    transform: rotate(-90deg);
}

.timer-circle circle {
    fill: none;
    stroke-width: 4;
}

.timer-circle .bg {
    stroke: var(--border, #e0e0e0);
}

[data-theme="dark"] .timer-circle .bg,
.dark .timer-circle .bg {
    stroke: rgba(255,255,255,0.1);
}

.timer-circle .progress {
    stroke: #10b981;
    stroke-linecap: round;
    stroke-dasharray: 188.495;
    transition: stroke-dashoffset 0.1s linear, stroke 0.3s;
}

.timer-circle .progress.warning {
    stroke: #f59e0b;
}

.timer-circle .progress.danger {
    stroke: #ef4444;
}

.timer-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 18px;
    font-weight: 800;
    color: var(--text-primary, #1a1a1a);
}

[data-theme="dark"] .timer-text,
.dark .timer-text {
    color: white;
}

/* 미니 캔들 차트 */
.chart-section {
    padding: 0 24px 24px;
}

.chart-wrapper {
    background: var(--bg-main, #f5f5f5);
    border: 1px solid var(--border, #e0e0e0);
    border-radius: 16px;
    padding: 20px;
    height: 200px;
    position: relative;
}

[data-theme="dark"] .chart-wrapper,
.dark .chart-wrapper {
    background: rgba(0,0,0,0.3);
    border: none;
}

#btcChart {
    width: 100%;
    height: 100%;
}

.chart-overlay {
    position: absolute;
    top: 20px;
    left: 20px;
    display: flex;
    gap: 16px;
}

.chart-stat {
    background: var(--bg-card, #fff);
    border: 1px solid var(--border, #e0e0e0);
    padding: 8px 12px;
    border-radius: 8px;
}

[data-theme="dark"] .chart-stat,
.dark .chart-stat {
    background: rgba(0,0,0,0.5);
    border: none;
}

.chart-stat-label {
    font-size: 10px;
    color: var(--text-secondary, #666);
    text-transform: uppercase;
}

[data-theme="dark"] .chart-stat-label,
.dark .chart-stat-label {
    color: rgba(255,255,255,0.5);
}

.chart-stat-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary, #1a1a1a);
}

[data-theme="dark"] .chart-stat-value,
.dark .chart-stat-value {
    color: white;
}

/* 베팅 영역 - 라이트 모드 */
.betting-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    padding: 24px;
    background: var(--bg-main, #f5f5f5);
}

[data-theme="dark"] .betting-section,
.dark .betting-section {
    background: rgba(0,0,0,0.2);
}

.bet-card {
    background: var(--bg-card, #fff);
    border: 2px solid var(--border, #e0e0e0);
    border-radius: 16px;
    padding: 24px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

[data-theme="dark"] .bet-card,
.dark .bet-card {
    background: rgba(255,255,255,0.03);
    border: 2px solid rgba(255,255,255,0.1);
}

.bet-card::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.3s;
}

.bet-card.up::before {
    background: linear-gradient(180deg, rgba(16, 185, 129, 0.2), transparent);
}

.bet-card.down::before {
    background: linear-gradient(180deg, rgba(239, 68, 68, 0.2), transparent);
}

.bet-card:hover::before {
    opacity: 1;
}

.bet-card.selected.up {
    border-color: #10b981;
    box-shadow: 0 0 30px rgba(16, 185, 129, 0.3);
}

.bet-card.selected.down {
    border-color: #ef4444;
    box-shadow: 0 0 30px rgba(239, 68, 68, 0.3);
}

.bet-card.disabled {
    opacity: 0.5;
    pointer-events: none;
}

.bet-card-icon {
    font-size: 48px;
    margin-bottom: 12px;
    position: relative;
    z-index: 1;
}

.bet-card.up .bet-card-icon {
    color: #10b981;
    text-shadow: 0 0 30px rgba(16, 185, 129, 0.5);
}

.bet-card.down .bet-card-icon {
    color: #ef4444;
    text-shadow: 0 0 30px rgba(239, 68, 68, 0.5);
}

.bet-card-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--text-primary, #1a1a1a);
    margin-bottom: 4px;
    position: relative;
    z-index: 1;
}

[data-theme="dark"] .bet-card-title,
.dark .bet-card-title {
    color: white;
}

.bet-card-desc {
    font-size: 13px;
    color: var(--text-secondary, #666);
    margin-bottom: 16px;
    position: relative;
    z-index: 1;
}

[data-theme="dark"] .bet-card-desc,
.dark .bet-card-desc {
    color: rgba(255,255,255,0.5);
}

.bet-card-odds {
    font-size: 24px;
    font-weight: 900;
    position: relative;
    z-index: 1;
}

.bet-card.up .bet-card-odds {
    color: #10b981;
}

.bet-card.down .bet-card-odds {
    color: #ef4444;
}

/* 베팅 컨트롤 */
.bet-controls {
    padding: 0 24px 24px;
    background: var(--bg-main, #f5f5f5);
}

[data-theme="dark"] .bet-controls,
.dark .bet-controls {
    background: transparent;
}

.bet-amount-section {
    background: var(--bg-card, #fff);
    border: 1px solid var(--border, #e0e0e0);
    border-radius: 16px;
    padding: 20px;
}

[data-theme="dark"] .bet-amount-section,
.dark .bet-amount-section {
    background: rgba(0,0,0,0.3);
    border: none;
}

.bet-amount-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.bet-amount-label {
    font-size: 12px;
    color: var(--text-secondary, #666);
    text-transform: uppercase;
    letter-spacing: 1px;
}

[data-theme="dark"] .bet-amount-label,
.dark .bet-amount-label {
    color: rgba(255,255,255,0.5);
}

.bet-amount-balance {
    font-size: 13px;
    color: var(--text-secondary, #666);
}

[data-theme="dark"] .bet-amount-balance,
.dark .bet-amount-balance {
    color: rgba(255,255,255,0.7);
}

.bet-amount-balance span {
    color: #f7931a;
    font-weight: 600;
}

[data-theme="dark"] .bet-amount-balance span,
.dark .bet-amount-balance span {
    color: #fbbf24;
}

.bet-input-row {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}

.bet-input-wrapper {
    flex: 1;
    position: relative;
}

.bet-input {
    width: 100%;
    background: var(--bg-main, #f5f5f5);
    border: 2px solid var(--border, #e0e0e0);
    border-radius: 12px;
    padding: 16px 50px 16px 20px;
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary, #1a1a1a);
    outline: none;
    transition: all 0.3s;
}

[data-theme="dark"] .bet-input,
.dark .bet-input {
    background: rgba(0,0,0,0.4);
    border: 2px solid rgba(255,255,255,0.1);
    color: white;
}

.bet-input:focus {
    border-color: #f7931a;
    box-shadow: 0 0 20px rgba(247, 147, 26, 0.2);
}

.bet-input-suffix {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #f7931a;
    font-weight: 600;
    font-size: 16px;
}

[data-theme="dark"] .bet-input-suffix,
.dark .bet-input-suffix {
    color: #fbbf24;
}

.bet-submit-btn {
    padding: 16px 32px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
    white-space: nowrap;
}

.bet-submit-btn.up {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 8px 30px rgba(16, 185, 129, 0.4);
}

.bet-submit-btn.down {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    box-shadow: 0 8px 30px rgba(239, 68, 68, 0.4);
}

.bet-submit-btn:disabled {
    background: rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.3);
    box-shadow: none;
    cursor: not-allowed;
}

.bet-submit-btn:hover:not(:disabled) {
    transform: translateY(-2px);
}

.bet-quick-amounts {
    display: flex;
    gap: 8px;
}

.bet-quick-amount {
    flex: 1;
    padding: 10px;
    background: var(--bg-main, #f5f5f5);
    border: 1px solid var(--border, #e0e0e0);
    border-radius: 8px;
    color: var(--text-secondary, #666);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}

[data-theme="dark"] .bet-quick-amount,
.dark .bet-quick-amount {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.7);
}

.bet-quick-amount:hover {
    background: var(--bg-card, #fff);
    color: var(--text-primary, #1a1a1a);
    border-color: #f7931a;
}

[data-theme="dark"] .bet-quick-amount:hover,
.dark .bet-quick-amount:hover {
    background: rgba(255,255,255,0.1);
    color: white;
    border-color: rgba(255,255,255,0.2);
}

/* 결과 테이블 섹션 - 라이트 모드 */
.results-table-section {
    padding: 20px 24px;
    background: var(--bg-main, #f5f5f5);
    border-top: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .results-table-section,
.dark .results-table-section {
    background: rgba(0,0,0,0.2);
    border-top: 1px solid rgba(255,255,255,0.05);
}

.results-table-section .section-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary, #1a1a1a);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

[data-theme="dark"] .results-table-section .section-title,
.dark .results-table-section .section-title {
    color: white;
}

.results-table-section .section-title::before {
    content: '📊';
}

.results-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.results-table thead th {
    background: var(--bg-card, #fff);
    color: var(--text-secondary, #666);
    font-weight: 600;
    padding: 12px 10px;
    text-align: center;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .results-table thead th,
.dark .results-table thead th {
    background: rgba(0,0,0,0.4);
    color: rgba(255,255,255,0.7);
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.results-table tbody tr {
    border-bottom: 1px solid var(--border, #e0e0e0);
    transition: background 0.2s;
}

[data-theme="dark"] .results-table tbody tr,
.dark .results-table tbody tr {
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.results-table tbody tr:hover {
    background: var(--bg-card, #fff);
}

[data-theme="dark"] .results-table tbody tr:hover,
.dark .results-table tbody tr:hover {
    background: rgba(255,255,255,0.03);
}

.results-table tbody td {
    padding: 12px 10px;
    text-align: center;
    color: var(--text-primary, #1a1a1a);
}

[data-theme="dark"] .results-table tbody td,
.dark .results-table tbody td {
    color: rgba(255,255,255,0.9);
}

.results-table .round-col {
    color: var(--text-secondary, #666);
    font-weight: 600;
}

[data-theme="dark"] .results-table .round-col,
.dark .results-table .round-col {
    color: rgba(255,255,255,0.5);
}

.results-table .price-col {
    font-family: 'Courier New', monospace;
    font-weight: 600;
}

.results-table .diff-col.up {
    color: #10b981;
}

.results-table .diff-col.down {
    color: #ef4444;
}

.results-table .result-col {
    font-weight: 700;
}

.results-table .result-col.up {
    color: #10b981;
}

.results-table .result-col.down {
    color: #ef4444;
}

.results-table .result-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 12px;
}

.results-table .result-badge.up {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.results-table .result-badge.down {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

/* 내 배팅 내역 섹션 - 라이트 모드 */
.my-history-section {
    padding: 20px 24px;
    background: var(--bg-card, #fff);
    border-top: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .my-history-section,
.dark .my-history-section {
    background: rgba(0,0,0,0.3);
    border-top: 1px solid rgba(255,255,255,0.05);
}

.my-history-section .section-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary, #1a1a1a);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

[data-theme="dark"] .my-history-section .section-title,
.dark .my-history-section .section-title {
    color: white;
}

.my-history-section .section-title::before {
    content: '📋';
}

.my-history-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}

.my-history-table thead th {
    background: var(--bg-main, #f5f5f5);
    color: var(--text-secondary, #666);
    font-weight: 600;
    padding: 10px 8px;
    text-align: center;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .my-history-table thead th,
.dark .my-history-table thead th {
    background: rgba(0,0,0,0.4);
    color: rgba(255,255,255,0.7);
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.my-history-table tbody tr {
    border-bottom: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .my-history-table tbody tr,
.dark .my-history-table tbody tr {
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.my-history-table tbody tr:hover {
    background: var(--bg-main, #f5f5f5);
}

[data-theme="dark"] .my-history-table tbody tr:hover,
.dark .my-history-table tbody tr:hover {
    background: rgba(255,255,255,0.03);
}

.my-history-table tbody td {
    padding: 10px 8px;
    text-align: center;
    color: var(--text-primary, #1a1a1a);
}

[data-theme="dark"] .my-history-table tbody td,
.dark .my-history-table tbody td {
    color: rgba(255,255,255,0.9);
}

.my-history-table .bet-type-col.up {
    color: #10b981;
    font-weight: 600;
}

.my-history-table .bet-type-col.down {
    color: #ef4444;
    font-weight: 600;
}

.my-history-table .profit-col.win {
    color: #10b981;
    font-weight: 700;
}

.my-history-table .profit-col.lose {
    color: #ef4444;
    font-weight: 700;
}

.my-history-table .win-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
}

.my-history-table .win-badge.win {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.my-history-table .win-badge.lose {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.no-history {
    text-align: center;
    color: var(--text-secondary, #666);
    padding: 30px;
    font-size: 13px;
}

[data-theme="dark"] .no-history,
.dark .no-history {
    color: rgba(255,255,255,0.4);
}

/* 시간/가격 셀 스타일 - 라이트 모드 */
.my-history-table .time-col {
    font-size: 10px;
    color: var(--text-secondary, #666);
}

[data-theme="dark"] .my-history-table .time-col,
.dark .my-history-table .time-col {
    color: rgba(255,255,255,0.6);
}

.my-history-table .price-col {
    font-family: 'Courier New', monospace;
    font-size: 11px;
    color: var(--text-primary, #1a1a1a);
}

[data-theme="dark"] .my-history-table .price-col,
.dark .my-history-table .price-col {
    color: rgba(255,255,255,0.9);
}

@media (max-width: 640px) {
    .results-table, .my-history-table {
        font-size: 11px;
    }

    .results-table thead th, .my-history-table thead th {
        padding: 8px 4px;
        font-size: 9px;
    }

    .results-table tbody td, .my-history-table tbody td {
        padding: 8px 4px;
    }

    .results-table .result-badge {
        padding: 3px 6px;
        font-size: 10px;
    }
}

/* 내 베팅 표시 */
.my-bet-display {
    background: rgba(247, 147, 26, 0.1);
    border: 1px solid rgba(247, 147, 26, 0.3);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
    display: none;
}

.my-bet-display.show {
    display: block;
}

.my-bet-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.my-bet-type {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    font-weight: 700;
}

.my-bet-type.up { color: #10b981; }
.my-bet-type.down { color: #ef4444; }

.my-bet-amount {
    font-size: 18px;
    font-weight: 700;
    color: #fbbf24;
}

.my-bet-price {
    margin-top: 8px;
    font-size: 13px;
    color: var(--text-secondary, #666);
}

[data-theme="dark"] .my-bet-price,
.dark .my-bet-price {
    color: rgba(255,255,255,0.6);
}

.my-bet-price span {
    color: #f7931a;
    font-weight: 600;
}

/* 결과 모달 */
.result-modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}

.result-modal.show {
    opacity: 1;
    visibility: visible;
}

.result-modal-content {
    background: var(--bg-card, #fff);
    border-radius: 24px;
    padding: 40px;
    text-align: center;
    max-width: 400px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    transform: scale(0.9);
    transition: transform 0.3s;
    border: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .result-modal-content,
.dark .result-modal-content {
    background: linear-gradient(180deg, #1a1a2e, #0f0f1a);
    border: 1px solid rgba(255,255,255,0.1);
}

.result-modal.show .result-modal-content {
    transform: scale(1);
}

.result-icon {
    font-size: 80px;
    margin-bottom: 20px;
}

.result-title {
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 8px;
}

.result-title.win { color: #10b981; }
.result-title.lose { color: #ef4444; }

.result-amount {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary, #1a1a1a);
    margin-bottom: 24px;
}

[data-theme="dark"] .result-amount,
.dark .result-amount {
    color: white;
}

.result-details {
    background: var(--bg-main, #f5f5f5);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 24px;
}

[data-theme="dark"] .result-details,
.dark .result-details {
    background: rgba(0,0,0,0.3);
}

.result-detail-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 14px;
}

.result-detail-row:not(:last-child) {
    border-bottom: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .result-detail-row:not(:last-child),
.dark .result-detail-row:not(:last-child) {
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.result-detail-label { color: var(--text-secondary, #666); }
.result-detail-value { color: var(--text-primary, #1a1a1a); font-weight: 600; }

[data-theme="dark"] .result-detail-label,
.dark .result-detail-label { color: rgba(255,255,255,0.5); }
[data-theme="dark"] .result-detail-value,
.dark .result-detail-value { color: white; }

/* 라이트 모드 */
.result-detail-row.result-direction {
    background: var(--bg-main, #f0f0f0);
    margin: 8px -16px;
    padding: 12px 16px;
    font-size: 16px;
}

/* 다크 모드 */
[data-theme="dark"] .result-detail-row.result-direction,
.dark .result-detail-row.result-direction {
    background: rgba(255,255,255,0.05);
}

.result-detail-row.result-direction .result-detail-value {
    font-size: 16px;
    font-weight: 700;
}

.result-close-btn {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #f7931a, #ffab40);
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    color: white;
    cursor: pointer;
    transition: all 0.3s;
}

.result-close-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(247, 147, 26, 0.4);
}

/* 모바일 하단 고정 배팅 슬립 (기본은 숨김) */
.btc-mobile-slip {
    display: none;
}

/* 반응형 */
@media (max-width: 640px) {
    .result-modal {
        align-items: flex-start;
        padding: 12px;
        box-sizing: border-box;
    }

    .result-modal-content {
        width: 100%;
        max-width: 520px;
        padding: 22px 16px;
        border-radius: 18px;
        max-height: calc(100vh - 24px);
    }

    .result-icon {
        display: none; /* 모바일에서는 아이콘 숨김(세로 길이 축소) */
    }

    .result-title {
        font-size: 24px;
    }

    .result-amount {
        font-size: 20px;
        margin-bottom: 16px;
    }

    .result-details {
        padding: 12px;
        margin-bottom: 16px;
    }

    .result-detail-row {
        font-size: 13px;
        padding: 7px 0;
    }

    .result-detail-row.result-direction {
        margin: 6px -12px;
        padding: 10px 12px;
        font-size: 14px;
    }

    .result-detail-row.result-direction .result-detail-value {
        font-size: 14px;
    }

    .result-close-btn {
        padding: 14px;
        font-size: 15px;
        border-radius: 12px;
    }

    .btc-container {
        margin: 10px auto;
        padding: 10px;
        max-width: none;
        width: 100%;
        box-sizing: border-box;
    }

    .btc-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
    }

    .btc-point-display {
        width: 100%;
        justify-content: space-between;
        padding: 10px 14px;
    }

    .price-section {
        padding: 16px;
    }

    .current-price-wrapper {
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 14px;
    }

    .round-timer-section {
        width: 100%;
        justify-content: space-between;
    }

    .price-value {
        font-size: 30px;
        line-height: 1.1;
        word-break: break-word;
    }

    .chart-section {
        padding: 0 16px 16px;
    }

    .chart-wrapper {
        padding: 14px;
        height: 170px;
    }

    .betting-section {
        grid-template-columns: 1fr;
        padding: 16px;
        gap: 12px;
    }

    .bet-card {
        padding: 18px 16px;
        border-radius: 14px;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
    }

    .bet-card-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .bet-card-title {
        font-size: 18px;
    }

    .bet-card-desc {
        font-size: 12px;
        margin-bottom: 12px;
    }

    .bet-card-odds {
        font-size: 22px;
    }

    .bet-controls {
        padding: 0 16px 16px;
    }

    .bet-amount-section {
        padding: 16px;
        border-radius: 14px;
    }

    .bet-input-row {
        flex-direction: column;
        gap: 10px;
    }

    .bet-input {
        padding: 14px 44px 14px 16px;
        font-size: 20px;
        border-radius: 12px;
    }

    .bet-submit-btn {
        width: 100%;
        padding: 14px 16px;
        border-radius: 12px;
    }

    .bet-quick-amounts {
        flex-wrap: wrap;
        gap: 8px;
    }

    .bet-quick-amount {
        flex: 1 1 calc(33.333% - 6px);
        min-width: 90px;
        padding: 12px 10px;
        font-size: 13px;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
    }

    /* 모바일에서는 하단 고정 슬립 사용 */
    .betting-section,
    .bet-controls {
        display: none;
    }

    .btc-container {
        padding-bottom: 130px; /* 하단 고정 슬립 공간 (더 슬림하게) */
    }

    /* 모바일 슬립 - 라이트 모드 기본 */
    .btc-mobile-slip {
        display: block;
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2000;
        padding: 6px 8px 6px;
        background: rgba(255, 255, 255, 0.95);
        border-top: 1px solid rgba(0,0,0,0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-sizing: border-box;
    }

    /* 모바일 슬립 - 다크 모드 */
    [data-theme="dark"] .btc-mobile-slip,
    .dark .btc-mobile-slip {
        background: rgba(15, 15, 26, 0.92);
        border-top: 1px solid rgba(255,255,255,0.08);
    }

    .btc-slip-inner {
        max-width: 900px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .btc-slip-mybet {
        display: none;
        border-radius: 12px;
        padding: 8px 10px;
        background: rgba(247, 147, 26, 0.10);
        border: 1px solid rgba(247, 147, 26, 0.30);
    }

    .btc-slip-mybet.show {
        display: block;
    }

    .btc-slip-mybet-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .btc-slip-mybet-left {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }

    /* 라이트 모드 */
    .btc-slip-mybet-dir {
        font-weight: 900;
        font-size: 12px;
        color: rgba(0,0,0,0.85);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    /* 다크 모드 */
    [data-theme="dark"] .btc-slip-mybet-dir,
    .dark .btc-slip-mybet-dir {
        color: rgba(255,255,255,0.95);
    }

    .btc-slip-mybet-dir.up { color: #10b981; }
    .btc-slip-mybet-dir.down { color: #ef4444; }

    /* 라이트 모드 */
    .btc-slip-mybet-price {
        font-size: 11px;
        color: rgba(0,0,0,0.6);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* 다크 모드 */
    [data-theme="dark"] .btc-slip-mybet-price,
    .dark .btc-slip-mybet-price {
        color: rgba(255,255,255,0.70);
    }

    .btc-slip-mybet-amt {
        font-size: 12px;
        font-weight: 900;
        color: #fbbf24;
        white-space: nowrap;
    }

    .btc-slip-betgrid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
    }

    /* 라이트 모드 */
    .btc-slip-betbtn {
        height: 42px;
        border-radius: 11px;
        border: 2px solid rgba(0,0,0,0.12);
        background: rgba(0,0,0,0.04);
        color: rgba(0,0,0,0.8);
        font-size: 13px;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
    }

    /* 다크 모드 */
    [data-theme="dark"] .btc-slip-betbtn,
    .dark .btc-slip-betbtn {
        border: 2px solid rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.06);
        color: rgba(255,255,255,0.9);
    }

    .btc-slip-betbtn.up.selected {
        border-color: #10b981;
        box-shadow: 0 0 20px rgba(16,185,129,0.25);
    }

    .btc-slip-betbtn.down.selected {
        border-color: #ef4444;
        box-shadow: 0 0 20px rgba(239,68,68,0.25);
    }

    .btc-slip-betbtn.disabled {
        opacity: 0.45;
        pointer-events: none;
    }

    .btc-slip-row {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    /* 라이트 모드 */
    .btc-slip-input {
        flex: 1;
        height: 40px;
        border-radius: 12px;
        border: 2px solid rgba(0,0,0,0.12);
        background: rgba(0,0,0,0.04);
        color: #1a1a1a;
        font-size: 15px;
        font-weight: 800;
        padding: 0 12px;
        outline: none;
        min-width: 0;
        box-sizing: border-box;
        text-align: right;
    }

    /* 다크 모드 */
    [data-theme="dark"] .btc-slip-input,
    .dark .btc-slip-input {
        border: 2px solid rgba(255,255,255,0.12);
        background: rgba(0,0,0,0.35);
        color: white;
    }

    .btc-slip-submit {
        width: 104px;
        height: 40px;
        border-radius: 12px;
        border: none;
        font-size: 12px;
        font-weight: 900;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .btc-slip-submit.up {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btc-slip-submit.down {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    /* 라이트 모드 */
    .btc-slip-submit:disabled {
        background: rgba(0,0,0,0.08);
        color: rgba(0,0,0,0.35);
        cursor: not-allowed;
        transform: none;
    }

    /* 다크 모드 */
    [data-theme="dark"] .btc-slip-submit:disabled,
    .dark .btc-slip-submit:disabled {
        background: rgba(255,255,255,0.10);
        color: rgba(255,255,255,0.35);
    }

    .btc-slip-submit:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .btc-slip-quick {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 2px;
        scrollbar-width: none; /* Firefox */
    }

    .btc-slip-quick::-webkit-scrollbar { /* Chrome/Safari */
        width: 0;
        height: 0;
        display: none;
    }

    /* 라이트 모드 */
    .btc-slip-quick button {
        flex: 0 0 auto;
        min-width: 68px;
        height: 32px;
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,0.12);
        background: rgba(0,0,0,0.04);
        color: rgba(0,0,0,0.75);
        font-size: 12px;
        font-weight: 800;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
    }

    /* 다크 모드 */
    [data-theme="dark"] .btc-slip-quick button,
    .dark .btc-slip-quick button {
        border: 1px solid rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.06);
        color: rgba(255,255,255,0.85);
    }

    .btc-slip-quick button:active {
        transform: translateY(1px);
    }

    /* 표는 모바일에서 가독성 우선: 좌우 스크롤 허용 */
    .my-history-section {
        padding: 16px;
    }

    .my-history-table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .no-history {
        padding: 20px 10px;
    }
}
</style>

<div class="btc-container">
    <div class="btc-game">
        <!-- 헤더 -->
        <div class="btc-header">
            <div class="btc-logo">
                <div class="btc-icon">₿</div>
                <div class="btc-title">
                    <h1>BTC Predict</h1>
                    <span class="subtitle">가격 예측 게임</span>
                </div>
            </div>
            <div class="btc-point-display">
                <span>💰</span>
                <span class="amount" id="userPoint"><?php echo number_format($member_point); ?></span>
                <span class="unit">P</span>
            </div>
        </div>

        <!-- 가격 섹션 -->
        <div class="price-section">
            <div class="current-price-wrapper">
                <div class="current-price">
                    <div class="price-label">현재 가격</div>
                    <div class="price-value">
                        <span class="currency">$</span>
                        <span id="currentPrice"><?php echo number_format($btc_price, 2); ?></span>
                    </div>
                </div>

                <div class="round-timer-section">
                    <div class="round-info">
                        <div class="round-number">라운드 #<span id="roundNumber">1</span></div>
                        <div class="round-phase" id="roundPhase">베팅 중</div>
                    </div>
                    <div class="timer-circle">
                        <svg width="70" height="70">
                            <circle class="bg" cx="35" cy="35" r="30"/>
                            <circle class="progress" id="timerProgress" cx="35" cy="35" r="30"/>
                        </svg>
                        <div class="timer-text" id="timerText">30</div>
                    </div>
                </div>
            </div>

            <div class="price-change up" id="priceChange">
                <span class="arrow">▲</span>
                <span id="changeValue">+0.52%</span>
            </div>
        </div>

        <!-- 차트 -->
        <div class="chart-section">
            <div class="chart-wrapper">
                <canvas id="btcChart"></canvas>
                <div class="chart-overlay">
                    <div class="chart-stat">
                        <div class="chart-stat-label">시작가</div>
                        <div class="chart-stat-value" id="startPrice">$42,128</div>
                    </div>
                    <div class="chart-stat">
                        <div class="chart-stat-label">잠금가</div>
                        <div class="chart-stat-value" id="lockPrice">-</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 베팅 카드 -->
        <div class="betting-section">
            <div class="bet-card up" onclick="selectBet('up')">
                <div class="bet-card-icon">📈</div>
                <div class="bet-card-title">UP</div>
                <div class="bet-card-desc">가격이 상승할 것으로 예측</div>
                <div class="bet-card-odds">x1.95</div>
            </div>

            <div class="bet-card down" onclick="selectBet('down')">
                <div class="bet-card-icon">📉</div>
                <div class="bet-card-title">DOWN</div>
                <div class="bet-card-desc">가격이 하락할 것으로 예측</div>
                <div class="bet-card-odds">x1.95</div>
            </div>
        </div>

        <!-- 베팅 컨트롤 -->
        <div class="bet-controls">
            <!-- 내 베팅 표시 -->
            <div class="my-bet-display" id="myBetDisplay">
                <div class="my-bet-info">
                    <div class="my-bet-type" id="myBetType">
                        <span id="myBetIcon">📈</span>
                        <span id="myBetDirection">UP</span>
                    </div>
                    <div class="my-bet-amount" id="myBetAmount">1,000P</div>
                </div>
                <div class="my-bet-price">베팅 시점: <span id="myBetPrice">$97,000</span></div>
            </div>

            <div class="bet-amount-section">
                <div class="bet-amount-header">
                    <span class="bet-amount-label">베팅 금액</span>
                    <span class="bet-amount-balance">보유: <span id="balanceDisplay"><?php echo number_format($member_point); ?></span>P</span>
                </div>

                <div class="bet-input-row">
                    <div class="bet-input-wrapper">
                        <input type="number" class="bet-input" id="betInput" value="100" min="10">
                        <span class="bet-input-suffix">P</span>
                    </div>
                    <button class="bet-submit-btn" id="submitBtn" onclick="placeBet()" disabled>
                        예측 선택
                    </button>
                </div>

                <div class="bet-quick-amounts">
                    <button class="bet-quick-amount" onclick="setBet(100)">100</button>
                    <button class="bet-quick-amount" onclick="setBet(500)">500</button>
                    <button class="bet-quick-amount" onclick="setBet(1000)">1K</button>
                    <button class="bet-quick-amount" onclick="setBet(5000)">5K</button>
                    <button class="bet-quick-amount" onclick="multiplyBet(2)">2x</button>
                    <button class="bet-quick-amount" onclick="setMaxBet()">MAX</button>
                </div>
            </div>
        </div>

        <!-- 모바일 하단 고정 배팅 슬립 (모바일에서만 표시) -->
        <div class="btc-mobile-slip" id="btcMobileSlip">
            <div class="btc-slip-inner">
                <div class="btc-slip-mybet" id="myBetDisplayMobile">
                    <div class="btc-slip-mybet-row">
                        <div class="btc-slip-mybet-left">
                            <div class="btc-slip-mybet-dir" id="myBetDirectionMobile">-</div>
                            <div class="btc-slip-mybet-price" id="myBetPriceMobile">-</div>
                        </div>
                        <div class="btc-slip-mybet-amt" id="myBetAmountMobile">-</div>
                    </div>
                </div>
                <div class="btc-slip-betgrid">
                    <button type="button" class="btc-slip-betbtn up" id="btcSlipUp" onclick="selectBet('up')">📈 UP</button>
                    <button type="button" class="btc-slip-betbtn down" id="btcSlipDown" onclick="selectBet('down')">📉 DOWN</button>
                </div>
                <div class="btc-slip-row">
                    <input type="number" class="btc-slip-input" id="betInputMobile" value="100" min="10" inputmode="numeric">
                    <button class="btc-slip-submit" id="submitBtnMobile" onclick="placeBet()" disabled>예측 선택</button>
                </div>
                <div class="btc-slip-quick">
                    <button type="button" onclick="setBet(100)">100</button>
                    <button type="button" onclick="setBet(500)">500</button>
                    <button type="button" onclick="setBet(1000)">1K</button>
                    <button type="button" onclick="setBet(5000)">5K</button>
                    <button type="button" onclick="multiplyBet(2)">2x</button>
                    <button type="button" onclick="setMaxBet()">MAX</button>
                </div>
            </div>
        </div>

        <!-- 내 배팅 내역 (DB에서 로드) -->
        <div class="my-history-section">
            <div class="section-title">내 배팅 내역</div>
            <table class="my-history-table">
                <thead>
                    <tr>
                        <th>시간</th>
                        <th>예측</th>
                        <th>배팅금</th>
                        <th>잠금가</th>
                        <th>종료가</th>
                        <th>결과</th>
                        <th>손익</th>
                    </tr>
                </thead>
                <tbody id="myHistoryTableBody">
                    <!-- DB에서 로드 -->
                </tbody>
            </table>
            <div class="no-history" id="noHistoryMsg">배팅 내역이 없습니다.</div>
        </div>
    </div>
</div>

<!-- 결과 모달 -->
<div class="result-modal" id="resultModal">
    <div class="result-modal-content">
        <div class="result-icon" id="modalIcon">🎉</div>
        <div class="result-title" id="modalTitle">WIN!</div>
        <div class="result-amount" id="modalAmount">+1,950P</div>
        <div class="result-details">
            <div class="result-detail-row">
                <span class="result-detail-label">잠금가</span>
                <span class="result-detail-value" id="modalLockPrice">$97,000</span>
            </div>
            <div class="result-detail-row">
                <span class="result-detail-label">마감가</span>
                <span class="result-detail-value" id="modalEndPrice">$97,500</span>
            </div>
            <div class="result-detail-row result-direction">
                <span class="result-detail-label">결과</span>
                <span class="result-detail-value" id="modalResult">📈 UP 입니다!</span>
            </div>
            <div class="result-detail-row">
                <span class="result-detail-label">내 예측</span>
                <span class="result-detail-value" id="modalPrediction">UP</span>
            </div>
            <div class="result-detail-row">
                <span class="result-detail-label">베팅 시점</span>
                <span class="result-detail-value" id="modalBetPrice">$97,000</span>
            </div>
            <div class="result-detail-row">
                <span class="result-detail-label">베팅 금액</span>
                <span class="result-detail-value" id="modalBet">1,000P</span>
            </div>
        </div>
        <button class="result-close-btn" onclick="closeResultModal()">확인</button>
    </div>
</div>

<script>
// 게임 상태
let gamePhase = 'betting'; // betting, locked, ended
let roundNumber = 1;
let selectedBet = null; // 'up' or 'down'
let currentBetAmount = 0;
let hasBet = false;
let userPoint = <?php echo $member_point; ?>;
let betPrice = 0; // 베팅 시점 가격

// 가격 데이터 - 실제 BTC 가격 기반
let basePrice = <?php echo $btc_price; ?>;
let currentPrice = basePrice;
let startPrice = basePrice;
let realBtcPrice = basePrice; // API에서 가져온 실제 가격
let lockPrice = 0;
let priceHistory = [];

// 타이머
let roundTime = 30; // 베팅 시간
let lockTime = 10;  // 잠금 시간
let currentTime = roundTime;
let timerInterval = null;

// 내 배팅 내역 (DB에서 로드)
let myBetHistory = <?php echo $db_bet_history_json; ?>;

// 캔버스
const canvas = document.getElementById('btcChart');
const ctx = canvas.getContext('2d');
let candleData = [];

// 초기화
function init() {
    fetchHistoricalCandles(); // Binance에서 과거 캔들 데이터 가져오기
    startPriceAnimation();
    updateMyHistoryTable(); // DB에서 로드된 배팅 내역 표시
}

// Binance에서 과거 캔들 데이터 가져오기
async function fetchHistoricalCandles() {
    try {
        // 1분봉 20개 가져오기 (약 20분간의 데이터)
        const response = await fetch('https://api.binance.com/api/v3/klines?symbol=BTCUSDT&interval=1m&limit=20');
        const data = await response.json();

        candleData = data.map(candle => ({
            open: parseFloat(candle[1]),
            high: parseFloat(candle[2]),
            low: parseFloat(candle[3]),
            close: parseFloat(candle[4]),
            time: new Date(candle[0])
        }));

        // 마지막 캔들의 종가로 현재 가격 설정
        if (candleData.length > 0) {
            const lastCandle = candleData[candleData.length - 1];
            basePrice = lastCandle.close;
            currentPrice = lastCandle.close;
            startPrice = lastCandle.close;
            realBtcPrice = lastCandle.close;

            document.getElementById('startPrice').textContent = '$' + formatPrice(startPrice);
            document.getElementById('currentPrice').textContent = formatPrice(currentPrice);
        }

        drawChart();
        startRound();

        console.log('✅ Binance 과거 캔들 데이터 로드 완료:', candleData.length + '개');

        // 1분마다 새로운 과거 캔들 데이터 갱신 (변동성 유지)
        setInterval(refreshCandleData, 60000);
    } catch (e) {
        console.error('캔들 데이터 로드 실패:', e);
        // 실패 시 랜덤 데이터로 대체
        generateCandleData();
        startRound();
    }
}

// 1분마다 Binance에서 새 캔들 데이터 갱신
async function refreshCandleData() {
    try {
        const response = await fetch('https://api.binance.com/api/v3/klines?symbol=BTCUSDT&interval=1m&limit=20');
        const data = await response.json();

        // 기존 캔들 데이터를 새 데이터로 교체
        const newCandles = data.map(candle => ({
            open: parseFloat(candle[1]),
            high: parseFloat(candle[2]),
            low: parseFloat(candle[3]),
            close: parseFloat(candle[4]),
            time: new Date(candle[0])
        }));

        // 새 캔들 데이터로 교체
        candleData = newCandles;

        console.log('✅ 캔들 데이터 갱신 완료');
    } catch (e) {
        console.error('캔들 데이터 갱신 실패:', e);
    }
}


function generateCandleData() {
    candleData = [];
    // 가격 변동폭을 현재 가격의 약 0.3% 수준으로 설정 (더 현실적)
    const priceVolatility = basePrice * 0.003;
    let price = basePrice;

    const now = new Date();

    // 과거 20개 캔들 생성 (3초 간격)
    for (let i = 19; i >= 0; i--) {
        const candleTime = new Date(now.getTime() - i * 3000);
        const open = price;
        const volatility = priceVolatility * (0.3 + Math.random() * 0.7);
        const direction = Math.random() > 0.5 ? 1 : -1;
        const close = open + direction * volatility * (0.5 + Math.random());
        const high = Math.max(open, close) + Math.random() * volatility * 0.5;
        const low = Math.min(open, close) - Math.random() * volatility * 0.5;

        candleData.push({
            open,
            high,
            low,
            close,
            time: candleTime
        });
        price = close;
    }

    // 현재 가격을 마지막 캔들 종가로 설정
    currentPrice = price;
    startPrice = price;
    realBtcPrice = basePrice;

    drawChart();
}

function drawChart() {
    const rect = canvas.parentElement.getBoundingClientRect();
    canvas.width = rect.width;
    canvas.height = rect.height;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    if (candleData.length === 0) return;

    // 여백 설정
    const padding = { top: 20, right: 80, bottom: 40, left: 20 };
    const chartWidth = canvas.width - padding.left - padding.right;
    const chartHeight = canvas.height - padding.top - padding.bottom;

    // 가격 범위 계산 - 현재 가격을 항상 포함하도록 동적 조정
    const prices = candleData.flatMap(c => [c.high, c.low]);
    prices.push(currentPrice);
    let minPrice = Math.min(...prices);
    let maxPrice = Math.max(...prices);

    // 현재 가격이 범위를 벗어나면 범위 확장
    let priceRange = maxPrice - minPrice;

    // 최소 범위 보장 (가격의 0.5% - 변동이 없어도 차트가 평평하지 않게)
    const minRange = currentPrice * 0.005;
    if (priceRange < minRange) {
        const center = (maxPrice + minPrice) / 2;
        minPrice = center - minRange / 2;
        maxPrice = center + minRange / 2;
        priceRange = minRange;
    }

    const buffer = Math.max(priceRange * 0.15, currentPrice * 0.001);

    // 현재 가격이 항상 차트 내에 표시되도록 조정
    const adjustedMin = Math.min(minPrice, currentPrice) - buffer;
    const adjustedMax = Math.max(maxPrice, currentPrice) + buffer;
    const adjustedRange = adjustedMax - adjustedMin;

    // 배경 그라데이션
    const bgGradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
    bgGradient.addColorStop(0, 'rgba(16, 185, 129, 0.05)');
    bgGradient.addColorStop(1, 'rgba(239, 68, 68, 0.05)');
    ctx.fillStyle = bgGradient;
    ctx.fillRect(padding.left, padding.top, chartWidth, chartHeight);

    // 가격 그리드 라인 (5개)
    ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
    ctx.lineWidth = 1;
    ctx.font = '11px "Noto Sans KR", sans-serif';
    ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
    ctx.textAlign = 'left';

    for (let i = 0; i <= 4; i++) {
        const y = padding.top + (chartHeight / 4) * i;
        const price = adjustedMax - (adjustedRange / 4) * i;

        // 그리드 라인
        ctx.beginPath();
        ctx.moveTo(padding.left, y);
        ctx.lineTo(padding.left + chartWidth, y);
        ctx.stroke();

        // 가격 라벨 (우측)
        ctx.fillText('$' + formatPrice(price), padding.left + chartWidth + 8, y + 4);
    }

    // 시간 라벨 (하단) - 실제 캔들 시간 사용
    ctx.textAlign = 'center';
    ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';

    const timeLabels = 5;
    for (let i = 0; i < timeLabels; i++) {
        const x = padding.left + (chartWidth / (timeLabels - 1)) * i;
        const candleIndex = Math.floor((candleData.length - 1) * (i / (timeLabels - 1)));
        const candle = candleData[candleIndex];

        if (candle && candle.time) {
            const t = candle.time;
            const timeStr = t.getHours().toString().padStart(2, '0') + ':' +
                           t.getMinutes().toString().padStart(2, '0') + ':' +
                           t.getSeconds().toString().padStart(2, '0');
            ctx.fillText(timeStr, x, canvas.height - 10);
        }
    }

    // 시간축 라인
    ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
    ctx.beginPath();
    ctx.moveTo(padding.left, padding.top + chartHeight);
    ctx.lineTo(padding.left + chartWidth, padding.top + chartHeight);
    ctx.stroke();

    // 캔들 그리기
    const candleWidth = chartWidth / candleData.length;
    const gap = candleWidth * 0.3;

    candleData.forEach((candle, i) => {
        const x = padding.left + i * candleWidth + gap / 2;
        const width = candleWidth - gap;

        const yHigh = padding.top + chartHeight - ((candle.high - adjustedMin) / adjustedRange) * chartHeight;
        const yLow = padding.top + chartHeight - ((candle.low - adjustedMin) / adjustedRange) * chartHeight;
        const yOpen = padding.top + chartHeight - ((candle.open - adjustedMin) / adjustedRange) * chartHeight;
        const yClose = padding.top + chartHeight - ((candle.close - adjustedMin) / adjustedRange) * chartHeight;

        const isGreen = candle.close >= candle.open;
        const color = isGreen ? '#10b981' : '#ef4444';

        // 심지 그림자
        ctx.shadowColor = color;
        ctx.shadowBlur = 3;

        // 심지
        ctx.strokeStyle = color;
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.moveTo(x + width / 2, yHigh);
        ctx.lineTo(x + width / 2, yLow);
        ctx.stroke();

        // 몸통
        ctx.fillStyle = color;
        const bodyTop = Math.min(yOpen, yClose);
        const bodyHeight = Math.abs(yClose - yOpen) || 2;
        ctx.fillRect(x, bodyTop, width, bodyHeight);

        ctx.shadowBlur = 0;
    });

    // 현재 가격 라인
    const currentY = padding.top + chartHeight - ((currentPrice - adjustedMin) / adjustedRange) * chartHeight;

    // 라인 글로우 효과
    ctx.shadowColor = '#f7931a';
    ctx.shadowBlur = 10;
    ctx.setLineDash([8, 4]);
    ctx.strokeStyle = '#f7931a';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(padding.left, currentY);
    ctx.lineTo(padding.left + chartWidth, currentY);
    ctx.stroke();
    ctx.setLineDash([]);
    ctx.shadowBlur = 0;

    // 현재 가격 라벨 박스
    const priceLabel = '$' + formatPrice(currentPrice);
    ctx.font = 'bold 12px "Noto Sans KR", sans-serif';
    const labelWidth = ctx.measureText(priceLabel).width + 16;

    // 박스 배경
    ctx.fillStyle = '#f7931a';
    ctx.shadowColor = '#f7931a';
    ctx.shadowBlur = 15;
    roundRect(ctx, padding.left + chartWidth + 4, currentY - 12, labelWidth, 24, 4);
    ctx.fill();
    ctx.shadowBlur = 0;

    // 가격 텍스트
    ctx.fillStyle = '#000';
    ctx.textAlign = 'left';
    ctx.fillText(priceLabel, padding.left + chartWidth + 12, currentY + 4);

    // LIVE 표시
    ctx.fillStyle = '#ef4444';
    ctx.font = 'bold 10px sans-serif';
    ctx.textAlign = 'left';
    const liveX = padding.left + 8;
    const liveY = padding.top + 16;

    // LIVE 점 (깜빡임)
    if (Math.floor(Date.now() / 500) % 2 === 0) {
        ctx.beginPath();
        ctx.arc(liveX, liveY - 3, 4, 0, Math.PI * 2);
        ctx.fill();
    }
    ctx.fillText('LIVE', liveX + 10, liveY);
}

// 둥근 사각형 그리기 헬퍼
function roundRect(ctx, x, y, width, height, radius) {
    ctx.beginPath();
    ctx.moveTo(x + radius, y);
    ctx.lineTo(x + width - radius, y);
    ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
    ctx.lineTo(x + width, y + height - radius);
    ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
    ctx.lineTo(x + radius, y + height);
    ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
    ctx.lineTo(x, y + radius);
    ctx.quadraticCurveTo(x, y, x + radius, y);
    ctx.closePath();
}

function startPriceAnimation() {
    // Binance WebSocket으로 실시간 BTC 가격 받기
    connectBinanceWebSocket();

    // 100ms마다 부드러운 가격 변동 + UI 업데이트
    setInterval(() => {
        // 실제 가격 방향으로 자연스럽게 이동
        const targetDiff = realBtcPrice - currentPrice;
        const smoothing = 0.1; // 빠르게 따라가기

        currentPrice += targetDiff * smoothing;

        // 가격 표시 업데이트
        document.getElementById('currentPrice').textContent = formatPrice(currentPrice);

        // 변동률 계산 및 표시
        const percentChange = ((currentPrice - startPrice) / startPrice) * 100;
        const changeEl = document.getElementById('priceChange');
        const changeValueEl = document.getElementById('changeValue');

        if (percentChange >= 0) {
            changeEl.className = 'price-change up';
            changeEl.querySelector('.arrow').textContent = '▲';
            changeValueEl.textContent = '+' + percentChange.toFixed(3) + '%';
        } else {
            changeEl.className = 'price-change down';
            changeEl.querySelector('.arrow').textContent = '▼';
            changeValueEl.textContent = percentChange.toFixed(3) + '%';
        }
    }, 100);

    // 500ms마다 차트 업데이트 (캔들 + 차트 리드로우) - 더 부드러운 업데이트
    setInterval(() => {
        updateLastCandle();
    }, 500);
}

// Binance WebSocket 연결 (실시간 BTC/USDT 가격)
let binanceWs = null;

function connectBinanceWebSocket() {
    // Binance WebSocket - BTC/USDT 실시간 티커
    binanceWs = new WebSocket('wss://stream.binance.com:9443/ws/btcusdt@trade');

    binanceWs.onopen = () => {
        console.log('✅ Binance WebSocket 연결됨 - 실시간 BTC 가격 수신 중');
    };

    binanceWs.onmessage = (event) => {
        try {
            const data = JSON.parse(event.data);
            if (data.p) {
                realBtcPrice = parseFloat(data.p);
            }
        } catch (e) {
            // 파싱 에러 무시
        }
    };

    binanceWs.onerror = (error) => {
        console.log('WebSocket 에러, 재연결 시도...');
    };

    binanceWs.onclose = () => {
        console.log('WebSocket 연결 종료, 3초 후 재연결...');
        setTimeout(connectBinanceWebSocket, 3000);
    };
}

function updateLastCandle() {
    if (candleData.length > 0) {
        const last = candleData[candleData.length - 1];
        const now = new Date();

        // 마지막 캔들이 1분 이상 된 경우 새 캔들 추가
        if (last.time && (now - last.time) > 60000) {
            candleData.push({
                open: currentPrice,
                high: currentPrice,
                low: currentPrice,
                close: currentPrice,
                time: now
            });

            // 최대 25개 캔들 유지
            if (candleData.length > 25) {
                candleData.shift();
            }
        } else {
            // 기존 캔들 업데이트
            last.close = currentPrice;
            last.high = Math.max(last.high, currentPrice);
            last.low = Math.min(last.low, currentPrice);
        }

        drawChart();
    }
}

function startRound() {
    gamePhase = 'betting';
    currentTime = roundTime;
    selectedBet = null;
    hasBet = false;
    currentBetAmount = 0;
    startPrice = currentPrice;
    lockPrice = 0;

    document.getElementById('startPrice').textContent = '$' + formatPrice(startPrice);
    document.getElementById('lockPrice').textContent = '-';
    document.getElementById('roundNumber').textContent = roundNumber;
    document.getElementById('roundPhase').textContent = '베팅 중';
    document.getElementById('roundPhase').className = 'round-phase';
    document.getElementById('myBetDisplay').classList.remove('show');
    const myBetMobile = document.getElementById('myBetDisplayMobile');
    if (myBetMobile) myBetMobile.classList.remove('show');

    updateBetCards();
    updateSubmitButton();
    startTimer();
}

function startTimer() {
    if (timerInterval) clearInterval(timerInterval);

    updateTimerDisplay();

    timerInterval = setInterval(() => {
        currentTime--;
        updateTimerDisplay();

        if (currentTime <= 0) {
            if (gamePhase === 'betting') {
                lockBets();
            } else if (gamePhase === 'locked') {
                endRound();
            }
        }
    }, 1000);
}

function updateTimerDisplay() {
    const timerText = document.getElementById('timerText');
    const timerProgress = document.getElementById('timerProgress');

    timerText.textContent = currentTime;

    const circumference = 188.495;
    const maxTime = gamePhase === 'betting' ? roundTime : lockTime;
    const progress = currentTime / maxTime;
    timerProgress.style.strokeDashoffset = circumference * (1 - progress);

    // 색상 변경
    timerProgress.classList.remove('warning', 'danger');
    if (currentTime <= 5) {
        timerProgress.classList.add('danger');
    } else if (currentTime <= 10) {
        timerProgress.classList.add('warning');
    }
}

function lockBets() {
    gamePhase = 'locked';
    currentTime = lockTime;
    lockPrice = currentPrice;

    document.getElementById('lockPrice').textContent = '$' + formatPrice(lockPrice);
    document.getElementById('roundPhase').textContent = '베팅 마감';
    document.getElementById('roundPhase').className = 'round-phase locked';

    updateBetCards();
    updateSubmitButton();
}

function endRound() {
    clearInterval(timerInterval);
    gamePhase = 'ended';

    document.getElementById('roundPhase').textContent = '결과 확인';
    document.getElementById('roundPhase').className = 'round-phase ended';

    // 결과 판정
    const result = currentPrice > lockPrice ? 'up' : 'down';
    const endPrice = currentPrice;

    // 베팅 결과 처리
    if (hasBet) {
        const isWin = selectedBet === result;
        const winAmount = isWin ? Math.floor(currentBetAmount * 1.95) : 0;
        const profit = isWin ? winAmount - currentBetAmount : -currentBetAmount;

        // 내 배팅 내역에 추가 (세션 중 실시간 표시용)
        const now = new Date();
        const datetime = now.getFullYear() + '-' +
            String(now.getMonth()+1).padStart(2,'0') + '-' +
            String(now.getDate()).padStart(2,'0') + ' ' +
            String(now.getHours()).padStart(2,'0') + ':' +
            String(now.getMinutes()).padStart(2,'0') + ':' +
            String(now.getSeconds()).padStart(2,'0');

        myBetHistory.unshift({
            id: 0,
            prediction: selectedBet,
            betAmount: currentBetAmount,
            lockPrice: lockPrice,
            endPrice: endPrice,
            actualResult: result,
            isWin: isWin,
            profit: profit,
            datetime: datetime
        });

        // 최대 20개 유지
        if (myBetHistory.length > 20) myBetHistory.pop();
        updateMyHistoryTable();

        showResultModal(isWin, profit, selectedBet, result);

        // 서버에 결과 전송 (가격 정보 포함)
        sendResultToServer(isWin, profit, result);
    }

    // 다음 라운드
    setTimeout(() => {
        roundNumber++;
        startRound();
    }, 3000);
}

function selectBet(direction) {
    if (gamePhase !== 'betting' || hasBet) return;

    selectedBet = direction;
    updateBetCards();
    updateSubmitButton();
}

function updateBetCards() {
    const upCard = document.querySelector('.bet-card.up');
    const downCard = document.querySelector('.bet-card.down');
    const slipUp = document.getElementById('btcSlipUp');
    const slipDown = document.getElementById('btcSlipDown');

    upCard.classList.remove('selected', 'disabled');
    downCard.classList.remove('selected', 'disabled');
    if (slipUp) slipUp.classList.remove('selected', 'disabled');
    if (slipDown) slipDown.classList.remove('selected', 'disabled');

    if (gamePhase !== 'betting' || hasBet) {
        upCard.classList.add('disabled');
        downCard.classList.add('disabled');
        if (slipUp) slipUp.classList.add('disabled');
        if (slipDown) slipDown.classList.add('disabled');
    }

    if (selectedBet === 'up') {
        upCard.classList.add('selected');
        if (slipUp) slipUp.classList.add('selected');
    } else if (selectedBet === 'down') {
        downCard.classList.add('selected');
        if (slipDown) slipDown.classList.add('selected');
    }
}

function getBetInputEls() {
    return [document.getElementById('betInput'), document.getElementById('betInputMobile')].filter(Boolean);
}

function getSubmitBtns() {
    return [document.getElementById('submitBtn'), document.getElementById('submitBtnMobile')].filter(Boolean);
}

function updateSubmitButton() {
    const btns = getSubmitBtns();
    btns.forEach((btn) => {
        if (!btn) return;
        const isDesktop = btn.id === 'submitBtn';

        if (hasBet) {
            btn.textContent = '베팅 완료';
            btn.disabled = true;
            btn.className = isDesktop ? 'bet-submit-btn' : 'btc-slip-submit';
        } else if (!selectedBet) {
            btn.textContent = '예측 선택';
            btn.disabled = true;
            btn.className = isDesktop ? 'bet-submit-btn' : 'btc-slip-submit';
        } else if (gamePhase !== 'betting') {
            btn.textContent = '베팅 마감';
            btn.disabled = true;
            btn.className = isDesktop ? 'bet-submit-btn' : 'btc-slip-submit';
        } else {
            btn.textContent = selectedBet === 'up' ? '📈 UP 베팅' : '📉 DOWN 베팅';
            btn.disabled = false;
            btn.className = isDesktop ? `bet-submit-btn ${selectedBet}` : `btc-slip-submit ${selectedBet}`;
        }
    });
}

function updateMyHistoryTable() {
    const tbody = document.getElementById('myHistoryTableBody');
    const noHistoryMsg = document.getElementById('noHistoryMsg');

    if (myBetHistory.length === 0) {
        tbody.innerHTML = '';
        noHistoryMsg.style.display = 'block';
        return;
    }

    noHistoryMsg.style.display = 'none';

    tbody.innerHTML = myBetHistory.map(b => {
        const predClass = b.prediction === 'up' ? 'up' : 'down';
        const profitClass = b.isWin ? 'win' : 'lose';
        const profitSign = b.profit >= 0 ? '+' : '';

        // 시간 표시 (datetime에서 시:분 추출)
        let timeDisplay = '-';
        if (b.datetime) {
            const parts = b.datetime.split(' ');
            if (parts.length >= 2) {
                const timeParts = parts[1].split(':');
                timeDisplay = parts[0].substring(5) + ' ' + timeParts[0] + ':' + timeParts[1];
            }
        }

        // 가격 표시 (DB에서 로드된 데이터는 숫자, 세션 데이터는 그대로)
        const lockPriceDisplay = b.lockPrice ? '$' + formatPrice(b.lockPrice) : '-';
        const endPriceDisplay = b.endPrice ? '$' + formatPrice(b.endPrice) : '-';

        return `
            <tr>
                <td class="time-col">${timeDisplay}</td>
                <td class="bet-type-col ${predClass}">
                    ${b.prediction === 'up' ? '▲ UP' : '▼ DOWN'}
                </td>
                <td>${numberFormat(b.betAmount)}P</td>
                <td class="price-col">${lockPriceDisplay}</td>
                <td class="price-col">${endPriceDisplay}</td>
                <td>
                    <span class="win-badge ${profitClass}">${b.isWin ? 'WIN' : 'LOSE'}</span>
                </td>
                <td class="profit-col ${profitClass}">${profitSign}${numberFormat(b.profit)}P</td>
            </tr>
        `;
    }).join('');
}

async function placeBet() {
    if (!selectedBet || gamePhase !== 'betting' || hasBet) return;

    const inputs = getBetInputEls();
    const bet = parseInt((inputs[0] ? inputs[0].value : '0'), 10) || 0;

    if (bet < 10) {
        alert('최소 베팅 금액은 10P입니다.');
        return;
    }

    if (bet > userPoint) {
        alert('포인트가 부족합니다.');
        return;
    }

    currentBetAmount = bet;
    hasBet = true;
    betPrice = currentPrice; // 베팅 시점 가격 저장

    // 입력값 동기화(PC/모바일)
    inputs.forEach(el => { el.value = bet; });

    // UI 업데이트
    document.getElementById('myBetDisplay').classList.add('show');
    document.getElementById('myBetType').className = `my-bet-type ${selectedBet}`;
    document.getElementById('myBetIcon').textContent = selectedBet === 'up' ? '📈' : '📉';
    document.getElementById('myBetDirection').textContent = selectedBet.toUpperCase();
    document.getElementById('myBetAmount').textContent = numberFormat(bet) + 'P';
    document.getElementById('myBetPrice').textContent = '$' + formatPrice(betPrice);

    // 모바일 하단 슬립용 "내 배팅" 표시
    const myBetMobile = document.getElementById('myBetDisplayMobile');
    if (myBetMobile) {
        myBetMobile.classList.add('show');
        const dirEl = document.getElementById('myBetDirectionMobile');
        const priceEl = document.getElementById('myBetPriceMobile');
        const amtEl = document.getElementById('myBetAmountMobile');
        if (dirEl) {
            dirEl.className = `btc-slip-mybet-dir ${selectedBet}`;
            dirEl.textContent = selectedBet === 'up' ? '📈 UP' : '📉 DOWN';
        }
        if (priceEl) priceEl.textContent = '베팅 시점: $' + formatPrice(betPrice);
        if (amtEl) amtEl.textContent = numberFormat(bet) + 'P';
    }

    updateBetCards();
    updateSubmitButton();

    // 서버에 베팅 전송
    try {
        const response = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=btc_bet&bet=${bet}&betType=${selectedBet}`
        });

        const result = await response.json();
        if (result.success) {
            userPoint = result.newPoint;
            document.getElementById('userPoint').textContent = numberFormat(userPoint);
            document.getElementById('balanceDisplay').textContent = numberFormat(userPoint);
        }
    } catch (e) {
        console.error(e);
    }
}

async function sendResultToServer(isWin, profit, actualResult) {
    try {
        // 가격 정보와 함께 결과 전송
        const lockPriceValue = lockPrice.toFixed(2);
        const endPriceValue = currentPrice.toFixed(2);

        await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=btc_result&bet=${currentBetAmount}&isWin=${isWin ? 1 : 0}&profit=${profit}&betType=${selectedBet}&lockPrice=${lockPriceValue}&endPrice=${endPriceValue}&result=${actualResult}`
        });

        // 포인트 새로고침
        const response = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=get_point'
        });

        const result = await response.json();
        if (result.success) {
            userPoint = result.point;
            document.getElementById('userPoint').textContent = numberFormat(userPoint);
            document.getElementById('balanceDisplay').textContent = numberFormat(userPoint);
        }
    } catch (e) {
        console.error(e);
    }
}

function showResultModal(isWin, profit, prediction, result) {
    const modal = document.getElementById('resultModal');
    const icon = document.getElementById('modalIcon');
    const title = document.getElementById('modalTitle');
    const amount = document.getElementById('modalAmount');
    const lockPriceEl = document.getElementById('modalLockPrice');
    const endPriceEl = document.getElementById('modalEndPrice');
    const resultEl = document.getElementById('modalResult');
    const predEl = document.getElementById('modalPrediction');
    const betPriceEl = document.getElementById('modalBetPrice');
    const betEl = document.getElementById('modalBet');

    // 승패 표시
    if (isWin) {
        icon.textContent = '🎉';
        title.textContent = 'WIN!';
        title.className = 'result-title win';
        // 베팅금 + 수익 = 총 획득 금액으로 표시
        const totalWin = currentBetAmount + profit;
        amount.textContent = numberFormat(totalWin) + 'P';
    } else {
        icon.textContent = '😢';
        title.textContent = 'LOSE';
        title.className = 'result-title lose';
        amount.textContent = numberFormat(profit) + 'P';
    }

    // 잠금가, 마감가 표시
    lockPriceEl.textContent = '$' + formatPrice(lockPrice);
    endPriceEl.textContent = '$' + formatPrice(currentPrice);

    // 결과 방향 표시
    const percentChange = ((currentPrice - lockPrice) / lockPrice) * 100;
    if (result === 'up') {
        resultEl.innerHTML = `<span style="color:#10b981">📈 UP 입니다! (${percentChange >= 0 ? '+' : ''}${percentChange.toFixed(3)}%)</span>`;
    } else {
        resultEl.innerHTML = `<span style="color:#ef4444">📉 DOWN 입니다! (${percentChange.toFixed(3)}%)</span>`;
    }

    // 내 예측 표시
    if (prediction === 'up') {
        predEl.innerHTML = '<span style="color:#10b981">📈 UP</span>';
    } else {
        predEl.innerHTML = '<span style="color:#ef4444">📉 DOWN</span>';
    }

    // 베팅 시점 가격, 베팅 금액 표시
    betPriceEl.textContent = '$' + formatPrice(betPrice);
    betEl.textContent = numberFormat(currentBetAmount) + 'P';

    modal.classList.add('show');
}

function closeResultModal() {
    document.getElementById('resultModal').classList.remove('show');
}

// 헬퍼 함수
function setBet(amount) {
    getBetInputEls().forEach(el => { el.value = amount; });
}

function multiplyBet(factor) {
    const inputs = getBetInputEls();
    const cur = parseInt((inputs[0] ? inputs[0].value : '0'), 10) || 0;
    const next = Math.max(10, Math.floor(cur * factor));
    inputs.forEach(el => { el.value = next; });
}

function setMaxBet() {
    const next = Math.min(userPoint, 100000);
    getBetInputEls().forEach(el => { el.value = next; });
}

function formatPrice(price) {
    return price.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function numberFormat(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// 시작
init();
</script>

<?php
include_once(G5_PATH.'/tail.php');
?>
