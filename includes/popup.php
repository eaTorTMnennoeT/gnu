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
                <div class="stat-summary-label">보유</div>
                <div class="stat-summary-value cash">125,000</div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">획득</div>
                <div class="stat-summary-value" style="color: #10b981;">+95,500</div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">사용</div>
                <div class="stat-summary-value" style="color: var(--accent);">-31,000</div>
            </div>
        </div>
        <div class="stat-history-title">최근 내역</div>
        <div class="stat-history-list" id="cashHistoryList">
            <!-- JS로 렌더링 -->
        </div>
        <div class="stat-pagination" id="cashPagination">
            <!-- JS로 렌더링 -->
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
                <div class="stat-summary-label">보유</div>
                <div class="stat-summary-value point">89,450</div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">획득</div>
                <div class="stat-summary-value" style="color: var(--gold);">+11,060</div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">사용</div>
                <div class="stat-summary-value" style="color: var(--accent);">-10,000</div>
            </div>
        </div>
        <div class="stat-history-title">최근 내역</div>
        <div class="stat-history-list" id="pointHistoryList">
            <!-- JS로 렌더링 -->
        </div>
        <div class="stat-pagination" id="pointPagination">
            <!-- JS로 렌더링 -->
        </div>
    </div>
    <div class="stat-popup-footer">
        <button class="stat-popup-btn secondary" onclick="closeStatPopup()">닫기</button>
        <button class="stat-popup-btn primary">포인트 전환</button>
    </div>
</div>

<script>
// 캐시 내역 데이터
const cashHistory = [
    { desc: '캐시 충전', date: '2025.01.09 14:32', amount: '+50,000', type: 'plus' },
    { desc: '프리미엄 이용권 구매', date: '2025.01.08 09:15', amount: '-15,000', type: 'minus' },
    { desc: '게시글 후원', date: '2025.01.07 18:42', amount: '-5,000', type: 'minus' },
    { desc: '출석 보너스', date: '2025.01.06 00:05', amount: '+500', type: 'plus' },
    { desc: '이벤트 당첨', date: '2025.01.05 12:00', amount: '+10,000', type: 'plus' },
    { desc: '캐시 충전', date: '2025.01.04 10:20', amount: '+30,000', type: 'plus' },
    { desc: '아이템 구매', date: '2025.01.03 15:45', amount: '-8,000', type: 'minus' },
    { desc: '친구 추천 보너스', date: '2025.01.02 09:00', amount: '+5,000', type: 'plus' },
    { desc: '게시글 후원', date: '2025.01.01 20:30', amount: '-3,000', type: 'minus' },
    { desc: '신년 이벤트', date: '2025.01.01 00:00', amount: '+20,000', type: 'plus' },
];

// 포인트 내역 데이터
const pointHistory = [
    { desc: '게시글 작성', date: '2025.01.09 15:20', amount: '+100', type: 'plus' },
    { desc: '댓글 작성', date: '2025.01.09 14:55', amount: '+10', type: 'plus' },
    { desc: '베스트 게시글 선정', date: '2025.01.08 10:00', amount: '+500', type: 'plus' },
    { desc: '출석 체크', date: '2025.01.08 08:30', amount: '+50', type: 'plus' },
    { desc: '포인트 → 캐시 전환', date: '2025.01.07 16:00', amount: '-10,000', type: 'minus' },
    { desc: '게시글 작성', date: '2025.01.07 11:20', amount: '+100', type: 'plus' },
    { desc: '추천 받음', date: '2025.01.06 18:30', amount: '+50', type: 'plus' },
    { desc: '출석 체크', date: '2025.01.06 09:15', amount: '+50', type: 'plus' },
    { desc: '댓글 작성', date: '2025.01.05 22:00', amount: '+10', type: 'plus' },
    { desc: '베스트 댓글 선정', date: '2025.01.05 14:00', amount: '+200', type: 'plus' },
];

const ITEMS_PER_PAGE = 3;
let cashCurrentPage = 1;
let pointCurrentPage = 1;

function renderHistory(data, listId, paginationId, currentPage, setPageFn) {
    const totalPages = Math.ceil(data.length / ITEMS_PER_PAGE);
    const start = (currentPage - 1) * ITEMS_PER_PAGE;
    const end = start + ITEMS_PER_PAGE;
    const pageData = data.slice(start, end);

    // 내역 렌더링
    document.getElementById(listId).innerHTML = pageData.map(item => `
        <div class="stat-history-item">
            <div class="stat-history-info">
                <span class="stat-history-desc">${item.desc}</span>
                <span class="stat-history-date">${item.date}</span>
            </div>
            <span class="stat-history-amount ${item.type}">${item.amount}</span>
        </div>
    `).join('');

    // 페이징 렌더링
    let paginationHtml = `
        <button class="stat-page-btn" onclick="${setPageFn}(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>‹</button>
    `;

    for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `<button class="stat-page-btn ${i === currentPage ? 'active' : ''}" onclick="${setPageFn}(${i})">${i}</button>`;
    }

    paginationHtml += `
        <button class="stat-page-btn" onclick="${setPageFn}(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>›</button>
    `;

    document.getElementById(paginationId).innerHTML = paginationHtml;
}

