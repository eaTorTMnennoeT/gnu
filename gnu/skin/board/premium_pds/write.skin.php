<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium PDS 스킨 - 글쓰기 (write.skin.php)
 * 자료실 게시판용 - 퍼블 디자인 그대로 적용
 */

// 공통 함수 로드
include_once(dirname(__FILE__).'/_inc.php');

// 게시판 설정값
$bo_subject = $board['bo_subject'];
$bo_table = $board['bo_table'];

// 수정 모드 여부
$is_edit = ($w == 'u');

// 에디터 사용 여부
$editor = ($board['bo_use_dhtml_editor'] && $member['mb_level'] >= $board['bo_html_level']);
?>

<style>
/* PDS 글쓰기 전용 스타일 */
.pds-write-form {
    background: var(--bg-card);
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border);
    /* premium-pds.css 기본값이 overflow:hidden 이라 에디터 하단/레이어가 잘릴 수 있음 */
    overflow: visible !important;
    /* 고정 하단 UI(테마/모바일)로 폼 하단이 가려지는 현상 방지 */
    margin-bottom: 24px;
}

.pds-form-section {
    padding: 24px;
    border-bottom: 1px solid var(--border);
    overflow: visible !important;
}
.pds-form-section:last-child { border-bottom: none; }

.pds-form-section-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-primary);
}
.pds-form-section-title svg {
    width: 20px;
    height: 20px;
    color: #10b981;
}

.pds-form-row {
    display: flex;
    gap: 16px;
    margin-bottom: 16px;
}
.pds-form-row:last-child { margin-bottom: 0; }

.pds-form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.pds-form-group.half { flex: 0 0 calc(50% - 8px); }

.pds-form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 4px;
}
.pds-form-label .required {
    color: var(--accent);
    font-size: 14px;
}

.pds-form-input,
.pds-form-select,
.pds-form-textarea {
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
.pds-form-input:focus,
.pds-form-select:focus,
.pds-form-textarea:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
}
.pds-form-input::placeholder,
.pds-form-textarea::placeholder {
    color: var(--text-light);
}

.pds-form-textarea {
    min-height: 300px;
    resize: vertical;
    line-height: 1.6;
}

.pds-form-hint {
    font-size: 12px;
    color: var(--text-light);
    margin-top: 4px;
}

/* 에디터 영역 - 그누보드 DHTML 에디터 스타일 보존 */
.pds-form-group .write_div,
.pds-form-group #wr_content {
    width: 100% !important;
    min-height: 300px;
}

.pds-form-group textarea {
    width: 100% !important;
}

/* 에디터 래퍼 */
.pds-form-group .editor-wrap,
.pds-form-group .SmartEditor2Wrapper,
.pds-form-group #ir1 {
    width: 100% !important;
    border-radius: 10px;
    /* SmartEditor2 하단 경로/리사이저 영역 잘림 방지 */
    overflow: visible !important;
}

/* 에디터 툴바 */
.pds-form-group .se2_tool {
    background: var(--bg-main) !important;
    border-color: var(--border) !important;
}

/* 에디터 본문 영역 */
.pds-form-group .se2_input_wysiwyg,
.pds-form-group .se2_input_htmlsrc,
.pds-form-group .se2_input_text {
    background: var(--bg-main) !important;
    color: var(--text-primary) !important;
    border-color: var(--border) !important;
}

/* 에디터 iframe */
.pds-form-group iframe {
    width: 100% !important;
    background: var(--bg-main);
}

/* CKEditor 대응 */
.pds-form-group .cke {
    width: 100% !important;
    border-radius: 10px;
    overflow: visible !important;
}

.pds-form-group .cke_inner {
    background: var(--bg-main) !important;
}

.pds-form-group .cke_top {
    background: var(--bg-main) !important;
    border-color: var(--border) !important;
}

.pds-form-group .cke_contents {
    background: var(--bg-main) !important;
}

/* 에디터 내부 글씨 색상 (다크모드 대응) */
.pds-form-group .se2_input_wysiwyg iframe html,
.pds-form-group .se2_input_wysiwyg iframe body {
    color: var(--text-primary) !important;
    background: var(--bg-main) !important;
}

/* 에디터 전체 컨테이너 */
.pds-form-group > div {
    width: 100% !important;
}

/* 에디터 테이블 레이아웃 수정 */
.pds-form-group table {
    width: 100% !important;
    table-layout: fixed;
}

/* 에디터가 div로 감싸져 있을 때 */
.pds-write-form .pds-form-group .write_div {
    display: block;
    width: 100% !important;
}

/* 에디터 래퍼 스타일 */
.pds-editor-wrap {
    width: 100%;
    margin-bottom: 8px;
}

.pds-editor-container {
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--border);
}

.pds-editor-container > div,
.pds-editor-container > table {
    width: 100% !important;
}

/* 에디터 내 모든 요소 너비 강제 */
.pds-editor-container * {
    max-width: 100%;
}

/* 에디터 textarea */
.pds-editor-container textarea,
.pds-editor-wrap textarea {
    width: 100% !important;
    min-height: 300px;
    padding: 12px 14px;
    font-size: 14px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: var(--bg-main);
    color: var(--text-primary);
    outline: none;
    resize: vertical;
    line-height: 1.6;
}

.pds-editor-container textarea:focus,
.pds-editor-wrap textarea:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
}

/* ========================================
   에디터 스타일 - 라이트/다크 모드 대응
   ======================================== */

/* 에디터 테이블 강제 너비 */
.pds-editor-container table,
.pds-editor-wrap table {
    width: 100% !important;
    max-width: 100% !important;
    table-layout: fixed !important;
}

.pds-editor-container td,
.pds-editor-wrap td {
    max-width: 100% !important;
}

/* 에디터 iframe */
.pds-editor-container iframe,
.pds-editor-wrap iframe {
    width: 100% !important;
    min-height: 300px;
    border: none !important;
}

