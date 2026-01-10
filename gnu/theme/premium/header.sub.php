<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * 헤더 서브 (검색바, 우측 메뉴)
 * pb/includes/header.php 기반
 */

// 회원 정보 준비
$mb_point = $is_member ? number_format($member['mb_point']) : '0';
$mb_cash = $is_member && isset($member['mb_cash']) ? number_format($member['mb_cash']) : '0';
$mb_memo_cnt = $is_member && isset($member['mb_memo_cnt']) ? (int)$member['mb_memo_cnt'] : 0;

// 레벨 정보 (extend/level.extend.php 사용)
$level_info = array('level' => 1, 'level_name' => '뉴비', 'progress' => 0, 'remaining' => 0, 'total_asset' => 0, 'next_point' => 100);
$is_vip = false;
if ($is_member && function_exists('get_member_level_info')) {
    $level_info = get_member_level_info($member['mb_id']);
    $is_vip = $level_info['level'] >= 22; // VIP는 레벨 22 이상
}
$mb_level = $level_info['level'];
$mb_level_name = $level_info['level_name'];
$mb_progress = $level_info['progress'];
$mb_remaining = number_format($level_info['remaining']);
$mb_total_asset = number_format($level_info['total_asset']);
$mb_next_point = $level_info['next_point'] ? number_format($level_info['next_point']) : '-';
?>
<!-- 헤더 -->
<header class="header">
    <div class="header-left">
        <button class="menu-toggle" id="menuToggle"><span></span><span></span><span></span></button>
        <div class="search-box">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL; ?>/search.php" style="display:contents;">
                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                <input type="hidden" name="sop" value="and">
                <input type="text" name="stx" placeholder="검색어를 입력하세요..." value="<?php echo isset($stx) ? htmlspecialchars($stx) : ''; ?>">
            </form>
        </div>
    </div>
    <div class="header-right">
        <div class="theme-toggle-wrap">
            <button class="theme-toggle" id="themeToggle">
                <span class="theme-label light">라이트</span>
                <span class="theme-label dark">다크</span>
                <span class="theme-slider"></span>
            </button>
        </div>
        <?php if($is_member) { ?>
        <div class="user-stats">
            <div class="stat-item" id="cashStatItem">
                <svg class="stat-item-icon cash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                <span class="stat-item-value"><?php echo $mb_cash; ?></span>
                <span class="stat-item-label">캐시</span>
            </div>
            <div class="stat-item" id="pointStatItem">
                <svg class="stat-item-icon point" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                <span class="stat-item-value"><?php echo $mb_point; ?></span>
                <span class="stat-item-label">포인트</span>
            </div>
        </div>
        <div class="notification-wrapper">
            <button class="header-btn" id="notificationBtn" type="button">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                <?php if($mb_memo_cnt > 0) { ?>
                <span class="notification-dot"></span>
                <?php } ?>
            </button>
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="noti-header">
                    <span class="noti-title">알림</span>
                    <button class="noti-read-all" onclick="markAllRead()">모두 읽음</button>
                </div>
                <div class="noti-list">
                    <?php
                    $memo_count = 0;
                    if(isset($member['mb_id']) && $member['mb_id']) {
                        $memo_sql = "SELECT * FROM {$g5['memo_table']} WHERE me_recv_mb_id = '{$member['mb_id']}' AND me_read_datetime = '0000-00-00 00:00:00' ORDER BY me_id DESC LIMIT 5";
                        $memo_result = sql_query($memo_sql);
                        while($memo = sql_fetch_array($memo_result)) {
                            $memo_count++;
                    ?>
                    <div class="noti-item unread" onclick="goToNoti(<?php echo $memo['me_id']; ?>)">
                        <div class="noti-icon comment">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div class="noti-content">
                            <p class="noti-text"><strong><?php echo $memo['me_send_mb_id']; ?></strong>님이 쪽지를 보냈습니다.</p>
                            <span class="noti-time"><?php echo substr($memo['me_send_datetime'], 0, 10); ?></span>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    if($memo_count == 0) {
                    ?>
                    <div class="noti-item">
                        <div class="noti-content">
                            <p class="noti-text">새로운 알림이 없습니다.</p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <a href="<?php echo G5_BBS_URL; ?>/memo.php" class="noti-more">전체 알림 보기</a>
            </div>
        </div>
        <div class="profile-wrapper">
            <div class="user-profile-header" id="profileBtn">
                <div class="user-level">
                    <span class="user-level-number"><?php echo $mb_level; ?></span>
                    <div class="user-level-badge"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg></div>
                </div>
                <div class="user-info-header">
                    <span class="user-nickname"><?php echo $member['mb_nick']; ?></span>
                    <span class="user-level-text">Lv.<?php echo $mb_level; ?> <span class="level-name-badge"><?php echo $mb_level_name; ?></span></span>
                </div>
                <svg class="user-dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6,9 12,15 18,9"/></svg>
            </div>

            <!-- 프로필 드롭다운 -->
            <div class="profile-dropdown" id="profileDropdown">
                <div class="profile-dd-header">
                    <div class="profile-dd-avatar">
                        <div class="profile-dd-level"><?php echo $mb_level; ?></div>
                        <div class="profile-dd-level-badge"><svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg></div>
                    </div>
                    <div class="profile-dd-info">
                        <span class="profile-dd-name"><?php echo $member['mb_nick']; ?> <span class="level-name-badge"><?php echo $mb_level_name; ?></span></span>
                        <span class="profile-dd-email"><?php echo $member['mb_email']; ?></span>
                    </div>
                </div>

                <!-- 레벨 진행 섹션 -->
                <div class="profile-dd-level-section">
                    <div class="level-progress-header">
                        <span class="level-current">Lv.<?php echo $mb_level; ?></span>
                        <span class="level-next">Lv.<?php echo $mb_level + 1; ?>까지</span>
                    </div>
                    <div class="level-progress-bar">
                        <div class="level-progress-fill" style="width: <?php echo $mb_progress; ?>%"></div>
                    </div>
                    <div class="level-progress-info">
                        <span class="level-progress-text"><?php echo $mb_total_asset; ?> / <?php echo $mb_next_point; ?></span>
                        <span class="level-progress-percent"><?php echo $mb_progress; ?>%</span>
                    </div>
                    <div class="level-need-info">
                        <div class="level-need-item cash">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            <span>캐시: <strong><?php echo $mb_cash; ?></strong></span>
                        </div>
                        <span class="level-need-plus">+</span>
                        <div class="level-need-item point">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                            <span>포인트: <strong><?php echo $mb_point; ?></strong></span>
                        </div>
                    </div>
                    <div class="level-remaining">
                        <span>레벨업까지 <strong class="accent"><?php echo $mb_remaining; ?></strong> 필요</span>
                    </div>
                </div>

                <!-- 메뉴 -->
                <div class="profile-dd-menu">
                    <a href="#" class="profile-dd-menu-item" data-modal="myinfo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>내 정보</span>
                    </a>
                    <a href="#" class="profile-dd-menu-item" data-modal="myposts">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                        <span>내가 쓴 글</span>
                    </a>
                    <a href="#" class="profile-dd-menu-item" data-modal="scrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                        <span>스크랩</span>
                    </a>
                    <a href="#" class="profile-dd-menu-item" data-modal="message">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span>쪽지함</span>
                        <?php if($mb_memo_cnt > 0) { ?>
                        <span class="menu-badge"><?php echo $mb_memo_cnt; ?></span>
                        <?php } ?>
                    </a>
                    <?php if($is_admin) { ?>
                    <a href="<?php echo G5_ADMIN_URL; ?>" class="profile-dd-menu-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                        <span>관리자</span>
                    </a>
                    <?php } ?>
                </div>

                <div class="profile-dd-footer">
                    <a href="<?php echo G5_BBS_URL; ?>/logout.php" class="profile-dd-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        <span>로그아웃</span>
                    </a>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <!-- 비회원 -->
        <a href="<?php echo G5_BBS_URL; ?>/login.php" class="header-login-btn">로그인</a>
        <a href="<?php echo G5_BBS_URL; ?>/register.php" class="header-register-btn">회원가입</a>
        <?php } ?>
    </div>
</header>
<div class="dropdown-overlay" id="dropdownOverlay"></div>

<!-- 모바일 바텀시트 -->
<div class="mobile-bottomsheet" id="mobileBottomsheet">
    <div class="bottomsheet-handle"></div>
    <div class="bottomsheet-content" id="bottomsheetContent"></div>
</div>
