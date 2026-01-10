<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium PDS 스킨 - 상세보기 (view.skin.php)
 * 자료실 게시판용
 */

// 공통 함수 로드
include_once(dirname(__FILE__).'/_inc.php');

// 게시판 설정값
$bo_subject = $board['bo_subject'];
$bo_table = $board['bo_table'];

// 첨부파일 정보
$file = get_file($bo_table, $wr_id);
$total_file_size = pds_get_total_file_size($bo_table, $wr_id);
$first_file = pds_get_first_file($bo_table, $wr_id);
$file_icon_class = $first_file ? pds_file_icon_class($first_file['source']) : 'zip';

// 회원 정보
$mb = get_member($view['mb_id']);
$mb_level = $mb['mb_level'] ?: 1;

// 카테고리 클래스
$category_class = pds_category_class($view['ca_name']);
?>

<!-- 게시글 헤더 -->
<header class="pds-post-header">
    <div class="pds-post-title-row">
        <?php if ($view['ca_name']) { ?>
        <span class="pds-post-category <?php echo $category_class; ?>"><?php echo pds_escape($view['ca_name']); ?></span>
        <?php } ?>
        <h1 class="pds-post-title"><?php echo $view['subject']; ?></h1>
    </div>
    <div class="pds-post-meta">
        <div class="pds-post-meta-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span><?php echo $view['name']; ?></span>
        </div>
        <div class="pds-post-meta-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
            <span><?php echo $view['datetime']; ?></span>
        </div>
        <div class="pds-post-meta-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            <span>조회 <?php echo number_format($view['wr_hit']); ?></span>
        </div>
        <?php if ($first_file) { ?>
        <div class="pds-post-meta-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            <span>다운로드 <?php echo number_format($first_file['download']); ?></span>
        </div>
        <?php } ?>
    </div>
</header>

<!-- 다운로드 정보 박스 -->
<?php if ($file['count'] > 0) { ?>
<section class="pds-download-info-box">
    <div class="pds-download-info-grid">
        <div class="pds-download-info-item">
            <span class="pds-download-info-label">다운포인트</span>
            <span class="pds-download-info-value">무료</span>
        </div>
        <div class="pds-download-info-item">
            <span class="pds-download-info-label">파일개수</span>
            <span class="pds-download-info-value"><?php echo number_format($file['count']); ?>개</span>
        </div>
        <div class="pds-download-info-item">
            <span class="pds-download-info-label">파일용량</span>
            <span class="pds-download-info-value"><?php echo pds_file_size($total_file_size); ?></span>
        </div>
    </div>

    <!-- 첨부파일 목록 -->
    <div class="pds-file-list">
        <?php
        $file_num = 0;
        for ($i = 0; $i <= $file['count']; $i++) {
            if (!$file[$i]) continue;
            $file_num++;
            $icon_class = pds_file_icon_class($file[$i]['source']);
            $icon_svg = pds_file_icon_svg($icon_class);
        ?>
        <div class="pds-file-item">
            <span class="pds-file-num"><?php echo $file_num; ?></span>
            <span class="pds-file-icon"><?php echo $icon_svg; ?></span>
            <div class="pds-file-info">
                <a href="<?php echo $file[$i]['href']; ?>" class="pds-file-name"><?php echo $file[$i]['source']; ?></a>
                <span class="pds-file-size"><?php echo pds_file_size($file[$i]['size']); ?></span>
            </div>
            <span class="pds-file-download-count"><?php echo number_format($file[$i]['download']); ?>회</span>
            <a href="<?php echo $file[$i]['href']; ?>" class="pds-file-download-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            </a>
        </div>
        <?php } ?>
    </div>
</section>
<?php } ?>

