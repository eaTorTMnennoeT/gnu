<?php
/**
 * 주사위 (Hi-Lo) 게임 - 3D 프리미엄
 * 그누보드 테마 레이아웃 적용
 */
include_once('./_common.php');

if (!$is_member) {
    alert('로그인 후 이용해주세요.', G5_URL);
    exit;
}

$g5['title'] = '주사위';
include_once(G5_PATH.'/head.php');

$member_point = $member['mb_point'];
?>

<style>
/* ========================================
   주사위 게임 - 3D 프리미엄 버전
   ======================================== */

.dice-container {
    max-width: 500px;
    margin: 40px auto;
    padding: 20px;
    padding-bottom: 220px;
}

@media (min-width: 769px) {
    .dice-container {
        padding-bottom: 20px;
    }
}

@media (max-width: 768px) {
    .dice-container {
        padding-bottom: 200px;
    }
}

.dice-game {
    background: var(--bg-card, #ffffff);
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    border: 1px solid var(--border, #e0e0e0);
    text-align: center;
}

.dice-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.dice-subtitle {
    color: var(--text-secondary, #666);
    font-size: 14px;
    margin-bottom: 24px;
}

/* 포인트 표시 */
.dice-point-display {
    display: flex;
    justify-content: center;
    margin-bottom: 24px;
}

.dice-point-box {
    background: var(--bg-main, #f5f5f5);
    padding: 12px 24px;
    border-radius: 12px;
    border: 1px solid var(--border, #e0e0e0);
}

.dice-point-label {
    font-size: 11px;
    color: var(--text-secondary, #666);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.dice-point-value {
    font-size: 24px;
    font-weight: 700;
    color: #3b82f6;
}

/* 3D 주사위 영역 */
.dice-area {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-bottom: 30px;
    padding: 50px 30px;
    background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    border-radius: 20px;
    perspective: 600px;
    position: relative;
    overflow: hidden;
}

.dice-area::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background:
        radial-gradient(ellipse at center bottom, rgba(255,255,255,0.1) 0%, transparent 60%),
        repeating-linear-gradient(90deg, transparent, transparent 50px, rgba(255,255,255,0.02) 50px, rgba(255,255,255,0.02) 100px);
    pointer-events: none;
}

/* 3D 주사위 */
.dice-3d-wrapper {
    width: 80px;
    height: 80px;
    perspective: 400px;
}

.dice-3d {
    width: 80px;
    height: 80px;
    position: relative;
    transform-style: preserve-3d;
    transform: rotateX(-20deg) rotateY(20deg);
    transition: transform 0.1s ease-out;
}

.dice-3d.rolling {
    animation: diceRoll3D 0.15s linear infinite;
}

@keyframes diceRoll3D {
    0% { transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg); }
    25% { transform: rotateX(90deg) rotateY(90deg) rotateZ(45deg); }
    50% { transform: rotateX(180deg) rotateY(180deg) rotateZ(90deg); }
    75% { transform: rotateX(270deg) rotateY(270deg) rotateZ(135deg); }
    100% { transform: rotateX(360deg) rotateY(360deg) rotateZ(180deg); }
}

.dice-face {
    position: absolute;
    width: 80px;
    height: 80px;
    background: linear-gradient(145deg, #ffffff 0%, #f0f0f0 50%, #e0e0e0 100%);
    border: 2px solid #ccc;
    border-radius: 12px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    padding: 10px;
    box-sizing: border-box;
    box-shadow: inset 0 2px 4px rgba(255,255,255,0.8), inset 0 -2px 4px rgba(0,0,0,0.1);
}

/* 주사위 면 위치 */
.dice-face.front  { transform: translateZ(40px); }
.dice-face.back   { transform: rotateY(180deg) translateZ(40px); }
.dice-face.right  { transform: rotateY(90deg) translateZ(40px); }
.dice-face.left   { transform: rotateY(-90deg) translateZ(40px); }
.dice-face.top    { transform: rotateX(90deg) translateZ(40px); }
.dice-face.bottom { transform: rotateX(-90deg) translateZ(40px); }

/* 주사위 눈 (점) */
.dot {
    width: 14px;
    height: 14px;
    background: radial-gradient(circle at 30% 30%, #4a4a4a, #1a1a1a);
    border-radius: 50%;
    box-shadow: inset 0 2px 3px rgba(0,0,0,0.5), 0 1px 1px rgba(255,255,255,0.3);
}

/* 1 */
.dice-face.face-1 {
    display: flex;
    align-items: center;
    justify-content: center;
}

.dice-face.face-1 .dot {
    width: 18px;
    height: 18px;
    background: radial-gradient(circle at 30% 30%, #dc2626, #7f1d1d);
}

/* 2 */
.dice-face.face-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    padding: 12px;
}

.dice-face.face-2 .dot:nth-child(1) { grid-area: 1 / 1; justify-self: start; align-self: start; }
.dice-face.face-2 .dot:nth-child(2) { grid-area: 2 / 2; justify-self: end; align-self: end; }

/* 3 */
.dice-face.face-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-template-rows: 1fr 1fr 1fr;
    padding: 10px;
}

.dice-face.face-3 .dot:nth-child(1) { grid-area: 1 / 1; justify-self: start; align-self: start; }
.dice-face.face-3 .dot:nth-child(2) { grid-area: 2 / 2; justify-self: center; align-self: center; }
.dice-face.face-3 .dot:nth-child(3) { grid-area: 3 / 3; justify-self: end; align-self: end; }

/* 4 */
.dice-face.face-4 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    padding: 12px;
    gap: 4px;
}

/* 5 */
.dice-face.face-5 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-template-rows: 1fr 1fr 1fr;
    padding: 10px;
}

.dice-face.face-5 .dot:nth-child(1) { grid-area: 1 / 1; justify-self: start; align-self: start; }
.dice-face.face-5 .dot:nth-child(2) { grid-area: 1 / 3; justify-self: end; align-self: start; }
.dice-face.face-5 .dot:nth-child(3) { grid-area: 2 / 2; justify-self: center; align-self: center; }
.dice-face.face-5 .dot:nth-child(4) { grid-area: 3 / 1; justify-self: start; align-self: end; }
.dice-face.face-5 .dot:nth-child(5) { grid-area: 3 / 3; justify-self: end; align-self: end; }

/* 6 */
.dice-face.face-6 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr 1fr;
    padding: 12px;
    gap: 2px;
}

/* 합계 표시 */
.dice-sum-display {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.6);
    padding: 8px 24px;
    border-radius: 20px;
    color: white;
    font-size: 18px;
    font-weight: 700;
    opacity: 0;
    transition: opacity 0.3s;
    z-index: 10;
}

.dice-sum-display.show {
    opacity: 1;
}

.dice-sum-display.win {
    background: linear-gradient(135deg, #10b981, #059669);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.dice-sum-display.lose {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
}

/* 데스크톱 베팅 섹션 - 모바일에서 숨김 */
@media (max-width: 768px) {
    .bet-type-section,
    .bet-amount-section,
    .roll-btn {
        display: none !important;
    }
}

/* 베팅 타입 */
.bet-type-section {
    margin-bottom: 20px;
}

.bet-type-label {
    font-size: 13px;
    color: var(--text-secondary, #666);
    margin-bottom: 10px;
}

.bet-type-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 16px;
}

.bet-type-btn {
    padding: 16px 12px;
    border: 2px solid var(--border, #e0e0e0);
    border-radius: 12px;
    background: var(--bg-main, #f5f5f5);
    color: var(--text-primary, #333);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.bet-type-btn:hover {
    border-color: #3b82f6;
    transform: translateY(-2px);
}

.bet-type-btn.active {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

.bet-type-btn .type-name {
    font-size: 16px;
    display: block;
    margin-bottom: 4px;
}

.bet-type-btn .type-odds {
    font-size: 12px;
    opacity: 0.8;
}

/* 베팅 금액 */
.bet-amount-section {
    margin-bottom: 24px;
}

.bet-amount-buttons {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}

.bet-btn {
    padding: 10px 18px;
    border: 2px solid var(--border, #e0e0e0);
    border-radius: 10px;
    background: var(--bg-main, #f5f5f5);
    color: var(--text-primary, #333);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.bet-btn:hover {
    border-color: #3b82f6;
}

.bet-btn.active {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.current-bet {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary, #333);
    margin-top: 12px;
}

/* 롤 버튼 */
.roll-btn {
    width: 100%;
    padding: 18px;
    font-size: 20px;
    font-weight: 700;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    color: white;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    text-transform: uppercase;
    letter-spacing: 2px;
    position: relative;
    overflow: hidden;
}

.roll-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.roll-btn:hover:not(:disabled)::before {
    left: 100%;
}

.roll-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
}

.roll-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.roll-btn.rolling {
    animation: btnPulse 0.5s ease-in-out infinite;
}

@keyframes btnPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(0.98); }
}

/* 결과 */
.dice-result {
    margin-top: 20px;
    padding: 16px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 18px;
    display: none;
    animation: resultPop 0.3s ease-out;
}

@keyframes resultPop {
    0% { transform: scale(0.8); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.dice-result.win {
    display: block;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.15));
    border: 2px solid #10b981;
    color: #10b981;
}

.dice-result.lose {
    display: block;
    background: rgba(239, 68, 68, 0.1);
    border: 2px solid rgba(239, 68, 68, 0.5);
    color: #ef4444;
}

/* 규칙 */
.dice-rules {
    margin-top: 30px;
    padding: 20px;
    background: var(--bg-main, #f5f5f5);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
    text-align: left;
}

.dice-rules h3 {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-secondary, #666);
    margin-bottom: 12px;
}

.dice-rules ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.dice-rules li {
    padding: 6px 0;
    font-size: 13px;
    color: var(--text-secondary, #666);
}

.dice-rules li::before {
    content: "•";
    color: #3b82f6;
    margin-right: 8px;
}

/* 배팅 내역 */
.dice-history-section {
    margin-top: 20px;
    padding: 20px;
    background: var(--bg-main, #f5f5f5);
    border-radius: 16px;
    border: 1px solid var(--border, #e0e0e0);
    text-align: left;
}

.dice-history-section h3 {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-secondary, #666);
    margin-bottom: 12px;
    text-transform: uppercase;
}

.dice-history-list {
    max-height: 250px;
    overflow-y: auto;
}

.dice-history-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid var(--border, #e0e0e0);
}

.dice-history-row:last-child {
    border-bottom: none;
}

.dice-history-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.dice-history-game {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary, #333);
}

.dice-history-time {
    font-size: 11px;
    color: var(--text-muted, #999);
}

.dice-history-point {
    font-size: 14px;
    font-weight: 700;
}

.dice-history-point.point-win {
    color: #10b981;
}

.dice-history-point.point-lose {
    color: #ef4444;
}

.dice-no-history {
    text-align: center;
    color: var(--text-muted, #999);
    padding: 30px 0;
    font-size: 13px;
}

/* 다크 모드 */
[data-theme="dark"] .dice-game,
.dark .dice-game {
    background: var(--bg-card, #1e1e1e);
    border-color: var(--border, #333);
}

[data-theme="dark"] .dice-point-box,
.dark .dice-point-box {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
}

[data-theme="dark"] .bet-type-btn,
.dark .bet-type-btn {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
    color: var(--text-primary, #f0f0f0);
}

[data-theme="dark"] .bet-type-btn.active,
.dark .bet-type-btn.active {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6) !important;
    border-color: transparent !important;
    color: white !important;
}

[data-theme="dark"] .bet-btn,
.dark .bet-btn {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
    color: var(--text-primary, #f0f0f0);
}

[data-theme="dark"] .bet-btn.active,
.dark .bet-btn.active {
    background: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: white !important;
}

[data-theme="dark"] .dice-rules,
.dark .dice-rules {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
}

[data-theme="dark"] .dice-history-section,
.dark .dice-history-section {
    background: var(--bg-main, #121212);
    border-color: var(--border, #333);
}

[data-theme="dark"] .current-bet,
.dark .current-bet {
    color: var(--text-primary, #f0f0f0);
}

/* 반응형 */
@media (max-width: 480px) {
    .dice-container {
        padding: 10px;
        margin: 20px auto;
    }

    .dice-game {
        padding: 20px;
    }

    .dice-area {
        gap: 20px;
        padding: 40px 20px;
    }

    .dice-3d-wrapper {
        width: 65px;
        height: 65px;
    }

    .dice-3d {
        width: 65px;
        height: 65px;
    }

    .dice-face {
        width: 65px;
        height: 65px;
        border-radius: 10px;
    }

    .dice-face.front  { transform: translateZ(32.5px); }
    .dice-face.back   { transform: rotateY(180deg) translateZ(32.5px); }
    .dice-face.right  { transform: rotateY(90deg) translateZ(32.5px); }
    .dice-face.left   { transform: rotateY(-90deg) translateZ(32.5px); }
    .dice-face.top    { transform: rotateX(90deg) translateZ(32.5px); }
    .dice-face.bottom { transform: rotateX(-90deg) translateZ(32.5px); }

    .dot {
        width: 11px;
        height: 11px;
    }

    .dice-face.face-1 .dot {
        width: 14px;
        height: 14px;
    }

    .bet-type-buttons {
        gap: 6px;
    }

    .bet-type-btn {
        padding: 12px 8px;
    }

    .bet-type-btn .type-name {
        font-size: 14px;
    }
}

/* ========================================
   모바일 하단 고정 배팅
   ======================================== */
.mobile-betting {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(180deg, #1a1a2e 0%, #0f0f1a 100%);
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 12px 12px;
    padding-bottom: calc(12px + env(safe-area-inset-bottom));
    z-index: 1000;
    box-shadow: 0 -10px 40px rgba(0,0,0,0.5);
    box-sizing: border-box;
    width: 100%;
}

@media (max-width: 768px) {
    .mobile-betting {
        display: block;
    }
}

@media (max-width: 400px) {
    .mobile-betting {
        padding: 10px 8px;
        padding-bottom: calc(10px + env(safe-area-inset-bottom));
    }
}

/* 모바일 베팅 타입 버튼 */
.mobile-bet-types {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-bottom: 12px;
}

@media (max-width: 400px) {
    .mobile-bet-types {
        gap: 6px;
        margin-bottom: 10px;
    }
}

.mobile-type-btn {
    padding: 10px 8px;
    border: 2px solid transparent;
    border-radius: 10px;
    background: rgba(255,255,255,0.05);
    color: white;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
    min-width: 0;
}

.mobile-type-btn .type-name {
    font-size: 12px;
    display: block;
}

.mobile-type-btn .type-odds {
    font-size: 10px;
    opacity: 0.6;
    display: block;
    margin-top: 2px;
}

@media (max-width: 400px) {
    .mobile-type-btn {
        padding: 8px 4px;
        border-radius: 8px;
    }

    .mobile-type-btn .type-name {
        font-size: 11px;
    }

    .mobile-type-btn .type-odds {
        font-size: 9px;
    }
}

.mobile-type-btn.low-btn {
    border-color: rgba(59, 130, 246, 0.5);
}

.mobile-type-btn.low-btn.active {
    background: #3b82f6;
    border-color: #3b82f6;
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
}

.mobile-type-btn.high-btn {
    border-color: rgba(239, 68, 68, 0.5);
}

.mobile-type-btn.high-btn.active {
    background: #ef4444;
    border-color: #ef4444;
    box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
}

.mobile-type-btn.seven-btn {
    border-color: rgba(245, 158, 11, 0.5);
}

.mobile-type-btn.seven-btn.active {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-color: #f59e0b;
    box-shadow: 0 0 20px rgba(245, 158, 11, 0.4);
}

/* 모바일 베팅 하단 영역 */
.mobile-bet-row {
    display: flex;
    gap: 10px;
    align-items: center;
}

.mobile-bet-chips {
    flex: 1;
    display: flex;
    gap: 6px;
    overflow-x: auto;
    padding: 4px 0;
    -webkit-overflow-scrolling: touch;
    min-width: 0;
}

.mobile-bet-chips::-webkit-scrollbar {
    display: none;
}

@media (max-width: 400px) {
    .mobile-bet-chips {
        gap: 4px;
    }
}

.mobile-chip {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 3px solid;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    background: linear-gradient(145deg, #2a2a3e, #1a1a2e);
}

.mobile-chip .chip-value {
    font-size: 11px;
    font-weight: 800;
    color: white;
}

.mobile-chip.chip-10 { border-color: #64748b; }
.mobile-chip.chip-50 { border-color: #3b82f6; }
.mobile-chip.chip-100 { border-color: #10b981; }
.mobile-chip.chip-500 { border-color: #8b5cf6; }
.mobile-chip.chip-1000 { border-color: #f59e0b; }

.mobile-chip.active {
    transform: scale(1.1);
    box-shadow: 0 0 15px currentColor;
}

.mobile-chip.chip-10.active { background: #64748b; }
.mobile-chip.chip-50.active { background: #3b82f6; }
.mobile-chip.chip-100.active { background: #10b981; }
.mobile-chip.chip-500.active { background: #8b5cf6; }
.mobile-chip.chip-1000.active { background: #f59e0b; }

@media (max-width: 400px) {
    .mobile-chip {
        width: 38px;
        height: 38px;
    }

    .mobile-chip .chip-value {
        font-size: 10px;
    }
}

/* 모바일 롤 버튼 */
.mobile-roll-btn {
    flex-shrink: 0;
    width: 80px;
    height: 50px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    color: white;
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    text-transform: uppercase;
}

.mobile-roll-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
}

.mobile-roll-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.mobile-roll-btn.rolling {
    animation: btnPulse 0.5s ease-in-out infinite;
}

@media (max-width: 400px) {
    .mobile-roll-btn {
        width: 70px;
        height: 44px;
        font-size: 12px;
    }
}
</style>

<div class="dice-container">
    <div class="dice-game">
        <h1 class="dice-title">DICE Hi-Lo</h1>
        <p class="dice-subtitle">높음/낮음/더블을 맞춰보세요!</p>

        <!-- 포인트 -->
        <div class="dice-point-display">
            <div class="dice-point-box">
                <div class="dice-point-label">보유 포인트</div>
                <div class="dice-point-value" id="userPoint"><?php echo number_format($member_point); ?></div>
            </div>
        </div>

        <!-- 3D 주사위 -->
        <div class="dice-area">
            <div class="dice-3d-wrapper">
                <div class="dice-3d" id="dice1">
                    <!-- 6개 면 -->
                    <div class="dice-face front face-1"><div class="dot"></div></div>
                    <div class="dice-face back face-6"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>
                    <div class="dice-face right face-3"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>
                    <div class="dice-face left face-4"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>
                    <div class="dice-face top face-2"><div class="dot"></div><div class="dot"></div></div>
                    <div class="dice-face bottom face-5"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>
                </div>
            </div>
            <div class="dice-3d-wrapper">
                <div class="dice-3d" id="dice2">
                    <div class="dice-face front face-1"><div class="dot"></div></div>
                    <div class="dice-face back face-6"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>
                    <div class="dice-face right face-3"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>
                    <div class="dice-face left face-4"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>
                    <div class="dice-face top face-2"><div class="dot"></div><div class="dot"></div></div>
                    <div class="dice-face bottom face-5"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>
                </div>
            </div>
            <div class="dice-sum-display" id="diceSumDisplay">= ?</div>
        </div>

        <!-- 베팅 타입 -->
        <div class="bet-type-section">
            <div class="bet-type-label">베팅 타입 선택</div>
            <div class="bet-type-buttons">
                <button class="bet-type-btn active" data-type="low">
                    <span class="type-name">LOW (2~6)</span>
                    <span class="type-odds">x2</span>
                </button>
                <button class="bet-type-btn" data-type="high">
                    <span class="type-name">HIGH (8~12)</span>
                    <span class="type-odds">x2</span>
                </button>
                <button class="bet-type-btn" data-type="seven">
                    <span class="type-name">SEVEN</span>
                    <span class="type-odds">x5</span>
                </button>
            </div>
        </div>

        <!-- 베팅 금액 -->
        <div class="bet-amount-section">
            <div class="bet-type-label">베팅 금액</div>
            <div class="bet-amount-buttons">
                <button class="bet-btn" data-bet="10">10P</button>
                <button class="bet-btn" data-bet="50">50P</button>
                <button class="bet-btn active" data-bet="100">100P</button>
                <button class="bet-btn" data-bet="500">500P</button>
                <button class="bet-btn" data-bet="1000">1000P</button>
            </div>
            <div class="current-bet">베팅: <span id="currentBet">100</span>P</div>
        </div>

        <!-- 롤 버튼 -->
        <button class="roll-btn" id="rollBtn" onclick="rollDice()">
            ROLL DICE!
        </button>

        <!-- 결과 -->
        <div class="dice-result" id="diceResult"></div>

        <!-- 규칙 -->
        <div class="dice-rules">
            <h3>게임 규칙</h3>
            <ul>
                <li>두 개의 주사위를 굴려 합을 맞추세요</li>
                <li>LOW (2~6): 2배 당첨</li>
                <li>HIGH (8~12): 2배 당첨</li>
                <li>SEVEN (7): 5배 당첨</li>
                <li>7이 나올 확률: 약 16.7%</li>
            </ul>
        </div>

        <!-- 배팅 내역 -->
        <div class="dice-history-section">
            <h3>내 배팅 내역</h3>
            <div class="dice-history-list" id="diceHistoryList">
                <?php
                $sql = "SELECT po_content, po_point, po_datetime
                        FROM {$g5['point_table']}
                        WHERE mb_id = '{$member['mb_id']}'
                        AND po_content LIKE '%주사위%'
                        ORDER BY po_id DESC
                        LIMIT 20";
                $result = sql_query($sql);

                if (sql_num_rows($result) > 0) {
                    while ($row = sql_fetch_array($result)) {
                        $isWin = $row['po_point'] > 0;
                        $pointClass = $isWin ? 'point-win' : 'point-lose';
                        $pointSign = $isWin ? '+' : '';
                        ?>
                        <div class="dice-history-row">
                            <div class="dice-history-info">
                                <span class="dice-history-game"><?php echo $row['po_content']; ?></span>
                                <span class="dice-history-time"><?php echo date('m/d H:i', strtotime($row['po_datetime'])); ?></span>
                            </div>
                            <div class="dice-history-point <?php echo $pointClass; ?>">
                                <?php echo $pointSign . number_format($row['po_point']); ?>P
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="dice-no-history">아직 배팅 내역이 없습니다.</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- 모바일 하단 고정 배팅 -->
<div class="mobile-betting">
    <div class="mobile-bet-types">
        <button class="mobile-type-btn low-btn active" data-type="low">
            <span class="type-name">LOW (2~6)</span>
            <span class="type-odds">x2</span>
        </button>
        <button class="mobile-type-btn high-btn" data-type="high">
            <span class="type-name">HIGH (8~12)</span>
            <span class="type-odds">x2</span>
        </button>
        <button class="mobile-type-btn seven-btn" data-type="seven">
            <span class="type-name">SEVEN</span>
            <span class="type-odds">x5</span>
        </button>
    </div>
    <div class="mobile-bet-row">
        <div class="mobile-bet-chips">
            <div class="mobile-chip chip-10" data-bet="10"><span class="chip-value">10</span></div>
            <div class="mobile-chip chip-50" data-bet="50"><span class="chip-value">50</span></div>
            <div class="mobile-chip chip-100 active" data-bet="100"><span class="chip-value">100</span></div>
            <div class="mobile-chip chip-500" data-bet="500"><span class="chip-value">500</span></div>
            <div class="mobile-chip chip-1000" data-bet="1000"><span class="chip-value">1K</span></div>
        </div>
        <button class="mobile-roll-btn" id="mobileRollBtn" onclick="rollDice()">ROLL</button>
    </div>
</div>

<script>
let currentBet = 100;
let currentType = 'low';
let userPoint = <?php echo $member_point; ?>;
let isRolling = false;

// 주사위 면 회전 값 (어떤 숫자가 앞면에 오게 할지)
const diceRotations = {
    1: { x: 0, y: 0 },
    2: { x: -90, y: 0 },
    3: { x: 0, y: -90 },
    4: { x: 0, y: 90 },
    5: { x: 90, y: 0 },
    6: { x: 180, y: 0 }
};

// 베팅 타입 버튼 (데스크톱 + 모바일 동기화)
document.querySelectorAll('.bet-type-btn, .mobile-type-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (isRolling) return;
        const type = this.dataset.type;
        // 데스크톱
        document.querySelectorAll('.bet-type-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll(`.bet-type-btn[data-type="${type}"]`).forEach(b => b.classList.add('active'));
        // 모바일
        document.querySelectorAll('.mobile-type-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll(`.mobile-type-btn[data-type="${type}"]`).forEach(b => b.classList.add('active'));
        currentType = type;
    });
});

// 베팅 금액 버튼 (데스크톱 + 모바일 동기화)
document.querySelectorAll('.bet-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (isRolling) return;
        const bet = parseInt(this.dataset.bet);
        document.querySelectorAll('.bet-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.mobile-chip').forEach(c => c.classList.remove('active'));
        document.querySelectorAll(`.mobile-chip[data-bet="${bet}"]`).forEach(c => c.classList.add('active'));
        currentBet = bet;
        document.getElementById('currentBet').textContent = currentBet;
    });
});

// 모바일 칩 버튼
document.querySelectorAll('.mobile-chip').forEach(chip => {
    chip.addEventListener('click', function() {
        if (isRolling) return;
        const bet = parseInt(this.dataset.bet);
        document.querySelectorAll('.mobile-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.bet-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll(`.bet-btn[data-bet="${bet}"]`).forEach(b => b.classList.add('active'));
        currentBet = bet;
        document.getElementById('currentBet').textContent = currentBet;
    });
});

// 주사위 굴리기
async function rollDice() {
    if (isRolling) return;
    if (userPoint < currentBet) {
        alert('포인트가 부족합니다.');
        return;
    }

    isRolling = true;
    const rollBtn = document.getElementById('rollBtn');
    const mobileRollBtn = document.getElementById('mobileRollBtn');
    rollBtn.disabled = true;
    rollBtn.textContent = 'ROLLING...';
    rollBtn.classList.add('rolling');
    mobileRollBtn.disabled = true;
    mobileRollBtn.textContent = '...';
    mobileRollBtn.classList.add('rolling');

    const dice1 = document.getElementById('dice1');
    const dice2 = document.getElementById('dice2');
    const sumDisplay = document.getElementById('diceSumDisplay');

    dice1.classList.add('rolling');
    dice2.classList.add('rolling');
    sumDisplay.classList.remove('show', 'win', 'lose');
    sumDisplay.textContent = '= ?';

    document.getElementById('diceResult').style.display = 'none';

    try {
        const response = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=dice&bet=${currentBet}&betType=${currentType}`
        });

        const result = await response.json();

        if (!result.success) {
            alert(result.message || '오류가 발생했습니다.');
            resetRoll();
            return;
        }

        // 3D 애니메이션
        await animate3DDice(result.dice1, result.dice2, result.win);

        // 결과 표시
        userPoint = result.newPoint;
        document.getElementById('userPoint').textContent = numberFormat(userPoint);

        showResult(result);

    } catch (e) {
        console.error(e);
        alert('오류가 발생했습니다.');
    }

    resetRoll();
}

function resetRoll() {
    isRolling = false;
    const rollBtn = document.getElementById('rollBtn');
    const mobileRollBtn = document.getElementById('mobileRollBtn');
    rollBtn.disabled = false;
    rollBtn.textContent = 'ROLL DICE!';
    rollBtn.classList.remove('rolling');
    mobileRollBtn.disabled = false;
    mobileRollBtn.textContent = 'ROLL';
    mobileRollBtn.classList.remove('rolling');

    document.getElementById('dice1').classList.remove('rolling');
    document.getElementById('dice2').classList.remove('rolling');
}

async function animate3DDice(final1, final2, isWin) {
    const dice1 = document.getElementById('dice1');
    const dice2 = document.getElementById('dice2');
    const sumDisplay = document.getElementById('diceSumDisplay');

    // 랜덤 회전 애니메이션 (2초)
    const duration = 2000;
    const startTime = Date.now();

    return new Promise(resolve => {
        function animate() {
            const elapsed = Date.now() - startTime;
            const progress = elapsed / duration;

            if (progress < 1) {
                // 속도 감소 효과
                const speed = 1 - Math.pow(progress, 2);
                const rotX1 = Math.random() * 360 * speed;
                const rotY1 = Math.random() * 360 * speed;
                const rotZ1 = Math.random() * 360 * speed;
                const rotX2 = Math.random() * 360 * speed;
                const rotY2 = Math.random() * 360 * speed;
                const rotZ2 = Math.random() * 360 * speed;

                dice1.style.transform = `rotateX(${rotX1}deg) rotateY(${rotY1}deg) rotateZ(${rotZ1}deg)`;
                dice2.style.transform = `rotateX(${rotX2}deg) rotateY(${rotY2}deg) rotateZ(${rotZ2}deg)`;

                requestAnimationFrame(animate);
            } else {
                // 최종 면으로 정지
                dice1.classList.remove('rolling');
                dice2.classList.remove('rolling');

                const rot1 = diceRotations[final1];
                const rot2 = diceRotations[final2];

                // 바운스 효과와 함께 최종 위치로
                dice1.style.transition = 'transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                dice2.style.transition = 'transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)';

                dice1.style.transform = `rotateX(${rot1.x}deg) rotateY(${rot1.y}deg)`;
                dice2.style.transform = `rotateX(${rot2.x}deg) rotateY(${rot2.y}deg)`;

                // 합계 표시
                setTimeout(() => {
                    const sum = final1 + final2;
                    sumDisplay.textContent = `${final1} + ${final2} = ${sum}`;
                    sumDisplay.classList.add('show');
                    sumDisplay.classList.add(isWin ? 'win' : 'lose');

                    // 트랜지션 초기화
                    setTimeout(() => {
                        dice1.style.transition = 'transform 0.1s ease-out';
                        dice2.style.transition = 'transform 0.1s ease-out';
                    }, 500);

                    resolve();
                }, 300);
            }
        }
        animate();
    });
}

function showResult(result) {
    const resultEl = document.getElementById('diceResult');
    const sum = result.dice1 + result.dice2;

    const now = new Date();
    const datetime = `${String(now.getMonth() + 1).padStart(2, '0')}/${String(now.getDate()).padStart(2, '0')} ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

    if (result.win) {
        resultEl.className = 'dice-result win';
        resultEl.innerHTML = `${result.dice1} + ${result.dice2} = ${sum} 당첨! +${numberFormat(result.winAmount)}P`;
        addToHistory(`주사위 당첨 (${sum})`, result.winAmount - currentBet, datetime);
    } else {
        resultEl.className = 'dice-result lose';
        resultEl.innerHTML = `${result.dice1} + ${result.dice2} = ${sum} 꽝! -${numberFormat(currentBet)}P`;
        addToHistory(`주사위 게임 (${sum})`, -currentBet, datetime);
    }

    resultEl.style.display = 'block';
}

function addToHistory(content, point, datetime) {
    const historyList = document.getElementById('diceHistoryList');
    const noHistory = historyList.querySelector('.dice-no-history');
    if (noHistory) noHistory.remove();

    const isWin = point > 0;
    const pointClass = isWin ? 'point-win' : 'point-lose';
    const pointSign = isWin ? '+' : '';

    const row = document.createElement('div');
    row.className = 'dice-history-row';
    row.innerHTML = `
        <div class="dice-history-info">
            <span class="dice-history-game">${content}</span>
            <span class="dice-history-time">${datetime}</span>
        </div>
        <div class="dice-history-point ${pointClass}">
            ${pointSign}${numberFormat(point)}P
        </div>
    `;

    historyList.insertBefore(row, historyList.firstChild);

    const rows = historyList.querySelectorAll('.dice-history-row');
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
