<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium PDS 스킨 - 목록 (list.skin.php)
 * 자료실 게시판용
 */

// 공통 함수 로드
include_once(dirname(__FILE__).'/_inc.php');

// 게시판 설정값
$bo_subject = $board['bo_subject'];
$bo_table = $board['bo_table'];

// 기간별 베스트 게시글 조회
$best_daily = pds_get_best_posts($write_table, 'daily');
$best_weekly = pds_get_best_posts($write_table, 'weekly');
$best_monthly = pds_get_best_posts($write_table, 'monthly');

// 모든 기간에 데이터가 있는지 확인
$has_best = (count($best_daily) > 0 || count($best_weekly) > 0 || count($best_monthly) > 0);
?>

<!-- 페이지 타이틀 -->
<div class="page-title-section pds-page">
    <div class="page-title">
        <div class="page-title-icon pds-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        </div>
        <div>
            <h1><?php echo pds_escape($bo_subject); ?></h1>
            <?php if ($board['bo_content']) { ?>
            <p><?php echo strip_tags($board['bo_content']); ?></p>
            <?php } ?>
        </div>
    </div>
</div>

<?php if ($has_best) { ?>
<!-- 베스트 자료 섹션 -->
<section class="best-section pds-best">
    <div class="best-tabs">
        <button class="best-tab active" data-period="daily">일간베스트</button>
        <button class="best-tab" data-period="weekly">주간베스트</button>
        <button class="best-tab" data-period="monthly">월간베스트</button>
    </div>

    <?php
    // 베스트 목록 렌더링 함수
    function render_pds_best_list($posts, $bo_table, $g5, $period, $is_active = false) {
        $active_class = $is_active ? 'active' : '';
        $total = min(count($posts), 10);

        if ($total == 0) {
            echo "<div class=\"best-list\" data-period=\"{$period}\" style=\"".($is_active ? '' : 'display:none')."\">";
            echo "<div class=\"best-empty\">해당 기간의 베스트 자료가 없습니다.</div>";
            echo "</div>";
            return;
        }

        $half = ceil($total / 2);
        $reordered = array();
        for ($i = 0; $i < $half; $i++) {
            $reordered[] = $i;
            if ($i + $half < $total) {
                $reordered[] = $i + $half;
            }
        }

        echo "<div class=\"best-list {$active_class}\" data-period=\"{$period}\" style=\"".($is_active ? '' : 'display:none')."\">";
        foreach ($reordered as $idx) {
            $rank = $idx + 1;
            $rank_class = ($rank <= 3) ? "rank-{$rank}" : 'rank-other';
            $best_href = "{$g5['bbs_url']}/board.php?bo_table={$bo_table}&wr_id={$posts[$idx]['wr_id']}";
            $title = strip_tags($posts[$idx]['wr_subject']);
            $downloads = number_format($posts[$idx]['wr_good']);
            echo "<div class=\"best-item\" onclick=\"location.href='{$best_href}'\">";
            echo "<span class=\"rank-badge {$rank_class}\">{$rank}</span>";
            echo "<span class=\"best-item-title\">{$title}</span>";
            echo "<span class=\"best-item-downloads\">{$downloads}</span>";
            echo "</div>";
        }
        echo "</div>";
    }

    // 일간/주간/월간 베스트 렌더링
    render_pds_best_list($best_daily, $bo_table, $g5, 'daily', true);
    render_pds_best_list($best_weekly, $bo_table, $g5, 'weekly', false);
    render_pds_best_list($best_monthly, $bo_table, $g5, 'monthly', false);
    ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bestTabs = document.querySelectorAll('.pds-best .best-tab');
    const bestLists = document.querySelectorAll('.pds-best .best-list');

    bestTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const period = this.dataset.period;

            bestTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            bestLists.forEach(list => {
                if (list.dataset.period === period) {
                    list.style.display = '';
                    list.classList.add('active');
                } else {
                    list.style.display = 'none';
                    list.classList.remove('active');
                }
            });
        });
    });
});
</script>
<?php } ?>

