<?php
/**
 * 그누보드5 게시글 읽기 스킨 - 다크 럭셔리 테마
 * Dark Luxury Board View Skin
 *
 * - 반응형: 360px ~ 1440px
 * - 다크/라이트 테마 지원
 * - 파일 다운로드 포인트/캐시 차감 기능
 * - 이미지 미리보기 기능
 * - 접근성: 버튼 터치영역 최소 44px, 포커스 표시, 대비 확보
 */

if (!defined('_GNUBOARD_')) exit;

// 썸네일 라이브러리
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// CSS 로드 (캐시버스터)
$css_file = G5_DATA_PATH.'/skin/board/'.$board['bo_skin'].'/css/board_view.css';
if (!file_exists($css_file)) {
    $css_file = G5_PATH.'/css/board_view.css';
}
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/board_view.css?ver='.filemtime($css_file).'">', 0);

// Font Awesome 아이콘
add_stylesheet('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">', 1);

// 이미지 리사이즈 스크립트
add_javascript('<script src="'.G5_JS_URL.'/viewimageresize.js"></script>', 0);

// 스크랩 여부 확인
$is_scrap = false;
if ($is_member) {
    $scrap_check = sql_fetch("SELECT COUNT(*) as cnt FROM {$g5['scrap_table']} WHERE mb_id = '{$member['mb_id']}' AND bo_table = '{$bo_table}' AND wr_id = '{$wr_id}'");
    $is_scrap = ($scrap_check['cnt'] > 0);
}

// 다운로드 권한 확인
$is_download_auth = ($board['bo_download_point'] >= 0 || $is_admin || $member['mb_level'] >= $board['bo_download_level']);

// 포인트/캐시 설정 (게시판 설정에서 가져오거나 기본값 사용)
$download_point = abs($board['bo_download_point']);
$download_cash = isset($board['bo_download_cash']) ? abs($board['bo_download_cash']) : 0;
?>