/* write_div 클래스 대응 */
.pds-editor-container .write_div,
.pds-editor-wrap .write_div {
    width: 100% !important;
    display: block !important;
}

/* ========================================
   라이트 모드 (기본)
   ======================================== */

/* SmartEditor2 툴바 - 라이트 */
.pds-editor-container .se2_tool,
.pds-editor-wrap .se2_tool {
    background: #f8f9fa !important;
    border: none !important;
    border-bottom: 1px solid #e0e0e0 !important;
}

.pds-editor-container .se2_tool *,
.pds-editor-wrap .se2_tool * {
    color: #333333 !important;
}

.pds-editor-container .se2_text_tool,
.pds-editor-wrap .se2_text_tool {
    background: #f8f9fa !important;
}

/* 에디터 본문 영역 - 라이트 */
.pds-editor-container .husky_seditor_editing_area_container,
.pds-editor-wrap .husky_seditor_editing_area_container,
.pds-editor-container .se2_input_wysiwyg,
.pds-editor-wrap .se2_input_wysiwyg,
.pds-editor-container iframe,
.pds-editor-wrap iframe,
.pds-editor-container .write_div,
.pds-editor-wrap .write_div {
    background: #ffffff !important;
}

/* 에디터 버튼 - 라이트 */
.pds-editor-container button:not(.cost-type-btn):not(.pds-btn),
.pds-editor-wrap button:not(.cost-type-btn):not(.pds-btn) {
    background: #f8f9fa !important;
    border-color: #e0e0e0 !important;
}

/* 단축키/경로 영역 - 라이트 */
.pds-editor-container .se2_path,
.pds-editor-wrap .se2_path {
    background: #f8f9fa !important;
    border-top: 1px solid #e0e0e0 !important;
    color: #666666 !important;
}

.pds-editor-container .se2_path *,
.pds-editor-wrap .se2_path * {
    color: #666666 !important;
}

/* 에디터 하단 정보 영역 - 라이트 */
.pds-form-section .tx-editor-path,
.pds-editor-wrap .tx-editor-path {
    background: #f8f9fa !important;
    color: #666666 !important;
    padding: 8px 12px !important;
    border-top: 1px solid #e0e0e0 !important;
    font-size: 12px !important;
}

/* CKEditor - 라이트 */
.pds-editor-container .cke_wysiwyg_frame,
.pds-editor-container .cke_wysiwyg_div,
.pds-editor-container .cke_top,
.pds-editor-container .cke_bottom {
    background: #ffffff !important;
}

.pds-editor-container .cke_top {
    border-bottom: 1px solid #e0e0e0 !important;
}

/* ========================================
   다크 모드
   ======================================== */
[data-theme="dark"] .pds-editor-container .se2_tool,
[data-theme="dark"] .pds-editor-wrap .se2_tool,
.dark .pds-editor-container .se2_tool,
.dark .pds-editor-wrap .se2_tool {
    background: #2a2a2a !important;
    border-bottom: 1px solid #404040 !important;
}

[data-theme="dark"] .pds-editor-container .se2_tool *,
[data-theme="dark"] .pds-editor-wrap .se2_tool *,
.dark .pds-editor-container .se2_tool *,
.dark .pds-editor-wrap .se2_tool * {
    color: #e0e0e0 !important;
}

[data-theme="dark"] .pds-editor-container .se2_text_tool,
[data-theme="dark"] .pds-editor-wrap .se2_text_tool,
.dark .pds-editor-container .se2_text_tool,
.dark .pds-editor-wrap .se2_text_tool {
    background: #2a2a2a !important;
}

/* 에디터 본문 영역 - 다크 (다크 배경 + 흰 글씨) */
[data-theme="dark"] .pds-editor-container .husky_seditor_editing_area_container,
[data-theme="dark"] .pds-editor-wrap .husky_seditor_editing_area_container,
[data-theme="dark"] .pds-editor-container .se2_input_wysiwyg,
[data-theme="dark"] .pds-editor-wrap .se2_input_wysiwyg,
[data-theme="dark"] .pds-editor-container iframe,
[data-theme="dark"] .pds-editor-wrap iframe,
[data-theme="dark"] .pds-editor-container .write_div,
[data-theme="dark"] .pds-editor-wrap .write_div,
.dark .pds-editor-container .husky_seditor_editing_area_container,
.dark .pds-editor-wrap .husky_seditor_editing_area_container,
.dark .pds-editor-container .se2_input_wysiwyg,
.dark .pds-editor-wrap .se2_input_wysiwyg,
.dark .pds-editor-container iframe,
.dark .pds-editor-wrap iframe,
.dark .pds-editor-container .write_div,
.dark .pds-editor-wrap .write_div {
    background: #1e1e1e !important;
}

/* 에디터 버튼 - 다크 */
[data-theme="dark"] .pds-editor-container button:not(.cost-type-btn):not(.pds-btn),
[data-theme="dark"] .pds-editor-wrap button:not(.cost-type-btn):not(.pds-btn),
.dark .pds-editor-container button:not(.cost-type-btn):not(.pds-btn),
.dark .pds-editor-wrap button:not(.cost-type-btn):not(.pds-btn) {
    background: #2a2a2a !important;
    border-color: #404040 !important;
}

/* 단축키/경로 영역 - 다크 */
[data-theme="dark"] .pds-editor-container .se2_path,
[data-theme="dark"] .pds-editor-wrap .se2_path,
.dark .pds-editor-container .se2_path,
.dark .pds-editor-wrap .se2_path {
    background: #2a2a2a !important;
    border-top: 1px solid #404040 !important;
    color: #a0a0a0 !important;
}

[data-theme="dark"] .pds-editor-container .se2_path *,
[data-theme="dark"] .pds-editor-wrap .se2_path *,
.dark .pds-editor-container .se2_path *,
.dark .pds-editor-wrap .se2_path * {
    color: #a0a0a0 !important;
}

