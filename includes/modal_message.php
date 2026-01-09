<!-- 쪽지함 모달 -->
<div class="profile-modal profile-modal-lg" id="messageModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            쪽지함
            <span class="message-unread-badge" id="messageUnreadBadge">3</span>
        </div>
        <button class="profile-modal-close" onclick="closeProfileModal()">✕</button>
    </div>
    <div class="message-tabs">
        <button class="message-tab active" onclick="switchMessageTab('received')">받은 쪽지</button>
        <button class="message-tab" onclick="switchMessageTab('sent')">보낸 쪽지</button>
    </div>
    <div class="profile-modal-body">
        <div class="message-list" id="messageList">
            <!-- JS로 렌더링 -->
        </div>
        <div class="message-pagination" id="messagePagination">
            <!-- JS로 렌더링 -->
        </div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeProfileModal()">닫기</button>
        <button class="profile-modal-btn primary" onclick="openNewMessage()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;margin-right:4px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            쪽지 쓰기
        </button>
    </div>
</div>

<!-- 쪽지 보기 모달 -->
<div class="profile-modal" id="messageViewModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            쪽지 보기
        </div>
        <button class="profile-modal-close" onclick="closeMessageView()">✕</button>
    </div>
    <div class="profile-modal-body">
        <div class="message-view-header">
            <div class="message-view-sender" id="messageViewSender"></div>
            <div class="message-view-date" id="messageViewDate"></div>
        </div>
        <div class="message-view-content" id="messageViewContent"></div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeMessageView()">목록으로</button>
        <button class="profile-modal-btn primary" onclick="replyMessage()">답장</button>
    </div>
</div>

<!-- 쪽지 쓰기 모달 -->
<div class="profile-modal" id="messageWriteModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            쪽지 쓰기
        </div>
        <button class="profile-modal-close" onclick="closeMessageWrite()">✕</button>
    </div>
    <div class="profile-modal-body">
        <div class="message-write-form">
            <div class="message-form-group">
                <label>받는 사람</label>
                <input type="text" id="messageRecipient" class="message-input" placeholder="닉네임을 입력하세요">
            </div>
            <div class="message-form-group">
                <label>내용</label>
                <textarea id="messageContent" class="message-textarea" placeholder="쪽지 내용을 입력하세요"></textarea>
            </div>
        </div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeMessageWrite()">취소</button>
        <button class="profile-modal-btn primary" onclick="sendMessage()">보내기</button>
    </div>
</div>

<script>
// 받은 쪽지 데이터
const receivedMessages = [
    { id: 1, sender: '헬스마니아', content: '안녕하세요! 게시글 잘 봤습니다. 혹시 테마 설치 방법 좀 더 자세히 알려주실 수 있나요?', date: '2025.01.09 14:30', read: false },
    { id: 2, sender: '테크마니아', content: '공유해주신 정보 감사합니다! 덕분에 많은 도움이 됐어요.', date: '2025.01.09 10:15', read: false },
    { id: 3, sender: '관리자', content: '축하합니다! 이번 주 베스트 게시글로 선정되셨습니다. 보상 포인트가 지급되었습니다.', date: '2025.01.08 18:00', read: false },
    { id: 4, sender: '디자이너', content: '혹시 사용하신 색상 코드 공유 가능할까요?', date: '2025.01.08 09:45', read: true },
    { id: 5, sender: '초보개발자', content: '답변 감사합니다! 덕분에 해결했어요 ㅎㅎ', date: '2025.01.07 22:30', read: true },
];

// 보낸 쪽지 데이터
const sentMessages = [
    { id: 1, recipient: '헬스마니아', content: '네, 설치 방법은 README 파일을 참고해주세요. 추가 질문 있으시면 말씀해주세요!', date: '2025.01.09 15:00' },
    { id: 2, recipient: '초보개발자', content: 'config.php 파일에서 DB 설정을 확인해보세요. 보통 그 부분에서 오류가 나더라고요.', date: '2025.01.07 20:15' },
    { id: 3, recipient: '관리자', content: '감사합니다! 앞으로도 좋은 콘텐츠로 찾아뵙겠습니다.', date: '2025.01.06 12:30' },
];

