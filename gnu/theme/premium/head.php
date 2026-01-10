<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}

// head.sub.php include (add_javascript 등 그누보드 표준 방식 사용)
include_once(G5_THEME_PATH.'/head.sub.php');
?>

<?php
// 사이드바
include_once(G5_THEME_PATH.'/sidebar.php');
?>

<!-- 메인 래퍼 -->
<div class="main-wrapper">
    <?php
    // 헤더
    include_once(G5_THEME_PATH.'/header.sub.php');
    ?>

    <!-- 메인 컨텐츠 시작 -->
    <main class="main-content">