/* 에디터 하단 정보 영역 - 다크 */
[data-theme="dark"] .pds-form-section .tx-editor-path,
[data-theme="dark"] .pds-editor-wrap .tx-editor-path,
.dark .pds-form-section .tx-editor-path,
.dark .pds-editor-wrap .tx-editor-path {
    background: #2a2a2a !important;
    color: #a0a0a0 !important;
    border-top: 1px solid #404040 !important;
}

/* CKEditor - 다크 */
[data-theme="dark"] .pds-editor-container .cke_wysiwyg_frame,
[data-theme="dark"] .pds-editor-container .cke_wysiwyg_div,
[data-theme="dark"] .pds-editor-container .cke_top,
[data-theme="dark"] .pds-editor-container .cke_bottom,
.dark .pds-editor-container .cke_wysiwyg_frame,
.dark .pds-editor-container .cke_wysiwyg_div,
.dark .pds-editor-container .cke_top,
.dark .pds-editor-container .cke_bottom {
    background: #1e1e1e !important;
}

[data-theme="dark"] .pds-editor-container .cke_top,
.dark .pds-editor-container .cke_top {
    border-bottom: 1px solid #404040 !important;
}

/* 스크린리더 전용 텍스트 숨김 */
.pds-editor-wrap .sound_only,
.pds-editor-container .sound_only {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
}

/* ========================================
   에디터 단축키 탭 숨기기 (상단)
   ======================================== */
.pds-editor-container .se2_tool .se2_multy_text,
.pds-editor-wrap .se2_tool .se2_multy_text,
.pds-editor-container .se2_text_tool .husky_seditor_ui_bDocument,
.pds-editor-wrap .se2_text_tool .husky_seditor_ui_bDocument,
.pds-editor-container .se2_tool ul li a[title="단축키 일람"],
.pds-editor-wrap .se2_tool ul li a[title="단축키 일람"],
.pds-editor-container .se2_text_tool .se2_view_shortcut,
.pds-editor-wrap .se2_text_tool .se2_view_shortcut,
.pds-editor-container .husky_seditor_shortcut_guide,
.pds-editor-wrap .husky_seditor_shortcut_guide {
    display: none !important;
}

/* 단축키 버튼/탭 전체 숨기기 */
.pds-editor-container .se2_tool .se2_multy,
.pds-editor-wrap .se2_tool .se2_multy {
    display: none !important;
}

/* CKEditor 단축키 버튼 숨기기 */
.pds-editor-container .cke_sc,
.pds-editor-wrap .cke_sc,
.pds-editor-container .btn_cke_sc,
.pds-editor-wrap .btn_cke_sc {
    display: none !important;
}

/* ========================================
   에디터 하단 드래그 영역/경로 영역 수정
   ======================================== */
/* 하단 경로/리사이즈 영역 - 보이지만 깔끔하게 */
.pds-editor-container .se2_resizer,
.pds-editor-wrap .se2_resizer {
    height: auto !important;
    min-height: 24px !important;
    padding: 4px 8px !important;
    background: #f8f9fa !important;
    border-top: 1px solid #e0e0e0 !important;
}

[data-theme="dark"] .pds-editor-container .se2_resizer,
[data-theme="dark"] .pds-editor-wrap .se2_resizer,
.dark .pds-editor-container .se2_resizer,
.dark .pds-editor-wrap .se2_resizer {
    background: #2a2a2a !important;
    border-top: 1px solid #404040 !important;
}

/* 하단 드래그 메시지 숨기기 */
.pds-editor-container .se2_resizer .husky_seditor_resize_notice,
.pds-editor-wrap .se2_resizer .husky_seditor_resize_notice,
.pds-editor-container .se2_resizer span,
.pds-editor-wrap .se2_resizer span {
    display: none !important;
}

/* 에디터 높이 조절 - 하단 잘림 방지 */
.pds-editor-container,
.pds-editor-wrap {
    min-height: auto !important;
    height: auto !important;
    overflow: visible !important;
}

.pds-editor-container table,
.pds-editor-wrap table {
    min-height: auto !important;
    height: auto !important;
}

/* 에디터 입력 영역 - iframe 높이 자동 조절 */
.pds-editor-container .se2_input_wysiwyg,
.pds-editor-wrap .se2_input_wysiwyg,
.pds-editor-container .husky_seditor_editing_area_container,
.pds-editor-wrap .husky_seditor_editing_area_container {
    min-height: 300px !important;
    height: auto !important;
}

/* iframe 높이 - style 속성 우선 적용되도록 */
.pds-editor-container iframe,
.pds-editor-wrap iframe {
    min-height: 300px !important;
    display: block !important;
}

/* 에디터 overflow 문제 해결 */
.pds-editor-container,
.pds-editor-wrap,
.pds-editor-container > div,
.pds-editor-container > table,
.pds-editor-wrap > div,
.pds-editor-wrap > table {
    overflow: visible !important;
}

/* 다운로드 정보 박스 */
.download-info-form {
    background: var(--bg-main);
    border-radius: 12px;
    padding: 20px;
    border: 1px solid var(--border);
}

.download-info-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.download-info-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.download-info-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-secondary);
}

.cost-type-select {
    display: flex;
    gap: 8px;
    margin-bottom: 8px;
}

