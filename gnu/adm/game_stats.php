<?php
/**
 * 게임 통계 관리
 */
$sub_menu = "800300";
include_once('./_common.php');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

$g5['title'] = '게임 통계';
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

// 기간 필터
$sdate = isset($_GET['sdate']) ? $_GET['sdate'] : date('Y-m-d', strtotime('-30 days'));
$edate = isset($_GET['edate']) ? $_GET['edate'] : date('Y-m-d');

// 전체 통계
$sql = "SELECT
            COUNT(*) as total_games,
            SUM(gl_bet_amount) as total_bet,
            SUM(gl_win_amount) as total_win,
            SUM(gl_profit) as total_profit,
            SUM(CASE WHEN gl_result = 'win' THEN 1 ELSE 0 END) as win_count,
            SUM(CASE WHEN gl_result = 'lose' THEN 1 ELSE 0 END) as lose_count
        FROM {$table_name}
        WHERE gl_datetime BETWEEN '{$sdate} 00:00:00' AND '{$edate} 23:59:59'";
$stats = sql_fetch($sql);

// 게임별 통계
$sql = "SELECT
            gl_game,
            COUNT(*) as game_count,
            SUM(gl_bet_amount) as total_bet,
            SUM(gl_win_amount) as total_win,
            SUM(gl_profit) as total_profit,
            SUM(CASE WHEN gl_result = 'win' THEN 1 ELSE 0 END) as win_count
        FROM {$table_name}
        WHERE gl_datetime BETWEEN '{$sdate} 00:00:00' AND '{$edate} 23:59:59'
        GROUP BY gl_game
        ORDER BY game_count DESC";
$game_stats = sql_query($sql);

// 사용자별 통계 (상위 20명)
$sql = "SELECT
            mb_id,
            mb_nick,
            COUNT(*) as game_count,
            SUM(gl_bet_amount) as total_bet,
            SUM(gl_win_amount) as total_win,
            SUM(gl_profit) as total_profit
        FROM {$table_name}
        WHERE gl_datetime BETWEEN '{$sdate} 00:00:00' AND '{$edate} 23:59:59'
        GROUP BY mb_id
        ORDER BY total_bet DESC
        LIMIT 20";
$user_stats = sql_query($sql);

// 일별 통계 (최근 30일)
$sql = "SELECT
            DATE(gl_datetime) as game_date,
            COUNT(*) as game_count,
            SUM(gl_bet_amount) as total_bet,
            SUM(gl_profit) as total_profit
        FROM {$table_name}
        WHERE gl_datetime BETWEEN '{$sdate} 00:00:00' AND '{$edate} 23:59:59'
        GROUP BY DATE(gl_datetime)
        ORDER BY game_date DESC
        LIMIT 30";
$daily_stats = sql_query($sql);

$game_names = [
    'slot' => '슬롯머신',
    'roulette' => '룰렛',
    'dice' => '주사위',
    'blackjack' => '블랙잭',
    'baccarat' => '바카라',
    'btc' => 'BTC 예측'
];

$game_icons = [
    'slot' => '🎰',
    'roulette' => '🎡',
    'dice' => '🎲',
    'blackjack' => '🃏',
    'baccarat' => '💎',
    'btc' => '₿'
];

// 사이트 수익 계산 (유저 손실 = 사이트 수익)
$site_profit = -($stats['total_profit'] ?: 0);
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

.admin-tab i {
    font-size: 18px;
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
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-600);
}

.filter-input {
    padding: 10px 16px;
    border: 2px solid var(--gray-200);
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s;
    background: var(--gray-50);
}