<!-- 게시글 읽기 시작 -->
<div class="bv-container" id="bo_v">

    <!-- 브레드크럼 -->
    <nav class="bv-breadcrumb" aria-label="현재 위치">
        <a href="<?php echo G5_URL; ?>">홈</a>
        <span class="bv-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
        <a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $board['bo_subject']; ?></a>
        <span class="bv-breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
        <span><?php echo cut_str(get_text($view['wr_subject']), 30); ?></span>
    </nav>

    <!-- 게시글 헤더 -->
    <header class="bv-header">
        <?php if ($view['ca_name']): ?>
        <span class="bv-category"><?php echo $view['ca_name']; ?></span>
        <?php endif; ?>

        <h1 class="bv-title"><?php echo get_text($view['wr_subject']); ?></h1>

        <div class="bv-meta">
            <div class="bv-meta-item">
                <i class="fas fa-user"></i>
                <span class="bv-author"><?php echo get_text($view['wr_name']); ?></span>
                <?php if ($view['mb_level']): ?>
                <span class="bv-author-level"><?php echo $view['mb_level']; ?></span>
                <?php endif; ?>
            </div>
            <div class="bv-meta-item">
                <i class="far fa-clock"></i>
                <span><?php echo date('Y.m.d H:i', strtotime($view['wr_datetime'])); ?></span>
            </div>
            <div class="bv-meta-item">
                <i class="far fa-eye"></i>
                <span>조회 <?php echo number_format($view['wr_hit']); ?></span>
            </div>
            <div class="bv-meta-item">
                <i class="far fa-heart"></i>
                <span>추천 <?php echo number_format($view['wr_good']); ?></span>
            </div>
            <?php if ($view['wr_comment']): ?>
            <div class="bv-meta-item">
                <i class="far fa-comment"></i>
                <span>댓글 <?php echo number_format($view['wr_comment']); ?></span>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- 게시글 본문 -->
    <article class="bv-content">
        <div class="bv-content-body" id="bo_v_con">
            <?php echo $view['content']; ?>
        </div>
    </article>

    <!-- 첨부파일 영역 -->
    <?php if ($view['file']['count'] > 0): ?>
    <section class="bv-files" aria-label="첨부파일">
        <div class="bv-files-header">
            <div class="bv-files-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <div>
                <div class="bv-files-title">첨부파일</div>
                <div class="bv-files-count"><?php echo $view['file']['count']; ?>개 파일</div>
            </div>
        </div>

        <div class="bv-file-list">
            <?php for ($i = 0; $i < count($view['file']); $i++):
                if (!$view['file'][$i]) continue;

                $file = $view['file'][$i];
                $file_name = $file['source'];
                $file_size = number_format($file['size'] / 1024, 1) . 'KB';
                if ($file['size'] >= 1048576) {
                    $file_size = number_format($file['size'] / 1048576, 1) . 'MB';
                }
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $is_image = in_array($file_ext, array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'));
                $is_free = ($board['bo_download_point'] >= 0);

                // 썸네일 생성 (이미지인 경우)
                $thumb_url = '';
                if ($is_image && $file['path']) {
                    $thumb = get_thumbnail($file['path'], 48, 48, true, true);
                    $thumb_url = $thumb['src'] ?? '';
                }
            ?>
            <div class="bv-file-item">
                <div class="bv-file-thumb <?php echo $is_image ? 'is-image' : ''; ?>" <?php if ($is_image): ?>onclick="bvPreviewImage('<?php echo addslashes($file['view']); ?>')"<?php endif; ?>>
                    <?php if ($thumb_url): ?>
                    <img src="<?php echo $thumb_url; ?>" alt="썸네일" loading="lazy">
                    <?php else: ?>
                    <i class="fas <?php echo $is_image ? 'fa-image' : 'fa-file'; ?>"></i>
                    <?php endif; ?>
                </div>

                <div class="bv-file-info">
                    <div class="bv-file-name"><?php echo $file_name; ?></div>
                    <div class="bv-file-meta">
                        <span><?php echo $file_size; ?></span>
                        <span>다운 <?php echo number_format($file['download']); ?>회</span>
                    </div>
                </div>

                <div class="bv-file-actions">
                    <?php if ($is_free): ?>
                    <span class="bv-file-cost is-free"><i class="fas fa-check"></i> 무료</span>
                    <?php elseif ($download_cash > 0): ?>
                    <span class="bv-file-cost is-cash"><i class="fas fa-coins"></i> <?php echo number_format($download_cash); ?>캐시</span>
                    <?php else: ?>
                    <span class="bv-file-cost"><i class="fas fa-star"></i> <?php echo number_format($download_point); ?>P</span>
                    <?php endif; ?>

                    <?php if ($is_image): ?>
                    <button type="button" class="bv-file-btn bv-file-btn-secondary" onclick="bvPreviewImage('<?php echo addslashes($file['view']); ?>')">
                        <i class="fas fa-eye"></i>
                        <span>미리보기</span>
                    </button>
                    <?php endif; ?>

                    <?php if ($is_download_auth): ?>
                    <a href="<?php echo $file['href']; ?>" class="bv-file-btn bv-file-btn-primary view_file_download" <?php if (!$is_free): ?>onclick="return bvConfirmDownload(<?php echo $download_point; ?>, <?php echo $download_cash; ?>)"<?php endif; ?>>
                        <i class="fas fa-download"></i>
                        <span>다운로드</span>
                    </a>
                    <?php else: ?>
                    <button type="button" class="bv-file-btn bv-file-btn-primary" onclick="alert('다운로드 권한이 없습니다.\n<?php echo $board['bo_download_level']; ?>레벨 이상만 다운로드 가능합니다.')">
                        <i class="fas fa-lock"></i>
                        <span>권한필요</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- 이미지 첨부 갤러리 (본문 이미지) -->
    <?php if (!empty($view['images']) && count($view['images']) > 0): ?>
    <section class="bv-gallery" aria-label="첨부 이미지">
        <div class="bv-gallery-header">
            <i class="fas fa-images"></i>
            <span>첨부 이미지 (<?php echo count($view['images']); ?>)</span>
        </div>
        <div class="bv-gallery-grid">
            <?php foreach ($view['images'] as $img): ?>
            <div class="bv-gallery-item" onclick="bvPreviewImage('<?php echo addslashes($img['src']); ?>')">
                <img src="<?php echo $img['thumb'] ?? $img['src']; ?>" alt="첨부 이미지" loading="lazy">
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- 액션 버튼 -->
    <div class="bv-actions">
        <a href="<?php echo $good_href.'&amp;'.$qstr; ?>" id="bv_good" class="bv-action-btn is-good <?php echo $view['is_good'] ? 'active' : ''; ?>" title="추천">
            <i class="<?php echo $view['is_good'] ? 'fas' : 'far'; ?> fa-heart"></i>
            <span>추천</span>
            <span class="bv-action-count"><?php echo number_format($view['wr_good']); ?></span>
        </a>

        <?php if ($board['bo_use_nogood']): ?>
        <a href="<?php echo $nogood_href.'&amp;'.$qstr; ?>" id="bv_nogood" class="bv-action-btn is-nogood" title="비추천">
            <i class="far fa-thumbs-down"></i>
            <span>비추천</span>
            <span class="bv-action-count"><?php echo number_format($view['wr_nogood']); ?></span>
        </a>
        <?php endif; ?>

        <button type="button" class="bv-action-btn" onclick="bvShareOpen()" title="공유">
            <i class="fas fa-share-alt"></i>
            <span>공유</span>
        </button>

        <?php if ($is_member): ?>
        <button type="button" class="bv-action-btn <?php echo $is_scrap ? 'active' : ''; ?>" onclick="bvScrap()" title="스크랩">
            <i class="<?php echo $is_scrap ? 'fas' : 'far'; ?> fa-bookmark"></i>
            <span>스크랩</span>
        </button>
        <?php endif; ?>

        <button type="button" class="bv-action-btn" onclick="bvReportOpen()" title="신고">
            <i class="fas fa-flag"></i>
            <span>신고</span>
        </button>
    </div>

    <!-- 이전글/다음글 -->
    <nav class="bv-nav" aria-label="이전글 다음글">
        <?php if ($prev_href): ?>
        <a href="<?php echo $prev_href; ?>" class="bv-nav-item is-prev">
            <div class="bv-nav-icon"><i class="fas fa-chevron-left"></i></div>
            <div class="bv-nav-text">
                <div class="bv-nav-label">이전글</div>
                <div class="bv-nav-title"><?php echo cut_str(get_text($prev['wr_subject']), 40); ?></div>
            </div>
        </a>
        <?php else: ?>
        <div class="bv-nav-item bv-nav-empty is-prev">
            <div class="bv-nav-icon"><i class="fas fa-chevron-left"></i></div>
            <div class="bv-nav-text">
                <div class="bv-nav-label">이전글</div>
                <div class="bv-nav-title">이전글이 없습니다</div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($next_href): ?>
        <a href="<?php echo $next_href; ?>" class="bv-nav-item is-next">
            <div class="bv-nav-icon"><i class="fas fa-chevron-right"></i></div>
            <div class="bv-nav-text">
                <div class="bv-nav-label">다음글</div>
                <div class="bv-nav-title"><?php echo cut_str(get_text($next['wr_subject']), 40); ?></div>
            </div>
        </a>
        <?php else: ?>
        <div class="bv-nav-item bv-nav-empty is-next">
            <div class="bv-nav-icon"><i class="fas fa-chevron-right"></i></div>
            <div class="bv-nav-text">
                <div class="bv-nav-label">다음글</div>
                <div class="bv-nav-title">다음글이 없습니다</div>
            </div>
        </div>
        <?php endif; ?>
    </nav>

    <!-- 댓글 영역 -->
    <section class="bv-comments" id="bv_comment">
        <?php
        // 댓글 include
        include_once(G5_BBS_PATH.'/view_comment.php');
        ?>
    </section>

    <!-- 하단 버튼 -->
    <div class="bv-bottom">
        <div class="bv-bottom-left">
            <a href="<?php echo $list_href; ?>" class="bv-btn bv-btn-secondary">
                <i class="fas fa-list"></i>
                <span>목록</span>
            </a>

            <?php if ($write_href): ?>
            <a href="<?php echo $write_href; ?>" class="bv-btn bv-btn-primary">
                <i class="fas fa-pen"></i>
                <span>글쓰기</span>
            </a>
            <?php endif; ?>
        </div>

        <div class="bv-bottom-right">
            <?php if ($update_href): ?>
            <a href="<?php echo $update_href; ?>" class="bv-btn bv-btn-secondary">
                <i class="fas fa-edit"></i>
                <span>수정</span>
            </a>
            <?php endif; ?>

            <?php if ($delete_href): ?>
            <a href="<?php echo $delete_href; ?>" class="bv-btn bv-btn-danger" onclick="return confirm('정말 삭제하시겠습니까?');">
                <i class="fas fa-trash"></i>
                <span>삭제</span>
            </a>
            <?php endif; ?>

            <?php if ($reply_href): ?>
            <a href="<?php echo $reply_href; ?>" class="bv-btn bv-btn-secondary">
                <i class="fas fa-reply"></i>
                <span>답변</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- 게시글 읽기 끝 -->

<!-- 이미지 미리보기 모달 -->
<div class="bv-modal-overlay" id="bvImageModal" onclick="bvCloseImageModal(event)">
    <div class="bv-modal-content">
        <button type="button" class="bv-modal-close" onclick="bvCloseImageModal(event)" aria-label="닫기">
            <i class="fas fa-times"></i>
        </button>
        <img src="" alt="이미지 미리보기" id="bvModalImage">
    </div>
</div>

<!-- 다운로드 확인 모달 -->
<div class="bv-download-modal" id="bvDownloadModal">
    <div class="bv-download-box">
        <div class="bv-download-icon">
            <i class="fas fa-download"></i>
        </div>
        <h3 class="bv-download-title">파일 다운로드</h3>
        <p class="bv-download-desc">
            파일을 다운로드하시면 포인트/캐시가 차감됩니다.<br>
            (게시물당 1회만 차감)
        </p>
        <div class="bv-download-cost">
            <span class="bv-download-cost-label">차감 비용:</span>
            <span class="bv-download-cost-value" id="bvDownloadCost">-</span>
        </div>
        <div class="bv-download-actions">
            <button type="button" class="bv-btn bv-btn-secondary" onclick="bvCloseDownloadModal()">취소</button>
            <button type="button" class="bv-btn bv-btn-primary" id="bvDownloadConfirm">다운로드</button>
        </div>
    </div>
</div>

<!-- 공유 모달 -->
<div class="bv-share-modal" id="bvShareModal">
    <div class="bv-share-box">
        <div class="bv-share-header">
            <h3 class="bv-share-title">공유하기</h3>
            <button type="button" class="bv-share-close" onclick="bvShareClose()" aria-label="닫기">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="bv-share-links">
            <a href="javascript:bvShareKakao()" class="bv-share-link kakao">
                <i class="fas fa-comment"></i>
                <span>카카오톡</span>
            </a>
            <a href="javascript:bvShareFacebook()" class="bv-share-link facebook">
                <i class="fab fa-facebook-f"></i>
                <span>페이스북</span>
            </a>
            <a href="javascript:bvShareTwitter()" class="bv-share-link twitter">
                <i class="fab fa-twitter"></i>
                <span>트위터</span>
            </a>
            <a href="javascript:bvCopyLink()" class="bv-share-link link">
                <i class="fas fa-link"></i>
                <span>링크복사</span>
            </a>
        </div>
        <div class="bv-share-url">
            <input type="text" id="bvShareUrl" value="<?php echo G5_URL.'/'.get_pretty_url($bo_table, $wr_id); ?>" readonly>
            <button type="button" onclick="bvCopyLink()">복사</button>
        </div>
    </div>
</div>

<!-- 신고 모달 -->
<div class="bv-report-modal" id="bvReportModal">
    <div class="bv-report-box">
        <div class="bv-report-header">
            <h3 class="bv-report-title">게시글 신고</h3>
            <button type="button" class="bv-share-close" onclick="bvReportClose()" aria-label="닫기">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="bvReportForm" onsubmit="return bvReportSubmit()">
            <div class="bv-report-options">
                <label class="bv-report-option">
                    <input type="radio" name="report_type" value="spam" required>
                    <span>스팸/광고</span>
                </label>
                <label class="bv-report-option">
                    <input type="radio" name="report_type" value="abuse">
                    <span>욕설/비방</span>
                </label>
                <label class="bv-report-option">
                    <input type="radio" name="report_type" value="adult">
                    <span>음란물</span>
                </label>
                <label class="bv-report-option">
                    <input type="radio" name="report_type" value="copyright">
                    <span>저작권 침해</span>
                </label>
                <label class="bv-report-option">
                    <input type="radio" name="report_type" value="other">
                    <span>기타</span>
                </label>
            </div>
            <textarea class="bv-report-textarea" name="report_content" placeholder="신고 사유를 입력해주세요 (선택사항)"></textarea>
            <div class="bv-report-actions">
                <button type="button" class="bv-btn bv-btn-secondary" onclick="bvReportClose()">취소</button>
                <button type="submit" class="bv-btn bv-btn-danger">신고하기</button>
            </div>
        </form>
    </div>
</div>

<!-- 토스트 알림 -->
<div class="bv-toast" id="bvToast"></div>

<!-- JavaScript -->
<script>
// 이미지 리사이즈
$(function() {
    $("#bo_v_con").viewimageresize();
});

// 추천/비추천
$("#bv_good, #bv_nogood").click(function(e) {
    e.preventDefault();

    <?php if (!$is_member): ?>
    bvToast('로그인 후 이용해주세요.', 'error');
    return false;
    <?php endif; ?>

    var $this = $(this);
    $.ajax({
        url: $this.attr('href'),
        type: 'POST',
        data: { js: 'on' },
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                bvToast(data.error, 'error');
                return;
            }
            if (data.count !== undefined) {
                $this.find('.bv-action-count').text(number_format(data.count));
                $this.addClass('active');
                $this.find('i').removeClass('far').addClass('fas');
                bvToast($this.attr('id') === 'bv_good' ? '추천하였습니다.' : '비추천하였습니다.', 'success');
            }
        }
    });
    return false;
});

