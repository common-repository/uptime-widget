<?php
/*
Plugin Name: Uptime Widget
Plugin URI: http://www.nerdtools.co.uk/uptime/
Description: A simple plugin that will display a gauge on your sidebar showing the uptime percentage of any website in the past month
Version: 1.0
Author: NerdTools
Author URI: http://www.nerdtools.co.uk/
License: GPL2
*/

class wp_my_plugin extends WP_Widget {

	// constructor
	function wp_my_plugin() {
        parent::WP_Widget(false, $name = __('Uptime Widget', 'wp_widget_plugin') );
	}

// widget form creation
function form($instance) {

// Check values
if( $instance) {
     $title = esc_attr($instance['title']);
     $host = esc_attr($instance['host']);
     $message = esc_textarea($instance['message']);
} else {
     $title = '';
     $host = '';
     $message = '';
}
?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('host'); ?>"><?php _e('Website to monitor:', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('host'); ?>" name="<?php echo $this->get_field_name('host'); ?>" type="text" value="<?php echo $host; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Message to display:', 'wp_widget_plugin'); ?></label>
<textarea class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>"><?php echo $message; ?></textarea>
</p>
<?php
}

// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['host'] = strip_tags($new_instance['host']);
      $instance['message'] = strip_tags($new_instance['message']);
     return $instance;
}

// display widget
function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $title = apply_filters('widget_title', $instance['title']);
   $host = $instance['host'];
   $message = $instance['message'];
   echo $before_widget;
   // Display the widget
   echo '<div class="widget-text wp_widget_plugin_box">';

   // Check if title is set
   if ($title) {
      echo $before_title . $title . $after_title;
   }

   // Check if message is set
   if($message) {
     echo '<p class="wp_widget_plugin_textarea">'.$message.'</p>';
   }

   // Check if host is set
   if($host) {
      echo '<p class="wp_widget_plugin_text"><iframe src="http://graph.nerdtools.co.uk/?gid=1&host='.$host.'&port=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowTransparency="true"></iframe></p>';
   }
   echo '</div>';
   echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_my_plugin");'));

?>