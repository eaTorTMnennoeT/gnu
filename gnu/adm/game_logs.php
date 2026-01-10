<?php
/**
 * 게임 배팅 리스트
 */
$sub_menu = "800310";
include_once('./_common.php');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

$g5['title'] = '배팅 리스트';
include_once(G5_ADMIN_PATH.'/admin.head.php');

// 테이블 존재 여부 확인
$table_name = $g5['write_prefix'].'game_log';
$table_exists = sql_query("SHOW TABLES LIKE '{$table_name}'");
$has_table = sql_num_rows($table_exists) > 0;

if (!$has_table) {
    echo '<div class="local_desc01 local_desc"><p>게임 로그 테이블이 없습니다. <a href="'.G5_ADMIN_URL.'/game_install.php" class="btn btn_02">테이블 생성</a></p></div>';
    include_once(G5_ADMIN_PATH.'/admin.tail.php');
    exit;
}

// 검색 조건
$sdate = isset($_GET['sdate']) ? $_GET['sdate'] : date('Y-m-d', strtotime('-7 days'));
$edate = isset($_GET['edate']) ? $_GET['edate'] : date('Y-m-d');
$mb_id = isset($_GET['mb_id']) ? trim($_GET['mb_id']) : '';
$game = isset($_GET['game']) ? $_GET['game'] : '';
$result_filter = isset($_GET['result']) ? $_GET['result'] : '';

// 페이징
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 30;
$offset = ($page - 1) * $per_page;

// WHERE 조건 생성
$where = "WHERE gl_datetime BETWEEN '{$sdate} 00:00:00' AND '{$edate} 23:59:59'";
if ($mb_id) {
    $where .= " AND mb_id = '".sql_escape_string($mb_id)."'";
}
if ($game) {
    $where .= " AND gl_game = '".sql_escape_string($game)."'";
}
if ($result_filter) {
    $where .= " AND gl_result = '".sql_escape_string($result_filter)."'";
}

// 총 개수
$sql = "SELECT COUNT(*) as cnt FROM {$table_name} {$where}";
$total_count = sql_fetch($sql)['cnt'];
$total_pages = ceil($total_count / $per_page);

// 리스트 조회 (누적 손익 포함)
$sql = "SELECT g.*,
        (SELECT SUM(gl_profit) FROM {$table_name} WHERE mb_id = g.mb_id) as cumulative_profit,
        (SELECT SUM(gl_bet_amount) FROM {$table_name} WHERE mb_id = g.mb_id) as cumulative_bet
        FROM {$table_name} g {$where} ORDER BY gl_datetime DESC LIMIT {$offset}, {$per_page}";
$result = sql_query($sql);

// 특정 유저의 기간 내 총계
$user_total = null;
$user_all_time = null;
if ($mb_id) {
    // 검색 기간 내 통계
    $sql = "SELECT
                COUNT(*) as game_count,
                SUM(gl_bet_amount) as total_bet,
                SUM(gl_win_amount) as total_win,
                SUM(gl_profit) as total_profit,
                SUM(CASE WHEN gl_result = 'win' THEN 1 ELSE 0 END) as win_count
            FROM {$table_name}
            {$where}";
    $user_total = sql_fetch($sql);

    // 전체 누적 통계 (기간 무관)
    $sql = "SELECT
                COUNT(*) as game_count,
                SUM(gl_bet_amount) as total_bet,
                SUM(gl_win_amount) as total_win,
                SUM(gl_profit) as total_profit,
                SUM(CASE WHEN gl_result = 'win' THEN 1 ELSE 0 END) as win_count,
                MIN(gl_datetime) as first_game,
                MAX(gl_datetime) as last_game
            FROM {$table_name}
            WHERE mb_id = '".sql_escape_string($mb_id)."'";
    $user_all_time = sql_fetch($sql);
}

