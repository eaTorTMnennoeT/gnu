<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium 스킨 공통 함수
 */

// 썸네일 라이브러리 로드
if (!function_exists('get_list_thumbnail')) {
    include_once(G5_LIB_PATH.'/thumbnail.lib.php');
}

// CSS 로드 (모든 스타일은 premium.css 하나로 통합)
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/premium.css">', 0);

/**
 * 시간 차이를 상대적 표현으로 변환
 * @param string $datetime 날짜/시간 문자열
 * @return string 상대적 시간 표현
 */
function premium_time_ago($datetime) {
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
 * 숫자를 K, M 형식으로 포맷
 * @param int $num 숫자
 * @return string 포맷된 문자열
 */
function premium_number_format($num) {
    $num = (int)$num;
    if ($num >= 1000000) {
        return round($num / 1000000, 1) . 'M';
    } elseif ($num >= 1000) {
        return round($num / 1000, 1) . 'K';
    }
    return number_format($num);
}

/**
 * 카테고리 색상 클래스 반환
 * @param string $category 카테고리명
 * @return string CSS 클래스
 */
function premium_category_class($category) {
    $classes = [
        '공지' => 'notice',
        '일반' => 'normal',
        '질문' => 'question',
        '정보' => 'info',
        '일상' => 'daily',
        '유머' => 'humor'
    ];
    return isset($classes[$category]) ? $classes[$category] : 'normal';
}

/**
 * 파일 크기를 읽기 쉬운 형식으로 변환
 * @param int $bytes 바이트
 * @return string 포맷된 크기
 */
function premium_file_size($bytes) {
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
 * @param string $str 문자열
 * @return string 이스케이프된 문자열
 */
function premium_escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * 새글 여부 확인
 * @param string $datetime 작성일시
 * @param int $hours 시간 (기본 24시간)
 * @return bool 새글 여부
 */
function premium_is_new($datetime, $hours = 24) {
    return (time() - strtotime($datetime)) < ($hours * 3600);
}

/**
 * 핫글 여부 확인 (댓글 수 기준)
 * @param int $comment_cnt 댓글 수
 * @param int $threshold 기준값 (기본 10)
 * @return bool 핫글 여부
 */
function premium_is_hot($comment_cnt, $threshold = 10) {
    return (int)$comment_cnt >= $threshold;
}

/**
 * 이미지 있는 글 확인
 * @param array $write 게시글 데이터
 * @return bool 이미지 포함 여부
 */
function premium_has_image($write) {
    global $board;
    $bo_table = $board['bo_table'];
    $wr_id = $write['wr_id'];

    // 첨부파일 이미지 확인
    $file = get_file($bo_table, $wr_id);
    if ($file['count'] > 0) {
        foreach ($file as $key => $val) {
            if (is_numeric($key) && isset($val['source']) && preg_match('/\.(gif|jpe?g|png|webp|bmp)$/i', $val['source'])) {
                return true;
            }
        }
    }

    // 목록에서 wr_content가 비어있을 수 있으므로 DB 조회
    $content = $write['wr_content'];
    if (empty($content)) {
        $row = get_write($bo_table, $wr_id);
        $content = $row['wr_content'];
    }

    // 본문 이미지 태그 확인
    if ($content && preg_match('/<img[^>]+>/i', $content)) {
        return true;
    }
    return false;
}

/**
 * 썸네일 URL 가져오기
 * @param string $bo_table 게시판 테이블명
 * @param int $wr_id 게시글 ID
 * @param int $width 너비
 * @param int $height 높이
 * @return string 썸네일 URL
 */
function premium_get_thumbnail($bo_table, $wr_id, $width = 200, $height = 150) {
    $thumb = get_list_thumbnail($bo_table, $wr_id, $width, $height);
    if ($thumb['src']) {
        return $thumb['src'];
    }
    return '';
}

/**
 * 게시판 링크 생성
 * @param string $bo_table 게시판 테이블명
 * @param int $wr_id 게시글 ID (선택)
 * @param string $mode 모드 (list, write, view 등)
 * @return string URL
 */
function premium_board_url($bo_table, $wr_id = 0, $mode = '') {
    $url = G5_BBS_URL . '/board.php?bo_table=' . urlencode($bo_table);
    if ($wr_id) {
        $url .= '&wr_id=' . (int)$wr_id;
    }
    if ($mode) {
        $url = G5_BBS_URL . '/' . $mode . '.php?bo_table=' . urlencode($bo_table);
        if ($wr_id) {
            $url .= '&wr_id=' . (int)$wr_id;
        }
    }
    return $url;
}

/**
 * 회원 프로필 이미지 URL
 * @param string $mb_id 회원 ID
 * @return string 이미지 URL
 */
function premium_member_photo($mb_id) {
    if(!$mb_id) return G5_IMG_URL . '/no_profile.png';

    $mb_dir = G5_DATA_PATH.'/member/'.substr($mb_id, 0, 2);
    $mb_icon_file = $mb_dir.'/'.get_mb_icon_name($mb_id).'.gif';
    if(file_exists($mb_icon_file)) {
        return str_replace(G5_DATA_PATH, G5_DATA_URL, $mb_icon_file);
    }
    return G5_IMG_URL . '/no_profile.png';
}

/**
 * 회원 레벨 아이콘
 * @param int $level 레벨
 * @return string HTML
 */
function premium_level_icon($level) {
    $level = (int)$level;
    return '<span class="level-badge level-'.$level.'">'.$level.'</span>';
}
