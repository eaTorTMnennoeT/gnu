<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- 사이드바 -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" class="logo">
            <div class="logo-icon">G</div>
            <div class="logo-text">Gnu<span>Board</span></div>
        </a>
    </div>

    <nav class="nav-section">
        <div class="nav-label">메인</div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="index.php" class="nav-link<?php echo ($current_page == 'home') ? ' active' : ''; ?>">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
                    <span class="nav-text">홈</span>
                </a>
            </li>
            <li class="nav-item<?php echo ($current_page == 'board') ? ' open' : ''; ?>">
                <a href="#" class="nav-link has-sub">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    <span class="nav-text">커뮤니티</span>
                    <span class="nav-badge">36</span>
                    <svg class="nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item"><a href="board.php" class="nav-link"><span class="nav-text">자유게시판</span><span class="nav-badge">12</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">유머게시판</span><span class="nav-badge">8</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">정보공유</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">홍보게시판</span></a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link has-sub">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <span class="nav-text">질문답변</span>
                    <span class="nav-badge">24</span>
                    <svg class="nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">PHP 질문</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">JS 질문</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">CSS 질문</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">서버/DB</span></a></li>
                </ul>
            </li>
            <li class="nav-item<?php echo ($current_page == 'gallery') ? ' open' : ''; ?>">
                <a href="#" class="nav-link has-sub">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
                    <span class="nav-text">갤러리</span>
                    <svg class="nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item"><a href="gallery.php" class="nav-link"><span class="nav-text">사진갤러리</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">작품갤러리</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">밈갤러리</span></a></li>
                </ul>
            </li>
            <li class="nav-item<?php echo ($current_page == 'pds') ? ' open' : ''; ?>">
                <a href="#" class="nav-link has-sub">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                    <span class="nav-text">자료실</span>
                    <span class="nav-badge gold">HOT</span>
                    <svg class="nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item"><a href="pds.php" class="nav-link<?php echo ($current_page == 'pds') ? ' active' : ''; ?>"><span class="nav-text">자료실</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">스킨/테마</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">플러그인</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">소스코드</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><span class="nav-text">문서/가이드</span></a></li>
                </ul>
            </li>
        </ul>

        <div class="nav-label">회원</div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg><span class="nav-text">회원목록</span></a></li>
            <li class="nav-item"><a href="#" class="nav-link" onclick="openProfileModal('message'); return false;"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><span class="nav-text">쪽지함</span><span class="nav-badge">3</span></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg><span class="nav-text">포인트</span></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg><span class="nav-text">스크랩</span></a></li>
        </ul>

        <div class="nav-label">관리</div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg><span class="nav-text">환경설정</span></a></li>
            <li class="nav-item"><a href="#" class="nav-link"><svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg><span class="nav-text">관리자</span></a></li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <button class="sidebar-footer-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            로그아웃
        </button>
    </div>
</aside>
