<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium 스킨 - 글쓰기 (write.skin.php)
 */

// 공통 함수 로드
include_once(dirname(__FILE__).'/_inc.php');

// 글쓰기/수정 모드
$is_edit = ($w == 'u');
$page_title = $is_edit ? '글 수정' : '글쓰기';
?>

<!-- 브레드크럼 -->
<div class="breadcrumb">
    <a href="<?php echo G5_URL; ?>">홈</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
    <a href="<?php echo premium_board_url($bo_table); ?>"><?php echo premium_escape($board['bo_subject']); ?></a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
    <span><?php echo $page_title; ?></span>
</div>

<!-- 페이지 타이틀 -->
<div class="page-title-section">
    <div class="page-title">
        <div class="page-title-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <div>
            <h1><?php echo $page_title; ?></h1>
            <p><?php echo premium_escape($board['bo_subject']); ?>에 글을 작성합니다</p>
        </div>
    </div>
</div>

<!-- 글쓰기 폼 -->
<form name="fwrite" id="fwrite" action="<?php echo $action_url; ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
<input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
<input type="hidden" name="sca" value="<?php echo premium_escape($sca); ?>">
<input type="hidden" name="sfl" value="<?php echo premium_escape($sfl); ?>">
<input type="hidden" name="stx" value="<?php echo premium_escape($stx); ?>">
<input type="hidden" name="spt" value="<?php echo $spt; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="is_notice" value="<?php echo (int)$is_notice; ?>">
<?php
// DHTML 에디터 사용 시 html 필드를 hidden으로 전달
if ($is_html && $is_dhtml_editor) {
    echo '<input type="hidden" name="html" value="html1">';
}
?>
<?php echo $g5['token']; ?>