<!-- 자료 목록 -->
<section class="board-section pds-board">
    <div class="board-table-header pds-header">
        <span>분류</span>
        <span>제목</span>
        <span>작성자</span>
        <span>날짜</span>
        <span style="text-align:center">다운C/P</span>
        <span style="text-align:center">추천</span>
    </div>

    <div id="boardList">
        <?php
        // 모든 게시글 출력 (공지사항은 is_notice로 구분)
        for ($i = 0; $i < count($list); $i++) {
            $is_notice = $list[$i]['is_notice'];
            $is_new = pds_is_new($list[$i]['datetime']);
            $is_hot = pds_is_hot($list[$i]['comment_cnt']);
            $has_image = pds_has_image($list[$i]);

            // 회원 정보 조회
            $mb = get_member($list[$i]['mb_id']);
            $mb_level = $mb['mb_level'] ?: 1;
            $level_class = ($mb_level > 5) ? 'lv-high' : 'lv-normal';

            // 첨부파일 정보
            $first_file = pds_get_first_file($bo_table, $list[$i]['wr_id']);
            $file_size = pds_get_total_file_size($bo_table, $list[$i]['wr_id']);
            $file_icon_class = $first_file ? pds_file_icon_class($first_file['source']) : 'zip';
            $file_icon_svg = pds_file_icon_svg($file_icon_class);

            // 카테고리 클래스
            $category_class = pds_category_class($list[$i]['ca_name']);
        ?>
        <div class="board-row pds-row<?php if ($is_notice) echo ' notice-row'; ?>" onclick="location.href='<?php echo $list[$i]['href']; ?>'">
            <!-- 분류 -->
            <span>
                <?php if ($is_notice) { ?>
                <span class="category-badge notice">공지</span>
                <?php } elseif ($list[$i]['ca_name']) { ?>
                <span class="category-badge <?php echo $category_class; ?>">
                    <?php echo pds_escape($list[$i]['ca_name']); ?>
                </span>
                <?php } else { ?>
                <span class="category-badge">일반</span>
                <?php } ?>
            </span>

            <!-- 제목 -->
            <div class="post-title-cell">
                <a href="<?php echo $list[$i]['href']; ?>" class="post-title-text">
                    <?php echo $file_icon_svg; ?>
                    <?php echo $list[$i]['subject']; ?>
                </a>
                <?php if ($has_image) { ?>
                <span class="image-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg></span>
                <?php } ?>
                <?php if ($file_size > 0) { ?>
                <span class="file-size"><?php echo pds_file_size($file_size); ?></span>
                <?php } ?>
                <?php if ($list[$i]['comment_cnt'] > 0) { ?>
                <span class="comment-count">[<?php echo $list[$i]['comment_cnt']; ?>]</span>
                <?php } ?>
                <?php if ($is_new) { ?><span class="new-badge">N</span><?php } ?>
                <?php if ($is_hot) { ?><span class="hot-badge">HOT</span><?php } ?>
            </div>

            <!-- 작성자 -->
            <span class="post-author">
                <span class="author-level-wrap <?php echo $level_class; ?>">
                    <span class="author-level-num"><?php echo $mb_level; ?></span>
                    <span class="author-level-badge"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg></span>
                </span>
                <?php echo $list[$i]['name']; ?>
            </span>

            <!-- 날짜 -->
            <span class="post-date"><?php echo $list[$i]['datetime2']; ?></span>

            <!-- 다운로드 비용 -->
            <span class="post-download-cost free">무료</span>

            <!-- 추천수 -->
            <span class="post-likes"><span class="likes-heart">♥</span> <?php echo number_format($list[$i]['wr_good']); ?></span>
        </div>
        <?php } ?>

        <?php if (count($list) == 0) { ?>
        <div class="board-empty">
            <p>등록된 자료가 없습니다.</p>
        </div>
        <?php } ?>
    </div>
</section>

<!-- 페이지네이션 -->
<div class="board-pagination">
    <?php echo $write_pages; ?>
</div>

<!-- 검색 -->
<div class="board-search-area pds-search">
    <form name="fsearch" method="get">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
        <input type="hidden" name="sca" value="<?php echo $sca; ?>">
        <input type="hidden" name="sop" value="and">

        <div class="search-form">
            <select name="sfl" class="search-select">
                <?php echo get_board_sfl_select_options($sfl); ?>
            </select>
            <input type="text" name="stx" value="<?php echo stripslashes($stx); ?>" class="search-input" placeholder="검색어 입력" required>
            <button type="submit" class="search-btn pds-search-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <span>검색</span>
            </button>
        </div>
    </form>
</div>

<!-- FAB 버튼들 -->
<div class="fab-container">
    <button class="fab-btn search-fab pds-fab" onclick="document.querySelector('.board-search-area').scrollIntoView({behavior:'smooth'})">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    </button>
    <?php if ($write_href) { ?>
    <a href="<?php echo $write_href; ?>" class="fab-btn write-fab pds-write-fab">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
    </a>
    <?php } ?>
</div>
