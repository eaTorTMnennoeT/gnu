<?php
$sub_menu = "800100";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

// 캐시 테이블 정의
if (!isset($g5['cash_table'])) {
    $g5['cash_table'] = G5_TABLE_PREFIX.'cash';
}

$mb_id = isset($_POST['mb_id']) ? strip_tags(clean_xss_attributes($_POST['mb_id'])) : '';
$ca_cash = isset($_POST['ca_cash']) ? (int)strip_tags(clean_xss_attributes($_POST['ca_cash'])) : 0;
$ca_content = isset($_POST['ca_content']) ? strip_tags(clean_xss_attributes($_POST['ca_content'])) : '';
$expire = isset($_POST['ca_expire_term']) ? preg_replace('/[^0-9]/', '', $_POST['ca_expire_term']) : '';

$mb = get_member($mb_id);

if (!$mb['mb_id']) {
    alert('존재하는 회원아이디가 아닙니다.', './cash_list.php?' . $qstr);
}

$mb_cash = isset($mb['mb_cash']) ? (int)$mb['mb_cash'] : 0;

if (($ca_cash < 0) && (abs($ca_cash) > $mb_cash)) {
    alert('캐시를 깎는 경우 현재 캐시보다 작으면 안됩니다.\\n현재 캐시: ' . number_format($mb_cash) . '원', './cash_list.php?' . $qstr);
}

// insert_cash 함수 사용
if (function_exists('insert_cash')) {
    $expire_days = $expire ? (int)$expire : 0;
    insert_cash($mb_id, $ca_cash, $ca_content, '@passive', $mb_id, $member['mb_id'] . '-' . uniqid(''), $expire_days);
} else {
    // 함수가 없으면 직접 처리
    $sum_cash = $mb_cash + $ca_cash;
    if ($sum_cash < 0) $sum_cash = 0;

    $ca_use_cash = 0;
    $ca_cash_insert = $ca_cash;
    if ($ca_cash < 0) {
        $ca_use_cash = abs($ca_cash);
        $ca_cash_insert = 0;
    }

    $ca_expire_date = '0000-00-00';
    if ($expire && (int)$expire > 0) {
        $ca_expire_date = date('Y-m-d', strtotime("+{$expire} days"));
    }

    $sql = "INSERT INTO {$g5['cash_table']}
            SET mb_id = '$mb_id',
                ca_datetime = '".G5_TIME_YMDHIS."',
                ca_content = '".sql_real_escape_string($ca_content)."',
                ca_cash = '$ca_cash_insert',
                ca_use_cash = '$ca_use_cash',
                ca_expired = '0',
                ca_expire_date = '$ca_expire_date',
                ca_mb_cash = '$sum_cash',
                ca_rel_table = '@passive',
                ca_rel_id = '$mb_id',
                ca_rel_action = '{$member['mb_id']}-".uniqid('')."'";
    sql_query($sql);

    sql_query("UPDATE {$g5['member_table']} SET mb_cash = '$sum_cash' WHERE mb_id = '$mb_id'");
}

goto_url('./cash_list.php?' . $qstr);
