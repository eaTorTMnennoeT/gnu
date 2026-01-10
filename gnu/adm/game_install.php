<?php
/**
 * 게임 로그 테이블 설치
 */
$sub_menu = "800300";
include_once('./_common.php');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

// 테이블 생성
$sql = "CREATE TABLE IF NOT EXISTS `{$g5['write_prefix']}game_log` (
    `gl_id` int(11) NOT NULL AUTO_INCREMENT,
    `mb_id` varchar(20) NOT NULL DEFAULT '',
    `mb_nick` varchar(40) NOT NULL DEFAULT '',
    `gl_game` varchar(20) NOT NULL DEFAULT '',
    `gl_bet_type` varchar(20) NOT NULL DEFAULT '',
    `gl_bet_amount` int(11) NOT NULL DEFAULT 0,
    `gl_result` varchar(20) NOT NULL DEFAULT '',
    `gl_win_amount` int(11) NOT NULL DEFAULT 0,
    `gl_profit` int(11) NOT NULL DEFAULT 0,
    `gl_detail` text,
    `gl_datetime` datetime NOT NULL,
    PRIMARY KEY (`gl_id`),
    KEY `idx_mb_id` (`mb_id`),
    KEY `idx_gl_game` (`gl_game`),
    KEY `idx_gl_datetime` (`gl_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

sql_query($sql);

// 경마 베팅 테이블 생성
$sql2 = "CREATE TABLE IF NOT EXISTS `{$g5['write_prefix']}game_racing_bet` (
    `rb_id` int(11) NOT NULL AUTO_INCREMENT,
    `mb_id` varchar(20) NOT NULL DEFAULT '',
    `mb_nick` varchar(40) NOT NULL DEFAULT '',
    `rb_round` int(11) NOT NULL DEFAULT 0,
    `rb_horse_id` int(11) NOT NULL DEFAULT 0,
    `rb_horse_name` varchar(50) NOT NULL DEFAULT '',
    `rb_amount` int(11) NOT NULL DEFAULT 0,
    `rb_odds` decimal(5,2) NOT NULL DEFAULT 0,
    `rb_status` enum('pending','win','lose') NOT NULL DEFAULT 'pending',
    `rb_win_amount` int(11) NOT NULL DEFAULT 0,
    `rb_datetime` datetime NOT NULL,
    PRIMARY KEY (`rb_id`),
    KEY `idx_mb_id` (`mb_id`),
    KEY `idx_rb_round` (`rb_round`),
    KEY `idx_rb_status` (`rb_status`),
    KEY `idx_rb_datetime` (`rb_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

sql_query($sql2);

// 사다리 베팅 테이블 생성
$sql3 = "CREATE TABLE IF NOT EXISTS `{$g5['write_prefix']}game_ladder_bet` (
    `lb_id` int(11) NOT NULL AUTO_INCREMENT,
    `mb_id` varchar(20) NOT NULL DEFAULT '',
    `mb_nick` varchar(40) NOT NULL DEFAULT '',
    `lb_round` int(11) NOT NULL DEFAULT 0,
    `lb_bet_type` varchar(20) NOT NULL DEFAULT '',
    `lb_bet_value` varchar(20) NOT NULL DEFAULT '',
    `lb_amount` int(11) NOT NULL DEFAULT 0,
    `lb_odds` decimal(5,2) NOT NULL DEFAULT 0,
    `lb_status` enum('pending','win','lose') NOT NULL DEFAULT 'pending',
    `lb_win_amount` int(11) NOT NULL DEFAULT 0,
    `lb_datetime` datetime NOT NULL,
    PRIMARY KEY (`lb_id`),
    KEY `idx_mb_id` (`mb_id`),
    KEY `idx_lb_round` (`lb_round`),
    KEY `idx_lb_status` (`lb_status`),
    KEY `idx_lb_datetime` (`lb_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

sql_query($sql3);

alert('게임 테이블이 생성되었습니다.', G5_ADMIN_URL.'/game_stats.php');
