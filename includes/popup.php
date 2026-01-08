<!-- 캐시 팝업 -->
<div class="stat-popup-overlay" id="statPopupOverlay"></div>
<div class="stat-popup" id="cashPopup">
    <div class="stat-popup-header">
        <div class="stat-popup-title">
            <div class="stat-popup-title-icon cash">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            캐시 내역
        </div>
        <button class="stat-popup-close" onclick="closeStatPopup()">✕</button>
    </div>
    <div class="stat-popup-body">
        <div class="stat-summary">
            <div class="stat-summary-item">
                <div class="stat-summary-label">보유 캐시</div>
                <div class="stat-summary-value cash">125,000</div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">이번 달 사용</div>
                <div class="stat-summary-value">32,500</div>
            </div>
        </div>
        <div class="stat-history-title">최근 내역</div>
        <div class="stat-history-list">
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">캐시 충전</span>
                    <span class="stat-history-date">2025.01.09 14:32</span>
                </div>
                <span class="stat-history-amount plus">+50,000</span>
            </div>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">프리미엄 이용권 구매</span>
                    <span class="stat-history-date">2025.01.08 09:15</span>
                </div>
                <span class="stat-history-amount minus">-15,000</span>
            </div>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">게시글 후원</span>
                    <span class="stat-history-date">2025.01.07 18:42</span>
                </div>
                <span class="stat-history-amount minus">-5,000</span>
            </div>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">출석 보너스</span>
                    <span class="stat-history-date">2025.01.06 00:05</span>
                </div>
                <span class="stat-history-amount plus">+500</span>
            </div>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">이벤트 당첨</span>
                    <span class="stat-history-date">2025.01.05 12:00</span>
                </div>
                <span class="stat-history-amount plus">+10,000</span>
            </div>
        </div>
    </div>
    <div class="stat-popup-footer">
        <button class="stat-popup-btn secondary" onclick="closeStatPopup()">닫기</button>
        <button class="stat-popup-btn primary">캐시 충전</button>
    </div>
</div>

<!-- 포인트 팝업 -->
<div class="stat-popup" id="pointPopup">
    <div class="stat-popup-header">
        <div class="stat-popup-title">
            <div class="stat-popup-title-icon point">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
            </div>
            포인트 내역
        </div>
        <button class="stat-popup-close" onclick="closeStatPopup()">✕</button>
    </div>
    <div class="stat-popup-body">
        <div class="stat-summary">
            <div class="stat-summary-item">
                <div class="stat-summary-label">보유 포인트</div>
                <div class="stat-summary-value point">89,450</div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">이번 달 적립</div>
                <div class="stat-summary-value">12,350</div>
            </div>
        </div>
        <div class="stat-history-title">최근 내역</div>
        <div class="stat-history-list">
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">게시글 작성</span>
                    <span class="stat-history-date">2025.01.09 15:20</span>
                </div>
                <span class="stat-history-amount plus">+100</span>
            </div>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">댓글 작성</span>
                    <span class="stat-history-date">2025.01.09 14:55</span>
                </div>
                <span class="stat-history-amount plus">+10</span>
            </div>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">베스트 게시글 선정</span>
                    <span class="stat-history-date">2025.01.08 10:00</span>
                </div>
                <span class="stat-history-amount plus">+500</span>
            </div>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">출석 체크</span>
                    <span class="stat-history-date">2025.01.08 08:30</span>
                </div>
                <span class="stat-history-amount plus">+50</span>
            </div>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc">포인트 → 캐시 전환</span>
                    <span class="stat-history-date">2025.01.07 16:00</span>
                </div>
                <span class="stat-history-amount minus">-10,000</span>
            </div>
        </div>
    </div>
    <div class="stat-popup-footer">
        <button class="stat-popup-btn secondary" onclick="closeStatPopup()">닫기</button>
        <button class="stat-popup-btn primary">포인트 전환</button>
    </div>
</div>
