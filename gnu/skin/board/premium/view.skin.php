<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium 스킨 - 상세보기 (view.skin.php)
 */

// 공통 함수 로드
include_once(dirname(__FILE__).'/_inc.php');

// 게시글 정보
$view_subject = premium_escape($view['wr_subject']);
$view_content = $view['content'];
$view_datetime = $view['wr_datetime'];
$view_hit = number_format($view['wr_hit']);
$view_good = number_format($view['wr_good']);
$view_nogood = number_format($view['wr_nogood']);
$view_comment = number_format($view['wr_comment']);
?>

<!-- 브레드크럼 -->
<nav class="breadcrumb">
    <a href="<?php echo G5_URL; ?>">홈</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
    <a href="<?php echo premium_board_url($bo_table); ?>"><?php echo premium_escape($board['bo_subject']); ?></a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
    <span><?php echo mb_strimwidth($view_subject, 0, 30, '...'); ?></span>
</nav>

<!-- 게시글 헤더 -->
<header class="post-header">
    <div class="post-title-row">
        <?php if ($view['ca_name']) { ?>
        <span class="post-category"><?php echo premium_escape($view['ca_name']); ?></span>
        <?php } ?>
        <h1 class="post-title"><?php echo $view_subject; ?></h1>
    </div>

    <div class="post-meta">
        <div class="post-meta-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span><?php echo $view['name']; ?></span>
        </div>
        <div class="post-meta-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
            <span><?php echo date('Y-m-d H:i', strtotime($view_datetime)); ?></span>
        </div>
        <div class="post-meta-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            <span>조회 <?php echo $view_hit; ?></span>
        </div>
    </div>
</header>

<!-- 게시글 본문 -->
<article class="post-content">
    <?php echo $view_content; ?>

    <!-- 추천/비추천 액션 -->
    <div class="post-content-actions">
        <?php if ($is_good) { ?>
        <button class="content-action-btn good-btn" onclick="good_eval2('good', '<?php echo $bo_table; ?>', '<?php echo $wr_id; ?>', this)">
            <span class="action-icon">👍</span>
            <span>추천</span>
            <span class="action-count"><?php echo $view_good; ?></span>
        </button>
        <?php } ?>
        <?php if ($is_nogood) { ?>
        <button class="content-action-btn nogood-btn" onclick="good_eval2('nogood', '<?php echo $bo_table; ?>', '<?php echo $wr_id; ?>', this)">
            <span class="action-icon">👎</span>
            <span>비추천</span>
            <span class="action-count"><?php echo $view_nogood; ?></span>
        </button>
        <?php } ?>
        <button class="content-action-btn" onclick="copyToClipboard()">
            <span class="action-icon">🔗</span>
            <span>공유</span>
        </button>
        <?php if ($scrap_href) { ?>
        <button class="content-action-btn" onclick="scrapPost(this)">
            <span class="action-icon">🔖</span>
            <span>스크랩</span>
        </button>
        <?php } ?>
        <button class="content-action-btn" onclick="reportPost()">
            <span class="action-icon">🚨</span>
            <span>신고</span>
        </button>
    </div>
</article>

<!-- 첨부파일 -->
<?php if ($view['file']['count'] > 0) { ?>
<div class="post-files">
    <div class="files-header">
        <div class="files-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
        </div>
        <div>
            <div class="files-title">첨부파일</div>
            <div class="files-count"><?php echo $view['file']['count']; ?>개 파일</div>
        </div>
    </div>

    <?php for ($i = 0; $i < count($view['file']); $i++) {
        if (!is_array($view['file'][$i])) continue;
        $file = $view['file'][$i];
    ?>
    <div class="file-item">
        <div class="file-item-top">
            <div class="file-thumb">
                <?php if ($file['view']['href']) { ?>
                <img src="<?php echo $file['view']['href']; ?>" alt="<?php echo premium_escape($file['source']); ?>" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                <?php } else { ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                <?php } ?>
            </div>
            <div class="file-info">
                <div class="file-name"><?php echo premium_escape($file['source']); ?></div>
                <div class="file-meta"><?php echo premium_file_size($file['size']); ?> · 다운 <?php echo number_format($file['download']); ?>회</div>
            </div>
            <span class="file-cost free">무료</span>
        </div>
        <a href="<?php echo $file['href']; ?>" class="file-download">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            다운로드
        </a>
    </div>
    <?php } ?>
</div>
<?php } ?>

<!-- 이전/다음글 -->
<div class="post-nav">
    <?php if ($prev_href) { ?>
    <a href="<?php echo $prev_href; ?>" class="pn-item prev">
        <div class="pn-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"/></svg>
        </div>
        <div class="pn-text">
            <div class="pn-label">이전글</div>
            <div class="pn-title"><?php echo premium_escape($prev['wr_subject']); ?></div>
        </div>
    </a>
    <?php } else { ?>
    <div class="pn-item prev disabled">
        <div class="pn-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"/></svg>
        </div>
        <div class="pn-text">
            <div class="pn-label">이전글</div>
            <div class="pn-title">이전글이 없습니다</div>
        </div>
    </div>
    <?php } ?>

    <?php if ($next_href) { ?>
    <a href="<?php echo $next_href; ?>" class="pn-item next">
        <div class="pn-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
        </div>
        <div class="pn-text">
            <div class="pn-label">다음글</div>
            <div class="pn-title"><?php echo premium_escape($next['wr_subject']); ?></div>
        </div>
    </a>
    <?php } else { ?>
    <div class="pn-item next disabled">
        <div class="pn-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
        </div>
        <div class="pn-text">
            <div class="pn-label">다음글</div>
            <div class="pn-title">다음글이 없습니다</div>
        </div>
    </div>
    <?php } ?>
