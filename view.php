<?php
$current_page = 'board';
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// 더미 데이터 (이미지 포함)
$posts = [
    1 => [
        'id' => 1,
        'category' => '일상',
        'title' => '그누보드 신규 테마 적용 후기입니다',
        'author' => '김철수',
        'date' => '2025-01-08 14:32',
        'views' => 1523,
        'likes' => 234,
        'dislikes' => 12,
        'comments' => 15,
        'content' => '
            <p>안녕하세요, 그누보드 테마를 적용해봤습니다.</p>
            <p>디자인이 정말 깔끔하고 모바일에서도 잘 작동하네요!</p>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&h=400&fit=crop" alt="테마 스크린샷">
            </div>
            <p>다크모드 지원도 훌륭합니다. 추천합니다!</p>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&h=500&fit=crop" alt="다크모드 화면">
            </div>
            <p>적용 방법도 간단해서 초보자도 쉽게 할 수 있을 것 같아요.</p>
        ',
        'files' => [
            ['name' => 'theme_screenshot.png', 'size' => '2.4MB', 'downloads' => 156, 'point' => 100],
            ['name' => 'install_guide.pdf', 'size' => '512KB', 'downloads' => 89, 'point' => 0]
        ]
    ],
    2 => ['id' => 2, 'category' => '정보', 'title' => '새해 다이어트 꿀팁 공유합니다', 'author' => '헬스마니아', 'date' => '2025-01-08 12:15', 'views' => 2341, 'likes' => 567, 'dislikes' => 23, 'comments' => 89, 'content' => '<p>새해를 맞아 다이어트 꿀팁을 공유합니다!</p><div class="content-image"><img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800&h=450&fit=crop" alt="운동 이미지"></div><p>1. 아침에 물 한잔 마시기</p><p>2. 계단 이용하기</p><p>3. 야식 자제하기</p>', 'files' => []],
    3 => ['id' => 3, 'category' => '모임', 'title' => '주말에 뭐하세요?', 'author' => '주말여행', 'date' => '2025-01-08 10:45', 'views' => 876, 'likes' => 45, 'dislikes' => 5, 'comments' => 42, 'content' => '<p>주말에 같이 등산 가실 분 계신가요?</p><div class="content-image"><img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=800&h=500&fit=crop" alt="등산 이미지"></div><p>북한산 코스 추천받습니다~</p>', 'files' => []],
    4 => ['id' => 4, 'category' => '일상', 'title' => '점심 메뉴 추천해주세요', 'author' => '맛집탐방', 'date' => '2025-01-07 11:30', 'views' => 1234, 'likes' => 189, 'dislikes' => 8, 'comments' => 8, 'content' => '<p>오늘 점심 뭐 먹을지 고민입니다.</p><p>추천 부탁드려요!</p>', 'files' => []],
    5 => ['id' => 5, 'category' => '정보', 'title' => '연초 계획 세우기', 'author' => '새출발', 'date' => '2025-01-07 09:20', 'views' => 987, 'likes' => 123, 'dislikes' => 3, 'comments' => 23, 'content' => '<p>새해 계획 세우셨나요?</p><p>저는 운동과 독서를 목표로 잡았습니다.</p>', 'files' => []],
];

$post = $posts[$post_id] ?? $posts[1];
$prev_id = $post_id > 1 ? $post_id - 1 : null;
$next_id = $post_id < count($posts) ? $post_id + 1 : null;

