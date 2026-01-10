<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium 스킨 - 목록 (list.skin.php)
 */

// 공통 함수 로드
include_once(dirname(__FILE__).'/_inc.php');

// 게시판 설정값
$bo_subject = $board['bo_subject'];
$bo_table = $board['bo_table'];

// 기간별 베스트 게시글 조회 함수
function get_best_posts_by_period($write_table, $period = 'daily') {
    $date_condition = '';
    switch($period) {
        case 'daily':
            $date_condition = "AND wr_datetime >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
            break;
        case 'weekly':
            $date_condition = "AND wr_datetime >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            break;
        case 'monthly':
            $date_condition = "AND wr_datetime >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            break;
    }

    $sql = "SELECT * FROM {$write_table} WHERE wr_is_comment = 0 AND wr_good >= 1 {$date_condition} ORDER BY wr_good DESC, wr_id DESC LIMIT 10";
    $result = sql_query($sql);
    $posts = [];
    while ($row = sql_fetch_array($result)) {
        $posts[] = $row;
    }
    return $posts;
}

// 일간 베스트 (기본)
$best_daily = get_best_posts_by_period($write_table, 'daily');
// 주간 베스트
$best_weekly = get_best_posts_by_period($write_table, 'weekly');
// 월간 베스트
$best_monthly = get_best_posts_by_period($write_table, 'monthly');

// 모든 기간에 데이터가 있는지 확인
$has_best = (count($best_daily) > 0 || count($best_weekly) > 0 || count($best_monthly) > 0);
?>

<!-- 페이지 타이틀 -->
<div class="page-title-section">
    <div class="page-title">
        <div class="page-title-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        </div>
        <div>
            <h1><?php echo premium_escape($bo_subject); ?></h1>
            <?php if ($board['bo_content']) { ?>
            <p><?php echo strip_tags($board['bo_content']); ?></p>
            <?php } ?>
        </div>
    </div>
</div>

<?php if ($has_best) { ?>
<!-- 베스트 글 섹션 -->
<section class="best-section">
    <div class="best-tabs">
        <button class="best-tab active" data-period="daily">일간베스트</button>
        <button class="best-tab" data-period="weekly">주간베스트</button>
        <button class="best-tab" data-period="monthly">월간베스트</button>
    </div>

    <?php
    // 베스트 목록 렌더링 함수
    function render_best_list($posts, $bo_table, $g5, $period, $is_active = false) {
        $active_class = $is_active ? 'active' : '';
        $total = min(count($posts), 10);

        if ($total == 0) {
            echo "<div class=\"best-list\" data-period=\"{$period}\" style=\"".($is_active ? '' : 'display:none')."\">";
            echo "<div class=\"best-empty\">해당 기간의 베스트 글이 없습니다.</div>";
            echo "</div>";
            return;
        }

        $half = ceil($total / 2);
        $reordered = [];
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
            $likes = number_format($posts[$idx]['wr_good']);
            echo "<div class=\"best-item\" onclick=\"location.href='{$best_href}'\">";
            echo "<span class=\"rank-badge {$rank_class}\">{$rank}</span>";
            echo "<span class=\"best-item-title\">{$title}</span>";
            echo "<span class=\"best-item-likes\">{$likes}</span>";
            echo "</div>";
        }
        echo "</div>";
    }

    // 일간/주간/월간 베스트 렌더링
    render_best_list($best_daily, $bo_table, $g5, 'daily', true);
    render_best_list($best_weekly, $bo_table, $g5, 'weekly', false);
    render_best_list($best_monthly, $bo_table, $g5, 'monthly', false);
    ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bestTabs = document.querySelectorAll('.best-tab');
    const bestLists = document.querySelectorAll('.best-list');

    bestTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const period = this.dataset.period;

            // 탭 활성화
            bestTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // 리스트 전환
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
        <?php
        // 게시글 출력 (공지사항은 is_notice로 구분 - list.php에서 이미 공지가 먼저 정렬되어 있음)
        for ($i = 0; $i < count($list); $i++) {
            $is_notice = isset($list[$i]['is_notice']) && $list[$i]['is_notice'];
            $is_new = premium_is_new($list[$i]['datetime']);
            $is_hot = premium_is_hot($list[$i]['comment_cnt']);
            $has_image = premium_has_image($list[$i]);
            $thumb_url = (!$is_notice && $has_image) ? premium_get_thumbnail($bo_table, $list[$i]['wr_id'], 200, 150) : '';

            // 회원 정보 조회
            $mb = get_member($list[$i]['mb_id']);
            $mb_level = $mb['mb_level'] ?: 1;
            $level_class = ($mb_level > 5) ? 'lv-high' : 'lv-normal';
        ?>
        <div class="board-row<?php if ($is_notice) echo ' notice-row'; ?>" onclick="location.href='<?php echo $list[$i]['href']; ?>'"<?php if ($thumb_url) { ?> data-thumb="<?php echo $thumb_url; ?>" onmouseenter="showImagePreview(event, this)" onmouseleave="hideImagePreview()"<?php } ?>>
            <!-- 분류 -->
            <span>
                <?php if ($is_notice) { ?>
                <span class="category-badge notice">공지</span>
                <?php } else if ($list[$i]['category']) { ?>
                <span class="category-badge <?php echo premium_category_class($list[$i]['category']); ?>">
                    <?php echo premium_escape($list[$i]['category']); ?>
                </span>
                <?php } else { ?>
                <span class="category-badge">일반</span>
                <?php } ?>
            </span>

            <!-- 제목 -->
            <div class="post-title-cell">
                <a href="<?php echo $list[$i]['href']; ?>" class="post-title-text">
                    <?php if ($has_image) { ?>
                    <svg class="attach-icon image" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
                    <?php } ?>
                    <?php if (isset($list[$i]['icon_file']) && $list[$i]['icon_file'] && !$has_image) { ?>
                    <svg class="attach-icon file" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
                    <?php } ?>
                    <?php echo $list[$i]['subject']; ?>
                </a>
                <?php if ($list[$i]['comment_cnt']) { ?><span class="comment-count">[<?php echo $list[$i]['wr_comment']; ?>]</span><?php } ?>
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

            <!-- 조회수 -->
            <span class="post-views"><?php echo number_format($list[$i]['wr_hit']); ?></span>

            <!-- 추천수 -->
            <span class="post-likes"><span class="likes-heart">♥</span> <?php echo number_format($list[$i]['wr_good']); ?></span>
        </div>
        <?php } ?>

        <?php if (count($list) == 0) { ?>
        <div class="board-empty">
            <p>등록된 게시글이 없습니다.</p>
        </div>
        <?php } ?>
    </div>