.filter-input:focus {
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

/* 통계 카드 그리드 */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: white;
    border-radius: var(--radius);
    padding: 24px;
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden;
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.stat-card.games::before { background: linear-gradient(90deg, #6366f1, #8b5cf6); }
.stat-card.bets::before { background: linear-gradient(90deg, #f59e0b, #f97316); }
.stat-card.wins::before { background: linear-gradient(90deg, #10b981, #14b8a6); }
.stat-card.profit::before { background: linear-gradient(90deg, #ef4444, #f97316); }
.stat-card.win-count::before { background: linear-gradient(90deg, #3b82f6, #6366f1); }
.stat-card.lose-count::before { background: linear-gradient(90deg, #94a3b8, #64748b); }

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 16px;
}

.stat-card.games .stat-icon { background: linear-gradient(135deg, #ede9fe, #ddd6fe); }
.stat-card.bets .stat-icon { background: linear-gradient(135deg, #fef3c7, #fde68a); }
.stat-card.wins .stat-icon { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
.stat-card.profit .stat-icon { background: linear-gradient(135deg, #fee2e2, #fecaca); }
.stat-card.win-count .stat-icon { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
.stat-card.lose-count .stat-icon { background: linear-gradient(135deg, #f1f5f9, #e2e8f0); }

.stat-value {
    font-size: 28px;
    font-weight: 800;
    color: var(--gray-800);
    margin-bottom: 4px;
    letter-spacing: -0.5px;
}

.stat-value.positive { color: var(--success); }
.stat-value.negative { color: var(--danger); }

.stat-label {
    font-size: 14px;
    color: var(--gray-500);
    font-weight: 500;
}

/* 섹션 카드 */
.section-card {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    margin-bottom: 24px;
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

.section-title i {
    font-size: 22px;
}

.section-body {
    padding: 0;
}

/* 테이블 스타일 */
.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    padding: 14px 20px;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: var(--gray-50);
    border-bottom: 1px solid var(--gray-200);
}

.data-table td {
    padding: 16px 20px;
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
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}

.game-badge.slot { background: #ede9fe; color: #7c3aed; }
.game-badge.roulette { background: #fee2e2; color: #dc2626; }
.game-badge.dice { background: #fef3c7; color: #d97706; }
.game-badge.blackjack { background: #e0e7ff; color: #4338ca; }
.game-badge.baccarat { background: #f3e8ff; color: #9333ea; }
.game-badge.btc { background: #fff7ed; color: #ea580c; }

/* 프로그레스 바 */
.progress-bar {
    width: 100%;
    height: 8px;
    background: var(--gray-200);
    border-radius: 4px;
    overflow: hidden;
    margin-top: 8px;
}

.progress-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.5s ease;
}

.progress-fill.win { background: linear-gradient(90deg, var(--success), #34d399); }
.progress-fill.lose { background: linear-gradient(90deg, var(--danger), #f87171); }

/* 순위 뱃지 */
.rank-badge {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
}

.rank-badge.gold { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: white; }
.rank-badge.silver { background: linear-gradient(135deg, #9ca3af, #6b7280); color: white; }
.rank-badge.bronze { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.rank-badge.normal { background: var(--gray-100); color: var(--gray-600); }

/* 회원 링크 */
.member-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
}

.member-link:hover {
    text-decoration: underline;
}

/* 반응형 */
@media (max-width: 768px) {
    .game-admin { padding: 16px; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .stat-card { padding: 16px; }
    .stat-value { font-size: 22px; }
    .filter-form { flex-direction: column; align-items: stretch; }
    .admin-tabs { width: 100%; }
    .admin-tab { flex: 1; justify-content: center; padding: 10px 12px; }
}
</style>

<div class="game-admin">
    <!-- 탭 네비게이션 -->
    <div class="admin-tabs">
        <a href="<?php echo G5_ADMIN_URL; ?>/game_stats.php" class="admin-tab active">
            <span>📊</span> 통계 대시보드
        </a>
        <a href="<?php echo G5_ADMIN_URL; ?>/game_logs.php" class="admin-tab">
            <span>📋</span> 배팅 내역
        </a>
    </div>

    <!-- 필터 -->
    <div class="filter-section">
        <form method="get" class="filter-form">
            <div class="filter-group">
                <span class="filter-label">조회 기간</span>
                <input type="date" name="sdate" value="<?php echo $sdate; ?>" class="filter-input">
                <span style="color: var(--gray-400);">~</span>
                <input type="date" name="edate" value="<?php echo $edate; ?>" class="filter-input">
            </div>
            <button type="submit" class="filter-btn">조회하기</button>
        </form>
    </div>

    <!-- 통계 카드 -->
    <div class="stats-grid">
        <div class="stat-card games">
            <div class="stat-icon">🎮</div>
            <div class="stat-value"><?php echo number_format($stats['total_games'] ?: 0); ?></div>
            <div class="stat-label">총 게임 수</div>
        </div>
        <div class="stat-card bets">
            <div class="stat-icon">💰</div>
            <div class="stat-value"><?php echo number_format($stats['total_bet'] ?: 0); ?></div>
            <div class="stat-label">총 베팅액 (P)</div>
        </div>
        <div class="stat-card wins">
            <div class="stat-icon">🏆</div>
            <div class="stat-value"><?php echo number_format($stats['total_win'] ?: 0); ?></div>
            <div class="stat-label">총 당첨액 (P)</div>
        </div>
        <div class="stat-card profit">
            <div class="stat-icon"><?php echo $site_profit >= 0 ? '📈' : '📉'; ?></div>
            <div class="stat-value <?php echo $site_profit >= 0 ? 'positive' : 'negative'; ?>">
                <?php echo ($site_profit >= 0 ? '+' : '') . number_format($site_profit); ?>
            </div>
            <div class="stat-label">사이트 수익 (P)</div>
        </div>
        <div class="stat-card win-count">
            <div class="stat-icon">✅</div>
            <div class="stat-value"><?php echo number_format($stats['win_count'] ?: 0); ?></div>
            <div class="stat-label">유저 승리</div>
        </div>
        <div class="stat-card lose-count">
            <div class="stat-icon">❌</div>
            <div class="stat-value"><?php echo number_format($stats['lose_count'] ?: 0); ?></div>
            <div class="stat-label">유저 패배</div>
        </div>
    </div>

    <!-- 게임별 통계 -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title"><span>🎰</span> 게임별 통계</h3>
        </div>
        <div class="section-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>게임</th>
                        <th class="num">플레이 수</th>
                        <th class="num">총 베팅액</th>
                        <th class="num">총 당첨액</th>
                        <th class="num">사이트 수익</th>
                        <th>승률</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = sql_fetch_array($game_stats)) {
                        $game_profit = -$row['total_profit'];
                        $win_rate = $row['game_count'] > 0 ? round(($row['win_count'] / $row['game_count']) * 100, 1) : 0;
                    ?>
                    <tr>
                        <td>
                            <span class="game-badge <?php echo $row['gl_game']; ?>">
                                <?php echo $game_icons[$row['gl_game']] ?? '🎮'; ?>
                                <?php echo $game_names[$row['gl_game']] ?? $row['gl_game']; ?>
                            </span>
                        </td>
                        <td class="num"><?php echo number_format($row['game_count']); ?>회</td>
                        <td class="num"><?php echo number_format($row['total_bet']); ?>P</td>
                        <td class="num"><?php echo number_format($row['total_win']); ?>P</td>
                        <td class="num <?php echo $game_profit >= 0 ? 'positive' : 'negative'; ?>">
                            <?php echo ($game_profit >= 0 ? '+' : '') . number_format($game_profit); ?>P
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-weight: 600;"><?php echo $win_rate; ?>%</span>
                                <div class="progress-bar" style="width: 80px;">
                                    <div class="progress-fill win" style="width: <?php echo $win_rate; ?>%;"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 사용자별 통계 -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title"><span>👤</span> 베팅 랭킹 TOP 20</h3>
        </div>
        <div class="section-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">순위</th>
                        <th>회원</th>
                        <th class="num">게임 수</th>
                        <th class="num">총 베팅액</th>
                        <th class="num">총 당첨액</th>
                        <th class="num">손익</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank = 1;
                    while ($row = sql_fetch_array($user_stats)) {
                        $rank_class = $rank == 1 ? 'gold' : ($rank == 2 ? 'silver' : ($rank == 3 ? 'bronze' : 'normal'));
                    ?>
                    <tr>
                        <td>
                            <span class="rank-badge <?php echo $rank_class; ?>"><?php echo $rank++; ?></span>
                        </td>
                        <td>
                            <a href="<?php echo G5_ADMIN_URL; ?>/game_logs.php?mb_id=<?php echo urlencode($row['mb_id']); ?>" class="member-link">
                                <?php echo htmlspecialchars($row['mb_nick']); ?>
                            </a>
                            <span style="color: var(--gray-400); font-size: 12px; margin-left: 4px;">(<?php echo $row['mb_id']; ?>)</span>
                        </td>
                        <td class="num"><?php echo number_format($row['game_count']); ?>회</td>
                        <td class="num"><?php echo number_format($row['total_bet']); ?>P</td>
                        <td class="num"><?php echo number_format($row['total_win']); ?>P</td>
                        <td class="num <?php echo $row['total_profit'] >= 0 ? 'positive' : 'negative'; ?>">
                            <?php echo ($row['total_profit'] >= 0 ? '+' : '') . number_format($row['total_profit']); ?>P
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 일별 통계 -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title"><span>📅</span> 일별 통계</h3>
        </div>
        <div class="section-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>날짜</th>
                        <th class="num">게임 수</th>
                        <th class="num">총 베팅액</th>
                        <th class="num">사이트 수익</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = sql_fetch_array($daily_stats)) {
                        $daily_profit = -$row['total_profit'];
                    ?>
                    <tr>
                        <td style="font-weight: 600;"><?php echo $row['game_date']; ?></td>
                        <td class="num"><?php echo number_format($row['game_count']); ?>회</td>
                        <td class="num"><?php echo number_format($row['total_bet']); ?>P</td>
                        <td class="num <?php echo $daily_profit >= 0 ? 'positive' : 'negative'; ?>">
                            <?php echo ($daily_profit >= 0 ? '+' : '') . number_format($daily_profit); ?>P
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>
