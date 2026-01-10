<?php
$sub_menu = "800200";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'r');

// 레벨 테이블 정의
if (!isset($g5['level_table'])) {
    $g5['level_table'] = G5_TABLE_PREFIX.'level';
}

$g5['title'] = '레벨설정';
require_once './admin.head.php';

// 레벨 목록 조회
$sql = "SELECT * FROM {$g5['level_table']} ORDER BY lv_level ASC";
$result = sql_query($sql);
?>

<style>
.level-color-preview {
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 4px;
    vertical-align: middle;
    margin-right: 5px;
    border: 1px solid #ddd;
}
.frm_input.lv-point { width: 120px; text-align: right; }
.frm_input.lv-name { width: 100px; }
.frm_input.lv-color { width: 80px; }
</style>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">레벨 설정</span></span>
    <p style="margin-top:10px; color:#666;">캐시 + 포인트 합산 점수로 레벨이 결정됩니다.</p>
</div>

<form name="flevellist" id="flevellist" method="post" action="./level_update.php">
    <input type="hidden" name="token" value="<?php echo isset($token) ? $token : ''; ?>">

    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th scope="col" style="width:60px;">레벨</th>
                    <th scope="col" style="width:120px;">등급명</th>
                    <th scope="col" style="width:150px;">필요점수</th>
                    <th scope="col" style="width:100px;">색상</th>
                    <th scope="col">미리보기</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $bg = 'bg' . ($i % 2);
                ?>
                <tr class="<?php echo $bg; ?>">
                    <td class="td_num">
                        <strong>Lv.<?php echo $row['lv_level']; ?></strong>
                        <input type="hidden" name="lv_level[<?php echo $i; ?>]" value="<?php echo $row['lv_level']; ?>">
                    </td>
                    <td>
                        <input type="text" name="lv_name[<?php echo $i; ?>]" value="<?php echo $row['lv_name']; ?>" class="frm_input lv-name">
                    </td>
                    <td>
                        <input type="text" name="lv_point[<?php echo $i; ?>]" value="<?php echo number_format($row['lv_point']); ?>" class="frm_input lv-point" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"> 점
                    </td>
                    <td>
                        <input type="color" name="lv_color[<?php echo $i; ?>]" value="<?php echo $row['lv_color'] ? $row['lv_color'] : '#9ca3af'; ?>" style="width:40px; height:30px; border:none; cursor:pointer;">
                    </td>
                    <td>
                        <span class="level-color-preview" style="background:<?php echo $row['lv_color'] ? $row['lv_color'] : '#9ca3af'; ?>;"></span>
                        <span style="color:<?php echo $row['lv_color'] ? $row['lv_color'] : '#9ca3af'; ?>; font-weight:600;">Lv.<?php echo $row['lv_level']; ?> <?php echo $row['lv_name']; ?></span>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="저장" class="btn_submit btn">
    </div>

</form>

<script>
// 색상 변경시 미리보기 업데이트
document.querySelectorAll('input[type="color"]').forEach(function(input) {
    input.addEventListener('change', function() {
        var row = this.closest('tr');
        var preview = row.querySelector('.level-color-preview');
        var text = row.querySelector('td:last-child span:last-child');
        preview.style.background = this.value;
        text.style.color = this.value;
    });
});
</script>

<?php
require_once './admin.tail.php';
