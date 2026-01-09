<!-- 내 정보 모달 -->
<div class="profile-modal" id="myinfoModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            내 정보
        </div>
        <button class="profile-modal-close" onclick="closeProfileModal()">✕</button>
    </div>
    <div class="profile-modal-body">
        <div class="myinfo-profile">
            <div class="myinfo-avatar">
                <div class="myinfo-level">7</div>
                <div class="myinfo-level-badge"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg></div>
            </div>
            <div class="myinfo-details">
                <div class="myinfo-name">김철수 <span class="vip-badge">VIP</span></div>
                <div class="myinfo-email">user@example.com</div>
            </div>
        </div>
        <div class="myinfo-stats">
            <div class="myinfo-stat-item">
                <span class="myinfo-stat-label">가입일</span>
                <span class="myinfo-stat-value">2024.03.15</span>
            </div>
            <div class="myinfo-stat-item">
                <span class="myinfo-stat-label">게시글</span>
                <span class="myinfo-stat-value">156개</span>
            </div>
            <div class="myinfo-stat-item">
                <span class="myinfo-stat-label">댓글</span>
                <span class="myinfo-stat-value">1,234개</span>
            </div>
            <div class="myinfo-stat-item">
                <span class="myinfo-stat-label">받은 추천</span>
                <span class="myinfo-stat-value">5,678개</span>
            </div>
        </div>
        <div class="myinfo-form">
            <div class="myinfo-form-group">
                <label>닉네임</label>
                <input type="text" value="김철수" class="myinfo-input">
            </div>
            <div class="myinfo-form-group">
                <label>이메일</label>
                <input type="email" value="user@example.com" class="myinfo-input" readonly>
            </div>
            <div class="myinfo-form-group">
                <label>비밀번호</label>
                <button class="myinfo-btn-change">비밀번호 변경</button>
            </div>
        </div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeProfileModal()">닫기</button>
        <button class="profile-modal-btn primary">저장</button>
    </div>
</div>

<style>
/* 내 정보 모달 */
.myinfo-profile {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: var(--bg-main);
    border-radius: 12px;
    margin-bottom: 16px;
}
.myinfo-avatar {
    width: 60px; height: 60px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    flex-shrink: 0;
}
.myinfo-level {
    font-size: 20px;
    font-weight: 800;
    color: white;
}
.myinfo-level-badge {
    position: absolute;
    bottom: -2px; right: -2px;
    width: 22px; height: 22px;
    background: var(--accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--bg-card);
}
.myinfo-level-badge svg {
    width: 12px;
    height: 12px;
    color: white;
}
.myinfo-details {
    flex: 1;
}
.myinfo-name {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.vip-badge {
    font-size: 10px;
    padding: 2px 6px;
    background: linear-gradient(135deg, var(--gold), #f4d03f);
    color: var(--primary);
    border-radius: 4px;
    font-weight: 700;
}
.myinfo-email {
    font-size: 13px;
    color: var(--text-light);
}

.myinfo-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}
.myinfo-stat-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 14px;
    background: var(--bg-main);
    border-radius: 10px;
}
.myinfo-stat-label {
    font-size: 12px;
    color: var(--text-light);
}
.myinfo-stat-value {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
}

.myinfo-form-group {
    margin-bottom: 14px;
}
.myinfo-form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 6px;
}
.myinfo-input {
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
.myinfo-input:focus {
    border-color: var(--accent);
}
.myinfo-input[readonly] {
    opacity: 0.6;
    cursor: not-allowed;
}
.myinfo-btn-change {
    padding: 10px 16px;
    background: var(--bg-main);
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 13px;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
}
.myinfo-btn-change:hover {
    border-color: var(--accent);
    color: var(--accent);
}

@media (max-width: 480px) {
    .myinfo-stats {
        grid-template-columns: 1fr;
    }
}
</style>
