<?php
/**
 * 룰렛 게임
 * 그누보드 테마 레이아웃 적용
 */
include_once('./_common.php');

if (!$is_member) {
    alert('로그인 후 이용해주세요.', G5_URL);
    exit;
}

$g5['title'] = '룰렛';
include_once(G5_PATH.'/head.php');

$member_point = $member['mb_point'];
?>

<style>
/* ========================================
   룰렛 - 라이트/다크 모드 대응
   ======================================== */

.roulette-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

/* 게임 헤더 */
.roulette-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding: 20px;
    background: var(--bg-card, #ffffff);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
    flex-wrap: wrap;
    gap: 16px;
}

.roulette-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.roulette-title-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.roulette-title h1 {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary, #333);
}

.roulette-title p {
    font-size: 13px;
    color: var(--text-secondary, #666);
}

.roulette-user-info {
    display: flex;
    align-items: center;
    gap: 16px;
}

.roulette-point-display {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: var(--bg-main, #f5f5f5);
    border-radius: 12px;
}

.roulette-point-icon {
    font-size: 20px;
}

.roulette-point-value {
    color: #f1c40f;
    font-size: 18px;
    font-weight: 700;
}

.back-link {
    padding: 10px 20px;
    background: var(--bg-main, #f5f5f5);
    border: 1px solid var(--border, #e0e0e0);
    border-radius: 8px;
    color: var(--text-primary, #333);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
}

.back-link:hover {
    background: var(--border, #e0e0e0);
}

/* 게임 영역 */
.roulette-game-area {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 20px;
}

@media (max-width: 768px) {
    .roulette-game-area {
        grid-template-columns: 1fr;
    }
}

/* 룰렛 휠 섹션 */
.roulette-wheel-section {
    background: var(--bg-card, #ffffff);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
    padding: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.wheel-wrapper {
    position: relative;
    width: 380px;
    height: 380px;
    margin: 20px 0;
}

@media (max-width: 480px) {
    .wheel-wrapper {
        width: 260px;
        height: 260px;
    }
}

.roulette-wheel {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    position: relative;
    transition: transform 5s cubic-bezier(0.17, 0.67, 0.12, 0.99);
    box-shadow:
        0 0 0 8px var(--border, #e0e0e0),
        0 0 0 12px var(--bg-main, #f5f5f5),
        0 0 30px rgba(0,0,0,0.2);
}

.roulette-wheel canvas {
    width: 100%;
    height: 100%;
}

.wheel-pointer {
    position: absolute;
    top: -16px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 16px solid transparent;
    border-right: 16px solid transparent;
    border-top: 32px solid #e74c3c;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    z-index: 10;
}

.wheel-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--bg-card, #fff), var(--bg-main, #f5f5f5));
    border-radius: 50%;
    border: 3px solid var(--border, #e0e0e0);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* 스핀 버튼 */
.spin-button {
    width: 100%;
    padding: 20px 48px;
    font-size: 20px;
    font-weight: 700;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 24px;
}

.spin-button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
}

.spin-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* 베팅 패널 */
.betting-panel {
    background: var(--bg-card, #ffffff);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
    padding: 20px;
}

.panel-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border, #e0e0e0);
    color: var(--text-primary, #333);
}

/* 베팅 금액 */
.bet-section {
    margin-bottom: 20px;
}

.bet-label {
    font-size: 13px;
    color: var(--text-secondary, #666);
    margin-bottom: 8px;
}

.bet-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
}

.bet-btn {
    padding: 10px;
    font-size: 13px;
    font-weight: 600;
    background: var(--bg-main, #f5f5f5);
    border: 2px solid var(--border, #e0e0e0);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    color: var(--text-primary, #333);
    position: relative;
    z-index: 1;
    -webkit-tap-highlight-color: transparent;
    user-select: none;
}

.bet-btn:hover {
    border-color: #e74c3c;
    background: var(--bg-main, #f0f0f0);
}

.bet-btn:active {
    transform: scale(0.95);
}

.bet-btn.active {
    background: #e74c3c;
    border-color: #e74c3c;
    color: white;
}

/* 배당률 */
.odds-section {
    margin-bottom: 20px;
}

.odds-table {
    width: 100%;
    font-size: 13px;
}

.odds-table td {
    padding: 8px 0;
    border-bottom: 1px solid var(--border, #e0e0e0);
}

.odds-color {
    display: inline-block;
    width: 14px;
    height: 14px;
    border-radius: 4px;
    margin-right: 6px;
    vertical-align: middle;
}

.odds-multiplier {
    font-weight: 700;
    color: #f1c40f;
    text-align: right;
}

/* 최근 결과 */
.history-section h3 {
    font-size: 13px;
    color: var(--text-secondary, #666);
    margin-bottom: 10px;
}

.history-list {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 6px;
}

.history-item {
    aspect-ratio: 1;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: white;
}

/* 규칙 섹션 */
.rules-section {
    margin-top: 20px;
    background: var(--bg-card, #ffffff);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
    padding: 20px;
}

.rules-section h3 {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--text-primary, #333);
}

.rules-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.rules-list li {
    padding: 8px 0;
    font-size: 14px;
    color: var(--text-secondary, #666);
    display: flex;
    align-items: flex-start;
    gap: 8px;
}

.rules-list li::before {
    content: "•";
    color: #e74c3c;
    font-weight: bold;
}

/* 결과 모달 */
.result-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.8);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}

.result-modal.show {
    display: flex;
}

.result-content {
    background: var(--bg-card, #ffffff);
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    max-width: 360px;
    width: 90%;
    animation: popIn 0.3s ease;
}

@keyframes popIn {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.result-number {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: 700;
    color: white;
    margin: 0 auto 16px;
}

.result-text {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 8px;
}

.result-text.win {
    color: #27ae60;
}

.result-text.lose {
    color: #e74c3c;
}

.result-amount {
    font-size: 32px;
    font-weight: 800;
    color: #f1c40f;
    margin-bottom: 20px;
}

.result-close {
    padding: 12px 40px;
    font-size: 16px;
    font-weight: 600;
    background: #e74c3c;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

/* 로딩 */
.loading-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9998;
    align-items: center;
    justify-content: center;
}

.loading-overlay.show {
    display: flex;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid var(--border, #e0e0e0);
    border-top-color: #e74c3c;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* 다크 모드 */
[data-theme="dark"] .roulette-header,
.dark .roulette-header {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}

[data-theme="dark"] .roulette-wheel-section,
.dark .roulette-wheel-section {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}

[data-theme="dark"] .betting-panel,
.dark .betting-panel {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}

[data-theme="dark"] .rules-section,
.dark .rules-section {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}

[data-theme="dark"] .roulette-point-display,
.dark .roulette-point-display {
    background: var(--bg-main, #121212);
}

[data-theme="dark"] .back-link,
.dark .back-link {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
}

[data-theme="dark"] .bet-btn,
.dark .bet-btn {
    background: var(--bg-main, #121212);
    border-color: var(--border, #444);
    color: var(--text-primary, #f0f0f0);
}

[data-theme="dark"] .bet-btn:hover,
.dark .bet-btn:hover {
    border-color: #e74c3c;
    background: #2a2a2a;
}

[data-theme="dark"] .bet-btn.active,
.dark .bet-btn.active {
    background: #e74c3c !important;
    border-color: #e74c3c !important;
    color: white !important;
}

[data-theme="dark"] .result-content,
.dark .result-content {
    background: var(--bg-card, #1e1e1e);
}

/* 배팅 내역 섹션 */
.betting-history-section {
    margin-top: 20px;
    background: var(--bg-card, #ffffff);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
    padding: 20px;
}

.betting-history-section h3 {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 16px;
    color: var(--text-primary, #333);
}

.betting-history-list {
    max-height: 400px;
    overflow-y: auto;
}

.history-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--border, #e0e0e0);
}

.history-row:last-child {
    border-bottom: none;
}

.history-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.history-game {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary, #333);
}

.history-time {
    font-size: 12px;
    color: var(--text-muted, #999);
}

.history-point {
    font-size: 15px;
    font-weight: 700;
}

.history-point.point-win {
    color: #27ae60;
}

.history-point.point-lose {
    color: #e74c3c;
}

.no-history {
    text-align: center;
    color: var(--text-muted, #999);
    padding: 40px 0;
    font-size: 14px;
}

[data-theme="dark"] .betting-history-section,
.dark .betting-history-section {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}
</style>

<div class="roulette-container">
    <!-- 헤더 -->
    <div class="roulette-header">
        <div class="roulette-title">
            <div class="roulette-title-icon">🎡</div>
            <div>
                <h1>럭키 룰렛</h1>
                <p>행운의 숫자에 베팅하세요!</p>
            </div>
        </div>
        <div class="roulette-user-info">
            <div class="roulette-point-display">
                <span class="roulette-point-icon">💰</span>
                <span>보유:</span>
                <span class="roulette-point-value" id="userPoint"><?php echo number_format($member_point); ?>P</span>
            </div>
            <a href="<?php echo G5_URL; ?>/game/" class="back-link">게임 목록</a>
        </div>
    </div>

    <!-- 게임 영역 -->
    <div class="roulette-game-area">
        <!-- 룰렛 휠 -->
        <div class="roulette-wheel-section">
            <div class="wheel-wrapper">
                <div class="wheel-pointer"></div>
                <div class="roulette-wheel" id="rouletteWheel">
                    <canvas id="wheelCanvas" width="380" height="380"></canvas>
                </div>
                <div class="wheel-center">🎯</div>
            </div>
            <button class="spin-button" id="spinBtn" onclick="spinRoulette()">
                🎲 스핀!
            </button>
        </div>

        <!-- 베팅 패널 -->
        <div class="betting-panel">
            <h2 class="panel-title">베팅</h2>

            <div class="bet-section">
                <div class="bet-label">베팅 금액</div>
                <div class="bet-buttons">
                    <button class="bet-btn" data-bet="10">10P</button>
                    <button class="bet-btn" data-bet="50">50P</button>
                    <button class="bet-btn active" data-bet="100">100P</button>
                    <button class="bet-btn" data-bet="500">500P</button>
                    <button class="bet-btn" data-bet="1000">1000P</button>
                    <button class="bet-btn" data-bet="5000">5000P</button>
                </div>
            </div>

            <div class="odds-section">
                <div class="bet-label">배당률</div>
                <table class="odds-table">
                    <tr>
                        <td><span class="odds-color" style="background:#666"></span>꽝</td>
                        <td class="odds-multiplier" style="color:#e74c3c">-베팅금</td>
                    </tr>
                    <tr>
                        <td><span class="odds-color" style="background:#e74c3c"></span>빨강</td>
                        <td class="odds-multiplier">x2</td>
                    </tr>
                    <tr>
                        <td><span class="odds-color" style="background:#2c3e50"></span>검정</td>
                        <td class="odds-multiplier">x2</td>
                    </tr>
                    <tr>
                        <td><span class="odds-color" style="background:#27ae60"></span>초록</td>
                        <td class="odds-multiplier">x14</td>
                    </tr>
                    <tr>
                        <td><span class="odds-color" style="background:#f1c40f"></span>골드</td>
                        <td class="odds-multiplier">x7</td>
                    </tr>
                </table>
            </div>

            <div class="history-section">
                <h3>최근 결과</h3>
                <div class="history-list" id="historyList">
                    <?php
                    // DB에서 최근 10개 룰렛 결과 조회 (5개씩 2줄)
                    $history_sql = "SELECT po_content, po_point FROM {$g5['point_table']}
                                    WHERE mb_id = '{$member['mb_id']}'
                                    AND po_content LIKE '%룰렛%'
                                    ORDER BY po_id DESC LIMIT 10";
                    $history_result = sql_query($history_sql);
                    while ($h = sql_fetch_array($history_result)) {
                        // 결과 타입 파싱
                        $isWin = $h['po_point'] > 0;
                        if (!$isWin) {
                            $color = '#666666';
                            $label = '꽝';
                        } else if (strpos($h['po_content'], 'x14') !== false) {
                            $color = '#27ae60';
                            $label = 'x14';
                        } else if (strpos($h['po_content'], 'x7') !== false) {
                            $color = '#f1c40f';
                            $label = 'x7';
                        } else {
                            // x2 - 빨강 또는 검정 (랜덤하게 표시)
                            $color = rand(0,1) ? '#e74c3c' : '#2c3e50';
                            $label = 'x2';
                        }
                        echo "<div class='history-item' style='background:{$color}'>{$label}</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 규칙 -->
    <div class="rules-section">
        <h3>🎮 게임 규칙</h3>
        <ul class="rules-list">
            <li>룰렛은 총 20칸으로 구성됩니다 (꽝 8칸, 빨강 5칸, 검정 5칸, 초록 1칸, 골드 1칸)</li>
            <li>꽝(40%): 베팅금 전액 손실</li>
            <li>빨강/검정(50%): 베팅금의 2배 당첨</li>
            <li>초록(5%): 베팅금의 14배 당첨</li>
            <li>골드(5%): 베팅금의 7배 당첨</li>
        </ul>
    </div>

    <!-- 배팅 내역 -->
    <div class="betting-history-section">
        <h3>📋 내 배팅 내역</h3>
        <div class="betting-history-list" id="bettingHistoryList">
            <?php
            // 최근 20개 게임 내역 조회
            $sql = "SELECT po_content, po_point, po_datetime
                    FROM {$g5['point_table']}
                    WHERE mb_id = '{$member['mb_id']}'
                    AND (po_content LIKE '%룰렛%')
                    ORDER BY po_id DESC
                    LIMIT 20";
            $result = sql_query($sql);

            if (sql_num_rows($result) > 0) {
                while ($row = sql_fetch_array($result)) {
                    $isWin = $row['po_point'] > 0;
                    $pointClass = $isWin ? 'point-win' : 'point-lose';
                    $pointSign = $isWin ? '+' : '';
                    ?>
                    <div class="history-row">
                        <div class="history-info">
                            <span class="history-game"><?php echo $row['po_content']; ?></span>
                            <span class="history-time"><?php echo date('m/d H:i', strtotime($row['po_datetime'])); ?></span>
                        </div>
                        <div class="history-point <?php echo $pointClass; ?>">
                            <?php echo $pointSign . number_format($row['po_point']); ?>P
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="no-history">아직 배팅 내역이 없습니다.</div>';
            }
            ?>
        </div>
    </div>
</div>

<!-- 결과 모달 -->
<div class="result-modal" id="resultModal">
    <div class="result-content">
        <div class="result-number" id="resultNumber">0</div>
        <div class="result-text" id="resultText">축하합니다!</div>
        <div class="result-amount" id="resultAmount">+0P</div>
        <button class="result-close" onclick="closeResult()">확인</button>
    </div>
</div>

<!-- 로딩 -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<script>
// 룰렛 설정 - 20칸 커스텀 룰렛
// 빨강(x2) 5칸, 검정(x2) 5칸, 초록(x14) 1칸, 골드(x7) 1칸, 꽝 8칸
const WHEEL_DATA = [
    { label: '꽝', color: '#666666', type: 'lose' },
    { label: 'x2', color: '#e74c3c', type: 'red' },
    { label: '꽝', color: '#555555', type: 'lose' },
    { label: 'x2', color: '#2c3e50', type: 'black' },
    { label: '꽝', color: '#666666', type: 'lose' },
    { label: 'x2', color: '#e74c3c', type: 'red' },
    { label: '꽝', color: '#555555', type: 'lose' },
    { label: 'x2', color: '#2c3e50', type: 'black' },
    { label: '꽝', color: '#666666', type: 'lose' },
    { label: 'x14', color: '#27ae60', type: 'green' },
    { label: '꽝', color: '#555555', type: 'lose' },
    { label: 'x2', color: '#e74c3c', type: 'red' },
    { label: '꽝', color: '#666666', type: 'lose' },
    { label: 'x2', color: '#2c3e50', type: 'black' },
    { label: '꽝', color: '#555555', type: 'lose' },
    { label: 'x2', color: '#e74c3c', type: 'red' },
    { label: 'x7', color: '#f1c40f', type: 'gold' },
    { label: 'x2', color: '#2c3e50', type: 'black' },
    { label: 'x2', color: '#e74c3c', type: 'red' },
    { label: 'x2', color: '#2c3e50', type: 'black' }
];

const SEGMENTS = WHEEL_DATA.length;
const SEGMENT_ANGLE = 360 / SEGMENTS;

const COLORS = WHEEL_DATA.map(d => d.color);
const LABELS = WHEEL_DATA.map(d => d.label);
const TYPES = WHEEL_DATA.map(d => d.type);

let currentBet = 100;
let isSpinning = false;
let userPoint = <?php echo $member_point; ?>;

// 캔버스에 룰렛 그리기
function drawWheel() {
    const canvas = document.getElementById('wheelCanvas');
    const ctx = canvas.getContext('2d');
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = canvas.width / 2 - 10;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < SEGMENTS; i++) {
        const startAngle = (i * SEGMENT_ANGLE - 90) * Math.PI / 180;
        const endAngle = ((i + 1) * SEGMENT_ANGLE - 90) * Math.PI / 180;

        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, startAngle, endAngle);
        ctx.closePath();
        ctx.fillStyle = COLORS[i];
        ctx.fill();
        ctx.strokeStyle = 'rgba(255,255,255,0.5)';
        ctx.lineWidth = 2;
        ctx.stroke();

        const textAngle = (i * SEGMENT_ANGLE + SEGMENT_ANGLE / 2 - 90) * Math.PI / 180;
        const textRadius = radius * 0.7;
        const textX = centerX + Math.cos(textAngle) * textRadius;
        const textY = centerY + Math.sin(textAngle) * textRadius;

        ctx.save();
        ctx.translate(textX, textY);
        ctx.rotate(textAngle + Math.PI / 2);
        ctx.fillStyle = 'white';
        ctx.font = 'bold 12px sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.shadowColor = 'rgba(0,0,0,0.5)';
        ctx.shadowBlur = 2;
        ctx.fillText(LABELS[i], 0, 0);
        ctx.restore();
    }
}

// 베팅 버튼 - 이벤트 위임 사용
document.querySelector('.bet-buttons').addEventListener('click', function(e) {
    const btn = e.target.closest('.bet-btn');
    if (!btn || isSpinning) return;

    e.preventDefault();
    e.stopPropagation();

    document.querySelectorAll('.bet-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentBet = parseInt(btn.dataset.bet);
    console.log('베팅금액 변경:', currentBet);
});

// 스핀
function spinRoulette() {
    if (isSpinning) return;

    if (userPoint < currentBet) {
        alert('포인트가 부족합니다!');
        return;
    }

    isSpinning = true;
    document.getElementById('spinBtn').disabled = true;
    document.getElementById('loadingOverlay').classList.add('show');

    fetch('<?php echo G5_URL; ?>/game/game_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=roulette&bet=${currentBet}`
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loadingOverlay').classList.remove('show');

        if (data.success) {
            animateSpin(data.result, data.win, data.winAmount, data.netProfit, data.newPoint, data.label);
        } else {
            alert(data.message || '오류 발생');
            isSpinning = false;
            document.getElementById('spinBtn').disabled = false;
        }
    })
    .catch(error => {
        document.getElementById('loadingOverlay').classList.remove('show');
        alert('서버 연결 오류');
        isSpinning = false;
        document.getElementById('spinBtn').disabled = false;
    });
}

function animateSpin(result, isWin, winAmount, netProfit, newPoint, label) {
    const wheel = document.getElementById('rouletteWheel');

    // 숫자 N의 중심 각도 (휠 기준, 0도 = 12시 방향)
    const segmentCenter = result * SEGMENT_ANGLE + SEGMENT_ANGLE / 2;
    // 휠을 시계방향으로 회전 → 숫자가 반시계로 이동
    // N을 12시로 가져오려면: 360 - segmentCenter 만큼 회전
    const stopAngle = 360 - segmentCenter;
    const rotations = 5 + Math.floor(Math.random() * 3);
    const totalRotation = 360 * rotations + stopAngle;

    wheel.style.transition = 'transform 5s cubic-bezier(0.17, 0.67, 0.12, 0.99)';
    wheel.style.transform = `rotate(${totalRotation}deg)`;

    setTimeout(() => {
        showResult(result, isWin, winAmount, netProfit, newPoint, label);

        setTimeout(() => {
            wheel.style.transition = 'none';
            wheel.style.transform = `rotate(${stopAngle}deg)`;
        }, 100);
    }, 5000);
}

function showResult(slotIndex, isWin, winAmount, netProfit, newPoint, label) {
    const modal = document.getElementById('resultModal');
    const resultNumber = document.getElementById('resultNumber');
    const resultText = document.getElementById('resultText');
    const resultAmount = document.getElementById('resultAmount');

    resultNumber.style.background = COLORS[slotIndex];
    resultNumber.textContent = LABELS[slotIndex];

    // 배팅 내역 추가
    const now = new Date();
    const datetime = `${String(now.getMonth() + 1).padStart(2, '0')}/${String(now.getDate()).padStart(2, '0')} ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
    const content = isWin ? `룰렛 당첨 (${label}, +${winAmount}P)` : '룰렛 꽝';
    addToBettingHistory(content, netProfit, datetime);

    if (isWin) {
        resultText.textContent = '🎉 당첨!';
        resultText.className = 'result-text win';
        resultAmount.textContent = `+${winAmount.toLocaleString()}P`;
    } else {
        resultText.textContent = '💀 꽝!';
        resultText.className = 'result-text lose';
        resultAmount.textContent = `-${Math.abs(netProfit).toLocaleString()}P`;
    }

    userPoint = newPoint;
    document.getElementById('userPoint').textContent = userPoint.toLocaleString() + 'P';

    addToHistory(slotIndex);
    modal.classList.add('show');
}

function closeResult() {
    document.getElementById('resultModal').classList.remove('show');
    isSpinning = false;
    document.getElementById('spinBtn').disabled = false;
}

function addToHistory(slotIndex) {
    const historyList = document.getElementById('historyList');

    // 새 항목을 맨 앞에 추가
    const item = document.createElement('div');
    item.className = 'history-item';
    item.style.background = COLORS[slotIndex];
    item.textContent = LABELS[slotIndex];
    historyList.insertBefore(item, historyList.firstChild);

    // 10개 초과 시 마지막 항목 제거
    const items = historyList.querySelectorAll('.history-item');
    if (items.length > 10) {
        items[items.length - 1].remove();
    }
}

// 배팅 내역에 새 항목 추가
function addToBettingHistory(content, point, datetime) {
    const historyList = document.getElementById('bettingHistoryList');
    const noHistory = historyList.querySelector('.no-history');
    if (noHistory) noHistory.remove();

    const isWin = point > 0;
    const pointClass = isWin ? 'point-win' : 'point-lose';
    const pointSign = isWin ? '+' : '';

    const row = document.createElement('div');
    row.className = 'history-row';
    row.innerHTML = `
        <div class="history-info">
            <span class="history-game">${content}</span>
            <span class="history-time">${datetime}</span>
        </div>
        <div class="history-point ${pointClass}">
            ${pointSign}${point.toLocaleString()}P
        </div>
    `;

    historyList.insertBefore(row, historyList.firstChild);

    // 최대 20개 유지
    const rows = historyList.querySelectorAll('.history-row');
    if (rows.length > 20) {
        rows[rows.length - 1].remove();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    drawWheel();
});
</script>

<?php
include_once(G5_PATH.'/tail.php');
?>
