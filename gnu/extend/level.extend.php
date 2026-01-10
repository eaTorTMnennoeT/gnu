<?php
/**
 * 레벨 시스템 확장
 * 캐시 + 포인트 합산으로 레벨 결정
 */

if (!defined('_GNUBOARD_')) exit;

// 레벨 설정 테이블 정의
$g5['level_table'] = G5_TABLE_PREFIX.'level';

/**
 * 레벨 테이블 자동 생성 및 기본 데이터 삽입
 */
function install_level_system() {
    global $g5;

    // 레벨 테이블 생성
    $sql = "CREATE TABLE IF NOT EXISTS `{$g5['level_table']}` (
        `lv_level` int(11) NOT NULL,
        `lv_name` varchar(50) NOT NULL DEFAULT '',
        `lv_point` int(11) NOT NULL DEFAULT '0',
        `lv_icon` varchar(255) NOT NULL DEFAULT '',
        `lv_color` varchar(20) NOT NULL DEFAULT '',
        PRIMARY KEY (`lv_level`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
    sql_query($sql);

    // 데이터가 없으면 기본 레벨 삽입
    $check = sql_fetch("SELECT COUNT(*) as cnt FROM {$g5['level_table']}");
    if ($check['cnt'] == 0) {
        // 1~30 레벨 기본 데이터
        $levels = array(
            array(1, '뉴비', 0, '', '#9ca3af'),
            array(2, '초보', 100, '', '#9ca3af'),
            array(3, '입문', 300, '', '#9ca3af'),
            array(4, '초급', 600, '', '#6b7280'),
            array(5, '하급', 1000, '', '#6b7280'),
            array(6, '중하급', 2000, '', '#6b7280'),
            array(7, '중급', 4000, '', '#3b82f6'),
            array(8, '중상급', 7000, '', '#3b82f6'),
            array(9, '상급', 12000, '', '#3b82f6'),
            array(10, '고급', 20000, '', '#8b5cf6'),
            array(11, '숙련', 35000, '', '#8b5cf6'),
            array(12, '전문가', 55000, '', '#8b5cf6'),
            array(13, '베테랑', 80000, '', '#f59e0b'),
            array(14, '엘리트', 120000, '', '#f59e0b'),
            array(15, '마스터', 180000, '', '#f59e0b'),
            array(16, '그랜드마스터', 260000, '', '#ef4444'),
            array(17, '챌린저', 360000, '', '#ef4444'),
            array(18, '레전드', 500000, '', '#ef4444'),
            array(19, '히어로', 700000, '', '#ec4899'),
            array(20, '슈퍼히어로', 1000000, '', '#ec4899'),
            array(21, '프리미엄', 1500000, '', '#d4af37'),
            array(22, 'VIP', 2200000, '', '#d4af37'),
            array(23, 'VVIP', 3200000, '', '#d4af37'),
            array(24, '다이아몬드', 4500000, '', '#06b6d4'),
            array(25, '로얄', 6500000, '', '#06b6d4'),
            array(26, '임페리얼', 9000000, '', '#7c3aed'),
            array(27, '갓', 13000000, '', '#7c3aed'),
            array(28, '신화', 18000000, '', '#dc2626'),
            array(29, '전설', 25000000, '', '#dc2626'),
            array(30, '불멸', 35000000, '', '#fbbf24')
        );

        foreach ($levels as $lv) {
            $sql = "INSERT INTO {$g5['level_table']} SET
                    lv_level = '{$lv[0]}',
                    lv_name = '{$lv[1]}',
                    lv_point = '{$lv[2]}',
                    lv_icon = '{$lv[3]}',
                    lv_color = '{$lv[4]}'";
            sql_query($sql);
        }
    }
}

// 설치 실행
install_level_system();

/**
 * 회원의 총 자산 (캐시 + 포인트) 조회
 */
function get_member_total_asset($mb_id) {
    global $g5;

    $mb = get_member($mb_id);
    if (!$mb['mb_id']) return 0;

    $point = isset($mb['mb_point']) ? (int)$mb['mb_point'] : 0;
    $cash = isset($mb['mb_cash']) ? (int)$mb['mb_cash'] : 0;

    return $point + $cash;
}

/**
 * 총 자산 기준 레벨 조회
 */
function get_level_by_asset($total_asset) {
    global $g5;

    $sql = "SELECT * FROM {$g5['level_table']} WHERE lv_point <= '{$total_asset}' ORDER BY lv_level DESC LIMIT 1";
    $row = sql_fetch($sql);

    if (!$row['lv_level']) {
        return array(
            'lv_level' => 1,
            'lv_name' => '뉴비',
            'lv_point' => 0,
            'lv_color' => '#9ca3af'
        );
    }

    return $row;
}

/**
 * 다음 레벨 정보 조회
 */
function get_next_level($current_level) {
    global $g5;

    $next_level = $current_level + 1;
    $sql = "SELECT * FROM {$g5['level_table']} WHERE lv_level = '{$next_level}'";
    $row = sql_fetch($sql);

    return $row ? $row : null;
}

/**
 * 회원의 레벨 정보 전체 조회
 */
function get_member_level_info($mb_id) {
    $total_asset = get_member_total_asset($mb_id);
    $current_level = get_level_by_asset($total_asset);
    $next_level = get_next_level($current_level['lv_level']);

    $result = array(
        'total_asset' => $total_asset,
        'level' => (int)$current_level['lv_level'],
        'level_name' => $current_level['lv_name'],
        'level_color' => $current_level['lv_color'],
        'current_point' => (int)$current_level['lv_point'],
        'next_level' => null,
        'next_level_name' => null,
        'next_point' => null,
        'progress' => 100,
        'remaining' => 0
    );

    if ($next_level) {
        $result['next_level'] = (int)$next_level['lv_level'];
        $result['next_level_name'] = $next_level['lv_name'];
        $result['next_point'] = (int)$next_level['lv_point'];

        // 진행률 계산
        $range = $result['next_point'] - $result['current_point'];
        $progress_amount = $total_asset - $result['current_point'];
        $result['progress'] = $range > 0 ? min(100, round(($progress_amount / $range) * 100)) : 100;
        $result['remaining'] = max(0, $result['next_point'] - $total_asset);
    }

    return $result;
}

/**
 * VIP 등급 체크 (레벨 22 이상)
 */
function is_vip_member($mb_id) {
    $level_info = get_member_level_info($mb_id);
    return $level_info['level'] >= 22;
}

/**
 * 레벨 목록 조회
 */
function get_level_list() {
    global $g5;

    $sql = "SELECT * FROM {$g5['level_table']} ORDER BY lv_level ASC";
    return sql_query($sql);
}

/**
 * 레벨 정보 업데이트
 */
function update_level($level, $name, $point, $color = '') {
    global $g5;

    $sql = "UPDATE {$g5['level_table']} SET
            lv_name = '".sql_real_escape_string($name)."',
            lv_point = '".intval($point)."',
            lv_color = '".sql_real_escape_string($color)."'
            WHERE lv_level = '".intval($level)."'";
    return sql_query($sql);
}
