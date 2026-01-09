<?php
$current_page = 'pds';
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// 더미 데이터
$posts = [
    1 => [
        'id' => 1,
        'category' => '프로그램',
        'title' => '그누보드 프리미엄 테마 v2.0',
        'author' => '개발자킴',
        'level' => 8,
        'date' => '2025-01-08 14:32',
        'likes' => 234,
        'dislikes' => 12,
        'comments' => 45,
        'content' => '
            <p>안녕하세요, 그누보드 프리미엄 테마 v2.0을 공개합니다.</p>
            <p>이번 버전에서는 다음과 같은 기능이 추가되었습니다:</p>
            <ul>
                <li>다크모드 완벽 지원 - 눈의 피로를 줄여줍니다</li>
                <li>반응형 디자인 개선 - 모바일, 태블릿, 데스크탑 완벽 대응</li>
                <li>성능 최적화 - 페이지 로딩 속도 50% 향상</li>
                <li>새로운 위젯 10종 추가</li>
                <li>SEO 최적화 적용</li>
            </ul>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&h=400&fit=crop" alt="테마 스크린샷">
            </div>
            <h3>설치 방법</h3>
            <p>1. 압축 파일을 다운로드합니다.</p>
            <p>2. 그누보드 theme 폴더에 압축을 풀어주세요.</p>
            <p>3. 관리자 페이지에서 테마를 활성화합니다.</p>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&h=500&fit=crop" alt="설치 가이드">
            </div>
            <p>문의사항은 댓글로 남겨주세요. 빠르게 답변드리겠습니다!</p>
        ',
        'download' => [
            'cost_type' => 'point',
            'cost_value' => 300,
            'file_count' => 1,
            'file_size' => '15.2MB',
            'duration' => null,
            'download_count' => 567,
            'has_ad' => false
        ],
        'files' => [
            ['name' => 'gnuboard_premium_theme_v2.0.zip', 'size' => '15.2MB']
        ]
    ],
    2 => [
        'id' => 2,
        'category' => '문서',
        'title' => 'PHP 개발 가이드 완벽정리 PDF',
        'author' => '코딩마스터',
        'level' => 7,
        'date' => '2025-01-08 12:15',
        'likes' => 167,
        'dislikes' => 5,
        'comments' => 32,
        'content' => '
            <p>PHP 개발에 필요한 모든 내용을 정리한 가이드입니다.</p>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1515879218367-8466d910aaa4?w=800&h=400&fit=crop" alt="PHP 코드">
            </div>
            <h3>목차</h3>
            <ul>
                <li>Chapter 1: PHP 기초 문법</li>
                <li>Chapter 2: 객체지향 프로그래밍</li>
                <li>Chapter 3: 데이터베이스 연동 (MySQL, PDO)</li>
                <li>Chapter 4: 보안 및 인증</li>
                <li>Chapter 5: RESTful API 개발</li>
                <li>Chapter 6: 실전 프로젝트</li>
            </ul>
            <p>총 450페이지 분량으로, 초보자부터 중급자까지 활용할 수 있습니다.</p>
            <p>예제 코드 포함되어 있어 바로 실습 가능합니다.</p>
        ',
        'download' => [
            'cost_type' => 'point',
            'cost_value' => 300,
            'file_count' => 1,
            'file_size' => '8.7MB',
            'duration' => null,
            'download_count' => 312,
            'has_ad' => true
        ],
        'files' => [
            ['name' => 'php_guide_complete.pdf', 'size' => '8.7MB']
        ]
    ],
    3 => [
        'id' => 3,
        'category' => '이미지',
        'title' => '무료 아이콘 팩 500종 모음',
        'author' => '디자이너',
        'level' => 5,
        'date' => '2025-01-08 10:45',
        'likes' => 289,
        'dislikes' => 3,
        'comments' => 23,
        'content' => '
            <p>다양한 스타일의 무료 아이콘 500종을 모았습니다.</p>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1558655146-9f40138edfeb?w=800&h=400&fit=crop" alt="아이콘 미리보기">
            </div>
            <h3>포함된 아이콘 종류</h3>
            <ul>
                <li>UI/UX 아이콘 150종</li>
                <li>소셜 미디어 아이콘 50종</li>
                <li>비즈니스 아이콘 100종</li>
                <li>이모지 스타일 아이콘 100종</li>
                <li>화살표/방향 아이콘 50종</li>
                <li>기타 50종</li>
            </ul>
            <p>SVG, PNG(24px, 48px, 96px), AI 포맷 모두 포함!</p>
            <p><strong>상업적 사용 가능</strong> - 출처 표기 없이 자유롭게 사용하세요.</p>
        ',
        'download' => [
            'cost_type' => 'point',
            'cost_value' => 200,
            'file_count' => 500,
            'file_size' => '45.3MB',
            'duration' => '02:15:30',
            'download_count' => 434,
            'has_ad' => false
        ],
        'files' => [
            ['name' => 'icon_pack_500.zip', 'size' => '45.3MB']
        ]
    ],
    4 => [
        'id' => 4,
        'category' => '프로그램',
        'title' => 'MySQL 백업 자동화 스크립트',
        'author' => 'DB관리자',
        'level' => 6,
        'date' => '2025-01-07 16:20',
        'likes' => 89,
        'dislikes' => 2,
        'comments' => 15,
        'content' => '
            <p>MySQL 데이터베이스를 자동으로 백업하는 스크립트입니다.</p>
            <h3>주요 기능</h3>
            <ul>
                <li>일별/주별/월별 자동 백업</li>
                <li>압축 백업 지원 (gzip)</li>
                <li>원격 서버 전송 (FTP, SFTP, S3)</li>
                <li>이메일 알림 기능</li>
                <li>백업 보관 기간 설정</li>
            </ul>
            <p>Linux/Windows 서버 모두 지원합니다.</p>
            <p>설정 파일 하나로 간편하게 구성 가능!</p>
        ',
        'download' => [
            'cost_type' => 'free',
            'cost_value' => 0,
            'file_count' => 1,
            'file_size' => '2.1MB',
            'duration' => null,
            'download_count' => 198,
            'has_ad' => false
        ],
        'files' => [
            ['name' => 'mysql_backup_script.zip', 'size' => '2.1MB']
        ]
    ],
    5 => [
        'id' => 5,
        'category' => '문서',
        'title' => '웹 보안 체크리스트 2025',
        'author' => '보안전문가',
        'level' => 9,
        'date' => '2025-01-07 11:45',
        'likes' => 123,
        'dislikes' => 1,
        'comments' => 8,
        'content' => '
            <p>2025년 최신 웹 보안 트렌드를 반영한 체크리스트입니다.</p>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1555949963-ff9fe0c870eb?w=800&h=400&fit=crop" alt="보안">
            </div>
            <h3>체크리스트 항목</h3>
            <ul>
                <li>SQL Injection 방어</li>
                <li>XSS 공격 방어</li>
                <li>CSRF 토큰 적용</li>
                <li>HTTPS 적용 및 설정</li>
                <li>세션 보안 강화</li>
                <li>파일 업로드 보안</li>
                <li>API 보안</li>
            </ul>
            <p>실제 사례와 함께 상세한 대응 방법을 설명합니다.</p>
        ',
        'download' => [
            'cost_type' => 'point',
            'cost_value' => 100,
            'file_count' => 1,
            'file_size' => '1.5MB',
            'duration' => null,
            'download_count' => 156,
            'has_ad' => true
        ],
        'files' => [
            ['name' => 'web_security_checklist_2025.pdf', 'size' => '1.5MB']
        ]
    ],
    6 => [
        'id' => 6,
        'category' => '동영상',
        'title' => 'React 강의 풀버전 (10시간)',
        'author' => '프론트개발',
        'level' => 4,
        'date' => '2025-01-07 09:30',
        'likes' => 456,
        'dislikes' => 8,
        'comments' => 67,
        'content' => '
            <p>React 입문부터 실전까지 완벽하게 배울 수 있는 풀버전 강의입니다.</p>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=800&h=400&fit=crop" alt="React 강의">
            </div>
            <h3>강의 커리큘럼</h3>
            <ul>
                <li>Part 1: React 기초 (2시간) - JSX, 컴포넌트, Props, State</li>
                <li>Part 2: React Hooks (2시간) - useState, useEffect, useContext, 커스텀 훅</li>
                <li>Part 3: 상태관리 (2시간) - Redux, Redux Toolkit, Zustand</li>
                <li>Part 4: 라우팅 & API (2시간) - React Router, Axios, React Query</li>
                <li>Part 5: 실전 프로젝트 (2시간) - 쇼핑몰 만들기</li>
            </ul>
            <p>총 10시간 25분 분량의 고화질 강의입니다.</p>
            <p>예제 소스코드 포함!</p>
        ',
        'download' => [
            'cost_type' => 'cash',
            'cost_value' => 1000,
            'file_count' => 1,
            'file_size' => '4.2GB',
            'duration' => '10:25:36',
            'download_count' => 389,
            'has_ad' => true
        ],
        'files' => [
            ['name' => 'react_full_course.mp4', 'size' => '4.2GB']
        ]
    ],
    7 => [
        'id' => 7,
        'category' => '문서',
        'title' => '2025년 IT 트렌드 리포트',
        'author' => '기술분석가',
        'level' => 6,
        'date' => '2025-01-06 15:00',
        'likes' => 234,
        'dislikes' => 4,
        'comments' => 28,
        'content' => '
            <p>2025년 주목해야 할 IT 트렌드를 분석한 리포트입니다.</p>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&h=400&fit=crop" alt="IT 트렌드">
            </div>
            <h3>주요 내용</h3>
            <ul>
                <li>AI/ML 기술 동향 및 전망</li>
                <li>클라우드 네이티브 아키텍처</li>
                <li>엣지 컴퓨팅의 부상</li>
                <li>사이버 보안 위협과 대응</li>
                <li>Web3와 블록체인 현황</li>
                <li>개발자 생산성 도구</li>
            </ul>
            <p>국내외 시장 분석과 투자 전망까지 담았습니다.</p>
        ',
        'download' => [
            'cost_type' => 'point',
            'cost_value' => 150,
            'file_count' => 1,
            'file_size' => '3.8MB',
            'duration' => null,
            'download_count' => 234,
            'has_ad' => false
        ],
        'files' => [
            ['name' => 'it_trend_report_2025.pdf', 'size' => '3.8MB']
        ]
    ],
    8 => [
        'id' => 8,
        'category' => '이미지',
        'title' => '고해상도 배경화면 모음 (4K)',
        'author' => '사진작가',
        'level' => 3,
        'date' => '2025-01-06 10:30',
        'likes' => 178,
        'dislikes' => 2,
        'comments' => 19,
        'content' => '
            <p>직접 촬영한 고해상도 배경화면 모음입니다.</p>
            <div class="content-image">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=400&fit=crop" alt="배경화면 샘플">
            </div>
            <h3>포함된 이미지</h3>
            <ul>
                <li>자연 풍경 30장</li>
                <li>도시 야경 20장</li>
                <li>우주/별 10장</li>
                <li>추상 아트 15장</li>
                <li>미니멀 디자인 25장</li>
            </ul>
            <p>모든 이미지 4K (3840x2160) 해상도!</p>
            <p>개인/상업적 사용 모두 가능합니다.</p>
        ',
        'download' => [
            'cost_type' => 'free',
            'cost_value' => 0,
            'file_count' => 100,
            'file_size' => '128MB',
            'duration' => null,
            'download_count' => 654,
            'has_ad' => false
        ],
        'files' => [
            ['name' => 'wallpaper_4k_collection.zip', 'size' => '128MB']
        ]
    ],
];

