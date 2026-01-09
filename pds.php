<?php $current_page = 'pds'; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <script>document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');</script>
    <?php include 'includes/head.php'; ?>
    <title>자료실 - 그누보드</title>
    <style>
        /* 자료실 페이지 전용 CSS */
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
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .page-title-icon svg { width: 24px; height: 24px; color: white; }

        .page-title h1 { font-size: 24px; font-weight: 700; }
        .page-title p { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }

        .write-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 8px 14px;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            border: none; border-radius: 8px;
            color: white; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .write-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4); }
        .write-btn svg { width: 14px; height: 14px; }

        /* 베스트 자료 섹션 */
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
            color: #10b981;
            background: var(--bg-main);
            border-bottom: 2px solid #10b981;
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

        .best-item-downloads {
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

        /* 자료실 테이블 */
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
            grid-template-columns: auto 1fr 100px 80px 80px 70px;
            gap: 12px;
            padding: 14px 20px;
            background: var(--bg-main);
            font-size: 12px; font-weight: 600;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border);
        }

        .board-row {
            display: grid;
            grid-template-columns: auto 1fr 100px 80px 80px 70px;
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
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
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

        .category-badge.program { background: rgba(99, 102, 241, 0.1); color: #6366f1; }
        .category-badge.document { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .category-badge.image { background: rgba(236, 72, 153, 0.1); color: #ec4899; }
        .category-badge.video { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .category-badge.music { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

        .post-title-cell {
            display: flex; align-items: center; gap: 8px;
        }

        .post-title-text {
            font-size: 14px; font-weight: 500;
            color: var(--text-primary);
            display: flex; align-items: center; gap: 4px;
        }

        .post-title-text:hover { color: #10b981; }

        .file-icon {
            width: 16px; height: 16px;
            flex-shrink: 0;
        }

        .file-icon.zip { color: #f59e0b; }
        .file-icon.pdf { color: #ef4444; }
        .file-icon.doc { color: #3b82f6; }
        .file-icon.img { color: #ec4899; }
        .file-icon.video { color: #8b5cf6; }

        .file-size {
            font-size: 11px;
            color: var(--text-light);
            background: var(--bg-main);
            padding: 2px 6px;
            border-radius: 4px;
        }

        .comment-count {
            font-size: 12px; font-weight: 600;
            color: #3b82f6;
        }

        .new-badge {
            padding: 2px 6px;
            background: #10b981;
            color: white;
            font-size: 9px; font-weight: 700;
            border-radius: 4px;
        }

        .image-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            color: #ec4899;
            flex-shrink: 0;
        }
        .image-badge svg {
            width: 14px;
            height: 14px;
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
        .post-download-cost {
            font-size: 12px;
            color: #10b981;
            text-align: center;
            font-weight: 600;
        }
        .post-download-cost.cash { color: var(--accent); }
        .post-download-cost.point { color: #f59e0b; }
        .post-download-cost.free { color: var(--text-light); }
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

        .page-btn:hover { border-color: #10b981; color: #10b981; }

        .page-btn.active {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
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

        .modal-close:hover { border-color: #10b981; color: #10b981; }

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
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
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

        .search-option:hover { border-color: #10b981; }

        .search-option.active {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.08);
            color: #10b981;
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
            border-color: #10b981;
            border-width: 5px;
        }

        .search-submit {
            width: 100%;
            padding: 14px;
            font-size: 15px; font-weight: 600;
            border: none; border-radius: 12px;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            cursor: pointer; transition: all 0.3s;
        }

        .search-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
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

            .post-download-cost {
                display: block;
                flex-shrink: 0;
                font-size: 11px;
                margin-left: auto;
            }

            .post-date {
                display: none;
            }

            .board-row .post-meta {
                display: none;
            }

            .comment-count,
            .new-badge,
            .hot-badge,
            .file-size {
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

        /* 이미지 미리보기 툴팁 */
        .image-preview-tooltip {
            position: fixed;
            z-index: 9999;
            background: var(--bg-card);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            padding: 8px;
            pointer-events: none;
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.2s, transform 0.2s;
            border: 1px solid var(--border);
        }
        .image-preview-tooltip.visible {
            opacity: 1;
            transform: scale(1);
        }
        .image-preview-tooltip img {
            display: block;
            max-width: 280px;
            max-height: 200px;
            border-radius: 8px;
            object-fit: cover;
        }
        .image-preview-tooltip .preview-title {
            margin-top: 8px;
            font-size: 12px;
            color: var(--text-secondary);
            text-align: center;
            max-width: 280px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                    </div>
                    <div>
                        <h1>자료실</h1>
                        <p>유용한 자료를 공유하는 공간입니다</p>
                    </div>
                </div>
                <button class="write-btn" onclick="location.href='pds_write.php'">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    자료 올리기
                </button>
            </div>

            <!-- 베스트 자료 -->
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

            <!-- 자료 목록 -->
            <section class="board-section">
                <div class="board-table-header">
                    <span>분류</span>
                    <span>제목</span>
                    <span>작성자</span>
                    <span>날짜</span>
                    <span style="text-align:center">다운C/P</span>
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
            <h2 class="modal-title">자료 검색</h2>
            <p class="modal-desc">찾고 싶은 자료를 검색해보세요</p>

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

    <!-- 이미지 미리보기 툴팁 -->
    <div class="image-preview-tooltip" id="imagePreviewTooltip">
        <img src="" alt="미리보기" id="previewImage">
        <div class="preview-title" id="previewTitle"></div>
    </div>

    <?php include 'includes/popup.php'; ?>
    <?php include 'includes/footer.php'; ?>

    <script>
        // 파일 아이콘 SVG
        const fileIcons = {
            zip: `<svg class="file-icon zip" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8v13H3V3h12l6 5z"/><path d="M10 12h4"/><path d="M10 15h4"/><path d="M10 9h4"/></svg>`,
            pdf: `<svg class="file-icon pdf" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>`,
            doc: `<svg class="file-icon doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10,9 9,9 8,9"/></svg>`,
            img: `<svg class="file-icon img" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>`,
            video: `<svg class="file-icon video" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23,7 16,12 23,17 23,7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>`,
        };

        // 공지사항 (상단 고정)
        const notices = [
            { id: 100, category: '공지', title: '[필독] 자료실 이용 규칙 및 저작권 안내', author: '관리자', level: 10, date: '01-06', views: 4520, likes: 45, comments: 12, isNew: false, isHot: false, fileType: 'pdf', fileSize: '245KB', downloadCost: { type: 'free', value: 0 }, isNotice: true },
        ];

        // 일반 자료
        const posts = [
            { id: 1, category: '프로그램', title: '그누보드 프리미엄 테마 v2.0', author: '개발자킴', level: 8, date: '01-08', views: 3523, likes: 234, comments: 45, isNew: true, isHot: true, fileType: 'zip', fileSize: '15.2MB', downloadCost: { type: 'cash', value: 500 }, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=300&h=200&fit=crop' },
            { id: 2, category: '문서', title: 'PHP 개발 가이드 완벽정리 PDF', author: '코딩마스터', level: 7, date: '01-08', views: 2341, likes: 167, comments: 32, isNew: true, isHot: false, fileType: 'pdf', fileSize: '8.7MB', downloadCost: { type: 'point', value: 300 }, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?w=300&h=200&fit=crop' },
            { id: 3, category: '이미지', title: '무료 아이콘 팩 500종 모음', author: '디자이너', level: 5, date: '01-08', views: 1876, likes: 289, comments: 23, isNew: true, isHot: true, fileType: 'zip', fileSize: '45.3MB', downloadCost: { type: 'point', value: 200 }, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1558655146-9f40138edfeb?w=300&h=200&fit=crop' },
            { id: 4, category: '프로그램', title: 'MySQL 백업 자동화 스크립트', author: 'DB관리자', level: 6, date: '01-07', views: 1234, likes: 89, comments: 15, isNew: false, isHot: false, fileType: 'zip', fileSize: '2.1MB', downloadCost: { type: 'free', value: 0 }, hasImage: false },
            { id: 5, category: '문서', title: '웹 보안 체크리스트 2025', author: '보안전문가', level: 9, date: '01-07', views: 987, likes: 123, comments: 8, isNew: false, isHot: false, fileType: 'pdf', fileSize: '1.5MB', downloadCost: { type: 'point', value: 100 }, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?w=300&h=200&fit=crop' },
            { id: 6, category: '동영상', title: 'React 강의 풀버전 (10시간)', author: '프론트개발', level: 4, date: '01-07', views: 3456, likes: 456, comments: 67, isNew: false, isHot: true, fileType: 'video', fileSize: '4.2GB', downloadCost: { type: 'cash', value: 1000 }, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=300&h=200&fit=crop' },
            { id: 7, category: '문서', title: '2025년 IT 트렌드 리포트', author: '기술분석가', level: 6, date: '01-06', views: 2876, likes: 234, comments: 28, isNew: false, isHot: false, fileType: 'doc', fileSize: '3.8MB', downloadCost: { type: 'point', value: 150 }, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=300&h=200&fit=crop' },
            { id: 8, category: '이미지', title: '고해상도 배경화면 모음', author: '사진작가', level: 3, date: '01-06', views: 1654, likes: 178, comments: 19, isNew: false, isHot: false, fileType: 'img', fileSize: '128MB', downloadCost: { type: 'free', value: 0 }, hasImage: true, thumbnail: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=300&h=200&fit=crop' },
        ];

        const bestPosts = {
            daily: [
                { title: '그누보드 프리미엄 테마 v2.0', downloads: 567 },
                { title: '무료 아이콘 팩 500종 모음', downloads: 434 },
                { title: 'React 강의 풀버전 (10시간)', downloads: 389 },
                { title: 'PHP 개발 가이드 완벽정리 PDF', downloads: 312 },
                { title: '고해상도 배경화면 모음', downloads: 289 },
                { title: '2025년 IT 트렌드 리포트', downloads: 234 },
                { title: 'MySQL 백업 자동화 스크립트', downloads: 198 },
                { title: '웹 보안 체크리스트 2025', downloads: 156 },
                { title: 'CSS 애니메이션 예제 모음', downloads: 134 },
                { title: 'Node.js 서버 템플릿', downloads: 112 },
            ],
            weekly: [
                { title: '풀스택 개발 강의 시리즈', downloads: 2341 },
                { title: 'AI 챗봇 구현 소스코드', downloads: 1876 },
                { title: '모바일 앱 UI 키트', downloads: 1654 },
                { title: 'Docker 실무 가이드', downloads: 1432 },
                { title: 'AWS 아키텍처 설계서', downloads: 1287 },
                { title: '데이터분석 파이썬 예제', downloads: 1156 },
                { title: 'Git 협업 가이드북', downloads: 987 },
                { title: 'API 설계 템플릿', downloads: 876 },
                { title: '보안 점검 도구 모음', downloads: 765 },
                { title: '성능 최적화 체크리스트', downloads: 654 },
            ],
            monthly: [
                { title: '개발자 필수 도구 100선', downloads: 5678 },
                { title: '머신러닝 입문 강의', downloads: 4532 },
                { title: '클린코드 실전 예제집', downloads: 3987 },
                { title: '시스템 설계 면접 가이드', downloads: 3456 },
                { title: '쿠버네티스 실습 환경', downloads: 2987 },
                { title: '마이크로서비스 아키텍처', downloads: 2654 },
                { title: 'CI/CD 파이프라인 템플릿', downloads: 2321 },
                { title: '모니터링 대시보드 템플릿', downloads: 1987 },
                { title: '로그 분석 도구 모음', downloads: 1654 },
                { title: '테스트 자동화 프레임워크', downloads: 1321 },
            ],
        };

        let currentPeriod = 'daily';
        let searchType = 'title';

        // 베스트 자료 렌더링
        function renderBestPosts() {
            const list = document.getElementById('bestList');
            const items = bestPosts[currentPeriod];
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                list.innerHTML = items.map((post, idx) => `
                    <div class="best-item" onclick="location.href='pds_view.php?id=${idx + 1}'">
                        <div class="rank-badge ${idx < 3 ? 'rank-' + (idx + 1) : 'rank-other'}">${idx + 1}</div>
                        <span class="best-item-title">${post.title}</span>
                        <span class="best-item-downloads">${post.downloads.toLocaleString()}</span>
                    </div>
                `).join('');
            } else {
                const half = Math.ceil(items.length / 2);
                const reordered = [];
                for (let i = 0; i < half; i++) {
                    reordered.push({ ...items[i], originalIdx: i });
                    if (i + half < items.length) {
                        reordered.push({ ...items[i + half], originalIdx: i + half });
                    }
                }

                list.innerHTML = reordered.map((post) => `
                    <div class="best-item" onclick="location.href='pds_view.php?id=${post.originalIdx + 1}'">
                        <div class="rank-badge ${post.originalIdx < 3 ? 'rank-' + (post.originalIdx + 1) : 'rank-other'}">${post.originalIdx + 1}</div>
                        <span class="best-item-title">${post.title}</span>
                        <span class="best-item-downloads">${post.downloads.toLocaleString()}</span>
                    </div>
                `).join('');
            }
        }

        // 다운로드 비용 표시
        function formatDownloadCost(cost) {
            if (cost.type === 'free') return { text: '무료', class: 'free' };
            if (cost.type === 'cash') return { text: cost.value + 'C', class: 'cash' };
            if (cost.type === 'point') return { text: cost.value + 'P', class: 'point' };
            return { text: '-', class: '' };
        }

        // 자료 목록 렌더링
        function renderPosts() {
            const list = document.getElementById('boardList');
            const isMobile = window.innerWidth <= 992;
            const allPosts = [...notices, ...posts];

            list.innerHTML = allPosts.map(post => {
                const isNotice = post.isNotice || post.category === '공지';
                const noticeClass = isNotice ? 'notice-row' : '';
                const fileIcon = fileIcons[post.fileType] || fileIcons.zip;
                const costInfo = formatDownloadCost(post.downloadCost);
                const categoryClass = post.category === '프로그램' ? 'program' :
                                     post.category === '문서' ? 'document' :
                                     post.category === '이미지' ? 'image' :
                                     post.category === '동영상' ? 'video' : '';
                const hoverEvents = post.hasImage && post.thumbnail ?
                    `onmouseenter="showImagePreview(event, ${post.id})" onmouseleave="hideImagePreview()" onmousemove="updatePreviewPosition(event)"` : '';
                const imageIcon = post.hasImage ? `<span class="image-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg></span>` : '';

                if (isMobile) {
                    return `
                        <div class="board-row ${noticeClass}" onclick="location.href='pds_view.php?id=${post.id}'">
                            <span class="category-badge ${isNotice ? 'notice' : categoryClass}">${post.category}</span>
                            <div class="post-title-cell">
                                <span class="post-title-text">${fileIcon}${post.title}</span>
                                ${imageIcon}
                                <span class="file-size">${post.fileSize}</span>
                                ${post.comments > 0 ? `<span class="comment-count">[${post.comments}]</span>` : ''}
                                ${post.isNew ? '<span class="new-badge">N</span>' : ''}
                                ${post.isHot ? '<span class="hot-badge">HOT</span>' : ''}
                            </div>
                            <span class="post-download-cost ${costInfo.class}">${costInfo.text}</span>
                        </div>
                    `;
                } else {
                    return `
                        <div class="board-row ${noticeClass}" ${hoverEvents} onclick="location.href='pds_view.php?id=${post.id}'">
                            <span class="category-badge ${isNotice ? 'notice' : categoryClass}">${post.category}</span>
                            <div class="post-title-cell">
                                <span class="post-title-text">${fileIcon}${post.title}</span>
                                ${imageIcon}
                                <span class="file-size">${post.fileSize}</span>
                                ${post.comments > 0 ? `<span class="comment-count">[${post.comments}]</span>` : ''}
                                ${post.isNew ? '<span class="new-badge">N</span>' : ''}
                                ${post.isHot ? '<span class="hot-badge">HOT</span>' : ''}
                            </div>
                            <span class="post-author"><span class="author-level-wrap lv-${post.level > 5 ? 'high' : 'normal'}"><span class="author-level-num">${post.level}</span><span class="author-level-badge"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg></span></span>${post.author}</span>
                            <span class="post-date">${post.date}</span>
                            <span class="post-download-cost ${costInfo.class}">${costInfo.text}</span>
                            <span class="post-likes">♥ ${post.likes}</span>
                        </div>
                    `;
                }
            }).join('');
        }

        // 이미지 미리보기 함수들
        function showImagePreview(event, postId) {
            const allPosts = [...notices, ...posts];
            const post = allPosts.find(p => p.id === postId);
            if (!post || !post.thumbnail) return;

            const tooltip = document.getElementById('imagePreviewTooltip');
            const img = document.getElementById('previewImage');
            const title = document.getElementById('previewTitle');

            img.src = post.thumbnail;
            title.textContent = post.title;

            updatePreviewPosition(event);
            tooltip.classList.add('visible');
        }

        function hideImagePreview() {
            const tooltip = document.getElementById('imagePreviewTooltip');
            tooltip.classList.remove('visible');
        }

        function updatePreviewPosition(event) {
            const tooltip = document.getElementById('imagePreviewTooltip');
            const padding = 15;
            let x = event.clientX + padding;
            let y = event.clientY + padding;

            // 화면 오른쪽 경계 체크
            if (x + 300 > window.innerWidth) {
                x = event.clientX - 300 - padding;
            }

            // 화면 하단 경계 체크
            if (y + 250 > window.innerHeight) {
                y = event.clientY - 250 - padding;
            }

            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';
        }

        // 윈도우 리사이즈 시 재렌더링
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                renderPosts();
                renderBestPosts();
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

        // 초기 렌더링
        renderBestPosts();
        renderPosts();
    </script>
</body>
</html>