function setCashPage(page) {
    const totalPages = Math.ceil(cashHistory.length / ITEMS_PER_PAGE);
    if (page < 1 || page > totalPages) return;
    cashCurrentPage = page;
    renderHistory(cashHistory, 'cashHistoryList', 'cashPagination', cashCurrentPage, 'setCashPage');
}

function setPointPage(page) {
    const totalPages = Math.ceil(pointHistory.length / ITEMS_PER_PAGE);
    if (page < 1 || page > totalPages) return;
    pointCurrentPage = page;
    renderHistory(pointHistory, 'pointHistoryList', 'pointPagination', pointCurrentPage, 'setPointPage');
}

// 초기 렌더링
renderHistory(cashHistory, 'cashHistoryList', 'cashPagination', cashCurrentPage, 'setCashPage');
renderHistory(pointHistory, 'pointHistoryList', 'pointPagination', pointCurrentPage, 'setPointPage');
</script>

<!-- 프로필 모달 오버레이 -->
<div class="profile-modal-overlay" id="profileModalOverlay"></div>

<!-- 개별 모달 파일 include -->
<?php include 'modal_myinfo.php'; ?>
<?php include 'modal_myposts.php'; ?>
<?php include 'modal_scrap.php'; ?>
<?php include 'modal_settings.php'; ?>
<?php include 'modal_message.php'; ?>

<script>
// 프로필 모달 공통 함수
function openProfileModal(type) {
    // 드롭다운 닫기
    document.getElementById('profileDropdown')?.classList.remove('show');
    document.getElementById('mobileBottomsheet')?.classList.remove('show');
    document.getElementById('dropdownOverlay')?.classList.remove('active');

    const overlay = document.getElementById('profileModalOverlay');
    const modal = document.getElementById(type + 'Modal');

    if (overlay && modal) {
        overlay.classList.add('active');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';

        // 각 모달별 초기화 함수 호출
        if (type === 'myposts' && typeof initMyPostsModal === 'function') {
            initMyPostsModal();
        } else if (type === 'scrap' && typeof initScrapModal === 'function') {
            initScrapModal();
        } else if (type === 'message' && typeof initMessageModal === 'function') {
            initMessageModal();
        }
    }
}

function closeProfileModal() {
    document.getElementById('profileModalOverlay')?.classList.remove('active');
    document.querySelectorAll('.profile-modal').forEach(m => m.classList.remove('active'));
    document.body.style.overflow = '';
}

// 오버레이 클릭시 닫기
document.getElementById('profileModalOverlay')?.addEventListener('click', closeProfileModal);
</script>

<style>
/* 프로필 모달 공통 스타일 */
.profile-modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.7);
    z-index: 10001;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}
.profile-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.profile-modal {
    position: fixed;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%) scale(0.9);
    width: 90%;
    max-width: 480px;
    max-height: 85vh;
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    z-index: 10002;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.profile-modal.active {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1);
}

.profile-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
}
.profile-modal-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
}
.profile-modal-title svg {
    width: 20px;
    height: 20px;
    color: var(--accent);
}
.profile-modal-close {
    width: 32px; height: 32px;
    border: none;
    background: var(--bg-main);
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.profile-modal-close:hover {
    background: var(--accent);
    color: white;
}

.profile-modal-body {
    padding: 20px;
    overflow-y: auto;
    flex: 1;
}

.profile-modal-footer {
    display: flex;
    gap: 10px;
    padding: 16px 20px;
    border-top: 1px solid var(--border);
    flex-shrink: 0;
}
.profile-modal-btn {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.profile-modal-btn.secondary {
    background: var(--bg-main);
    border: 1px solid var(--border);
    color: var(--text-secondary);
}
.profile-modal-btn.secondary:hover {
    border-color: var(--accent);
    color: var(--accent);
}
.profile-modal-btn.primary {
    background: linear-gradient(135deg, var(--accent), #ff6b6b);
    border: none;
    color: white;
}
.profile-modal-btn.primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px var(--accent-glow);
}

@media (max-width: 480px) {
    .profile-modal {
        width: 95%;
        max-height: 90vh;
    }
}
</style>