.cost-type-btn {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: var(--bg-card);
    color: var(--text-secondary);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.cost-type-btn:hover {
    border-color: #10b981;
}
.cost-type-btn.active {
    background: linear-gradient(135deg, #10b981, #34d399);
    border-color: transparent;
    color: white;
}
.cost-type-btn.active.cash {
    background: linear-gradient(135deg, var(--accent), #ff6b6b);
}
.cost-type-btn.active.point {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
}

/* 광고 유무 토글 */
.ad-toggle-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: var(--bg-card);
    border-radius: 10px;
    border: 1px solid var(--border);
    margin-top: 16px;
}
.ad-toggle-label {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    flex: 1;
}
.ad-toggle-label small {
    display: block;
    font-size: 12px;
    color: var(--text-light);
    margin-top: 2px;
    font-weight: 400;
}
.ad-toggle {
    position: relative;
    width: 52px;
    height: 28px;
    background: var(--border);
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.3s;
}
.ad-toggle.active {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
}
.ad-toggle::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 22px;
    height: 22px;
    background: white;
    border-radius: 50%;
    transition: all 0.3s;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
.ad-toggle.active::after {
    left: 27px;
}
.ad-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
}
.ad-badge.has-ad {
    background: rgba(245, 158, 11, 0.15);
    color: #f59e0b;
}
.ad-badge.no-ad {
    background: rgba(16, 185, 129, 0.15);
    color: #10b981;
}

/* 자료 링크 섹션 */
.link-item {
    background: var(--bg-main);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    border: 1px solid var(--border);
}
.link-item:last-child { margin-bottom: 0; }

.link-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.link-number {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}
.link-number span {
    width: 24px;
    height: 24px;
    background: linear-gradient(135deg, #10b981, #34d399);
    color: white;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.link-fields {
    display: grid;
    grid-template-columns: 1fr 120px;
    gap: 12px;
}

.add-link-btn {
    width: 100%;
    padding: 14px;
    border: 2px dashed var(--border);
    border-radius: 12px;
    background: transparent;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
    margin-top: 12px;
}
.add-link-btn:hover {
    border-color: #10b981;
    color: #10b981;
    background: rgba(16, 185, 129, 0.05);
}
.add-link-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.add-link-btn svg { width: 18px; height: 18px; }

/* 첨부파일 - 드래그앤드롭 스타일 */
.file-upload-area {
    border: 2px dashed var(--border);
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 16px;
    background: var(--bg-main);
    position: relative;
}
.file-upload-area:hover,
.file-upload-area.dragover {
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.08);
}

.file-hidden-input {
    /* display:none이면 모바일에서 fileInput.click()이 막히는 케이스가 있어 "시각적으로만 숨김" 처리 */
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
    left: 0;
    top: 0;
}

.file-upload-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 12px;
    color: var(--text-light);
    transition: color 0.2s;
}
.file-upload-area:hover .file-upload-icon,
.file-upload-area.dragover .file-upload-icon {
    color: #10b981;
}
.file-upload-text {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}
.file-upload-hint {
    font-size: 12px;
    color: var(--text-light);
}

/* 파일 미리보기 리스트 */
.pds-file-preview-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 12px;
    margin-top: 16px;
}

.pds-file-preview-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 10px;
    overflow: hidden;
    background: var(--bg-main);
    border: 1px solid var(--border);
}

.pds-file-preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pds-file-preview-item .video-icon {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1e1e2e, #2a2a3e);
}

.pds-file-preview-item .video-icon svg {
    width: 32px;
    height: 32px;
    color: #10b981;
}

.pds-file-preview-item .preview-remove {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 24px;
    height: 24px;
    background: rgba(239, 68, 68, 0.9);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    opacity: 0;
}

.pds-file-preview-item:hover .preview-remove {
    opacity: 1;
}

.pds-file-preview-item .preview-remove:hover {
    background: #dc2626;
    transform: scale(1.1);
}

.pds-file-preview-item .preview-remove svg {
    width: 14px;
    height: 14px;
    color: white;
}

.pds-file-preview-item .preview-name {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 6px 8px;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    font-size: 10px;
    color: white;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* 기존 파일 리스트 */
.pds-existing-files {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 12px;
    margin-top: 16px;
}

.pds-existing-file-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 10px;
    overflow: hidden;
    background: var(--bg-main);
    border: 1px solid var(--border);
}

.pds-existing-file-item .pds-existing-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pds-existing-file-item .pds-existing-video {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1e1e2e, #2a2a3e);
}

.pds-existing-file-item .pds-existing-video svg {
    width: 32px;
    height: 32px;
    color: #10b981;
}

.pds-existing-file-item .pds-existing-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 6px 8px;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
}

.pds-existing-file-item .pds-existing-name {
    display: block;
    font-size: 10px;
    color: white;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.pds-existing-file-item .pds-existing-size {
    font-size: 9px;
    color: rgba(255,255,255,0.7);
}

.pds-existing-file-item .pds-existing-delete {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 24px;
    height: 24px;
    background: rgba(0,0,0,0.5);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.pds-existing-file-item .pds-existing-delete:hover {
    background: rgba(239, 68, 68, 0.9);
}

.pds-existing-file-item .pds-existing-delete input {
    display: none;
}

.pds-existing-file-item .pds-existing-delete input:checked + svg {
    color: #ef4444;
}

.pds-existing-file-item .pds-existing-delete svg {
    width: 14px;
    height: 14px;
    color: white;
}

.pds-existing-file-item.marked-delete {
    opacity: 0.4;
}

.pds-existing-file-item.marked-delete::after {
    content: '삭제 예정';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(239, 68, 68, 0.9);
    color: white;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
}

/* 옵션 그리드 */
.pds-options-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.pds-option-item {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    padding: 10px 16px;
    background: var(--bg-main);
    border-radius: 8px;
    border: 1px solid var(--border);
    transition: all 0.2s;
}

.pds-option-item:hover {
    border-color: #10b981;
}

.pds-option-item input[type="checkbox"] {
    display: none;
}

.pds-option-check {
    width: 18px;
    height: 18px;
    border: 2px solid var(--border);
    border-radius: 4px;
    position: relative;
    transition: all 0.2s;
}

.pds-option-item input:checked + .pds-option-check {
    background: linear-gradient(135deg, #10b981, #34d399);
    border-color: transparent;
}

.pds-option-item input:checked + .pds-option-check::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.pds-option-text {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary);
}

/* 버튼 영역 */
.pds-form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: var(--bg-main);
    border-top: 1px solid var(--border);
}

.pds-btn-group {
    display: flex;
    gap: 10px;
}

.pds-btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
    border: none;
    text-decoration: none;
}

