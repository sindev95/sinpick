<?php
add_option('custom_css');
if (isset($_REQUEST['data'])) {
    $check = function () {
        $arr = array('custom_css');
        foreach ($arr as $v) {
            if (isset($_REQUEST[$v])) {
                update_option($v, $_REQUEST[$v]);
            }
        }
    };
    $check();
    ?>
    <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
        <p><strong>Your settings have been saved.</strong></p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Hide this notification.</span>
        </button>
    </div>
<?php
}
$css = stripslashes(get_option('custom_css'));
?>
<script>
    jQuery(function($) {
        var wrap = $('#setting_page'),
            css = $('#css', wrap).children('textarea'),
            submit = wrap.find('#submit'),
            form = submit.parent('.submit').siblings('form');

        submit.on('click', function(e) {
            e.preventDefault();

            var c_css = css.val();

            form.children('[name="custom_css"]').val(c_css);
            form.submit();
        });

    });
</script>
<div class="wrap" id="setting_page">
    <h2>Settings : </h2>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">CSS :</th>
                <td>
                    <div id="css">
                        <textarea cols="70" rows="30"><?= (stripslashes($css)) ? stripslashes($css) : '' ?></textarea>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <p class="submit">
        <button id="submit" data-disabled="" class="button button-primary">Save Changes</button>
    </p>
    <form method="post" action="admin.php?page=sinpicker">
        <input type="hidden" name="custom_css" value="<?= ($css) ? $css : '' ?>">
        <input type="hidden" name="data" value="1">
    </form>
</div>