<div class="write-form">
    <!-- 기본 정보 -->
    <div class="form-section">
        <div class="form-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            기본 정보
        </div>

        <?php if (!$is_member) { ?>
        <div class="form-row">
            <div class="form-group half">
                <label class="form-label">이름 <span class="required">*</span></label>
                <input type="text" name="wr_name" value="<?php echo premium_escape($name); ?>" class="form-input" placeholder="이름을 입력하세요" required>
            </div>
            <div class="form-group half">
                <label class="form-label">비밀번호 <span class="required">*</span></label>
                <input type="password" name="wr_password" class="form-input" placeholder="비밀번호를 입력하세요" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">이메일</label>
                <input type="email" name="wr_email" value="<?php echo premium_escape($email); ?>" class="form-input" placeholder="이메일을 입력하세요">
            </div>
        </div>
        <?php } ?>

        <?php if ($is_category) { ?>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">분류 <span class="required">*</span></label>
                <select name="ca_name" class="form-select" required>
                    <option value="">분류 선택</option>
                    <?php echo $category_option; ?>
                </select>
            </div>
        </div>
        <?php } ?>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">제목 <span class="required">*</span></label>
                <input type="text" name="wr_subject" value="<?php echo premium_escape($subject); ?>" class="form-input" placeholder="제목을 입력하세요" required>
            </div>
        </div>
    </div>

    <!-- 본문 -->
    <div class="form-section">
        <div class="form-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            내용
        </div>

        <div class="form-row">
            <div class="form-group">
                <?php if ($write_min < $html_level) { ?>
                <div class="html-mode-wrap">
                    <?php echo $html_value; ?>
                </div>
                <?php } ?>

                <?php if ($editor) { ?>
                <?php echo $editor; ?>
                <?php } else { ?>
                <textarea name="wr_content" class="form-textarea" placeholder="내용을 입력하세요..."><?php echo $content; ?></textarea>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- 파일 첨부 -->
    <?php if ($is_file) { ?>
    <div class="form-section">
        <div class="form-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
            첨부파일 / 미리보기 이미지
        </div>

        <!-- 드래그앤드롭 영역 -->
        <div class="file-dropzone" id="fileDropzone">
            <input type="file" name="bf_file[]" id="fileInput" multiple class="file-hidden-input" accept="*/*">
            <div class="dropzone-content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <p>파일을 아래에서 선택하세요</p>
                <span>최대 <?php echo $file_count; ?>개 / 파일당 <?php echo number_format($board['bo_upload_size'] / 1024 / 1024, 1); ?>MB</span>
            </div>
        </div>

        <!-- 파일 목록 -->
        <div class="file-list" id="fileList">
            <?php for ($i = 0; $i < $file_count; $i++) { ?>
            <div class="file-slot" data-slot="<?php echo $i; ?>">
                <span class="file-slot-num"><?php echo $i + 1; ?></span>
                <label class="file-slot-btn">
                    <input type="file" name="bf_file[]" class="file-slot-input" data-index="<?php echo $i; ?>">
                    파일 선택
                </label>
                <span class="file-slot-name">선택된 파일 없음</span>
                <input type="text" name="bf_content[]" class="file-slot-desc" placeholder="파일 설명 (선택)">
                <?php if (isset($file[$i]['source']) && $file[$i]['source']) { ?>
                <div class="file-slot-exist">
                    <?php
                    $file_ext = strtolower(pathinfo($file[$i]['source'], PATHINFO_EXTENSION));
                    $is_image_file = in_array($file_ext, array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'));
                    ?>
                    <?php if ($is_image_file) { ?>
                    <img src="<?php echo G5_DATA_URL; ?>/file/<?php echo $bo_table; ?>/<?php echo $file[$i]['file']; ?>" alt="<?php echo premium_escape($file[$i]['source']); ?>" class="file-thumb">
                    <?php } else { ?>
                    <span class="file-icon-box">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                    </span>
                    <?php } ?>
                    <span class="file-exist-name"><?php echo premium_escape($file[$i]['source']); ?></span>
                    <label class="file-del-check"><input type="checkbox" name="bf_file_del[]" value="<?php echo $i; ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></label>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

    <!-- 링크 -->
    <?php if ($is_link) { ?>
    <div class="form-section">
        <div class="form-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
            링크
        </div>

        <?php for ($i = 1; $i <= $link_count; $i++) { ?>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">링크 <?php echo $i; ?></label>
                <input type="url" name="wr_link<?php echo $i; ?>" value="<?php echo premium_escape(${'link'.$i}); ?>" class="form-input" placeholder="https://">
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>

    <!-- 옵션 -->
    <?php if ($is_notice || $is_secret || $is_mail) { ?>
    <div class="form-section">
        <div class="form-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            옵션
        </div>

        <div class="option-list">
            <?php if ($is_notice) { ?>
            <label class="option-item">
                <input type="checkbox" name="notice" value="1" <?php echo $notice_checked; ?>>
                <span class="option-check"></span>
                <span class="option-text">공지사항</span>
            </label>
            <?php } ?>

            <?php if ($is_secret) { ?>
            <label class="option-item">
                <input type="checkbox" name="secret" value="secret" <?php echo $secret_checked; ?>>
                <span class="option-check"></span>
                <span class="option-text">비밀글</span>
            </label>
            <?php } ?>

            <?php if ($is_mail) { ?>
            <label class="option-item">
                <input type="checkbox" name="mail" value="mail" <?php echo $mail_checked; ?>>
                <span class="option-check"></span>
                <span class="option-text">답변 메일 알림</span>
            </label>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

    <!-- 버튼 -->
    <div class="form-actions">
        <a href="<?php echo $list_href; ?>" class="btn-cancel">취소</a>
        <button type="submit" class="btn-submit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20,6 9,17 4,12"/></svg>
            <?php echo $is_edit ? '수정하기' : '등록하기'; ?>
        </button>
    </div>
</div>
</form>

<script>
// 파일 슬롯 선택 시 파일명 및 썸네일 표시
document.querySelectorAll('.file-slot-input').forEach(function(input) {
    input.addEventListener('change', function() {
        var slot = this.closest('.file-slot');
        var nameEl = slot.querySelector('.file-slot-name');
        var file = this.files[0];

        if (file) {
            nameEl.textContent = file.name;

            // 이미지 파일이면 썸네일 미리보기 생성
            if (file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // 기존 미리보기 제거
                    var oldPreview = slot.querySelector('.file-preview');
                    if (oldPreview) oldPreview.remove();

                    var preview = document.createElement('div');
                    preview.className = 'file-preview';
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="미리보기"><button type="button" class="file-preview-remove" onclick="removeFilePreview(this)"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
                    slot.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        } else {
            nameEl.textContent = '선택된 파일 없음';
        }
    });
});

// 파일 미리보기 제거
function removeFilePreview(btn) {
    var slot = btn.closest('.file-slot');
    var input = slot.querySelector('.file-slot-input');
    var nameEl = slot.querySelector('.file-slot-name');
    var preview = slot.querySelector('.file-preview');

    // input 초기화
    input.value = '';
    nameEl.textContent = '선택된 파일 없음';
    if (preview) preview.remove();
}

// 드래그앤드롭 영역
var dropzone = document.getElementById('fileDropzone');
var mainFileInput = document.getElementById('fileInput');
if (dropzone && mainFileInput) {
    dropzone.addEventListener('click', function() {
        mainFileInput.click();
    });

    // 메인 파일 input에서 여러 파일 선택 시 각 슬롯에 배분
    mainFileInput.addEventListener('change', function() {
        var files = this.files;
        var slots = document.querySelectorAll('.file-slot-input');

        for (var i = 0; i < files.length && i < slots.length; i++) {
            var dt = new DataTransfer();
            dt.items.add(files[i]);
            slots[i].files = dt.files;
            slots[i].dispatchEvent(new Event('change'));
        }
        // input 초기화
        this.value = '';
    });

    dropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');

        var files = e.dataTransfer.files;
        var slots = document.querySelectorAll('.file-slot-input');

        for (var i = 0; i < files.length && i < slots.length; i++) {
            // DataTransfer를 사용하여 파일 설정
            var dt = new DataTransfer();
            dt.items.add(files[i]);
            slots[i].files = dt.files;

            // change 이벤트 트리거
            slots[i].dispatchEvent(new Event('change'));
        }
    });
}

// 다크모드 에디터 글씨 색상 설정 및 하단 영역 숨기기
function setEditorDarkMode() {
    var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    var iframes = document.querySelectorAll('.write-form iframe');
    iframes.forEach(function(iframe) {
        try {
            var doc = iframe.contentDocument || iframe.contentWindow.document;
            if (doc && doc.body) {
                doc.body.style.backgroundColor = isDark ? '#2a2a3e' : '#fff';
                doc.body.style.color = isDark ? '#fff' : '#1a1a2e';

                // 드래그 메시지 숨기기
                var resizeNotice = doc.querySelector('.husky_seditor_resize_notice');
                if (resizeNotice) resizeNotice.style.display = 'none';

                // 하단 "입력창 크기 조절" 및 Editor/HTML/TEXT 탭 숨기기
                var conversionMode = doc.querySelector('.se2_conversion_mode');
                if (conversionMode) conversionMode.style.display = 'none';

                var inputareaController = doc.querySelector('.se2_inputarea_controller');
                if (inputareaController) inputareaController.style.display = 'none';
            }
        } catch(e) {}
    });
}

// 페이지 로드 후 에디터 다크모드 설정
setTimeout(setEditorDarkMode, 500);
setTimeout(setEditorDarkMode, 1000);
setTimeout(setEditorDarkMode, 2000);

// 테마 변경 감지
var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.attributeName === 'data-theme') {
            setEditorDarkMode();
        }
    });
});
observer.observe(document.documentElement, { attributes: true });

// 폼 제출 전 체크
function fwrite_submit(f) {
    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함 ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
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

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함 ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>

<style>
/* 글쓰기 폼 스타일 */
.write-form {
    background: var(--bg-card);
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border);
    overflow: visible;
}

.form-section {
    padding: 24px;
    border-bottom: 1px solid var(--border);
}

.form-section:last-child {
    border-bottom: none;
}

.form-section-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-primary);
}

.form-section-title svg {
    width: 20px;
    height: 20px;
    color: var(--accent);
}

.form-row {
    display: flex;
    gap: 16px;
    margin-bottom: 16px;
}

.form-row:last-child {
    margin-bottom: 0;
}

.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group.half {
    flex: 0 0 calc(50% - 8px);
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 4px;
}

.form-label .required {
    color: var(--accent);
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 12px 14px;
    font-size: 14px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: var(--bg-main);
    color: var(--text-primary);
    outline: none;
    transition: all 0.2s;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
}

.form-textarea {
    min-height: 300px;
    resize: vertical;
    line-height: 1.6;
}

.form-hint {
    font-size: 12px;
    color: var(--text-light);
    margin-top: 8px;
}

/* 파일 업로드 - 드래그앤드롭 영역 */
.file-dropzone {
    border: 2px dashed var(--border);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--bg-main);
    margin-bottom: 16px;
}

