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

    document.querySelector('.stat-item:first-child')?.addEventListener('click', () => {
        cashPopup.classList.add('active');
        popupOverlay.classList.add('active');
    });

    document.querySelector('.stat-item:last-child')?.addEventListener('click', () => {
        pointPopup.classList.add('active');
        popupOverlay.classList.add('active');
    });

    function closeStatPopup() {
        cashPopup?.classList.remove('active');
        pointPopup?.classList.remove('active');
        popupOverlay?.classList.remove('active');
    }

    popupOverlay?.addEventListener('click', closeStatPopup);
</script>
