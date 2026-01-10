<?php
$sub_menu = "800200";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

// 레벨 테이블 정의
if (!isset($g5['level_table'])) {
    $g5['level_table'] = G5_TABLE_PREFIX.'level';
}

$count = isset($_POST['lv_level']) ? count($_POST['lv_level']) : 0;

for ($i = 0; $i < $count; $i++) {
    $lv_level = (int)$_POST['lv_level'][$i];
    $lv_name = isset($_POST['lv_name'][$i]) ? strip_tags($_POST['lv_name'][$i]) : '';
    $lv_point = isset($_POST['lv_point'][$i]) ? (int)preg_replace('/[^0-9]/', '', $_POST['lv_point'][$i]) : 0;
    $lv_color = isset($_POST['lv_color'][$i]) ? strip_tags($_POST['lv_color'][$i]) : '';

    $sql = "UPDATE {$g5['level_table']} SET
            lv_name = '".sql_real_escape_string($lv_name)."',
            lv_point = '{$lv_point}',
            lv_color = '".sql_real_escape_string($lv_color)."'
            WHERE lv_level = '{$lv_level}'";
    sql_query($sql);
}

goto_url('./level_list.php');
