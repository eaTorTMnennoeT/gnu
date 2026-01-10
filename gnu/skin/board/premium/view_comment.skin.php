<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium 스킨 - 댓글 (view_comment.skin.php)
 * 그누보드 표준 view_comment.skin.php 참고
 */

// 공통 함수 로드
include_once(dirname(__FILE__).'/_inc.php');
?>

<script>
// 글자수 제한
var char_min = parseInt(<?php echo $comment_min ?>);
var char_max = parseInt(<?php echo $comment_max ?>);
</script>

<!-- 댓글 목록 시작 -->
<div class="premium-comment-list">
    <?php
    if (!isset($list)) $list = array();
    $cmt_amt = count($list);
    for ($i = 0; $i < $cmt_amt; $i++) {
        $comment_id = $list[$i]['wr_id'];
        $cmt_depth = strlen($list[$i]['wr_comment_reply']);
        $comment = $list[$i]['content'];

        // 비밀글 체크
        $is_secret = strstr($list[$i]['wr_option'], 'secret');

        // 답변/수정 링크
        $c_reply_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=c#bo_vc_w';
        $c_edit_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=cu#bo_vc_w';

        $is_comment_reply_edit = ($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del']) ? 1 : 0;
    ?>
    <div class="comment-item<?php echo $cmt_depth ? ' comment-reply depth-'.$cmt_depth : ''; ?>" id="c_<?php echo $comment_id; ?>"<?php echo $cmt_depth ? ' style="margin-left:'.($cmt_depth * 30).'px;"' : ''; ?>>
        <div class="comment-header">
            <div class="comment-author">
                <?php
                $avatar_name = strip_tags($list[$i]['wr_name']);
                $first_char = mb_substr($avatar_name, 0, 1, 'UTF-8');
                // 레벨 아이콘
                $mb_level_icon = '';
                if ($list[$i]['mb_id']) {
                    $cmt_member = get_member($list[$i]['mb_id']);
                    if ($cmt_member['mb_level']) {
                        $mb_level_icon = get_mb_icon_name($cmt_member['mb_level']);
                    }
                }
                ?>
                <div class="comment-avatar">
                    <?php if ($mb_level_icon && is_file(G5_DATA_PATH.'/member/'.$mb_level_icon)) { ?>
                    <img src="<?php echo G5_DATA_URL; ?>/member/<?php echo $mb_level_icon; ?>" alt="레벨<?php echo $cmt_member['mb_level']; ?>">
                    <?php } else { ?>
                    <?php echo $first_char; ?>
                    <?php } ?>
                </div>
                <div class="comment-author-info">
                    <span class="comment-name"><?php echo $list[$i]['name']; ?></span>
                    <span class="comment-date"><?php echo $list[$i]['datetime']; ?></span>
                    <?php if ($is_secret) { ?>
                    <span class="comment-secret-badge">비밀</span>
                    <?php } ?>
                </div>
            </div>

            <?php if ($is_comment_reply_edit) { ?>
            <div class="comment-actions">
                <?php if ($list[$i]['is_reply']) { ?>
                <button type="button" class="comment-action-btn" onclick="comment_box('<?php echo $comment_id; ?>', 'c')">답글</button>
                <?php } ?>
                <?php if ($list[$i]['is_edit']) { ?>
                <button type="button" class="comment-action-btn" onclick="comment_box('<?php echo $comment_id; ?>', 'cu')">수정</button>
                <?php } ?>
                <?php if ($list[$i]['is_del']) { ?>
                <a href="<?php echo $list[$i]['del_link']; ?>" class="comment-action-btn delete" onclick="return confirm('이 댓글을 삭제하시겠습니까?');">삭제</a>
                <?php } ?>
            </div>
            <?php } ?>
        </div>

        <div class="comment-content">
            <?php
            // 답글인 경우 부모 댓글 작성자 @멘션 표시
            if ($cmt_depth > 0 && $i > 0) {
                // 부모 댓글 찾기
                $parent_reply = substr($list[$i]['wr_comment_reply'], 0, -1);
                for ($j = $i - 1; $j >= 0; $j--) {
                    if ($list[$j]['wr_comment'] == $list[$i]['wr_comment'] && $list[$j]['wr_comment_reply'] == $parent_reply) {
                        $parent_name = strip_tags($list[$j]['wr_name']);
                        echo '<span class="comment-mention">@'.$parent_name.'</span> ';
                        break;
                    }
                }
            }
            echo $comment;
            ?>
        </div>

        <!-- 수정/답변 폼 삽입 위치 -->
        <span id="edit_<?php echo $comment_id; ?>" class="bo_vc_w"></span>
        <span id="reply_<?php echo $comment_id; ?>" class="bo_vc_w"></span>

        <!-- 비밀댓글 및 원본 저장 -->
        <input type="hidden" value="<?php echo $is_secret ? 'secret' : ''; ?>" id="secret_comment_<?php echo $comment_id; ?>">
        <textarea id="save_comment_<?php echo $comment_id; ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0); ?></textarea>
    </div>
    <?php } ?>

    <?php if ($cmt_amt == 0) { ?>
    <div class="comment-empty">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="empty-icon">
            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
        </svg>
        <p>첫 번째 댓글을 남겨보세요!</p>
    </div>
    <?php } ?>
</div>
<!-- 댓글 목록 끝 -->

<?php if ($is_comment_write) {
    if ($w == '') $w = 'c';
?>
<!-- 댓글 작성 폼 시작 -->
<aside id="bo_vc_w" class="comment-write-section">
    <h3 class="comment-write-title">댓글 작성</h3>
    <form name="fviewcomment" id="fviewcomment" action="<?php echo $comment_action_url; ?>" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
        <input type="hidden" name="w" value="<?php echo $w; ?>" id="w">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
        <input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
        <input type="hidden" name="comment_id" value="<?php echo $c_id; ?>" id="comment_id">
        <input type="hidden" name="sca" value="<?php echo $sca; ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
        <input type="hidden" name="stx" value="<?php echo $stx; ?>">
        <input type="hidden" name="spt" value="<?php echo $spt; ?>">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <input type="hidden" name="is_good" value="">

        <div class="comment-form-wrap">
            <?php if ($is_guest) { ?>
            <div class="comment-guest-row">
                <div class="comment-guest-field">
                    <label for="wr_name">이름</label>
                    <input type="text" name="wr_name" id="wr_name" value="<?php echo get_cookie('ck_sns_name'); ?>" class="comment-input-field" placeholder="이름" required>
                </div>
                <div class="comment-guest-field">
                    <label for="wr_password">비밀번호</label>
                    <input type="password" name="wr_password" id="wr_password" class="comment-input-field" placeholder="비밀번호" required>
                </div>
            </div>
            <?php } ?>

            <div class="comment-textarea-wrap">
                <?php if ($comment_min || $comment_max) { ?>
                <div class="comment-char-count">
                    <span id="char_count">0</span>글자
                    <?php if ($comment_min) { ?><span class="char-limit">(최소 <?php echo $comment_min; ?>자)</span><?php } ?>
                    <?php if ($comment_max) { ?><span class="char-limit">(최대 <?php echo $comment_max; ?>자)</span><?php } ?>
                </div>
                <?php } ?>
                <textarea name="wr_content" id="wr_content" class="comment-textarea" placeholder="댓글 내용을 입력해주세요" required maxlength="10000"
                    <?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content; ?></textarea>
            </div>

            <div class="comment-form-footer">
                <div class="comment-options">
                    <label class="comment-secret-check">
                        <input type="checkbox" name="wr_secret" id="wr_secret" value="secret">
                        <span class="checkmark"></span>
                        <span>비밀글</span>
                    </label>
                </div>

                <?php if ($is_guest) { echo $captcha_html; } ?>

                <button type="submit" id="btn_submit" class="comment-submit-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22,2 15,22 11,13 2,9"/>
                    </svg>
                    <span>등록</span>
                </button>
            </div>
        </div>
    </form>
</aside>

<script>
<?php if ($comment_min || $comment_max) { ?>
check_byte('wr_content', 'char_count');
<?php } ?>

var save_before = '';
var save_html = document.getElementById('bo_vc_w').innerHTML;

function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g;

    f.is_good.value = 0;

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": "",
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!document.getElementById('wr_content').value)
    {
        alert("댓글을 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    <?php if($is_guest) echo chk_captcha_js(); ?>

    set_comment_token(f);

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

function comment_box(comment_id, work) {
    var el_id,
        form_el = 'fviewcomment',
        respond = document.getElementById(form_el);

    if (comment_id) {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    } else {
        el_id = 'bo_vc_w';
    }

    if (save_before != el_id) {
        if (save_before) {
            document.getElementById(save_before).style.display = 'none';
        }

        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).appendChild(respond);
        document.getElementById('wr_content').value = '';

        // 댓글 수정
        if (work == 'cu') {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
            if (document.getElementById('secret_comment_' + comment_id).value)
                document.getElementById('wr_secret').checked = true;
            else
                document.getElementById('wr_secret').checked = false;
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        if (save_before)
            $("#captcha_reload").trigger("click");

        save_before = el_id;
    }
}

// 초기화
comment_box('', 'c');
</script>
<?php } ?>
<!-- 댓글 작성 폼 끝 -->

<style>
/* ========================================
   Premium 댓글 스타일
   ======================================== */

/* 댓글 목록 */
.premium-comment-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 24px;
}

/* 댓글 아이템 */
.comment-item {
    padding: 16px 20px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    transition: all 0.2s;
}

.comment-item:hover {
    border-color: var(--border-hover, var(--border));
}

.comment-item.comment-reply {
    background: var(--bg-main);
    border-left: 3px solid var(--accent);
    border-radius: 0 12px 12px 0;
}

/* 댓글 헤더 */
.comment-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.comment-author {
    display: flex;
    align-items: center;
    gap: 10px;
}

.comment-avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--accent), #ff6b6b);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    font-weight: 600;
    flex-shrink: 0;
}

