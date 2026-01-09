<?php $current_page = 'pds'; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <script>document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'light');</script>
    <?php include 'includes/head.php'; ?>
    <title>자료 등록 - 자료실</title>
    <style>
        .main-content { padding: 20px; }

        /* 브레드크럼 */
        .breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--text-secondary);
            margin-bottom: 20px;
        }
        .breadcrumb a { color: var(--text-secondary); text-decoration: none; }
        .breadcrumb a:hover { color: var(--text-primary); }
        .breadcrumb svg { width: 14px; height: 14px; }

        /* 페이지 타이틀 */
        .page-title-section {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 24px;
        }
        .page-title-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        .page-title-icon svg { width: 24px; height: 24px; color: white; }
        .page-title h1 { font-size: 24px; font-weight: 700; }
        .page-title p { font-size: 13px; color: var(--text-secondary); margin-top: 2px; }

        /* 글쓰기 폼 */
        .write-form {
            background: var(--bg-card);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .form-section {
            padding: 24px;
            border-bottom: 1px solid var(--border);
        }
        .form-section:last-child { border-bottom: none; }

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
            color: #10b981;
        }

        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }
        .form-row:last-child { margin-bottom: 0; }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .form-group.half { flex: 0 0 calc(50% - 8px); }
        .form-group.third { flex: 0 0 calc(33.333% - 11px); }
        .form-group.quarter { flex: 0 0 calc(25% - 12px); }

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
            font-size: 14px;
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
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }
        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--text-light);
        }

        .form-textarea {
            min-height: 300px;
            resize: vertical;
            line-height: 1.6;
        }

        .form-hint {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 4px;
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
            background: var(--bg-main);
            border-radius: 10px;
            border: 1px solid var(--border);
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

        .link-remove {
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 6px;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .link-remove:hover {
            background: #ef4444;
            color: white;
        }
        .link-remove svg { width: 16px; height: 16px; }

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

        /* 첨부파일 */
        .file-upload-area {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .file-upload-area:hover {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.05);
        }
        .file-upload-area.dragover {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .file-upload-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            color: var(--text-light);
        }
        .file-upload-text {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 4px;
        }
        .file-upload-hint {
            font-size: 12px;
            color: var(--text-light);
        }

        .file-list {
            margin-top: 16px;
        }
        .file-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: var(--bg-main);
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .file-item:last-child { margin-bottom: 0; }

        .file-icon {
            width: 36px;
            height: 36px;
            background: var(--bg-card);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
        }
        .file-icon svg { width: 18px; height: 18px; }

        .file-info { flex: 1; min-width: 0; }
        .file-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .file-size {
            font-size: 11px;
            color: var(--text-light);
            margin-top: 2px;
        }

        .file-remove {
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 6px;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .file-remove:hover {
            background: #ef4444;
            color: white;
        }
        .file-remove svg { width: 14px; height: 14px; }

        /* 버튼 영역 */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            background: var(--bg-main);
            border-top: 1px solid var(--border);
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
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
        }

        .btn-cancel {
            background: var(--bg-card);
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }
        .btn-cancel:hover {
            border-color: var(--text-light);
            color: var(--text-primary);
        }

        .btn-draft {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
        }
        .btn-draft:hover {
            background: rgba(99, 102, 241, 0.2);
        }

        .btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }

        .btn svg { width: 16px; height: 16px; }

        /* 반응형 */
        @media (max-width: 992px) {
            .download-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .form-row {
                flex-direction: column;
            }
            .form-group.half,
            .form-group.third,
            .form-group.quarter {
                flex: 1;
            }
        }

        @media (max-width: 768px) {
            .page-title-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .page-title-icon { width: 40px; height: 40px; border-radius: 10px; }
            .page-title-icon svg { width: 20px; height: 20px; }
            .page-title h1 { font-size: 18px; }

            .form-section { padding: 16px; }

            .download-info-grid {
                grid-template-columns: 1fr;
            }

            .link-fields {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
                gap: 12px;
            }
            .btn-group {
                width: 100%;
            }
            .btn-group .btn {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-wrapper">
        <?php include 'includes/header.php'; ?>

        <main class="main-content">
            <!-- 브레드크럼 -->
            <div class="breadcrumb">
                <a href="index.php">홈</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                <a href="pds.php">자료실</a>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>
                <span>자료 등록</span>
            </div>

            <!-- 페이지 타이틀 -->
            <div class="page-title-section">
                <div class="page-title-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                </div>
                <div class="page-title">
                    <h1>자료 등록</h1>
                    <p>유용한 자료를 공유해주세요</p>
                </div>
            </div>

            <!-- 글쓰기 폼 -->
            <form class="write-form" id="writeForm" onsubmit="submitForm(event)">
                <!-- 기본 정보 -->
                <div class="form-section">
                    <div class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                        기본 정보
                    </div>

                    <div class="form-row">
                        <div class="form-group half">
                            <label class="form-label">분류 <span class="required">*</span></label>
                            <select class="form-select" name="category" required>
                                <option value="">분류 선택</option>
                                <option value="프로그램">프로그램</option>
                                <option value="문서">문서</option>
                                <option value="이미지">이미지</option>
                                <option value="동영상">동영상</option>
                                <option value="음악">음악</option>
                                <option value="기타">기타</option>
                            </select>
                        </div>
                        <div class="form-group half">
                            <label class="form-label">파일 형식</label>
                            <select class="form-select" name="fileType">
                                <option value="zip">ZIP (압축파일)</option>
                                <option value="pdf">PDF (문서)</option>
                                <option value="doc">DOC (문서)</option>
                                <option value="img">IMG (이미지)</option>
                                <option value="video">VIDEO (동영상)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">제목 <span class="required">*</span></label>
                        <input type="text" class="form-input" name="title" placeholder="자료의 제목을 입력하세요" required>
                    </div>
                </div>

                <!-- 다운로드 정보 -->
                <div class="form-section">
                    <div class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        다운로드 정보
                    </div>

                    <div class="download-info-form">
                        <div class="download-info-grid">
                            <div class="download-info-item">
                                <label class="download-info-label">다운로드 비용</label>
                                <div class="cost-type-select">
                                    <button type="button" class="cost-type-btn active" data-type="free" onclick="setCostType('free', this)">무료</button>
                                    <button type="button" class="cost-type-btn point" data-type="point" onclick="setCostType('point', this)">포인트</button>
                                    <button type="button" class="cost-type-btn cash" data-type="cash" onclick="setCostType('cash', this)">캐시</button>
                                </div>
                                <input type="number" class="form-input" name="costValue" placeholder="0" min="0" value="0" id="costValueInput" disabled>
                                <input type="hidden" name="costType" value="free" id="costTypeInput">
                            </div>
                            <div class="download-info-item">
                                <label class="download-info-label">파일 개수</label>
                                <input type="number" class="form-input" name="fileCount" placeholder="1" min="1" value="1">
                            </div>
                            <div class="download-info-item">
                                <label class="download-info-label">파일 용량</label>
                                <input type="text" class="form-input" name="fileSize" placeholder="예: 15.2MB">
                            </div>
                            <div class="download-info-item">
                                <label class="download-info-label">재생시간 (동영상)</label>
                                <input type="text" class="form-input" name="duration" placeholder="예: 10:25:36">
                                <span class="form-hint">동영상인 경우에만 입력</span>
                            </div>
                        </div>

                        <!-- 광고 유무 -->
                        <div class="ad-toggle-wrap" style="margin-top: 16px; grid-column: 1 / -1;">
                            <div class="ad-toggle-label">
                                광고 포함 여부
                                <small>다운로드 링크에 광고(링크허브 등)가 포함되어 있나요?</small>
                            </div>
                            <span class="ad-badge no-ad" id="adBadge">광고없음</span>
                            <div class="ad-toggle" id="adToggle" onclick="toggleAd()"></div>
                            <input type="hidden" name="hasAd" value="false" id="hasAdInput">
                        </div>
                    </div>
                </div>

                <!-- 자료 링크 -->
                <div class="form-section">
                    <div class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
                        자료 링크
                    </div>

                    <div id="linkContainer">
                        <div class="link-item" data-link-id="1">
                            <div class="link-header">
                                <div class="link-number">
                                    <span>1</span>
                                    링크 #1
                                </div>
                            </div>
                            <div class="link-fields">
                                <input type="url" class="form-input" name="link1_url" placeholder="https://example.com/download/file.zip">
                                <input type="text" class="form-input" name="link1_name" placeholder="링크명 (선택)">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-link-btn" id="addLinkBtn" onclick="addLink()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        링크 추가 (최대 2개)
                    </button>
                </div>

                <!-- 내용 -->
                <div class="form-section">
                    <div class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        내용
                    </div>

                    <div class="form-group">
                        <textarea class="form-textarea" name="content" placeholder="자료에 대한 상세 설명을 입력하세요. HTML 태그 사용이 가능합니다."></textarea>
                        <span class="form-hint">자료의 특징, 사용법, 주의사항 등을 자세히 작성해주세요.</span>
                    </div>
                </div>

                <!-- 첨부파일 (썸네일/미리보기 이미지) -->
                <div class="form-section">
                    <div class="form-section-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
                        미리보기 이미지 (선택)
                    </div>

                    <div class="file-upload-area" id="fileUploadArea" onclick="document.getElementById('fileInput').click()">
                        <input type="file" id="fileInput" name="thumbnail" accept="image/*" style="display: none" onchange="handleFileSelect(event)">
                        <svg class="file-upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <div class="file-upload-text">클릭하여 이미지를 선택하세요</div>
                        <div class="file-upload-hint">JPG, PNG, GIF (최대 5MB)</div>
                    </div>

                    <div class="file-list" id="fileList" style="display: none;"></div>
                </div>

                <!-- 버튼 영역 -->
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="history.back()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12,19 5,12 12,5"/></svg>
                        취소
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-draft" onclick="saveDraft()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17,21 17,13 7,13 7,21"/><polyline points="7,3 7,8 15,8"/></svg>
                            임시저장
                        </button>
                        <button type="submit" class="btn btn-submit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            등록하기
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <?php include 'includes/popup.php'; ?>
    <?php include 'includes/footer.php'; ?>

    <script>
        let linkCount = 1;
        const maxLinks = 2;

        // 다운로드 비용 타입 설정
        function setCostType(type, btn) {
            document.querySelectorAll('.cost-type-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('costTypeInput').value = type;

            const costInput = document.getElementById('costValueInput');
            if (type === 'free') {
                costInput.value = 0;
                costInput.disabled = true;
            } else {
                costInput.disabled = false;
                costInput.focus();
            }
        }

        // 링크 추가
        function addLink() {
            if (linkCount >= maxLinks) return;

            linkCount++;
            const container = document.getElementById('linkContainer');
            const linkItem = document.createElement('div');
            linkItem.className = 'link-item';
            linkItem.setAttribute('data-link-id', linkCount);
            linkItem.innerHTML = `
                <div class="link-header">
                    <div class="link-number">
                        <span>${linkCount}</span>
                        링크 #${linkCount}
                    </div>
                    <button type="button" class="link-remove" onclick="removeLink(${linkCount})">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                <div class="link-fields">
                    <input type="url" class="form-input" name="link${linkCount}_url" placeholder="https://example.com/download/file.zip">
                    <input type="text" class="form-input" name="link${linkCount}_name" placeholder="링크명 (선택)">
                </div>
            `;
            container.appendChild(linkItem);

            if (linkCount >= maxLinks) {
                document.getElementById('addLinkBtn').disabled = true;
            }
        }

        // 링크 삭제
        function removeLink(id) {
            const linkItem = document.querySelector(`.link-item[data-link-id="${id}"]`);
            if (linkItem) {
                linkItem.remove();
                linkCount--;
                document.getElementById('addLinkBtn').disabled = false;
            }
        }

        // 광고 유무 토글
        function toggleAd() {
            const toggle = document.getElementById('adToggle');
            const badge = document.getElementById('adBadge');
            const input = document.getElementById('hasAdInput');

            toggle.classList.toggle('active');
            const hasAd = toggle.classList.contains('active');

            input.value = hasAd ? 'true' : 'false';
            badge.textContent = hasAd ? '광고있음' : '광고없음';
            badge.className = hasAd ? 'ad-badge has-ad' : 'ad-badge no-ad';
        }

        // 파일 선택 처리
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (file.size > 5 * 1024 * 1024) {
                alert('파일 크기는 5MB 이하여야 합니다.');
                return;
            }

            const fileList = document.getElementById('fileList');
            fileList.style.display = 'block';
            fileList.innerHTML = `
                <div class="file-item">
                    <div class="file-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>
                    </div>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${formatFileSize(file.size)}</div>
                    </div>
                    <button type="button" class="file-remove" onclick="removeFile()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            `;
        }

        // 파일 삭제
        function removeFile() {
            document.getElementById('fileInput').value = '';
            document.getElementById('fileList').style.display = 'none';
            document.getElementById('fileList').innerHTML = '';
        }

        // 파일 크기 포맷
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // 드래그 앤 드롭
        const uploadArea = document.getElementById('fileUploadArea');
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                document.getElementById('fileInput').files = e.dataTransfer.files;
                handleFileSelect({ target: { files: [file] } });
            }
        });

        // 임시저장
        function saveDraft() {
            const formData = new FormData(document.getElementById('writeForm'));
            const data = {};
            formData.forEach((value, key) => data[key] = value);
            localStorage.setItem('pds_draft', JSON.stringify(data));
            alert('임시저장되었습니다.');
        }

        // 임시저장 불러오기
        function loadDraft() {
            const draft = localStorage.getItem('pds_draft');
            if (draft) {
                const data = JSON.parse(draft);
                Object.keys(data).forEach(key => {
                    const input = document.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = data[key];
                    }
                });
            }
        }

        // 폼 제출
        function submitForm(event) {
            event.preventDefault();

            // 유효성 검사
            const form = document.getElementById('writeForm');
            const category = form.querySelector('[name="category"]').value;
            const title = form.querySelector('[name="title"]').value;

            if (!category) {
                alert('분류를 선택해주세요.');
                return;
            }
            if (!title.trim()) {
                alert('제목을 입력해주세요.');
                return;
            }

            // 실제 서버로 전송 (데모용 alert)
            alert('자료가 등록되었습니다.\n\n실제 서버에서는 데이터베이스에 저장됩니다.');
            localStorage.removeItem('pds_draft');
            location.href = 'pds.php';
        }

        // 페이지 로드 시 임시저장 확인
        window.addEventListener('DOMContentLoaded', () => {
            const draft = localStorage.getItem('pds_draft');
            if (draft) {
                if (confirm('임시저장된 글이 있습니다. 불러오시겠습니까?')) {
                    loadDraft();
                }
            }
        });
    </script>
</body>
</html>
