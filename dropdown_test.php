<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Dropdown PHP Test</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 240px;
            --header-height: 64px;
            --primary: #1a1a2e;
            --primary-light: #16213e;
            --accent: #e94560;
            --accent-glow: rgba(233, 69, 96, 0.3);
            --gold: #d4af37;
            --bg-main: #f0f2f5;
            --bg-card: #ffffff;
            --bg-header: rgba(255,255,255,0.95);
            --text-primary: #1a1a2e;
            --text-secondary: #6b7280;
            --text-light: #9ca3af;
            --border: #e5e7eb;
        }

        [data-theme="dark"] {
            --bg-main: #0d0d14;
            --bg-card: #1a1a2e;
            --bg-header: rgba(26,26,46,0.95);
            --text-primary: #f0f0f5;
            --text-secondary: #a0a0b0;
            --text-light: #6b6b80;
            --border: #2a2a40;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Noto Sans KR', sans-serif;
            background: var(--bg-main);
            color: var(--text-primary);
            min-height: 200vh;
            padding-top: 80px;
        }

        /* 헤더 */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: var(--bg-header);
            backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 16px;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            z-index: 100;
            border-bottom: 1px solid var(--border);
        }

        .header-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: none;
            background: var(--bg-main);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s;
        }

        .header-btn:hover { background: var(--border); }
        .header-btn svg { width: 16px; height: 16px; color: var(--text-secondary); }

        .notification-dot {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 7px;
            height: 7px;
            background: var(--accent);
            border-radius: 50%;
            border: 2px solid var(--bg-card);
        }

        /* 프로필 버튼 */
        .user-profile-header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 10px 5px 5px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-profile-header:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(26,26,46,0.3); }

        .user-level {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--gold) 0%, #f4d03f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 2px 6px rgba(212,175,55,0.4);
        }

        .user-level-number { font-size: 11px; font-weight: 800; color: var(--primary); }

        .user-level-badge {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid var(--primary);
        }

        .user-level-badge svg { width: 7px; height: 7px; color: white; }
        .user-info-header { display: flex; flex-direction: column; }
        .user-nickname { font-size: 11px; font-weight: 600; color: white; display: flex; align-items: center; gap: 4px; }

        .user-nickname .vip {
            font-size: 8px;
            background: linear-gradient(135deg, var(--gold) 0%, #f4d03f 100%);
            color: var(--primary);
            padding: 1px 4px;
            border-radius: 3px;
            font-weight: 700;
        }

        .user-level-text { font-size: 9px; color: rgba(255,255,255,0.6); }
        .user-dropdown-arrow { width: 14px; height: 14px; color: rgba(255,255,255,0.5); transition: transform 0.2s; }
        .user-profile-header:hover .user-dropdown-arrow { transform: rotate(180deg); }

        /* 알림 드롭다운 */
        .notification-wrapper {
            position: relative;
        }

        .notification-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 340px;
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2000;
            overflow: hidden;
        }

        .notification-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .noti-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 18px;
            border-bottom: 1px solid var(--border);
        }

        .noti-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .noti-read-all {
            font-size: 12px;
            color: var(--accent);
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }

        .noti-list {
            max-height: 320px;
            overflow-y: auto;
        }

        .noti-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 1px solid var(--border);
        }

        .noti-item:last-child { border-bottom: none; }
        .noti-item:hover { background: var(--bg-main); }
        .noti-item.unread { background: rgba(233, 69, 96, 0.05); }

        .noti-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .noti-icon svg { width: 16px; height: 16px; }
        .noti-icon.comment { background: rgba(99, 102, 241, 0.1); color: #6366f1; }
        .noti-icon.like { background: rgba(233, 69, 96, 0.1); color: var(--accent); }
        .noti-icon.system { background: rgba(16, 185, 129, 0.1); color: #10b981; }

        .noti-content { flex: 1; min-width: 0; }
        .noti-text { font-size: 13px; color: var(--text-primary); line-height: 1.5; margin-bottom: 4px; }
        .noti-text strong { font-weight: 600; color: var(--accent); }
        .noti-time { font-size: 11px; color: var(--text-light); }

        .noti-more {
            display: block;
            text-align: center;
            padding: 14px;
            font-size: 13px;
            font-weight: 500;
            color: var(--accent);
            text-decoration: none;
            border-top: 1px solid var(--border);
        }

        /* 프로필 드롭다운 */
        .profile-wrapper {
            position: relative;
        }

        .profile-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 300px;
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2000;
            overflow: hidden;
        }

        .profile-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-dd-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
        }

        .profile-dd-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--gold), #f4d03f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .profile-dd-level { font-size: 18px; font-weight: 800; color: var(--primary); }

        .profile-dd-info { display: flex; flex-direction: column; gap: 2px; }
        .profile-dd-name { font-size: 15px; font-weight: 600; color: white; }
        .profile-dd-email { font-size: 12px; color: rgba(255,255,255,0.6); }

        .profile-dd-menu { padding: 8px; }

        .profile-dd-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-primary);
            font-size: 14px;
            transition: all 0.2s;
        }

        .profile-dd-menu-item:hover { background: var(--bg-main); color: var(--accent); }
        .profile-dd-menu-item svg { width: 18px; height: 18px; color: var(--text-secondary); }

        .profile-dd-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--border);
        }

        .profile-dd-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 13px;
            transition: all 0.2s;
        }

        .profile-dd-logout:hover { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .profile-dd-logout svg { width: 16px; height: 16px; }

        /* 드롭다운 오버레이 */
        .dropdown-overlay {
            position: fixed;
            inset: 0;
            z-index: 1000;
            background: transparent;
            display: none;
            -webkit-tap-highlight-color: transparent;
        }

        .dropdown-overlay.active {
            display: block;
        }

        /* 모바일 드롭다운 */
        @media (max-width: 768px) {
            .user-info-header { display: none; }
            .user-profile-header { padding: 3px; border-radius: 50%; }
            .user-dropdown-arrow { display: none; }
        }

        /* 모바일 드롭다운 - 위에서 아래로 */
        .mobile-bottomsheet {
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            width: 100%;
            max-height: calc(100vh - 64px);
            background: var(--bg-card);
            border-radius: 0 0 20px 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            z-index: 10000;
            display: none;
            overflow-y: auto;
        }

        .mobile-bottomsheet.show {
            display: block;
        }

        .mobile-bottomsheet .bottomsheet-handle {
            display: none;
        }

        .content {
            padding: 20px;
        }

        .content p {
            margin-bottom: 20px;
            line-height: 1.8;
        }

        #debug {
            position: fixed;
            bottom: 10px;
            left: 10px;
            background: rgba(0,0,0,0.8);
            color: #0f0;
            font-family: monospace;
            font-size: 12px;
            padding: 10px;
            border-radius: 8px;
            max-width: calc(100vw - 20px);
            white-space: pre-wrap;
            z-index: 99999;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="notification-wrapper">
            <button class="header-btn" id="notificationBtn" type="button">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                <span class="notification-dot"></span>
            </button>
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="noti-header">
                    <span class="noti-title">알림</span>
                    <button class="noti-read-all">모두 읽음</button>
                </div>
                <div class="noti-list">
                    <div class="noti-item unread">
                        <div class="noti-icon comment">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        </div>
                        <div class="noti-content">
                            <p class="noti-text"><strong>댓글러1</strong>님이 회원님의 글에 댓글을 남겼습니다.</p>
                            <span class="noti-time">5분 전</span>
                        </div>
                    </div>
                    <div class="noti-item unread">
                        <div class="noti-icon like">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                        </div>
                        <div class="noti-content">
                            <p class="noti-text"><strong>익명사용자</strong>님이 회원님의 글을 추천했습니다.</p>
                            <span class="noti-time">32분 전</span>
                        </div>
                    </div>
                    <div class="noti-item">
                        <div class="noti-icon system">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <div class="noti-content">
                            <p class="noti-text">출석 체크 보상 <strong>100P</strong>가 지급되었습니다.</p>
                            <span class="noti-time">1시간 전</span>
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

            <div class="profile-dropdown" id="profileDropdown">
                <div class="profile-dd-header">
                    <div class="profile-dd-avatar">
                        <div class="profile-dd-level">7</div>
                    </div>
                    <div class="profile-dd-info">
                        <span class="profile-dd-name">김철수</span>
                        <span class="profile-dd-email">user@example.com</span>
                    </div>
                </div>
                <div class="profile-dd-menu">
                    <a href="#" class="profile-dd-menu-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>내 정보</span>
                    </a>
                    <a href="#" class="profile-dd-menu-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                        <span>내가 쓴 글</span>
                    </a>
                    <a href="#" class="profile-dd-menu-item">
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
    </header>

    <div class="dropdown-overlay" id="dropdownOverlay"></div>

    <div class="content">
        <h1>드롭다운 PHP 테스트</h1>
        <p>이 페이지는 header.php와 동일한 HTML/CSS를 사용합니다.</p>
        <p>스크롤 테스트용 더미 텍스트입니다.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    </div>

    <div id="debug">ready</div>

    <!-- 모바일 바텀시트 (body 바로 아래) -->
    <div class="mobile-bottomsheet" id="mobileBottomsheet">
        <div class="bottomsheet-handle"></div>
        <div class="bottomsheet-content" id="bottomsheetContent"></div>
    </div>

    <script>
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const dropdownOverlay = document.getElementById('dropdownOverlay');
        const mobileBottomsheet = document.getElementById('mobileBottomsheet');
        const bottomsheetContent = document.getElementById('bottomsheetContent');
        const debug = document.getElementById('debug');

        let logs = [];
        function log(msg) {
            const t = new Date();
            const ts = `${t.getMinutes()}:${t.getSeconds()}.${String(t.getMilliseconds()).padStart(3,'0')}`;
            logs.push(`${ts} ${msg}`);
            if (logs.length > 15) logs.shift();
            debug.textContent = logs.join('\n');
        }

        function isMobile() {
            return window.innerWidth <= 768;
        }

        function closeAll() {
            log('closeAll()');
            if (isMobile()) {
                mobileBottomsheet.classList.remove('show');
            } else {
                notificationDropdown.classList.remove('show');
                profileDropdown.classList.remove('show');
            }
            dropdownOverlay.classList.remove('active');
        }

        function openDropdown(which) {
            const isNoti = which === 'noti';
            log(`openDropdown(${which}) mobile=${isMobile()}`);

            if (isMobile()) {
                // 모바일: 바텀시트 사용
                const isOpen = mobileBottomsheet.classList.contains('show');

                if (isOpen) {
                    mobileBottomsheet.classList.remove('show');
                    dropdownOverlay.classList.remove('active');
                } else {
                    // 드롭다운 내용을 바텀시트로 복사
                    const source = isNoti ? notificationDropdown : profileDropdown;
                    bottomsheetContent.innerHTML = source.innerHTML;

                    // href="#" 클릭 방지
                    bottomsheetContent.querySelectorAll('a[href="#"]').forEach(a => {
                        a.addEventListener('click', e => e.preventDefault());
                    });

                    mobileBottomsheet.classList.add('show');
                    dropdownOverlay.classList.add('active');
                }
            } else {
                // 데스크탑: 기존 방식
                const target = isNoti ? notificationDropdown : profileDropdown;
                const other = isNoti ? profileDropdown : notificationDropdown;
                const isOpen = target.classList.contains('show');

                other.classList.remove('show');

                if (isOpen) {
                    target.classList.remove('show');
                    dropdownOverlay.classList.remove('active');
                } else {
                    target.classList.add('show');
                    dropdownOverlay.classList.add('active');
                }
            }
        }

        // pointerdown 이벤트
        notificationBtn.addEventListener('pointerdown', function(e) {
            log(`notificationBtn pointerdown`);
            e.preventDefault();
            e.stopPropagation();
            openDropdown('noti');
        }, { passive: false });

        profileBtn.addEventListener('pointerdown', function(e) {
            log(`profileBtn pointerdown`);
            e.preventDefault();
            e.stopPropagation();
            openDropdown('profile');
        }, { passive: false });

        // 드롭다운/바텀시트 내부 클릭 방지
        [notificationDropdown, profileDropdown, mobileBottomsheet].forEach(el => {
            el.addEventListener('pointerdown', e => {
                log(el.id + ' pointerdown');
                e.stopPropagation();
            }, { passive: true });
        });

        // 내부 href="#" 점프 방지
        document.querySelectorAll('a[href="#"]').forEach(a => {
            a.addEventListener('click', (ev) => {
                ev.preventDefault();
            });
        });

        // 오버레이 클릭시 닫기
        dropdownOverlay.addEventListener('pointerdown', function(e) {
            log('overlay pointerdown');
            e.preventDefault();
            e.stopPropagation();
            closeAll();
        }, { passive: false });

        log('init complete - mobile bottomsheet mode');
    </script>
</body>
</html>
