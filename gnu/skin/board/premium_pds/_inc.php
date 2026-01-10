<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium PDS 스킨 공통 함수 (자료실)
 */

// CSS 로드 (모든 스타일은 premium.css 하나로 통합)
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/premium.css">', 0);

/**
 * 시간 차이를 상대적 표현으로 변환
 */
function pds_time_ago($datetime) {
    $now = time();
    $time = strtotime($datetime);
    $diff = $now - $time;

    if ($diff < 60) {
        return '방금 전';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . '분 전';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . '시간 전';
    } elseif ($diff < 604800) {
        return floor($diff / 86400) . '일 전';
    } else {
        return date('m-d', $time);
    }
}

/**
 * 파일 크기를 읽기 쉬운 형식으로 변환
 */
function pds_file_size($bytes) {
    $bytes = (int)$bytes;
    if ($bytes >= 1073741824) {
        return round($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return round($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return round($bytes / 1024, 2) . ' KB';
    }
    return $bytes . ' B';
}

/**
 * XSS 방지 출력
 */
function pds_escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * 새글 여부 확인
 */
function pds_is_new($datetime, $hours = 24) {
    return (time() - strtotime($datetime)) < ($hours * 3600);
}

/**
 * 핫글 여부 확인
 */
function pds_is_hot($comment_cnt, $threshold = 10) {
    return (int)$comment_cnt >= $threshold;
}

/**
 * 파일 확장자에 따른 아이콘 클래스 반환
 */
function pds_file_icon_class($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $icons = array(
        // 압축 파일
        'zip' => 'zip', 'rar' => 'zip', '7z' => 'zip', 'tar' => 'zip', 'gz' => 'zip',
        // PDF
        'pdf' => 'pdf',
        // 문서
        'doc' => 'doc', 'docx' => 'doc', 'hwp' => 'doc', 'txt' => 'doc', 'rtf' => 'doc',
        'xls' => 'doc', 'xlsx' => 'doc', 'ppt' => 'doc', 'pptx' => 'doc',
        // 이미지
        'jpg' => 'img', 'jpeg' => 'img', 'png' => 'img', 'gif' => 'img', 'bmp' => 'img', 'webp' => 'img',
        // 동영상
        'mp4' => 'video', 'avi' => 'video', 'mkv' => 'video', 'mov' => 'video', 'wmv' => 'video',
        // 음악
        'mp3' => 'music', 'wav' => 'music', 'flac' => 'music', 'ogg' => 'music',
    );

    return isset($icons[$ext]) ? $icons[$ext] : 'zip';
}

/**
 * 파일 아이콘 SVG 반환
 */
function pds_file_icon_svg($type) {
    $icons = array(
        'zip' => '<svg class="file-icon zip" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8v13H3V3h12l6 5z"/><path d="M10 12h4"/><path d="M10 15h4"/><path d="M10 9h4"/></svg>',
        'pdf' => '<svg class="file-icon pdf" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
        'doc' => '<svg class="file-icon doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10,9 9,9 8,9"/></svg>',
        'img' => '<svg class="file-icon img" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg>',
        'video' => '<svg class="file-icon video" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23,7 16,12 23,17 23,7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>',
        'music' => '<svg class="file-icon music" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>',
    );

    return isset($icons[$type]) ? $icons[$type] : $icons['zip'];
}

/**
 * 카테고리 클래스 반환
 */
function pds_category_class($category) {
    $classes = array(
        '프로그램' => 'program',
        '문서' => 'document',
        '이미지' => 'image',
        '동영상' => 'video',
        '음악' => 'music',
        '공지' => 'notice',
    );
    return isset($classes[$category]) ? $classes[$category] : '';
}

/**
 * 이미지 있는 글 확인
 */
function pds_has_image($write) {
    global $board;
    $file = get_file($board['bo_table'], $write['wr_id']);
    if ($file['count'] > 0) {
        foreach ($file as $key => $val) {
            if (is_numeric($key) && isset($val['source']) && preg_match('/\.(gif|jpe?g|png|webp|bmp)$/i', $val['source'])) {
                return true;
            }
        }
    }
    if (preg_match('/<img[^>]+>/i', $write['wr_content'])) {
        return true;
    }
    return false;
}

/**
 * 첫 번째 첨부파일 정보 가져오기
 */
function pds_get_first_file($bo_table, $wr_id) {
    $file = get_file($bo_table, $wr_id);
    if ($file['count'] > 0) {
        foreach ($file as $key => $val) {
            if (is_numeric($key)) {
                return array(
                    'source' => $val['source'],
                    'size' => $val['size'],
                    'download' => $val['download'],
                );
            }
        }
    }
    return null;
}

/**
 * 총 첨부파일 크기 계산
 */
function pds_get_total_file_size($bo_table, $wr_id) {
    $file = get_file($bo_table, $wr_id);
    $total = 0;
    if ($file['count'] > 0) {
        foreach ($file as $key => $val) {
            if (is_numeric($key) && isset($val['size'])) {
                $total += (int)$val['size'];
            }
        }
    }
    return $total;
}

/**
 * 기간별 베스트 게시글 조회
 */
function pds_get_best_posts($write_table, $period = 'daily', $limit = 10) {
    $date_condition = '';
    switch($period) {
        case 'daily':
            $date_condition = "AND wr_datetime >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
            break;
        case 'weekly':
            $date_condition = "AND wr_datetime >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            break;
        case 'monthly':
            $date_condition = "AND wr_datetime >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            break;
    }

    $sql = "SELECT * FROM {$write_table}
            WHERE wr_is_comment = 0 AND wr_good >= 1 {$date_condition}
            ORDER BY wr_good DESC, wr_id DESC
            LIMIT {$limit}";
    $result = sql_query($sql);
    $posts = array();
    while ($row = sql_fetch_array($result)) {
        $posts[] = $row;
    }
    return $posts;
}

/**
 * 썸네일 URL 가져오기
 */
function pds_get_thumbnail($bo_table, $wr_id, $width = 200, $height = 150) {
    $thumb = get_list_thumbnail($bo_table, $wr_id, $width, $height);
    if ($thumb['src']) {
        return $thumb['src'];
    }
    return '';
}
