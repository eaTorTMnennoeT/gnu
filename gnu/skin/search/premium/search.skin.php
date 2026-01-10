<?php
if (!defined("_GNUBOARD_")) exit;

// 프리미엄 CSS 로드
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/premium.css">', 0);

// 게시판 탭을 위해 모든 게시판의 검색 결과를 별도로 조회
$premium_board_tabs = array();
if ($stx) {
    $sql_boards = " SELECT bo_table, bo_subject, bo_mobile_subject FROM {$g5['board_table']} WHERE bo_use_search = 1 AND bo_list_level <= '{$member['mb_level']}' ";
    if ($gr_id) {
        $sql_boards .= " AND gr_id = '{$gr_id}' ";
    }
    $sql_boards .= " ORDER BY bo_order, gr_id, bo_table ";
    $result_boards = sql_query($sql_boards);

    while ($row_board = sql_fetch_array($result_boards)) {
        $tmp_table = $g5['write_prefix'] . $row_board['bo_table'];
        $sql_cnt = " SELECT COUNT(*) as cnt FROM {$tmp_table} WHERE {$sql_search} ";
        $row_cnt = sql_fetch($sql_cnt);

        if ($row_cnt['cnt'] > 0) {
            $premium_board_tabs[] = array(
                'bo_table' => $row_board['bo_table'],
                'bo_subject' => (G5_IS_MOBILE && $row_board['bo_mobile_subject']) ? $row_board['bo_mobile_subject'] : $row_board['bo_subject'],
                'cnt' => $row_cnt['cnt']
            );
        }
    }
}
?>

