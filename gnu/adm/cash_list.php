<?php
$sub_menu = "800100";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'r');

// 캐시 테이블 정의
if (!isset($g5['cash_table'])) {
    $g5['cash_table'] = G5_TABLE_PREFIX.'cash';
}

$sql_common = " from {$g5['cash_table']} ca";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_id':
            $sql_search .= " (ca.{$sfl} = '{$stx}') ";
            break;
        default:
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "ca_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);
if ($page < 1) {
    $page = 1;
}
$from_record = ($page - 1) * $rows;

$sql = " select ca.*, mb.mb_name, mb.mb_nick, mb.mb_email, mb.mb_homepage, mb.mb_cash
            {$sql_common}
            LEFT JOIN {$g5['member_table']} mb ON ca.mb_id = mb.mb_id
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';

$mb = array();
if ($sfl == 'mb_id' && $stx) {
    $mb = get_member($stx);
}

$g5['title'] = '캐시관리';
require_once './admin.head.php';

$colspan = 9;

if (strstr($sfl, "mb_id")) {
    $mb_id = $stx;
} else {
    $mb_id = "";
}
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">전체 </span><span class="ov_num"> <?php echo number_format($total_count) ?> 건 </span></span>
    <?php
    if (isset($mb['mb_id']) && $mb['mb_id']) {
        $mb_cash = isset($mb['mb_cash']) ? $mb['mb_cash'] : 0;
        echo '&nbsp;<span class="btn_ov01"><span class="ov_txt">' . $mb['mb_id'] . ' 님 캐시 합계 </span><span class="ov_num"> ' . number_format($mb_cash) . '원</span></span>';
    } else {
        $row2 = sql_fetch(" select sum(ca_cash) as sum_cash from {$g5['cash_table']} ");
        echo '&nbsp;<span class="btn_ov01"><span class="ov_txt">전체 합계</span><span class="ov_num">' . number_format($row2['sum_cash']) . '원 </span></span>';
    }
    ?>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="mb_id" <?php echo get_selected($sfl, "mb_id"); ?>>회원아이디</option>
        <option value="ca_content" <?php echo get_selected($sfl, "ca_content"); ?>>내용</option>
    </select>
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
    <input type="submit" class="btn_submit" value="검색">
</form>

<form name="fcashlist" id="fcashlist" method="post" action="./cash_list_delete.php" onsubmit="return fcashlist_submit(this);">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">

    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th scope="col">
                        <label for="chkall" class="sound_only">캐시 내역 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col"><?php echo subject_sort_link('mb_id') ?>회원아이디</a></th>
                    <th scope="col">이름</th>
                    <th scope="col">닉네임</th>
                    <th scope="col"><?php echo subject_sort_link('ca_content') ?>캐시 내용</a></th>
                    <th scope="col"><?php echo subject_sort_link('ca_cash') ?>캐시</a></th>
                    <th scope="col"><?php echo subject_sort_link('ca_datetime') ?>일시</a></th>
                    <th scope="col">만료일</th>
                    <th scope="col">캐시합</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $mb_nick = get_sideview($row['mb_id'], $row['mb_nick'], $row['mb_email'], $row['mb_homepage']);

                    $link1 = $link2 = '';
                    if (!preg_match("/^\@/", $row['ca_rel_table']) && $row['ca_rel_table']) {
                        $link1 = '<a href="' . get_pretty_url($row['ca_rel_table'], $row['ca_rel_id']) . '" target="_blank">';
                        $link2 = '</a>';
                    }

                    $expr = '';
                    if ($row['ca_expired'] == 1) {
                        $expr = ' txt_expired';
                    }

                    $bg = 'bg' . ($i % 2);
                ?>

                    <tr class="<?php echo $bg; ?>">
                        <td class="td_chk">
                            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
                            <input type="hidden" name="ca_id[<?php echo $i ?>]" value="<?php echo $row['ca_id'] ?>" id="ca_id_<?php echo $i ?>">
                            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $row['ca_content'] ?> 내역</label>
                            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
                        </td>
                        <td class="td_left"><a href="?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo $row['mb_id'] ?></a></td>
                        <td class="td_left"><?php echo get_text($row['mb_name']); ?></td>
                        <td class="td_left sv_use">
                            <div><?php echo $mb_nick ?></div>
                        </td>
                        <td class="td_left"><?php echo $link1 ?><?php echo $row['ca_content'] ?><?php echo $link2 ?></td>
                        <td class="td_num td_pt"><?php echo number_format($row['ca_cash'] - $row['ca_use_cash']) ?></td>
                        <td class="td_datetime"><?php echo $row['ca_datetime'] ?></td>
                        <td class="td_datetime2<?php echo $expr; ?>">
                            <?php if ($row['ca_expired'] == 1) { ?>
                                만료<?php echo substr(str_replace('-', '', $row['ca_expire_date']), 2); ?>
                            <?php } else {
                                echo $row['ca_expire_date'] == '0000-00-00' ? '무제한' : $row['ca_expire_date'];
                            } ?>
                        </td>
                        <td class="td_num td_pt"><?php echo number_format($row['ca_mb_cash']) ?></td>
                    </tr>

                <?php
                }

                if ($i == 0) {
                    echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
    </div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<section id="cash_mng">
    <h2 class="h2_frm">개별회원 캐시 증감 설정</h2>

    <form name="fcashlist2" method="post" id="fcashlist2" action="./cash_update.php" autocomplete="off">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="token" value="<?php echo isset($token) ? $token : ''; ?>">

        <div class="tbl_frm01 tbl_wrap">
            <table>
                <colgroup>
                    <col class="grid_4">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row"><label for="mb_id">회원아이디<strong class="sound_only">필수</strong></label></th>
                        <td><input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" class="required frm_input" required></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ca_content">캐시 내용<strong class="sound_only">필수</strong></label></th>
                        <td><input type="text" name="ca_content" id="ca_content" required class="required frm_input" size="80"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ca_cash">캐시<strong class="sound_only">필수</strong></label></th>
                        <td><input type="text" name="ca_cash" id="ca_cash" required class="required frm_input"> 원 (마이너스 입력시 차감)</td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ca_expire_term">캐시 유효기간</label></th>
                        <td><input type="text" name="ca_expire_term" value="" id="ca_expire_term" class="frm_input" size="5"> 일 (비워두면 무제한)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="btn_confirm01 btn_confirm">
            <input type="submit" value="확인" class="btn_submit btn">
        </div>

    </form>

</section>

<script>
    function fcashlist_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        if (document.pressed == "선택삭제") {
            if (!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
                return false;
            }
        }

        return true;
    }
</script>

<?php
require_once './admin.tail.php';