$comments = [
    ['id' => 1, 'author' => '댓글러1', 'date' => '01-08 15:20', 'content' => '좋은 정보 감사합니다!', 'likes' => 12],
    ['id' => 2, 'author' => '익명사용자', 'date' => '01-08 16:45', 'content' => '저도 적용해봤는데 정말 좋네요~', 'likes' => 8],
    ['id' => 3, 'author' => '초보개발자', 'date' => '01-08 18:30', 'content' => '설치 방법 자세히 알려주실 수 있나요?', 'likes' => 3],
];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <script>document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');</script>
    <?php include 'includes/head.php'; ?>
    <title><?php echo htmlspecialchars($post['title']); ?> - 자유게시판</title>
    <style>
        .main-content { padding: 20px; }

        /* 브레드크럼 */
        .breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--text-light);
            margin-bottom: 20px;
        }
        .breadcrumb a { color: var(--text-secondary); text-decoration: none; }
        .breadcrumb a:hover { color: var(--accent); }
        .breadcrumb svg { width: 12px; height: 12px; }

        /* 게시글 헤더 */
        .post-header {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
        }

        .post-title-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .post-category {
            display: inline-block;
            padding: 4px 10px;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            font-size: 12px; font-weight: 600;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .post-title {
            font-size: 22px; font-weight: 700;
            color: var(--text-primary);
            line-height: 1.4;
        }

        .post-meta {
            display: flex; flex-wrap: wrap; gap: 16px;
            font-size: 13px; color: var(--text-secondary);
        }

        .post-meta-item {
            display: flex; align-items: center; gap: 6px;
        }

        .post-meta-item svg { width: 14px; height: 14px; opacity: 0.7; }

        /* 게시글 본문 */
        .post-content {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
            min-height: 200px;
        }

        .post-content p {
            margin-bottom: 16px;
            line-height: 1.8;
            color: var(--text-primary);
        }

        .post-content .content-image {
            margin: 20px 0;
            border-radius: 12px;
            overflow: hidden;
        }

        .post-content .content-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* 본문 내 액션 버튼 */
        .post-content-actions {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
            gap: 8px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .content-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 14px;
            background: var(--bg-main);
            border: 1px solid var(--border);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 13px;
            color: var(--text-secondary);
            white-space: nowrap;
            flex-shrink: 1;
            min-width: 0;
        }

        .content-action-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .content-action-btn.active {
            border-color: var(--accent);
            background: rgba(233, 69, 96, 0.1);
            color: var(--accent);
        }

        .content-action-btn .action-icon { font-size: 18px; }
        .content-action-btn .action-count { font-weight: 700; }

        /* 첨부파일 */
        .post-files {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
        }

        .files-header {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .files-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white;
        }

        .files-icon svg { width: 18px; height: 18px; }
        .files-title { font-weight: 600; font-size: 15px; }
        .files-count { font-size: 12px; color: var(--text-light); }

        .file-item {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 14px;
            background: var(--bg-main);
            border-radius: 10px;
            margin-bottom: 8px;
        }

        .file-item:last-child { margin-bottom: 0; }

        .file-item-top {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .file-thumb {
            width: 44px; height: 44px;
            background: var(--bg-card);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-light);
            flex-shrink: 0;
        }

        .file-thumb svg { width: 20px; height: 20px; }
        .file-info { flex: 1; min-width: 0; }
        .file-name { font-size: 13px; font-weight: 500; margin-bottom: 2px; }
        .file-meta { font-size: 11px; color: var(--text-light); }

        .file-cost {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px; font-weight: 600;
            flex-shrink: 0;
        }

        .file-cost.free { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .file-cost.point { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }

        .file-download {
            width: 100%;
            padding: 10px 14px;
            background: linear-gradient(135deg, var(--accent), #ff6b6b);
            color: white;
            border: none; border-radius: 8px;
            font-size: 13px; font-weight: 600;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 6px;
            transition: all 0.2s;
        }

        .file-download:hover { transform: translateY(-1px); box-shadow: 0 4px 12px var(--accent-glow); }
        .file-download svg { width: 14px; height: 14px; }

        /* 이전/다음글 */
        .post-nav {
            display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
            margin-bottom: 16px;
        }

        .pn-item {
            display: flex; align-items: center; gap: 12px;
            padding: 16px;
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border);
            text-decoration: none;
            transition: all 0.2s;
        }

        .pn-item:hover { border-color: var(--accent); background: var(--bg-main); }
        .pn-item.disabled { opacity: 0.5; pointer-events: none; }
        .pn-item.next { flex-direction: row-reverse; text-align: right; }

        .pn-icon {
            width: 36px; height: 36px;
            background: var(--bg-main);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-light);
            flex-shrink: 0;
        }

        .pn-icon svg { width: 16px; height: 16px; }
        .pn-text { flex: 1; min-width: 0; }
        .pn-label { font-size: 11px; color: var(--text-light); margin-bottom: 2px; }
        .pn-title { font-size: 13px; font-weight: 500; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        /* 댓글 영역 */
        .comments-section {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
        }

        .comments-header {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 20px;
            font-size: 16px; font-weight: 700;
        }

        .comments-count { color: var(--accent); }

        .comment-form {
            display: flex; gap: 12px;
            margin-bottom: 24px;
        }

        .comment-input {
            flex: 1;
            padding: 14px 16px;
            background: var(--bg-main);
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 14px;
            color: var(--text-primary);
            resize: none;
            outline: none;
            transition: all 0.2s;
        }

        .comment-input:focus { border-color: var(--accent); }
        .comment-input::placeholder { color: var(--text-light); }

        .comment-submit {
            padding: 14px 20px;
            background: linear-gradient(135deg, var(--accent), #ff6b6b);
            color: white;
            border: none; border-radius: 12px;
            font-size: 14px; font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .comment-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px var(--accent-glow); }

        .comment-list { display: flex; flex-direction: column; gap: 16px; }

        .comment-item {
            padding: 16px;
            background: var(--bg-main);
            border-radius: 12px;
        }

        .comment-top {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 10px;
        }

        .comment-author { display: flex; align-items: center; gap: 8px; }

        .comment-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--accent), #ff6b6b);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 12px; font-weight: 600;
        }

        .comment-name { font-size: 13px; font-weight: 600; }
        .comment-date { font-size: 11px; color: var(--text-light); }

        .comment-like {
            display: flex; align-items: center; gap: 4px;
            padding: 6px 10px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 12px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s;
        }

        .comment-like:hover { border-color: var(--accent); color: var(--accent); }
        .comment-text { font-size: 14px; line-height: 1.6; color: var(--text-primary); }

        /* 하단 버튼 */
        .post-bottom {
            display: flex; justify-content: space-between; gap: 12px;
        }

        .bottom-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px; font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .bottom-btn svg { width: 16px; height: 16px; }

        .btn-list {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .btn-list:hover { border-color: var(--accent); color: var(--accent); }

        .btn-write {
            background: linear-gradient(135deg, var(--accent), #ff6b6b);
            color: white; border: none;
        }

        .btn-write:hover { transform: translateY(-1px); box-shadow: 0 4px 12px var(--accent-glow); }

        /* 반응형 */
        @media (max-width: 768px) {
            .main-content { padding: 16px; }
            .post-header, .post-content, .post-files, .comments-section { padding: 16px; border-radius: 12px; }
            .post-title { font-size: 18px; }
            .post-title-row { flex-wrap: wrap; gap: 8px; }
            .post-meta { gap: 12px; font-size: 12px; }
            .post-content-actions { gap: 6px; }
            .content-action-btn { padding: 8px 10px; font-size: 12px; gap: 4px; }
            .content-action-btn .action-icon { font-size: 14px; }
            .post-nav { grid-template-columns: 1fr; }
            .pn-item.next { flex-direction: row; text-align: left; }
            .comment-form { flex-direction: column; }
            .post-bottom { flex-direction: column; }
            .bottom-btn { justify-content: center; }
            .file-item { padding: 12px; }
            .file-item-top { gap: 10px; }
            .file-thumb { width: 38px; height: 38px; }
            .file-name { font-size: 12px; }
            .file-meta { font-size: 10px; }
            .file-download { padding: 10px 12px; font-size: 12px; }
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-wrapper">
        <?php include 'includes/header.php'; ?>

        <main class="main-content">
            <!-- 브레드크럼 -->
            <nav class="breadcrumb">
                <a href="index.php">홈</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                <a href="board.php">자유게시판</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                <span><?php echo htmlspecialchars($post['title']); ?></span>
            </nav>

            <!-- 게시글 헤더 -->
            <header class="post-header">
                <div class="post-title-row">
                    <span class="post-category"><?php echo htmlspecialchars($post['category']); ?></span>
                    <h1 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                </div>
                <div class="post-meta">
                    <div class="post-meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span><?php echo htmlspecialchars($post['author']); ?></span>
                    </div>
                    <div class="post-meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                        <span><?php echo $post['date']; ?></span>
                    </div>
                    <div class="post-meta-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <span>조회 <?php echo number_format($post['views']); ?></span>
                    </div>
                </div>
            </header>

            <!-- 게시글 본문 -->
            <article class="post-content">
                <?php echo $post['content']; ?>

                <!-- 본문 내 액션 버튼 -->
                <div class="post-content-actions">
                    <button class="content-action-btn" onclick="toggleLike(this)">
                        <span class="action-icon">👍</span>
                        <span>추천</span>
                        <span class="action-count"><?php echo number_format($post['likes']); ?></span>
                    </button>
                    <button class="content-action-btn" onclick="sharePost()">
                        <span class="action-icon">🔗</span>
                        <span>공유</span>
                    </button>
                    <button class="content-action-btn" onclick="scrapPost(this)">
                        <span class="action-icon">🔖</span>
                        <span>스크랩</span>
                    </button>
                    <button class="content-action-btn" onclick="reportPost()">
                        <span class="action-icon">🚨</span>
                        <span>신고</span>
                    </button>
                </div>
            </article>

            <!-- 첨부파일 -->
            <?php if (!empty($post['files'])): ?>
            <section class="post-files">
                <div class="files-header">
                    <div class="files-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                    </div>
                    <div>
                        <div class="files-title">첨부파일</div>
                        <div class="files-count"><?php echo count($post['files']); ?>개 파일</div>
                    </div>
                </div>

                <?php foreach ($post['files'] as $file): ?>
                <div class="file-item">
                    <div class="file-item-top">
                        <div class="file-thumb">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                        </div>
                        <div class="file-info">
                            <div class="file-name"><?php echo htmlspecialchars($file['name']); ?></div>
                            <div class="file-meta"><?php echo $file['size']; ?> / 다운 <?php echo number_format($file['downloads']); ?>회</div>
                        </div>
                        <?php if ($file['point'] > 0): ?>
                        <span class="file-cost point"><?php echo number_format($file['point']); ?>P</span>
                        <?php else: ?>
                        <span class="file-cost free">무료</span>
                        <?php endif; ?>
                    </div>
                    <button class="file-download" onclick="alert('다운로드 기능은 실제 서버에서 구현됩니다.')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        다운로드
                    </button>
                </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>

            <!-- 이전/다음글 -->
            <nav class="post-nav">
                <?php if ($prev_id && isset($posts[$prev_id])): ?>
                <a href="view.php?id=<?php echo $prev_id; ?>" class="pn-item prev">
                    <div class="pn-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"/></svg>
                    </div>
                    <div class="pn-text">
                        <div class="pn-label">이전글</div>
                        <div class="pn-title"><?php echo htmlspecialchars($posts[$prev_id]['title']); ?></div>
                    </div>
                </a>
                <?php else: ?>
                <div class="pn-item prev disabled">
                    <div class="pn-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"/></svg>
                    </div>
                    <div class="pn-text">
                        <div class="pn-label">이전글</div>
                        <div class="pn-title">이전글이 없습니다</div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($next_id && isset($posts[$next_id])): ?>
                <a href="view.php?id=<?php echo $next_id; ?>" class="pn-item next">
                    <div class="pn-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                    </div>
                    <div class="pn-text">
                        <div class="pn-label">다음글</div>
                        <div class="pn-title"><?php echo htmlspecialchars($posts[$next_id]['title']); ?></div>
                    </div>
                </a>
                <?php else: ?>
                <div class="pn-item next disabled">
                    <div class="pn-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                    </div>
                    <div class="pn-text">
                        <div class="pn-label">다음글</div>
                        <div class="pn-title">다음글이 없습니다</div>
                    </div>
                </div>
                <?php endif; ?>
            </nav>

            <!-- 댓글 -->
            <section class="comments-section">
                <div class="comments-header">
                    <span>댓글</span>
                    <span class="comments-count"><?php echo count($comments); ?></span>
                </div>

                <form class="comment-form" onsubmit="submitComment(event)">
                    <textarea class="comment-input" rows="2" placeholder="댓글을 입력하세요..."></textarea>
                    <button type="submit" class="comment-submit">등록</button>
                </form>

                <div class="comment-list">
                    <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <div class="comment-top">
                            <div class="comment-author">
                                <div class="comment-avatar"><?php echo substr($comment['author'], 0, 3); ?></div>
                                <div>
                                    <div class="comment-name"><?php echo htmlspecialchars($comment['author']); ?></div>
                                    <div class="comment-date"><?php echo $comment['date']; ?></div>
                                </div>
                            </div>
                            <button class="comment-like" onclick="likeComment(this)">
                                ❤️ <?php echo $comment['likes']; ?>
                            </button>
                        </div>
                        <div class="comment-text"><?php echo htmlspecialchars($comment['content']); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- 하단 버튼 -->
            <div class="post-bottom">
                <a href="board.php" class="bottom-btn btn-list">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    목록
                </a>
                <button class="bottom-btn btn-write">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    글쓰기
                </button>
            </div>
        </main>
    </div>

    <!-- 신고 모달 -->
    <div class="report-modal-overlay" id="reportModal">
        <div class="report-modal">
            <div class="report-modal-header">
                <h3>게시글 신고</h3>
                <button class="report-modal-close" onclick="closeReportModal()">&times;</button>
            </div>
            <div class="report-modal-body">
                <p class="report-desc">신고 사유를 선택해주세요.</p>
                <div class="report-options">
                    <label class="report-option">
                        <input type="radio" name="report_reason" value="스팸/광고">
                        <span class="report-radio"></span>
                        <span>스팸/광고</span>
                    </label>
                    <label class="report-option">
                        <input type="radio" name="report_reason" value="욕설/비방">
                        <span class="report-radio"></span>
                        <span>욕설/비방</span>
                    </label>
                    <label class="report-option">
                        <input type="radio" name="report_reason" value="음란물">
                        <span class="report-radio"></span>
                        <span>음란물</span>
                    </label>
                    <label class="report-option">
                        <input type="radio" name="report_reason" value="도배">
                        <span class="report-radio"></span>
                        <span>도배</span>
                    </label>
                    <label class="report-option">
                        <input type="radio" name="report_reason" value="기타">
                        <span class="report-radio"></span>
                        <span>기타</span>
                    </label>
                </div>
                <textarea class="report-detail" id="reportDetail" placeholder="상세 내용을 입력해주세요 (선택사항)"></textarea>
            </div>
            <div class="report-modal-footer">
                <button class="report-btn-cancel" onclick="closeReportModal()">취소</button>
                <button class="report-btn-submit" onclick="submitReport()">신고하기</button>
            </div>
        </div>
    </div>

    <?php include 'includes/popup.php'; ?>
    <?php include 'includes/footer.php'; ?>

    <script>
        const postId = <?php echo $post_id; ?>;

        // AJAX 헬퍼 함수
        async function ajaxRequest(action, data = {}) {
            try {
                const response = await fetch('ajax_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action, postId, ...data })
                });
                return await response.json();
            } catch (error) {
                console.error('AJAX Error:', error);
                return { success: false, message: '서버 오류가 발생했습니다.' };
            }
        }

        // 토스트 알림
        function showToast(message, type = 'success') {
            const existing = document.querySelector('.toast-notification');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.className = 'toast-notification ' + type;
            toast.innerHTML = `
                <span class="toast-icon">${type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ'}</span>
                <span>${message}</span>
            `;
            document.body.appendChild(toast);

            setTimeout(() => toast.classList.add('show'), 10);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }

        // 추천
        async function toggleLike(btn) {
            btn.disabled = true;
            const result = await ajaxRequest('like');

            if (result.success) {
                btn.classList.toggle('active');
                const count = btn.querySelector('.action-count');
                let val = parseInt(count.textContent.replace(/,/g, ''));
                val += btn.classList.contains('active') ? 1 : -1;
                count.textContent = val.toLocaleString();
                showToast(btn.classList.contains('active') ? '추천했습니다!' : '추천을 취소했습니다.');
            } else {
                showToast(result.message || '오류가 발생했습니다.', 'error');
            }
            btn.disabled = false;
        }

        // 비추천
        async function toggleDislike(btn) {
            btn.disabled = true;
            const result = await ajaxRequest('dislike');

            if (result.success) {
                btn.classList.toggle('active');
                const count = btn.querySelector('.action-count');
                let val = parseInt(count.textContent.replace(/,/g, ''));
                val += btn.classList.contains('active') ? 1 : -1;
                count.textContent = val.toLocaleString();
                showToast(btn.classList.contains('active') ? '비추천했습니다.' : '비추천을 취소했습니다.');
            } else {
                showToast(result.message || '오류가 발생했습니다.', 'error');
            }
            btn.disabled = false;
        }

        // 공유
        async function sharePost() {
            const url = location.href;
            const title = document.title;

            if (navigator.share) {
                try {
                    await navigator.share({ title, url });
                    await ajaxRequest('share');
                    showToast('공유되었습니다!');
                } catch (e) {
                    if (e.name !== 'AbortError') {
                        showToast('공유를 취소했습니다.', 'info');
                    }
                }
            } else {
                try {
                    await navigator.clipboard.writeText(url);
                    await ajaxRequest('share');
                    showToast('링크가 복사되었습니다!');
                } catch (e) {
                    showToast('링크 복사에 실패했습니다.', 'error');
                }
            }
        }

        // 스크랩
        async function scrapPost(btn) {
            btn.disabled = true;
            const isScrap = !btn.classList.contains('active');
            const result = await ajaxRequest('scrap', { scrap: isScrap });

            if (result.success) {
                btn.classList.toggle('active');
                showToast(btn.classList.contains('active') ? '스크랩되었습니다!' : '스크랩이 취소되었습니다.');
            } else {
                showToast(result.message || '오류가 발생했습니다.', 'error');
            }
            btn.disabled = false;
        }

        // 신고 모달 열기
        function reportPost() {
            document.getElementById('reportModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        // 신고 모달 닫기
        function closeReportModal() {
            document.getElementById('reportModal').classList.remove('show');
            document.body.style.overflow = '';
            // 초기화
            document.querySelectorAll('input[name="report_reason"]').forEach(r => r.checked = false);
            document.getElementById('reportDetail').value = '';
        }

        // 신고 제출
        async function submitReport() {
            const selected = document.querySelector('input[name="report_reason"]:checked');
            if (!selected) {
                showToast('신고 사유를 선택해주세요.', 'error');
                return;
            }

            const reason = selected.value;
            const detail = document.getElementById('reportDetail').value.trim();
            const submitBtn = document.querySelector('.report-btn-submit');

            submitBtn.disabled = true;
            submitBtn.textContent = '처리중...';

            const result = await ajaxRequest('report', { reason, detail });

            if (result.success) {
                closeReportModal();
                showToast('신고가 접수되었습니다.');
            } else {
                showToast(result.message || '신고 처리 중 오류가 발생했습니다.', 'error');
            }

            submitBtn.disabled = false;
            submitBtn.textContent = '신고하기';
        }

        // 모달 바깥 클릭시 닫기
        document.getElementById('reportModal').addEventListener('click', function(e) {
            if (e.target === this) closeReportModal();
        });

        // 댓글 등록
        async function submitComment(e) {
            e.preventDefault();
            const form = e.target;
            const input = form.querySelector('.comment-input');
            const submitBtn = form.querySelector('.comment-submit');
            const content = input.value.trim();

            if (!content) {
                showToast('댓글 내용을 입력하세요.', 'error');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.textContent = '등록중...';

            const result = await ajaxRequest('comment_add', { content });

            if (result.success) {
                // 새 댓글 추가
                const commentList = document.querySelector('.comment-list');
                const newComment = document.createElement('div');
                newComment.className = 'comment-item';
                newComment.innerHTML = `
                    <div class="comment-top">
                        <div class="comment-author">
                            <div class="comment-avatar">나</div>
                            <div>
                                <div class="comment-name">나</div>
                                <div class="comment-date">방금 전</div>
                            </div>
                        </div>
                        <button class="comment-like" onclick="likeComment(this, ${result.commentId || 0})">
                            ❤️ 0
                        </button>
                    </div>
                    <div class="comment-text">${content.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</div>
                `;
                commentList.insertBefore(newComment, commentList.firstChild);

                // 댓글 수 업데이트
                const countEl = document.querySelector('.comments-count');
                countEl.textContent = parseInt(countEl.textContent) + 1;

                input.value = '';
                showToast('댓글이 등록되었습니다!');
            } else {
                showToast(result.message || '댓글 등록에 실패했습니다.', 'error');
            }

            submitBtn.disabled = false;
            submitBtn.textContent = '등록';
        }

        // 댓글 좋아요
        async function likeComment(btn, commentId) {
            btn.disabled = true;
            const result = await ajaxRequest('comment_like', { commentId });

            if (result.success) {
                const num = parseInt(btn.textContent.replace(/[^0-9]/g, ''));
                btn.textContent = '❤️ ' + (num + 1);
                btn.style.color = 'var(--accent)';
                btn.style.borderColor = 'var(--accent)';
            } else {
                showToast(result.message || '오류가 발생했습니다.', 'error');
            }
            btn.disabled = false;
        }

        // 파일 다운로드
        async function downloadFile(btn, fileIdx, fileName) {
            btn.disabled = true;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span>다운로드중...</span>';

            const result = await ajaxRequest('download', { fileIdx });

            if (result.success) {
                showToast(`${fileName} 다운로드를 시작합니다.`);
                // 실제로는 서버에서 파일 URL 반환 후 다운로드
                // window.location.href = result.downloadUrl;
            } else {
                showToast(result.message || '다운로드에 실패했습니다.', 'error');
            }

            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    </script>

    <style>
        .toast-notification {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 14px 24px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            z-index: 10000;
            opacity: 0;
            transition: all 0.3s ease;
        }
        .toast-notification.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
        .toast-notification.success .toast-icon { color: #10b981; }
        .toast-notification.error .toast-icon { color: #ef4444; }
        .toast-notification.info .toast-icon { color: #6366f1; }
        .toast-icon { font-size: 18px; font-weight: bold; }

        .content-action-btn:disabled,
        .comment-like:disabled,
        .file-download:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* 신고 모달 */
        .report-modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .report-modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        .report-modal {
            background: var(--bg-card);
            border-radius: 16px;
            width: 90%;
            max-width: 420px;
            transform: translateY(30px);
            transition: transform 0.3s ease;
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .report-modal-overlay.show .report-modal {
            transform: translateY(0);
        }
        .report-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
        }
        .report-modal-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }
        .report-modal-close {
            width: 32px; height: 32px;
            border: none;
            background: var(--bg-main);
            border-radius: 8px;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .report-modal-close:hover {
            background: var(--accent);
            color: white;
        }
        .report-modal-body {
            padding: 20px;
        }
        .report-desc {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 16px;
        }
        .report-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 16px;
        }
        .report-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: var(--bg-main);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            color: var(--text-primary);
        }
        .report-option:hover {
            background: rgba(233, 69, 96, 0.1);
        }
        .report-option input {
            display: none;
        }
        .report-radio {
            width: 18px; height: 18px;
            border: 2px solid var(--border);
            border-radius: 50%;
            position: relative;
            transition: all 0.2s;
        }
        .report-option input:checked ~ .report-radio {
            border-color: var(--accent);
        }
        .report-option input:checked ~ .report-radio::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
        }
        .report-detail {
            width: 100%;
            padding: 12px 14px;
            background: var(--bg-main);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-primary);
            resize: none;
            height: 80px;
            outline: none;
            transition: all 0.2s;
        }
        .report-detail:focus {
            border-color: var(--accent);
        }
        .report-detail::placeholder {
            color: var(--text-light);
        }
        .report-modal-footer {
            display: flex;
            gap: 10px;
            padding: 16px 20px;
            border-top: 1px solid var(--border);
        }
        .report-btn-cancel, .report-btn-submit {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .report-btn-cancel {
            background: var(--bg-main);
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }
        .report-btn-cancel:hover {
            border-color: var(--accent);
            color: var(--accent);
        }
        .report-btn-submit {
            background: linear-gradient(135deg, var(--accent), #ff6b6b);
            border: none;
            color: white;
        }
        .report-btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px var(--accent-glow);
        }
        .report-btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</body>
</html>
