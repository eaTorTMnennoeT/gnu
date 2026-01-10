<?php
/**
 * 캐시 시스템 확장
 * 포인트 로직을 참고하여 캐시 시스템 구현
 *
 * 설치 방법: 이 파일을 extend 폴더에 넣으면 자동 로드됨
 */

if (!defined('_GNUBOARD_')) exit;

// 캐시 테이블 정의
$g5['cash_table'] = G5_TABLE_PREFIX.'cash';

/**
 * 캐시 테이블 및 컬럼 자동 생성
 */
function install_cash_system() {
    global $g5;

    // 1. 회원 테이블에 mb_cash 컬럼 추가
    $sql = "SHOW COLUMNS FROM {$g5['member_table']} LIKE 'mb_cash'";
    $result = sql_query($sql);
    if (!sql_num_rows($result)) {
        sql_query("ALTER TABLE {$g5['member_table']} ADD `mb_cash` int(11) NOT NULL DEFAULT '0' AFTER `mb_point`");
    }

    // 2. 캐시 테이블 생성
    $sql = "CREATE TABLE IF NOT EXISTS `{$g5['cash_table']}` (
        `ca_id` int(11) NOT NULL AUTO_INCREMENT,
        `mb_id` varchar(20) NOT NULL DEFAULT '',
        `ca_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        `ca_content` varchar(255) NOT NULL DEFAULT '',
        `ca_cash` int(11) NOT NULL DEFAULT '0',
        `ca_use_cash` int(11) NOT NULL DEFAULT '0',
        `ca_expired` tinyint(4) NOT NULL DEFAULT '0',
        `ca_expire_date` date NOT NULL DEFAULT '0000-00-00',
        `ca_mb_cash` int(11) NOT NULL DEFAULT '0',
        `ca_rel_table` varchar(20) NOT NULL DEFAULT '',
        `ca_rel_id` varchar(20) NOT NULL DEFAULT '',
        `ca_rel_action` varchar(100) NOT NULL DEFAULT '',
        PRIMARY KEY (`ca_id`),
        KEY `index1` (`mb_id`, `ca_rel_table`, `ca_rel_id`, `ca_rel_action`),
        KEY `index2` (`mb_id`, `ca_expired`, `ca_expire_date`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
    sql_query($sql);
}

// 설치 실행 (테이블/컬럼이 없으면 자동 생성)
install_cash_system();

/**
 * 캐시 부여/차감
 *
 * @param string $mb_id 회원 아이디
 * @param int $cash 캐시 (양수: 부여, 음수: 차감)
 * @param string $content 내용
 * @param string $rel_table 관련 테이블
 * @param string $rel_id 관련 ID
 * @param string $rel_action 관련 액션
 * @param int $expire 만료일 (0: 무제한, 양수: 일수)
 * @return bool
 */
function insert_cash($mb_id, $cash, $content='', $rel_table='', $rel_id='', $rel_action='', $expire=0) {
    global $g5, $config;

    if (!$mb_id || $cash == 0) return false;

    // 이미 지급/차감된 내역이 있는지 확인
    if ($rel_table || $rel_id || $rel_action) {
        $sql = "SELECT ca_id FROM {$g5['cash_table']}
                WHERE mb_id = '$mb_id'
                AND ca_rel_table = '$rel_table'
                AND ca_rel_id = '$rel_id'
                AND ca_rel_action = '$rel_action'";
        $row = sql_fetch($sql);
        if ($row['ca_id']) return false;
    }

    // 현재 캐시
    $mb = get_member($mb_id);
    if (!$mb['mb_id']) return false;

    $mb_cash = (int)$mb['mb_cash'];
    $ca_cash = (int)$cash;
    $ca_use_cash = 0;

    // 차감인 경우
    if ($ca_cash < 0) {
        $ca_use_cash = abs($ca_cash);
        $ca_cash = 0;
    }

    // 캐시 부여 후 합계
    $sum_cash = $mb_cash + $cash;
    if ($sum_cash < 0) $sum_cash = 0;

    // 만료일 설정
    $ca_expire_date = '0000-00-00';
    if ($expire > 0) {
        $ca_expire_date = date('Y-m-d', strtotime("+{$expire} days"));
    }

    // 캐시 내역 추가
    $sql = "INSERT INTO {$g5['cash_table']}
            SET mb_id = '$mb_id',
                ca_datetime = '".G5_TIME_YMDHIS."',
                ca_content = '".sql_real_escape_string($content)."',
                ca_cash = '$ca_cash',
                ca_use_cash = '$ca_use_cash',
                ca_expired = '0',
                ca_expire_date = '$ca_expire_date',
                ca_mb_cash = '$sum_cash',
                ca_rel_table = '$rel_table',
                ca_rel_id = '$rel_id',
                ca_rel_action = '$rel_action'";
    sql_query($sql);

    // 회원 캐시 업데이트
    $sql = "UPDATE {$g5['member_table']} SET mb_cash = '$sum_cash' WHERE mb_id = '$mb_id'";
    sql_query($sql);

    return true;
}

/**
 * 캐시 삭제 (관련 내역 기준)
 */
function delete_cash($mb_id, $rel_table, $rel_id, $rel_action) {
    global $g5;

    if (!$mb_id) return false;

    $sql = "SELECT ca_id, ca_cash, ca_use_cash FROM {$g5['cash_table']}
            WHERE mb_id = '$mb_id'
            AND ca_rel_table = '$rel_table'
            AND ca_rel_id = '$rel_id'
            AND ca_rel_action = '$rel_action'";
    $row = sql_fetch($sql);

    if (!$row['ca_id']) return false;

    // 부여된 캐시 회수 또는 차감된 캐시 복원
    $diff = $row['ca_use_cash'] - $row['ca_cash'];

    // 현재 캐시
    $mb = get_member($mb_id);
    $mb_cash = (int)$mb['mb_cash'];
    $sum_cash = $mb_cash + $diff;
    if ($sum_cash < 0) $sum_cash = 0;

    // 캐시 내역 삭제
    sql_query("DELETE FROM {$g5['cash_table']} WHERE ca_id = '{$row['ca_id']}'");

    // 회원 캐시 업데이트
    sql_query("UPDATE {$g5['member_table']} SET mb_cash = '$sum_cash' WHERE mb_id = '$mb_id'");

    return true;
}

/**
 * 회원 캐시 조회
 */
function get_cash($mb_id) {
    global $g5;

    $sql = "SELECT mb_cash FROM {$g5['member_table']} WHERE mb_id = '$mb_id'";
    $row = sql_fetch($sql);

    return isset($row['mb_cash']) ? (int)$row['mb_cash'] : 0;
}

/**
 * 캐시 내역 조회
 */
function get_cash_list($mb_id, $page=1, $limit=20) {
    global $g5;

    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM {$g5['cash_table']}
            WHERE mb_id = '$mb_id'
            ORDER BY ca_id DESC
            LIMIT $offset, $limit";

    return sql_query($sql);
}

/**
 * 캐시 내역 총 개수
 */
function get_cash_count($mb_id) {
    global $g5;

    $sql = "SELECT COUNT(*) as cnt FROM {$g5['cash_table']} WHERE mb_id = '$mb_id'";
    $row = sql_fetch($sql);

    return (int)$row['cnt'];
}

/**
 * 캐시 합계 재계산
 */
function recalculate_cash($mb_id) {
    global $g5;

    $sql = "SELECT SUM(ca_cash) - SUM(ca_use_cash) as total FROM {$g5['cash_table']} WHERE mb_id = '$mb_id'";
    $row = sql_fetch($sql);

    $total = $row['total'] ? (int)$row['total'] : 0;
    if ($total < 0) $total = 0;

    sql_query("UPDATE {$g5['member_table']} SET mb_cash = '$total' WHERE mb_id = '$mb_id'");

    return $total;
}