.pds-btn svg { width: 16px; height: 16px; }

.pds-btn.btn-cancel {
    background: var(--bg-card);
    color: var(--text-secondary);
    border: 1px solid var(--border);
}
.pds-btn.btn-cancel:hover {
    border-color: var(--text-light);
    color: var(--text-primary);
}

.pds-btn.btn-submit {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}
.pds-btn.btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
}

/* 반응형 */
@media (max-width: 992px) {
    .download-info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .pds-form-row {
        flex-direction: column;
    }
    .pds-form-group.half {
        flex: 1;
    }
    .link-fields {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .pds-form-section { padding: 16px; }
    .download-info-grid {
        grid-template-columns: 1fr;
    }
    .pds-form-actions {
        flex-direction: column;
        gap: 12px;
    }
    .pds-btn-group {
        width: 100%;
    }
    .pds-btn-group .pds-btn {
        flex: 1;
        justify-content: center;
    }
    .pds-file-upload-item {
        flex-wrap: wrap;
    }
    .pds-file-upload-item .pds-file-desc {
        width: 100%;
    }

    /* 모바일 하단 고정 UI 고려 */
    .pds-write-form {
        margin-bottom: calc(200px + env(safe-area-inset-bottom));
    }
}
</style>

<!-- 페이지 타이틀 -->
<div class="page-title-section pds-page">
    <div class="page-title">
        <div class="page-title-icon pds-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        </div>
        <div>
            <h1><?php echo $is_edit ? '자료 수정' : '자료 등록'; ?></h1>
            <p><?php echo pds_escape($bo_subject); ?></p>
        </div>
    </div>
</div>

<!-- 글쓰기 폼 -->
<form name="fwrite" id="fwrite" action="<?php echo $action_url; ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" class="pds-write-form">

<input type="hidden" name="token" value="">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
<input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="spt" value="<?php echo $spt; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<?php
// DHTML 에디터 사용 시 html 필드를 hidden으로 전달
if ($is_html && $is_dhtml_editor) {
    echo '<input type="hidden" name="html" value="html1">';
}
?>

<!-- 기본 정보 섹션 -->
<div class="pds-form-section">
    <div class="pds-form-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
        기본 정보
    </div>

    <div class="pds-form-row">
        <?php if ($is_category) { ?>
        <div class="pds-form-group half">
            <label class="pds-form-label">분류 <span class="required">*</span></label>
            <select name="ca_name" id="ca_name" class="pds-form-select" required>
                <option value="">분류 선택</option>
                <?php echo $category_option; ?>
            </select>
        </div>
        <?php } ?>
        <div class="pds-form-group half">
            <label class="pds-form-label">파일 형식</label>
            <select name="wr_10" id="wr_10" class="pds-form-select">
                <option value="zip" <?php echo ($write['wr_10'] == 'zip') ? 'selected' : ''; ?>>ZIP (압축파일)</option>
                <option value="pdf" <?php echo ($write['wr_10'] == 'pdf') ? 'selected' : ''; ?>>PDF (문서)</option>
                <option value="doc" <?php echo ($write['wr_10'] == 'doc') ? 'selected' : ''; ?>>DOC (문서)</option>
                <option value="img" <?php echo ($write['wr_10'] == 'img') ? 'selected' : ''; ?>>IMG (이미지)</option>
                <option value="video" <?php echo ($write['wr_10'] == 'video') ? 'selected' : ''; ?>>VIDEO (동영상)</option>
            </select>
        </div>
    </div>

    <div class="pds-form-group">
        <label class="pds-form-label">제목 <span class="required">*</span></label>
        <input type="text" name="wr_subject" id="wr_subject" value="<?php echo $subject; ?>" class="pds-form-input" maxlength="255" placeholder="자료의 제목을 입력하세요" required>
    </div>
</div>

<!-- 다운로드 정보 섹션 -->
<div class="pds-form-section">
    <div class="pds-form-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        다운로드 정보
    </div>

    <div class="download-info-form">
        <div class="download-info-grid">
            <div class="download-info-item">
                <label class="download-info-label">다운로드 비용</label>
                <div class="cost-type-select">
                    <button type="button" class="cost-type-btn <?php echo (!$write['wr_1'] || $write['wr_1'] == 'free') ? 'active' : ''; ?>" data-type="free" onclick="setCostType('free', this)">무료</button>
                    <button type="button" class="cost-type-btn point <?php echo ($write['wr_1'] == 'point') ? 'active' : ''; ?>" data-type="point" onclick="setCostType('point', this)">포인트</button>
                    <button type="button" class="cost-type-btn cash <?php echo ($write['wr_1'] == 'cash') ? 'active' : ''; ?>" data-type="cash" onclick="setCostType('cash', this)">캐시</button>
                </div>
                <input type="number" class="pds-form-input" name="wr_2" id="costValueInput" placeholder="0" min="0" value="<?php echo (int)$write['wr_2']; ?>" <?php echo (!$write['wr_1'] || $write['wr_1'] == 'free') ? 'disabled' : ''; ?>>
                <input type="hidden" name="wr_1" id="costTypeInput" value="<?php echo $write['wr_1'] ?: 'free'; ?>">
            </div>
            <div class="download-info-item">
                <label class="download-info-label">파일 개수</label>
                <input type="number" class="pds-form-input" name="wr_3" placeholder="1" min="1" value="<?php echo (int)$write['wr_3'] ?: 1; ?>">
            </div>
            <div class="download-info-item">
                <label class="download-info-label">파일 용량</label>
                <input type="text" class="pds-form-input" name="wr_4" placeholder="예: 15.2MB" value="<?php echo $write['wr_4']; ?>">
            </div>
            <div class="download-info-item">
                <label class="download-info-label">재생시간 (동영상)</label>
                <input type="text" class="pds-form-input" name="wr_5" placeholder="예: 10:25:36" value="<?php echo $write['wr_5']; ?>">
                <span class="pds-form-hint">동영상인 경우에만 입력</span>
            </div>
        </div>

        <!-- 광고 유무 -->
        <div class="ad-toggle-wrap">
            <div class="ad-toggle-label">
                광고 포함 여부
                <small>다운로드 링크에 광고(링크허브 등)가 포함되어 있나요?</small>
            </div>
            <span class="ad-badge <?php echo ($write['wr_6'] == 'Y') ? 'has-ad' : 'no-ad'; ?>" id="adBadge"><?php echo ($write['wr_6'] == 'Y') ? '광고있음' : '광고없음'; ?></span>
            <div class="ad-toggle <?php echo ($write['wr_6'] == 'Y') ? 'active' : ''; ?>" id="adToggle" onclick="toggleAd()"></div>
            <input type="hidden" name="wr_6" id="hasAdInput" value="<?php echo $write['wr_6'] ?: 'N'; ?>">
        </div>
    </div>
</div>

<!-- 자료 링크 섹션 -->
<?php
// 링크 개수: 게시판 설정이 0이면 기본 2개
$link_count = $board['bo_link_count'] > 0 ? $board['bo_link_count'] : 2;
?>
<div class="pds-form-section">
    <div class="pds-form-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
        자료 링크
    </div>

    <div id="linkContainer">
        <?php for ($i = 1; $i <= $link_count; $i++) {
            $link_var = 'link'.$i;
            $link_value = isset($$link_var) ? $$link_var : '';
        ?>
        <div class="link-item" data-link-id="<?php echo $i; ?>">
            <div class="link-header">
                <div class="link-number">
                    <span><?php echo $i; ?></span>
                    링크 #<?php echo $i; ?>
                </div>
            </div>
            <div class="link-fields">
                <input type="url" class="pds-form-input" name="wr_link<?php echo $i; ?>" value="<?php echo $link_value; ?>" placeholder="https://example.com/download/file.zip">
                <input type="text" class="pds-form-input" name="wr_link<?php echo $i; ?>_name" value="" placeholder="링크명 (선택)">
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<!-- 내용 섹션 -->
<div class="pds-form-section">
    <div class="pds-form-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        내용
    </div>

    <div class="pds-editor-wrap">
        <?php if ($editor) { ?>
        <div class="pds-editor-container">
            <?php echo $editor_html; ?>
        </div>
        <?php } else { ?>
        <textarea name="wr_content" id="wr_content" class="pds-form-textarea" placeholder="자료에 대한 상세 설명을 입력하세요"><?php echo $content; ?></textarea>
        <?php } ?>
    </div>
    <span class="pds-form-hint">자료의 특징, 사용법, 주의사항 등을 자세히 작성해주세요.</span>
</div>

<!-- 첨부파일 섹션 -->
<?php if ($board['bo_upload_count'] > 0) { ?>
<div class="pds-form-section">
    <div class="pds-form-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
        첨부파일 / 미리보기 이미지
    </div>

    <div class="file-upload-area" id="pdsFileDropzone">
        <input type="file" name="bf_file[]" id="pdsFileInput" multiple accept="image/*,video/*" class="file-hidden-input">
        <svg class="file-upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        <div class="file-upload-text">클릭하거나 파일을 드래그하세요</div>
        <div class="file-upload-hint">이미지/동영상 파일을 여러 개 선택할 수 있습니다</div>
    </div>

    <!-- 업로드된 파일 미리보기 -->
    <div class="pds-file-preview-list" id="pdsFilePreviewList"></div>

    <!-- 기존 파일 (수정 시) -->
    <?php if ($is_edit) { ?>
    <div class="pds-existing-files" id="pdsExistingFiles">
        <?php for ($i = 0; $i < $board['bo_upload_count']; $i++) {
            if (isset($file[$i]['file']) && $file[$i]['file']) {
                $file_ext = strtolower(pathinfo($file[$i]['source'], PATHINFO_EXTENSION));
                $is_image_file = in_array($file_ext, array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'));
                $is_video_file = in_array($file_ext, array('mp4', 'webm', 'avi', 'mov', 'mkv'));
        ?>
        <div class="pds-existing-file-item" data-index="<?php echo $i; ?>">
            <?php if ($is_image_file) { ?>
            <img src="<?php echo G5_DATA_URL; ?>/file/<?php echo $bo_table; ?>/<?php echo $file[$i]['file']; ?>" alt="<?php echo pds_escape($file[$i]['source']); ?>" class="pds-existing-thumb">
            <?php } elseif ($is_video_file) { ?>
            <div class="pds-existing-video">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5,3 19,12 5,21 5,3"/></svg>
            </div>
            <?php } ?>
            <div class="pds-existing-info">
                <span class="pds-existing-name"><?php echo $file[$i]['source']; ?></span>
                <span class="pds-existing-size"><?php echo pds_file_size($file[$i]['size']); ?></span>
            </div>
            <label class="pds-existing-delete">
                <input type="checkbox" name="bf_file_del[<?php echo $i; ?>]" value="1">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </label>
        </div>
        <?php }
        } ?>
    </div>
    <?php } ?>
</div>
<?php } ?>

<!-- 옵션 섹션 -->
<div class="pds-form-section">
    <div class="pds-form-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
        옵션
    </div>

    <div class="pds-options-grid">
        <?php if ($board['bo_use_secret'] && $is_member) { ?>
        <label class="pds-option-item">
            <input type="checkbox" name="secret" value="secret" <?php echo $secret_checked; ?>>
            <span class="pds-option-check"></span>
            <span class="pds-option-text">비밀글</span>
        </label>
        <?php } ?>

        <?php if ($is_notice) { ?>
        <label class="pds-option-item">
            <input type="checkbox" name="notice" value="1" <?php echo $notice_checked; ?>>
            <span class="pds-option-check"></span>
            <span class="pds-option-text">공지글</span>
        </label>
        <?php } ?>

        <?php if ($is_html) { ?>
        <label class="pds-option-item">
            <input type="checkbox" name="html" value="html1" <?php echo $html_checked; ?>>
            <span class="pds-option-check"></span>
            <span class="pds-option-text">HTML 사용</span>
        </label>
        <?php } ?>

        <?php if ($board['bo_use_email'] && $is_member) { ?>
        <label class="pds-option-item">
            <input type="checkbox" name="mail" value="mail" <?php echo $recv_email_checked; ?>>
            <span class="pds-option-check"></span>
            <span class="pds-option-text">답변 메일 수신</span>
        </label>
        <?php } ?>
    </div>
</div>

<!-- 비회원 정보 -->
<?php if (!$is_member) { ?>
<div class="pds-form-section">
    <div class="pds-form-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        작성자 정보
    </div>

    <div class="pds-form-row">
        <div class="pds-form-group half">
            <label class="pds-form-label">이름 <span class="required">*</span></label>
            <input type="text" name="wr_name" id="wr_name" value="<?php echo $name; ?>" class="pds-form-input" maxlength="20" required>
        </div>
        <div class="pds-form-group half">
            <label class="pds-form-label">비밀번호 <span class="required">*</span></label>
            <input type="password" name="wr_password" id="wr_password" class="pds-form-input" maxlength="20" required>
        </div>
    </div>

    <?php if ($board['bo_use_email']) { ?>
    <div class="pds-form-group">
        <label class="pds-form-label">이메일</label>
        <input type="email" name="wr_email" id="wr_email" value="<?php echo $email; ?>" class="pds-form-input" maxlength="100">
    </div>
    <?php } ?>

    <?php if ($board['bo_use_homepage']) { ?>
    <div class="pds-form-group">
        <label class="pds-form-label">홈페이지</label>
        <input type="url" name="wr_homepage" id="wr_homepage" value="<?php echo $homepage; ?>" class="pds-form-input" maxlength="255" placeholder="https://">
    </div>
    <?php } ?>
</div>
<?php } ?>

<!-- 버튼 영역 -->
<div class="pds-form-actions">
    <a href="<?php echo $list_href; ?>" class="pds-btn btn-cancel">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12,19 5,12 12,5"/></svg>
        취소
    </a>
    <div class="pds-btn-group">
        <button type="submit" class="pds-btn btn-submit" id="btn_submit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            <?php echo $is_edit ? '수정하기' : '등록하기'; ?>
        </button>
    </div>
</div>

</form>

<script>
// 다운로드 비용 타입 설정
function setCostType(type, btn) {
    document.querySelectorAll('.cost-type-btn').forEach(function(b) {
        b.classList.remove('active');
    });
    btn.classList.add('active');
    document.getElementById('costTypeInput').value = type;

    var costInput = document.getElementById('costValueInput');
    if (type === 'free') {
        costInput.value = 0;
        costInput.disabled = true;
    } else {
        costInput.disabled = false;
        costInput.focus();
    }
}

// 광고 유무 토글
function toggleAd() {
    var toggle = document.getElementById('adToggle');
    var badge = document.getElementById('adBadge');
    var input = document.getElementById('hasAdInput');

    toggle.classList.toggle('active');
    var hasAd = toggle.classList.contains('active');

    input.value = hasAd ? 'Y' : 'N';
    badge.textContent = hasAd ? '광고있음' : '광고없음';
    badge.className = hasAd ? 'ad-badge has-ad' : 'ad-badge no-ad';
}

// 폼 제출 검증
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

    document.getElementById('btn_submit').disabled = true;
    return true;
}

// 다크모드 감지 및 에디터 iframe 내부 스타일 주입
(function() {
    function isDarkMode() {
        var html = document.documentElement;
        var body = document.body;
        var htmlTheme = html ? html.getAttribute('data-theme') : null;
        var bodyTheme = body ? body.getAttribute('data-theme') : null;

        return htmlTheme === 'dark' ||
               bodyTheme === 'dark' ||
               (body && body.classList.contains('dark')) ||
               (html && html.classList.contains('dark'));
    }

    function applyEditorTheme() {
        var isDark = isDarkMode();
        var iframes = document.querySelectorAll('.pds-editor-container iframe, .pds-editor-wrap iframe');

        iframes.forEach(function(iframe) {
            try {
                var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                if (iframeDoc && iframeDoc.body) {
                    // 에디터 내부 요소가 자체 색상 지정하는 케이스가 있어 style 태그로 강제 적용
                    var head = iframeDoc.head || iframeDoc.getElementsByTagName('head')[0];
                    if (head) {
                        var styleEl = iframeDoc.getElementById('pds-editor-theme-style');
                        if (!styleEl) {
                            styleEl = iframeDoc.createElement('style');
                            styleEl.id = 'pds-editor-theme-style';
                            head.appendChild(styleEl);
                        }
                        styleEl.textContent = isDark
                            ? 'html,body{background:#1e1e1e !important;color:#f0f0f0 !important;}body, p, div, span, li, td, th{color:#f0f0f0 !important;}a{color:#93c5fd !important;}'
                            : 'html,body{background:#ffffff !important;color:#111827 !important;}body, p, div, span, li, td, th{color:#111827 !important;}a{color:#2563eb !important;}';
                    }
                    if (isDark) {
                        iframeDoc.body.style.backgroundColor = '#1e1e1e';
                        iframeDoc.body.style.color = '#f0f0f0';
                    } else {
                        iframeDoc.body.style.backgroundColor = '#ffffff';
                        iframeDoc.body.style.color = '#333333';
                    }
                    iframeDoc.body.style.margin = '10px';
                    iframeDoc.body.style.fontFamily = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
                    iframeDoc.body.style.fontSize = '14px';
                    iframeDoc.body.style.lineHeight = '1.6';

                    // 드래그 메시지 및 하단 영역 숨기기
                    var resizeNotice = iframeDoc.querySelector('.husky_seditor_resize_notice');
                    if (resizeNotice) {
                        resizeNotice.style.display = 'none';
                    }

                    // 하단 "입력창 크기 조절" 및 Editor/HTML/TEXT 탭 숨기기
                    var conversionMode = iframeDoc.querySelector('.se2_conversion_mode');
                    if (conversionMode) {
                        conversionMode.style.display = 'none';
                    }

                    var inputareaController = iframeDoc.querySelector('.se2_inputarea_controller');
                    if (inputareaController) {
                        inputareaController.style.display = 'none';
                    }
                }
            } catch(e) {
                // cross-origin 에러 무시
            }
        });
    }

    // 페이지 로드 후 실행
    function init() {
        // 초기 적용
        setTimeout(applyEditorTheme, 500);
        setTimeout(applyEditorTheme, 1000);
        setTimeout(applyEditorTheme, 2000);
        setTimeout(applyEditorTheme, 4000);

        // SmartEditor2 iframe이 늦게 생기는 케이스가 있어 초반엔 폴링으로 강제 적용
        var tries = 0;
        var t = setInterval(function() {
            tries++;
            applyEditorTheme();
            if (tries >= 24) clearInterval(t); // 약 12초
        }, 500);

        // 테마 변경 감지 (MutationObserver)
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'data-theme' || mutation.attributeName === 'class') {
                    applyEditorTheme();
                }
            });
        });

        observer.observe(document.documentElement, { attributes: true });
        observer.observe(document.body, { attributes: true });

        // iframe 로드 이벤트 (동적으로 생성되는 iframe 포함)
        function bindIframeLoad() {
            document.querySelectorAll('.pds-editor-container iframe, .pds-editor-wrap iframe').forEach(function(iframe) {
                if (iframe.__pdsThemeBound) return;
                iframe.__pdsThemeBound = true;
                iframe.addEventListener('load', applyEditorTheme);
            });
        }
        bindIframeLoad();
        setInterval(bindIframeLoad, 1000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

// 파일 업로드 관리 (전역 변수)
var pdsSelectedFiles = [];
var pdsPreviewList, pdsFileInput, pdsDropzone;

// 파일 추가 함수
function addPdsFiles(files) {
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        // 이미지/동영상만 허용
        if (!file.type.startsWith('image/') && !file.type.startsWith('video/')) {
            continue;
        }
        pdsSelectedFiles.push(file);
        createPdsPreview(file, pdsSelectedFiles.length - 1);
    }
    updatePdsFileInput();
}