.comment-author-info {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
}

.comment-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

.comment-date {
    font-size: 12px;
    color: var(--text-light);
}

.comment-secret-badge {
    padding: 2px 6px;
    background: var(--accent);
    color: white;
    font-size: 10px;
    border-radius: 4px;
}

/* 댓글 액션 버튼 */
.comment-actions {
    display: flex;
    gap: 6px;
}

.comment-action-btn {
    padding: 5px 10px;
    background: transparent;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 12px;
    color: var(--text-secondary);
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}

.comment-action-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
    background: rgba(16, 185, 129, 0.05);
}

.comment-action-btn.delete:hover {
    border-color: #ef4444;
    color: #ef4444;
    background: rgba(239, 68, 68, 0.05);
}

/* 댓글 내용 */
.comment-content {
    font-size: 14px;
    line-height: 1.7;
    color: var(--text-primary);
    word-break: break-word;
}

.comment-content a {
    color: var(--accent);
}

.comment-mention {
    color: var(--accent);
    font-weight: 600;
    margin-right: 4px;
}

.comment-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

/* 빈 상태 */
.comment-empty {
    padding: 60px 20px;
    text-align: center;
    color: var(--text-light);
}

.comment-empty .empty-icon {
    width: 48px;
    height: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.comment-empty p {
    margin: 0;
    font-size: 14px;
}

/* 댓글 작성 섹션 */
.comment-write-section {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    margin-top: 24px;
}

.comment-write-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 16px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* 비회원 입력 필드 */
.comment-guest-row {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
}

.comment-guest-field {
    flex: 1;
}

.comment-guest-field label {
    display: block;
    font-size: 12px;
    color: var(--text-secondary);
    margin-bottom: 4px;
}

.comment-input-field {
    width: 100%;
    padding: 10px 12px;
    background: var(--bg-main);
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 14px;
    color: var(--text-primary);
    outline: none;
    transition: all 0.2s;
    box-sizing: border-box;
}

.comment-input-field:focus {
    border-color: var(--accent);
}

/* 텍스트영역 */
.comment-textarea-wrap {
    position: relative;
    margin-bottom: 12px;
}

.comment-char-count {
    position: absolute;
    top: 10px;
    right: 12px;
    font-size: 11px;
    color: var(--text-light);
    z-index: 1;
}

.comment-char-count .char-limit {
    color: var(--text-light);
    opacity: 0.7;
}

.comment-textarea {
    width: 100%;
    min-height: 100px;
    padding: 14px 16px;
    padding-top: 32px;
    background: var(--bg-main);
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 14px;
    color: var(--text-primary);
    resize: vertical;
    outline: none;
    transition: all 0.2s;
    box-sizing: border-box;
    font-family: inherit;
}

.comment-textarea:focus {
    border-color: var(--accent);
}

.comment-textarea::placeholder {
    color: var(--text-light);
}

/* 폼 푸터 */
.comment-form-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.comment-options {
    display: flex;
    align-items: center;
    gap: 16px;
}

/* 비밀글 체크박스 */
.comment-secret-check {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    font-size: 13px;
    color: var(--text-secondary);
}

.comment-secret-check input[type="checkbox"] {
    display: none;
}

.comment-secret-check .checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid var(--border);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.comment-secret-check input[type="checkbox"]:checked + .checkmark {
    background: var(--accent);
    border-color: var(--accent);
}

.comment-secret-check input[type="checkbox"]:checked + .checkmark::after {
    content: '';
    width: 5px;
    height: 9px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    margin-bottom: 2px;
}

/* 등록 버튼 */
.comment-submit-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    background: linear-gradient(135deg, var(--accent), #059669);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.comment-submit-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.comment-submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.comment-submit-btn svg {
    width: 16px;
    height: 16px;
}

/* 수정/답변 폼 위치 */
.bo_vc_w {
    display: block;
}

/* 캡챠 스타일 조정 */
#bo_vc_w .captcha_box {
    margin: 0;
}

/* 반응형 */
@media (max-width: 768px) {
    .comment-item {
        padding: 14px 16px;
    }

    .comment-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .comment-actions {
        width: 100%;
        justify-content: flex-end;
    }

    .comment-guest-row {
        flex-direction: column;
        gap: 8px;
    }

    .comment-form-footer {
        flex-direction: column;
        align-items: stretch;
    }

    .comment-submit-btn {
        width: 100%;
        justify-content: center;
    }

    .comment-item.comment-reply {
        margin-left: 16px !important;
    }
}

/* 다크모드 */
[data-theme="dark"] .comment-item {
    background: var(--bg-card);
}

[data-theme="dark"] .comment-item.comment-reply {
    background: rgba(255,255,255,0.02);
}

[data-theme="dark"] .comment-input-field,
[data-theme="dark"] .comment-textarea {
    background: var(--bg-main);
}
</style>