$game_names = [
    'slot' => '슬롯머신',
    'roulette' => '룰렛',
    'dice' => '주사위',
    'blackjack' => '블랙잭',
    'baccarat' => '바카라',
    'btc' => 'BTC 예측',
    'racing' => '경마',
    'crash' => '크래시',
    'ladder' => '사다리'
];

$game_icons = [
    'slot' => '🎰',
    'roulette' => '🎡',
    'dice' => '🎲',
    'blackjack' => '🃏',
    'baccarat' => '💎',
    'btc' => '₿',
    'racing' => '🏇',
    'crash' => '📈',
    'ladder' => '🪜'
];

// URL 파라미터 생성
function buildUrl($params = []) {
    $base = ['sdate' => $GLOBALS['sdate'], 'edate' => $GLOBALS['edate']];
    if ($GLOBALS['mb_id']) $base['mb_id'] = $GLOBALS['mb_id'];
    if ($GLOBALS['game']) $base['game'] = $GLOBALS['game'];
    if ($GLOBALS['result_filter']) $base['result'] = $GLOBALS['result_filter'];
    return '?' . http_build_query(array_merge($base, $params));
}
?>

<style>
/* ========================================
   게임 관리자 - 프리미엄 대시보드
   ======================================== */
:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --info: #3b82f6;
    --dark: #1e293b;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
    --radius: 16px;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
}

.game-admin {
    padding: 24px;
    background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 100%);
    min-height: calc(100vh - 200px);
}

/* 네비게이션 탭 */
.admin-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
    background: white;
    padding: 8px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    width: fit-content;
}

.admin-tab {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: transparent;
    color: var(--gray-600);
    text-decoration: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s;
}

.admin-tab:hover {
    background: var(--gray-100);
    color: var(--gray-800);
}

.admin-tab.active {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
}

/* 필터 섹션 */
.filter-section {
    background: white;
    border-radius: var(--radius);
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
}

.filter-form {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--gray-600);
    white-space: nowrap;
}

.filter-input, .filter-select {
    padding: 10px 14px;
    border: 2px solid var(--gray-200);
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s;
    background: var(--gray-50);
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: var(--primary);
    background: white;
}

.filter-btn {
    padding: 10px 24px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
}

.reset-btn {
    padding: 10px 20px;
    background: var(--gray-100);
    color: var(--gray-600);
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s;
}

.reset-btn:hover {
    background: var(--gray-200);
    color: var(--gray-800);
}

/* 유저 요약 카드 */
.user-summary-card {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: var(--radius);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-lg);
    color: white;
}

.user-summary-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.user-avatar {
    width: 48px;
    height: 48px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.user-name {
    font-size: 20px;
    font-weight: 700;
}

.user-id {
    font-size: 14px;
    opacity: 0.8;
}

.user-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 16px;
}

.user-stat {
    text-align: center;
    padding: 12px;
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
}

.user-stat-value {
    font-size: 22px;
    font-weight: 800;
}

.user-stat-label {
    font-size: 12px;
    opacity: 0.8;
    margin-top: 4px;
}

/* 섹션 카드 */
.section-card {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.section-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--gray-800);
    display: flex;
    align-items: center;
    gap: 10px;
}

.total-count {
    font-size: 14px;
    color: var(--gray-500);
}

.total-count strong {
    color: var(--primary);
    font-weight: 700;
}

/* 테이블 스타일 */
.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    padding: 14px 16px;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
    white-space: nowrap;
}

.data-table td {
    padding: 14px 16px;
    font-size: 14px;
    color: var(--gray-700);
    border-bottom: 1px solid var(--gray-100);
}

.data-table tr:last-child td {
    border-bottom: none;
}

.data-table tr:hover td {
    background: var(--gray-50);
}

.data-table .num {
    text-align: right;
    font-family: 'SF Mono', 'Consolas', monospace;
    font-weight: 600;
}

.data-table .center {
    text-align: center;
}

.data-table .positive {
    color: var(--success);
    font-weight: 700;
}

.data-table .negative {
    color: var(--danger);
    font-weight: 700;
}

