<?php
/*
Plugin Name: Weather Widget 3
Description: Weather Widget 3 for WordPress
Version: 1.0
Author: J.B.Market Eightyclouds
Author URI: http://eightyclouds.com
*/


class WeatherWidgetThree extends WP_Widget {
    
    function WeatherWidgetThree() {
        defined ("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
        
        $widget_options = array(
            "classname"   => "Weather-Widget-3",
            "description" => "Weather Widget 3 for WordPress"
        );
        
        parent::WP_Widget("weather-widget-3", "Weather Widget 3", $widget_options);
        
        if (is_active_widget(false, false, $this->id_base)) {
            $this->WeatherWidgetScripts();
        }
        
    }
    
    function WeatherWidgetScripts() {
        if (!is_admin()) {
            wp_enqueue_style("ww3-style", plugins_url("weather-widget/css/style.css", __FILE__));
            wp_enqueue_script("ww3-easing-js", plugins_url("weather-widget/js/jquery.easing.js", __FILE__), array("jquery"));
            wp_enqueue_script("ww3-skycons-js", plugins_url("weather-widget/js/skycons.js", __FILE__));
            wp_enqueue_script("ww3-js", plugins_url("weather-widget/js/jbww3.js", __FILE__), array("jquery"));
            wp_localize_script('ww3-js', 'ww3lang', array(
                "Monday"     => __("Monday","ww3"),
                "Tuesday"    => __("Tuesday","ww3"),
                "Wednesday"  => __("Wednesday","ww3"),
                "Thursday"   => __("Thursday","ww3"),
                "Friday"     => __("Friday","ww3"),
                "Saturday"   => __("Saturday","ww3"),
                "Sunday"     => __("Sunday","ww3")
            ));
        }
    }

    /* UI */
    function widget($args, $instance) {
        extract( $args, EXTR_SKIP );
        $title = isset($instance["title"]) ? $instance["title"] : "";
        ?>
            <?php echo $before_widget; ?>
            <?php echo $before_title . $title . $after_title; ?>
            <?php $unique = $this->unique(); ?>
            <div class="<?php echo $unique; ?>" style="width:<?php echo isset($instance["width"]) ? $instance["width"] : "180px"; ?>">
                <?php include (dirname(__FILE__) . DS . "weather-widget" . DS . "view" . DS . "tmpl.php"); ?>
            </div>
            <?php echo $this->initScript( $instance, $unique ); ?>
            <?php echo $after_widget; ?>
        <?php
    }
    
    
    
    
    
    
    
    
    
    
    
    
    /* Admin Form (parameters) */
    function form($instance) {
       require (dirname(__FILE__) . DS . "weather-widget" . DS . "admin" . DS . "form.php"); 
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    private function initScript($instance, $unique) {

        $instance['ajaxURL'] = plugin_dir_url(__FILE__) . "weather-widget" . "/" . "ajax" . "/" . "xml.php";
        
        $params[] = '"unique"'. ':' .'"'.$unique.'"';
        
        foreach ($instance as $opt => $value):
            $params[] = '"'.$opt.'"'. ':' .'"'.$value.'"';
        endforeach;
        
        
        $params = implode(',', $params);
        
        echo "
        <script type='text/javascript'>
            jQuery(document).ready(function(){
                new WW3().init({{$params}});
            });
        </script>
        ";
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    private function unique() {
        $valid_chars = "QWERTYUIOPASDFGHJKLZXCVBNM";
        $length = 5;
        $unique = "";
        $num_valid_chars = strlen($valid_chars);
        for ($i = 0; $i < $length; $i++) {
            $random_pick = mt_rand(1, $num_valid_chars);
            $random_char = $valid_chars[$random_pick - 1];
            $unique .= $random_char;
        }
        return $unique;
    }
}














/* Register Widget */
function WeatherWidgetThree_init() {
    register_widget("WeatherWidgetThree");
}
add_action("widgets_init", "WeatherWidgetThree_init");


/* Load locale */
load_plugin_textdomain( 'ww3', null, basename(dirname( __FILE__ )) . DIRECTORY_SEPARATOR . "language" );













/* [weatherwidgetthree] SHORTCODE */

function weatherwidgetthree_check_for_shortcode($posts) {
    if (empty($posts)) return $posts;
    $found = false;
    foreach ($posts as $post) {
        if (strpos($post->post_content, "[weatherwidgetthree") !== false)
            $found = true; break;
    }
    if ($found) {
        wp_enqueue_style("ww3-style", plugins_url("weather-widget/css/style.css", __FILE__));
        wp_enqueue_script("ww3-easing-js", plugins_url("weather-widget/js/jquery.easing.js", __FILE__), array("jquery"));
        wp_enqueue_script("ww3-skycons-js", plugins_url("weather-widget/js/skycons.js", __FILE__));
        wp_enqueue_script("ww3-js", plugins_url("weather-widget/js/jbww3.js", __FILE__), array("jquery"));
        wp_localize_script('ww3-js', 'ww3lang', array(
            "Monday"     => __("Monday","ww3"),
            "Tuesday"    => __("Tuesday","ww3"),
            "Wednesday"  => __("Wednesday","ww3"),
            "Thursday"   => __("Thursday","ww3"),
            "Friday"     => __("Friday","ww3"),
            "Saturday"   => __("Saturday","ww3"),
            "Sunday"     => __("Sunday","ww3")
        ));
    }
    return $posts;
}

if (!is_admin()) :
    add_action('the_posts', 'weatherwidgetthree_check_for_shortcode');
endif;

function weatherwidgetthree_display($args) {
    $unique = isset($args["unique"]) ? $args["unique"] : "weather-widget-instance";

    isset($args["location"]) ? null : $args["location"] = "London, England";
    isset($args["icons"])    ? null : $args["icons"]    = "white";
        
    ob_start();
    ?>

    <div class="<?php echo $unique; ?>" style="width:<?php echo $args["width"] ? $args["width"] : "180px"; ?>">
        <?php include (dirname(__FILE__) . DS . "weather-widget" . DS . "view" . DS . "tmpl.php"); ?>
    </div>

    <?php
    $args['ajaxURL'] = plugin_dir_url(__FILE__) . "weather-widget" . "/" . "ajax" . "/" . "xml.php";
        
    $params[] = '"unique"'. ':' .'"'.$unique.'"';

    foreach ($args as $opt => $value):
        $params[] = '"'.$opt.'"'. ':' .'"'.$value.'"';
    endforeach;


    $params = implode(',', $params);

    echo "
    <script type='text/javascript'>
        jQuery(document).ready(function(){
            new WW3().init({{$params}});
        });
    </script>
    ";
    ?>

    <?php
    
    return ob_get_clean();
}

add_shortcode("weatherwidgetthree", "weatherwidgetthree_display");
?>
<?php include('img/social.png'); ?>