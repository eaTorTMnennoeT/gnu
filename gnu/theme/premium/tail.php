<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * 테마 tail.php
 * 컨텐츠 종료부터 </html>까지
 */
?>
    </main>
    <!-- 메인 컨텐츠 끝 -->
</div>
<!-- 메인 래퍼 끝 -->

<?php
// 팝업
include_once(G5_THEME_PATH.'/popup.php');
?>

<!-- 테마 JavaScript -->
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
        cashPopup?.classList.add('active');
        popupOverlay?.classList.add('active');
    });

    document.getElementById('pointStatItem')?.addEventListener('click', () => {
        pointPopup?.classList.add('active');
        popupOverlay?.classList.add('active');
    });

    function closeStatPopup() {
        cashPopup?.classList.remove('active');
        pointPopup?.classList.remove('active');
        popupOverlay?.classList.remove('active');
    }

    popupOverlay?.addEventListener('click', closeStatPopup);

    // ========== 드롭다운 통합 관리 ==========
    (function() {
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const dropdownOverlay = document.getElementById('dropdownOverlay');

        function closeAllDropdowns() {
            notificationDropdown?.classList.remove('show');
            profileDropdown?.classList.remove('show');
            dropdownOverlay?.classList.remove('active');
        }

        // 알림 버튼 클릭
        if (notificationBtn) {
            notificationBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isOpen = notificationDropdown?.classList.contains('show');
                closeAllDropdowns();

                if (!isOpen && notificationDropdown) {
                    notificationDropdown.classList.add('show');
                    dropdownOverlay?.classList.add('active');
                }
            });
        }

        // 프로필 버튼 클릭
        if (profileBtn) {
            profileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isOpen = profileDropdown?.classList.contains('show');
                closeAllDropdowns();

                if (!isOpen && profileDropdown) {
                    profileDropdown.classList.add('show');
                    dropdownOverlay?.classList.add('active');
                }
            });
        }

        // 오버레이 클릭 시 닫기
        if (dropdownOverlay) {
            dropdownOverlay.addEventListener('click', function(e) {
                e.preventDefault();
                closeAllDropdowns();
            });
        }

        // 드롭다운 내부 클릭 시 전파 방지
        notificationDropdown?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        profileDropdown?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // 바깥 영역 클릭 시 닫기
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.notification-wrapper') && !e.target.closest('.profile-wrapper')) {
                closeAllDropdowns();
            }
        });

        // ESC 키로 닫기
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllDropdowns();
            }
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
            closeAllDropdowns();
            location.href = '<?php echo G5_BBS_URL; ?>/memo_view.php?me_id=' + id;
        };

        window.closeAllDropdowns = closeAllDropdowns;
    })();
</script>

<?php
if ($config['cf_add_script']) {
    echo $config['cf_add_script']."\n";
}

run_event('tail_sub');
?>
</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : add_javascript() 스크립트 출력 ?>
