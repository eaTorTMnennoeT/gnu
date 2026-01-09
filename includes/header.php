<!-- 헤더 -->
<header class="header">
    <div class="header-left">
        <button class="menu-toggle" id="menuToggle"><span></span><span></span><span></span></button>
        <div class="search-box">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" placeholder="검색어를 입력하세요...">
        </div>
    </div>
    <div class="header-right">
        <div class="theme-toggle-wrap">
            <button class="theme-toggle" id="themeToggle">
                <span class="theme-label light">라이트</span>
                <span class="theme-label dark">다크</span>
                <span class="theme-slider"></span>
            </button>
        </div>
        <div class="user-stats">
            <div class="stat-item" id="cashStatItem">
                <svg class="stat-item-icon cash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                <span class="stat-item-value">125,000</span>
                <span class="stat-item-label">캐시</span>
            </div>
            <div class="stat-item" id="pointStatItem">
                <svg class="stat-item-icon point" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                <span class="stat-item-value">89,450</span>
                <span class="stat-item-label">포인트</span>
            </div>
        </div>
        <div class="notification-wrapper">
            <button class="header-btn" id="notificationBtn" type="button">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                <span class="notification-dot"></span>
            </button>
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="noti-header">
                    <span class="noti-title">알림</span>
                    <button class="noti-read-all" onclick="markAllRead()">모두 읽음</button>
                </div>
                <div class="noti-list">
                    <div class="noti-item unread" onclick="goToNoti(1)">
                        <div class="noti-icon comment">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        </div>
                        <div class="noti-content">
                            <p class="noti-text"><strong>댓글러1</strong>님이 회원님의 글에 댓글을 남겼습니다.</p>
                            <span class="noti-time">5분 전</span>
                        </div>
                    </div>
                    <div class="noti-item unread" onclick="goToNoti(2)">
                        <div class="noti-icon like">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                        </div>
                        <div class="noti-content">
                            <p class="noti-text"><strong>익명사용자</strong>님이 회원님의 글을 추천했습니다.</p>
                            <span class="noti-time">32분 전</span>
                        </div>
                    </div>
                    <div class="noti-item" onclick="goToNoti(3)">
                        <div class="noti-icon system">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <div class="noti-content">
                            <p class="noti-text">출석 체크 보상 <strong>100P</strong>가 지급되었습니다.</p>
                            <span class="noti-time">1시간 전</span>
                        </div>
                    </div>
                    <div class="noti-item" onclick="goToNoti(4)">
                        <div class="noti-icon point">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                        </div>
                        <div class="noti-content">
                            <p class="noti-text">글 작성 보상 <strong>50P</strong>가 지급되었습니다.</p>
                            <span class="noti-time">3시간 전</span>
                        </div>
                    </div>
                </div>
                <a href="#" class="noti-more">전체 알림 보기</a>
            </div>
        </div>
        <div class="profile-wrapper">
            <div class="user-profile-header" id="profileBtn">
                <div class="user-level">
                    <span class="user-level-number">7</span>
                    <div class="user-level-badge"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg></div>
                </div>
                <div class="user-info-header">
                    <span class="user-nickname">김철수 <span class="vip">VIP</span></span>
                    <span class="user-level-text">Lv.7 프리미엄</span>
                </div>
                <svg class="user-dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6,9 12,15 18,9"/></svg>
            </div>

            <!-- 프로필 드롭다운 -->
            <div class="profile-dropdown" id="profileDropdown">
                <div class="profile-dd-header">
                    <div class="profile-dd-avatar">
                        <div class="profile-dd-level">7</div>
                        <div class="profile-dd-level-badge"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg></div>
                    </div>
                    <div class="profile-dd-info">
                        <span class="profile-dd-name">김철수 <span class="vip">VIP</span></span>
                        <span class="profile-dd-email">user@example.com</span>
                    </div>
                </div>

                <!-- 레벨 진행 섹션 -->
                <div class="profile-dd-level-section">
                    <div class="level-progress-header">
                        <span class="level-current">Lv.7 프리미엄</span>
                        <span class="level-next">Lv.8까지</span>
                    </div>
                    <div class="level-progress-bar">
                        <div class="level-progress-fill" style="width: 68%"></div>
                    </div>
                    <div class="level-progress-info">
                        <span class="level-progress-text">214,450 / 315,000</span>
                        <span class="level-progress-percent">68%</span>
                    </div>
                    <div class="level-need-info">
                        <div class="level-need-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            <span>캐시: <strong>125,000</strong></span>
                        </div>
                        <span class="level-need-plus">+</span>
                        <div class="level-need-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                            <span>포인트: <strong>89,450</strong></span>
                        </div>
                    </div>
                    <div class="level-remaining">
                        <span>레벨업까지 <strong class="accent">100,550</strong> 필요</span>
                    </div>
                </div>

                <!-- 메뉴 -->
                <div class="profile-dd-menu">
                    <a href="#" class="profile-dd-menu-item" data-modal="myinfo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>내 정보</span>
                    </a>
                    <a href="#" class="profile-dd-menu-item" data-modal="myposts">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                        <span>내가 쓴 글</span>
                    </a>
                    <a href="#" class="profile-dd-menu-item" data-modal="scrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                        <span>스크랩</span>
                    </a>
                    <a href="#" class="profile-dd-menu-item" data-modal="message">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span>쪽지함</span>
                        <span class="menu-badge">3</span>
                    </a>
                    <a href="#" class="profile-dd-menu-item" data-modal="settings">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                        <span>설정</span>
                    </a>
                </div>

                <div class="profile-dd-footer">
                    <a href="#" class="profile-dd-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        <span>로그아웃</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="dropdown-overlay" id="dropdownOverlay"></div>

<!-- 모바일 바텀시트 (body 레벨) -->
<div class="mobile-bottomsheet" id="mobileBottomsheet">
    <div class="bottomsheet-handle"></div>
    <div class="bottomsheet-content" id="bottomsheetContent"></div>
</div>
