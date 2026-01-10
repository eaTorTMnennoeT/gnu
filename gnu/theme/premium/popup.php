<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * 팝업 출력
 * pb/includes/popup.php 기반
 */

// 회원 정보
$mb_cash_val = $is_member && isset($member['mb_cash']) ? number_format($member['mb_cash']) : '0';
$mb_point_val = $is_member ? number_format($member['mb_point']) : '0';
?>

<!-- 캐시 팝업 -->
<div class="stat-popup-overlay" id="statPopupOverlay"></div>
<div class="stat-popup" id="cashPopup">
    <div class="stat-popup-header">
        <div class="stat-popup-title">
            <div class="stat-popup-title-icon cash">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            캐시 내역
        </div>
        <button class="stat-popup-close" onclick="closeStatPopup()">&#10005;</button>
    </div>
    <div class="stat-popup-body">
        <div class="stat-summary">
            <div class="stat-summary-item">
                <div class="stat-summary-label">보유</div>
                <div class="stat-summary-value cash"><?php echo $mb_cash_val; ?></div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">획득</div>
                <div class="stat-summary-value" style="color: #10b981;">+0</div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">사용</div>
                <div class="stat-summary-value" style="color: var(--accent);">-0</div>
            </div>
        </div>
        <div class="stat-history-title">최근 내역</div>
        <div class="stat-history-list" id="cashHistoryList">
            <?php
            if ($is_member && isset($g5['cash_table'])) {
                $cash_sql = "SELECT * FROM {$g5['cash_table']} WHERE mb_id = '{$member['mb_id']}' ORDER BY ca_id DESC LIMIT 10";
                $cash_result = sql_query($cash_sql);
                $cash_count = 0;
                while($row = sql_fetch_array($cash_result)) {
                    $cash_count++;
                    $type = $row['ca_cash'] >= 0 ? 'plus' : 'minus';
                    $amount = $row['ca_cash'] >= 0 ? '+'.number_format($row['ca_cash']) : number_format($row['ca_cash']);
            ?>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc"><?php echo $row['ca_content']; ?></span>
                    <span class="stat-history-date"><?php echo substr($row['ca_datetime'], 0, 16); ?></span>
                </div>
                <span class="stat-history-amount <?php echo $type; ?>"><?php echo $amount; ?></span>
            </div>
            <?php
                }
                if ($cash_count == 0) {
                    echo '<div class="stat-history-empty">캐시 내역이 없습니다.</div>';
                }
            } else {
                echo '<div class="stat-history-empty">캐시 내역이 없습니다.</div>';
            }
            ?>
        </div>
    </div>
    <div class="stat-popup-footer">
        <button class="stat-popup-btn secondary" onclick="closeStatPopup()">닫기</button>
        <button class="stat-popup-btn primary">캐시 충전</button>
    </div>
</div>

<!-- 포인트 팝업 -->
<div class="stat-popup" id="pointPopup">
    <div class="stat-popup-header">
        <div class="stat-popup-title">
            <div class="stat-popup-title-icon point">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
            </div>
            포인트 내역
        </div>
        <button class="stat-popup-close" onclick="closeStatPopup()">&#10005;</button>
    </div>
    <div class="stat-popup-body">
        <div class="stat-summary">
            <div class="stat-summary-item">
                <div class="stat-summary-label">보유</div>
                <div class="stat-summary-value point"><?php echo $mb_point_val; ?></div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">획득</div>
                <div class="stat-summary-value" style="color: var(--gold);">+0</div>
            </div>
            <div class="stat-summary-item">
                <div class="stat-summary-label">사용</div>
                <div class="stat-summary-value" style="color: var(--accent);">-0</div>
            </div>
        </div>
        <div class="stat-history-title">최근 내역</div>
        <div class="stat-history-list" id="pointHistoryList">
            <?php
            if ($is_member) {
                $point_sql = "SELECT * FROM {$g5['point_table']} WHERE mb_id = '{$member['mb_id']}' ORDER BY po_id DESC LIMIT 10";
                $point_result = sql_query($point_sql);
                $point_count = 0;
                while($row = sql_fetch_array($point_result)) {
                    $point_count++;
                    $type = $row['po_point'] >= 0 ? 'plus' : 'minus';
                    $amount = $row['po_point'] >= 0 ? '+'.number_format($row['po_point']) : number_format($row['po_point']);
            ?>
            <div class="stat-history-item">
                <div class="stat-history-info">
                    <span class="stat-history-desc"><?php echo $row['po_content']; ?></span>
                    <span class="stat-history-date"><?php echo substr($row['po_datetime'], 0, 16); ?></span>
                </div>
                <span class="stat-history-amount <?php echo $type; ?>"><?php echo $amount; ?></span>
            </div>
            <?php
                }
                if ($point_count == 0) {
                    echo '<div class="stat-history-empty">포인트 내역이 없습니다.</div>';
                }
            } else {
                echo '<div class="stat-history-empty">포인트 내역이 없습니다.</div>';
            }
            ?>
        </div>
    </div>
    <div class="stat-popup-footer">
        <button class="stat-popup-btn secondary" onclick="closeStatPopup()">닫기</button>
        <a href="<?php echo G5_BBS_URL; ?>/point.php" class="stat-popup-btn primary">포인트 내역</a>
    </div>
