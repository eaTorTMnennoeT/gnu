<?php $current_page = 'gallery'; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <script>document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');</script>
    <?php include 'includes/head.php'; ?>
    <title>사진갤러리 - 그누보드</title>
    <style>
        /* 갤러리 페이지 전용 CSS */
        .main-content { padding: 20px; }

        /* 페이지 타이틀 */
        .page-title-section {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title { display: flex; align-items: center; gap: 12px; }

        .page-title-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .page-title-icon svg { width: 24px; height: 24px; color: white; }

        .page-title h1 { font-size: 24px; font-weight: 700; }
        .page-title p { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }

        .upload-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
            border: none; border-radius: 10px;
            color: white; font-size: 14px; font-weight: 600;
            cursor: pointer; transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .upload-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4); }
        .upload-btn svg { width: 18px; height: 18px; }

        /* 베스트 갤러리 */
        .best-section {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
        }

        .best-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px;
        }

        .best-title {
            display: flex; align-items: center; gap: 10px;
            font-size: 18px; font-weight: 700;
        }

        .best-title-icon { font-size: 24px; }

        .period-tabs { display: flex; gap: 8px; }

        .period-tab {
            padding: 8px 16px;
            background: var(--bg-main);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px; font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer; transition: all 0.2s;
        }

        .period-tab:hover { border-color: #8b5cf6; color: #8b5cf6; }

        .period-tab.active {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        .best-gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .best-gallery-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
        }

        .best-gallery-item:hover { transform: scale(1.03); }

        .best-gallery-item img {
            width: 100%; height: 100%;
            object-fit: cover;
        }

        .best-gallery-item .placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-size: 48px;
        }

        .best-gallery-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 50%);
            display: flex; flex-direction: column;
            justify-content: flex-end;
            padding: 12px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .best-gallery-item:hover .best-gallery-overlay { opacity: 1; }

        .best-gallery-title {
            font-size: 13px; font-weight: 600;
            color: white;
            margin-bottom: 4px;
        }

        .best-gallery-stats {
            display: flex; gap: 12px;
            font-size: 11px; color: rgba(255,255,255,0.8);
        }

        .rank-ribbon {
            position: absolute; top: 8px; left: 8px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px; font-weight: 700;
            color: white;
        }

        .rank-ribbon.rank-1 { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; }
        .rank-ribbon.rank-2 { background: linear-gradient(135deg, #9ca3af, #6b7280); }
        .rank-ribbon.rank-3 { background: linear-gradient(135deg, #d97706, #b45309); }

        /* 갤러리 그리드 */
        .gallery-section {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
        }

        .gallery-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px;
        }

        .gallery-title {
            font-size: 18px; font-weight: 700;
        }

        .view-toggle { display: flex; gap: 4px; }

        .view-btn {
            width: 36px; height: 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-main);
            color: var(--text-secondary);
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center;
        }

        .view-btn:hover { border-color: #8b5cf6; color: #8b5cf6; }
        .view-btn.active { background: #8b5cf6; border-color: #8b5cf6; color: white; }
        .view-btn svg { width: 16px; height: 16px; }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .gallery-item {
            background: var(--bg-main);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
        }

        .gallery-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #8b5cf6;
        }

        .gallery-thumb {
            aspect-ratio: 4/3;
            overflow: hidden;
        }

        .gallery-thumb img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .gallery-item:hover .gallery-thumb img { transform: scale(1.1); }

        .gallery-thumb .placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-size: 40px;
        }

        .gallery-info { padding: 14px; }

        .gallery-info-title {
            font-size: 14px; font-weight: 600;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .gallery-info-meta {
            display: flex; justify-content: space-between;
            font-size: 12px; color: var(--text-light);
        }

        .gallery-info-stats {
            display: flex; gap: 10px;
        }

        .gallery-stat { display: flex; align-items: center; gap: 3px; }
        .gallery-stat.likes { color: var(--accent); }
        .gallery-stat.views { color: var(--text-light); }

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

        .page-btn:hover { border-color: #8b5cf6; color: #8b5cf6; }

        .page-btn.active {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
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
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.2);
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

        .search-option:hover { border-color: #8b5cf6; }

        .search-option.active {
            border-color: #8b5cf6;
            background: rgba(139, 92, 246, 0.08);
            color: #8b5cf6;
        }

        .search-option input { display: none; }

        .radio-dot {
            width: 18px; height: 18px;
            border-radius: 50%;
            border: 2px solid var(--border);
            transition: all 0.2s;
        }

        .search-option.active .radio-dot {
            border-color: #8b5cf6;
            border-width: 5px;
        }

        .search-submit {
            width: 100%;
            padding: 14px;
            font-size: 15px; font-weight: 600;
            border: none; border-radius: 12px;
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
            color: white;
            cursor: pointer; transition: all 0.3s;
        }

        .search-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);
        }

        /* 반응형 - 페이지 전용 */
        @media (max-width: 1200px) {
            .best-gallery-grid { grid-template-columns: repeat(3, 1fr); }
            .best-gallery-item:nth-child(4) { display: none; }
            .gallery-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 992px) {
            .best-gallery-grid { grid-template-columns: repeat(2, 1fr); }
            .best-gallery-item:nth-child(3), .best-gallery-item:nth-child(4) { display: none; }
            .gallery-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .page-title-section { flex-direction: column; gap: 16px; align-items: flex-start; }
        }

        @media (max-width: 480px) {
            .gallery-grid { grid-template-columns: 1fr; }
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
                    </div>
                    <div>
                        <h1>사진갤러리</h1>
                        <p>아름다운 사진을 공유하는 공간입니다</p>
                    </div>
                </div>
                <button class="upload-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    사진 올리기
                </button>
            </div>

            <!-- 베스트 갤러리 -->
            <section class="best-section">
                <div class="best-header">
                    <div class="best-title">
                        <span class="best-title-icon">🏆</span>
                        베스트 사진
                    </div>
                    <div class="period-tabs">
                        <button class="period-tab active" onclick="setPeriod('daily', this)">일간</button>
                        <button class="period-tab" onclick="setPeriod('weekly', this)">주간</button>
                        <button class="period-tab" onclick="setPeriod('monthly', this)">월간</button>
                    </div>
                </div>
                <div class="best-gallery-grid" id="bestGalleryGrid">
                    <!-- JS로 렌더링 -->
                </div>
            </section>

            <!-- 갤러리 그리드 -->
            <section class="gallery-section">
                <div class="gallery-header">
                    <h2 class="gallery-title">전체 사진</h2>
                    <div class="view-toggle">
                        <button class="view-btn active">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                        </button>
                        <button class="view-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                        </button>
                    </div>
                </div>
                <div class="gallery-grid" id="galleryGrid">
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
            <h2 class="modal-title">사진 검색</h2>
            <p class="modal-desc">찾고 싶은 사진을 검색해보세요</p>

            <input type="text" class="search-input-modal" placeholder="검색어를 입력하세요..." id="searchInput">

            <div class="search-options">
                <label class="search-option active" onclick="setSearchType('title', this)">
                    <input type="radio" name="searchType" value="title" checked>
                    <span class="radio-dot"></span>
                    제목
                </label>
                <label class="search-option" onclick="setSearchType('title_content', this)">
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
        const gradients = [
            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%)',
            'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
            'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)',
        ];

        const emojis = ['🌅', '🌸', '🏔️', '🌊', '🌺', '🌙', '🦋', '🌈', '🎨', '📸', '🌻', '🍀'];

        const bestGallery = {
            daily: [
                { title: '봄날의 벚꽃', author: '포토그래퍼', likes: 567, views: 2341 },
                { title: '도시의 야경', author: '야경러버', likes: 432, views: 1876 },
                { title: '바다 풍경', author: '바다사랑', likes: 389, views: 1654 },
                { title: '가을 단풍', author: '단풍여행', likes: 345, views: 1432 },
            ],
            weekly: [
                { title: '은하수 촬영', author: '별지기', likes: 2341, views: 8765 },
                { title: '눈 내리는 마을', author: '겨울왕국', likes: 1987, views: 7654 },
                { title: '무지개 사진', author: '행운가득', likes: 1654, views: 6543 },
                { title: '오로라 촬영', author: '북극탐험', likes: 1432, views: 5432 },
            ],
            monthly: [
                { title: '일출 타임랩스', author: '새벽감성', likes: 5678, views: 23456 },
                { title: '별 궤적 사진', author: '천문학자', likes: 4567, views: 19876 },
                { title: '폭포 장노출', author: '자연사랑', likes: 3987, views: 17654 },
                { title: '번개 촬영', author: '폭풍추적자', likes: 3456, views: 15432 },
            ],
        };

        const galleryItems = [
            { title: '봄날의 벚꽃', author: '포토그래퍼', likes: 567, views: 2341 },
            { title: '도시의 야경', author: '야경러버', likes: 432, views: 1876 },
            { title: '바다 풍경', author: '바다사랑', likes: 389, views: 1654 },
            { title: '가을 단풍', author: '단풍여행', likes: 345, views: 1432 },
            { title: '숲속 산책로', author: '힐링여행', likes: 298, views: 1234 },
            { title: '일몰 사진', author: '노을감상', likes: 276, views: 1098 },
            { title: '꽃밭 사진', author: '플라워러버', likes: 234, views: 987 },
            { title: '구름 사진', author: '하늘사진가', likes: 198, views: 876 },
        ];

        let currentPeriod = 'daily';
        let searchType = 'title';

        // 베스트 갤러리 렌더링
        function renderBestGallery() {
            const grid = document.getElementById('bestGalleryGrid');
            grid.innerHTML = bestGallery[currentPeriod].map((item, idx) => `
                <div class="best-gallery-item" style="background: ${gradients[idx]}">
                    <div class="placeholder">${emojis[idx]}</div>
                    <div class="rank-ribbon rank-${idx + 1}">${idx + 1}위</div>
                    <div class="best-gallery-overlay">
                        <span class="best-gallery-title">${item.title}</span>
                        <div class="best-gallery-stats">
                            <span>♥ ${item.likes.toLocaleString()}</span>
                            <span>👁 ${item.views.toLocaleString()}</span>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // 갤러리 그리드 렌더링
        function renderGallery() {
            const grid = document.getElementById('galleryGrid');
            grid.innerHTML = galleryItems.map((item, idx) => `
                <div class="gallery-item">
                    <div class="gallery-thumb" style="background: ${gradients[idx % gradients.length]}">
                        <div class="placeholder">${emojis[idx % emojis.length]}</div>
                    </div>
                    <div class="gallery-info">
                        <div class="gallery-info-title">${item.title}</div>
                        <div class="gallery-info-meta">
                            <span>${item.author}</span>
                            <div class="gallery-info-stats">
                                <span class="gallery-stat likes">♥ ${item.likes}</span>
                                <span class="gallery-stat views">👁 ${item.views}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // 기간 변경
        function setPeriod(period, btn) {
            currentPeriod = period;
            document.querySelectorAll('.period-tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            renderBestGallery();
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
            document.querySelectorAll('.search-option').forEach(l => l.classList.remove('active'));
            label.classList.add('active');
        }

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
        renderBestGallery();
        renderGallery();
    </script>
</body>
</html>