// 스크랩
function bvScrap() {
    <?php if (!$is_member): ?>
    bvToast('로그인 후 이용해주세요.', 'error');
    return;
    <?php endif; ?>

    $.ajax({
        url: '<?php echo G5_BBS_URL; ?>/scrap_popin.php',
        type: 'POST',
        data: {
            bo_table: '<?php echo $bo_table; ?>',
            wr_id: '<?php echo $wr_id; ?>',
            token: '<?php echo $token; ?>'
        },
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                bvToast(data.error, 'error');
                return;
            }
            bvToast('스크랩되었습니다.', 'success');
        },
        error: function() {
            // 기존 스크랩 팝업 열기
            window.open('<?php echo G5_BBS_URL; ?>/scrap_popin.php?bo_table=<?php echo $bo_table; ?>&wr_id=<?php echo $wr_id; ?>', 'scrap', 'width=500,height=400');
        }
    });
}

// 이미지 미리보기
function bvPreviewImage(src) {
    var modal = document.getElementById('bvImageModal');
    var img = document.getElementById('bvModalImage');
    img.src = src;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function bvCloseImageModal(e) {
    if (e.target.id === 'bvImageModal' || e.target.closest('.bv-modal-close')) {
        document.getElementById('bvImageModal').classList.remove('active');
        document.body.style.overflow = '';
    }
}

// 다운로드 확인
var pendingDownloadHref = '';

function bvConfirmDownload(point, cash) {
    var costText = '';
    if (cash > 0) {
        costText = number_format(cash) + ' 캐시';
    } else if (point > 0) {
        costText = number_format(point) + ' 포인트';
    }

    document.getElementById('bvDownloadCost').textContent = costText;
    document.getElementById('bvDownloadModal').classList.add('active');
    pendingDownloadHref = event.target.closest('a').href + '&js=on';

    document.getElementById('bvDownloadConfirm').onclick = function() {
        location.href = pendingDownloadHref;
    };

    return false;
}

function bvCloseDownloadModal() {
    document.getElementById('bvDownloadModal').classList.remove('active');
}

// 공유
function bvShareOpen() {
    document.getElementById('bvShareModal').classList.add('active');
}

function bvShareClose() {
    document.getElementById('bvShareModal').classList.remove('active');
}

function bvShareKakao() {
    // 카카오 SDK 사용 시
    if (typeof Kakao !== 'undefined' && Kakao.isInitialized()) {
        Kakao.Share.sendDefault({
            objectType: 'feed',
            content: {
                title: '<?php echo addslashes(get_text($view['wr_subject'])); ?>',
                description: '<?php echo addslashes(cut_str(strip_tags($view['content']), 100)); ?>',
                imageUrl: '',
                link: {
                    mobileWebUrl: location.href,
                    webUrl: location.href
                }
            }
        });
    } else {
        bvCopyLink();
        bvToast('링크가 복사되었습니다. 카카오톡에 붙여넣기 해주세요.', 'success');
    }
}

function bvShareFacebook() {
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(location.href), 'facebook', 'width=600,height=400');
}