</div>

<!-- 프로필 모달 오버레이 -->
<div class="profile-modal-overlay" id="profileModalOverlay"></div>

<!-- 내정보 모달 -->
<div class="profile-modal" id="myinfoModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            내 정보
        </div>
        <button class="profile-modal-close" onclick="closeProfileModal()">&#10005;</button>
    </div>
    <div class="profile-modal-body">
        <?php if ($is_member) { ?>
        <div class="myinfo-section">
            <div class="myinfo-item">
                <span class="myinfo-label">아이디</span>
                <span class="myinfo-value"><?php echo $member['mb_id']; ?></span>
            </div>
            <div class="myinfo-item">
                <span class="myinfo-label">닉네임</span>
                <span class="myinfo-value"><?php echo $member['mb_nick']; ?></span>
            </div>
            <div class="myinfo-item">
                <span class="myinfo-label">이메일</span>
                <span class="myinfo-value"><?php echo $member['mb_email']; ?></span>
            </div>
            <div class="myinfo-item">
                <span class="myinfo-label">가입일</span>
                <span class="myinfo-value"><?php echo substr($member['mb_datetime'], 0, 10); ?></span>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeProfileModal()">닫기</button>
        <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=<?php echo urlencode(G5_BBS_URL.'/register_form.php'); ?>" class="profile-modal-btn primary">정보수정</a>
    </div>
</div>

<!-- 내 게시글 모달 -->
<div class="profile-modal" id="mypostsModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            내 게시글
        </div>
        <button class="profile-modal-close" onclick="closeProfileModal()">&#10005;</button>
    </div>
    <div class="profile-modal-body">
        <div class="myposts-list">
            <?php
            $myposts_count = 0;
            if ($is_member && isset($g5['board_new_table'])) {
                // board_new 테이블에서 최근 글 조회 (더 효율적)
                $myposts_sql = "SELECT bn.*, b.bo_subject
                    FROM {$g5['board_new_table']} bn
                    LEFT JOIN {$g5['board_table']} b ON bn.bo_table = b.bo_table
                    WHERE bn.mb_id = '{$member['mb_id']}'
                    ORDER BY bn.bn_id DESC LIMIT 5";
                $myposts_result = sql_query($myposts_sql);
                while($row = sql_fetch_array($myposts_result)) {
                    $myposts_count++;
            ?>
            <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $row['bo_table']; ?>&wr_id=<?php echo $row['wr_id']; ?>" class="myposts-item">
                <span class="myposts-title"><?php echo cut_str(strip_tags($row['bn_subject']), 30); ?></span>
                <span class="myposts-date"><?php echo substr($row['bn_datetime'], 0, 10); ?></span>
            </a>
            <?php
                }
            }
            if ($myposts_count == 0) {
                echo '<p class="myposts-empty">아직 작성한 글이 없습니다.</p>';
            }
            ?>
        </div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeProfileModal()">닫기</button>
    </div>
</div>

<!-- 스크랩 모달 -->
<div class="profile-modal" id="scrapModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
            스크랩
        </div>
        <button class="profile-modal-close" onclick="closeProfileModal()">&#10005;</button>
    </div>
    <div class="profile-modal-body">
        <div class="scrap-list">
            <?php
            $scrap_count = 0;
            if ($is_member) {
                $scrap_sql = "SELECT * FROM {$g5['scrap_table']} WHERE mb_id = '{$member['mb_id']}' ORDER BY ms_id DESC LIMIT 10";
                $scrap_result = sql_query($scrap_sql);
                while($row = sql_fetch_array($scrap_result)) {
                    $scrap_count++;
            ?>
            <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $row['bo_table']; ?>&wr_id=<?php echo $row['wr_id']; ?>" class="scrap-item">
                <span class="scrap-title"><?php echo cut_str($row['ms_subject'], 30); ?></span>
                <span class="scrap-date"><?php echo substr($row['ms_datetime'], 0, 10); ?></span>
            </a>
            <?php
                }
            }
            if ($scrap_count == 0) {
                echo '<p class="scrap-empty">스크랩한 게시글이 없습니다.</p>';
            }
            ?>
        </div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeProfileModal()">닫기</button>
    </div>
</div>

<!-- 쪽지 모달 -->
<div class="profile-modal" id="messageModal">
    <div class="profile-modal-header">
        <div class="profile-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            쪽지함
        </div>
        <button class="profile-modal-close" onclick="closeProfileModal()">&#10005;</button>
    </div>
    <div class="profile-modal-body">
        <div class="message-list">
            <?php
            $memo_count = 0;
            if ($is_member) {
                $memo_sql = "SELECT * FROM {$g5['memo_table']} WHERE me_recv_mb_id = '{$member['mb_id']}' ORDER BY me_id DESC LIMIT 10";
                $memo_result = sql_query($memo_sql);
                while($row = sql_fetch_array($memo_result)) {
                    $memo_count++;
                    $unread = ($row['me_read_datetime'] == '0000-00-00 00:00:00') ? 'unread' : '';
            ?>
            <a href="<?php echo G5_BBS_URL; ?>/memo_view.php?me_id=<?php echo $row['me_id']; ?>" class="message-item <?php echo $unread; ?>">
                <div class="message-info">
                    <span class="message-sender"><?php echo $row['me_send_mb_id']; ?></span>
                    <span class="message-preview"><?php echo cut_str(strip_tags($row['me_memo']), 20); ?></span>
                </div>
                <span class="message-date"><?php echo substr($row['me_send_datetime'], 0, 10); ?></span>
            </a>
            <?php
                }
            }
            if ($memo_count == 0) {
                echo '<p class="message-empty">받은 쪽지가 없습니다.</p>';
            }
            ?>
        </div>
    </div>
    <div class="profile-modal-footer">
        <button class="profile-modal-btn secondary" onclick="closeProfileModal()">닫기</button>
    </div>
</div>

<script>
// 프로필 모달 공통 함수
function openProfileModal(type) {
    // 드롭다운 닫기
    document.getElementById('profileDropdown')?.classList.remove('show');
    document.getElementById('mobileBottomsheet')?.classList.remove('show');
    document.getElementById('dropdownOverlay')?.classList.remove('active');

    const overlay = document.getElementById('profileModalOverlay');
    const modal = document.getElementById(type + 'Modal');

    if (overlay && modal) {
        overlay.classList.add('active');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeProfileModal() {
    document.getElementById('profileModalOverlay')?.classList.remove('active');
    document.querySelectorAll('.profile-modal').forEach(m => m.classList.remove('active'));
    document.body.style.overflow = '';
}

// 오버레이 클릭시 닫기
document.getElementById('profileModalOverlay')?.addEventListener('click', closeProfileModal);
</script>

<style>
/* 프로필 모달 공통 스타일 */
.profile-modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.7);
    z-index: 10001;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}
.profile-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.profile-modal {
    position: fixed;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%) scale(0.9);
    width: 90%;
    max-width: 480px;
    max-height: 85vh;
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border);
    z-index: 10002;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.profile-modal.active {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1);
}