/* 게임 뱃지 */
.game-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.game-badge.slot { background: #ede9fe; color: #7c3aed; }
.game-badge.roulette { background: #fee2e2; color: #dc2626; }
.game-badge.dice { background: #fef3c7; color: #d97706; }
.game-badge.blackjack { background: #e0e7ff; color: #4338ca; }
.game-badge.baccarat { background: #f3e8ff; color: #9333ea; }
.game-badge.btc { background: #fff7ed; color: #ea580c; }
.game-badge.racing { background: #dcfce7; color: #16a34a; }
.game-badge.crash { background: #fce7f3; color: #db2777; }
.game-badge.ladder { background: #fef9c3; color: #a16207; }

/* 결과 뱃지 */
.result-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

.result-badge.win {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #047857;
}

.result-badge.lose {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #b91c1c;
}

.result-badge.push {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
}

/* 상세 정보 */
.detail-text {
    font-size: 12px;
    color: var(--gray-500);
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* 회원 링크 */
.member-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
}

.member-link:hover {
    text-decoration: underline;
}

/* 페이지네이션 */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    padding: 24px;
}

.page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 12px;
    border: 1px solid var(--gray-200);
    border-radius: 8px;
    background: white;
    color: var(--gray-600);
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.page-link:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
    color: var(--gray-800);
}

.page-link.active {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-color: transparent;
    color: white;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.page-link.disabled {
    opacity: 0.5;
    pointer-events: none;
}

/* 빈 상태 */
.empty-state {
    padding: 60px 20px;
    text-align: center;
    color: var(--gray-500);
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-text {
    font-size: 16px;
}

/* 상세보기 버튼 */
.detail-btn {
    padding: 5px 12px;
    background: var(--gray-100);
    border: 1px solid var(--gray-200);
    border-radius: 6px;
    font-size: 12px;
    color: var(--gray-600);
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.detail-btn:hover {
    background: var(--gray-200);
    color: var(--gray-800);
}

/* 모달 */
.detail-modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

.detail-modal-overlay.show {
    display: flex;
}

.detail-modal {
    background: white;
    border-radius: var(--radius);
    padding: 24px;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.detail-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--gray-200);
}

.detail-modal-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--gray-800);
}

.detail-modal-close {
    width: 32px;
    height: 32px;
    border: none;
    background: var(--gray-100);
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    color: var(--gray-500);
    transition: all 0.2s;
}

.detail-modal-close:hover {
    background: var(--gray-200);
    color: var(--gray-800);
}

.detail-modal-content {
    font-size: 14px;
    line-height: 1.8;
    color: var(--gray-700);
    word-break: break-all;
}

.detail-row {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid var(--gray-100);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    width: 80px;
    flex-shrink: 0;
    font-weight: 600;
    color: var(--gray-500);
}

.detail-value {
    flex: 1;
    color: var(--gray-800);
}

/* 반응형 */
@media (max-width: 1200px) {
    .data-table { display: block; overflow-x: auto; }
}

@media (max-width: 768px) {
    .game-admin { padding: 16px; }
    .filter-form { flex-direction: column; align-items: stretch; }
    .filter-group { flex-wrap: wrap; }
    .admin-tabs { width: 100%; }
    .admin-tab { flex: 1; justify-content: center; padding: 10px 12px; font-size: 13px; }
    .user-stats { grid-template-columns: repeat(3, 1fr); }
}
</style>

<div class="game-admin">
    <!-- 탭 네비게이션 -->
    <div class="admin-tabs">
        <a href="<?php echo G5_ADMIN_URL; ?>/game_stats.php" class="admin-tab">
            <span>📊</span> 통계 대시보드
        </a>
        <a href="<?php echo G5_ADMIN_URL; ?>/game_logs.php" class="admin-tab active">
            <span>📋</span> 배팅 내역
        </a>
    </div>

    <!-- 필터 -->
    <div class="filter-section">
        <form method="get" class="filter-form">
            <div class="filter-group">
                <span class="filter-label">기간</span>
                <input type="date" name="sdate" value="<?php echo $sdate; ?>" class="filter-input">
                <span style="color: var(--gray-400);">~</span>
                <input type="date" name="edate" value="<?php echo $edate; ?>" class="filter-input">
            </div>

            <div class="filter-group">
                <span class="filter-label">회원ID</span>
                <input type="text" name="mb_id" value="<?php echo htmlspecialchars($mb_id); ?>" placeholder="검색" class="filter-input" style="width: 120px;">
            </div>

            <div class="filter-group">
                <span class="filter-label">게임</span>
                <select name="game" class="filter-select">
                    <option value="">전체</option>
                    <?php foreach ($game_names as $key => $name) { ?>
                    <option value="<?php echo $key; ?>" <?php echo $game == $key ? 'selected' : ''; ?>><?php echo $name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="filter-group">
                <span class="filter-label">결과</span>
                <select name="result" class="filter-select">
                    <option value="">전체</option>
                    <option value="win" <?php echo $result_filter == 'win' ? 'selected' : ''; ?>>승리</option>
                    <option value="lose" <?php echo $result_filter == 'lose' ? 'selected' : ''; ?>>패배</option>
                </select>
            </div>

            <button type="submit" class="filter-btn">검색</button>
            <a href="<?php echo G5_ADMIN_URL; ?>/game_logs.php" class="reset-btn">초기화</a>
        </form>
    </div>

    <?php if ($user_total && $mb_id) { ?>
    <!-- 유저 요약 카드 -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px; margin-bottom: 24px;">
        <!-- 전체 누적 통계 -->
        <?php if ($user_all_time && $user_all_time['game_count'] > 0) { ?>
        <div class="user-summary-card" style="margin-bottom: 0; background: linear-gradient(135deg, #dc2626 0%, #ea580c 100%);">
            <div class="user-summary-header">
                <div class="user-avatar">📊</div>
                <div>
                    <div class="user-name"><?php echo htmlspecialchars($mb_id); ?></div>
                    <div class="user-id">전체 누적 통계 (<?php echo date('Y.m.d', strtotime($user_all_time['first_game'])); ?> ~ <?php echo date('Y.m.d', strtotime($user_all_time['last_game'])); ?>)</div>
                </div>
            </div>
            <div class="user-stats">
                <div class="user-stat">
                    <div class="user-stat-value"><?php echo number_format($user_all_time['game_count']); ?></div>
                    <div class="user-stat-label">누적 게임</div>
                </div>
                <div class="user-stat">
                    <div class="user-stat-value"><?php echo number_format($user_all_time['total_bet']); ?></div>
                    <div class="user-stat-label">누적 베팅액</div>
                </div>
                <div class="user-stat">
                    <div class="user-stat-value"><?php echo number_format($user_all_time['total_win']); ?></div>
                    <div class="user-stat-label">누적 당첨액</div>
                </div>
                <div class="user-stat">
                    <div class="user-stat-value" style="<?php echo $user_all_time['total_profit'] >= 0 ? 'color: #86efac;' : 'color: #fca5a5;'; ?>"><?php echo ($user_all_time['total_profit'] >= 0 ? '+' : '') . number_format($user_all_time['total_profit']); ?></div>
                    <div class="user-stat-label">누적 손익</div>
                </div>
                <div class="user-stat">
                    <div class="user-stat-value"><?php echo $user_all_time['game_count'] > 0 ? round(($user_all_time['win_count'] / $user_all_time['game_count']) * 100, 1) : 0; ?>%</div>
                    <div class="user-stat-label">승률</div>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- 검색 기간 통계 -->
        <div class="user-summary-card" style="margin-bottom: 0;">
            <div class="user-summary-header">
                <div class="user-avatar">📅</div>
                <div>
                    <div class="user-name"><?php echo htmlspecialchars($mb_id); ?></div>
                    <div class="user-id">검색 기간 통계 (<?php echo $sdate; ?> ~ <?php echo $edate; ?>)</div>
                </div>
            </div>
            <div class="user-stats">
                <div class="user-stat">
                    <div class="user-stat-value"><?php echo number_format($user_total['game_count']); ?></div>
                    <div class="user-stat-label">게임 수</div>
                </div>
                <div class="user-stat">
                    <div class="user-stat-value"><?php echo number_format($user_total['total_bet']); ?></div>
                    <div class="user-stat-label">베팅액</div>
                </div>
                <div class="user-stat">
                    <div class="user-stat-value"><?php echo number_format($user_total['total_win']); ?></div>
                    <div class="user-stat-label">당첨액</div>
                </div>
                <div class="user-stat">
                    <div class="user-stat-value" style="<?php echo $user_total['total_profit'] >= 0 ? 'color: #86efac;' : 'color: #fca5a5;'; ?>"><?php echo ($user_total['total_profit'] >= 0 ? '+' : '') . number_format($user_total['total_profit']); ?></div>
                    <div class="user-stat-label">손익</div>
                </div>
                <div class="user-stat">
                    <div class="user-stat-value"><?php echo $user_total['game_count'] > 0 ? round(($user_total['win_count'] / $user_total['game_count']) * 100, 1) : 0; ?>%</div>
                    <div class="user-stat-label">승률</div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- 배팅 리스트 -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title"><span>📋</span> 배팅 내역</h3>
            <span class="total-count">총 <strong><?php echo number_format($total_count); ?></strong>건</span>
        </div>

        <?php if ($total_count > 0) { ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th class="center" style="width: 50px;">No</th>
                    <th style="width: 140px;">일시</th>
                    <th>회원</th>
                    <th>게임</th>
                    <th>베팅타입</th>
                    <th class="num">베팅액</th>
                    <th class="center">결과</th>
                    <th class="num">당첨액</th>
                    <th class="num">손익</th>
                    <th class="num">누적손익</th>
                    <th>상세</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = $total_count - $offset;
                while ($row = sql_fetch_array($result)) { ?>
                <tr>
                    <td class="center" style="color: var(--gray-400); font-size: 12px;"><?php echo $no--; ?></td>
                    <td style="font-size: 13px; color: var(--gray-600);">
                        <?php echo date('m/d H:i', strtotime($row['gl_datetime'])); ?>
                    </td>
                    <td>
                        <a href="<?php echo G5_ADMIN_URL; ?>/game_logs.php?mb_id=<?php echo urlencode($row['mb_id']); ?>&sdate=<?php echo $sdate; ?>&edate=<?php echo $edate; ?>" class="member-link">
                            <?php echo htmlspecialchars($row['mb_nick']); ?>
                        </a>
                    </td>
                    <td>
                        <span class="game-badge <?php echo $row['gl_game']; ?>">
                            <?php echo $game_icons[$row['gl_game']] ?? '🎮'; ?>
                            <?php echo $game_names[$row['gl_game']] ?? $row['gl_game']; ?>
                        </span>
                    </td>
                    <td style="font-size: 13px;"><?php echo htmlspecialchars($row['gl_bet_type']); ?></td>
                    <td class="num"><?php echo number_format($row['gl_bet_amount']); ?>P</td>
                    <td class="center">
                        <?php
                        if ($row['gl_result'] == 'win') {
                            $result_class = 'win';
                            $result_icon = '✓';
                            $result_text = '승리';
                        } elseif ($row['gl_result'] == 'lose') {
                            $result_class = 'lose';
                            $result_icon = '✕';
                            $result_text = '패배';
                        } elseif ($row['gl_result'] == 'pending') {
                            $result_class = 'push';
                            $result_icon = '⏳';
                            $result_text = '대기중';
                        } else {
                            $result_class = 'push';
                            $result_icon = '—';
                            $result_text = '무승부';
                        }
                        ?>
                        <span class="result-badge <?php echo $result_class; ?>">
                            <?php echo $result_icon; ?> <?php echo $result_text; ?>
                        </span>
                    </td>
                    <td class="num"><?php echo number_format($row['gl_win_amount']); ?>P</td>
                    <td class="num <?php echo $row['gl_profit'] >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo ($row['gl_profit'] >= 0 ? '+' : '') . number_format($row['gl_profit']); ?>P
                    </td>
                    <td class="num <?php echo $row['cumulative_profit'] >= 0 ? 'positive' : 'negative'; ?>" style="font-weight: 800;">
                        <?php echo ($row['cumulative_profit'] >= 0 ? '+' : '') . number_format($row['cumulative_profit']); ?>P
                    </td>
                    <td>
                        <?php if ($row['gl_detail']) { ?>
                        <button type="button" class="detail-btn" onclick="showDetail('<?php echo htmlspecialchars($row['mb_nick']); ?>', '<?php echo $game_names[$row['gl_game']] ?? $row['gl_game']; ?>', '<?php echo date('Y-m-d H:i:s', strtotime($row['gl_datetime'])); ?>', '<?php echo addslashes(htmlspecialchars($row['gl_detail'])); ?>')">상세</button>
                        <?php } else { ?>
                        <span style="color: var(--gray-400);">-</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if ($total_pages > 1) { ?>
        <div class="pagination">
            <?php if ($page > 1) { ?>
            <a href="<?php echo buildUrl(['page' => 1]); ?>" class="page-link">«</a>
            <a href="<?php echo buildUrl(['page' => $page - 1]); ?>" class="page-link">‹</a>
            <?php } else { ?>
            <span class="page-link disabled">«</span>
            <span class="page-link disabled">‹</span>
            <?php } ?>

            <?php
            $start_page = max(1, $page - 3);
            $end_page = min($total_pages, $page + 3);
            for ($i = $start_page; $i <= $end_page; $i++) {
                $active = $i == $page ? 'active' : '';
                echo '<a href="'.buildUrl(['page' => $i]).'" class="page-link '.$active.'">'.$i.'</a>';
            }
            ?>

            <?php if ($page < $total_pages) { ?>
            <a href="<?php echo buildUrl(['page' => $page + 1]); ?>" class="page-link">›</a>
            <a href="<?php echo buildUrl(['page' => $total_pages]); ?>" class="page-link">»</a>
            <?php } else { ?>
            <span class="page-link disabled">›</span>
            <span class="page-link disabled">»</span>
            <?php } ?>
        </div>
        <?php } ?>

        <?php } else { ?>
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <div class="empty-text">조회된 데이터가 없습니다.</div>
        </div>
        <?php } ?>
    </div>
</div>

<!-- 상세보기 모달 -->
<div class="detail-modal-overlay" id="detailModal" onclick="closeDetailModal(event)">
    <div class="detail-modal" onclick="event.stopPropagation()">
        <div class="detail-modal-header">
            <h4 class="detail-modal-title">게임 상세정보</h4>
            <button type="button" class="detail-modal-close" onclick="closeDetailModal()">&times;</button>
        </div>
        <div class="detail-modal-content">
            <div class="detail-row">
                <span class="detail-label">회원</span>
                <span class="detail-value" id="modalMember">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">게임</span>
                <span class="detail-value" id="modalGame">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">일시</span>
                <span class="detail-value" id="modalDatetime">-</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">상세</span>
                <span class="detail-value" id="modalDetail">-</span>
            </div>
        </div>
    </div>
</div>

<script>
function showDetail(member, game, datetime, detail) {
    document.getElementById('modalMember').textContent = member;
    document.getElementById('modalGame').textContent = game;
    document.getElementById('modalDatetime').textContent = datetime;
    document.getElementById('modalDetail').textContent = detail;
    document.getElementById('detailModal').classList.add('show');
}

function closeDetailModal(event) {
    if (!event || event.target === document.getElementById('detailModal')) {
        document.getElementById('detailModal').classList.remove('show');
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDetailModal();
    }
});
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>