<!-- 전체검색 시작 { -->
<div class="search-page-container">
    <!-- 페이지 타이틀 -->
    <div class="page-title-section">
        <div class="page-title">
            <div class="page-title-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            </div>
            <div>
                <h1>통합 검색</h1>
                <p>전체 게시판에서 검색합니다</p>
            </div>
        </div>
    </div>

    <!-- 검색 폼 -->
    <div class="global-search-box">
        <form name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
            <input type="hidden" name="srows" value="<?php echo $srows ?>">

            <div class="search-form-row">
                <?php echo str_replace('<select', '<select class="search-select"', $group_select); ?>
                <script>document.getElementById("gr_id").value = "<?php echo $gr_id ?>";</script>

                <select name="sfl" id="sfl" class="search-select">
                    <option value="wr_subject||wr_content"<?php echo get_selected($sfl, "wr_subject||wr_content") ?>>제목+내용</option>
                    <option value="wr_subject"<?php echo get_selected($sfl, "wr_subject") ?>>제목</option>
                    <option value="wr_content"<?php echo get_selected($sfl, "wr_content") ?>>내용</option>
                    <option value="mb_id"<?php echo get_selected($sfl, "mb_id") ?>>회원아이디</option>
                    <option value="wr_name"<?php echo get_selected($sfl, "wr_name") ?>>이름</option>
                </select>
            </div>

            <div class="search-form-main">
                <input type="text" name="stx" value="<?php echo $text_stx ?>" id="stx" required class="search-input-main" placeholder="검색어를 입력하세요">
                <button type="submit" class="search-btn-main">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <span>검색</span>
                </button>
            </div>

            <div class="search-options">
                <label class="search-radio">
                    <input type="radio" value="and" <?php echo ($sop == "and") ? "checked" : ""; ?> id="sop_and" name="sop">
                    <span class="radio-mark"></span>
                    <span>AND (모두 포함)</span>
                </label>
                <label class="search-radio">
                    <input type="radio" value="or" <?php echo ($sop == "or") ? "checked" : ""; ?> id="sop_or" name="sop">
                    <span class="radio-mark"></span>
                    <span>OR (하나 이상)</span>
                </label>
            </div>
        </form>
    </div>

    <script>
    function fsearch_submit(f) {
        var stx = f.stx.value.trim();
        if (stx.length < 2) {
            alert("검색어는 두글자 이상 입력하십시오.");
            f.stx.select();
            f.stx.focus();
            return false;
        }

        var cnt = 0;
        for (var i = 0; i < stx.length; i++) {
            if (stx.charAt(i) == ' ') cnt++;
        }

        if (cnt > 1) {
            alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
            f.stx.select();
            f.stx.focus();
            return false;
        }
        f.stx.value = stx;
        f.action = "";
        return true;
    }
    </script>

    <!-- 검색 결과 -->
    <div class="search-results">
        <?php if ($stx) { ?>
            <?php if ($board_count) { ?>
            <!-- 검색 요약 -->
            <div class="search-summary">
                <div class="search-summary-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
                    <span>"<strong><?php echo htmlspecialchars($stx); ?></strong>" 검색 결과</span>
                </div>
                <div class="search-summary-stats">
                    <span class="stat-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        게시판 <strong><?php echo $board_count ?></strong>개
                    </span>
                    <span class="stat-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        게시물 <strong><?php echo number_format($total_count) ?></strong>개
                    </span>
                    <span class="stat-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <strong><?php echo number_format($page) ?></strong>/<strong><?php echo number_format($total_page) ?></strong> 페이지
                    </span>
                </div>
            </div>

            <!-- 게시판 필터 탭 -->
            <div class="search-board-tabs">
                <a href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>" class="board-tab <?php echo !$onetable ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    전체
                </a>
                <?php foreach ($premium_board_tabs as $tab) { ?>
                <a href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>&amp;onetable=<?php echo $tab['bo_table'] ?>" class="board-tab <?php echo ($onetable == $tab['bo_table']) ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($tab['bo_subject']); ?>
                    <span class="tab-count"><?php echo number_format($tab['cnt']); ?></span>
                </a>
                <?php } ?>
            </div>

            <?php } else { ?>
            <!-- 검색 결과 없음 -->
            <div class="search-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><line x1="8" y1="8" x2="14" y2="14"/><line x1="14" y1="8" x2="8" y2="14"/></svg>
                <h3>"<?php echo htmlspecialchars($stx); ?>" 검색 결과가 없습니다</h3>
                <p>다른 검색어로 다시 시도해 보세요</p>
            </div>
            <?php } ?>
        <?php } ?>

        <?php if ($stx && $board_count) { ?>
        <!-- 검색 결과 목록 -->
        <div class="search-result-list">
            <?php
            $k = 0;
            for ($idx = $table_index, $k = 0; $idx < count($search_table) && $k < $rows; $idx++) {
            ?>
            <div class="search-board-section">
                <div class="search-board-header">
                    <a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>" class="board-name">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        <?php echo $bo_subject[$idx] ?>
                    </a>
                    <a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>" class="more-link">
                        더보기
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                    </a>
                </div>

                <div class="search-items">
                    <?php
                    for ($i = 0; $i < count($list[$idx]) && $k < $rows; $i++, $k++) {
                        if ($list[$idx][$i]['wr_is_comment']) {
                            $comment_def = '<span class="comment-badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>댓글</span>';
                            $comment_href = '#c_' . $list[$idx][$i]['wr_id'];
                        } else {
                            $comment_def = '';
                            $comment_href = '';
                        }
                    ?>
                    <div class="search-item" onclick="location.href='<?php echo $list[$idx][$i]['href'] . $comment_href; ?>'">
                        <div class="search-item-title">
                            <?php echo $comment_def; ?>
                            <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>"><?php echo $list[$idx][$i]['subject'] ?></a>
                            <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" target="_blank" class="new-window-btn" onclick="event.stopPropagation();">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </a>
                        </div>
                        <p class="search-item-content"><?php echo $list[$idx][$i]['content'] ?></p>
                        <div class="search-item-meta">
                            <span class="meta-author">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <?php echo $list[$idx][$i]['name'] ?>
                            </span>
                            <span class="meta-date">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                                <?php echo $list[$idx][$i]['wr_datetime'] ?>
                            </span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>

        <!-- 페이지네이션 -->
        <div class="board-pagination">
            <?php echo $write_pages ?>
        </div>
        <?php } ?>
    </div>
</div>
<!-- } 전체검색 끝 -->
