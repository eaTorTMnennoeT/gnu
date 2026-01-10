<?php
/**
 * 슬롯머신 게임
 * 그누보드 포인트 연동
 */
include_once('./_common.php');

if (!$is_member) {
    alert('로그인 후 이용해주세요.', G5_URL);
    exit;
}

$g5['title'] = '슬롯머신';
include_once(G5_PATH.'/head.php');

// 현재 포인트
$my_point = $member['mb_point'];
?>

<style>
/* ========================================
   슬롯머신 - 라이트/다크 모드 대응
   ======================================== */

.slot-container {
    max-width: 500px;
    margin: 40px auto;
    padding: 20px;
}

.slot-machine {
    background: var(--bg-card, #ffffff);
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    border: 1px solid var(--border, #e0e0e0);
    text-align: center;
}

.slot-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.slot-subtitle {
    color: var(--text-secondary, #666);
    font-size: 14px;
    margin-bottom: 24px;
}

/* 포인트 표시 */
.slot-point-display {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 24px;
}

.point-box {
    background: var(--bg-main, #f5f5f5);
    padding: 12px 24px;
    border-radius: 12px;
    border: 1px solid var(--border, #e0e0e0);
}

.point-label {
    font-size: 11px;
    color: var(--text-secondary, #666);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.point-value {
    font-size: 24px;
    font-weight: 700;
    color: #f59e0b;
}

/* 릴 영역 */
.slot-reels {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 24px;
    padding: 20px;
    background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
    border-radius: 16px;
    box-shadow: inset 0 4px 20px rgba(0,0,0,0.5);
    position: relative;
}

.slot-reel {
    width: 90px;
    height: 100px;
    background: linear-gradient(180deg, #0f0f23 0%, #1a1a2e 50%, #0f0f23 100%);
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    box-shadow: inset 0 2px 10px rgba(0,0,0,0.8);
    border: 2px solid #333;
}

.reel-inner {
    position: absolute;
    width: 100%;
    transition: transform 0.1s ease-out;
}

.reel-symbol {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
}

/* 당첨선 */
.slot-reels::before {
    content: '';
    position: absolute;
    left: 10px;
    right: 10px;
    top: 50%;
    height: 3px;
    background: linear-gradient(90deg, transparent, #f59e0b, transparent);
    z-index: 10;
    pointer-events: none;
}

/* 베팅 영역 */
.slot-betting {
    margin-bottom: 24px;
}

.bet-label {
    font-size: 13px;
    color: var(--text-secondary, #666);
    margin-bottom: 8px;
}

.bet-buttons {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 12px;
}

.bet-btn {
    padding: 10px 20px;
    border: 2px solid var(--border, #e0e0e0);
    border-radius: 10px;
    background: var(--bg-main, #f5f5f5);
    color: var(--text-primary, #333);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.bet-btn:hover {
    border-color: #f59e0b;
    color: #f59e0b;
}

.bet-btn.active {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    border-color: transparent;
    color: white;
}

.bet-amount {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary, #333);
}

/* 스핀 버튼 */
.spin-btn {
    width: 100%;
    padding: 18px;
    font-size: 20px;
    font-weight: 700;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #ef4444 0%, #f59e0b 100%);
    color: white;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    text-transform: uppercase;
    letter-spacing: 2px;
}

.spin-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.5);
}

.spin-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.spin-btn.spinning {
    animation: pulse 0.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(0.98); }
}

/* 결과 메시지 */
.slot-result {
    margin-top: 20px;
    padding: 16px;
    border-radius: 12px;
    font-weight: 600;
    display: none;
}

.slot-result.win {
    display: block;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.15));
    border: 1px solid #10b981;
    color: #10b981;
    animation: winPulse 0.5s ease-out;
}

.slot-result.lose {
    display: block;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #ef4444;
}

.slot-result.jackpot {
    display: block;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(251, 191, 36, 0.2));
    border: 2px solid #f59e0b;
    color: #f59e0b;
    font-size: 20px;
    animation: jackpot 0.5s ease-out;
}

@keyframes winPulse {
    0% { transform: scale(0.9); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

@keyframes jackpot {
    0% { transform: scale(0.5) rotate(-5deg); opacity: 0; }
    50% { transform: scale(1.1) rotate(2deg); }
    100% { transform: scale(1) rotate(0deg); opacity: 1; }
}

/* 배당표 */
.slot-paytable {
    margin-top: 30px;
    padding: 20px;
    background: var(--bg-main, #f5f5f5);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
}

.paytable-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-secondary, #666);
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.paytable-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid var(--border, #e0e0e0);
}

.paytable-row:last-child {
    border-bottom: none;
}

.paytable-symbols {
    font-size: 24px;
}

.paytable-multiplier {
    font-weight: 700;
    color: #f59e0b;
}

/* 다크 모드 */
[data-theme="dark"] .slot-machine,
.dark .slot-machine {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}

[data-theme="dark"] .point-box,
.dark .point-box {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
}

[data-theme="dark"] .bet-btn,
.dark .bet-btn {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
    color: var(--text-primary, #f0f0f0);
}

[data-theme="dark"] .bet-btn.active,
.dark .bet-btn.active {
    background: linear-gradient(135deg, #f59e0b, #fbbf24) !important;
    border-color: transparent !important;
    color: white !important;
}

[data-theme="dark"] .slot-paytable,
.dark .slot-paytable {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
}

[data-theme="dark"] .bet-amount,
.dark .bet-amount {
    color: var(--text-primary, #f0f0f0);
}

/* 배팅 내역 섹션 */
.slot-history-section {
    margin-top: 20px;
    padding: 20px;
    background: var(--bg-main, #f5f5f5);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
    text-align: left;
}

.slot-history-section h3 {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-secondary, #666);
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.slot-history-list {
    max-height: 300px;
    overflow-y: auto;
}

.slot-history-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid var(--border, #e0e0e0);
}

.slot-history-row:last-child {
    border-bottom: none;
}

.slot-history-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.slot-history-game {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary, #333);
}

.slot-history-time {
    font-size: 11px;
    color: var(--text-muted, #999);
}

.slot-history-point {
    font-size: 14px;
    font-weight: 700;
}

.slot-history-point.point-win {
    color: #10b981;
}

.slot-history-point.point-lose {
    color: #ef4444;
}

.slot-no-history {
    text-align: center;
    color: var(--text-muted, #999);
    padding: 30px 0;
    font-size: 13px;
}

[data-theme="dark"] .slot-history-section,
.dark .slot-history-section {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
}

/* 반응형 */
@media (max-width: 540px) {
    .slot-container {
        padding: 10px;
        margin: 20px auto;
    }

    .slot-machine {
        padding: 20px;
    }

    .slot-reel {
        width: 70px;
        height: 80px;
    }

    .reel-symbol {
        height: 80px;
        font-size: 36px;
    }

    .bet-buttons {
        flex-wrap: wrap;
    }

    .bet-btn {
        padding: 8px 16px;
        font-size: 14px;
    }
}
</style>

<div class="slot-container">
    <div class="slot-machine">
        <h1 class="slot-title">SLOT MACHINE</h1>
        <p class="slot-subtitle">3개가 일치하면 당첨!</p>

        <!-- 포인트 표시 -->
        <div class="slot-point-display">
            <div class="point-box">
                <div class="point-label">보유 포인트</div>
                <div class="point-value" id="myPoint"><?php echo number_format($my_point); ?></div>
            </div>
        </div>

        <!-- 릴 영역 -->
        <div class="slot-reels">
            <div class="slot-reel" id="reel1">
                <div class="reel-inner">
                    <div class="reel-symbol">🍒</div>
                </div>
            </div>
            <div class="slot-reel" id="reel2">
                <div class="reel-inner">
                    <div class="reel-symbol">🍋</div>
                </div>
            </div>
            <div class="slot-reel" id="reel3">
                <div class="reel-inner">
                    <div class="reel-symbol">⭐</div>
                </div>
            </div>
        </div>

        <!-- 베팅 영역 -->
        <div class="slot-betting">
            <div class="bet-label">베팅 금액</div>
            <div class="bet-buttons">
                <button class="bet-btn" data-bet="10">10P</button>
                <button class="bet-btn" data-bet="50">50P</button>
                <button class="bet-btn active" data-bet="100">100P</button>
                <button class="bet-btn" data-bet="500">500P</button>
                <button class="bet-btn" data-bet="1000">1000P</button>
            </div>
            <div class="bet-amount">베팅: <span id="currentBet">100</span>P</div>
        </div>

        <!-- 스핀 버튼 -->
        <button class="spin-btn" id="spinBtn" onclick="spin()">
            SPIN!
        </button>

        <!-- 결과 -->
        <div class="slot-result" id="slotResult"></div>

        <!-- 배당표 -->
        <div class="slot-paytable">
            <div class="paytable-title">배당표</div>
            <div class="paytable-row">
                <span class="paytable-symbols">7️⃣ 7️⃣ 7️⃣</span>
                <span class="paytable-multiplier">x100 JACKPOT!</span>
            </div>
            <div class="paytable-row">
                <span class="paytable-symbols">💎 💎 💎</span>
                <span class="paytable-multiplier">x50</span>
            </div>
            <div class="paytable-row">
                <span class="paytable-symbols">⭐ ⭐ ⭐</span>
                <span class="paytable-multiplier">x20</span>
            </div>
            <div class="paytable-row">
                <span class="paytable-symbols">🍀 🍀 🍀</span>
                <span class="paytable-multiplier">x10</span>
            </div>
            <div class="paytable-row">
                <span class="paytable-symbols">🍒 🍒 🍒</span>
                <span class="paytable-multiplier">x5</span>
            </div>
            <div class="paytable-row">
                <span class="paytable-symbols">🍋 🍋 🍋</span>
                <span class="paytable-multiplier">x3</span>
            </div>
            <div class="paytable-row">
                <span class="paytable-symbols">🍇 🍇 🍇</span>
                <span class="paytable-multiplier">x2</span>
            </div>
        </div>

        <!-- 배팅 내역 -->
        <div class="slot-history-section">
            <h3>📋 내 배팅 내역</h3>
            <div class="slot-history-list" id="slotHistoryList">
                <?php
                // 최근 20개 슬롯 게임 내역 조회
                $sql = "SELECT po_content, po_point, po_datetime
                        FROM {$g5['point_table']}
                        WHERE mb_id = '{$member['mb_id']}'
                        AND po_content LIKE '%슬롯머신%'
                        ORDER BY po_id DESC
                        LIMIT 20";
                $result = sql_query($sql);

                if (sql_num_rows($result) > 0) {
                    while ($row = sql_fetch_array($result)) {
                        $isWin = $row['po_point'] > 0;
                        $pointClass = $isWin ? 'point-win' : 'point-lose';
                        $pointSign = $isWin ? '+' : '';
                        ?>
                        <div class="slot-history-row">
                            <div class="slot-history-info">
                                <span class="slot-history-game"><?php echo $row['po_content']; ?></span>
                                <span class="slot-history-time"><?php echo date('m/d H:i', strtotime($row['po_datetime'])); ?></span>
                            </div>
                            <div class="slot-history-point <?php echo $pointClass; ?>">
                                <?php echo $pointSign . number_format($row['po_point']); ?>P
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="slot-no-history">아직 배팅 내역이 없습니다.</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
const SYMBOLS = ['🍇', '🍋', '🍒', '🍀', '⭐', '💎', '7️⃣'];
const MULTIPLIERS = {
    '🍇': 2,
    '🍋': 3,
    '🍒': 5,
    '🍀': 10,
    '⭐': 20,
    '💎': 50,
    '7️⃣': 100
};

let currentBet = 100;
let myPoint = <?php echo $my_point; ?>;
let isSpinning = false;

// 베팅 버튼
document.querySelectorAll('.bet-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.bet-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        currentBet = parseInt(this.dataset.bet);
        document.getElementById('currentBet').textContent = currentBet;
    });
});

// 스핀
async function spin() {
    if (isSpinning) return;
    if (myPoint < currentBet) {
        alert('포인트가 부족합니다.');
        return;
    }

    isSpinning = true;
    const spinBtn = document.getElementById('spinBtn');
    spinBtn.disabled = true;
    spinBtn.classList.add('spinning');
    spinBtn.textContent = 'SPINNING...';

    // 결과 숨기기
    document.getElementById('slotResult').className = 'slot-result';
    document.getElementById('slotResult').style.display = 'none';

    try {
        // 서버에 스핀 요청
        const response = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=slot&bet=${currentBet}`
        });

        const result = await response.json();

        if (!result.success) {
            alert(result.message || '오류가 발생했습니다.');
            resetSpin();
            return;
        }

        // 릴 애니메이션
        await animateReels(result.reels);

        // 결과 표시
        myPoint = parseInt(result.newPoint);
        document.getElementById('myPoint').textContent = numberFormat(myPoint);

        showResult(result);

    } catch (e) {
        console.error(e);
        alert('오류가 발생했습니다.');
    }

    resetSpin();
}

function resetSpin() {
    isSpinning = false;
    const spinBtn = document.getElementById('spinBtn');
    spinBtn.disabled = false;
    spinBtn.classList.remove('spinning');
    spinBtn.textContent = 'SPIN!';
}

async function animateReels(finalSymbols) {
    const reels = [
        document.querySelector('#reel1 .reel-inner'),
        document.querySelector('#reel2 .reel-inner'),
        document.querySelector('#reel3 .reel-inner')
    ];

    // 각 릴 스핀
    for (let i = 0; i < 3; i++) {
        spinReel(reels[i], finalSymbols[i], 1000 + i * 500);
    }

    // 모든 릴 멈출 때까지 대기
    await new Promise(resolve => setTimeout(resolve, 2500));
}

function spinReel(reel, finalSymbol, duration) {
    const startTime = Date.now();
    const spinSpeed = 50;

    function animate() {
        const elapsed = Date.now() - startTime;

        if (elapsed < duration) {
            // 랜덤 심볼로 빠르게 변경
            const randomSymbol = SYMBOLS[Math.floor(Math.random() * SYMBOLS.length)];
            reel.innerHTML = `<div class="reel-symbol">${randomSymbol}</div>`;

            setTimeout(animate, spinSpeed);
        } else {
            // 최종 심볼
            reel.innerHTML = `<div class="reel-symbol">${finalSymbol}</div>`;
        }
    }

    animate();
}

function showResult(result) {
    const resultEl = document.getElementById('slotResult');

    // 내역에 추가할 내용
    const now = new Date();
    const datetime = `${String(now.getMonth() + 1).padStart(2, '0')}/${String(now.getDate()).padStart(2, '0')} ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
    let content = '';
    let point = 0;

    if (result.win) {
        if (result.winType === 'jackpot') {
            resultEl.className = 'slot-result jackpot';
            resultEl.innerHTML = `🎉 JACKPOT! +${numberFormat(result.winAmount)}P 🎉`;
            content = '슬롯머신 당첨 (jackpot)';
        } else if (result.winType === 'big') {
            resultEl.className = 'slot-result win';
            resultEl.innerHTML = `💎 BIG WIN! +${numberFormat(result.winAmount)}P`;
            content = '슬롯머신 당첨 (big)';
        } else {
            resultEl.className = 'slot-result win';
            resultEl.innerHTML = `🎊 당첨! +${numberFormat(result.winAmount)}P`;
            content = `슬롯머신 당첨 (${result.winType})`;
        }
        point = result.winAmount - currentBet;
    } else {
        resultEl.className = 'slot-result lose';
        resultEl.innerHTML = `😢 꽝! -${numberFormat(currentBet)}P`;
        content = '슬롯머신 게임';
        point = -currentBet;
    }

    resultEl.style.display = 'block';

    // 배팅 내역에 추가
    addToHistory(content, point, datetime);
}

function addToHistory(content, point, datetime) {
    const historyList = document.getElementById('slotHistoryList');
    const noHistory = historyList.querySelector('.slot-no-history');
    if (noHistory) noHistory.remove();

    const isWin = point > 0;
    const pointClass = isWin ? 'point-win' : 'point-lose';
    const pointSign = isWin ? '+' : '';

    const row = document.createElement('div');
    row.className = 'slot-history-row';
    row.innerHTML = `
        <div class="slot-history-info">
            <span class="slot-history-game">${content}</span>
            <span class="slot-history-time">${datetime}</span>
        </div>
        <div class="slot-history-point ${pointClass}">
            ${pointSign}${numberFormat(point)}P
        </div>
    `;

    historyList.insertBefore(row, historyList.firstChild);

    // 최대 20개 유지
    const rows = historyList.querySelectorAll('.slot-history-row');
    if (rows.length > 20) {
        rows[rows.length - 1].remove();
    }
}

function numberFormat(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}
</script>

<?php
include_once(G5_PATH.'/tail.php');
?>