// 미리보기 생성
function createPdsPreview(file, index) {
    var item = document.createElement('div');
    item.className = 'pds-file-preview-item';
    item.dataset.index = index;

    if (file.type.startsWith('image/')) {
        var reader = new FileReader();
        reader.onload = function(e) {
            item.innerHTML = '<img src="' + e.target.result + '" alt="미리보기">' +
                '<button type="button" class="preview-remove" onclick="removePdsFile(' + index + ')">' +
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
                '<div class="preview-name">' + file.name + '</div>';
        };
        reader.readAsDataURL(file);
    } else if (file.type.startsWith('video/')) {
        item.innerHTML = '<div class="video-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5,3 19,12 5,21 5,3"/></svg></div>' +
            '<button type="button" class="preview-remove" onclick="removePdsFile(' + index + ')">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
            '<div class="preview-name">' + file.name + '</div>';
    }

    pdsPreviewList.appendChild(item);
}

// 파일 제거
function removePdsFile(index) {
    pdsSelectedFiles[index] = null;
    var item = pdsPreviewList.querySelector('[data-index="' + index + '"]');
    if (item) item.remove();
    updatePdsFileInput();
}

// input 파일 목록 업데이트
function updatePdsFileInput() {
    // 일부 브라우저(iOS Safari 등)에서 DataTransfer() 생성이 안되는 케이스 fallback
    var dt = null;
    try { dt = new DataTransfer(); } catch (e) { dt = null; }

    if (!dt) {
        // 최소 보장: native file input에 담긴 파일은 그대로 제출되도록 둠
        return;
    }

    pdsSelectedFiles.forEach(function(file) {
        if (file) dt.items.add(file);
    });
    pdsFileInput.files = dt.files;
}

