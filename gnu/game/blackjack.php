<?php
/**
 * 블랙잭 게임 - 프리미엄 버전
 * 라이트/다크 모드 지원 + 모바일 최적화
 */
include_once('./_common.php');

if (!$is_member) {
    alert('로그인 후 이용해주세요.', G5_URL);
    exit;
}

$g5['title'] = '블랙잭';
include_once(G5_PATH.'/head.php');

$member_point = $member['mb_point'];
?>

<style>
/* ========================================
   블랙잭 - 프리미엄 테마 (라이트/다크 지원)
   고급 카드 애니메이션 + 모바일 최적화
   ======================================== */

.blackjack-container {
    max-width: 700px;
    margin: 0 auto;
    padding: 15px;
    padding-bottom: 220px;
    box-sizing: border-box;
    overflow-x: hidden;
}

@media (min-width: 769px) {
    .blackjack-container {
        padding-bottom: 20px;
    }
}

@media (max-width: 768px) {
    .blackjack-container {
        padding: 10px;
        padding-bottom: 200px;
    }
}

/* ========================================
   라이트 모드 기본
   ======================================== */
.blackjack-game {
    background: var(--bg-card, #ffffff);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    border: 1px solid var(--border, #e0e0e0);
    width: 100%;
    box-sizing: border-box;
}

/* ========================================
   다크 모드 - 프리미엄 테마
   ======================================== */
[data-theme="dark"] .blackjack-game,
.dark .blackjack-game {
    background: linear-gradient(180deg, #0d1117 0%, #161b22 100%);
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    border: 1px solid rgba(255,255,255,0.1);
}

/* 헤더 - 라이트 모드 */
.bj-header {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    padding: 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.bj-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0;
    transition: opacity 0.3s;
}

.bj-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #fbbf24, #f59e0b, #fbbf24);
}

/* 헤더 - 다크 모드 프리미엄 */
[data-theme="dark"] .bj-header,
.dark .bj-header {
    background: linear-gradient(135deg, #065f46 0%, #047857 100%);
}

[data-theme="dark"] .bj-header::before,
.dark .bj-header::before {
    opacity: 1;
}

.bj-header-content {
    position: relative;
    z-index: 1;
}

.bj-title {
    font-size: 28px;
    font-weight: 900;
    color: white;
    margin: 0;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    letter-spacing: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.bj-subtitle {
    font-size: 12px;
    color: rgba(255,255,255,0.8);
    margin-top: 5px;
    letter-spacing: 1px;
}

/* 포인트 바 - 라이트 모드 */
.bj-point-bar {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 12px 20px;
    background: var(--bg-main, #f5f5f5);
    border-bottom: 1px solid var(--border, #e0e0e0);
}

/* 포인트 바 - 다크 모드 */
[data-theme="dark"] .bj-point-bar,
.dark .bj-point-bar {
    background: rgba(0,0,0,0.3);
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.bj-point-box {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(0,0,0,0.05);
    padding: 8px 20px;
    border-radius: 30px;
}

[data-theme="dark"] .bj-point-box,
.dark .bj-point-box {
    background: rgba(255,255,255,0.1);
}

.bj-point-icon {
    font-size: 18px;
}

.bj-point-label {
    font-size: 12px;
    color: var(--text-secondary, #666);
    font-weight: 600;
}

[data-theme="dark"] .bj-point-label,
.dark .bj-point-label {
    color: rgba(255,255,255,0.6);
}

.bj-point-value {
    font-size: 22px;
    font-weight: 800;
    color: #10b981;
}

[data-theme="dark"] .bj-point-value,
.dark .bj-point-value {
    color: #fbbf24;
}

.bj-point-unit {
    color: var(--text-secondary, #666);
    font-size: 14px;
}

[data-theme="dark"] .bj-point-unit,
.dark .bj-point-unit {
    color: rgba(255,255,255,0.5);
}

/* 테이블 영역 - 프리미엄 그린 펠트 */
.bj-table-area {
    background: linear-gradient(180deg, #0d5c2e 0%, #0a4423 100%);
    padding: 25px 15px;
    position: relative;
    min-height: 320px;
}

/* 다크 모드 - 더 깊은 그린 */
[data-theme="dark"] .bj-table-area,
.dark .bj-table-area {
    background: linear-gradient(180deg, #1a472a 0%, #0d2818 100%);
}

.bj-table-area::before {
    content: '';
    position: absolute;
    inset: 8px;
    border: 3px solid rgba(255,215,0,0.3);
    border-radius: 80px;
    pointer-events: none;
}

[data-theme="dark"] .bj-table-area::before,
.dark .bj-table-area::before {
    border: 3px solid rgba(212, 175, 55, 0.4);
    border-radius: 100px;
}

/* 게임 대기 오버레이 */
.bj-waiting-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.75);
    border-radius: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 10;
    backdrop-filter: blur(3px);
}

.bj-waiting-overlay.hidden {
    display: none;
}

.bj-waiting-icon {
    font-size: 56px;
    margin-bottom: 15px;
    animation: cardBounce 1.5s ease-in-out infinite;
}

@keyframes cardBounce {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    25% { transform: translateY(-15px) rotate(-5deg); }
    75% { transform: translateY(-15px) rotate(5deg); }
}

.bj-waiting-text {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 10px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}

.bj-waiting-hint {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.7);
}

/* 핸드 래퍼 */
.hands-wrapper {
    display: flex;
    flex-direction: column;
    gap: 20px;
    position: relative;
    z-index: 1;
}

/* 핸드 섹션 */
.hand-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.hand-header {
    display: flex;
    align-items: center;
    gap: 10px;
}

.hand-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.hand-label.dealer {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
}

.hand-label.player {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
}

.hand-score-badge {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(0,0,0,0.5);
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 900;
    border: 2px solid rgba(255,255,255,0.3);
    transition: all 0.3s;
}

.hand-score-badge.bust {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border-color: #ef4444;
    animation: pulse 0.5s ease-in-out;
}

.hand-score-badge.blackjack {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-color: #fbbf24;
    animation: glow 1s ease-in-out infinite alternate;
}

.hand-score-badge.winner {
    background: linear-gradient(135deg, #10b981, #059669);
    border-color: #34d399;
    box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
    transform: scale(1.2);
}

@keyframes glow {
    from { box-shadow: 0 0 10px rgba(245, 158, 11, 0.5); }
    to { box-shadow: 0 0 25px rgba(245, 158, 11, 0.8); }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* 카드 영역 */
.cards-area {
    display: flex;
    justify-content: center;
    gap: 8px;
    min-height: 100px;
    flex-wrap: wrap;
    padding: 10px;
    perspective: 1000px;
}

/* ========================================
   프리미엄 카드 스타일 - 고급 애니메이션
   ======================================== */
.premium-card {
    width: 60px;
    height: 84px;
    position: relative;
    transform-style: preserve-3d;
    animation: cardDealPremium 0.6s ease-out forwards;
    opacity: 0;
    flex-shrink: 0;
}

@keyframes cardDealPremium {
    0% {
        transform: translateY(-100px) rotateY(180deg) scale(0.5);
        opacity: 0;
    }
    50% {
        transform: translateY(10px) rotateY(90deg) scale(1.1);
        opacity: 1;
    }
    100% {
        transform: translateY(0) rotateY(0deg) scale(1);
        opacity: 1;
    }
}

.premium-card:nth-child(1) { animation-delay: 0s; }
.premium-card:nth-child(2) { animation-delay: 0.15s; }
.premium-card:nth-child(3) { animation-delay: 0.3s; }
.premium-card:nth-child(4) { animation-delay: 0.45s; }
.premium-card:nth-child(5) { animation-delay: 0.6s; }

.card-inner {
    width: 100%;
    height: 100%;
    position: relative;
    border-radius: 8px;
    background: linear-gradient(145deg, #ffffff 0%, #f0f0f0 100%);
    box-shadow:
        0 4px 15px rgba(0,0,0,0.3),
        inset 0 1px 0 rgba(255,255,255,0.8),
        inset 0 -1px 0 rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 6px;
    overflow: hidden;
}

.card-inner::before {
    content: '';
    position: absolute;
    inset: 3px;
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 6px;
    pointer-events: none;
}

.premium-card .card-value {
    font-size: 22px;
    font-weight: 900;
    line-height: 1;
}

.premium-card .card-suit {
    font-size: 28px;
    line-height: 1;
    margin-top: 2px;
}

.premium-card.red .card-value,
.premium-card.red .card-suit,
.premium-card.red .card-corner {
    color: #dc2626;
}

.premium-card.black .card-value,
.premium-card.black .card-suit,
.premium-card.black .card-corner {
    color: #1a1a1a;
}

/* 코너 표시 */
.premium-card .card-corner {
    position: absolute;
    font-size: 10px;
    font-weight: 700;
    line-height: 1.1;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.premium-card .card-corner.top-left,
.premium-card .card-corner.top {
    top: 4px;
    left: 5px;
}

.premium-card .card-corner.bottom-right,
.premium-card .card-corner.bottom {
    bottom: 4px;
    right: 5px;
    transform: rotate(180deg);
}

.premium-card .card-corner .corner-suit {
    font-size: 8px;
}

/* 카드 뒷면 - 프리미엄 */
.card-back {
    width: 60px;
    height: 84px;
    border-radius: 8px;
    background: linear-gradient(135deg, #1e3a5f 0%, #0d1f33 100%);
    background-image:
        repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(255,255,255,0.03) 5px, rgba(255,255,255,0.03) 10px),
        repeating-linear-gradient(-45deg, transparent, transparent 5px, rgba(255,255,255,0.03) 5px, rgba(255,255,255,0.03) 10px);
    position: relative;
    box-shadow: 0 4px 15px rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: cardSlide 0.3s ease-out;
    flex-shrink: 0;
}

@keyframes cardSlide {
    from {
        transform: translateX(100px) rotate(20deg);
        opacity: 0;
    }
    to {
        transform: translateX(0) rotate(0);
        opacity: 1;
    }
}

.card-back::after {
    content: '';
    width: 40px;
    height: 56px;
    border: 2px solid rgba(212, 175, 55, 0.5);
    border-radius: 4px;
    background: repeating-linear-gradient(
        45deg,
        rgba(212, 175, 55, 0.1),
        rgba(212, 175, 55, 0.1) 2px,
        transparent 2px,
        transparent 6px
    );
}

/* VS 구분선 */
.vs-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px 0;
}

.vs-badge {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 900;
    color: white;
    box-shadow: 0 4px 20px rgba(245, 158, 11, 0.5);
    border: 3px solid rgba(255,255,255,0.3);
}

/* ========================================
   데스크톱 베팅/액션 섹션
   ======================================== */
@media (max-width: 768px) {
    .desktop-betting-section,
    .desktop-action-buttons {
        display: none !important;
    }
}

/* 데스크톱 베팅 섹션 - 라이트 모드 */
.desktop-betting-section {
    padding: 20px;
    background: var(--bg-main, #f5f5f5);
    border-top: 1px solid var(--border, #e0e0e0);
}

/* 데스크톱 베팅 섹션 - 다크 모드 */
[data-theme="dark"] .desktop-betting-section,
.dark .desktop-betting-section {
    background: rgba(0,0,0,0.3);
    border-top: 1px solid rgba(255,255,255,0.05);
}

.bet-label {
    font-size: 13px;
    color: var(--text-secondary, #666);
    margin-bottom: 12px;
    font-weight: 600;
    text-align: center;
}

[data-theme="dark"] .bet-label,
.dark .bet-label {
    color: rgba(255,255,255,0.6);
}

.bet-chips-row {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

/* 프리미엄 칩 스타일 */
.bet-chip {
    flex-shrink: 0;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border: 3px solid;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
    background: var(--bg-card, #fff);
}

[data-theme="dark"] .bet-chip,
.dark .bet-chip {
    background: linear-gradient(180deg, #2a2a3e 0%, #1a1a2e 100%);
}

.bet-chip::before {
    content: '';
    position: absolute;
    inset: 4px;
    border-radius: 50%;
    border: 2px dashed;
    opacity: 0.5;
}

.bet-chip .chip-value {
    font-size: 13px;
    font-weight: 800;
    color: var(--text-primary, #333);
}

[data-theme="dark"] .bet-chip .chip-value,
.dark .bet-chip .chip-value {
    color: white;
}

.bet-chip.chip-10 { border-color: #64748b; color: #64748b; }
.bet-chip.chip-10::before { border-color: #64748b; }
.bet-chip.chip-50 { border-color: #3b82f6; color: #3b82f6; }
.bet-chip.chip-50::before { border-color: #3b82f6; }
.bet-chip.chip-100 { border-color: #10b981; color: #10b981; }
.bet-chip.chip-100::before { border-color: #10b981; }
.bet-chip.chip-500 { border-color: #8b5cf6; color: #8b5cf6; }
.bet-chip.chip-500::before { border-color: #8b5cf6; }
.bet-chip.chip-1000 { border-color: #f59e0b; color: #f59e0b; }
.bet-chip.chip-1000::before { border-color: #f59e0b; }

.bet-chip.active {
    transform: scale(1.15);
    box-shadow: 0 0 20px currentColor;
}

.bet-chip.chip-10.active { background: #64748b; }
.bet-chip.chip-50.active { background: #3b82f6; }
.bet-chip.chip-100.active { background: #10b981; }
.bet-chip.chip-500.active { background: #8b5cf6; }
.bet-chip.chip-1000.active { background: #f59e0b; }

.bet-chip.active .chip-value { color: white; }

.current-bet-display {
    text-align: center;
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary, #333);
}

[data-theme="dark"] .current-bet-display,
.dark .current-bet-display {
    color: white;
}

/* 데스크톱 액션 버튼 */
.desktop-action-buttons {
    padding: 20px;
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    background: var(--bg-main, #f5f5f5);
}

[data-theme="dark"] .desktop-action-buttons,
.dark .desktop-action-buttons {
    background: rgba(0,0,0,0.2);
}

.action-btn {
    padding: 14px 28px;
    font-size: 15px;
    font-weight: 700;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.action-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-deal {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    min-width: 200px;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.btn-hit {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

.btn-stand {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
}

.btn-double {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
}

.action-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(0,0,0,0.3);
}

/* ========================================
   결과 모달 오버레이 - 바카라 스타일
   ======================================== */
.bj-result-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}

.bj-result-overlay.show {
    opacity: 1;
    visibility: visible;
}

.bj-result-modal {
    background: linear-gradient(180deg, #1a1a2e 0%, #0f0f1a 100%);
    border-radius: 24px;
    padding: 30px;
    text-align: center;
    max-width: 320px;
    width: 90%;
    transform: scale(0.9);
    transition: transform 0.3s;
    border: 1px solid rgba(255,255,255,0.1);
}

.bj-result-overlay.show .bj-result-modal {
    transform: scale(1);
}

.bj-result-icon {
    font-size: 60px;
    margin-bottom: 16px;
    animation: resultBounce 0.5s ease;
}

@keyframes resultBounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

.bj-result-title {
    font-size: 28px;
    font-weight: 900;
    margin-bottom: 8px;
}

.bj-result-title.win {
    color: #10b981;
}

.bj-result-title.lose {
    color: #ef4444;
}

.bj-result-title.push {
    color: #6b7280;
}

.bj-result-title.blackjack {
    color: #f59e0b;
}

.bj-result-amount {
    font-size: 24px;
    font-weight: 700;
    color: white;
    margin-bottom: 20px;
}

.bj-result-amount.win {
    color: #10b981;
}

.bj-result-amount.lose {
    color: #ef4444;
}

.bj-result-details {
    background: rgba(0,0,0,0.3);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 20px;
}

.bj-result-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 14px;
}

.bj-result-row-label {
    color: rgba(255,255,255,0.5);
}

.bj-result-row-value {
    color: white;
    font-weight: 600;
}

.bj-result-close-btn {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.bj-result-close-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
}

/* ========================================
   정보 섹션
   ======================================== */
.bj-info-section {
    padding: 20px;
    background: var(--bg-main, #f5f5f5);
}

[data-theme="dark"] .bj-info-section,
.dark .bj-info-section {
    background: transparent;
}

/* 규칙 */
.bj-rules {
    background: var(--bg-card, #fff);
    border-radius: 12px;
    padding: 16px;
    border: 1px solid var(--border, #e0e0e0);
    margin-bottom: 16px;
}

[data-theme="dark"] .bj-rules,
.dark .bj-rules {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.05);
}

.bj-rules h3 {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary, #333);
    margin: 0 0 12px 0;
}

[data-theme="dark"] .bj-rules h3,
.dark .bj-rules h3 {
    color: rgba(255,255,255,0.7);
}

.bj-rules ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}

@media (max-width: 480px) {
    .bj-rules ul {
        grid-template-columns: 1fr;
    }
}

.bj-rules li {
    font-size: 12px;
    color: var(--text-secondary, #666);
    display: flex;
    align-items: center;
    gap: 6px;
}

[data-theme="dark"] .bj-rules li,
.dark .bj-rules li {
    color: rgba(255,255,255,0.5);
}

.bj-rules li::before {
    content: "•";
    color: #10b981;
    font-weight: bold;
}

/* 배팅 내역 */
.bj-history {
    background: var(--bg-card, #fff);
    border-radius: 12px;
    padding: 16px;
    border: 1px solid var(--border, #e0e0e0);
    margin-bottom: 16px;
}

[data-theme="dark"] .bj-history,
.dark .bj-history {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.05);
}

.bj-history h3 {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary, #333);
    margin: 0 0 12px 0;
}

[data-theme="dark"] .bj-history h3,
.dark .bj-history h3 {
    color: rgba(255,255,255,0.7);
}

.bj-history-list {
    max-height: 200px;
    overflow-y: auto;
}

.bj-history-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .bj-history-row,
.dark .bj-history-row {
    border-bottom-color: rgba(255,255,255,0.05);
}

.bj-history-row:last-child {
    border-bottom: none;
}

.bj-history-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.bj-history-game {
    font-size: 12px;
    font-weight: 500;
    color: var(--text-primary, #333);
}

[data-theme="dark"] .bj-history-game,
.dark .bj-history-game {
    color: rgba(255,255,255,0.8);
}

.bj-history-time {
    font-size: 10px;
    color: var(--text-muted, #999);
}

[data-theme="dark"] .bj-history-time,
.dark .bj-history-time {
    color: rgba(255,255,255,0.4);
}

.bj-history-point {
    font-size: 13px;
    font-weight: 700;
}

.bj-history-point.point-win { color: #10b981; }
.bj-history-point.point-lose { color: #ef4444; }

.bj-no-history {
    text-align: center;
    color: var(--text-muted, #999);
    padding: 20px 0;
    font-size: 12px;
}

[data-theme="dark"] .bj-no-history,
.dark .bj-no-history {
    color: rgba(255,255,255,0.4);
}

/* ========================================
   검증 섹션 - 프리미엄 스타일
   ======================================== */
.bj-verify {
    background: var(--bg-card, #fff);
    border-radius: 12px;
    padding: 16px;
    border: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .bj-verify,
.dark .bj-verify {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.05);
}

.bj-verify-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.bj-verify h3 {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-primary, #333);
    margin: 0;
}

[data-theme="dark"] .bj-verify h3,
.dark .bj-verify h3 {
    color: rgba(255,255,255,0.7);
}

.bj-verify-pill {
    font-size: 11px;
    font-weight: 800;
    padding: 6px 10px;
    border-radius: 999px;
    border: 1px solid var(--border, #e0e0e0);
    background: var(--bg-main, #f5f5f5);
    color: var(--text-secondary, #666);
    white-space: nowrap;
}

[data-theme="dark"] .bj-verify-pill,
.dark .bj-verify-pill {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.8);
}

.bj-verify-pill.ok { color: #10b981; border-color: rgba(16,185,129,0.35); }
.bj-verify-pill.bad { color: #ef4444; border-color: rgba(239,68,68,0.35); }
.bj-verify-pill.warn { color: #f59e0b; border-color: rgba(245,158,11,0.35); }

.bj-verify p {
    margin: 0 0 10px 0;
    font-size: 11px;
    line-height: 1.5;
    color: var(--text-secondary, #666);
}

[data-theme="dark"] .bj-verify p,
.dark .bj-verify p {
    color: rgba(255,255,255,0.55);
}

.bj-pf-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 8px;
}

@media (min-width: 480px) {
    .bj-pf-grid { grid-template-columns: 1fr 1fr; }
}

.bj-pf-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 10px 12px;
    border-radius: 10px;
    background: var(--bg-main, #f5f5f5);
    border: 1px solid var(--border, #e0e0e0);
}

[data-theme="dark"] .bj-pf-item,
.dark .bj-pf-item {
    background: rgba(0,0,0,0.22);
    border-color: rgba(255,255,255,0.06);
}

.bj-pf-label {
    font-size: 10px;
    color: var(--text-muted, #999);
    font-weight: 700;
}

[data-theme="dark"] .bj-pf-label,
.dark .bj-pf-label {
    color: rgba(255,255,255,0.55);
}

.bj-pf-code {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: 10px;
    color: var(--text-primary, #333);
    word-break: break-all;
    line-height: 1.35;
}

[data-theme="dark"] .bj-pf-code,
.dark .bj-pf-code {
    color: rgba(255,255,255,0.9);
}

.bj-verify-actions {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.bj-verify-btn {
    flex: 1;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid var(--border, #e0e0e0);
    background: var(--bg-card, #fff);
    color: var(--text-primary, #333);
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}

[data-theme="dark"] .bj-verify-btn,
.dark .bj-verify-btn {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.85);
}

.bj-verify-btn:hover {
    transform: translateY(-1px);
    border-color: #10b981;
}

.bj-pf-panel {
    margin-top: 12px;
    padding: 12px;
    border-radius: 10px;
    background: var(--bg-main, #f5f5f5);
    border: 1px solid var(--border, #e0e0e0);
    display: none;
}

[data-theme="dark"] .bj-pf-panel,
.dark .bj-pf-panel {
    background: rgba(0,0,0,0.25);
    border-color: rgba(255,255,255,0.06);
}

.bj-pf-panel.show { display: block; }

.bj-pf-status {
    font-size: 12px;
    font-weight: 800;
    margin-bottom: 8px;
}

.bj-pf-status.ok { color: #10b981; }
.bj-pf-status.bad { color: #ef4444; }
.bj-pf-status.warn { color: #f59e0b; }

.bj-pf-json {
    margin: 0;
    padding: 10px;
    border-radius: 8px;
    background: var(--bg-card, #fff);
    border: 1px solid var(--border, #e0e0e0);
    color: var(--text-primary, #333);
    font-size: 11px;
    line-height: 1.4;
    max-height: 220px;
    overflow: auto;
    white-space: pre-wrap;
    word-break: break-word;
}

[data-theme="dark"] .bj-pf-json,
.dark .bj-pf-json {
    background: rgba(0,0,0,0.35);
    border-color: rgba(255,255,255,0.05);
    color: rgba(255,255,255,0.85);
}

/* ========================================
   모바일 하단 고정 베팅 - 프리미엄 다크
   ======================================== */
.mobile-betting {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(180deg, #1a1a2e 0%, #0f0f1a 100%);
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 12px;
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

/* 모바일 칩 행 */
.mobile-chips-row {
    display: flex;
    gap: 6px;
    margin-bottom: 12px;
    overflow-x: auto;
    padding: 2px 0;
    -webkit-overflow-scrolling: touch;
}

.mobile-chips-row::-webkit-scrollbar {
    display: none;
}

/* 모바일 프리미엄 칩 */
.mobile-chip {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 3px solid;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    background: linear-gradient(180deg, #2a2a3e 0%, #1a1a2e 100%);
    position: relative;
}

.mobile-chip::before {
    content: '';
    position: absolute;
    inset: 3px;
    border-radius: 50%;
    border: 2px dashed;
    opacity: 0.5;
}

.mobile-chip .chip-value {
    font-size: 11px;
    font-weight: 800;
    color: white;
}

.mobile-chip.chip-10 { border-color: #64748b; }
.mobile-chip.chip-10::before { border-color: #64748b; }
.mobile-chip.chip-50 { border-color: #3b82f6; }
.mobile-chip.chip-50::before { border-color: #3b82f6; }
.mobile-chip.chip-100 { border-color: #10b981; }
.mobile-chip.chip-100::before { border-color: #10b981; }
.mobile-chip.chip-500 { border-color: #8b5cf6; }
.mobile-chip.chip-500::before { border-color: #8b5cf6; }
.mobile-chip.chip-1000 { border-color: #f59e0b; }
.mobile-chip.chip-1000::before { border-color: #f59e0b; }

.mobile-chip.active {
    transform: scale(1.1);
    box-shadow: 0 0 15px currentColor;
}

.mobile-chip.chip-10.active { background: #64748b; }
.mobile-chip.chip-50.active { background: #3b82f6; }
.mobile-chip.chip-100.active { background: #10b981; }
.mobile-chip.chip-500.active { background: #8b5cf6; }
.mobile-chip.chip-1000.active { background: #f59e0b; }

/* 모바일 액션 버튼 행 */
.mobile-action-row {
    display: flex;
    gap: 8px;
}

.mobile-action-btn {
    flex: 1;
    padding: 14px 10px;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
}

.mobile-action-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.mobile-action-btn.btn-deal {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.mobile-action-btn.btn-hit {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

.mobile-action-btn.btn-stand {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
}

.mobile-action-btn.btn-double {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
}

.mobile-action-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

/* ========================================
   반응형 - 모바일 최적화
   ======================================== */
@media (max-width: 480px) {
    .premium-card {
        width: 46px;
        height: 64px;
    }

    .card-inner {
        padding: 4px;
    }

    .premium-card .card-value {
        font-size: 16px;
    }

    .premium-card .card-suit {
        font-size: 20px;
    }

    .premium-card .card-corner {
        font-size: 8px;
    }

    .premium-card .card-corner .corner-suit {
        font-size: 6px;
    }

    .card-back {
        width: 46px;
        height: 64px;
    }

    .card-back::after {
        width: 30px;
        height: 44px;
    }

    .vs-badge {
        width: 36px;
        height: 36px;
        font-size: 12px;
    }

    .hand-score-badge {
        width: 28px;
        height: 28px;
        font-size: 14px;
    }

    .hand-label {
        font-size: 12px;
        padding: 4px 12px;
    }

    .bj-header {
        padding: 15px;
    }

    .bj-title {
        font-size: 22px;
    }

    .bj-subtitle {
        font-size: 11px;
    }

    .bj-point-bar {
        padding: 10px 15px;
    }

    .bj-point-value {
        font-size: 18px;
    }

    .cards-area {
        min-height: 90px;
        gap: 5px;
    }

    .bj-table-area {
        padding: 15px 10px;
        min-height: 280px;
    }

    .bj-table-area::before {
        inset: 5px;
        border-width: 2px;
        border-radius: 50px;
    }

    .bj-info-section {
        padding: 15px;
    }

    .mobile-chip {
        width: 40px;
        height: 40px;
    }

    .mobile-chip .chip-value {
        font-size: 10px;
    }

    .mobile-action-btn {
        padding: 12px 8px;
        font-size: 12px;
    }

    .bet-chip {
        width: 42px;
        height: 42px;
    }

    .bet-chip .chip-value {
        font-size: 10px;
    }
}

/* 모바일 가로 스크롤 방지 */
@media (max-width: 768px) {
    .bj-table-area::before {
        border-radius: 60px;
    }

    .hand-section {
        width: 100%;
        max-width: none;
        min-width: 0;
    }

    .hands-wrapper {
        justify-items: stretch;
    }

    .cards-area {
        width: 100%;
        box-sizing: border-box;
    }
}
</style>

<div class="blackjack-container">
    <div class="blackjack-game">
        <!-- 헤더 -->
        <div class="bj-header">
            <div class="bj-header-content">
                <h1 class="bj-title">BLACKJACK</h1>
                <p class="bj-subtitle">21에 가깝게 만들어 딜러를 이기세요</p>
            </div>
        </div>

        <!-- 포인트 바 -->
        <div class="bj-point-bar">
            <div class="bj-point-box">
                <span class="bj-point-icon">💰</span>
                <span class="bj-point-value" id="userPoint"><?php echo number_format($member_point); ?></span>
                <span class="bj-point-unit">P</span>
            </div>
        </div>

        <!-- 테이블 영역 -->
        <div class="bj-table-area">
            <!-- 게임 대기 오버레이 -->
            <div class="bj-waiting-overlay" id="bjWaitingOverlay">
                <div class="bj-waiting-icon">🃏</div>
                <div class="bj-waiting-text">게임 대기중</div>
                <div class="bj-waiting-hint">DEAL 버튼을 눌러 게임을 시작하세요</div>
            </div>

            <div class="hands-wrapper">
                <!-- 딜러 -->
                <div class="hand-section">
                    <div class="hand-header">
                        <span class="hand-label dealer">DEALER</span>
                        <span class="hand-score-badge" id="dealerScore">?</span>
                    </div>
                    <div class="cards-area" id="dealerCards"></div>
                </div>

                <!-- VS -->
                <div class="vs-divider">
                    <div class="vs-badge">VS</div>
                </div>

                <!-- 플레이어 -->
                <div class="hand-section">
                    <div class="hand-header">
                        <span class="hand-label player">PLAYER</span>
                        <span class="hand-score-badge" id="playerScore">?</span>
                    </div>
                    <div class="cards-area" id="playerCards"></div>
                </div>
            </div>
        </div>

        <!-- 데스크톱 베팅 섹션 -->
        <div class="desktop-betting-section" id="bettingSection">
            <div class="bet-label">베팅 금액 선택</div>
            <div class="bet-chips-row">
                <div class="bet-chip chip-10" data-bet="10"><span class="chip-value">10</span></div>
                <div class="bet-chip chip-50" data-bet="50"><span class="chip-value">50</span></div>
                <div class="bet-chip chip-100 active" data-bet="100"><span class="chip-value">100</span></div>
                <div class="bet-chip chip-500" data-bet="500"><span class="chip-value">500</span></div>
                <div class="bet-chip chip-1000" data-bet="1000"><span class="chip-value">1K</span></div>
            </div>
            <div class="current-bet-display">베팅: <span id="currentBet">100</span>P</div>
        </div>

        <!-- 데스크톱 액션 버튼 -->
        <div class="desktop-action-buttons" id="actionButtons">
            <button class="action-btn btn-deal" id="dealBtn" onclick="deal()">🃏 DEAL</button>
            <button class="action-btn btn-hit" id="hitBtn" onclick="hit()" style="display:none">HIT</button>
            <button class="action-btn btn-stand" id="standBtn" onclick="stand()" style="display:none">STAND</button>
            <button class="action-btn btn-double" id="doubleBtn" onclick="doubleDown()" style="display:none">DOUBLE</button>
        </div>

        <!-- 정보 섹션 -->
        <div class="bj-info-section">
            <!-- 규칙 -->
            <div class="bj-rules">
                <h3>🎮 게임 규칙</h3>
                <ul>
                    <li>21에 가장 가까운 쪽이 승리</li>
                    <li>21 초과 시 버스트 (패배)</li>
                    <li>A는 1 또는 11로 계산</li>
                    <li>J, Q, K는 10으로 계산</li>
                    <li>블랙잭 승리 시 x2.5 지급</li>
                    <li>일반 승리 시 x2 지급</li>
                </ul>
            </div>

            <!-- 배팅 내역 -->
            <div class="bj-history">
                <h3>📋 내 배팅 내역</h3>
                <div class="bj-history-list" id="bjHistoryList">
                    <?php
                    $sql = "SELECT po_content, po_point, po_datetime
                            FROM {$g5['point_table']}
                            WHERE mb_id = '{$member['mb_id']}'
                            AND po_content LIKE '%블랙잭%'
                            ORDER BY po_id DESC
                            LIMIT 10";
                    $result = sql_query($sql);

                    if (sql_num_rows($result) > 0) {
                        while ($row = sql_fetch_array($result)) {
                            $isWin = $row['po_point'] > 0;
                            $pointClass = $isWin ? 'point-win' : 'point-lose';
                            $pointSign = $isWin ? '+' : '';
                            ?>
                            <div class="bj-history-row">
                                <div class="bj-history-info">
                                    <span class="bj-history-game"><?php echo $row['po_content']; ?></span>
                                    <span class="bj-history-time"><?php echo date('m/d H:i', strtotime($row['po_datetime'])); ?></span>
                                </div>
                                <div class="bj-history-point <?php echo $pointClass; ?>">
                                    <?php echo $pointSign . number_format($row['po_point']); ?>P
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="bj-no-history">아직 배팅 내역이 없습니다.</div>';
                    }
                    ?>
                </div>
            </div>

            <!-- 검증 -->
            <div class="bj-verify">
                <div class="bj-verify-top">
                    <h3>🔐 조작/검증</h3>
                    <span class="bj-verify-pill warn" id="bjPfPill">대기중</span>
                </div>
                <p>DEAL 전 서버가 해시(커밋)를 공개하고, 게임 후 실제 시드를 공개합니다.</p>
                <div class="bj-pf-grid">
                    <div class="bj-pf-item">
                        <div class="bj-pf-label">서버 해시</div>
                        <div class="bj-pf-code" id="bjPfServerHash">-</div>
                        <div class="bj-pf-label" style="margin-top:6px;">Nonce</div>
                        <div class="bj-pf-code" id="bjPfNonce">-</div>
                    </div>
                    <div class="bj-pf-item">
                        <div class="bj-pf-label">클라이언트 시드</div>
                        <div class="bj-pf-code" id="bjPfClientSeed">-</div>
                        <div class="bj-verify-actions">
                            <button type="button" class="bj-verify-btn" onclick="toggleBjVerify()">검증</button>
                            <button type="button" class="bj-verify-btn" onclick="refreshBjCommit()">새로고침</button>
                        </div>
                    </div>
                </div>
                <div class="bj-pf-panel" id="bjPfPanel">
                    <div class="bj-pf-status warn" id="bjPfStatus">게임 진행 후 검증 가능</div>
                    <pre class="bj-pf-json" id="bjPfJson">{}</pre>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 결과 모달 오버레이 (바카라 스타일) -->
<div class="bj-result-overlay" id="bjResultOverlay">
    <div class="bj-result-modal">
        <div class="bj-result-icon" id="resultIcon">🎉</div>
        <div class="bj-result-title" id="resultTitle">WIN!</div>
        <div class="bj-result-amount" id="resultAmount">+1,000P</div>
        <div class="bj-result-details">
            <div class="bj-result-row">
                <span class="bj-result-row-label">결과</span>
                <span class="bj-result-row-value" id="resultType">승리</span>
            </div>
            <div class="bj-result-row">
                <span class="bj-result-row-label">플레이어</span>
                <span class="bj-result-row-value" id="resultPlayerScore">21</span>
            </div>
            <div class="bj-result-row">
                <span class="bj-result-row-label">딜러</span>
                <span class="bj-result-row-value" id="resultDealerScore">18</span>
            </div>
            <div class="bj-result-row">
                <span class="bj-result-row-label">베팅액</span>
                <span class="bj-result-row-value" id="resultBetAmount">100P</span>
            </div>
        </div>
        <button class="bj-result-close-btn" onclick="closeResult()">확인</button>
    </div>
</div>

<!-- 모바일 하단 고정 베팅 -->
<div class="mobile-betting">
    <div class="mobile-chips-row">
        <div class="mobile-chip chip-10" data-bet="10"><span class="chip-value">10</span></div>
        <div class="mobile-chip chip-50" data-bet="50"><span class="chip-value">50</span></div>
        <div class="mobile-chip chip-100 active" data-bet="100"><span class="chip-value">100</span></div>
        <div class="mobile-chip chip-500" data-bet="500"><span class="chip-value">500</span></div>
        <div class="mobile-chip chip-1000" data-bet="1000"><span class="chip-value">1K</span></div>
    </div>
    <div class="mobile-action-row" id="mobileActionRow">
        <button class="mobile-action-btn btn-deal" id="mobileDealBtn" onclick="deal()">🃏 DEAL</button>
        <button class="mobile-action-btn btn-hit" id="mobileHitBtn" onclick="hit()" style="display:none">HIT</button>
        <button class="mobile-action-btn btn-stand" id="mobileStandBtn" onclick="stand()" style="display:none">STAND</button>
        <button class="mobile-action-btn btn-double" id="mobileDoubleBtn" onclick="doubleDown()" style="display:none">2X</button>
    </div>
</div>

<script>
let currentBet = 100;
let userPoint = <?php echo $member_point; ?>;
let gameState = 'betting';
let playerCards = [];
let dealerCards = [];
let isDoubled = false;
let bjCommit = null;
let lastBlackjackResult = null;
const BJ_PF_STORAGE_KEY = 'blackjack_pf_client_seed_v1';

function getOrCreateBjClientSeed() {
    try {
        const existing = localStorage.getItem(BJ_PF_STORAGE_KEY);
        if (existing && existing.length >= 8) return existing;
        const seed = (crypto && crypto.randomUUID) ? crypto.randomUUID() : ('seed_' + Math.random().toString(16).slice(2) + Date.now());
        localStorage.setItem(BJ_PF_STORAGE_KEY, seed);
        return seed;
    } catch (e) {
        return 'seed_' + Math.random().toString(16).slice(2) + Date.now();
    }
}

async function refreshBjCommit() {
    const clientSeed = getOrCreateBjClientSeed();
    document.getElementById('bjPfClientSeed').textContent = clientSeed;

    try {
        const res = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=blackjack_commit'
        });
        const data = await res.json();
        if (!data.success || !data.provablyFair) throw new Error(data.message || 'commit failed');
        bjCommit = { serverSeedHash: data.provablyFair.serverSeedHash, nonce: data.provablyFair.nonce };
        document.getElementById('bjPfServerHash').textContent = bjCommit.serverSeedHash;
        document.getElementById('bjPfNonce').textContent = String(bjCommit.nonce);
        document.getElementById('bjPfPill').className = 'bj-verify-pill warn';
        document.getElementById('bjPfPill').textContent = '준비됨';
    } catch (e) {
        console.error(e);
        document.getElementById('bjPfPill').className = 'bj-verify-pill bad';
        document.getElementById('bjPfPill').textContent = '실패';
        bjCommit = null;
    }
}

// 베팅 칩 클릭 (데스크톱 + 모바일 동기화)
document.querySelectorAll('.bet-chip, .mobile-chip').forEach(chip => {
    chip.addEventListener('click', function() {
        if (gameState !== 'betting') return;
        const bet = parseInt(this.dataset.bet);
        document.querySelectorAll('.bet-chip, .mobile-chip').forEach(c => c.classList.remove('active'));
        document.querySelectorAll(`[data-bet="${bet}"]`).forEach(c => c.classList.add('active'));
        currentBet = bet;
        document.getElementById('currentBet').textContent = currentBet;
    });
});

// 프리미엄 카드 렌더링 (바카라 스타일)
function renderCard(card, hidden = false, delay = 0) {
    if (hidden) {
        return '<div class="card-back"></div>';
    }
    const isRed = card.suit === '♥' || card.suit === '♦';
    const colorClass = isRed ? 'red' : 'black';
    const delayStyle = delay > 0 ? ` style="animation-delay: ${delay}s"` : '';

    return `<div class="premium-card ${colorClass}"${delayStyle}>
        <div class="card-inner">
            <div class="card-corner top">
                <span>${card.value}</span>
                <span class="corner-suit">${card.suit}</span>
            </div>
            <div class="card-value">${card.value}</div>
            <div class="card-suit">${card.suit}</div>
            <div class="card-corner bottom">
                <span>${card.value}</span>
                <span class="corner-suit">${card.suit}</span>
            </div>
        </div>
    </div>`;
}

function calculateScore(cards) {
    let score = 0;
    let aces = 0;
    cards.forEach(card => {
        if (card.value === 'A') {
            aces++;
            score += 11;
        } else if (['J', 'Q', 'K'].includes(card.value)) {
            score += 10;
        } else {
            score += parseInt(card.value);
        }
    });
    while (score > 21 && aces > 0) {
        score -= 10;
        aces--;
    }
    return score;
}

function updateDisplay(showDealerHidden = false, animate = false) {
    const playerCardsEl = document.getElementById('playerCards');
    const dealerCardsEl = document.getElementById('dealerCards');
    const playerScoreEl = document.getElementById('playerScore');
    const dealerScoreEl = document.getElementById('dealerScore');

    // 프리미엄 애니메이션으로 카드 렌더링
    if (animate) {
        playerCardsEl.innerHTML = playerCards.map((c, i) => renderCard(c, false, i * 0.15)).join('');
    } else {
        playerCardsEl.innerHTML = playerCards.map(c => renderCard(c)).join('');
    }

    if (showDealerHidden && dealerCards.length > 0) {
        if (animate) {
            dealerCardsEl.innerHTML = renderCard(dealerCards[0], false, 0.1) + renderCard(null, true);
        } else {
            dealerCardsEl.innerHTML = renderCard(dealerCards[0]) + renderCard(null, true);
        }
        dealerScoreEl.textContent = '?';
        dealerScoreEl.className = 'hand-score-badge';
    } else {
        if (animate) {
            dealerCardsEl.innerHTML = dealerCards.map((c, i) => renderCard(c, false, i * 0.15)).join('');
        } else {
            dealerCardsEl.innerHTML = dealerCards.map(c => renderCard(c)).join('');
        }
        const dealerScore = calculateScore(dealerCards);
        dealerScoreEl.textContent = dealerScore;
        dealerScoreEl.className = 'hand-score-badge';
        if (dealerScore > 21) dealerScoreEl.classList.add('bust');
    }

    const playerScore = calculateScore(playerCards);
    playerScoreEl.textContent = playerScore;
    playerScoreEl.className = 'hand-score-badge';
    if (playerScore > 21) playerScoreEl.classList.add('bust');
    else if (playerScore === 21 && playerCards.length === 2) playerScoreEl.classList.add('blackjack');
}

function showActionButtons(showHitStand) {
    const show = showHitStand ? 'inline-block' : 'none';
    const showDeal = showHitStand ? 'none' : 'inline-block';

    // 데스크톱
    document.getElementById('dealBtn').style.display = showDeal;
    document.getElementById('hitBtn').style.display = show;
    document.getElementById('standBtn').style.display = show;
    document.getElementById('doubleBtn').style.display = showHitStand && userPoint >= currentBet * 2 ? show : 'none';

    // 모바일
    document.getElementById('mobileDealBtn').style.display = showDeal;
    document.getElementById('mobileHitBtn').style.display = show;
    document.getElementById('mobileStandBtn').style.display = show;
    document.getElementById('mobileDoubleBtn').style.display = showHitStand && userPoint >= currentBet * 2 ? show : 'none';
}

async function deal() {
    if (userPoint < currentBet) {
        alert('포인트가 부족합니다.');
        return;
    }

    gameState = 'playing';
    isDoubled = false;
    playerCards = [];
    dealerCards = [];

    document.getElementById('bjWaitingOverlay').classList.add('hidden');
    document.getElementById('bjResultOverlay').classList.remove('show');
    document.getElementById('bettingSection').style.display = 'none';

    try {
        if (!bjCommit) await refreshBjCommit();
        if (!bjCommit) {
            alert('검증 정보를 불러오지 못했습니다. 새로고침 후 다시 시도해 주세요.');
            resetGame();
            return;
        }

        const clientSeed = getOrCreateBjClientSeed();
        const response = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=blackjack_deal&bet=${currentBet}&clientSeed=${encodeURIComponent(clientSeed)}&serverSeedHash=${encodeURIComponent(bjCommit.serverSeedHash)}&nonce=${encodeURIComponent(bjCommit.nonce)}`
        });

        const result = await response.json();
        if (!result.success) {
            alert(result.message);
            resetGame();
            return;
        }

        if (result.status === 'finished') {
            playerCards = result.playerHand || [];
            dealerCards = result.dealerHand || [];
            updateDisplay(false, true); // 프리미엄 애니메이션 적용
            userPoint = result.newPoint;
            document.getElementById('userPoint').textContent = numberFormat(userPoint);
            lastBlackjackResult = result;
            // 딜레이 후 결과 표시 (카드 애니메이션 완료 대기)
            setTimeout(() => showResult(result), 800);
            updateNextCommit(result);
            return;
        }

        playerCards = result.playerHand || [];
        dealerCards = (result.dealerHand && result.dealerHand[0] && result.dealerHand[0].value !== '?') ? [result.dealerHand[0]] : [];
        lastBlackjackResult = null;
        updateDisplay(true, true); // 애니메이션 적용

        const playerScore = calculateScore(playerCards);
        if (playerScore === 21) {
            await stand();
            return;
        }

        showActionButtons(true);

    } catch (e) {
        console.error(e);
        alert('오류가 발생했습니다.');
        resetGame();
    }
}

async function hit() {
    try {
        const response = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=blackjack_hit'
        });

        const result = await response.json();
        if (!result.success) {
            alert(result.message);
            return;
        }

        if (result.status === 'finished') {
            playerCards = result.playerHand || playerCards;
            dealerCards = result.dealerHand || dealerCards;
            updateDisplay(false);
            userPoint = result.newPoint;
            document.getElementById('userPoint').textContent = numberFormat(userPoint);
            lastBlackjackResult = result;
            showResult(result);
            updateNextCommit(result);
            return;
        }

        playerCards = result.playerHand || playerCards;
        if (result.dealerHand && result.dealerHand[0] && result.dealerHand[0].value !== '?') {
            dealerCards = [result.dealerHand[0]];
        }
        updateDisplay(true);

        // 더블다운 숨김
        document.getElementById('doubleBtn').style.display = 'none';
        document.getElementById('mobileDoubleBtn').style.display = 'none';

        const playerScore = calculateScore(playerCards);
        if (playerScore >= 21) {
            await stand();
        }
    } catch (e) {
        console.error(e);
    }
}

async function stand() {
    showActionButtons(false);
    document.getElementById('dealBtn').style.display = 'none';
    document.getElementById('mobileDealBtn').style.display = 'none';

    try {
        const response = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=blackjack_stand'
        });

        const result = await response.json();
        if (!result.success) {
            alert(result.message);
            resetGame();
            return;
        }

        dealerCards = result.dealerHand || dealerCards;
        updateDisplay(false);

        userPoint = result.newPoint;
        document.getElementById('userPoint').textContent = numberFormat(userPoint);
        lastBlackjackResult = result;
        showResult(result);
        updateNextCommit(result);

    } catch (e) {
        console.error(e);
        resetGame();
    }
}

async function doubleDown() {
    if (userPoint < currentBet * 2) {
        alert('포인트가 부족합니다.');
        return;
    }

    isDoubled = true;

    try {
        const response = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=blackjack_double'
        });

        const result = await response.json();
        if (!result.success) {
            alert(result.message);
            return;
        }

        playerCards = result.playerHand || playerCards;
        dealerCards = result.dealerHand || dealerCards;
        updateDisplay(false);

        userPoint = result.newPoint;
        document.getElementById('userPoint').textContent = numberFormat(userPoint);
        lastBlackjackResult = result;
        showResult(result);
        updateNextCommit(result);

    } catch (e) {
        console.error(e);
    }
}

function updateNextCommit(result) {
    if (result.provablyFair && result.provablyFair.nextServerSeedHash != null) {
        bjCommit = { serverSeedHash: result.provablyFair.nextServerSeedHash, nonce: result.provablyFair.nextNonce };
        document.getElementById('bjPfServerHash').textContent = bjCommit.serverSeedHash;
        document.getElementById('bjPfNonce').textContent = String(bjCommit.nonce);
    }
}

function showResult(result) {
    gameState = 'ended';

    const overlay = document.getElementById('bjResultOverlay');
    const iconEl = document.getElementById('resultIcon');
    const titleEl = document.getElementById('resultTitle');
    const amountEl = document.getElementById('resultAmount');
    const typeEl = document.getElementById('resultType');
    const playerScoreDisplay = document.getElementById('resultPlayerScore');
    const dealerScoreDisplay = document.getElementById('resultDealerScore');
    const betAmountEl = document.getElementById('resultBetAmount');

    let resultClass = '';
    let icon = '';
    let title = '';
    let amount = '';
    let typeName = '';

    if (result.result === 'blackjack') {
        resultClass = 'blackjack';
        icon = '🎰';
        title = 'BLACKJACK!';
        amount = '+' + numberFormat(result.winAmount) + 'P';
        typeName = '블랙잭';
    } else if (result.result === 'win' || result.result === 'dealer_bust') {
        resultClass = 'win';
        icon = '🎉';
        title = 'WIN!';
        amount = '+' + numberFormat(result.winAmount) + 'P';
        typeName = result.result === 'dealer_bust' ? '딜러 버스트' : '승리';
    } else if (result.result === 'push') {
        resultClass = 'push';
        icon = '🤝';
        title = 'PUSH';
        amount = '±0P';
        typeName = '무승부';
    } else {
        resultClass = 'lose';
        icon = '😢';
        title = 'LOSE';
        amount = '-' + numberFormat(result.loseAmount || currentBet) + 'P';
        typeName = result.result === 'bust' ? '버스트' : '패배';
    }

    // 모달 내용 설정
    iconEl.textContent = icon;
    titleEl.textContent = title;
    titleEl.className = 'bj-result-title ' + resultClass;
    amountEl.textContent = amount;
    amountEl.className = 'bj-result-amount ' + (resultClass === 'win' || resultClass === 'blackjack' ? 'win' : (resultClass === 'lose' ? 'lose' : ''));
    typeEl.textContent = typeName;
    playerScoreDisplay.textContent = result.playerScore || calculateScore(playerCards);
    dealerScoreDisplay.textContent = result.dealerScore || calculateScore(dealerCards);
    betAmountEl.textContent = numberFormat(isDoubled ? currentBet * 2 : currentBet) + 'P';

    // 모달 표시
    overlay.classList.add('show');

    // 테이블 위 승자 표시
    const playerScoreEl = document.getElementById('playerScore');
    const dealerScoreEl = document.getElementById('dealerScore');
    playerScoreEl.classList.remove('winner');
    dealerScoreEl.classList.remove('winner');

    if (resultClass === 'win' || resultClass === 'blackjack') {
        playerScoreEl.classList.add('winner');
    } else if (resultClass === 'lose') {
        dealerScoreEl.classList.add('winner');
    }

    addToHistory(result);
}

function closeResult() {
    document.getElementById('bjResultOverlay').classList.remove('show');

    // 베팅 상태로 전환 (배팅액 변경 가능하도록)
    gameState = 'betting';

    // 새 게임 버튼 표시
    document.getElementById('dealBtn').textContent = '🃏 NEW GAME';
    document.getElementById('dealBtn').style.display = 'inline-block';
    document.getElementById('mobileDealBtn').textContent = '🃏 NEW';
    document.getElementById('mobileDealBtn').style.display = 'inline-block';
    document.getElementById('bettingSection').style.display = 'block';
}

function resetGame() {
    gameState = 'betting';
    document.getElementById('dealBtn').textContent = '🃏 DEAL';
    document.getElementById('dealBtn').style.display = 'inline-block';
    document.getElementById('mobileDealBtn').textContent = '🃏 DEAL';
    document.getElementById('mobileDealBtn').style.display = 'inline-block';
    document.getElementById('bettingSection').style.display = 'block';
    showActionButtons(false);

    document.getElementById('dealerScore').textContent = '?';
    document.getElementById('dealerScore').className = 'hand-score-badge';
    document.getElementById('playerScore').textContent = '?';
    document.getElementById('playerScore').className = 'hand-score-badge';
    document.getElementById('dealerCards').innerHTML = '';
    document.getElementById('playerCards').innerHTML = '';
    document.getElementById('bjWaitingOverlay').classList.remove('hidden');
    document.getElementById('bjResultOverlay').classList.remove('show');
}

function addToHistory(result) {
    const historyList = document.getElementById('bjHistoryList');
    const noHistory = historyList.querySelector('.bj-no-history');
    if (noHistory) noHistory.remove();

    const now = new Date();
    const datetime = `${String(now.getMonth() + 1).padStart(2, '0')}/${String(now.getDate()).padStart(2, '0')} ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

    const isWin = result.netProfit > 0;
    const pointClass = result.netProfit > 0 ? 'point-win' : (result.netProfit < 0 ? 'point-lose' : '');
    const pointSign = result.netProfit > 0 ? '+' : '';
    const content = result.result === 'blackjack' ? '블랙잭 BJ' : (isWin ? '블랙잭 승리' : (result.result === 'push' ? '블랙잭 무승부' : '블랙잭 패배'));

    const row = document.createElement('div');
    row.className = 'bj-history-row';
    row.innerHTML = `
        <div class="bj-history-info">
            <span class="bj-history-game">${content}</span>
            <span class="bj-history-time">${datetime}</span>
        </div>
        <div class="bj-history-point ${pointClass}">
            ${result.netProfit === 0 ? '±0' : pointSign + numberFormat(result.netProfit)}P
        </div>
    `;

    historyList.insertBefore(row, historyList.firstChild);

    const rows = historyList.querySelectorAll('.bj-history-row');
    if (rows.length > 10) {
        rows[rows.length - 1].remove();
    }
}

function numberFormat(num) {
    return Math.abs(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// 검증 관련
async function sha256Hex(str) {
    const enc = new TextEncoder();
    const data = enc.encode(str);
    const hashBuf = await crypto.subtle.digest('SHA-256', data);
    return Array.from(new Uint8Array(hashBuf)).map(b => b.toString(16).padStart(2, '0')).join('');
}

async function toggleBjVerify() {
    const panel = document.getElementById('bjPfPanel');
    const statusEl = document.getElementById('bjPfStatus');
    const jsonEl = document.getElementById('bjPfJson');
    const pill = document.getElementById('bjPfPill');

    panel.classList.toggle('show');
    if (!panel.classList.contains('show')) return;

    if (!lastBlackjackResult || !lastBlackjackResult.provablyFair) {
        statusEl.className = 'bj-pf-status warn';
        statusEl.textContent = '게임 진행 후 검증 가능';
        jsonEl.textContent = '{}';
        pill.className = 'bj-verify-pill warn';
        pill.textContent = '대기중';
        return;
    }

    const pf = lastBlackjackResult.provablyFair;
    let hashOk = false;
    try {
        hashOk = (await sha256Hex(String(pf.serverSeed))) === String(pf.serverSeedHash);
    } catch (e) {}

    if (hashOk) {
        statusEl.className = 'bj-pf-status ok';
        statusEl.textContent = '검증 통과: 해시 일치';
        pill.className = 'bj-verify-pill ok';
        pill.textContent = '통과';
    } else {
        statusEl.className = 'bj-pf-status bad';
        statusEl.textContent = '검증 실패';
        pill.className = 'bj-verify-pill bad';
        pill.textContent = '실패';
    }

    jsonEl.textContent = JSON.stringify({
        provablyFair: pf,
        result: {
            playerScore: lastBlackjackResult.playerScore,
            dealerScore: lastBlackjackResult.dealerScore,
            result: lastBlackjackResult.result,
            netProfit: lastBlackjackResult.netProfit
        }
    }, null, 2);
}

document.addEventListener('DOMContentLoaded', function() {
    refreshBjCommit();
});
</script>

<?php
include_once(G5_PATH.'/tail.php');
?>
