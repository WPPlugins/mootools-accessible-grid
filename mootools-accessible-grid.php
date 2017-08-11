<?php
/*
Plugin Name: MooTools Accessible Grid
Plugin URI: http://wordpress.org/extend/plugins/mootools-accessible-grid/
Description: WAI-ARIA Enabled Grid Plugin for Wordpress
Author: Kontotasiou Dionysia
Version: 1.0
Author URI: http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/

add_action("plugins_loaded", "MooToolsAccessibleGrid_init");
function MooToolsAccessibleGrid_init() {
    register_sidebar_widget(__('MooTools Accessible Grid'), 'widget_MooToolsAccessibleGrid');
    register_widget_control(   'MooTools Accessible Grid', 'MooToolsAccessibleGrid_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_MooToolsAccessibleGrid') ) {
        wp_deregister_script('jquery');

        // add your own script
        wp_register_script('mootools-core', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-grid/lib/mootools-core.js'));
        wp_enqueue_script('mootools-core');

        wp_register_script('mootools-more', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-grid/lib/mootools-more.js'));
        wp_enqueue_script('mootools-more');

        wp_register_style('MooToolsAccessibleGrid_css', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-grid/lib/demo.css'));
        wp_enqueue_style('MooToolsAccessibleGrid_css');

        wp_register_script('MooToolsAccessibleGrid', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-grid/lib/demo.js'));
        wp_enqueue_script('MooToolsAccessibleGrid');
		
		wp_register_script('grid', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-grid/lib/grid.js'));
        wp_enqueue_script('grid');
    }
}

function widget_MooToolsAccessibleGrid($args) {
    extract($args);

    $options = get_option("widget_MooToolsAccessibleGrid");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'MooTools Accessible Grid',
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    MooToolsAccessibleGridContent();
    echo $after_widget;
}

function MooToolsAccessibleGridContent() {

    $options = get_option("widget_MooToolsAccessibleGrid");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'MooTools Accessible Grid',
        );
    }

    echo '
		<div class="sa_demo_contentScreen">
			<div id="tabl"></div>
		</div>
		';
}

function MooToolsAccessibleGrid_control() {
    $options = get_option("widget_MooToolsAccessibleGrid");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'MooTools Accessible Grid',
        );
    }

    if ($_POST['MooToolsAccessibleGrid-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['MooToolsAccessibleGrid-WidgetTitle']);
        update_option("widget_MooToolsAccessibleGrid", $options);
    }
   
    ?>
    <p>
        <label for="MooToolsAccessibleGrid-WidgetTitle">Widget Title: </label>
        <input type="text" id="MooToolsAccessibleGrid-WidgetTitle" name="MooToolsAccessibleGrid-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="MooToolsAccessibleGrid-SubmitTitle" name="MooToolsAccessibleGrid-SubmitTitle" value="1" />
    </p>
    
    <?php
}

?>
