<?php
/*
 * Plugin Name: TwineSocial Widget
 * Plugin URI: http://www.twinesocial.com
 * Description: Display your social media content with the Twine Social Wordpress plugin - including hashtags and user content - in a beautiful and richly interactive view.
 * Version: 2.9.1
 * Author: Nathan Elliott
 * License: GPLv2 or later
 */

if (!defined('TWINE_PLUGIN_DIRNAME')) {
	define('TWINE_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) );
}

if (!defined('TWINE_PUBLIC_URL')) { 
	define('TWINE_PUBLIC_URL',  '//www.twinesocial.com');
}

if (!defined('TWINE_APPS_URL')) {
	define('TWINE_APPS_URL',  '//apps.twinesocial.com');
}

if (!defined('TWINE_CUSTOMER_URL')) {
	define('TWINE_CUSTOMER_URL',  '//customer.twinesocial.com');
}


include_once ("lib/functions.php");
require_once dirname( __FILE__ ) . '/twinesocial-admin.php';

/**
 * Register the Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget("twinesocial_widget");' ) );

/**
 * Create the widget class and extend from the WP_Widget
 */
 class twinesocial_Widget extends WP_Widget {

	/**
	 * Set the widget defaults
	 */
	private $widget_title = "TwineSocial Hub";
	private $app = "";
	private $height = "auto";
	private $width = "";
	private $language="en";
	private $theme="";
	private $color="";
	private $scrolloptions="fixed";
	private $pagesize="20";
	private $collection = "";
	private $nav = "0";
	private $noAnimate = false;

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(
			'twinesocial_Widget', // Base ID
			'Twine Social ',      // Name
			array(
				'classname'		=>	'twinesocial_Widget',
				'description'	=>	__('A WordPress widget to add your TwineSocial Hub.', 'framework')
			)
		);
	} // end constructor

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	 
	 // this only affects the sidebar widget
	public function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$this->widget_title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : "TwineSocial" );

		$this->height     = $instance['height'];
		$this->app        = $instance['app'];
		$this->language   = $instance['language'];
		$this->theme      = $instance['theme'];
		$this->color      = $instance['color'];
		$this->scrolloptions   = $instance['scrolloptions'];
		$this->nav        = $instance['nav'];
		$this->pagesize   = $instance['pagesize'];
		$this->collection = isset($instance['collection']) ? $instance['collection'] : null;
		$this->noAnimate  = true ;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ($this->widget_title)
			echo $before_title . $this->widget_title . $after_title;

        $this->render( array('app' => $this->app
                            , 'collection' => $this->collection
                            , 'height' => $this->height
                            , 'noAnimate' => $this->noAnimate
                            , 'language' => $this->language
                            , 'theme' => $this->theme
                            , 'color' => $this->color
                            , 'scrolloptions' => $this->scrolloptions
                            , 'pagesize' => $this->pagesize
                            , 'nav' => $this->nav
                            ) );

		/* After widget (defined by themes). */
		echo $after_widget;
	}

    public function render( $args ) {
        echo $this->tw_render( $args );
    }

    public function tw_render( $args ) {

		$twinesocial_appdata = get_option('twinesocial_appdata');
		if ($twinesocial_appdata) {
			$twinesocial_appdata_json = json_decode($twinesocial_appdata);
		}


        $r = wp_parse_args( $args, array('app' => ''
                                    , 'height' => ''
                                    , 'width' => ''
                                    , 'collection' => ''
                                    , 'language' => ''
                                    , 'theme' => ''
                                    , 'color' => ''
                                    , 'scrolloptions' => ''
                                    , 'pagesize' => ''
                                    , 'noAnimate'=>false
                                    , 'nav' => ''
                                    ) );

        $r['app'] = $this->clean_appname( $r['app'] );

        $url = add_query_arg( array(
            'app'      => rawurlencode( $r['app'] ),
        ), TWINE_APPS_URL . '/embed' );

        if (!empty( $r['height'])) {
            $url = add_query_arg( 'height', $r['height'], $url );
        } else {
            $url = add_query_arg( 'height', "auto", $url );
        }

        if ( !empty( $r['collection'] ) )
            $url = add_query_arg( 'collection', $r['collection'], $url );

       if (!empty($r['language']))
            $url = add_query_arg( 'lang', $r['language'], $url );

       if (!empty($r['theme']))
            $url = add_query_arg( 'theme-layout', $r['theme'], $url );

       if (!empty($r['color']))
            $url = add_query_arg( 'theme-color', $r['color'], $url );


       if (empty($r['scrolloptions'])) {
           $url = add_query_arg( 'scroll', "no", $url );
       } else if ($r['scrolloptions']=="showbutton") {
            $url = add_query_arg( 'showLoadMore', "yes", $url );
            $url = add_query_arg( 'autoload', "no", $url );
			$url = add_query_arg( 'scroll', "no", $url );
       } else if ($r['scrolloptions']=="fixed") {
			$url = add_query_arg( 'scroll', "no", $url );
            $url = add_query_arg( 'autoload', "no", $url );
       }


       if ( !empty( $r['pagesize'] ) )
            $url = add_query_arg( 'pagesize', $r['pagesize'], $url );

        if ($r['nav']==0) {
            $url = add_query_arg('showNav', "no", $url);
        }

		if ($r['noAnimate']) {
	        $url = add_query_arg( 'noAnimate', "1", $url );
	    }

		$code = substr(md5(uniqid(mt_rand(), true)) , 0, 8);

        $output = '<script type="text/javascript" id="twine-script" data-instance-id="' . $code . '" src="' . esc_url( $url ) . '">';
        if ($twinesocial_appdata && count($twinesocial_appdata_json->urls)>0) {
        	$rnd = rand(0,sizeof($twinesocial_appdata_json->urls)-1);
        	$output .= '<a href="' . $twinesocial_appdata_json->urls[$rnd]->url . '">' . $twinesocial_appdata_json->urls[$rnd]->keyword . '</a>';
        }
        $output .= '</script>';

        return $output;
    }

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['app'] = strip_tags( $new_instance['app'] );
		$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		$instance['height'] = strip_tags( $new_instance['height'] );
		$instance['collection'] = strip_tags( $new_instance['collection'] );
		$instance['nav'] = strip_tags( $new_instance['nav'] );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['language'] = strip_tags( $new_instance['language'] );
		$instance['theme'] = strip_tags( $new_instance['theme'] );
		$instance['color'] = strip_tags( $new_instance['color'] );
		$instance['scrolloptions'] = strip_tags( $new_instance['scrolloptions'] );
		$instance['pagesize'] = strip_tags( $new_instance['pagesize'] );

		return $instance;
	}

    function clean_appname($appname) {
        if (! empty($appname))
            return preg_replace('/^http(s)?:\/\/(www.)?twinesocial.com\//', '', $appname);
        else
            '';
    }

	/**
	 * Create the form for the Widget admin
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {

		$twinesocial_appdata = get_option('twinesocial_appdata');
		
		wp_enqueue_script('twinesocial_widget_js3', plugins_url('/js/jquery.timeago.js', __file__ ) );
	    wp_enqueue_script('twinesocial_widget_js3', plugins_url('/js/twine.js', __file__ ) );	    

		/* Set up some default widget settings. */
		$defaults = array(
                'title' => $this->widget_title,
                'app' => $this->app,
                'height' => $this->height,
                'collection' => $this->collection,
                'nav' => $this->nav,
                'language' => $this->language,
                'theme' => $this->theme,
                'color' => $this->color,
                'scrolloptions' => $this->scrolloptions,
                'pagesize' => $this->pagesize,
                'width' => $this->width,
            );

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<div class="tw-widget-content">

            <!-- Page name: Text Input -->

             <H4>Configure your Twine Social Sidebar Widget</H4>

            <p>
                <label for="<?php echo $this->get_field_id( 'app' ); ?>"><?php _e('Social Hub', 'framework') ?>: </label><BR>


				<?php 
				if ($twinesocial_appdata) {
					$js = json_decode($twinesocial_appdata);
					if ($js->success) { ?>
						<SELECT id="twinesocial_baseUrl" name="<?php echo $this->get_field_name( 'app' ); ?>" >
						<?php foreach ($js->apps as $app) {

							$sel = $instance['app']==$app->baseUrl ? 'selected' : '';
							echo '<OPTION ' . $sel . ' value="' . $app->baseUrl . '">' . $app->name . '</option>';
						}
						echo '</SELECT>';
					} else {
						echo '<div class="alert alert-info">' . $js->message . '</div>';
					}
			} ?>
						
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'collection' ); ?>"><?php _e('Collection', 'framework') ?>: </label><BR>

				<?php 
				if ($twinesocial_appdata) {
					$js = json_decode($twinesocial_appdata); ?>
					<SELECT id="twinesocial_collection" name="<?php echo $this->get_field_name('collection'); ?>">
						<OPTION value="0">Show All Items</option>
						<?php foreach ($js->apps as $app) {
							if ($app->baseUrl == $js->apps[0]->baseUrl) {
								foreach ($app->collections as $collection) { 
									$sel = $instance['collection']==$collection->id ? 'selected="selected"' : '';
									echo '<OPTION ' . $sel . ' value="' . $collection->id . '">' . $collection->name . '</option>';
								}
							}
						}
					echo '</SELECT>';

			} ?>
						
            </p>



            <p>
            
                <label for="<?php echo $this->get_field_id( 'pagesize' ); ?>"><?php _e('Limit', 'framework') ?>: </label><BR>
				<SELECT id="twinesocial_pagesize" name="<?php echo $this->get_field_name('pagesize'); ?>">
					<OPTION <?php echo $instance['pagesize']=="1" ? 'selected="selected"' : ''?> value="1">Show 1 post</option>
					<OPTION <?php echo $instance['pagesize']=="2" ? 'selected="selected"' : ''?> value="2">Show 2 posts</option>
					<OPTION <?php echo $instance['pagesize']=="3" || $instance['pagesize']=='' || $instance['pagesize']=="20" ? 'selected="selected"' : ''?> value="3">Show 3 posts</option>
					<OPTION <?php echo $instance['pagesize']=="5" ? 'selected="selected"' : ''?> value="5">Show 5 posts</option>
					<OPTION <?php echo $instance['pagesize']=="10" ? 'selected="selected"' : ''?> value="10">Show 10 posts</option>
				</SELECT>
						
            </p>
            
			<p>
               <label for="<?php echo $this->get_field_id( 'language' ); ?>"><?php _e('Language', 'framework') ?>: </label><BR>
				<SELECT id="twinesocial_language" name="<?php echo $this->get_field_name('language'); ?>">
				<?php foreach ($js->languages as $language) {
						$sel = $instance['language']==$language->culture ? 'selected="selected"' : '';
						echo '<OPTION ' . $sel . ' value="' . $language->culture . '">' . $language->name . '</option>';
				}
			echo '</SELECT>'; ?>
			</p>


            <!-- Widget Title: Text Input -->
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget Title', 'framework') ?>: </label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </p>

			<hr>
            <p>
            <strong>Advanced Settings:</strong>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height', 'framework') ?>: </label>
                <input type="text" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" size="5" />px
                <br> <small>Initial height of the sidebar widget. Set to "auto" to auto-grow and shrink.</small>
            </p>

			<p><small>When visitors reach the last post:</small>
			<SELECT id="twinesocial_scrolloptions" name="<?php echo $this->get_field_name('scrolloptions'); ?>">
				<OPTION <?php echo $instance['scrolloptions']=='fixed'  || $instance['scrolloptions']=='' ? 'selected="selected"' : ''?> value="fixed">Do nothing (Recommended)</option>
				<OPTION <?php echo $instance['scrolloptions']=='showbutton' ? 'selected="selected"' : ''?> value="showbutton">Show a "Load More Posts" button</option>
				<OPTION <?php echo $instance['scrolloptions']=='autoload' ? 'selected="selected"' : ''?> value="autoload">Auto-load more posts (Not recommended)</option>
			</SELECT>
			</p>

			<p><input type="checkbox" id="<?php echo $this->get_field_id('nav'); ?>" name="<?php echo $this->get_field_name('nav'); ?>" value="1" <?php echo $instance['nav']=="1" ? "checked" : ""?> />&nbsp;Show navigation tabs</p>
		
					
					
        </div>

	<?php
	}
 }

