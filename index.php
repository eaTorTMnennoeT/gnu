<?php $current_page = 'home'; ?>
<!DOCTYPE html>
<html lang="ko" data-theme="light">
<head>
    <?php include 'includes/head.php'; ?>
    <title>그누보드 프리미엄 테마</title>
    <style>
        /* 인기글 가로 */
        .popular-bar {
            background: var(--bg-card);
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            margin-bottom: 16px;
            overflow: hidden;
        }

        .popular-bar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            background: var(--bg-main);
            border-bottom: 1px solid var(--border);
        }

        .popular-bar-title {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .popular-tabs {
            display: flex;
            gap: 4px;
        }

        .popular-tab {
            padding: 4px 10px;
            font-size: 10px;
            font-weight: 500;
            color: var(--text-secondary);
            background: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .popular-tab:hover { background: var(--border); }
        .popular-tab.active { background: var(--accent); color: white; }

        .popular-bar-list {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0;
        }

        .popular-bar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-right: 1px solid var(--border);
            transition: background 0.2s;
        }

        .popular-bar-item:nth-child(5),
        .popular-bar-item:nth-child(10) {
            border-right: none;
        }

        .popular-bar-item:nth-child(n+6) {
            border-top: 1px solid var(--border);
        }

        .popular-bar-item:hover { background: var(--bg-main); }

        .popular-rank {
            width: 22px;
            height: 22px;
            background: var(--bg-main);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-secondary);
            flex-shrink: 0;
        }

        .popular-rank.top { background: linear-gradient(135deg, var(--accent) 0%, #ff6b6b 100%); color: white; }

        .popular-info { flex: 1; min-width: 0; }

        .popular-info a {
            display: block;
            font-size: 12px;
            color: var(--text-primary);
            text-decoration: none;
            word-break: break-word;
            overflow-wrap: break-word;
            line-height: 1.4;
            transition: color 0.2s;
        }

        .popular-info a:hover { color: var(--accent); }
        .popular-meta { font-size: 9px; color: var(--text-light); margin-top: 1px; }

        /* 갤러리 가로 */
        .gallery-bar {
            background: var(--bg-card);
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            margin-bottom: 16px;
            overflow: hidden;
        }

        .gallery-bar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            background: var(--bg-main);
            border-bottom: 1px solid var(--border);
        }

        .gallery-bar-title { font-size: 13px; font-weight: 600; }

        .gallery-bar-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 10px;
            padding: 14px;
        }

        .gallery-bar-item {
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
        }

        .gallery-bar-item svg {
            width: 100%;
            height: 100%;
            transition: transform 0.3s;
        }

        .gallery-bar-item:hover svg { transform: scale(1.1); }

        .gallery-item-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px 6px 6px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .gallery-bar-item:hover .gallery-item-overlay { opacity: 1; }
        .gallery-item-title { font-size: 9px; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .board-more {
            color: var(--text-light);
            font-size: 10px;
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .board-more:hover { background: var(--border); color: var(--accent); }

        /* 게시판 그리드 */
        .boards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .board-card {
            background: var(--bg-card);
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.3s;
        }

        .board-card:hover { box-shadow: var(--shadow-md); }

        .board-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
            background: var(--bg-main);
        }

        .board-title { display: flex; align-items: center; gap: 8px; }

        .board-title-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .board-title-icon.free { background: rgba(99, 102, 241, 0.15); color: #6366f1; }
        .board-title-icon.qna { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .board-title-icon.gallery { background: rgba(244, 63, 94, 0.15); color: #f43f5e; }
        .board-title-icon.download { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
        .board-title-icon svg { width: 14px; height: 14px; }
        .board-title h3 { font-size: 13px; font-weight: 600; }

        .board-list { list-style: none; }

        .board-item {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            transition: background 0.2s;
        }

        .board-item:last-child { border-bottom: none; }
        .board-item:hover { background: var(--bg-main); }

        .board-item-title {
            flex: 1;
            font-size: 12px;
            color: var(--text-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color 0.2s;
        }

        .board-item-title:hover { color: var(--accent); }

        .board-item-title .new {
            background: var(--accent);
            color: white;
            font-size: 8px;
            font-weight: 700;
            padding: 1px 3px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        .board-item-title .hot { background: var(--gold); color: var(--primary); }
        .board-item-comment { color: var(--accent); font-size: 10px; font-weight: 600; flex-shrink: 0; margin-left: 4px; }

        .board-item-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            font-size: 10px;
            flex-shrink: 0;
            margin-left: 10px;
        }

        /* 반응형 - 페이지 전용 */
        @media (max-width: 1400px) and (min-width: 993px) {
            .popular-bar-list { grid-template-columns: repeat(5, 1fr); }
            .popular-bar-item:nth-child(n+6) { display: none; }
            .gallery-bar-grid { grid-template-columns: repeat(6, 1fr); }
        }

        @media (max-width: 1200px) {
            .boards-grid { grid-template-columns: 1fr; }
            .gallery-bar-grid { grid-template-columns: repeat(5, 1fr); }
        }

        @media (max-width: 992px) {
            .popular-bar-list {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .popular-bar-item,
            .popular-bar-item:nth-child(1),
            .popular-bar-item:nth-child(2),
            .popular-bar-item:nth-child(3),
            .popular-bar-item:nth-child(4),
            .popular-bar-item:nth-child(5),
            .popular-bar-item:nth-child(6),
            .popular-bar-item:nth-child(7),
            .popular-bar-item:nth-child(8),
            .popular-bar-item:nth-child(9),
            .popular-bar-item:nth-child(10) {
                display: flex !important;
                border-right: 1px solid var(--border);
                border-bottom: 1px solid var(--border);
            }
            .popular-bar-item:nth-child(2n) {
                border-right: none;
            }
            .popular-bar-item:nth-child(n+9) {
                border-bottom: none;
            }
            .popular-bar-item:nth-child(9),
            .popular-bar-item:nth-child(10) {
                border-bottom: none;
            }

            .popular-info a {
                white-space: normal;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                line-height: 1.4;
                max-height: 2.8em;
            }

            .popular-bar-header {
                flex-wrap: wrap;
                gap: 8px;
            }

            .popular-tabs {
                gap: 6px;
                z-index: 100;
            }

            .popular-tab {
                padding: 8px 14px;
                font-size: 12px;
                cursor: pointer;
                -webkit-tap-highlight-color: transparent;
                min-height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .gallery-bar-grid { grid-template-columns: repeat(4, 1fr); }
        }

        @media (max-width: 768px) {
            .popular-bar-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 12px;
            }

            .popular-tabs {
                width: 100%;
                justify-content: flex-start;
                gap: 8px;
            }

            .popular-tab {
                padding: 10px 16px;
                font-size: 13px;
                min-height: 40px;
                flex: 1;
            }

            .popular-bar-list {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            .popular-bar-item,
            .popular-bar-item:nth-child(1),
            .popular-bar-item:nth-child(2),
            .popular-bar-item:nth-child(3),
            .popular-bar-item:nth-child(4),
            .popular-bar-item:nth-child(5),
            .popular-bar-item:nth-child(6),
            .popular-bar-item:nth-child(7),
            .popular-bar-item:nth-child(8),
            .popular-bar-item:nth-child(9),
            .popular-bar-item:nth-child(10) {
                display: flex !important;
                border-right: 1px solid var(--border);
                border-bottom: 1px solid var(--border);
            }
            .popular-bar-item:nth-child(2n) {
                border-right: none;
            }
            .popular-bar-item:nth-child(9),
            .popular-bar-item:nth-child(10) {
                border-bottom: none;
            }
            .gallery-bar-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 480px) {
            .board-item-meta { display: none; }
            .gallery-bar-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <!-- 메인 -->
    <div class="main-wrapper">
        <?php include 'includes/header.php'; ?>

        <!-- 메인 컨텐츠 -->
        <main class="main-content">
            <!-- 인기글 가로 바 -->
            <div class="popular-bar">
                <div class="popular-bar-header">
                    <span class="popular-bar-title">🔥 인기글 TOP 10</span>
                    <div class="popular-tabs">
                        <button class="popular-tab active">일간</button>
                        <button class="popular-tab">주간</button>
                        <button class="popular-tab">월간</button>
                    </div>
                </div>
                <div class="popular-bar-list">
                    <div class="popular-bar-item">
                        <span class="popular-rank top">1</span>
                        <div class="popular-info">
                            <a href="#">그누보드 5.5 새로운 기능 총정리</a>
                            <div class="popular-meta">자유 · 👁 2,847</div>
                        </div>
                    </div>
                    <div class="popular-bar-item">
                        <span class="popular-rank top">2</span>
                        <div class="popular-info">
                            <a href="#">초보자를 위한 PHP 기초 강좌</a>
                            <div class="popular-meta">질문 · 👁 1,923</div>
                        </div>
                    </div>
                    <div class="popular-bar-item">
                        <span class="popular-rank top">3</span>
                        <div class="popular-info">
                            <a href="#">무료 부트스트랩 템플릿 모음</a>
                            <div class="popular-meta">자료 · 👁 1,456</div>
                        </div>
                    </div>
                    <div class="popular-bar-item">
                        <span class="popular-rank">4</span>
                        <div class="popular-info">
                            <a href="#">사이트 속도 최적화 방법</a>
                            <div class="popular-meta">질문 · 👁 1,234</div>
                        </div>
                    </div>
                    <div class="popular-bar-item">
                        <span class="popular-rank">5</span>
                        <div class="popular-info">
                            <a href="#">SEO 최적화 완벽 가이드</a>
                            <div class="popular-meta">자료 · 👁 987</div>
                        </div>
                    </div>
                    <div class="popular-bar-item">
                        <span class="popular-rank">6</span>
                        <div class="popular-info">
                            <a href="#">오늘의 고양이 사진 모음</a>
                            <div class="popular-meta">갤러리 · 👁 876</div>
                        </div>
                    </div>
                    <div class="popular-bar-item">
                        <span class="popular-rank">7</span>
                        <div class="popular-info">
                            <a href="#">MySQL vs PostgreSQL 비교</a>
                            <div class="popular-meta">질문 · 👁 765</div>
                        </div>
                    </div>
                    <div class="popular-bar-item">
                        <span class="popular-rank">8</span>
                        <div class="popular-info">
                            <a href="#">React vs Vue 뭐가 좋을까요</a>
                            <div class="popular-meta">질문 · 👁 654</div>
                        </div>
                    </div>
                    <div class="popular-bar-item">
                        <span class="popular-rank">9</span>
                        <div class="popular-info">
                            <a href="#">무료 아이콘 사이트 추천</a>
                            <div class="popular-meta">자료 · 👁 543</div>
                        </div>
                    </div>
                    <div class="popular-bar-item">
                        <span class="popular-rank">10</span>
                        <div class="popular-info">
                            <a href="#">제주도 여행 사진 공유</a>
                            <div class="popular-meta">갤러리 · 👁 432</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 갤러리 가로 바 -->
            <div class="gallery-bar">
                <div class="gallery-bar-header">
                    <span class="gallery-bar-title">📷 최신 갤러리</span>
                    <a href="#" class="board-more">더보기 +</a>
                </div>
                <div class="gallery-bar-grid">
                    <div class="gallery-bar-item">
                        <svg viewBox="0 0 100 100"><defs><linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#667eea"/><stop offset="100%" style="stop-color:#764ba2"/></linearGradient></defs><rect fill="url(#g1)" width="100" height="100"/><circle cx="30" cy="35" r="12" fill="rgba(255,255,255,0.3)"/><polygon points="20,85 50,50 80,85" fill="rgba(255,255,255,0.2)"/></svg>
                        <div class="gallery-item-overlay"><span class="gallery-item-title">제주도 바다</span></div>
                    </div>
                    <div class="gallery-bar-item">
                        <svg viewBox="0 0 100 100"><defs><linearGradient id="g2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#f093fb"/><stop offset="100%" style="stop-color:#f5576c"/></linearGradient></defs><rect fill="url(#g2)" width="100" height="100"/><rect x="25" y="25" width="50" height="50" rx="8" fill="rgba(255,255,255,0.2)"/><circle cx="50" cy="50" r="15" fill="rgba(255,255,255,0.3)"/></svg>
                        <div class="gallery-item-overlay"><span class="gallery-item-title">고양이 사진</span></div>
                    </div>
                    <div class="gallery-bar-item">
                        <svg viewBox="0 0 100 100"><defs><linearGradient id="g3" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#4facfe"/><stop offset="100%" style="stop-color:#00f2fe"/></linearGradient></defs><rect fill="url(#g3)" width="100" height="100"/><path d="M20,70 Q50,20 80,70" stroke="rgba(255,255,255,0.4)" fill="none" stroke-width="3"/><circle cx="35" cy="45" r="8" fill="rgba(255,255,255,0.3)"/></svg>
                        <div class="gallery-item-overlay"><span class="gallery-item-title">산 풍경</span></div>
                    </div>
                    <div class="gallery-bar-item">
                        <svg viewBox="0 0 100 100"><defs><linearGradient id="g4" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#43e97b"/><stop offset="100%" style="stop-color:#38f9d7"/></linearGradient></defs><rect fill="url(#g4)" width="100" height="100"/><polygon points="50,20 80,80 20,80" fill="rgba(255,255,255,0.25)"/><circle cx="50" cy="55" r="12" fill="rgba(255,255,255,0.3)"/></svg>
                        <div class="gallery-item-overlay"><span class="gallery-item-title">봄꽃 사진</span></div>
                    </div>
                    <div class="gallery-bar-item">
                        <svg viewBox="0 0 100 100"><defs><linearGradient id="g5" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#fa709a"/><stop offset="100%" style="stop-color:#fee140"/></linearGradient></defs><rect fill="url(#g5)" width="100" height="100"/><rect x="20" y="30" width="25" height="40" rx="4" fill="rgba(255,255,255,0.25)"/><rect x="55" y="40" width="25" height="30" rx="4" fill="rgba(255,255,255,0.2)"/></svg>
                        <div class="gallery-item-overlay"><span class="gallery-item-title">카페 인테리어</span></div>
                    </div>
                    <div class="gallery-bar-item">
                        <svg viewBox="0 0 100 100"><defs><linearGradient id="g6" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#a18cd1"/><stop offset="100%" style="stop-color:#fbc2eb"/></linearGradient></defs><rect fill="url(#g6)" width="100" height="100"/><circle cx="30" cy="40" r="15" fill="rgba(255,255,255,0.25)"/><circle cx="70" cy="60" r="20" fill="rgba(255,255,255,0.2)"/></svg>
                        <div class="gallery-item-overlay"><span class="gallery-item-title">야경 사진</span></div>
                    </div>
                    <div class="gallery-bar-item">
                        <svg viewBox="0 0 100 100"><defs><linearGradient id="g7" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff9a9e"/><stop offset="100%" style="stop-color:#fecfef"/></linearGradient></defs><rect fill="url(#g7)" width="100" height="100"/><rect x="30" y="20" width="40" height="60" rx="6" fill="rgba(255,255,255,0.25)"/></svg>
                        <div class="gallery-item-overlay"><span class="gallery-item-title">음식 사진</span></div>
                    </div>
                    <div class="gallery-bar-item">
                        <svg viewBox="0 0 100 100"><defs><linearGradient id="g8" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ffecd2"/><stop offset="100%" style="stop-color:#fcb69f"/></linearGradient></defs><rect fill="url(#g8)" width="100" height="100"/><circle cx="50" cy="40" r="20" fill="rgba(255,255,255,0.3)"/><rect x="35" y="55" width="30" height="25" rx="4" fill="rgba(255,255,255,0.25)"/></svg>
                        <div class="gallery-item-overlay"><span class="gallery-item-title">일상 스냅</span></div>
                    </div>
                </div>
            </div>

            <!-- 게시판 그리드 -->
            <div class="boards-grid">
                <!-- 자유게시판 -->
                <div class="board-card">
                    <div class="board-header">
                        <div class="board-title">
                            <div class="board-title-icon free"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
                            <h3>자유게시판</h3>
                        </div>
                        <a href="#" class="board-more">더보기 +</a>
                    </div>
                    <ul class="board-list">
                        <li class="board-item"><a href="#" class="board-item-title">그누보드 신규 테마 적용 후기입니다 <span class="new">N</span></a><span class="board-item-comment">[15]</span><div class="board-item-meta"><span>김철수</span><span>10분전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">오늘 날씨가 정말 좋네요</a><span class="board-item-comment">[5]</span><div class="board-item-meta"><span>행복이</span><span>25분전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">주말에 뭐하세요? <span class="new hot">HOT</span></a><span class="board-item-comment">[42]</span><div class="board-item-meta"><span>주말여행</span><span>1시간전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">점심 메뉴 추천해주세요</a><span class="board-item-comment">[8]</span><div class="board-item-meta"><span>맛집탐방</span><span>2시간전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">새해 목표 공유합니다</a><span class="board-item-comment">[23]</span><div class="board-item-meta"><span>새출발</span><span>3시간전</span></div></li>
                    </ul>
                </div>

                <!-- 질문답변 -->
                <div class="board-card">
                    <div class="board-header">
                        <div class="board-title">
                            <div class="board-title-icon qna"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
                            <h3>질문답변</h3>
                        </div>
                        <a href="#" class="board-more">더보기 +</a>
                    </div>
                    <ul class="board-list">
                        <li class="board-item"><a href="#" class="board-item-title">PHP 8.2 호환성 이슈 해결 방법 <span class="new">N</span></a><span class="board-item-comment">[31]</span><div class="board-item-meta"><span>초보개발</span><span>5분전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">반응형 레이아웃 CSS 질문드립니다</a><span class="board-item-comment">[12]</span><div class="board-item-meta"><span>웹초보</span><span>30분전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">MySQL 쿼리 최적화 방법 <span class="new hot">HOT</span></a><span class="board-item-comment">[56]</span><div class="board-item-meta"><span>DB마스터</span><span>1시간전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">JavaScript 비동기 처리 질문</a><span class="board-item-comment">[7]</span><div class="board-item-meta"><span>JS러버</span><span>2시간전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">서버 보안 설정 관련 질문</a><span class="board-item-comment">[15]</span><div class="board-item-meta"><span>보안전문</span><span>4시간전</span></div></li>
                    </ul>
                </div>

                <!-- 유머게시판 -->
                <div class="board-card">
                    <div class="board-header">
                        <div class="board-title">
                            <div class="board-title-icon gallery"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg></div>
                            <h3>유머게시판</h3>
                        </div>
                        <a href="#" class="board-more">더보기 +</a>
                    </div>
                    <ul class="board-list">
                        <li class="board-item"><a href="#" class="board-item-title">웃긴 짤 모음 ㅋㅋㅋ <span class="new hot">HOT</span></a><span class="board-item-comment">[89]</span><div class="board-item-meta"><span>웃음충전</span><span>15분전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">오늘자 드립 모음</a><span class="board-item-comment">[34]</span><div class="board-item-meta"><span>개그맨</span><span>45분전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">직장인 공감 짤 <span class="new">N</span></a><span class="board-item-comment">[67]</span><div class="board-item-meta"><span>직장인</span><span>1시간전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">레전드 댓글 모음</a><span class="board-item-comment">[45]</span><div class="board-item-meta"><span>댓글러</span><span>3시간전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">어이없는 상황 모음</a><span class="board-item-comment">[28]</span><div class="board-item-meta"><span>헛웃음</span><span>5시간전</span></div></li>
                    </ul>
                </div>

                <!-- 자료실 -->
                <div class="board-card">
                    <div class="board-header">
                        <div class="board-title">
                            <div class="board-title-icon download"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></div>
                            <h3>자료실</h3>
                        </div>
                        <a href="#" class="board-more">더보기 +</a>
                    </div>
                    <ul class="board-list">
                        <li class="board-item"><a href="#" class="board-item-title">무료 아이콘 모음 공유합니다 <span class="new">N</span></a><span class="board-item-comment">[23]</span><div class="board-item-meta"><span>디자이너</span><span>20분전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">부트스트랩 테마 모음 <span class="new hot">HOT</span></a><span class="board-item-comment">[67]</span><div class="board-item-meta"><span>프론트엔드</span><span>1시간전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">PHP 유틸리티 클래스 공유</a><span class="board-item-comment">[34]</span><div class="board-item-meta"><span>백엔드</span><span>2시간전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">그누보드 스킨 배포합니다</a><span class="board-item-comment">[45]</span><div class="board-item-meta"><span>스킨장인</span><span>4시간전</span></div></li>
                        <li class="board-item"><a href="#" class="board-item-title">무료 폰트 모음 2024</a><span class="board-item-comment">[19]</span><div class="board-item-meta"><span>타이포</span><span>6시간전</span></div></li>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    <?php include 'includes/popup.php'; ?>
    <?php include 'includes/footer.php'; ?>

    <script>
        // 인기글 데이터
        const popularPosts = {
            daily: [
                { rank: 1, title: '그누보드 5.5 새로운 기능 총정리', category: '자유', views: 2847 },
                { rank: 2, title: '초보자를 위한 PHP 기초 강좌', category: '질문', views: 1923 },
                { rank: 3, title: '무료 부트스트랩 템플릿 모음', category: '자료', views: 1456 },
                { rank: 4, title: '사이트 속도 최적화 방법', category: '질문', views: 1234 },
                { rank: 5, title: 'SEO 최적화 완벽 가이드', category: '자료', views: 987 },
                { rank: 6, title: '오늘의 고양이 사진 모음', category: '갤러리', views: 876 },
                { rank: 7, title: 'MySQL vs PostgreSQL 비교', category: '질문', views: 765 },
                { rank: 8, title: 'React vs Vue 뭐가 좋을까요', category: '질문', views: 654 },
                { rank: 9, title: '무료 아이콘 사이트 추천', category: '자료', views: 543 },
                { rank: 10, title: '제주도 여행 사진 공유', category: '갤러리', views: 432 },
            ],
            weekly: [
                { rank: 1, title: '2024년 결산 및 2025년 목표', category: '자유', views: 5234 },
                { rank: 2, title: '직장인 재테크 노하우', category: '정보', views: 4876 },
                { rank: 3, title: '해외여행 준비 가이드', category: '정보', views: 3654 },
                { rank: 4, title: '그누보드 5.5 새로운 기능 총정리', category: '자유', views: 2847 },
                { rank: 5, title: '초보자를 위한 PHP 기초 강좌', category: '질문', views: 1923 },
                { rank: 6, title: '무료 부트스트랩 템플릿 모음', category: '자료', views: 1456 },
                { rank: 7, title: '사이트 속도 최적화 방법', category: '질문', views: 1234 },
                { rank: 8, title: 'SEO 최적화 완벽 가이드', category: '자료', views: 987 },
                { rank: 9, title: '오늘의 고양이 사진 모음', category: '갤러리', views: 876 },
                { rank: 10, title: 'MySQL vs PostgreSQL 비교', category: '질문', views: 765 },
            ],
            monthly: [
                { rank: 1, title: '올해의 인생템 공유', category: '자유', views: 9678 },
                { rank: 2, title: '신년 운세 풀이', category: '정보', views: 8532 },
                { rank: 3, title: '연말정산 완벽 가이드', category: '정보', views: 7987 },
                { rank: 4, title: '2024년 결산 및 2025년 목표', category: '자유', views: 5234 },
                { rank: 5, title: '직장인 재테크 노하우', category: '정보', views: 4876 },
                { rank: 6, title: '해외여행 준비 가이드', category: '정보', views: 3654 },
                { rank: 7, title: '그누보드 5.5 새로운 기능 총정리', category: '자유', views: 2847 },
                { rank: 8, title: '초보자를 위한 PHP 기초 강좌', category: '질문', views: 1923 },
                { rank: 9, title: '무료 부트스트랩 템플릿 모음', category: '자료', views: 1456 },
                { rank: 10, title: '사이트 속도 최적화 방법', category: '질문', views: 1234 },
            ],
        };

        let currentPeriod = 'daily';

        // 인기글 렌더링
        function renderPopularPosts() {
            const list = document.querySelector('.popular-bar-list');
            if (!list) return;

            list.innerHTML = popularPosts[currentPeriod].map(post => `
                <div class="popular-bar-item">
                    <span class="popular-rank ${post.rank <= 3 ? 'top' : ''}">${post.rank}</span>
                    <div class="popular-info">
                        <a href="#">${post.title}</a>
                        <div class="popular-meta">${post.category} · 👁 ${post.views.toLocaleString()}</div>
                    </div>
                </div>
            `).join('');
        }

        // 일간/주간/월간 탭 클릭
        document.querySelectorAll('.popular-tab').forEach((tab, index) => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.popular-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const periods = ['daily', 'weekly', 'monthly'];
                currentPeriod = periods[index];
                renderPopularPosts();
            });
        });

        // 초기 렌더링
        renderPopularPosts();
    </script>
</body>
</html>
