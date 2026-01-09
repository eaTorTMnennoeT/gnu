<script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
    });

    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
    });

    document.querySelectorAll('.nav-link.has-sub').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            this.parentElement.classList.toggle('open');
        });
    });

    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);

    themeToggle.addEventListener('click', () => {
        const newTheme = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 992) {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        }
    });

    // 캐시/포인트 팝업
    const cashPopup = document.getElementById('cashPopup');
    const pointPopup = document.getElementById('pointPopup');
    const popupOverlay = document.getElementById('statPopupOverlay');

    document.getElementById('cashStatItem')?.addEventListener('click', () => {
        cashPopup.classList.add('active');
        popupOverlay.classList.add('active');
    });

    document.getElementById('pointStatItem')?.addEventListener('click', () => {
        pointPopup.classList.add('active');
        popupOverlay.classList.add('active');
    });

    function closeStatPopup() {
        cashPopup?.classList.remove('active');
        pointPopup?.classList.remove('active');
        popupOverlay?.classList.remove('active');
    }

    popupOverlay?.addEventListener('click', closeStatPopup);

    // ========== 드롭다운 통합 관리 (모바일 바텀시트 지원) ==========
    (function() {
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const dropdownOverlay = document.getElementById('dropdownOverlay');
        const mobileBottomsheet = document.getElementById('mobileBottomsheet');
        const bottomsheetContent = document.getElementById('bottomsheetContent');

        if (!notificationBtn && !profileBtn) return;

        function isMobile() {
            return window.innerWidth <= 768;
        }

        function closeAll() {
            if (isMobile()) {
                mobileBottomsheet?.classList.remove('show');
            } else {
                notificationDropdown?.classList.remove('show');
                profileDropdown?.classList.remove('show');
            }
            dropdownOverlay?.classList.remove('active');
        }

        function openDropdown(which, e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            const isNoti = which === 'noti';

            if (isMobile()) {
                // 모바일: 바텀시트 사용
                const isOpen = mobileBottomsheet?.classList.contains('show');

                if (isOpen) {
                    mobileBottomsheet?.classList.remove('show');
                    dropdownOverlay?.classList.remove('active');
                } else {
                    // 드롭다운 내용을 바텀시트로 복사
                    const source = isNoti ? notificationDropdown : profileDropdown;
                    if (source && bottomsheetContent) {
                        bottomsheetContent.innerHTML = source.innerHTML;

                        // href="#" 클릭 방지
                        bottomsheetContent.querySelectorAll('a[href="#"]').forEach(a => {
                            if (!a.classList.contains('profile-dd-menu-item')) {
                                a.addEventListener('click', ev => ev.preventDefault());
                            }
                        });

                        // 바텀시트 내 프로필 메뉴 클릭 이벤트 바인딩
                        bottomsheetContent.querySelectorAll('.profile-dd-menu-item[data-modal]').forEach(item => {
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                const modalType = this.getAttribute('data-modal');
                                if (modalType && typeof window.openProfileModal === 'function') {
                                    closeAll();
                                    window.openProfileModal(modalType);
                                }
                            });
                        });
                    }

                    mobileBottomsheet?.classList.add('show');
                    dropdownOverlay?.classList.add('active');
                }
            } else {
                // 데스크탑: 기존 방식
                const target = isNoti ? notificationDropdown : profileDropdown;
                const other = isNoti ? profileDropdown : notificationDropdown;

                if (!target) return;
                const isOpen = target.classList.contains('show');

                // 다른 드롭다운 닫기
                other?.classList.remove('show');

                if (isOpen) {
                    closeAll();
                } else {
                    target.classList.add('show');
                    dropdownOverlay?.classList.add('active');
                }
            }
        }

        // pointerdown 이벤트 사용 (모바일 터치 호환)
        notificationBtn?.addEventListener('pointerdown', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openDropdown('noti', e);
        }, { passive: false });

        profileBtn?.addEventListener('pointerdown', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openDropdown('profile', e);
        }, { passive: false });

        // 오버레이 클릭 시 닫기
        dropdownOverlay?.addEventListener('pointerdown', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeAll();
        }, { passive: false });

        // 드롭다운 내부 pointerdown 전파 방지 (오버레이 닫힘 방지용)
        notificationDropdown?.addEventListener('pointerdown', function(e) {
            e.stopPropagation();
        }, { passive: true });

        profileDropdown?.addEventListener('pointerdown', function(e) {
            // 메뉴 아이템이 아니면 전파만 방지
            if (!e.target.closest('.profile-dd-menu-item[data-modal]')) {
                e.stopPropagation();
            }
        }, { passive: true });

        mobileBottomsheet?.addEventListener('pointerdown', function(e) {
            // 메뉴 아이템이 아니면 전파만 방지
            if (!e.target.closest('.profile-dd-menu-item[data-modal]')) {
                e.stopPropagation();
            }
        }, { passive: true });

        // 내부 href="#" 점프 방지 (프로필 메뉴 제외)
        document.querySelectorAll('a[href="#"]').forEach(a => {
            if (a.classList.contains('profile-dd-menu-item')) return;
            a.addEventListener('click', ev => ev.preventDefault());
        });

        // 프로필 메뉴 아이템 클릭 처리
        document.querySelectorAll('.profile-dd-menu-item[data-modal]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const modalType = this.getAttribute('data-modal');
                if (modalType && typeof window.openProfileModal === 'function') {
                    closeAll();
                    window.openProfileModal(modalType);
                }
            });
        });

        // 전역 함수
        window.markAllRead = function() {
            document.querySelectorAll('.noti-item.unread').forEach(item => {
                item.classList.remove('unread');
            });
            const dot = document.querySelector('.notification-dot');
            if (dot) dot.style.display = 'none';
        };

        window.goToNoti = function(id) {
            closeAll();
        };
    })();
</script>