</section>

<!-- 페이지네이션 -->
<div class="board-pagination">
    <?php echo $write_pages; ?>
</div>

<!-- 검색 -->
<div class="board-search-area">
    <form name="fsearch" method="get">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
        <input type="hidden" name="sca" value="<?php echo $sca; ?>">
        <input type="hidden" name="sop" value="and">

        <div class="search-form">
            <select name="sfl" class="search-select">
                <?php echo get_board_sfl_select_options($sfl); ?>
            </select>
            <input type="text" name="stx" value="<?php echo stripslashes($stx); ?>" class="search-input" placeholder="검색어 입력" required>
            <button type="submit" class="search-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <span>검색</span>
            </button>
        </div>
    </form>
</div>

<!-- FAB 버튼들 -->
<div class="fab-container">
    <button class="fab-btn search-fab" onclick="document.querySelector('.board-search-area').scrollIntoView({behavior:'smooth'})">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    </button>
    <?php if ($write_href) { ?>
    <a href="<?php echo $write_href; ?>" class="fab-btn write-fab">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
    </a>
    <?php } ?>
</div>

<!-- 이미지 미리보기 -->
<div id="imagePreviewTooltip" class="image-preview-tooltip"></div>
<script>
var previewEl = document.getElementById('imagePreviewTooltip');

function showImagePreview(e, el) {
    var thumb = el.getAttribute('data-thumb');
    if (!thumb) return;

    previewEl.innerHTML = '<img src="' + thumb + '" alt="미리보기">';
    previewEl.style.display = 'block';
    updatePreviewPosition(e);
}

function updatePreviewPosition(e) {
    if (!previewEl) return;
    var x = e.clientX + 15;
    var y = e.clientY + 15;

    var maxX = window.innerWidth - 220;
    var maxY = window.innerHeight - 160;

    previewEl.style.left = Math.min(x, maxX) + 'px';
    previewEl.style.top = Math.min(y, maxY) + 'px';
}

function hideImagePreview() {
    if (previewEl) {
        previewEl.style.display = 'none';
    }
}

document.addEventListener('mousemove', function(e) {
    if (previewEl && previewEl.style.display === 'block') {
        updatePreviewPosition(e);
    }
});
</script>
