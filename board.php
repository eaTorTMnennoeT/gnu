<?php $current_page = 'board'; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <script>document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');</script>
    <?php include 'includes/head.php'; ?>
    <title>자유게시판 - 그누보드</title>
    <style>
        /* 게시판 페이지 전용 CSS */
        .main-content { padding: 20px; }

        /* 페이지 타이틀 */
        .page-title-section {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            display: flex; align-items: center; gap: 12px;
        }

        .page-title-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--accent) 0%, #ff6b6b 100%);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px var(--accent-glow);
        }

        .page-title-icon svg { width: 24px; height: 24px; color: white; }

        .page-title h1 { font-size: 24px; font-weight: 700; }
        .page-title p { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }

        .write-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 8px 14px;
            background: linear-gradient(135deg, var(--accent) 0%, #ff6b6b 100%);
            border: none; border-radius: 8px;
            color: white; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: all 0.3s;
            box-shadow: 0 2px 8px var(--accent-glow);
        }

        .write-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px var(--accent-glow); }
        .write-btn svg { width: 14px; height: 14px; }

        /* 베스트 글 섹션 */
        .best-section {
            background: var(--bg-card);
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .best-tabs {
            display: flex;
            border-bottom: 1px solid var(--border);
        }

        .best-tab {
            flex: 1;
            padding: 14px 16px;
            background: transparent;
            border: none;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .best-tab:hover {
            color: var(--text-primary);
            background: var(--bg-main);
        }

        .best-tab.active {
            color: var(--accent);
            background: var(--bg-main);
            border-bottom: 2px solid var(--accent);
            margin-bottom: -1px;
        }

        .best-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        .best-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 1px solid var(--border);
        }

        .best-item:nth-child(odd) {
            border-right: 1px solid var(--border);
        }

        .best-item:nth-last-child(-n+2) {
            border-bottom: none;
        }

        .best-item:hover {
            background: var(--bg-main);
        }

        .rank-badge {
            width: 20px; height: 20px;
            border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 800;
            flex-shrink: 0;
        }

        .rank-1 { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; }
        .rank-2 { background: linear-gradient(135deg, #9ca3af, #6b7280); color: #1f2937; }
        .rank-3 { background: linear-gradient(135deg, #d97706, #b45309); color: #451a03; }
        .rank-other { background: transparent; color: var(--text-light); font-weight: 600; }

        .best-item-title {
            flex: 1;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--text-primary);
        }

        .best-item-likes {
            font-size: 12px;
            color: var(--text-light);
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .best-list {
                grid-template-columns: 1fr;
            }
            .best-item:nth-child(odd) {
                border-right: none;
            }
            .best-item:last-child {
                border-bottom: none;
            }
            .best-item:nth-last-child(-n+2) {
                border-bottom: 1px solid var(--border);
            }
            .best-item:last-child {
                border-bottom: none;
            }
        }

        /* 게시판 테이블 */
        .board-section {
            background: var(--bg-card);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
        }

        #boardList {
            display: contents;
        }

        .board-table-header {
            display: grid;
            grid-template-columns: auto 1fr 100px 80px 70px 70px;
            gap: 12px;
            padding: 14px 20px;
            background: var(--bg-main);
            font-size: 12px; font-weight: 600;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border);
        }

        .board-row {
            display: grid;
            grid-template-columns: auto 1fr 100px 80px 70px 70px;
            gap: 12px;
            padding: 14px 20px;
            align-items: center;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
        }

        .board-row > *:first-child {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .board-row:hover { background: var(--bg-main); }
        .board-row:last-child { border-bottom: none; }

        .category-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 6px;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            font-size: 11px;
            font-weight: 600;
            border-radius: 6px;
            white-space: nowrap;
            flex-shrink: 0;
            text-align: center;
            box-sizing: border-box;
        }

        .category-badge.notice {
            background: rgba(233, 69, 96, 0.1);
            color: var(--accent);
        }

        .post-title-cell {
            display: flex; align-items: center; gap: 8px;
        }

        .post-title-text {
            font-size: 14px; font-weight: 500;
            color: var(--text-primary);
            display: flex; align-items: center; gap: 4px;
        }

        .post-title-text:hover { color: var(--accent); }

        .image-icon {
            width: 14px; height: 14px;
            color: #6366f1;
            flex-shrink: 0;
        }

        .comment-count {
            font-size: 12px; font-weight: 600;
            color: #3b82f6;
        }

        .new-badge {
            padding: 2px 6px;
            background: var(--accent);
            color: white;
            font-size: 9px; font-weight: 700;
            border-radius: 4px;
        }

        .hot-badge {
            padding: 2px 6px;
            background: linear-gradient(135deg, var(--gold), #f59e0b);
            color: #78350f;
            font-size: 9px; font-weight: 700;
            border-radius: 4px;
        }

        .post-author { font-size: 13px; color: var(--text-secondary); }
        .post-date { font-size: 12px; color: var(--text-light); }
        .post-views { font-size: 12px; color: var(--text-light); text-align: center; }
        .post-likes { font-size: 12px; color: var(--accent); text-align: center; font-weight: 600; }

        /* 페이지네이션 */
        .pagination {
            display: flex; justify-content: center; gap: 6px;
            margin-top: 24px;
        }

        .page-btn {
            width: 36px; height: 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-card);
            color: var(--text-secondary);
            font-size: 13px; font-weight: 500;
            cursor: pointer; transition: all 0.2s;
        }

        .page-btn:hover { border-color: var(--accent); color: var(--accent); }

        .page-btn.active {
            background: linear-gradient(135deg, var(--accent) 0%, #ff6b6b 100%);
            border-color: transparent;
            color: white;
        }

        /* 검색 FAB */
        .search-fab {
            position: fixed;
            bottom: 30px; right: 30px;
            width: 56px; height: 56px;
            border-radius: 50%; border: none;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white; font-size: 22px;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(26,26,46,0.4);
            transition: all 0.3s;
            display: flex; align-items: center; justify-content: center;
            z-index: 100;
        }

        .search-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(26,26,46,0.5);
        }

        /* 검색 모달 */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center; justify-content: center;
            z-index: 2000;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .modal-overlay.open { display: flex; opacity: 1; }

        .modal-content {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 32px;
            width: 90%; max-width: 480px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-close {
            position: absolute; top: 16px; right: 16px;
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--bg-main);
            color: var(--text-secondary);
            font-size: 18px;
            cursor: pointer; transition: all 0.2s;
        }

        .modal-close:hover { border-color: var(--accent); color: var(--accent); }

        .modal-title { font-size: 20px; font-weight: 700; margin-bottom: 8px; }
        .modal-desc { font-size: 14px; color: var(--text-secondary); margin-bottom: 24px; }

        .search-input-modal {
            width: 100%;
            padding: 14px 18px;
            font-size: 15px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: var(--bg-main);
            color: var(--text-primary);
            outline: none;
            transition: all 0.3s;
        }

        .search-input-modal:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .search-input-modal::placeholder { color: var(--text-light); }

        .search-options {
            display: flex; gap: 12px;
            margin: 20px 0 28px;
        }

        .search-option {
            display: flex; align-items: center; gap: 8px;
            padding: 12px 18px;
            border: 1px solid var(--border);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .search-option:hover { border-color: var(--accent); }

        .search-option.active {
            border-color: var(--accent);
            background: rgba(233, 69, 96, 0.08);
            color: var(--accent);
        }

        .search-option input { display: none; }

        .radio-dot {
            width: 18px; height: 18px;
            border-radius: 50%;
            border: 2px solid var(--border);
            transition: all 0.2s;
            position: relative;
        }

        .search-option.active .radio-dot {
            border-color: var(--accent);
            border-width: 5px;
        }

        .search-submit {
            width: 100%;
            padding: 14px;
            font-size: 15px; font-weight: 600;
            border: none; border-radius: 12px;
            background: linear-gradient(135deg, var(--accent) 0%, #ff6b6b 100%);
            color: white;
            cursor: pointer; transition: all 0.3s;
        }

        .search-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--accent-glow);
        }

        /* 반응형 - 페이지 전용 */
        @media (max-width: 992px) {
            .board-table-header { display: none; }

            .board-section {
                padding: 0;
                background: var(--bg-card);
            }

            #boardList {
                display: flex;
                flex-direction: column;
            }

            .board-row {
                display: flex;
                flex-direction: row;
                align-items: center;
                gap: 10px;
                padding: 12px 14px;
                background: transparent;
                border: none;
                border-bottom: 1px solid var(--border);
                border-radius: 0;
                box-shadow: none;
                margin-bottom: 0;
            }

            .board-row:last-child {
                border-bottom: none;
            }

            .board-row:hover {
                background: var(--bg-main);
                box-shadow: none;
                transform: none;
            }

            .board-row > *:first-child {
                flex-shrink: 0;
            }

            .post-title-cell {
                flex: 1;
                min-width: 0;
                display: flex;
                align-items: center;
                gap: 4px;
                overflow: hidden;
            }

            .post-title-text {
                font-size: 13px;
                font-weight: 500;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                flex-shrink: 1;
            }

            .post-author,
            .post-views,
            .post-likes {
                display: none;
            }

            .post-date {
                display: block;
                flex-shrink: 0;
                font-size: 11px;
                color: var(--text-light);
                margin-left: auto;
            }

            .board-row .post-meta {
                display: none;
            }

            .comment-count,
            .new-badge,
            .hot-badge {
                flex-shrink: 0;
            }
        }

        @media (max-width: 768px) {
            .page-title-section {
                flex-direction: row;
                gap: 12px;
                align-items: center;
                justify-content: space-between;
            }
            .page-title-icon { width: 40px; height: 40px; border-radius: 10px; }
            .page-title-icon svg { width: 20px; height: 20px; }
            .page-title h1 { font-size: 18px; }
            .page-title p { font-size: 11px; }
            .write-btn { padding: 6px 12px; font-size: 12px; }
            .write-btn svg { width: 12px; height: 12px; }

            /* 모바일에서 베스트 10개 모두 표시 */

            .board-row {
                padding: 10px 12px;
                gap: 8px;
            }

            .post-title-text {
                font-size: 12px;
            }

            .category-badge {
                font-size: 10px;
                padding: 3px 5px;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <!-- 메인 -->
    <div class="main-wrapper">
        <?php include 'includes/header.php'; ?>

        <!-- 메인 콘텐츠 -->
        <main class="main-content">
            <!-- 페이지 타이틀 -->
            <div class="page-title-section">
                <div class="page-title">
                    <div class="page-title-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    </div>
                    <div>
                        <h1>자유게시판</h1>
                        <p>자유롭게 소통하는 공간입니다</p>
                    </div>
                </div>
                <button class="write-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    글쓰기
                </button>
            </div>

            <!-- 베스트 글 -->
            <section class="best-section">
                <div class="best-tabs">
                    <button class="best-tab active" onclick="setPeriod('daily', this)">일간베스트</button>
                    <button class="best-tab" onclick="setPeriod('weekly', this)">주간베스트</button>
                    <button class="best-tab" onclick="setPeriod('monthly', this)">월간베스트</button>
                </div>
                <div class="best-list" id="bestList">
                    <!-- JS로 렌더링 -->
                </div>
            </section>

            <!-- 게시판 -->
            <section class="board-section">
                <div class="board-table-header">
                    <span>분류</span>
                    <span>제목</span>
                    <span>작성자</span>
                    <span>날짜</span>
                    <span style="text-align:center">조회</span>
                    <span style="text-align:center">추천</span>
                </div>
                <div id="boardList">
                    <!-- JS로 렌더링 -->
                </div>
            </section>

            <!-- 페이지네이션 -->
            <div class="pagination">
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">4</button>
                <button class="page-btn">5</button>
            </div>
        </main>
    </div>

    <!-- 검색 FAB -->
    <button class="search-fab" onclick="openSearchModal()">🔍</button>

    <!-- 검색 모달 -->
    <div class="modal-overlay" id="searchModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeSearchModal()">✕</button>
            <h2 class="modal-title">게시글 검색</h2>
            <p class="modal-desc">찾고 싶은 게시글을 검색해보세요</p>

            <input type="text" class="search-input-modal" placeholder="검색어를 입력하세요..." id="searchInput">

            <div class="search-options">
                <label class="search-option active" data-type="title">
                    <input type="radio" name="searchType" value="title" checked>
                    <span class="radio-dot"></span>
                    제목
                </label>
                <label class="search-option" data-type="title_content">
                    <input type="radio" name="searchType" value="title_content">
                    <span class="radio-dot"></span>
                    제목+내용
                </label>
            </div>

            <button class="search-submit" onclick="doSearch()">🔍 검색하기</button>
        </div>
    </div>

    <?php include 'includes/popup.php'; ?>
    <?php include 'includes/footer.php'; ?>

    <script>
        // 데이터
        // 공지사항 (상단 고정)
        const notices = [
            { id: 100, category: '공지', title: '[필독] 커뮤니티 이용 규칙 안내', author: '관리자', level: 10, date: '01-06', views: 6540, likes: 67, comments: 28, isNew: false, isHot: false, hasImage: false, isNotice: true },
            { id: 101, category: '공지', title: '[이벤트] 새해 맞이 출석체크 이벤트', author: '관리자', level: 10, date: '01-05', views: 8234, likes: 156, comments: 89, isNew: false, isHot: true, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1513151233558-d860c5398176?w=300&h=200&fit=crop', isNotice: true },
        ];

        // 일반 게시글
        const posts = [
            { id: 1, category: '일상', title: '그누보드 신규 테마 적용 후기입니다', author: '김철수', level: 7, date: '01-08', views: 1523, likes: 234, comments: 15, isNew: true, isHot: false, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=300&h=200&fit=crop' },
            { id: 2, category: '정보', title: '새해 다이어트 꿀팁 공유합니다', author: '헬스마니아', level: 5, date: '01-08', views: 2341, likes: 567, comments: 89, isNew: true, isHot: true, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=300&h=200&fit=crop' },
            { id: 3, category: '모임', title: '주말에 뭐하세요?', author: '주말여행', level: 3, date: '01-08', views: 876, likes: 45, comments: 42, isNew: false, isHot: true, hasImage: false },
            { id: 4, category: '일상', title: '점심 메뉴 추천해주세요', author: '맛집탐방', level: 8, date: '01-07', views: 1234, likes: 189, comments: 8, isNew: false, isHot: false, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=300&h=200&fit=crop' },
            { id: 5, category: '정보', title: '연초 계획 세우기', author: '새출발', level: 2, date: '01-07', views: 987, likes: 123, comments: 23, isNew: false, isHot: false, hasImage: false },
            { id: 6, category: '일상', title: '오늘 날씨가 정말 좋네요', author: '행복이', level: 4, date: '01-07', views: 3456, likes: 789, comments: 5, isNew: false, isHot: false, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1601297183305-6df142704ea2?w=300&h=200&fit=crop' },
            { id: 7, category: '일상', title: '반려동물 자랑해요', author: '집사', level: 6, date: '01-06', views: 2876, likes: 934, comments: 156, isNew: false, isHot: true, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=300&h=200&fit=crop' },
            { id: 8, category: '질문', title: 'PHP 초보 질문드립니다', author: '코딩왕', level: 1, date: '01-06', views: 432, likes: 12, comments: 8, isNew: false, isHot: false, hasImage: false },
        ];

        const bestPosts = {
            daily: [
                { title: '새해 다이어트 꿀팁 공유합니다', likes: 567, comments: 89 },
                { title: '반려동물 자랑해요', likes: 934, comments: 156 },
                { title: '주말에 뭐하세요?', likes: 45, comments: 42 },
                { title: '오늘 날씨가 정말 좋네요', likes: 789, comments: 5 },
                { title: '그누보드 신규 테마 적용 후기입니다', likes: 234, comments: 15 },
                { title: '점심 메뉴 추천해주세요', likes: 189, comments: 8 },
                { title: '연초 계획 세우기', likes: 123, comments: 23 },
                { title: '커뮤니티 이용 규칙 안내', likes: 67, comments: 28 },
                { title: '맛집 탐방 후기', likes: 456, comments: 67 },
                { title: '주말 영화 추천', likes: 321, comments: 45 },
            ],
            weekly: [
                { title: '2024년 결산 및 2025년 목표', likes: 2341, comments: 234 },
                { title: '직장인 재테크 노하우', likes: 1876, comments: 189 },
                { title: '해외여행 준비 가이드', likes: 1654, comments: 145 },
                { title: '신년 다이어트 성공기', likes: 1432, comments: 123 },
                { title: '재택근무 꿀팁 모음', likes: 1287, comments: 98 },
                { title: '연말정산 꿀팁', likes: 1156, comments: 87 },
                { title: '건강검진 후기', likes: 987, comments: 76 },
                { title: '새해 인테리어 추천', likes: 876, comments: 65 },
                { title: '겨울철 피부관리', likes: 765, comments: 54 },
                { title: '연초 독서 목록 공유', likes: 654, comments: 43 },
            ],
            monthly: [
                { title: '올해의 인생템 공유', likes: 5678, comments: 567 },
                { title: '신년 운세 풀이', likes: 4532, comments: 432 },
                { title: '연말정산 완벽 가이드', likes: 3987, comments: 398 },
                { title: '올해의 베스트 영화', likes: 3456, comments: 345 },
                { title: '신년 목표 달성법', likes: 2987, comments: 298 },
                { title: '겨울 여행지 추천', likes: 2654, comments: 265 },
                { title: '건강한 식단 가이드', likes: 2321, comments: 232 },
                { title: '올해의 베스트 도서', likes: 1987, comments: 198 },
                { title: '새해 재테크 전략', likes: 1654, comments: 165 },
                { title: '2025 트렌드 예측', likes: 1321, comments: 132 },
            ],
        };

        let currentPeriod = 'daily';
        let searchType = 'title';

        // 베스트 글 렌더링
        function renderBestPosts() {
            const list = document.getElementById('bestList');
            const items = bestPosts[currentPeriod];
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                // 모바일: 1,2,3,4,5,6,7,8,9,10 순차 표시
                list.innerHTML = items.map((post, idx) => `
                    <div class="best-item" onclick="location.href='view.php?id=${idx + 1}'">
                        <div class="rank-badge ${idx < 3 ? 'rank-' + (idx + 1) : 'rank-other'}">${idx + 1}</div>
                        <span class="best-item-title">${post.title}</span>
                        <span class="best-item-likes">${post.likes.toLocaleString()}</span>
                    </div>
                `).join('');
            } else {
                // 데스크탑: 2열 그리드에서 왼쪽부터 순서대로 표시하기 위해 재정렬
                // 원래: 1,2 / 3,4 / 5,6 / 7,8 / 9,10 (row 순서)
                // 필요: 1,6 / 2,7 / 3,8 / 4,9 / 5,10 (column 순서로 보이게)
                const half = Math.ceil(items.length / 2);
                const reordered = [];
                for (let i = 0; i < half; i++) {
                    reordered.push({ ...items[i], originalIdx: i });
                    if (i + half < items.length) {
                        reordered.push({ ...items[i + half], originalIdx: i + half });
                    }
                }

                list.innerHTML = reordered.map((post) => `
                    <div class="best-item" onclick="location.href='view.php?id=${post.originalIdx + 1}'">
                        <div class="rank-badge ${post.originalIdx < 3 ? 'rank-' + (post.originalIdx + 1) : 'rank-other'}">${post.originalIdx + 1}</div>
                        <span class="best-item-title">${post.title}</span>
                        <span class="best-item-likes">${post.likes.toLocaleString()}</span>
                    </div>
                `).join('');
            }
        }

        // 게시글 목록 렌더링
        const imageIcon = `<svg class="image-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>`;

        function renderPosts() {
            const list = document.getElementById('boardList');
            const isMobile = window.innerWidth <= 992;
            const allPosts = [...notices, ...posts];

            list.innerHTML = allPosts.map(post => {
                const isNotice = post.isNotice || post.category === '공지';
                const noticeClass = isNotice ? 'notice-row' : '';

                if (isMobile) {
                    return `
                        <div class="board-row ${noticeClass}" onclick="location.href='view.php?id=${post.id}'">
                            <span class="category-badge ${isNotice ? 'notice' : ''}">${post.category}</span>
                            <div class="post-title-cell">
                                <span class="post-title-text">${post.hasImage ? imageIcon : ''}${post.title}</span>
                                ${post.comments > 0 ? `<span class="comment-count">[${post.comments}]</span>` : ''}
                                ${post.isNew ? '<span class="new-badge">N</span>' : ''}
                                ${post.isHot ? '<span class="hot-badge">HOT</span>' : ''}
                            </div>
                            <span class="post-date">${post.date}</span>
                        </div>
                    `;
                } else {
                    return `
                        <div class="board-row ${noticeClass}" onclick="location.href='view.php?id=${post.id}'" ${post.hasImage && post.thumbnail ? `onmouseenter="showImagePreview(event, ${post.id}, ${isNotice})" onmouseleave="hideImagePreview()"` : ''}>
                            <span class="category-badge ${isNotice ? 'notice' : ''}">${post.category}</span>
                            <div class="post-title-cell">
                                <span class="post-title-text">${post.hasImage ? imageIcon : ''}${post.title}</span>
                                ${post.comments > 0 ? `<span class="comment-count">[${post.comments}]</span>` : ''}
                                ${post.isNew ? '<span class="new-badge">N</span>' : ''}
                                ${post.isHot ? '<span class="hot-badge">HOT</span>' : ''}
                            </div>
                            <span class="post-author"><span class="author-level-wrap lv-${post.level > 5 ? 'high' : 'normal'}"><span class="author-level-num">${post.level}</span><span class="author-level-badge"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg></span></span>${post.author}</span>
                            <span class="post-date">${post.date}</span>
                            <span class="post-views">${post.views.toLocaleString()}</span>
                            <span class="post-likes">♥ ${post.likes}</span>
                        </div>
                    `;
                }
            }).join('');
        }

        // 윈도우 리사이즈 시 재렌더링
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                renderPosts();
            }, 250);
        });

        // 기간 변경
        function setPeriod(period, btn) {
            currentPeriod = period;
            document.querySelectorAll('.best-tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            renderBestPosts();
        }

        // 검색 모달
        function openSearchModal() {
            document.getElementById('searchModal').classList.add('open');
        }

        function closeSearchModal() {
            document.getElementById('searchModal').classList.remove('open');
        }

        function setSearchType(type, label) {
            searchType = type;
            document.querySelectorAll('.search-option').forEach(l => {
                l.classList.remove('active');
                l.querySelector('input[type="radio"]').checked = false;
            });
            label.classList.add('active');
            label.querySelector('input[type="radio"]').checked = true;
        }

        // 검색 라디오 버튼 이벤트
        document.querySelectorAll('.search-option').forEach(option => {
            option.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                setSearchType(type, this);
            });
        });

        function doSearch() {
            const query = document.getElementById('searchInput').value;
            alert(`검색어: ${query}\n검색 옵션: ${searchType === 'title' ? '제목' : '제목+내용'}`);
            closeSearchModal();
        }

        // 모달 외부 클릭 시 닫기
        document.getElementById('searchModal').addEventListener('click', function(e) {
            if (e.target === this) closeSearchModal();
        });

        // 이미지 프리뷰
        let previewEl = null;

        function showImagePreview(e, postId, isNotice = false) {
            const allPosts = [...notices, ...posts];
            const post = allPosts.find(p => p.id === postId);
            if (!post || !post.thumbnail) return;

            if (!previewEl) {
                previewEl = document.createElement('div');
                previewEl.className = 'image-preview-tooltip';
                document.body.appendChild(previewEl);
            }

            previewEl.innerHTML = `<img src="${post.thumbnail}" alt="미리보기">`;
            previewEl.style.display = 'block';

            updatePreviewPosition(e);
        }

        function updatePreviewPosition(e) {
            if (!previewEl) return;
            const x = e.clientX + 15;
            const y = e.clientY + 15;

            // 화면 밖으로 나가지 않도록 조정
            const maxX = window.innerWidth - 220;
            const maxY = window.innerHeight - 160;

            previewEl.style.left = Math.min(x, maxX) + 'px';
            previewEl.style.top = Math.min(y, maxY) + 'px';
        }

        function hideImagePreview() {
            if (previewEl) {
                previewEl.style.display = 'none';
            }
        }

        // 마우스 이동 시 프리뷰 위치 업데이트
        document.addEventListener('mousemove', (e) => {
            if (previewEl && previewEl.style.display === 'block') {
                updatePreviewPosition(e);
            }
        });

        // 초기 렌더링
        renderBestPosts();
        renderPosts();
    </script>

    <style>
        /* 작성자 레벨 배지 */
        .author-level-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 800;
            margin-right: 6px;
            position: relative;
            flex-shrink: 0;
        }
        .author-level-wrap.lv-normal {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 2px 6px rgba(99, 102, 241, 0.4);
        }
        .author-level-wrap.lv-high {
            background: linear-gradient(135deg, var(--gold), #f4d03f);
            box-shadow: 0 2px 6px rgba(212, 175, 55, 0.4);
        }
        .author-level-num {
            color: white;
            line-height: 1;
        }
        .author-level-wrap.lv-high .author-level-num {
            color: var(--primary);
        }
        .author-level-badge {
            position: absolute;
            bottom: -3px;
            right: -3px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid var(--bg-card);
        }
        .author-level-wrap.lv-normal .author-level-badge {
            background: #8b5cf6;
            color: white;
        }
        .author-level-wrap.lv-high .author-level-badge {
            background: var(--accent);
            color: white;
        }
        .author-level-badge svg {
            width: 7px;
            height: 7px;
        }

        /* 이미지 프리뷰 툴팁 */
        .image-preview-tooltip {
            position: fixed;
            display: none;
            z-index: 9999;
            pointer-events: none;
            background: var(--bg-card);
            border-radius: 12px;
            padding: 6px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            border: 1px solid var(--border);
        }
        .image-preview-tooltip img {
            width: 200px;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
        }

        /* 공지사항 스타일 */
        .board-row.notice-row {
            background: rgba(233, 69, 96, 0.06);
        }
        .board-row.notice-row:hover {
            background: rgba(233, 69, 96, 0.1);
        }
        [data-theme="dark"] .board-row.notice-row {
            background: rgba(233, 69, 96, 0.12);
        }
        [data-theme="dark"] .board-row.notice-row:hover {
            background: rgba(233, 69, 96, 0.18);
        }
        .category-badge.notice {
            background: linear-gradient(135deg, var(--accent), #ff6b6b) !important;
            color: white !important;
        }
        .board-row.notice-row .post-title-text {
            font-weight: 600;
        }
    </style>
</body>
</html>