<!-- 게시글 본문 -->
<article class="pds-post-content">
    <div class="pds-post-body">
        <?php echo $view['content']; ?>
    </div>

    <!-- 본문 내 액션 버튼 -->
    <div class="pds-post-content-actions">
        <?php if ($good_href) { ?>
        <button type="button" class="pds-content-action-btn" onclick="document.getElementById('good_form').submit();">
            <span class="action-icon">👍</span>
            <span>추천</span>
            <span class="action-count"><?php echo number_format($view['wr_good']); ?></span>
        </button>
        <form id="good_form" action="<?php echo $good_href; ?>" method="post" style="display:none;">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
            <input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
        </form>
        <?php } ?>

        <?php if ($nogood_href) { ?>
        <button type="button" class="pds-content-action-btn" onclick="document.getElementById('nogood_form').submit();">
            <span class="action-icon">👎</span>
            <span>비추천</span>
            <span class="action-count"><?php echo number_format($view['wr_nogood']); ?></span>
        </button>
        <form id="nogood_form" action="<?php echo $nogood_href; ?>" method="post" style="display:none;">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
            <input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
        </form>
        <?php } ?>

        <button type="button" class="pds-content-action-btn" onclick="copyUrl();">
            <span class="action-icon">🔗</span>
            <span>공유</span>
        </button>

        <?php if ($scrap_href) { ?>
        <a href="<?php echo $scrap_href; ?>" class="pds-content-action-btn" target="_blank" onclick="win_scrap(this.href); return false;">
            <span class="action-icon">🔖</span>
            <span>스크랩</span>
        </a>
        <?php } ?>
    </div>
</article>

<!-- 이전/다음글 -->
<?php if ($prev_href || $next_href) { ?>
<nav class="pds-post-nav">
    <?php if ($prev_href) { ?>
    <a href="<?php echo $prev_href; ?>" class="pds-pn-item prev">
        <div class="pds-pn-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"/></svg>
        </div>
        <div class="pds-pn-text">
            <div class="pds-pn-label">이전글</div>
            <div class="pds-pn-title"><?php echo $prev_wr_subject; ?></div>
        </div>
    </a>
    <?php } else { ?>
    <div class="pds-pn-item prev disabled">
        <div class="pds-pn-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"/></svg>
        </div>
        <div class="pds-pn-text">
            <div class="pds-pn-label">이전글</div>
            <div class="pds-pn-title">이전글이 없습니다</div>
        </div>
    </div>
    <?php } ?>

    <?php if ($next_href) { ?>
    <a href="<?php echo $next_href; ?>" class="pds-pn-item next">
        <div class="pds-pn-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
        </div>
        <div class="pds-pn-text">
            <div class="pds-pn-label">다음글</div>
            <div class="pds-pn-title"><?php echo $next_wr_subject; ?></div>
        </div>
    </a>
    <?php } else { ?>
    <div class="pds-pn-item next disabled">
        <div class="pds-pn-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
        </div>
        <div class="pds-pn-text">
            <div class="pds-pn-label">다음글</div>
            <div class="pds-pn-title">다음글이 없습니다</div>
        </div>
    </div>
    <?php } ?>
</nav>
<?php } ?>

<!-- 하단 버튼 -->
<div class="pds-post-bottom">
    <a href="<?php echo $list_href; ?>" class="pds-bottom-btn btn-list">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        목록
    </a>
    <div class="pds-bottom-btns-right">
        <?php if ($update_href) { ?>
        <a href="<?php echo $update_href; ?>" class="pds-bottom-btn btn-edit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            수정
        </a>
        <?php } ?>
        <?php if ($delete_href) { ?>
        <a href="<?php echo $delete_href; ?>" onclick="del(this.href); return false;" class="pds-bottom-btn btn-delete">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3,6 5,6 21,6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
            삭제
        </a>
        <?php } ?>
        <?php if ($write_href) { ?>
        <a href="<?php echo $write_href; ?>" class="pds-bottom-btn btn-write">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            자료 올리기
        </a>
        <?php } ?>
    </div>
</div>

<!-- 댓글 섹션 -->
<section id="bo_vc" class="pds-comments-section">
    <h2 class="pds-comments-header">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        댓글 <span class="pds-comments-count"><?php echo number_format($view['wr_comment']); ?></span>
    </h2>
    <?php
    // 댓글 출력
    include_once(G5_BBS_PATH.'/view_comment.php');
    ?>
</section>

<script>
// URL 복사
function copyUrl() {
    var url = window.location.href;
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(function() {
            alert('링크가 복사되었습니다.');
        });
    } else {
        var input = document.createElement('input');
        input.value = url;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        alert('링크가 복사되었습니다.');
    }
}
</script>