.file-dropzone:hover,
.file-dropzone.dragover {
    border-color: var(--accent);
    background: var(--accent-glow);
}

.file-dropzone .dropzone-content svg {
    width: 48px;
    height: 48px;
    color: var(--text-light);
    margin-bottom: 12px;
}

.file-dropzone:hover .dropzone-content svg,
.file-dropzone.dragover .dropzone-content svg {
    color: var(--accent);
}

.file-dropzone .dropzone-content p {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 6px 0;
}

.file-dropzone .dropzone-content span {
    font-size: 12px;
    color: var(--text-light);
}

.file-hidden-input {
    display: none;
}

/* 파일 목록 */
.file-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.file-slot {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: var(--bg-main);
    border: 1px solid var(--border);
    border-radius: 10px;
    position: relative;
}

.file-slot-num {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--accent);
    color: white;
    font-size: 12px;
    font-weight: 700;
    border-radius: 50%;
    flex-shrink: 0;
}

.file-slot-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 14px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}

.file-slot-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.file-slot-input {
    display: none;
}

.file-slot-name {
    flex: 1;
    font-size: 13px;
    color: var(--text-light);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    min-width: 0;
}

.file-slot-desc {
    width: 180px;
    padding: 8px 12px;
    font-size: 12px;
    border: 1px solid var(--border);
    border-radius: 6px;
    background: var(--bg-card);
    color: var(--text-primary);
    flex-shrink: 0;
}

