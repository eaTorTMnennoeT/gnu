<?php
$sub_menu = '800100';
require_once './_common.php';

check_demo();

auth_check_menu($auth, $sub_menu, 'd');

check_admin_token();

// 캐시 테이블 정의
if (!isset($g5['cash_table'])) {
    $g5['cash_table'] = G5_TABLE_PREFIX.'cash';
}

$count = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
if (!$count) {
    alert($_POST['act_button'] . ' 하실 항목을 하나 이상 체크하세요.');
}

for ($i = 0; $i < $count; $i++) {
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];
    $ca_id = (int) $_POST['ca_id'][$k];
    $str_mb_id = sql_real_escape_string($_POST['mb_id'][$k]);

    // 캐시 내역정보
    $sql = " select * from {$g5['cash_table']} where ca_id = '{$ca_id}' ";
    $row = sql_fetch($sql);

    if (!$row['ca_id']) {
        continue;
    }

    // 캐시 내역삭제
    $sql = " delete from {$g5['cash_table']} where ca_id = '{$ca_id}' ";
    sql_query($sql);

    // ca_mb_cash에 반영
    $diff = $row['ca_use_cash'] - $row['ca_cash'];
    $sql = " update {$g5['cash_table']}
                set ca_mb_cash = ca_mb_cash + '{$diff}'
                where mb_id = '{$str_mb_id}'
                  and ca_id > '{$ca_id}' ";
    sql_query($sql);

    // 캐시 합계 재계산
    $sql = " select SUM(ca_cash) - SUM(ca_use_cash) as total from {$g5['cash_table']} where mb_id = '{$str_mb_id}' ";
    $sum_row = sql_fetch($sql);
    $sum_cash = $sum_row['total'] ? (int)$sum_row['total'] : 0;
    if ($sum_cash < 0) $sum_cash = 0;

    $sql = " update {$g5['member_table']} set mb_cash = '$sum_cash' where mb_id = '{$str_mb_id}' ";
    sql_query($sql);
}

goto_url('./cash_list.php?' . $qstr);
