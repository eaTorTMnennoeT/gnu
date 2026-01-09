<!-- 스크랩 모달 -->
<div class="profile-modal" id="scrapModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
            스크랩
        </div>
        <button class="profile-modal-close" onclick="closeProfileModal()">✕</button>
    </div>
    <div class="profile-modal-body">
        <div class="scrap-summary">
            <span>총 <strong>23</strong>개의 스크랩</span>
        </div>
        <div class="scrap-list" id="scrapList">
            <!-- JS로 렌더링 -->
        </div>
        <div class="scrap-pagination" id="scrapPagination">
            <!-- JS로 렌더링 -->
        </div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeProfileModal()">닫기</button>
    </div>
</div>

<script>
// 스크랩 데이터
const scrapData = [
    { id: 1, title: '2025년 웹 트렌드 전망', category: '정보', date: '2025.01.07', author: '테크마니아' },
    { id: 2, title: '무료 아이콘 사이트 모음', category: '정보', date: '2025.01.06', author: '디자이너' },
    { id: 3, title: '서버 보안 체크리스트', category: '정보', date: '2025.01.04', author: '보안전문가' },
    { id: 4, title: 'CSS 애니메이션 예제', category: '정보', date: '2025.01.02', author: '프론트엔드' },
    { id: 5, title: '카페 추천 모음', category: '일상', date: '2024.12.30', author: '카페탐방' },
];

let scrapPage = 1;
const SCRAP_PER_PAGE = 3;

function renderScrapList() {
    const data = scrapData;
    const totalPages = Math.ceil(data.length / SCRAP_PER_PAGE);
    const start = (scrapPage - 1) * SCRAP_PER_PAGE;
    const end = start + SCRAP_PER_PAGE;
    const pageData = data.slice(start, end);

    document.getElementById('scrapList').innerHTML = pageData.map(item => `
        <div class="scrap-item" onclick="location.href='view.php?id=${item.id}'">
            <div class="scrap-item-top">
                <span class="scrap-category">${item.category}</span>
                <span class="scrap-date">${item.date}</span>
            </div>
            <div class="scrap-title">${item.title}</div>
            <div class="scrap-meta">
                <span>작성자: ${item.author}</span>
            </div>
        </div>
    `).join('');

    let paginationHtml = `
        <button class="stat-page-btn" onclick="setScrapPage(${scrapPage - 1})" ${scrapPage === 1 ? 'disabled' : ''}>‹</button>
    `;
    for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `<button class="stat-page-btn ${i === scrapPage ? 'active' : ''}" onclick="setScrapPage(${i})">${i}</button>`;
    }
    paginationHtml += `
        <button class="stat-page-btn" onclick="setScrapPage(${scrapPage + 1})" ${scrapPage === totalPages ? 'disabled' : ''}>›</button>
    `;
    document.getElementById('scrapPagination').innerHTML = paginationHtml;
}

function setScrapPage(page) {
    const totalPages = Math.ceil(scrapData.length / SCRAP_PER_PAGE);
    if (page < 1 || page > totalPages) return;
    scrapPage = page;
    renderScrapList();
}

function initScrapModal() {
    scrapPage = 1;
    renderScrapList();
}
</script>

<style>
/* 스크랩 모달 */
.scrap-summary {
    font-size: 13px;
    color: var(--text-secondary);
    margin-bottom: 14px;
}
.scrap-summary strong {
    color: var(--accent);
}

.scrap-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 16px;
}
.scrap-item {
    padding: 14px;
    background: var(--bg-main);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}
.scrap-item:hover {
    background: rgba(233, 69, 96, 0.1);
}
.scrap-item-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}
.scrap-category {
    font-size: 11px;
    padding: 2px 8px;
    background: rgba(99, 102, 241, 0.1);
    color: #6366f1;
    border-radius: 4px;
    font-weight: 600;
}
.scrap-date {
    font-size: 11px;
    color: var(--text-light);
}
.scrap-title {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.scrap-meta {
    display: flex;
    gap: 12px;
    font-size: 11px;
    color: var(--text-light);
}
.scrap-pagination {
    display: flex;
    justify-content: center;
    gap: 4px;
}
</style>
