<!-- 설정 모달 -->
<div class="profile-modal" id="settingsModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            설정
        </div>
        <button class="profile-modal-close" onclick="closeProfileModal()">✕</button>
    </div>
    <div class="profile-modal-body">
        <div class="settings-section">
            <div class="settings-title">알림 설정</div>
            <div class="settings-item">
                <div class="settings-item-info">
                    <span class="settings-item-label">댓글 알림</span>
                    <span class="settings-item-desc">내 글에 댓글이 달리면 알림</span>
                </div>
                <label class="settings-toggle">
                    <input type="checkbox" checked>
                    <span class="settings-toggle-slider"></span>
                </label>
            </div>
            <div class="settings-item">
                <div class="settings-item-info">
                    <span class="settings-item-label">추천 알림</span>
                    <span class="settings-item-desc">내 글이 추천받으면 알림</span>
                </div>
                <label class="settings-toggle">
                    <input type="checkbox" checked>
                    <span class="settings-toggle-slider"></span>
                </label>
            </div>
            <div class="settings-item">
                <div class="settings-item-info">
                    <span class="settings-item-label">쪽지 알림</span>
                    <span class="settings-item-desc">새 쪽지가 오면 알림</span>
                </div>
                <label class="settings-toggle">
                    <input type="checkbox" checked>
                    <span class="settings-toggle-slider"></span>
                </label>
            </div>
            <div class="settings-item">
                <div class="settings-item-info">
                    <span class="settings-item-label">이벤트 알림</span>
                    <span class="settings-item-desc">이벤트 및 공지사항 알림</span>
                </div>
                <label class="settings-toggle">
                    <input type="checkbox">
                    <span class="settings-toggle-slider"></span>
                </label>
            </div>
        </div>
        <div class="settings-section">
            <div class="settings-title">개인정보 설정</div>
            <div class="settings-item">
                <div class="settings-item-info">
                    <span class="settings-item-label">프로필 공개</span>
                    <span class="settings-item-desc">다른 사용자에게 프로필 공개</span>
                </div>
                <label class="settings-toggle">
                    <input type="checkbox" checked>
                    <span class="settings-toggle-slider"></span>
                </label>
            </div>
            <div class="settings-item">
                <div class="settings-item-info">
                    <span class="settings-item-label">활동 내역 공개</span>
                    <span class="settings-item-desc">작성글/댓글 목록 공개</span>
                </div>
                <label class="settings-toggle">
                    <input type="checkbox">
                    <span class="settings-toggle-slider"></span>
                </label>
            </div>
            <div class="settings-item">
                <div class="settings-item-info">
                    <span class="settings-item-label">쪽지 수신 허용</span>
                    <span class="settings-item-desc">다른 사용자의 쪽지 수신</span>
                </div>
                <label class="settings-toggle">
                    <input type="checkbox" checked>
                    <span class="settings-toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeProfileModal()">닫기</button>
        <button class="profile-modal-btn primary">저장</button>
    </div>
</div>

<style>
/* 설정 모달 */
.settings-section {
    margin-bottom: 20px;
}
.settings-section:last-child {
    margin-bottom: 0;
}
.settings-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border);
}
.settings-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}
.settings-item:last-child {
    border-bottom: none;
}
.settings-item-info {
    flex: 1;
}
.settings-item-label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 2px;
}
.settings-item-desc {
    font-size: 11px;
    color: var(--text-light);
}

/* 토글 스위치 */
.settings-toggle {
    position: relative;
    width: 44px;
    height: 24px;
    cursor: pointer;
}
.settings-toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}
.settings-toggle-slider {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: var(--border);
    border-radius: 24px;
    transition: all 0.3s;
}
.settings-toggle-slider::before {
    content: '';
    position: absolute;
    width: 18px;
    height: 18px;
    left: 3px;
    bottom: 3px;
    background: white;
    border-radius: 50%;
    transition: all 0.3s;
}
.settings-toggle input:checked + .settings-toggle-slider {
    background: var(--accent);
}
.settings-toggle input:checked + .settings-toggle-slider::before {
    transform: translateX(20px);
}
</style>