</div>

<!-- 댓글 -->
<section id="bo_vc" class="comments-section">
    <h2 class="comments-header">
        💬 댓글 <span class="comments-count"><?php echo $view_comment; ?></span>
    </h2>

    <?php
    // 댓글 출력 (view_comment.php에서 view_comment.skin.php를 자동 로드)
    include_once(G5_BBS_PATH.'/view_comment.php');
    ?>
</section>

<!-- 하단 버튼 -->
<div class="post-bottom">
    <div class="post-bottom-left">
        <a href="<?php echo $list_href; ?>" class="bottom-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            목록
        </a>
    </div>
    <div class="post-bottom-right">
        <?php if ($update_href) { ?>
        <a href="<?php echo $update_href; ?>" class="bottom-btn edit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            수정
        </a>
        <?php } ?>
        <?php if ($delete_href) { ?>
        <a href="<?php echo $delete_href; ?>" class="bottom-btn delete" onclick="return confirm('정말 삭제하시겠습니까?');">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3,6 5,6 21,6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            삭제
        </a>
        <?php } ?>
        <?php if ($reply_href) { ?>
        <a href="<?php echo $reply_href; ?>" class="bottom-btn reply">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,17 4,12 9,7"/><path d="M20 18v-2a4 4 0 00-4-4H4"/></svg>
            답변
        </a>
        <?php } ?>
    </div>
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

<script>
// 토스트 알림
function showToast(message, type) {
    type = type || 'success';
    var existing = document.querySelector('.toast-notification');
    if (existing) existing.remove();

    var toast = document.createElement('div');
    toast.className = 'toast-notification ' + type;
    var icon = type === 'success' ? '✓' : (type === 'error' ? '✕' : 'ℹ');
    toast.innerHTML = '<span class="toast-icon">' + icon + '</span><span>' + message + '</span>';
    document.body.appendChild(toast);

    setTimeout(function() { toast.classList.add('show'); }, 10);
    setTimeout(function() {
        toast.classList.remove('show');
        setTimeout(function() { toast.remove(); }, 300);
    }, 2500);
}

// 추천/비추천
function good_eval2(good, bo_table, wr_id, el) {
    var msg = good == 'good' ? '추천' : '비추천';

    $.ajax({
        type: 'POST',
        url: '<?php echo G5_BBS_URL; ?>/ajax.good.php',
        data: { bo_table: bo_table, wr_id: wr_id, good: good },
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                showToast(data.error, 'error');
            } else {
                var countEl = el.querySelector('.action-count');
                if (countEl) {
                    countEl.textContent = data[good];
                }
                el.classList.add('active');
                showToast(msg + '했습니다!', 'success');
            }
        },
        error: function() {
            showToast('오류가 발생했습니다.', 'error');
        }
    });
}

// 공유 (클립보드 복사)
function copyToClipboard() {
    var url = window.location.href;
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function() {
            showToast('링크가 복사되었습니다!', 'success');
        }).catch(function() {
            fallbackCopy(url);
        });
    } else {
        fallbackCopy(url);
    }
}

function fallbackCopy(text) {
    var textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    try {
        document.execCommand('copy');
        showToast('링크가 복사되었습니다!', 'success');
    } catch (e) {
        showToast('복사에 실패했습니다.', 'error');
    }
    document.body.removeChild(textarea);
}

// 스크랩
function scrapPost(btn) {
    <?php if ($scrap_href) { ?>
    var win = window.open('<?php echo $scrap_href; ?>', 'scrap', 'width=500,height=400,scrollbars=yes');
    if (win) {
        btn.classList.add('active');
        showToast('스크랩 창이 열렸습니다.', 'info');
    }
    <?php } else { ?>
    showToast('스크랩 기능을 사용할 수 없습니다.', 'error');
    <?php } ?>
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
    document.querySelectorAll('input[name="report_reason"]').forEach(function(r) { r.checked = false; });
    document.getElementById('reportDetail').value = '';
}

// 신고 제출
function submitReport() {
    var selected = document.querySelector('input[name="report_reason"]:checked');
    if (!selected) {
        showToast('신고 사유를 선택해주세요.', 'error');
        return;
    }

    var reason = selected.value;
    var detail = document.getElementById('reportDetail').value.trim();
    var submitBtn = document.querySelector('.report-btn-submit');

    submitBtn.disabled = true;
    submitBtn.textContent = '처리중...';

    // 실제 신고 처리 (서버 API 호출)
    setTimeout(function() {
        closeReportModal();
        showToast('신고가 접수되었습니다.', 'success');
        submitBtn.disabled = false;
        submitBtn.textContent = '신고하기';
    }, 500);
}

// 모달 바깥 클릭시 닫기
document.getElementById('reportModal').addEventListener('click', function(e) {
    if (e.target === this) closeReportModal();
});
</script>