.file-slot-desc:focus {
    border-color: var(--accent);
    outline: none;
}

/* 기존 파일 표시 */
.file-slot-exist {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 8px;
    margin-top: 8px;
    position: absolute;
    bottom: -50px;
    left: 12px;
    right: 12px;
    z-index: 1;
}

.file-slot:has(.file-slot-exist) {
    margin-bottom: 55px;
}

.file-slot-exist .file-thumb {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
    flex-shrink: 0;
}

.file-slot-exist .file-icon-box {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-main);
    border-radius: 4px;
    flex-shrink: 0;
}

.file-slot-exist .file-icon-box svg {
    width: 24px;
    height: 24px;
    color: var(--text-light);
}

.file-slot-exist .file-exist-name {
    flex: 1;
    font-size: 12px;
    color: var(--text-secondary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.file-del-check {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--bg-main);
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}

.file-del-check:hover {
    background: #ef4444;
}

.file-del-check:hover svg {
    color: white;
}

.file-del-check input {
    display: none;
}

.file-del-check input:checked + svg {
    color: #ef4444;
}

.file-del-check svg {
    width: 16px;
    height: 16px;
    color: var(--text-light);
}

/* 새 파일 미리보기 */
.file-preview {
    position: absolute;
    bottom: -60px;
    left: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    background: var(--bg-card);
    border: 1px solid var(--accent);
    border-radius: 8px;
    z-index: 2;
}

.file-slot:has(.file-preview) {
    margin-bottom: 65px;
}

.file-preview img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
}

.file-preview-remove {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ef4444;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s;
}

.file-preview-remove:hover {
    background: #dc2626;
    transform: scale(1.1);
}

.file-preview-remove svg {
    width: 14px;
    height: 14px;
    color: white;
}

/* 옵션 */
.option-list {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.option-item {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.option-item input {
    display: none;
}

.option-check {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border);
    border-radius: 4px;
    position: relative;
    transition: all 0.2s;
}

.option-item input:checked + .option-check {
    background: var(--accent);
    border-color: var(--accent);
}

.option-item input:checked + .option-check::after {
    content: '';
    position: absolute;
    top: 2px;
    left: 6px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.option-text {
    font-size: 14px;
    color: var(--text-primary);
}

/* 버튼 */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 20px 24px;
    background: var(--bg-main);
}

.btn-cancel {
    padding: 12px 24px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-secondary);
    text-decoration: none;
    transition: all 0.2s;
}

