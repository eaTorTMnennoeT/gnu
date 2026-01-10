<?php
/**
 * 게임센터 메인 페이지
 * 그누보드 테마 레이아웃 적용
 */
include_once('./_common.php');

$g5['title'] = '게임센터';
include_once(G5_PATH.'/head.php');

$member_point = $is_member ? $member['mb_point'] : 0;
?>

<style>
/* ========================================
   게임센터 - 라이트/다크 모드 대응
   ======================================== */

.game-center {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

/* 헤더 섹션 */
.game-header-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
}

.game-header-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.5;
}

.game-header-content {
    position: relative;
    z-index: 1;
}

.game-header-icon {
    font-size: 56px;
    margin-bottom: 16px;
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.game-header-title {
    font-size: 32px;
    font-weight: 800;
    color: white;
    margin-bottom: 8px;
}

.game-header-subtitle {
    font-size: 16px;
    color: rgba(255,255,255,0.7);
    margin-bottom: 24px;
}

.game-header-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.game-stat {
    text-align: center;
}

.game-stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #f1c40f;
}

.game-stat-label {
    font-size: 13px;
    color: rgba(255,255,255,0.6);
    margin-top: 4px;
}

/* 포인트 바 */
.game-point-bar {
    background: var(--bg-card, #ffffff);
    border: 1px solid var(--border, #e0e0e0);
    border-radius: 16px;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 16px;
}

.point-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.point-icon-box {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #f1c40f, #e67e22);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.point-text {
    font-size: 14px;
    color: var(--text-secondary, #666);
}

.point-amount {
    font-size: 24px;
    font-weight: 700;
    color: #f1c40f;
}

/* 게임 그리드 */
.game-section-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-primary, #333);
}

.games-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.game-card {
    background: var(--bg-card, #ffffff);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
    overflow: hidden;
    transition: all 0.3s;
    text-decoration: none;
    color: inherit;
    display: block;
}

.game-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

.game-card.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    pointer-events: none;
}

.game-thumbnail {
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 64px;
    position: relative;
}

.game-thumbnail.slot {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.game-thumbnail.roulette {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
}

.game-thumbnail.coming {
    background: linear-gradient(135deg, #636e72 0%, #2d3436 100%);
}

.game-thumbnail.blackjack {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
}

.game-thumbnail.dice {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
}

.game-thumbnail.baccarat {
    background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
}

.game-thumbnail.btc {
    background: linear-gradient(135deg, #f7931a 0%, #ffab40 100%);
}

.game-thumbnail.ladder {
    background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
}

.game-thumbnail.racing {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
}

/* 실시간 게임 뱃지 */
.badge-live {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    animation: livePulse 1.5s ease-in-out infinite;
}

@keyframes livePulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* 실시간 게임 섹션 스타일 */
.live-game-card {
    position: relative;
    overflow: visible;
}

.live-game-card::before {
    content: '🔴 LIVE';
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 6px;
    z-index: 10;
    animation: livePulse 1.5s ease-in-out infinite;
}

.game-info {
    padding: 20px;
}

.game-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: var(--text-primary, #333);
}

.game-badge {
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 20px;
    text-transform: uppercase;
}

.badge-hot {
    background: #e74c3c;
    color: white;
}

.badge-new {
    background: #27ae60;
    color: white;
}

.badge-soon {
    background: #95a5a6;
    color: white;
}

.game-desc {
    font-size: 14px;
    color: var(--text-secondary, #666);
    line-height: 1.5;
    margin-bottom: 16px;
}

.game-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid var(--border, #e0e0e0);
}

.game-odds {
    font-size: 13px;
    color: var(--text-muted, #999);
}

.game-odds span {
    color: #f1c40f;
    font-weight: 600;
}

.play-btn {
    padding: 8px 20px;
    background: #10b981;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
}

/* 로그인 안내 */
.login-notice {
    background: var(--bg-card, #ffffff);
    border: 1px solid var(--border, #e0e0e0);
    border-radius: 16px;
    padding: 60px 20px;
    text-align: center;
}

.login-notice-icon {
    font-size: 56px;
    margin-bottom: 16px;
}

.login-notice h2 {
    font-size: 22px;
    margin-bottom: 8px;
    color: var(--text-primary, #333);
}

.login-notice p {
    color: var(--text-secondary, #666);
    margin-bottom: 24px;
}

.login-btn {
    display: inline-block;
    padding: 14px 40px;
    background: #10b981;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
}

/* 다크 모드 */
[data-theme="dark"] .game-point-bar,
.dark .game-point-bar {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}

[data-theme="dark"] .game-card,
.dark .game-card {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}

[data-theme="dark"] .login-notice,
.dark .login-notice {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}

/* 반응형 */
@media (max-width: 640px) {
    .game-header-section {
        padding: 30px 20px;
    }

    .game-header-title {
        font-size: 24px;
    }

    .game-header-stats {
        gap: 24px;
    }

    .game-point-bar {
        flex-direction: column;
        text-align: center;
    }

    .games-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="game-center">
    <!-- 헤더 -->
    <div class="game-header-section">
        <div class="game-header-content">
            <div class="game-header-icon">🎮</div>
            <h1 class="game-header-title">프리미엄 게임센터</h1>
            <p class="game-header-subtitle">포인트로 즐기는 다양한 미니게임!</p>
            <div class="game-header-stats">
                <div class="game-stat">
                    <div class="game-stat-value">8</div>
                    <div class="game-stat-label">게임 수</div>
                </div>
                <div class="game-stat">
                    <div class="game-stat-value">x100</div>
                    <div class="game-stat-label">최대 배당</div>
                </div>
                <div class="game-stat">
                    <div class="game-stat-value">24/7</div>
                    <div class="game-stat-label">운영 시간</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 포인트 바 -->
    <div class="game-point-bar">
        <div class="point-info">
            <div class="point-icon-box">💰</div>
            <div>
                <div class="point-text">보유 포인트</div>
                <div class="point-amount"><?php echo number_format($member_point); ?>P</div>
            </div>
        </div>
        <?php if (!$is_member) { ?>
        <a href="<?php echo G5_BBS_URL; ?>/login.php" class="login-btn">🔑 로그인</a>
        <?php } ?>
    </div>

    <?php if ($is_member) { ?>
    <!-- 게임 목록 -->
    <h2 class="game-section-title">🎰 게임 목록</h2>

    <div class="games-grid">
        <!-- 슬롯머신 -->
        <a href="<?php echo G5_URL; ?>/game/slot.php" class="game-card">
            <div class="game-thumbnail slot">🎰</div>
            <div class="game-info">
                <div class="game-title">
                    럭키 슬롯
                    <span class="game-badge badge-hot">HOT</span>
                </div>
                <p class="game-desc">3개의 릴을 돌려 같은 심볼을 맞추세요! 7️⃣ 잭팟 시 100배!</p>
                <div class="game-meta">
                    <span class="game-odds">최대 <span>x100</span></span>
                    <span class="play-btn">플레이</span>
                </div>
            </div>
        </a>

        <!-- 룰렛 -->
        <a href="<?php echo G5_URL; ?>/game/roulette.php" class="game-card">
            <div class="game-thumbnail roulette">🎡</div>
            <div class="game-info">
                <div class="game-title">
                    럭키 룰렛
                    <span class="game-badge badge-new">NEW</span>
                </div>
                <p class="game-desc">행운의 숫자에 베팅하세요! 초록(0) 14배, 골드(7) 7배!</p>
                <div class="game-meta">
                    <span class="game-odds">최대 <span>x14</span></span>
                    <span class="play-btn">플레이</span>
                </div>
            </div>
        </a>

        <!-- 주사위 -->
        <a href="<?php echo G5_URL; ?>/game/dice.php" class="game-card">
            <div class="game-thumbnail dice">🎲</div>
            <div class="game-info">
                <div class="game-title">
                    주사위 Hi-Lo
                    <span class="game-badge badge-new">NEW</span>
                </div>
                <p class="game-desc">두 주사위 합을 예측하세요! LOW(2-6), HIGH(8-12), SEVEN(7)!</p>
                <div class="game-meta">
                    <span class="game-odds">최대 <span>x5</span></span>
                    <span class="play-btn">플레이</span>
                </div>
            </div>
        </a>

        <!-- 블랙잭 -->
        <a href="<?php echo G5_URL; ?>/game/blackjack.php" class="game-card">
            <div class="game-thumbnail blackjack">🃏</div>
            <div class="game-info">
                <div class="game-title">
                    블랙잭
                    <span class="game-badge badge-new">NEW</span>
                </div>
                <p class="game-desc">딜러와의 카드 대결! 21에 가까운 숫자를 만들어 승리하세요.</p>
                <div class="game-meta">
                    <span class="game-odds">최대 <span>x2.5</span></span>
                    <span class="play-btn">플레이</span>
                </div>
            </div>
        </a>

        <!-- 바카라 -->
        <a href="<?php echo G5_URL; ?>/game/baccarat.php" class="game-card">
            <div class="game-thumbnail baccarat">💎</div>
            <div class="game-info">
                <div class="game-title">
                    바카라
                    <span class="game-badge badge-new">NEW</span>
                </div>
                <p class="game-desc">플레이어 vs 뱅커! 타이 배팅 시 8배 당첨!</p>
                <div class="game-meta">
                    <span class="game-odds">최대 <span>x8</span></span>
                    <span class="play-btn">플레이</span>
                </div>
            </div>
        </a>

        <!-- BTC Predict -->
        <a href="<?php echo G5_URL; ?>/game/btc.php" class="game-card">
            <div class="game-thumbnail btc">₿</div>
            <div class="game-info">
                <div class="game-title">
                    BTC Predict
                    <span class="game-badge badge-hot">HOT</span>
                </div>
                <p class="game-desc">비트코인 가격을 예측하세요! UP or DOWN!</p>
                <div class="game-meta">
                    <span class="game-odds">최대 <span>x1.95</span></span>
                    <span class="play-btn">플레이</span>
                </div>
            </div>
        </a>
    </div>

    <!-- 실시간 게임 섹션 -->
    <h2 class="game-section-title">🔴 실시간 게임 (LIVE)</h2>

    <div class="games-grid">
        <!-- 사다리 게임 -->
        <a href="<?php echo G5_URL; ?>/game/ladder.php" class="game-card live-game-card">
            <div class="game-thumbnail ladder">🪜</div>
            <div class="game-info">
                <div class="game-title">
                    사다리 게임
                    <span class="game-badge badge-live">LIVE</span>
                </div>
                <p class="game-desc">3분마다 새 회차! 좌/우, 홀/짝, 3줄/4줄을 맞춰보세요!</p>
                <div class="game-meta">
                    <span class="game-odds">배당 <span>x1.95</span></span>
                    <span class="play-btn">참여하기</span>
                </div>
            </div>
        </a>

        <!-- 경마 게임 -->
        <a href="<?php echo G5_URL; ?>/game/racing.php" class="game-card live-game-card">
            <div class="game-thumbnail racing">🏇</div>
            <div class="game-info">
                <div class="game-title">
                    경마 게임
                    <span class="game-badge badge-live">LIVE</span>
                </div>
                <p class="game-desc">5분마다 새 경주! 6마리 말 중 우승마를 예측하세요!</p>
                <div class="game-meta">
                    <span class="game-odds">최대 <span>x10</span></span>
                    <span class="play-btn">참여하기</span>
                </div>
            </div>
        </a>
    </div>

    <?php } else { ?>
    <!-- 로그인 안내 -->
    <div class="login-notice">
        <div class="login-notice-icon">🔒</div>
        <h2>로그인이 필요합니다</h2>
        <p>게임을 즐기려면 먼저 로그인해주세요.</p>
        <a href="<?php echo G5_BBS_URL; ?>/login.php" class="login-btn">로그인하기</a>
    </div>
    <?php } ?>
</div>

<?php
include_once(G5_PATH.'/tail.php');
?>