.profile-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
}
.profile-modal-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
}
.profile-modal-title svg {
    width: 20px;
    height: 20px;
    color: var(--accent);
}
.profile-modal-close {
    width: 32px; height: 32px;
    border: none;
    background: var(--bg-main);
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.profile-modal-close:hover {
    background: var(--accent);
    color: white;
}

.profile-modal-body {
    padding: 20px;
    overflow-y: auto;
    flex: 1;
}

.profile-modal-footer {
    display: flex;
    gap: 10px;
    padding: 16px 20px;
    border-top: 1px solid var(--border);
    flex-shrink: 0;
}
.profile-modal-btn {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}
.profile-modal-btn.secondary {
    background: var(--bg-main);
    border: 1px solid var(--border);
    color: var(--text-secondary);
}
.profile-modal-btn.secondary:hover {
    border-color: var(--accent);
    color: var(--accent);
}
.profile-modal-btn.primary {
    background: linear-gradient(135deg, var(--accent), #ff6b6b);
    border: none;
    color: white;
}
.profile-modal-btn.primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px var(--accent-glow);
}

/* 내정보 */
.myinfo-section { display: flex; flex-direction: column; gap: 12px; }
.myinfo-item { display: flex; justify-content: space-between; padding: 12px; background: var(--bg-main); border-radius: 8px; }
.myinfo-label { color: var(--text-secondary); font-size: 13px; }
.myinfo-value { color: var(--text-primary); font-weight: 600; font-size: 13px; }

/* 내 게시글/스크랩/쪽지 */
.myposts-list, .scrap-list, .message-list { display: flex; flex-direction: column; gap: 8px; }
.myposts-item, .scrap-item, .message-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 12px; background: var(--bg-main); border-radius: 8px;
    text-decoration: none; transition: all 0.2s;
}
.myposts-item:hover, .scrap-item:hover, .message-item:hover { background: var(--bg-hover); }
.myposts-title, .scrap-title { color: var(--text-primary); font-size: 13px; }
.myposts-date, .scrap-date, .message-date { color: var(--text-light); font-size: 11px; }
.myposts-empty, .scrap-empty, .message-empty { text-align: center; padding: 30px; color: var(--text-light); font-size: 13px; }

.message-item.unread { background: rgba(255,107,107,0.1); }
.message-info { display: flex; flex-direction: column; gap: 4px; }
.message-sender { color: var(--text-primary); font-weight: 600; font-size: 13px; }
.message-preview { color: var(--text-secondary); font-size: 12px; }

/* 히스토리 빈 상태 */
.stat-history-empty { text-align: center; padding: 30px; color: var(--text-light); font-size: 13px; }

@media (max-width: 480px) {
    .profile-modal {
        width: 95%;
        max-height: 90vh;
    }
}
</style>