// 파일 업로드 초기화 (DOM 로드 후 실행)
function initPdsFileUpload() {
    pdsPreviewList = document.getElementById('pdsFilePreviewList');
    pdsFileInput = document.getElementById('pdsFileInput');
    pdsDropzone = document.getElementById('pdsFileDropzone');

    if (!pdsDropzone || !pdsFileInput) return;
    if (!pdsPreviewList) return;

    // 클릭 이벤트
    pdsDropzone.addEventListener('click', function(e) {
        if (e.target === pdsFileInput) return;
        pdsFileInput.click();
    });

    // 파일 선택 이벤트
    pdsFileInput.addEventListener('change', function() {
        addPdsFiles(this.files);
    });

    // 드래그 오버
    pdsDropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('dragover');
    });

    // 드래그 리브
    pdsDropzone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
    });

    // 드롭
    pdsDropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
        addPdsFiles(e.dataTransfer.files);
    });
}

// DOM 로드 후 파일 업로드 초기화
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPdsFileUpload);
} else {
    initPdsFileUpload();
}

// 기존 파일 삭제 토글
document.querySelectorAll('.pds-existing-delete input').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var item = this.closest('.pds-existing-file-item');
        if (this.checked) {
            item.classList.add('marked-delete');
        } else {
            item.classList.remove('marked-delete');
        }
    });
});
</script>