$post = $posts[$post_id] ?? $posts[1];
$prev_id = $post_id > 1 ? $post_id - 1 : null;
$next_id = $post_id < 6 ? $post_id + 1 : null;

// 이전/다음 글 찾기
$prev_post = null;
$next_post = null;
$ids = array_keys($posts);
$current_idx = array_search($post_id, $ids);
if ($current_idx !== false) {
    if ($current_idx > 0) $prev_post = $posts[$ids[$current_idx - 1]];
    if ($current_idx < count($ids) - 1) $next_post = $posts[$ids[$current_idx + 1]];
}

$comments = [
    ['id' => 1, 'author' => '다운러1', 'date' => '01-08 15:20', 'content' => '좋은 자료 감사합니다!', 'likes' => 12],
    ['id' => 2, 'author' => '개발자A', 'date' => '01-08 16:45', 'content' => '정말 유용하네요~', 'likes' => 8],
    ['id' => 3, 'author' => '초보코더', 'date' => '01-08 18:30', 'content' => '잘 받아갑니다!', 'likes' => 3],
];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <script>document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');</script>
    <?php include 'includes/head.php'; ?>
    <title><?php echo htmlspecialchars($post['title']); ?> - 자료실</title>
    <style>
        .main-content { padding: 20px; }

        /* 브레드크럼 */
        .breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--text-light);
            margin-bottom: 20px;
        }
        .breadcrumb a { color: var(--text-secondary); text-decoration: none; }
        .breadcrumb a:hover { color: #10b981; }
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
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            font-size: 12px; font-weight: 600;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .post-category.program { background: rgba(99, 102, 241, 0.1); color: #6366f1; }
        .post-category.document { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .post-category.image { background: rgba(236, 72, 153, 0.1); color: #ec4899; }
        .post-category.video { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

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

        /* 다운로드 정보 박스 */
        .download-info-box {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
        }

        .download-info-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .download-info-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .download-info-label {
            padding: 6px 12px;
            background: var(--accent);
            color: white;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            white-space: nowrap;
        }

        .download-info-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .download-info-value.point { color: #f59e0b; }
        .download-info-value.cash { color: var(--accent); }

        .download-info-label.ad-yes {
            background: #f59e0b;
        }
        .download-info-label.ad-no {
            background: #10b981;
        }

        .download-btn-large {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.35);
        }

        .download-btn-large:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.45);
        }

        .download-btn-large:active {
            transform: translateY(0);
        }

        .download-btn-large svg {
            width: 18px;
            height: 18px;
        }

        /* 다운로드 결과 영역 (버튼 자리에 표시) */
        .download-result {
            display: none;
            flex-direction: column;
            gap: 12px;
            animation: fadeInUp 0.3s ease;
        }

        .download-result.show {
            display: flex;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .download-result-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 10px;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .download-result-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .download-result-icon svg {
            width: 18px;
            height: 18px;
            color: white;
        }

        .download-result-text {
            flex: 1;
            min-width: 0;
        }

        .download-result-title {
            font-size: 14px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 2px;
        }

        .download-result-expire {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .download-result-expire strong {
            color: #f59e0b;
        }

        .download-links-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .download-link-item {
            background: var(--bg-main);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .download-link-num {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .download-link-input {
            flex: 1;
            background: transparent;
            border: none;
            font-size: 11px;
            color: var(--text-primary);
            font-family: 'Consolas', 'Monaco', monospace;
            outline: none;
            min-width: 0;
        }

        .download-link-copy {
            padding: 6px 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
        }

        .download-link-copy:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .download-link-copy.copied {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .download-link-copy svg {
            width: 11px;
            height: 11px;
        }

        .download-notice-inline {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.08), rgba(249, 115, 22, 0.08));
            border: 1px solid rgba(239, 68, 68, 0.15);
            border-radius: 10px;
            padding: 12px 14px;
        }

        .download-notice-inline-title {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            color: #ef4444;
            margin-bottom: 8px;
        }

        .download-notice-inline-title svg {
            width: 14px;
            height: 14px;
        }

        .download-notice-inline-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 11px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .download-notice-inline-list li {
            position: relative;
            padding-left: 12px;
            margin-bottom: 2px;
        }

        .download-notice-inline-list li:last-child {
            margin-bottom: 0;
        }

        .download-notice-inline-list li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #ef4444;
        }

        .download-notice-inline-list strong {
            color: var(--text-primary);
        }

        .download-guide-inline {
            background: rgba(99, 102, 241, 0.06);
            border: 1px solid rgba(99, 102, 241, 0.15);
            border-radius: 10px;
            padding: 12px 14px;
        }

        .download-guide-inline-title {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            color: #6366f1;
            margin-bottom: 8px;
        }

        .download-guide-inline-title svg {
            width: 14px;
            height: 14px;
        }

        .download-guide-inline-steps {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .download-guide-inline-step {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            color: var(--text-secondary);
        }

        .step-num {
            width: 18px;
            height: 18px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
            font-weight: 700;
            flex-shrink: 0;
        }

        @media (max-width: 480px) {
            .download-link-box {
                flex-direction: column;
                gap: 8px;
            }
            .download-link-input {
                width: 100%;
                text-align: center;
            }
            .download-link-copy {
                width: 100%;
                justify-content: center;
            }
        }

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

        .post-content ul {
            margin: 16px 0;
            padding-left: 24px;
        }

        .post-content li {
            margin-bottom: 8px;
            line-height: 1.6;
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
            border-color: #10b981;
            color: #10b981;
        }

        .content-action-btn.active {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .content-action-btn .action-icon { font-size: 18px; }
        .content-action-btn .action-count { font-weight: 700; }

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

        .pn-item:hover { border-color: #10b981; background: var(--bg-main); }
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

        .comments-count { color: #10b981; }

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

        .comment-input:focus { border-color: #10b981; }
        .comment-input::placeholder { color: var(--text-light); }

        .comment-submit {
            padding: 14px 20px;
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
            border: none; border-radius: 12px;
            font-size: 14px; font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .comment-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }

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
            background: linear-gradient(135deg, #10b981, #34d399);
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

        .comment-like:hover { border-color: #10b981; color: #10b981; }
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

        .btn-list:hover { border-color: #10b981; color: #10b981; }

        .btn-write {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white; border: none;
        }

        .btn-write:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }

        /* 토스트 */
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

        /* 반응형 */
        @media (max-width: 768px) {
            .main-content { padding: 16px; }
            .post-header, .post-content, .download-info-box, .comments-section { padding: 16px; border-radius: 12px; }
            .post-title { font-size: 18px; }
            .post-title-row { flex-wrap: wrap; gap: 8px; }
            .post-meta { gap: 12px; font-size: 12px; }
            .download-info-grid { flex-direction: column; gap: 10px; }
            .download-info-item { width: 100%; }
            .post-content-actions { gap: 6px; }
            .content-action-btn { padding: 8px 10px; font-size: 12px; gap: 4px; }
            .content-action-btn .action-icon { font-size: 14px; }
            .post-nav { grid-template-columns: 1fr; }
            .pn-item.next { flex-direction: row; text-align: left; }
            .comment-form { flex-direction: column; }
            .post-bottom { flex-direction: column; }
            .bottom-btn { justify-content: center; }
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
                <a href="pds.php">자료실</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                <span><?php echo htmlspecialchars($post['title']); ?></span>
            </nav>

            <!-- 게시글 헤더 -->
            <header class="post-header">
                <div class="post-title-row">
                    <?php
                    $categoryClass = '';
                    if ($post['category'] === '프로그램') $categoryClass = 'program';
                    elseif ($post['category'] === '문서') $categoryClass = 'document';
                    elseif ($post['category'] === '이미지') $categoryClass = 'image';
                    elseif ($post['category'] === '동영상') $categoryClass = 'video';
                    ?>
                    <span class="post-category <?php echo $categoryClass; ?>"><?php echo htmlspecialchars($post['category']); ?></span>
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        <span>다운로드 <?php echo number_format($post['download']['download_count']); ?></span>
                    </div>
                </div>
            </header>

            <!-- 다운로드 정보 박스 -->
            <section class="download-info-box">
                <div class="download-info-grid">
                    <div class="download-info-item">
                        <span class="download-info-label">다운포인트</span>
                        <?php
                        $costClass = $post['download']['cost_type'] === 'cash' ? 'cash' : 'point';
                        $costText = $post['download']['cost_value'] . ($post['download']['cost_type'] === 'cash' ? ' C' : ' P');
                        if ($post['download']['cost_value'] == 0) {
                            $costText = '무료';
                            $costClass = '';
                        }
                        ?>
                        <span class="download-info-value <?php echo $costClass; ?>"><?php echo $costText; ?></span>
                    </div>
                    <div class="download-info-item">
                        <span class="download-info-label">영상개수</span>
                        <span class="download-info-value"><?php echo number_format($post['download']['file_count']); ?>개</span>
                    </div>
                    <div class="download-info-item">
                        <span class="download-info-label">파일용량</span>
                        <span class="download-info-value"><?php echo $post['download']['file_size']; ?></span>
                    </div>
                    <?php if ($post['download']['duration']): ?>
                    <div class="download-info-item">
                        <span class="download-info-label">재생시간</span>
                        <span class="download-info-value"><?php echo $post['download']['duration']; ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="download-info-item">
                        <span class="download-info-label <?php echo $post['download']['has_ad'] ? 'ad-yes' : 'ad-no'; ?>">광고</span>
                        <span class="download-info-value"><?php echo $post['download']['has_ad'] ? '있음' : '없음'; ?></span>
                    </div>
                </div>
                <!-- 다운로드 버튼 -->
                <button class="download-btn-large" id="downloadBtn" onclick="downloadFile()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    다운로드 링크 받기
                </button>

                <!-- 다운로드 결과 (버튼 자리에 표시) -->
                <div class="download-result" id="downloadResult">
                    <div class="download-result-header">
                        <div class="download-result-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20,6 9,17 4,12"/></svg>
                        </div>
                        <div class="download-result-text">
                            <div class="download-result-title">다운로드 링크 생성 완료</div>
                            <div class="download-result-expire">남은 시간: <strong id="countdownTimer">2일 23:59:59</strong></div>
                        </div>
                    </div>

                    <!-- 다운로드 링크 목록 -->
                    <div class="download-links-list" id="downloadLinksList">
                        <!-- JS로 렌더링 -->
                    </div>

                    <div class="download-notice-inline">
                        <div class="download-notice-inline-title">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            주의사항
                        </div>
                        <ul class="download-notice-inline-list">
                            <li>링크는 <strong>3일간</strong> 유효합니다</li>
                            <li>타인과 공유 시 <strong>계정 차단</strong></li>
                            <li>1인 1회 다운로드 가능</li>
                        </ul>
                    </div>

                    <div class="download-guide-inline">
                        <div class="download-guide-inline-title">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            다운로드 방법
                        </div>
                        <div class="download-guide-inline-steps">
                            <div class="download-guide-inline-step">
                                <span class="step-num">1</span>
                                <span>위 링크를 <strong>복사</strong></span>
                            </div>
                            <div class="download-guide-inline-step">
                                <span class="step-num">2</span>
                                <span>브라우저 주소창에 <strong>붙여넣기</strong> 후 접속</span>
                            </div>
                            <div class="download-guide-inline-step">
                                <span class="step-num">3</span>
                                <span>페이지에서 파일 <strong>다운로드</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

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

            <!-- 이전/다음글 -->
            <nav class="post-nav">
                <?php if ($prev_post): ?>
                <a href="pds_view.php?id=<?php echo $prev_post['id']; ?>" class="pn-item prev">
                    <div class="pn-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"/></svg>
                    </div>
                    <div class="pn-text">
                        <div class="pn-label">이전글</div>
                        <div class="pn-title"><?php echo htmlspecialchars($prev_post['title']); ?></div>
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

                <?php if ($next_post): ?>
                <a href="pds_view.php?id=<?php echo $next_post['id']; ?>" class="pn-item next">
                    <div class="pn-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                    </div>
                    <div class="pn-text">
                        <div class="pn-label">다음글</div>
                        <div class="pn-title"><?php echo htmlspecialchars($next_post['title']); ?></div>
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
                <a href="pds.php" class="bottom-btn btn-list">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    목록
                </a>
                <button class="bottom-btn btn-write">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    자료 올리기
                </button>
            </div>
        </main>
    </div>

    <?php include 'includes/popup.php'; ?>
    <?php include 'includes/footer.php'; ?>

    <script>
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

        // 다운로드 링크 생성
        let expireTime = null;
        let countdownInterval = null;
        const fileCount = <?php echo $post['download']['file_count']; ?>;

        function generateDownloadLink() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let token = '';
            for (let i = 0; i < 32; i++) {
                token += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return `https://download.example.com/file/${token}`;
        }

        function updateCountdown() {
            if (!expireTime) return;

            const now = new Date().getTime();
            const diff = expireTime - now;

            if (diff <= 0) {
                document.getElementById('countdownTimer').textContent = '만료됨';
                clearInterval(countdownInterval);
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            let timeStr = '';
            if (days > 0) timeStr += days + '일 ';
            timeStr += String(hours).padStart(2, '0') + ':';
            timeStr += String(minutes).padStart(2, '0') + ':';
            timeStr += String(seconds).padStart(2, '0');

            document.getElementById('countdownTimer').textContent = timeStr;
        }

        function renderDownloadLinks(count) {
            const listEl = document.getElementById('downloadLinksList');
            let html = '';

            for (let i = 1; i <= count; i++) {
                const link = generateDownloadLink();
                html += `
                    <div class="download-link-item">
                        <span class="download-link-num">${i}</span>
                        <input type="text" class="download-link-input" value="${link}" readonly>
                        <button class="download-link-copy" onclick="copyLink(this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                            복사
                        </button>
                    </div>
                `;
            }

            listEl.innerHTML = html;
        }

        function downloadFile() {
            const costValue = <?php echo $post['download']['cost_value']; ?>;
            const costType = '<?php echo $post['download']['cost_type']; ?>';

            if (costValue > 0) {
                const costText = costType === 'cash' ? costValue + '캐시' : costValue + '포인트';
                if (!confirm(costText + '가 차감됩니다. 다운로드하시겠습니까?')) {
                    return;
                }
            }

            // 만료 시간 설정 (3일 후)
            expireTime = new Date().getTime() + (3 * 24 * 60 * 60 * 1000);

            // 카운트다운 시작
            updateCountdown();
            countdownInterval = setInterval(updateCountdown, 1000);

            // 다운로드 링크 렌더링 (파일 개수만큼, 최대 5개)
            const linkCount = Math.min(fileCount, 5);
            renderDownloadLinks(linkCount);

            // 버튼 숨기고 결과 표시
            document.getElementById('downloadBtn').style.display = 'none';
            document.getElementById('downloadResult').classList.add('show');

            showToast('다운로드 링크가 생성되었습니다!');
        }

        async function copyLink(btn) {
            const input = btn.previousElementSibling;

            try {
                await navigator.clipboard.writeText(input.value);
                btn.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20,6 9,17 4,12"/></svg>
                    완료
                `;
                btn.classList.add('copied');
                showToast('링크가 복사되었습니다!');

                setTimeout(() => {
                    btn.innerHTML = `
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        복사
                    `;
                    btn.classList.remove('copied');
                }, 2000);
            } catch (e) {
                input.select();
                document.execCommand('copy');
                showToast('링크가 복사되었습니다!');
            }
        }

        // 추천
        function toggleLike(btn) {
            btn.classList.toggle('active');
            const count = btn.querySelector('.action-count');
            let val = parseInt(count.textContent.replace(/,/g, ''));
            val += btn.classList.contains('active') ? 1 : -1;
            count.textContent = val.toLocaleString();
            showToast(btn.classList.contains('active') ? '추천했습니다!' : '추천을 취소했습니다.');
        }

        // 공유
        async function sharePost() {
            const url = location.href;
            try {
                await navigator.clipboard.writeText(url);
                showToast('링크가 복사되었습니다!');
            } catch (e) {
                showToast('링크 복사에 실패했습니다.', 'error');
            }
        }

        // 스크랩
        function scrapPost(btn) {
            btn.classList.toggle('active');
            showToast(btn.classList.contains('active') ? '스크랩되었습니다!' : '스크랩이 취소되었습니다.');
        }

        // 신고
        function reportPost() {
            if (confirm('이 게시물을 신고하시겠습니까?')) {
                showToast('신고가 접수되었습니다.');
            }
        }

        // 댓글 등록
        function submitComment(e) {
            e.preventDefault();
            const input = e.target.querySelector('.comment-input');
            const content = input.value.trim();

            if (!content) {
                showToast('댓글 내용을 입력하세요.', 'error');
                return;
            }

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
                    <button class="comment-like" onclick="likeComment(this)">
                        ❤️ 0
                    </button>
                </div>
                <div class="comment-text">${content.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</div>
            `;
            commentList.insertBefore(newComment, commentList.firstChild);

            const countEl = document.querySelector('.comments-count');
            countEl.textContent = parseInt(countEl.textContent) + 1;

            input.value = '';
            showToast('댓글이 등록되었습니다!');
        }

        // 댓글 좋아요
        function likeComment(btn) {
            const num = parseInt(btn.textContent.replace(/[^0-9]/g, ''));
            btn.textContent = '❤️ ' + (num + 1);
            btn.style.color = '#10b981';
            btn.style.borderColor = '#10b981';
        }
    </script>
</body>
</html>
