<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<!-- 메인 페이지 컨텐츠 -->
<div class="main-page">
    <div class="welcome-section" style="padding: 40px; text-align: center; background: var(--bg-card); border-radius: 16px; margin-bottom: 24px; border: 1px solid var(--border);">
        <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 12px;">환영합니다</h2>
        <p style="color: var(--text-secondary);">프리미엄 테마가 적용된 그누보드입니다.</p>
    </div>
</div>

<?php
include_once(G5_THEME_PATH.'/tail.php');