function bvShareTwitter() {
    window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(location.href) + '&text=' + encodeURIComponent('<?php echo addslashes(get_text($view['wr_subject'])); ?>'), 'twitter', 'width=600,height=400');
}

function bvCopyLink() {
    var input = document.getElementById('bvShareUrl');
    input.select();
    input.setSelectionRange(0, 99999);

    if (navigator.clipboard) {
        navigator.clipboard.writeText(input.value).then(function() {
            bvToast('링크가 복사되었습니다.', 'success');
        });
    } else {
        document.execCommand('copy');
        bvToast('링크가 복사되었습니다.', 'success');
    }
}

// 신고
function bvReportOpen() {
    <?php if (!$is_member): ?>
    bvToast('로그인 후 이용해주세요.', 'error');
    return;
    <?php endif; ?>

    document.getElementById('bvReportModal').classList.add('active');
}

function bvReportClose() {
    document.getElementById('bvReportModal').classList.remove('active');
}

function bvReportSubmit() {
    var form = document.getElementById('bvReportForm');
    var type = form.querySelector('input[name="report_type"]:checked');

    if (!type) {
        bvToast('신고 사유를 선택해주세요.', 'error');
        return false;
    }

    // AJAX로 신고 처리 (서버 구현 필요)
    $.ajax({
        url: '<?php echo G5_BBS_URL; ?>/ajax.report.php',
        type: 'POST',
        data: {
            bo_table: '<?php echo $bo_table; ?>',
            wr_id: '<?php echo $wr_id; ?>',
            report_type: type.value,
            report_content: form.querySelector('textarea[name="report_content"]').value,
            token: '<?php echo $token; ?>'
        },
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                bvToast(data.error, 'error');
                return;
            }
            bvToast('신고가 접수되었습니다.', 'success');
            bvReportClose();
        },
        error: function() {
            bvToast('신고 처리 중 오류가 발생했습니다.', 'error');
        }
    });

    return false;
}

// 토스트 알림
function bvToast(message, type) {
    var toast = document.getElementById('bvToast');
    toast.textContent = message;
    toast.className = 'bv-toast active';
    if (type) toast.classList.add('is-' + type);

    setTimeout(function() {
        toast.classList.remove('active');
    }, 3000);
}

// 숫자 포맷
function number_format(n) {
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// 모달 외부 클릭 시 닫기
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('bv-share-modal')) {
        bvShareClose();
    }
    if (e.target.classList.contains('bv-report-modal')) {
        bvReportClose();
    }
    if (e.target.classList.contains('bv-download-modal')) {
        bvCloseDownloadModal();
    }
});

// ESC 키로 모달 닫기
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        bvShareClose();
        bvReportClose();
        bvCloseDownloadModal();
        bvCloseImageModal({target: {id: 'bvImageModal'}});
    }
});
</script>
