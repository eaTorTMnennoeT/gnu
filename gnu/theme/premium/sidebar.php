<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * 사이드바
 */

// 현재 페이지 확인
$current_bo_table = isset($bo_table) ? $bo_table : '';

// 게시판 그룹 및 목록 가져오기
$sql = "SELECT * FROM {$g5['group_table']} ORDER BY gr_order, gr_id";
$groups = sql_query($sql);

// 게시판 목록 가져오기 (사이드바에 표시할 게시판)
$sql = "SELECT * FROM {$g5['board_table']} ORDER BY bo_order, bo_table";
$boards = sql_query($sql);

$board_list = [];
while($_sb_board = sql_fetch_array($boards)) {
    $board_list[$_sb_board['gr_id']][] = $_sb_board;
}
?>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- 사이드바 -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="<?php echo G5_URL; ?>" class="logo">
            <div class="logo-icon">G</div>
            <div class="logo-text">Gnu<span>Board</span></div>
        </a>
    </div>

    <nav class="nav-section">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="<?php echo G5_URL; ?>" class="nav-link<?php echo (G5_URL == $_SERVER['REQUEST_URI'] || $_SERVER['REQUEST_URI'] == '/') ? ' active' : ''; ?>">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
                    <span class="nav-text">홈</span>
                </a>
            </li>
            <?php while($group = sql_fetch_array($groups)) { ?>
            <?php if(isset($board_list[$group['gr_id']]) && count($board_list[$group['gr_id']]) > 0) { ?>
            <?php
            // 그룹 내 현재 게시판 있는지 확인
            $is_group_active = false;
            $group_new_cnt = 0;
            foreach($board_list[$group['gr_id']] as $_sb_board) {
                if($current_bo_table == $_sb_board['bo_table']) {
                    $is_group_active = true;
                }
                // 그룹 전체 새글 수
                $new_sql = "SELECT COUNT(*) as cnt FROM {$g5['board_new_table']} WHERE bo_table = '{$_sb_board['bo_table']}' AND bn_datetime > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
                $new_row = sql_fetch($new_sql);
                $group_new_cnt += $new_row['cnt'];
            }
            ?>
            <li class="nav-item<?php echo $is_group_active ? ' open' : ''; ?>">
                <a href="#" class="nav-link has-sub">
                    <?php if($group['gr_icon']) { ?>
                    <span class="nav-icon"><?php echo $group['gr_icon']; ?></span>
                    <?php } else { ?>
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/></svg>
                    <?php } ?>
                    <span class="nav-text"><?php echo $group['gr_subject']; ?></span>
                    <?php if($group['gr_id'] == 'pds') { ?>
                    <span class="nav-badge gold">HOT</span>
                    <?php } elseif($group_new_cnt > 0) { ?>
                    <span class="nav-badge"><?php echo $group_new_cnt; ?></span>
                    <?php } ?>
                    <svg class="nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                </a>
                <ul class="sub-menu">
                    <?php foreach($board_list[$group['gr_id']] as $_sb_board) { ?>
                    <?php
                    // 개별 게시판 새글 수
                    $board_new_sql = "SELECT COUNT(*) as cnt FROM {$g5['board_new_table']} WHERE bo_table = '{$_sb_board['bo_table']}' AND bn_datetime > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
                    $board_new_row = sql_fetch($board_new_sql);
                    $board_new_cnt = $board_new_row['cnt'];
                    ?>
                    <li class="nav-item">
                        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $_sb_board['bo_table']; ?>" class="nav-link<?php echo ($current_bo_table == $_sb_board['bo_table']) ? ' active' : ''; ?>">
                            <?php if($_sb_board['bo_icon']) { ?>
                            <span class="nav-icon"><?php echo $_sb_board['bo_icon']; ?></span>
                            <?php } ?>
                            <span class="nav-text"><?php echo $_sb_board['bo_subject']; ?></span>
                            <?php if($board_new_cnt > 0) { ?>
                            <span class="nav-badge"><?php echo $board_new_cnt; ?></span>
                            <?php } ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php } ?>
        </ul>

        <div class="nav-label">회원</div>
        <ul class="nav-menu">
            <?php if($is_member) { ?>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link" onclick="openSidebarModal('message')">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span class="nav-text">쪽지함</span>
                    <?php if($member['mb_memo_cnt'] > 0) { ?>
                    <span class="nav-badge"><?php echo $member['mb_memo_cnt']; ?></span>
                    <?php } ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link" onclick="openSidebarModal('point')">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                    <span class="nav-text">포인트</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link" onclick="openSidebarModal('scrap')">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                    <span class="nav-text">스크랩</span>
                </a>
            </li>
            <?php } else { ?>
            <li class="nav-item">
                <a href="<?php echo G5_BBS_URL; ?>/login.php" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10,17 15,12 10,7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    <span class="nav-text">로그인</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo G5_BBS_URL; ?>/register.php" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    <span class="nav-text">회원가입</span>
                </a>
            </li>
            <?php } ?>
        </ul>

        <?php if($is_admin) { ?>
        <div class="nav-label">관리</div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="<?php echo G5_ADMIN_URL; ?>" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                    <span class="nav-text">관리자</span>
                </a>
            </li>
        </ul>
        <?php } ?>

        <div class="nav-label">게임</div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="<?php echo G5_URL; ?>/game/" class="nav-link">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"/><line x1="6" y1="12" x2="10" y2="12"/><line x1="8" y1="10" x2="8" y2="14"/><circle cx="17" cy="10" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/></svg>
                    <span class="nav-text">게임센터</span>
                    <span class="nav-badge gold">NEW</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <?php if($is_member) { ?>
        <a href="<?php echo G5_BBS_URL; ?>/logout.php" class="sidebar-footer-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            로그아웃
        </a>
        <?php } else { ?>
        <a href="<?php echo G5_BBS_URL; ?>/login.php" class="sidebar-footer-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10,17 15,12 10,7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            로그인
        </a>
        <?php } ?>
    </div>
</aside>

<!-- 사이드바 모달 오버레이 -->
<div class="sidebar-modal-overlay" id="sidebarModalOverlay" onclick="closeSidebarModal()"></div>

<!-- 쪽지함 모달 -->
<?php if($is_member) { ?>
<div class="sidebar-modal sidebar-modal-lg" id="sidebarMessageModal">
    <div class="sidebar-modal-header">
        <div class="sidebar-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            쪽지함
        </div>
        <button class="sidebar-modal-close" onclick="closeSidebarModal()">✕</button>
    </div>
    <div class="sidebar-modal-body">
        <div class="sidebar-modal-tabs">
            <a href="<?php echo G5_BBS_URL; ?>/memo.php" class="sidebar-modal-tab active">받은 쪽지</a>
            <a href="<?php echo G5_BBS_URL; ?>/memo.php?kind=send" class="sidebar-modal-tab">보낸 쪽지</a>
        </div>
        <div class="sidebar-modal-content">
            <p class="sidebar-modal-info">쪽지함 페이지로 이동합니다.</p>
        </div>
    </div>
    <div class="sidebar-modal-footer">
        <button class="sidebar-modal-btn secondary" onclick="closeSidebarModal()">닫기</button>
        <a href="<?php echo G5_BBS_URL; ?>/memo.php" class="sidebar-modal-btn primary">쪽지함 가기</a>
    </div>
</div>

<!-- 포인트 모달 -->
<div class="sidebar-modal" id="sidebarPointModal">
    <div class="sidebar-modal-header">
        <div class="sidebar-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
            내 포인트
        </div>
        <button class="sidebar-modal-close" onclick="closeSidebarModal()">✕</button>
    </div>
    <div class="sidebar-modal-body">
        <div class="point-summary">
            <div class="point-current">
                <span class="point-label">보유 포인트</span>
                <span class="point-value"><?php echo number_format($member['mb_point']); ?> P</span>
            </div>
        </div>
        <div class="sidebar-modal-content">
            <p class="sidebar-modal-info">포인트 내역 페이지로 이동합니다.</p>
        </div>
    </div>
    <div class="sidebar-modal-footer">
        <button class="sidebar-modal-btn secondary" onclick="closeSidebarModal()">닫기</button>
        <a href="<?php echo G5_BBS_URL; ?>/point.php" class="sidebar-modal-btn primary">포인트 내역</a>
    </div>
</div>

<!-- 스크랩 모달 -->
<div class="sidebar-modal" id="sidebarScrapModal">
    <div class="sidebar-modal-header">
        <div class="sidebar-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
            스크랩
        </div>
        <button class="sidebar-modal-close" onclick="closeSidebarModal()">✕</button>
    </div>
    <div class="sidebar-modal-body">
        <div class="sidebar-modal-content">
            <p class="sidebar-modal-info">스크랩 목록 페이지로 이동합니다.</p>
        </div>
    </div>
    <div class="sidebar-modal-footer">
        <button class="sidebar-modal-btn secondary" onclick="closeSidebarModal()">닫기</button>
        <a href="<?php echo G5_BBS_URL; ?>/scrap.php" class="sidebar-modal-btn primary">스크랩 보기</a>
    </div>
</div>
<?php } ?>

<!-- 게임센터 모달 -->
<div class="sidebar-modal sidebar-modal-lg" id="sidebarGameModal">
    <div class="sidebar-modal-header">
        <div class="sidebar-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"/><line x1="6" y1="12" x2="10" y2="12"/><line x1="8" y1="10" x2="8" y2="14"/><circle cx="17" cy="10" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/></svg>
            게임센터
        </div>
        <button class="sidebar-modal-close" onclick="closeSidebarModal()">✕</button>
    </div>
    <div class="sidebar-modal-body">
        <div class="game-list">
            <div class="game-item" onclick="alert('준비 중입니다!')">
                <div class="game-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">🎰</div>
                <div class="game-info">
                    <div class="game-name">룰렛</div>
                    <div class="game-desc">행운의 룰렛을 돌려보세요!</div>
                </div>
                <span class="game-badge">인기</span>
            </div>
            <div class="game-item" onclick="alert('준비 중입니다!')">
                <div class="game-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">🎲</div>
                <div class="game-info">
                    <div class="game-name">주사위</div>
                    <div class="game-desc">숫자를 맞춰 포인트 획득!</div>
                </div>
            </div>
            <div class="game-item" onclick="alert('준비 중입니다!')">
                <div class="game-icon" style="background: linear-gradient(135deg, #6366f1, #818cf8);">🃏</div>
                <div class="game-info">
                    <div class="game-name">카드 뒤집기</div>
                    <div class="game-desc">같은 카드를 찾아보세요!</div>
                </div>
            </div>
            <div class="game-item" onclick="alert('준비 중입니다!')">
                <div class="game-icon" style="background: linear-gradient(135deg, #ec4899, #f472b6);">✊</div>
                <div class="game-info">
                    <div class="game-name">가위바위보</div>
                    <div class="game-desc">컴퓨터와 대결!</div>
                </div>
                <span class="game-badge new">NEW</span>
            </div>
        </div>
    </div>
    <div class="sidebar-modal-footer">
        <button class="sidebar-modal-btn secondary" onclick="closeSidebarModal()">닫기</button>
    </div>
</div>

<script>
// 사이드바 모달 열기
function openSidebarModal(type) {
    const overlay = document.getElementById('sidebarModalOverlay');
    overlay.classList.add('active');

    // 모든 모달 닫기
    document.querySelectorAll('.sidebar-modal').forEach(m => m.classList.remove('active'));

    // 해당 모달 열기
    let modalId = '';
    switch(type) {
        case 'message': modalId = 'sidebarMessageModal'; break;
        case 'point': modalId = 'sidebarPointModal'; break;
        case 'scrap': modalId = 'sidebarScrapModal'; break;
        case 'game': modalId = 'sidebarGameModal'; break;
    }

    if(modalId) {
        const modal = document.getElementById(modalId);
        if(modal) modal.classList.add('active');
    }

    // 모바일에서 사이드바 닫기
    if(window.innerWidth <= 992) {
        document.getElementById('sidebar').classList.remove('active');
        document.getElementById('sidebarOverlay').classList.remove('active');
    }
}

// 사이드바 모달 닫기
function closeSidebarModal() {
    document.getElementById('sidebarModalOverlay').classList.remove('active');
    document.querySelectorAll('.sidebar-modal').forEach(m => m.classList.remove('active'));
}

// ESC 키로 모달 닫기
document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape') {
        closeSidebarModal();
    }
});
</script>
