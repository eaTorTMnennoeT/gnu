<?php
/**
 * 추가기능 메뉴
 * 커스텀 확장 기능들을 여기에 등록
 */
$menu['menu800'] = array(
    array('800000', '추가기능', G5_ADMIN_URL . '/cash_list.php', 'extend'),
    array('800100', '캐시관리', G5_ADMIN_URL . '/cash_list.php', 'ext_cash'),
    array('800200', '레벨설정', G5_ADMIN_URL . '/level_list.php', 'ext_level'),
    array('800300', '게임통계', G5_ADMIN_URL . '/game_stats.php', 'ext_game_stats', 1),
    array('800310', '배팅리스트', G5_ADMIN_URL . '/game_logs.php', 'ext_game_logs', 1),
);