.btn-cancel:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.btn-submit {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--accent), #ff6b6b);
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px var(--accent-glow);
}

.btn-submit svg {
    width: 18px;
    height: 18px;
}

/* 에디터 스타일 */
.write-form iframe,
.write-form .tx_trg_editor,
.write-form .cheditor_body,
.write-form .se2_input_area,
.write-form .se2_input_wysiwyg {
    background: #fff !important;
}

/* 다크모드 에디터 */
[data-theme="dark"] .write-form iframe,
[data-theme="dark"] .write-form .tx_trg_editor,
[data-theme="dark"] .write-form .cheditor_body,
[data-theme="dark"] .write-form .se2_input_area,
[data-theme="dark"] .write-form .se2_input_wysiwyg {
    background: #2a2a3e !important;
}

[data-theme="dark"] .write-form iframe body,
[data-theme="dark"] .write-form .cheditor_body,
[data-theme="dark"] .write-form .se2_input_wysiwyg {
    color: #fff !important;
}

/* ========================================
   에디터 단축키 탭 숨기기 (상단)
   ======================================== */
.write-form .se2_tool .se2_multy_text,
.write-form .se2_text_tool .husky_seditor_ui_bDocument,
.write-form .se2_tool ul li a[title="단축키 일람"],
.write-form .se2_text_tool .se2_view_shortcut,
.write-form .husky_seditor_shortcut_guide {
    display: none !important;
}

/* 단축키 버튼/탭 전체 숨기기 */
.write-form .se2_tool .se2_multy {
    display: none !important;
}

/* CKEditor 단축키 버튼 숨기기 */
.write-form .cke_sc,
.write-form .btn_cke_sc {
    display: none !important;
}

/* ========================================
   에디터 하단 드래그 영역/경로 영역 수정
   ======================================== */
/* 하단 경로/리사이즈 영역 - 깔끔하게 */
.write-form .se2_resizer {
    height: auto !important;
    min-height: 24px !important;
    padding: 4px 8px !important;
    background: #f8f9fa !important;
    border-top: 1px solid #e0e0e0 !important;
}

[data-theme="dark"] .write-form .se2_resizer {
    background: #2a2a2a !important;
    border-top: 1px solid #404040 !important;
}

/* 하단 드래그 메시지 숨기기 */
.write-form .se2_resizer .husky_seditor_resize_notice,
.write-form .se2_resizer span {
    display: none !important;
}

/* 에디터 높이 조절 - 하단 잘림 방지 */
.write-form .form-group > div {
    min-height: auto !important;
    height: auto !important;
    overflow: visible !important;
}

.write-form .form-group table {
    min-height: auto !important;
    height: auto !important;
}

/* 에디터 입력 영역 - iframe 높이 자동 조절 */
.write-form .se2_input_wysiwyg,
.write-form .husky_seditor_editing_area_container {
    min-height: 300px !important;
    height: auto !important;
}

/* iframe 높이 - style 속성 우선 적용되도록 */
.write-form iframe {
    min-height: 300px !important;
    display: block !important;
}

/* 에디터 overflow 문제 해결 */
.write-form .form-group > div,
.write-form .form-group > div > table {
    overflow: visible !important;
}

/* HTML 모드 선택 */
.html-mode-wrap {
    margin-bottom: 12px;
}

.html-mode-wrap select {
    padding: 8px 12px;
    border: 1px solid var(--border);
    border-radius: 6px;
    background: var(--bg-main);
    color: var(--text-primary);
    font-size: 13px;
}

/* 반응형 */
@media (max-width: 768px) {
    .form-section {
        padding: 16px;
    }

    .form-row {
        flex-direction: column;
    }

    .form-group.half {
        flex: 1;
    }

    .form-actions {
        flex-direction: column;
        padding: 16px;
    }

    .btn-cancel,
    .btn-submit {
        width: 100%;
        justify-content: center;
    }
}
</style>
