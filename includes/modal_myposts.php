<!-- 내가 쓴 글 모달 -->
<div class="profile-modal" id="mypostsModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
            내가 쓴 글
        </div>
        <button class="profile-modal-close" onclick="closeProfileModal()">✕</button>
    </div>
    <div class="profile-modal-body">
        <div class="myposts-summary">
            <span>총 <strong>156</strong>개의 글</span>
        </div>
        <div class="myposts-list" id="mypostsList">
            <!-- JS로 렌더링 -->
        </div>
        <div class="myposts-pagination" id="mypostsPagination">
            <!-- JS로 렌더링 -->
        </div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeProfileModal()">닫기</button>
        <button class="profile-modal-btn primary" onclick="location.href='board.php'">게시판으로</button>
    </div>
</div>

<script>
// 내가 쓴 글 데이터
const myPostsData = [
    { id: 1, title: '그누보드 신규 테마 적용 후기입니다', category: '일상', date: '2025.01.08', views: 1523, comments: 15 },
    { id: 2, title: '새해 목표 공유해요', category: '일상', date: '2025.01.05', views: 892, comments: 32 },
    { id: 3, title: 'PHP 최적화 팁 정리', category: '정보', date: '2025.01.03', views: 2156, comments: 45 },
    { id: 4, title: '맛집 추천 받습니다', category: '일상', date: '2024.12.28', views: 567, comments: 23 },
    { id: 5, title: '연말 회고록', category: '일상', date: '2024.12.25', views: 1234, comments: 18 },
    { id: 6, title: '크리스마스 이벤트 후기', category: '일상', date: '2024.12.26', views: 890, comments: 12 },
];

let myPostsPage = 1;
const MYPOSTS_PER_PAGE = 3;

function renderMyPostsList() {
    const data = myPostsData;
    const totalPages = Math.ceil(data.length / MYPOSTS_PER_PAGE);
    const start = (myPostsPage - 1) * MYPOSTS_PER_PAGE;
    const end = start + MYPOSTS_PER_PAGE;
    const pageData = data.slice(start, end);

    document.getElementById('mypostsList').innerHTML = pageData.map(item => `
        <div class="myposts-item" onclick="location.href='view.php?id=${item.id}'">
            <div class="myposts-item-top">
                <span class="myposts-category">${item.category}</span>
                <span class="myposts-date">${item.date}</span>
            </div>
            <div class="myposts-title">${item.title}</div>
            <div class="myposts-meta">
                <span>조회 ${item.views.toLocaleString()}</span>
                <span>댓글 ${item.comments}</span>
            </div>
        </div>
    `).join('');

    let paginationHtml = `
        <button class="stat-page-btn" onclick="setMyPostsPage(${myPostsPage - 1})" ${myPostsPage === 1 ? 'disabled' : ''}>‹</button>
    `;
    for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `<button class="stat-page-btn ${i === myPostsPage ? 'active' : ''}" onclick="setMyPostsPage(${i})">${i}</button>`;
    }
    paginationHtml += `
        <button class="stat-page-btn" onclick="setMyPostsPage(${myPostsPage + 1})" ${myPostsPage === totalPages ? 'disabled' : ''}>›</button>
    `;
    document.getElementById('mypostsPagination').innerHTML = paginationHtml;
}

function setMyPostsPage(page) {
    const totalPages = Math.ceil(myPostsData.length / MYPOSTS_PER_PAGE);
    if (page < 1 || page > totalPages) return;
    myPostsPage = page;
    renderMyPostsList();
}

function initMyPostsModal() {
    myPostsPage = 1;
    renderMyPostsList();
}
</script>

<style>
/* 내가 쓴 글 모달 */
.myposts-summary {
    font-size: 13px;
    color: var(--text-secondary);
    margin-bottom: 14px;
}
.myposts-summary strong {
    color: var(--accent);
}

.myposts-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 16px;
}
.myposts-item {
    padding: 14px;
    background: var(--bg-main);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}
.myposts-item:hover {
    background: rgba(233, 69, 96, 0.1);
}
.myposts-item-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}
.myposts-category {
    font-size: 11px;
    padding: 2px 8px;
    background: rgba(99, 102, 241, 0.1);
    color: #6366f1;
    border-radius: 4px;
    font-weight: 600;
}
.myposts-date {
    font-size: 11px;
    color: var(--text-light);
}
.myposts-title {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.myposts-meta {
    display: flex;
    gap: 12px;
    font-size: 11px;
    color: var(--text-light);
}
.myposts-pagination {
    display: flex;
    justify-content: center;
    gap: 4px;
}
</style>