let currentMessageTab = 'received';
let messagePage = 1;
const MESSAGE_PER_PAGE = 3;
let currentViewingMessage = null;

function switchMessageTab(tab) {
    currentMessageTab = tab;
    messagePage = 1;

    document.querySelectorAll('.message-tab').forEach(t => t.classList.remove('active'));
    document.querySelector(`.message-tab:${tab === 'received' ? 'first' : 'last'}-child`).classList.add('active');

    renderMessageList();
}

function renderMessageList() {
    const data = currentMessageTab === 'received' ? receivedMessages : sentMessages;
    const totalPages = Math.ceil(data.length / MESSAGE_PER_PAGE);
    const start = (messagePage - 1) * MESSAGE_PER_PAGE;
    const end = start + MESSAGE_PER_PAGE;
    const pageData = data.slice(start, end);

    const isReceived = currentMessageTab === 'received';

    document.getElementById('messageList').innerHTML = pageData.map(item => `
        <div class="message-item ${isReceived && !item.read ? 'unread' : ''}" onclick="viewMessage(${item.id}, '${currentMessageTab}')">
            <div class="message-item-top">
                <span class="message-sender">${isReceived ? item.sender : item.recipient}</span>
                <span class="message-date">${item.date}</span>
            </div>
            <div class="message-preview">${item.content}</div>
            ${isReceived && !item.read ? '<span class="message-new-dot"></span>' : ''}
        </div>
    `).join('');

    let paginationHtml = '';
    if (totalPages > 1) {
        paginationHtml = `
            <button class="stat-page-btn" onclick="setMessagePage(${messagePage - 1})" ${messagePage === 1 ? 'disabled' : ''}>‹</button>
        `;
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `<button class="stat-page-btn ${i === messagePage ? 'active' : ''}" onclick="setMessagePage(${i})">${i}</button>`;
        }
        paginationHtml += `
            <button class="stat-page-btn" onclick="setMessagePage(${messagePage + 1})" ${messagePage === totalPages ? 'disabled' : ''}>›</button>
        `;
    }
    document.getElementById('messagePagination').innerHTML = paginationHtml;
}

function setMessagePage(page) {
    const data = currentMessageTab === 'received' ? receivedMessages : sentMessages;
    const totalPages = Math.ceil(data.length / MESSAGE_PER_PAGE);
    if (page < 1 || page > totalPages) return;
    messagePage = page;
    renderMessageList();
}

function viewMessage(id, tab) {
    const data = tab === 'received' ? receivedMessages : sentMessages;
    const message = data.find(m => m.id === id);
    if (!message) return;

    currentViewingMessage = message;

    // 읽음 처리
    if (tab === 'received' && !message.read) {
        message.read = true;
        updateUnreadBadge();
        renderMessageList();
    }

    const isReceived = tab === 'received';
    document.getElementById('messageViewSender').innerHTML = `
        <span class="message-view-label">${isReceived ? '보낸 사람' : '받는 사람'}</span>
        <span class="message-view-name">${isReceived ? message.sender : message.recipient}</span>
    `;
    document.getElementById('messageViewDate').textContent = message.date;
    document.getElementById('messageViewContent').textContent = message.content;

    document.getElementById('messageModal').classList.remove('active');
    document.getElementById('messageViewModal').classList.add('active');
}

function closeMessageView() {
    document.getElementById('messageViewModal').classList.remove('active');
    document.getElementById('messageModal').classList.add('active');
}

function openNewMessage(recipient = '') {
    document.getElementById('messageRecipient').value = recipient;
    document.getElementById('messageContent').value = '';
    document.getElementById('messageModal').classList.remove('active');
    document.getElementById('messageWriteModal').classList.add('active');
}

function closeMessageWrite() {
    document.getElementById('messageWriteModal').classList.remove('active');
    document.getElementById('messageModal').classList.add('active');
}

function replyMessage() {
    if (currentViewingMessage && currentMessageTab === 'received') {
        openNewMessage(currentViewingMessage.sender);
        document.getElementById('messageViewModal').classList.remove('active');
    }
}

