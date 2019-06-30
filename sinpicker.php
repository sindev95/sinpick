<?php

/**
 *Plugin Name: jQuery datepicker widget
 *Description: Description here
 **/

function settings_page()
{
    include_once(dirname(__FILE__) . '/src/settings_page.php');
}
function create_admin_menu()
{
    add_menu_page('Sin Picker', 'Sin Picker', 'administrator', 'sinpicker', 'settings_page');
}

add_action('admin_menu', 'create_admin_menu');


function scripts()
{
    wp_deregister_script('jquery');

    wp_enqueue_script(
        'jquery',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js',
        array(),
        '3.4.0',
        false
    );

    wp_enqueue_script(
        'jquery-pick',
        plugin_dir_url(__FILE__) . 'src/js/jquery-ui.min.js',
        array(),
        false,
        true
    );
    wp_enqueue_script(
        'jquery-ui',
        plugin_dir_url(__FILE__) . 'src/js/jquery.ui.datepicker-ja.min.js',
        array(),
        false,
        true
    );

    wp_register_style(
        'datepicker',
        plugin_dir_url(__FILE__) . 'src/css/jquery-ui.css',
        array(),
        false,
        false
    );
    wp_enqueue_style('datepicker');
}
add_action('wp_enqueue_scripts', 'scripts', 99);


function date_css()
{
    $options     = get_option('custom_css');
    $raw_content = isset($options) ? $options : '';
    $content     = wp_kses($raw_content, array('\'', '\"'));
    $content     = str_replace('&gt;', '>', $content);
    echo $content;
}

function sinpicker_css()
{

    ?>
    <style type="text/css" id="date_css">
        <?php date_css();
        ?>
    </style>
<?php
}

add_action('wp_head', 'sinpicker_css', 99);


class SinPicker_Widget extends WP_Widget
{
    public function __construct()
    {
        $widget_options = array('classname' => 'datepicker', 'description' => 'Add datepicker Widget to your website');
        parent::__construct('datepicker', 'jQuery datepicker Widget', $widget_options);
    }

    public function widget($args, $instance)
    {
        ?>
    <div id="datepicker"></div>
    <script>
        jQuery(function() {
            jQuery('#datepicker').datepicker({
                duration: 'fast'
            });
        });
    </script>
<?php

}

public function form($instance)
{
    $title = !empty($instance['title']) ? $instance['title'] : '';
    ?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" />
    </p>
<?php
}


public function update($new_instance, $old_instance)
{
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
}
}

function sinpicker_widget()
{
    register_widget('SinPicker_Widget');
}
add_action('widgets_init', 'sinpicker_widget');
