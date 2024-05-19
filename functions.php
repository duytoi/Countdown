/*
 * Code đếm ngược để hiển thị mật khẩu
 * Cách dùng [pass_countdown code="vnet"]
 * Author: DTC
 * */
add_shortcode('pass_countdown', 'button_countdown_func');
function button_countdown_func($atts)
{
    $atts = shortcode_atts(array(
        'time' => 120,
        'code' => 'vnet@!@#$24',
        'before_code' => '',
        'title' => 'Nhấp vào đây để lấy mã bảo mật',
        'mess' => 'Mã bảo mật sẽ hiện sau %s giây',
    ), $atts, 'button_countdown');
    $time = isset($atts['time']) ? intval($atts['time']) : 10;
    $code = isset($atts['code']) ? sanitize_text_field($atts['code']) : '';
    $title = isset($atts['title']) ? sanitize_text_field($atts['title']) : '';
    $mess = isset($atts['mess']) ? sanitize_text_field($atts['mess']) : '';
    $before_code = isset($atts['before_code']) ? sanitize_text_field($atts['before_code']) : '';
    ob_start();
    ?>
    <span data-counter="<?php echo $time;?>" data-mess="<?php echo esc_attr($mess);?>" data-before="<?php echo esc_attr($before_code);?>" data-code="<?php echo esc_attr(base64_encode($code));?>" class="coundownmobile" onclick="startcountdown(this); this.onclick=null;">
        <?php echo $title;?>
    </span>
    <?php
    return ob_get_clean();
}
add_action('wp_footer', 'countdown_script');
function countdown_script(){
    ?>
    <style>
        .coundownmobile{
            background: #e81e1e;
            border-radius: 10px;
            border: none;
            color: #ffffff;
            display: inline-block;
            text-align: center;
            padding: 10px;
            outline: none;
            cursor: pointer;
        }
        .coundownmobile.countdown-loading {
            background: #FF5722;
        }
        .coundownmobile.countdown-done {
            background: green;
        }
    </style>
    <script type="text/javascript">
        function startcountdown(btn){
            btn.classList.add("countdown-loading");
            let counter = btn.getAttribute('data-counter');
            let $code = btn.getAttribute('data-code');
            let mess = btn.getAttribute('data-mess');
            let before = btn.getAttribute('data-before');
            let startcountdown = setInterval(function(){
                counter--;
                btn.innerHTML = mess.replace(/%s/gi, counter);
                if(counter == 0){
                    if($code) {
                        btn.innerHTML = before + ' ' + atob($code);
                        btn.classList.add("countdown-done");
                    }
                    clearInterval(startcountdown);
                    return false;
                }}, 1000);
        }
    </script>
    <?php
}