/**
 * Display the embed of twinesocial stream
 *
 * The list of arguments is below:
 *     'app' (string) - You twinesocial site id
 *     'height' (int) - height of the iframe
 *
 * @param string|array $args Optional. Override the defaults.
 */ 
function twinesocial_embed( $args ) {
    $tw_widget = new twinesocial_Widget();
    $tw_widget->tw_render( $args );
}

/**
 * Shortcode to diplay Twine Social in your site.
 * 
 * The list of arguments is below:
 *     'app' (string) - You twinesocial site id
 *                    Default: twinesocial
 *     'height' (int) - height of the iframe
 *                    Default: initial auto adjustable to 20 posts.
 * 
 * Usage: 
 * [twinesocial app="twinesocial"]
 * [twinesocial app="twinesocial" height="1500"]
 */
function twinesocial_shortcode( $atts ) {
    $tw_widget = new twinesocial_Widget();

    $height = '';
    if ( isset($atts['height']) && !empty( $atts['height'] ) ) {
        $height = $atts['height'];
    }

    $width = '0';
    if ( isset($atts['width']) && !empty( $atts['width'] ) ) {
        $width = $atts['width'];
    }

    $app = '';
    if (isset($atts['app']) && ! empty( $atts['app'] ) ) {
        $app = $atts['app'];
    }

    $collection = '';
    if (isset($atts['collection']) && ! empty( $atts['collection'] ) ) {
        $collection = urlencode($atts['collection']);
    }

    if (isset($atts['language']) && ! empty( $atts['language'] ) ) {
        $language = urlencode($atts['language']);
    }

    if (isset($atts['theme']) && ! empty( $atts['theme'] ) ) {
        $theme = urlencode($atts['theme']);
    }

    if (isset($atts['color']) && ! empty( $atts['color'] ) ) {
        $color = urlencode($atts['color']);
    }


    if (isset($atts['scrolloptions']) && ! empty( $atts['scrolloptions'] ) ) {
        $scrolloptions = urlencode($atts['scrolloptions']);
    }

    if (isset($atts['pagesize']) && ! empty( $atts['pagesize'] ) ) {
        $pagesize = urlencode($atts['pagesize']);
    }

    $nav = '0';
    if (isset($atts['nav']) && !empty( $atts['nav'] ) ) {
        $nav = '1';
    }

    return $tw_widget->tw_render( array(
        'app'     => $app,
        'height'        => $height,
        'collection'        => $collection,
        'language'        => $language,
        'theme'        => $theme,
        'color'        => $color,
        'scrolloptions'        => $scrolloptions,
        'pagesize'        => $pagesize,
        'width'        => $width,
        'nav'        => $nav,
        'noAnimate'        => false
    ) );
}
add_shortcode( 'twinesocial', 'twinesocial_shortcode' );
	
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'twine_add_action_links' );
    function twine_add_action_links ( $links ) {
        $links[] = '<a href="'. get_admin_url(null, 'admin.php?page=twinesocial-key-setting') .'">Settings</a>';
        $links[] = '<a href="http://www.twinesocial.com/" target="_blank">Visit TwineSocial Website<a>';
        return $links;
    }
