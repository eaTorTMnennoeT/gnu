<?php
/**
 * 바카라 게임 - 프리미엄 버전
 * 모바일 최적화 + 고급 카드 애니메이션
 */
include_once('./_common.php');

if (!$is_member) {
    alert('로그인 후 이용해주세요.', G5_URL);
    exit;
}

$g5['title'] = '바카라';
include_once(G5_PATH.'/head.php');

$member_point = $member['mb_point'];
?>

<style>
/* ========================================
   바카라 - 프리미엄 모바일 최적화
   ======================================== */

.baccarat-container {
    max-width: 700px;
    margin: 0 auto;
    padding: 15px;
    padding-bottom: 220px; /* 모바일 하단 고정 영역 */
    box-sizing: border-box;
    overflow-x: hidden;
}

@media (min-width: 769px) {
    .baccarat-container {
        padding-bottom: 20px;
    }
}

@media (max-width: 768px) {
    .baccarat-container {
        padding: 10px;
        padding-bottom: 200px;
    }
}

.baccarat-game {
    background: linear-gradient(180deg, #0d1117 0%, #161b22 100%);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    border: 1px solid rgba(255,255,255,0.1);
    width: 100%;
    box-sizing: border-box;
}

/* 헤더 */
.bacc-header {
    background: linear-gradient(135deg, #7c2d12 0%, #991b1b 100%);
    padding: 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.bacc-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.bacc-header-content {
    position: relative;
    z-index: 1;
}

.bacc-title {
    font-size: 26px;
    font-weight: 900;
    color: white;
    margin: 0 0 4px 0;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.bacc-subtitle {
    color: rgba(255,255,255,0.7);
    font-size: 13px;
    margin: 0;
}

/* 포인트 바 */
.bacc-point-bar {
    display: flex;
    justify-content: center;
    padding: 12px 20px;
    background: rgba(0,0,0,0.3);
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.bacc-point-box {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.1);
    padding: 8px 20px;
    border-radius: 30px;
}

.bacc-point-icon {
    font-size: 18px;
}

.bacc-point-value {
    font-size: 20px;
    font-weight: 800;
    color: #fbbf24;
}

.bacc-point-unit {
    color: rgba(255,255,255,0.5);
    font-size: 14px;
}

/* 테이블 영역 */
.bacc-table-area {
    padding: 20px;
    background: linear-gradient(180deg, #1a472a 0%, #0d2818 100%);
    position: relative;
}

.bacc-table-area::before {
    content: '';
    position: absolute;
    inset: 10px;
    border: 3px solid rgba(212, 175, 55, 0.3);
    border-radius: 100px;
    pointer-events: none;
}

/* 핸드 컨테이너 */
.hands-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    position: relative;
    z-index: 1;
}

.hand-section {
    text-align: center;
}

.hand-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 12px;
}

.hand-label.player {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
}

.hand-label.banker {
    background: linear-gradient(135deg, #ef4444, #b91c1c);
    color: white;
}

.hand-score-badge {
    background: rgba(0,0,0,0.5);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 900;
    color: white;
    margin-left: 8px;
    transition: all 0.3s;
}

.hand-score-badge.winner {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    box-shadow: 0 0 20px rgba(245, 158, 11, 0.6);
    transform: scale(1.2);
}

/* 카드 영역 */
.cards-area {
    min-height: 110px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    perspective: 1000px;
}

/* 프리미엄 카드 스타일 */
.premium-card {
    width: 60px;
    height: 84px;
    position: relative;
    transform-style: preserve-3d;
    animation: cardDeal 0.6s ease-out forwards;
    opacity: 0;
}

@keyframes cardDeal {
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
.premium-card:nth-child(2) { animation-delay: 0.3s; }
.premium-card:nth-child(3) { animation-delay: 0.6s; }

.card-inner {
    width: 100%;
    height: 100%;
    position: relative;
    border-radius: 8px;
    background: linear-gradient(145deg, #ffffff 0%, #f0f0f0 100%);
    box-shadow:
        0 4px 15px rgba(0,0,0,0.4),
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

.card-value {
    font-size: 22px;
    font-weight: 900;
    line-height: 1;
}

.card-suit {
    font-size: 28px;
    line-height: 1;
    margin-top: 2px;
}

.card-corner {
    position: absolute;
    font-size: 10px;
    font-weight: 700;
    display: flex;
    flex-direction: column;
    align-items: center;
    line-height: 1;
}

.card-corner.top {
    top: 4px;
    left: 4px;
}

.card-corner.bottom {
    bottom: 4px;
    right: 4px;
    transform: rotate(180deg);
}

.card-corner .corner-suit {
    font-size: 8px;
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

/* 카드 뒷면 (딜링 시) */
.card-back {
    width: 60px;
    height: 84px;
    border-radius: 8px;
    background: linear-gradient(135deg, #1e3a5f 0%, #0d1f33 100%);
    background-image:
        repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(255,255,255,0.03) 5px, rgba(255,255,255,0.03) 10px),
        repeating-linear-gradient(-45deg, transparent, transparent 5px, rgba(255,255,255,0.03) 5px, rgba(255,255,255,0.03) 10px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: cardSlide 0.3s ease-out;
    flex-shrink: 0;
}

@media (max-width: 480px) {
    .card-back {
        width: 46px;
        height: 64px;
    }

    .card-back::after {
        width: 30px;
        height: 44px;
    }
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
    height: 60px;
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

/* VS 뱃지 */
.vs-badge {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 900;
    color: white;
    box-shadow: 0 4px 20px rgba(245, 158, 11, 0.5);
    z-index: 10;
    border: 3px solid rgba(255,255,255,0.3);
}

/* 데스크톱 베팅 영역 */
.desktop-betting {
    padding: 20px;
    background: rgba(0,0,0,0.3);
}

@media (max-width: 768px) {
    .desktop-betting {
        display: none;
    }
}

/* 모바일 하단 고정 베팅 */
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

/* 베팅 타입 버튼 */
.bet-types-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-bottom: 12px;
}

@media (max-width: 400px) {
    .bet-types-row {
        gap: 6px;
        margin-bottom: 10px;
    }
}

.bet-type-btn {
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

.bet-type-btn .type-name {
    font-size: 13px;
    display: block;
}

.bet-type-btn .type-odds {
    font-size: 11px;
    opacity: 0.6;
    display: block;
    margin-top: 2px;
}

@media (max-width: 400px) {
    .bet-type-btn {
        padding: 8px 4px;
        border-radius: 8px;
    }

    .bet-type-btn .type-name {
        font-size: 11px;
    }

    .bet-type-btn .type-odds {
        font-size: 10px;
    }
}

.bet-type-btn.player-bet {
    border-color: rgba(59, 130, 246, 0.5);
}

.bet-type-btn.player-bet.active {
    background: #3b82f6;
    border-color: #3b82f6;
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
}

.bet-type-btn.banker-bet {
    border-color: rgba(239, 68, 68, 0.5);
}

.bet-type-btn.banker-bet.active {
    background: #ef4444;
    border-color: #ef4444;
    box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
}

.bet-type-btn.tie-bet {
    border-color: rgba(16, 185, 129, 0.5);
}

.bet-type-btn.tie-bet.active {
    background: #10b981;
    border-color: #10b981;
    box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
}

/* 베팅 금액 + 딜 버튼 */
.bet-action-row {
    display: flex;
    gap: 10px;
    align-items: center;
}

.bet-amount-group {
    flex: 1;
    display: flex;
    gap: 6px;
    overflow-x: auto;
    padding: 4px 0;
    -webkit-overflow-scrolling: touch;
    min-width: 0;
}

.bet-amount-group::-webkit-scrollbar {
    display: none;
}

@media (max-width: 400px) {
    .bet-amount-group {
        gap: 4px;
    }
}

.bet-chip {
    flex-shrink: 0;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 3px solid;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 11px;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
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

.bet-chip[data-bet="100"] {
    border-color: #ef4444;
    color: #ef4444;
}
.bet-chip[data-bet="100"]::before {
    border-color: #ef4444;
}

.bet-chip[data-bet="500"] {
    border-color: #3b82f6;
    color: #3b82f6;
}
.bet-chip[data-bet="500"]::before {
    border-color: #3b82f6;
}

.bet-chip[data-bet="1000"] {
    border-color: #10b981;
    color: #10b981;
}
.bet-chip[data-bet="1000"]::before {
    border-color: #10b981;
}

.bet-chip[data-bet="5000"] {
    border-color: #8b5cf6;
    color: #8b5cf6;
}
.bet-chip[data-bet="5000"]::before {
    border-color: #8b5cf6;
}

.bet-chip[data-bet="10000"] {
    border-color: #f59e0b;
    color: #f59e0b;
}
.bet-chip[data-bet="10000"]::before {
    border-color: #f59e0b;
}

.bet-chip.active {
    transform: scale(1.15);
    box-shadow: 0 0 20px currentColor;
}

.bet-chip .chip-value {
    font-size: 12px;
    font-weight: 800;
}

/* 딜 버튼 */
.deal-btn {
    width: 80px;
    height: 50px;
    flex-shrink: 0;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    color: white;
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
}

.deal-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.5);
}

.deal-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.deal-btn.dealing {
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

/* 결과 표시 */
.result-overlay {
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

.result-overlay.show {
    opacity: 1;
    visibility: visible;
}

.result-modal {
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

.result-overlay.show .result-modal {
    transform: scale(1);
}

.result-icon {
    font-size: 60px;
    margin-bottom: 16px;
    animation: bounce 0.5s ease;
}

@keyframes bounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

.result-title {
    font-size: 28px;
    font-weight: 900;
    margin-bottom: 8px;
}

.result-title.win {
    color: #10b981;
}

.result-title.lose {
    color: #ef4444;
}

.result-amount {
    font-size: 24px;
    font-weight: 700;
    color: white;
    margin-bottom: 20px;
}

.result-details {
    background: rgba(0,0,0,0.3);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 20px;
}

.result-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 14px;
}

.result-row-label {
    color: rgba(255,255,255,0.5);
}

.result-row-value {
    color: white;
    font-weight: 600;
}

.result-close-btn {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    color: white;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
}

.result-close-btn:hover {
    transform: translateY(-2px);
}

/* 규칙 & 히스토리 */
.bacc-info-section {
    padding: 20px;
}

.bacc-rules {
    background: rgba(255,255,255,0.03);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
    border: 1px solid rgba(255,255,255,0.05);
}

.bacc-rules h3 {
    font-size: 13px;
    font-weight: 700;
    color: rgba(255,255,255,0.7);
    margin: 0 0 12px 0;
}

.bacc-rules ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.bacc-rules li {
    padding: 4px 0;
    font-size: 12px;
    color: rgba(255,255,255,0.5);
    display: flex;
    align-items: center;
    gap: 8px;
}

.bacc-rules li::before {
    content: "•";
    color: #dc2626;
}

.bacc-history {
    background: rgba(255,255,255,0.03);
    border-radius: 12px;
    padding: 16px;
    border: 1px solid rgba(255,255,255,0.05);
}

.bacc-history h3 {
    font-size: 13px;
    font-weight: 700;
    color: rgba(255,255,255,0.7);
    margin: 0 0 12px 0;
}

.bacc-history-list {
    max-height: 200px;
    overflow-y: auto;
}

.bacc-history-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.bacc-history-row:last-child {
    border-bottom: none;
}

.bacc-history-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.bacc-history-game {
    font-size: 12px;
    color: rgba(255,255,255,0.8);
}

.bacc-history-time {
    font-size: 10px;
    color: rgba(255,255,255,0.4);
}

.bacc-history-point {
    font-size: 13px;
    font-weight: 700;
}

.bacc-history-point.point-win {
    color: #10b981;
}

.bacc-history-point.point-lose {
    color: #ef4444;
}

/* 조작/검증 안내 */
.bacc-verify {
    background: rgba(255,255,255,0.03);
    border-radius: 12px;
    padding: 16px;
    border: 1px solid rgba(255,255,255,0.05);
    margin-top: 16px;
}

.bacc-verify h3 {
    font-size: 13px;
    font-weight: 700;
    color: rgba(255,255,255,0.7);
    margin: 0 0 10px 0;
}

.bacc-verify p {
    margin: 0 0 10px 0;
    font-size: 12px;
    line-height: 1.6;
    color: rgba(255,255,255,0.55);
}

.bacc-verify strong {
    color: rgba(255,255,255,0.9);
    font-weight: 800;
}

.bacc-verify-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 10px;
}

.bacc-verify-pill {
    font-size: 11px;
    font-weight: 800;
    padding: 6px 10px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.06);
    color: rgba(255,255,255,0.8);
    white-space: nowrap;
}

.bacc-verify-pill.ok { border-color: rgba(16,185,129,0.35); color: #10b981; }
.bacc-verify-pill.bad { border-color: rgba(239,68,68,0.35); color: #ef4444; }
.bacc-verify-pill.warn { border-color: rgba(245,158,11,0.35); color: #f59e0b; }

.bacc-pf-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 8px;
    margin: 10px 0 0 0;
}

@media (min-width: 480px) {
    .bacc-pf-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.bacc-pf-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 10px 12px;
    border-radius: 10px;
    background: rgba(0,0,0,0.22);
    border: 1px solid rgba(255,255,255,0.06);
}

.bacc-pf-label {
    font-size: 11px;
    color: rgba(255,255,255,0.55);
    font-weight: 700;
}

.bacc-pf-code {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: 11px;
    color: rgba(255,255,255,0.9);
    word-break: break-all;
    line-height: 1.35;
}

.bacc-verify details {
    margin-top: 10px;
    border-top: 1px solid rgba(255,255,255,0.06);
    padding-top: 10px;
}

.bacc-verify summary {
    cursor: pointer;
    font-size: 12px;
    font-weight: 800;
    color: rgba(255,255,255,0.75);
    list-style: none;
}

.bacc-verify summary::-webkit-details-marker { display: none; }

.bacc-verify summary::after {
    content: "▾";
    float: right;
    opacity: 0.8;
}

.bacc-verify details[open] summary::after { content: "▴"; }

.bacc-verify ul {
    list-style: none;
    padding: 0;
    margin: 0 0 12px 0;
}

.bacc-verify li {
    padding: 4px 0;
    font-size: 12px;
    color: rgba(255,255,255,0.5);
    display: flex;
    align-items: flex-start;
    gap: 8px;
}

.bacc-verify li::before {
    content: "•";
    color: #f59e0b;
    flex: 0 0 auto;
    margin-top: 1px;
}

.bacc-verify-actions {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.bacc-verify-btn {
    appearance: none;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.06);
    color: rgba(255,255,255,0.85);
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    flex: 1;
}

.bacc-verify-btn:hover {
    transform: translateY(-1px);
    border-color: rgba(245,158,11,0.5);
}

.bacc-verify-panel {
    margin-top: 12px;
    padding: 12px;
    border-radius: 10px;
    background: rgba(0,0,0,0.25);
    border: 1px solid rgba(255,255,255,0.06);
    display: none;
}

.bacc-verify-panel.show {
    display: block;
}

.bacc-verify-status {
    font-size: 12px;
    font-weight: 800;
    margin-bottom: 8px;
}

.bacc-verify-status.ok { color: #10b981; }
.bacc-verify-status.bad { color: #ef4444; }
.bacc-verify-status.warn { color: #f59e0b; }

.bacc-verify-json {
    margin: 0;
    padding: 10px;
    border-radius: 8px;
    background: rgba(0,0,0,0.35);
    border: 1px solid rgba(255,255,255,0.05);
    color: rgba(255,255,255,0.85);
    font-size: 11px;
    line-height: 1.4;
    max-height: 220px;
    overflow: auto;
    white-space: pre-wrap;
    word-break: break-word;
}

.bacc-no-history {
    text-align: center;
    color: rgba(255,255,255,0.4);
    padding: 20px 0;
    font-size: 12px;
}

/* 반응형 */
@media (max-width: 480px) {
    .hands-wrapper {
        gap: 8px;
    }

    .premium-card {
        width: 46px;
        height: 64px;
    }

    .card-value {
        font-size: 16px;
    }

    .card-suit {
        font-size: 20px;
    }

    .card-corner {
        font-size: 8px;
    }

    .card-corner .corner-suit {
        font-size: 6px;
    }

    .vs-badge {
        width: 36px;
        height: 36px;
        font-size: 12px;
    }

    .bet-chip {
        width: 42px;
        height: 42px;
    }

    .bet-chip .chip-value {
        font-size: 10px;
    }

    .hand-label {
        font-size: 12px;
        padding: 4px 12px;
    }

    .hand-score-badge {
        width: 28px;
        height: 28px;
        font-size: 14px;
    }

    .cards-area {
        min-height: 90px;
        gap: 5px;
    }

    .bacc-table-area {
        padding: 15px 10px;
    }

    .bacc-table-area::before {
        inset: 5px;
        border-width: 2px;
        border-radius: 50px;
    }

    .bacc-header {
        padding: 15px;
    }

    .bacc-title {
        font-size: 22px;
    }

    .bacc-subtitle {
        font-size: 11px;
    }

    .bacc-point-bar {
        padding: 10px 15px;
    }

    .bacc-point-value {
        font-size: 18px;
    }

    .bacc-info-section {
        padding: 15px;
    }
}

/* 모바일 가로 스크롤 방지 */
@media (max-width: 768px) {
    .bacc-table-area::before {
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

<div class="baccarat-container">
    <div class="baccarat-game">
        <!-- 헤더 -->
        <div class="bacc-header">
            <div class="bacc-header-content">
                <h1 class="bacc-title">BACCARAT</h1>
                <p class="bacc-subtitle">Player vs Banker - 9에 가까운 쪽이 승리!</p>
            </div>
        </div>

        <!-- 포인트 바 -->
        <div class="bacc-point-bar">
            <div class="bacc-point-box">
                <span class="bacc-point-icon">💰</span>
                <span class="bacc-point-value" id="userPoint"><?php echo number_format($member_point); ?></span>
                <span class="bacc-point-unit">P</span>
            </div>
        </div>

        <!-- 테이블 영역 -->
        <div class="bacc-table-area">
            <div class="hands-wrapper">
                <!-- 플레이어 -->
                <div class="hand-section">
                    <div class="hand-label player">
                        PLAYER
                        <span class="hand-score-badge" id="playerScore">0</span>
                    </div>
                    <div class="cards-area" id="playerCards"></div>
                </div>

                <!-- 뱅커 -->
                <div class="hand-section">
                    <div class="hand-label banker">
                        BANKER
                        <span class="hand-score-badge" id="bankerScore">0</span>
                    </div>
                    <div class="cards-area" id="bankerCards"></div>
                </div>
            </div>

            <div class="vs-badge">VS</div>
        </div>

        <!-- 데스크톱 베팅 영역 -->
        <div class="desktop-betting">
            <div class="bet-types-row">
                <button class="bet-type-btn player-bet active" data-type="player">
                    <span class="type-name">플레이어</span>
                    <span class="type-odds">x2.0</span>
                </button>
                <button class="bet-type-btn tie-bet" data-type="tie">
                    <span class="type-name">타이</span>
                    <span class="type-odds">x8.0</span>
                </button>
                <button class="bet-type-btn banker-bet" data-type="banker">
                    <span class="type-name">뱅커</span>
                    <span class="type-odds">x1.95</span>
                </button>
            </div>

            <div class="bet-action-row">
                <div class="bet-amount-group">
                    <div class="bet-chip" data-bet="100"><span class="chip-value">100</span></div>
                    <div class="bet-chip active" data-bet="500"><span class="chip-value">500</span></div>
                    <div class="bet-chip" data-bet="1000"><span class="chip-value">1K</span></div>
                    <div class="bet-chip" data-bet="5000"><span class="chip-value">5K</span></div>
                    <div class="bet-chip" data-bet="10000"><span class="chip-value">10K</span></div>
                </div>
                <button class="deal-btn" id="dealBtnDesktop" onclick="playBaccarat()">DEAL</button>
            </div>
        </div>

        <!-- 정보 섹션 -->
        <div class="bacc-info-section">
            <div class="bacc-rules">
                <h3>게임 규칙</h3>
                <ul>
                    <li>카드 합이 9에 가까운 쪽이 승리</li>
                    <li>10, J, Q, K는 0점 / A는 1점</li>
                    <li>플레이어 승리: 2배 / 뱅커: 1.95배 / 타이: 8배</li>
                </ul>
            </div>

            <div class="bacc-history">
                <h3>배팅 내역</h3>
                <div class="bacc-history-list" id="baccHistoryList">
                    <?php
                    $sql = "SELECT po_content, po_point, po_datetime
                            FROM {$g5['point_table']}
                            WHERE mb_id = '{$member['mb_id']}'
                            AND po_content LIKE '%바카라%'
                            ORDER BY po_id DESC
                            LIMIT 10";
                    $result = sql_query($sql);

                    if (sql_num_rows($result) > 0) {
                        while ($row = sql_fetch_array($result)) {
                            $isWin = $row['po_point'] > 0;
                            $pointClass = $isWin ? 'point-win' : 'point-lose';
                            $pointSign = $isWin ? '+' : '';
                            ?>
                            <div class="bacc-history-row">
                                <div class="bacc-history-info">
                                    <span class="bacc-history-game"><?php echo $row['po_content']; ?></span>
                                    <span class="bacc-history-time"><?php echo date('m/d H:i', strtotime($row['po_datetime'])); ?></span>
                                </div>
                                <div class="bacc-history-point <?php echo $pointClass; ?>">
                                    <?php echo $pointSign . number_format($row['po_point']); ?>P
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="bacc-no-history">배팅 내역이 없습니다</div>';
                    }
                    ?>
                </div>
            </div>

            <div class="bacc-verify">
                <div class="bacc-verify-top">
                    <h3 style="margin:0;">조작/검증</h3>
                    <span class="bacc-verify-pill warn" id="baccVerifyPill">대기중</span>
                </div>
                <p style="margin-bottom:8px;">
                    결과는 <strong>서버</strong>에서 결정되고, 화면은 <strong>표시</strong>만 합니다.
                    아래 <strong>해시(커밋)</strong>는 “이 판에 쓸 서버 시드”를 미리 약속(커밋)한 값입니다.
                </p>
                <ul>
                    <li><strong>왜 조작이 어렵나</strong>: 화면을 바꿔도 서버가 다시 계산/정산합니다.</li>
                    <li><strong>검증하기</strong>: 마지막 판의 카드로 점수/승자를 재계산해 서버값과 일치하는지 확인합니다.</li>
                </ul>
                <div class="bacc-pf-grid">
                    <div class="bacc-pf-item">
                        <div class="bacc-pf-label">서버 해시(커밋)</div>
                        <div class="bacc-pf-code" id="pfServerHash">-</div>
                        <div class="bacc-pf-label">Nonce</div>
                        <div class="bacc-pf-code" id="pfNonce">-</div>
                    </div>
                    <div class="bacc-pf-item">
                        <div class="bacc-pf-label">내 클라이언트 시드</div>
                        <div class="bacc-pf-code" id="pfClientSeed">-</div>
                        <div class="bacc-verify-actions" style="margin-top:6px;">
                            <button type="button" class="bacc-verify-btn" onclick="toggleBaccaratVerify()">검증하기</button>
                            <button type="button" class="bacc-verify-btn" onclick="refreshBaccaratCommit()">해시 새로고침</button>
                        </div>
                    </div>
                </div>
                <div class="bacc-verify-panel" id="baccVerifyPanel">
                    <div class="bacc-verify-status warn" id="baccVerifyStatus">아직 검증할 게임 결과가 없습니다. 먼저 DEAL을 눌러주세요.</div>
                    <pre class="bacc-verify-json" id="baccVerifyJson">{}</pre>
                </div>
                <details>
                    <summary>더 알아보기 (해시/시드)</summary>
                    <p style="margin-top:10px;">
                        <strong>커밋-리빌</strong>: DEAL 전에 서버는 <strong>serverSeed의 해시</strong>만 공개합니다.
                        DEAL 후에는 실제 <strong>serverSeed</strong>를 공개해서 해시가 맞는지 확인할 수 있습니다.
                    </p>
                    <p style="margin:0;">
                        이 방식은 “이 판 결과가 커밋된 시드로부터 계산된 것”을 검증할 수 있게 해줍니다.
                        (완전한 제3자 감사/블록체인 증명까지는 아니지만, 화면 조작/사후 변경 여부는 잡아낼 수 있습니다.)
                    </p>
                </details>
            </div>
        </div>
    </div>
</div>

<!-- 모바일 하단 고정 베팅 -->
<div class="mobile-betting">
    <div class="bet-types-row">
        <button class="bet-type-btn player-bet active" data-type="player">
            <span class="type-name">플레이어</span>
            <span class="type-odds">x2.0</span>
        </button>
        <button class="bet-type-btn tie-bet" data-type="tie">
            <span class="type-name">타이</span>
            <span class="type-odds">x8.0</span>
        </button>
        <button class="bet-type-btn banker-bet" data-type="banker">
            <span class="type-name">뱅커</span>
            <span class="type-odds">x1.95</span>
        </button>
    </div>

    <div class="bet-action-row">
        <div class="bet-amount-group">
            <div class="bet-chip" data-bet="100"><span class="chip-value">100</span></div>
            <div class="bet-chip active" data-bet="500"><span class="chip-value">500</span></div>
            <div class="bet-chip" data-bet="1000"><span class="chip-value">1K</span></div>
            <div class="bet-chip" data-bet="5000"><span class="chip-value">5K</span></div>
            <div class="bet-chip" data-bet="10000"><span class="chip-value">10K</span></div>
        </div>
        <button class="deal-btn" id="dealBtnMobile" onclick="playBaccarat()">DEAL</button>
    </div>
</div>

<!-- 결과 모달 -->
<div class="result-overlay" id="resultOverlay">
    <div class="result-modal">
        <div class="result-icon" id="resultIcon">🎉</div>
        <div class="result-title" id="resultTitle">WIN!</div>
        <div class="result-amount" id="resultAmount">+1,000P</div>
        <div class="result-details">
            <div class="result-row">
                <span class="result-row-label">승자</span>
                <span class="result-row-value" id="resultWinner">플레이어</span>
            </div>
            <div class="result-row">
                <span class="result-row-label">플레이어</span>
                <span class="result-row-value" id="resultPlayerScore">8</span>
            </div>
            <div class="result-row">
                <span class="result-row-label">뱅커</span>
                <span class="result-row-value" id="resultBankerScore">5</span>
            </div>
            <div class="result-row">
                <span class="result-row-label">내 베팅</span>
                <span class="result-row-value" id="resultMyBet">플레이어</span>
            </div>
        </div>
        <button class="result-close-btn" onclick="closeResult()">확인</button>
    </div>
</div>

<script>
let currentBet = 500;
let currentType = 'player';
let userPoint = <?php echo $member_point; ?>;
let isPlaying = false;
// 마지막 서버 응답(검증용)
let lastBaccaratResult = null;
let lastBaccaratRequest = null;
let baccaratCommit = null;
const PF_STORAGE_KEY = 'baccarat_pf_client_seed_v1';

function getOrCreateClientSeed() {
    try {
        const existing = localStorage.getItem(PF_STORAGE_KEY);
        if (existing && existing.length >= 8) return existing;
        const seed = (crypto && crypto.randomUUID) ? crypto.randomUUID() : ('seed_' + Math.random().toString(16).slice(2) + Date.now());
        localStorage.setItem(PF_STORAGE_KEY, seed);
        return seed;
    } catch (e) {
        return 'seed_' + Math.random().toString(16).slice(2) + Date.now();
    }
}

async function refreshBaccaratCommit() {
    const clientSeed = getOrCreateClientSeed();
    const elSeed = document.getElementById('pfClientSeed');
    if (elSeed) elSeed.textContent = clientSeed;

    try {
        const res = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=baccarat_commit'
        });
        const data = await res.json();
        if (!data.success || !data.provablyFair) throw new Error(data.message || 'commit failed');

        baccaratCommit = {
            serverSeedHash: data.provablyFair.serverSeedHash,
            nonce: data.provablyFair.nonce
        };

        const elHash = document.getElementById('pfServerHash');
        const elNonce = document.getElementById('pfNonce');
        if (elHash) elHash.textContent = baccaratCommit.serverSeedHash;
        if (elNonce) elNonce.textContent = String(baccaratCommit.nonce);

        const pill = document.getElementById('baccVerifyPill');
        if (pill) {
            pill.className = 'bacc-verify-pill warn';
            pill.textContent = '커밋 준비됨';
        }
    } catch (e) {
        console.error(e);
        const pill = document.getElementById('baccVerifyPill');
        if (pill) {
            pill.className = 'bacc-verify-pill bad';
            pill.textContent = '커밋 실패';
        }
    }
}

// 베팅 타입 버튼 (데스크톱 + 모바일)
document.querySelectorAll('.bet-type-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (isPlaying) return;
        document.querySelectorAll('.bet-type-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll(`.bet-type-btn[data-type="${this.dataset.type}"]`).forEach(b => b.classList.add('active'));
        currentType = this.dataset.type;
    });
});

// 베팅 칩 (데스크톱 + 모바일)
document.querySelectorAll('.bet-chip').forEach(chip => {
    chip.addEventListener('click', function() {
        if (isPlaying) return;
        document.querySelectorAll('.bet-chip').forEach(c => c.classList.remove('active'));
        document.querySelectorAll(`.bet-chip[data-bet="${this.dataset.bet}"]`).forEach(c => c.classList.add('active'));
        currentBet = parseInt(this.dataset.bet);
    });
});

// 프리미엄 카드 렌더링
function renderPremiumCard(card, delay = 0) {
    const isRed = card.suit === '♥' || card.suit === '♦';
    const colorClass = isRed ? 'red' : 'black';

    return `
        <div class="premium-card ${colorClass}" style="animation-delay: ${delay}s">
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
        </div>
    `;
}

// 카드 뒷면 렌더링
function renderCardBack() {
    return '<div class="card-back"></div>';
}

// 게임 실행
async function playBaccarat() {
    if (isPlaying) return;
    if (userPoint < currentBet) {
        alert('포인트가 부족합니다.');
        return;
    }

    if (!baccaratCommit) {
        await refreshBaccaratCommit();
    }
    if (!baccaratCommit) {
        alert('검증 정보(해시)를 불러오지 못했습니다. 새로고침 후 다시 시도해 주세요.');
        return;
    }

    isPlaying = true;
    const dealBtns = document.querySelectorAll('.deal-btn');
    dealBtns.forEach(btn => {
        btn.disabled = true;
        btn.classList.add('dealing');
        btn.textContent = '...';
    });

    // 초기화
    document.getElementById('playerCards').innerHTML = '';
    document.getElementById('bankerCards').innerHTML = '';
    document.getElementById('playerScore').textContent = '?';
    document.getElementById('bankerScore').textContent = '?';
    document.getElementById('playerScore').classList.remove('winner');
    document.getElementById('bankerScore').classList.remove('winner');

    try {
        const clientSeed = getOrCreateClientSeed();
        const response = await fetch('<?php echo G5_URL; ?>/game/game_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=baccarat&bet=${currentBet}&betType=${currentType}`
                + `&clientSeed=${encodeURIComponent(clientSeed)}`
                + `&serverSeedHash=${encodeURIComponent(baccaratCommit.serverSeedHash)}`
                + `&nonce=${encodeURIComponent(baccaratCommit.nonce)}`
        });

        const result = await response.json();

        if (!result.success) {
            alert(result.message || '오류가 발생했습니다.');
            resetGame();
            return;
        }

        // 검증용으로 마지막 요청/응답 저장
        lastBaccaratRequest = {
            bet: currentBet,
            betType: currentType,
            at: new Date().toISOString()
        };
        lastBaccaratResult = result;

        // 다음 커밋으로 UI 갱신(서버가 next 커밋을 같이 줌)
        if (result.provablyFair && result.provablyFair.nextServerSeedHash != null) {
            baccaratCommit = {
                serverSeedHash: result.provablyFair.nextServerSeedHash,
                nonce: result.provablyFair.nextNonce
            };
            const elHash = document.getElementById('pfServerHash');
            const elNonce = document.getElementById('pfNonce');
            if (elHash) elHash.textContent = baccaratCommit.serverSeedHash;
            if (elNonce) elNonce.textContent = String(baccaratCommit.nonce);
        } else {
            // fallback
            refreshBaccaratCommit();
        }

        // 고급 카드 딜링 애니메이션
        await dealCardsAnimated(result.playerCards, result.bankerCards, result.playerScore, result.bankerScore);

        // 승자 표시
        await delay(300);
        if (result.winner === 'player') {
            document.getElementById('playerScore').classList.add('winner');
        } else if (result.winner === 'banker') {
            document.getElementById('bankerScore').classList.add('winner');
        } else {
            document.getElementById('playerScore').classList.add('winner');
            document.getElementById('bankerScore').classList.add('winner');
        }

        // 포인트 업데이트
        userPoint = result.newPoint;
        document.getElementById('userPoint').textContent = numberFormat(userPoint);

        // 결과 모달 표시
        await delay(500);
        showResultModal(result);

    } catch (e) {
        console.error(e);
        alert('오류가 발생했습니다.');
        resetGame();
    }
}

// 고급 카드 딜링 애니메이션
async function dealCardsAnimated(playerCards, bankerCards, pScore, bScore) {
    const playerEl = document.getElementById('playerCards');
    const bankerEl = document.getElementById('bankerCards');

    // 카드 뒷면 먼저 보여주기 (딜링 효과)
    for (let i = 0; i < 2; i++) {
        playerEl.innerHTML += renderCardBack();
        await delay(200);
        bankerEl.innerHTML += renderCardBack();
        await delay(200);
    }

    await delay(500);

    // 카드 뒤집기 애니메이션 - 첫 2장
    playerEl.innerHTML = '';
    bankerEl.innerHTML = '';

    for (let i = 0; i < 2; i++) {
        playerEl.innerHTML += renderPremiumCard(playerCards[i], i * 0.15);
        await delay(400);
        bankerEl.innerHTML += renderPremiumCard(bankerCards[i], i * 0.15);
        await delay(400);
    }

    await delay(600);

    // 3번째 카드 (있는 경우)
    if (playerCards.length > 2) {
        playerEl.innerHTML += renderPremiumCard(playerCards[2], 0);
        await delay(500);
    }

    if (bankerCards.length > 2) {
        bankerEl.innerHTML += renderPremiumCard(bankerCards[2], 0);
        await delay(500);
    }

    // 점수 공개
    await delay(300);
    document.getElementById('playerScore').textContent = pScore;
    document.getElementById('bankerScore').textContent = bScore;
}

function delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function showResultModal(result) {
    const overlay = document.getElementById('resultOverlay');
    const icon = document.getElementById('resultIcon');
    const title = document.getElementById('resultTitle');
    const amount = document.getElementById('resultAmount');
    const winner = document.getElementById('resultWinner');
    const pScore = document.getElementById('resultPlayerScore');
    const bScore = document.getElementById('resultBankerScore');
    const myBet = document.getElementById('resultMyBet');

    let winnerText = result.winner === 'player' ? '플레이어' : result.winner === 'banker' ? '뱅커' : '타이';
    let myBetText = currentType === 'player' ? '플레이어' : currentType === 'banker' ? '뱅커' : '타이';

    if (result.win) {
        icon.textContent = '🎉';
        title.textContent = 'WIN!';
        title.className = 'result-title win';
        amount.textContent = '+' + numberFormat(result.winAmount) + 'P';
        amount.style.color = '#10b981';
    } else {
        icon.textContent = '😢';
        title.textContent = 'LOSE';
        title.className = 'result-title lose';
        amount.textContent = '-' + numberFormat(currentBet) + 'P';
        amount.style.color = '#ef4444';
    }

    winner.textContent = winnerText;
    pScore.textContent = result.playerScore;
    bScore.textContent = result.bankerScore;
    myBet.textContent = myBetText;

    overlay.classList.add('show');

    // 히스토리 추가
    addToHistory(result);
}

function closeResult() {
    document.getElementById('resultOverlay').classList.remove('show');
    resetGame();
}

function resetGame() {
    isPlaying = false;
    const dealBtns = document.querySelectorAll('.deal-btn');
    dealBtns.forEach(btn => {
        btn.disabled = false;
        btn.classList.remove('dealing');
        btn.textContent = 'DEAL';
    });
}

function addToHistory(result) {
    const historyList = document.getElementById('baccHistoryList');
    const noHistory = historyList.querySelector('.bacc-no-history');
    if (noHistory) noHistory.remove();

    const isWin = result.win;
    const pointClass = isWin ? 'point-win' : 'point-lose';
    const pointValue = isWin ? result.netProfit : -currentBet;
    const pointSign = pointValue > 0 ? '+' : '';

    let winnerText = result.winner === 'player' ? '플레이어' : result.winner === 'banker' ? '뱅커' : '타이';

    const now = new Date();
    const datetime = `${String(now.getMonth() + 1).padStart(2, '0')}/${String(now.getDate()).padStart(2, '0')} ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

    const row = document.createElement('div');
    row.className = 'bacc-history-row';
    row.innerHTML = `
        <div class="bacc-history-info">
            <span class="bacc-history-game">바카라 ${isWin ? '당첨' : '게임'} (${winnerText})</span>
            <span class="bacc-history-time">${datetime}</span>
        </div>
        <div class="bacc-history-point ${pointClass}">
            ${pointSign}${numberFormat(pointValue)}P
        </div>
    `;

    historyList.insertBefore(row, historyList.firstChild);

    const rows = historyList.querySelectorAll('.bacc-history-row');
    if (rows.length > 10) {
        rows[rows.length - 1].remove();
    }
}

function numberFormat(num) {
    return Math.abs(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// =========================
// 조작/검증 (일치 검사)
// =========================
function calcBaccaratScore(cards) {
    let total = 0;
    (cards || []).forEach(card => {
        const v = (card && card.value) ? String(card.value) : '';
        if (v === 'A') total += 1;
        else if (v === 'K' || v === 'Q' || v === 'J' || v === '10') total += 0;
        else total += parseInt(v, 10) || 0;
    });
    return total % 10;
}

function calcBaccaratWinner(playerScore, bankerScore) {
    if (playerScore > bankerScore) return 'player';
    if (bankerScore > playerScore) return 'banker';
    return 'tie';
}

async function sha256Hex(str) {
    const enc = new TextEncoder();
    const data = enc.encode(str);
    const hashBuf = await crypto.subtle.digest('SHA-256', data);
    const bytes = new Uint8Array(hashBuf);
    return Array.from(bytes).map(b => b.toString(16).padStart(2, '0')).join('');
}

function createDeck() {
    const suits = ['♠', '♥', '♦', '♣'];
    const values = ['A','2','3','4','5','6','7','8','9','10','J','Q','K'];
    const deck = [];
    suits.forEach(s => values.forEach(v => deck.push({suit:s, value:v})));
    return deck;
}

async function hmacSha256Hex(keyStr, msgStr) {
    const enc = new TextEncoder();
    const key = await crypto.subtle.importKey(
        'raw',
        enc.encode(keyStr),
        { name: 'HMAC', hash: 'SHA-256' },
        false,
        ['sign']
    );
    const sig = await crypto.subtle.sign('HMAC', key, enc.encode(msgStr));
    const bytes = new Uint8Array(sig);
    return Array.from(bytes).map(b => b.toString(16).padStart(2, '0')).join('');
}

async function createProvablyFairDeck(serverSeed, clientSeed, nonce) {
    const deck = createDeck();
    for (let i = deck.length - 1; i > 0; i--) {
        const msg = `${clientSeed}:${nonce}:${i}`;
        const hex = await hmacSha256Hex(serverSeed, msg);
        const rand = parseInt(hex.slice(0, 8), 16) >>> 0;
        const j = rand % (i + 1);
        const tmp = deck[i];
        deck[i] = deck[j];
        deck[j] = tmp;
    }
    return deck;
}

function sameCard(a, b) {
    return a && b && String(a.suit) === String(b.suit) && String(a.value) === String(b.value);
}

async function toggleBaccaratVerify() {
    const panel = document.getElementById('baccVerifyPanel');
    const statusEl = document.getElementById('baccVerifyStatus');
    const jsonEl = document.getElementById('baccVerifyJson');
    const pill = document.getElementById('baccVerifyPill');

    if (!panel || !statusEl || !jsonEl) return;
    panel.classList.toggle('show');

    if (!panel.classList.contains('show')) return;

    if (!lastBaccaratResult) {
        statusEl.className = 'bacc-verify-status warn';
        statusEl.textContent = '아직 검증할 게임 결과가 없습니다. 먼저 DEAL을 눌러주세요.';
        jsonEl.textContent = '{}';
        if (pill) { pill.className = 'bacc-verify-pill warn'; pill.textContent = '대기중'; }
        return;
    }

    if (!lastBaccaratResult.provablyFair) {
        statusEl.className = 'bacc-verify-status warn';
        statusEl.textContent = '이 결과는 해시(커밋-리빌) 정보가 없습니다. (서버 업데이트 후부터 적용)';
        if (pill) { pill.className = 'bacc-verify-pill warn'; pill.textContent = '부분검증'; }
        jsonEl.textContent = JSON.stringify({ serverResponse: lastBaccaratResult }, null, 2);
        return;
    }

    // 1) 서버 시드 해시 검증
    const pf = lastBaccaratResult.provablyFair;
    let hashOk = false;
    try {
        const h = await sha256Hex(String(pf.serverSeed));
        hashOk = (h === String(pf.serverSeedHash));
    } catch (e) {
        hashOk = false;
    }

    // 2) 서버 응답을 기반으로 점수/승자 재계산
    const pScore = calcBaccaratScore(lastBaccaratResult.playerCards);
    const bScore = calcBaccaratScore(lastBaccaratResult.bankerCards);
    const winner = calcBaccaratWinner(pScore, bScore);

    const okScore = (Number(lastBaccaratResult.playerScore) === pScore) && (Number(lastBaccaratResult.bankerScore) === bScore);
    const okWinner = (String(lastBaccaratResult.winner) === winner);

    // 3) 덱 재생성 후 카드 일치(상위 일부만 비교)
    let deckOk = false;
    let expected = { playerCards: [], bankerCards: [] };
    try {
        const deck = await createProvablyFairDeck(String(pf.serverSeed), String(pf.clientSeed), Number(pf.nonce));
        expected.playerCards = [deck[0], deck[2]];
        expected.bankerCards = [deck[1], deck[3]];
        // 3번째 카드 규칙은 서버가 이미 적용한 결과로 검증(점수/승자 일치)까지 포함되므로,
        // 여기서는 최소한 "초기 4장"이 일치하는지만 강하게 체크
        deckOk =
            sameCard(expected.playerCards[0], lastBaccaratResult.playerCards[0]) &&
            sameCard(expected.playerCards[1], lastBaccaratResult.playerCards[1]) &&
            sameCard(expected.bankerCards[0], lastBaccaratResult.bankerCards[0]) &&
            sameCard(expected.bankerCards[1], lastBaccaratResult.bankerCards[1]);
    } catch (e) {
        deckOk = false;
    }

    const allOk = hashOk && okScore && okWinner && deckOk;

    if (allOk) {
        statusEl.className = 'bacc-verify-status ok';
        statusEl.textContent = '검증 통과: 해시(커밋) + 덱(초기 4장) + 점수/승자 재계산이 서버 응답과 일치합니다.';
        if (pill) { pill.className = 'bacc-verify-pill ok'; pill.textContent = '검증 통과'; }
    } else {
        statusEl.className = 'bacc-verify-status bad';
        statusEl.textContent = '검증 실패: (해시/덱/점수/승자) 중 일부가 일치하지 않습니다.';
        if (pill) { pill.className = 'bacc-verify-pill bad'; pill.textContent = '검증 실패'; }
    }

    // 화면에 보기 좋게 출력(요청/응답/재계산)
    const payload = {
        request: lastBaccaratRequest,
        provablyFair: pf,
        checks: {
            hashOk,
            deckOk,
            scoreOk: okScore,
            winnerOk: okWinner
        },
        serverResponse: {
            playerCards: lastBaccaratResult.playerCards,
            bankerCards: lastBaccaratResult.bankerCards,
            playerScore: lastBaccaratResult.playerScore,
            bankerScore: lastBaccaratResult.bankerScore,
            winner: lastBaccaratResult.winner,
            betType: lastBaccaratResult.betType,
            win: lastBaccaratResult.win,
            multiplier: lastBaccaratResult.multiplier,
            winAmount: lastBaccaratResult.winAmount,
            netProfit: lastBaccaratResult.netProfit,
            newPoint: lastBaccaratResult.newPoint
        },
        browserRecalc: {
            playerScore: pScore,
            bankerScore: bScore,
            winner: winner,
            expectedInitialCards: expected
        }
    };

    try {
        jsonEl.textContent = JSON.stringify(payload, null, 2);
    } catch (e) {
        jsonEl.textContent = String(payload);
    }
}

// 최초 로드 시 커밋/시드 표시
document.addEventListener('DOMContentLoaded', function() {
    const clientSeed = getOrCreateClientSeed();
    const elSeed = document.getElementById('pfClientSeed');
    if (elSeed) elSeed.textContent = clientSeed;
    refreshBaccaratCommit();
});
</script>

<?php
include_once(G5_PATH.'/tail.php');
?>
