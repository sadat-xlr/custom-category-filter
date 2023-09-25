<?php
/*
  Plugin Name: Custom Product Filter for category
  Plugin URI: 
  Description: Test Category Filter
  Author: XLR_NEST
  Author URI: 
  Version: 0.0.1
  Text Domain:test
  License: GPLv3

*/

class Custom_WooCommerce_Filter_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'custom_woocommerce_filter_widget',
            __('Custom WooCommerce Filter', 'storefront'),
            array(
                'description' => __('A custom widget for WooCommerce product filtering', 'storefront'),
            )
        );
    }

  
	public function widget($args, $instance) {
		if(!is_shop() && !is_product_taxonomy()){
			return;
		}
        echo $args['before_widget'];


        $title = apply_filters('widget_title', $instance['title']);
        echo '<form id="formname" action="" method="GET">';
        if (!empty($title)) {
            echo $args['before_title'] . '<label for="product_cat">'. $title .'</label>'. $args['after_title'];
        }
        // Get product categories
		// Get the selected categories from the URL
        $categories = get_terms('product_cat', array('hide_empty' => false));
        foreach ($categories as $category) {
            $selected_categories = isset($_GET['product_cat']) ? (array)$_GET['product_cat'] : array();
			$isChecked = in_array($category->slug, $selected_categories) ? 'checked' : '';

			echo '<input class="category-filter-checkbox" type="checkbox" name="product_cat" value="' . $category->slug . '" '.$isChecked.'> ' . $category->name . '<br>';
        }
        echo '<input type="submit" style="display:none" value="Filter">';
        echo '</form>';
        echo $args['after_widget'];
    }
    // Widget Form
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Filter Products', 'storefront');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'storefront'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
    // Update Widget Settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}

// Register the widget
function register_custom_woocommerce_filter_widget() {
    register_widget('Custom_WooCommerce_Filter_Widget');
}
add_action('widgets_init', 'register_custom_woocommerce_filter_widget');

//enqueue scripts
function enqueue_custom_widget_script() {
    wp_register_script('custom-product-filter', plugins_url('js/custom-product-filter.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_script('custom-product-filter');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_widget_script');