function sendMessage() {
    const recipient = document.getElementById('messageRecipient').value.trim();
    const content = document.getElementById('messageContent').value.trim();

    if (!recipient) {
        alert('받는 사람을 입력해주세요.');
        return;
    }
    if (!content) {
        alert('내용을 입력해주세요.');
        return;
    }

    // 실제로는 서버로 전송
    alert('쪽지가 전송되었습니다.');
    closeMessageWrite();
}

function updateUnreadBadge() {
    const unreadCount = receivedMessages.filter(m => !m.read).length;
    const badge = document.getElementById('messageUnreadBadge');
    if (badge) {
        badge.textContent = unreadCount;
        badge.style.display = unreadCount > 0 ? 'inline-flex' : 'none';
    }
}

function initMessageModal() {
    currentMessageTab = 'received';
    messagePage = 1;
    document.querySelectorAll('.message-tab').forEach((t, i) => {
        t.classList.toggle('active', i === 0);
    });
    renderMessageList();
    updateUnreadBadge();
}
</script>

<style>
/* 쪽지함 모달 */
.profile-modal-lg {
    max-width: 520px;
}

.message-unread-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 6px;
    background: var(--accent);
    color: white;
    border-radius: 9px;
    font-size: 11px;
    font-weight: 700;
    margin-left: 8px;
}

.message-tabs {
    display: flex;
    border-bottom: 1px solid var(--border);
    padding: 0 20px;
}
.message-tab {
    flex: 1;
    padding: 14px 0;
    background: none;
    border: none;
    font-size: 14px;
    font-weight: 500;
    color: var(--text-light);
    cursor: pointer;
    position: relative;
    transition: all 0.2s;
}
.message-tab:hover {
    color: var(--text-primary);
}
.message-tab.active {
    color: var(--accent);
    font-weight: 600;
}
.message-tab.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 2px;
    background: var(--accent);
}

.message-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 16px;
}
.message-item {
    padding: 14px;
    background: var(--bg-main);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
}
.message-item:hover {
    background: rgba(233, 69, 96, 0.1);
}
.message-item.unread {
    background: rgba(99, 102, 241, 0.08);
    border-left: 3px solid #6366f1;
}
.message-item.unread:hover {
    background: rgba(99, 102, 241, 0.15);
}
.message-item-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}
.message-sender {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
}
.message-date {
    font-size: 11px;
    color: var(--text-light);
}
.message-preview {
    font-size: 13px;
    color: var(--text-secondary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.message-new-dot {
    position: absolute;
    top: 50%;
    right: 14px;
    transform: translateY(-50%);
    width: 8px;
    height: 8px;
    background: var(--accent);
    border-radius: 50%;
}
.message-pagination {
    display: flex;
    justify-content: center;
    gap: 4px;
}

/* 쪽지 보기 */
.message-view-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px;
    background: var(--bg-main);
    border-radius: 10px;
    margin-bottom: 16px;
}
.message-view-label {
    font-size: 11px;
    color: var(--text-light);
    display: block;
    margin-bottom: 2px;
}
.message-view-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}
.message-view-date {
    font-size: 12px;
    color: var(--text-light);
}
.message-view-content {
    padding: 16px;
    background: var(--bg-main);
    border-radius: 10px;
    font-size: 14px;
    line-height: 1.7;
    color: var(--text-primary);
    min-height: 150px;
    white-space: pre-wrap;
}

/* 쪽지 쓰기 */
.message-write-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.message-form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 6px;
}
.message-input {
    width: 100%;
    padding: 12px 14px;
    background: var(--bg-main);
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 14px;
    color: var(--text-primary);
    outline: none;
    transition: all 0.2s;
}
.message-input:focus {
    border-color: var(--accent);
}
.message-textarea {
    width: 100%;
    padding: 12px 14px;
    background: var(--bg-main);
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 14px;
    color: var(--text-primary);
    outline: none;
    transition: all 0.2s;
    resize: none;
    height: 180px;
    line-height: 1.6;
}
.message-textarea:focus {
    border-color: var(--accent);
}
.message-textarea::placeholder,
.message-input::placeholder {
    color: var(--text-light);
}
</style>
