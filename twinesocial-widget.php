<?php
/*
 * Plugin Name: Twine Social Widget
 * Plugin URI: http://www.twinesocial.com
 * Description: Display your social media content with the Twine Social Wordpress plugin - including hashtags and user content - in a beautiful and richly interactive view.
 * Version: 1.3.2
 * Author: Nathan Elliott
 * License: GPLv2 or later
 */

define( 'TWINESOCIAL_FULL_WIDTH_TEMPLATE', 'page-twinesocial-4-columns.php' );

require_once dirname( __FILE__ ) . '/twinesocial-admin.php';

/**
 * Template functions
 **/

function twinesocial_template_custom_activation() {
    twinesocial_add_templates_to_theme();
}
register_activation_hook( __FILE__, 'twinesocial_template_custom_activation' );


function twinesocial_template_custom_deactivation() {
    twinesocial_remove_template_from_theme();
}
register_deactivation_hook( __FILE__, 'twinesocial_template_custom_deactivation' );


/**
 * Create a Twine Social plugin template for page into the current theme.
 */
function twinesocial_add_templates_to_theme(){

    $src_template = dirname( __FILE__ ).'/templates/' . TWINESOCIAL_FULL_WIDTH_TEMPLATE;
    $dst_template = get_template_directory().'/' . TWINESOCIAL_FULL_WIDTH_TEMPLATE;

    if( ! file_exists( $dst_template ) ) {
        $data = file_get_contents($src_template);
        if ( ! twinesocial_create_page_template( $data, get_template_directory(), TWINESOCIAL_FULL_WIDTH_TEMPLATE) ) {
            //wp_die('plugin need write permissions on the template');
        }
    }
}


function twinesocial_create_page_template($data, $dst_dir,  $dst_file){
    $result = false;
    
    $destination = get_template_directory().'/'.$dst_file;
    
    if ( file_exists($destination) ) {
        //backup home
        $bkp_file = tempnam($dst_dir, $dst_file);
        rename($destination, $bkp_file);
    }

    if ( !file_exists($destination) ){
        $handle = fopen($destination, "w");
        $result = fwrite($handle, $data);
        fclose($handle);
    } 
    
    return $result;
}


function twinesocial_remove_template_from_theme(){
    
     twinesocial_remove_templates_files( TWINESOCIAL_FULL_WIDTH_TEMPLATE );
     
}

function twinesocial_remove_templates_files( $file ) {
    
    //only remove home.php and twinesocial_FULL_WIDTH_TEMPLATE
    if ( in_array( $file, array(TWINESOCIAL_FULL_WIDTH_TEMPLATE)) ) {
    
        $dst_template = get_template_directory().'/'.$file;
        //$handle = fopen($dst_template);
        //fclose($handle);
        return unlink($dst_template);
    }
    return false;
}


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
	private $widget_title = "Twine Social";
	private $app = "";
	private $height = "";
	private $width = "";
	private $topic = "";
	private $cols = "1";

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(
			'twinesocial_Widget',// Base ID
			'Twine Social ',// Name
			array(
				'classname'		=>	'twinesocial_Widget',
				'description'	=>	__('A widget to add your Twine Social stream.', 'framework')
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
	public function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$this->widget_title = apply_filters('widget_title', $instance['title'] );

		$this->height      = $instance['height'];
		$this->cols      = $instance['cols'];
		$this->app   = $instance['app'];
		$this->topic   = $instance['topic'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $this->widget_title )
			echo $before_title . $this->widget_title . $after_title;

        $this->render( array('app' => $this->app
                            , 'cols' => $this->cols
                            , 'topic' => $this->topic
                            , 'height' => $this->height
                            ) );

		/* After widget (defined by themes). */
		echo $after_widget;
	}

    public function render( $args ) {
        echo $this->tw_render( $args );
    }

    public function tw_render( $args ) {
        $r = wp_parse_args( $args, array('app' => ''
                                    , 'cols' => '363'
                                    , 'height' => '1500'
                                    , 'width' => ''
                                    , 'topic' => ''
                                    , 'scroll' => ''
                                    ) );

        $r['app'] = $this->clean_appname( $r['app'] );

        $url = add_query_arg( array(
            'app'      => rawurlencode( $r['app'] ),
            'height'   => $r['height'], 
            'scroll'   => $r['scroll'] 
        ), 'http://apps.twinesocial.com/embed' );


//        if ( !empty( $r['height'] ) )
//            $url = add_query_arg( 'height', $r['height'], $url );

        if ( !empty( $r['cols'] ) )
            $url = add_query_arg( 'cols', $r['cols'], $url );

        if ( !empty( $r['topic'] ) )
            $url = add_query_arg( 'topic', $r['topic'], $url );

        $output = '<script type="text/javascript" id="twine-script" src="' . esc_url( $url ) . '"></script>';

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
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['app'] = strip_tags( $new_instance['app'] );

		$instance['height'] = strip_tags( $new_instance['height'] );
		$instance['topic'] = strip_tags( $new_instance['topic'] );
//		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['cols'] = strip_tags( $new_instance['cols'] );

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

		/* Set up some default widget settings. */
		$defaults = array(
                'title' => $this->widget_title,
                'app' => $this->app,
                'cols' => $this->cols,
                'height' => $this->height,
                'topic' => $this->topic,
                'width' => $this->width,
            );

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<div class="tw-widget-content">

            <!-- Page name: Text Input -->
            <p>
                <label for="<?php echo $this->get_field_id( 'app' ); ?>"><?php _e('TwineSocial Site ID', 'framework') ?>: </label>


				<?php 
				if ($twinesocial_appdata) {
					$js = json_decode($twinesocial_appdata);
					if ($js->success) { ?>
						<SELECT id="<?php echo $this->get_field_id( 'app' ); ?>" name="<?php echo $this->get_field_name( 'app' ); ?>" >
						<?php foreach ($js->apps as $app) {
							echo '<OPTION value="' . $app->baseUrl . '">' . $app->name . '</option>';
						}
						echo '</SELECT>';
					} else {
						echo '<div class="alert alert-info">' . $js->message . '</div>';
					}
			} ?>
						
            </p>


            <!-- Widget Title: Text Input -->
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'framework') ?>: </label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </p>

            <p>
            <strong>Advanced Settings:</strong>
            </p>

            <!-- Height: Text Input -->
            <p>
                <label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height', 'framework') ?>: </label>
                <input type="text" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" size="5" />px
                <br><!-- <span class="tw_description">Leave empty if you want twinesocial to take the full height of your sidebar.</span> -->
            </p>

            <!-- Height: Text Input -->
            <p>
                <label for="<?php echo $this->get_field_id( 'topic' ); ?>"><?php _e('Topic', 'framework') ?>: </label>
                <input type="text" id="<?php echo $this->get_field_id( 'topic' ); ?>" name="<?php echo $this->get_field_name( 'topic' ); ?>" value="<?php echo $instance['topic']; ?>" size="10" placeholder="Videos" />
                <br><span class="tw_topic">Only show items with a certain topic. Setup topics <a href="http://customer.twinesocial.com/appTopic/edit">here</a>.</span>
            </p>


            <!-- Columns: Text Input -->
            <p>
                <label for="<?php echo $this->get_field_id( 'cols' ); ?>"><?php _e('Columns', 'framework') ?>: </label>
                <input type="text" id="<?php echo $this->get_field_id( 'cols' ); ?>" name="<?php echo $this->get_field_name( 'cols' ); ?>" value="<?php echo $instance['cols']; ?>" size="5" />
            </p>

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
 * [twinesocial app="twinesocial" height="1500" cols="3"]
 */
function twinesocial_shortcode( $atts ) {
    $tw_widget = new twinesocial_Widget();

    $height = '1500';
    if ( isset($atts['height']) && !empty( $atts['height'] ) ) {
        $height = $atts['height'];
    }

    $width = '0';
    if ( isset($atts['width']) && !empty( $atts['width'] ) ) {
        $width = $atts['width'];
    }

    $cols = '1';
    if ( isset($atts['cols']) && ! empty( $atts['cols'] ) ) {
        $cols = $atts['cols'];
    }

    $app = '';
    if (isset($atts['app']) && ! empty( $atts['app'] ) ) {
        $app = $atts['app'];
    }

    $topic = '';
    if (isset($atts['topic']) && ! empty( $atts['topic'] ) ) {
        $topic = urlencode($atts['topic']);
    }

    $scroll = '';
    if (isset($atts['scroll']) && ! empty( $atts['scroll'] ) ) {
        $scroll = $atts['scroll'];
    }

    return $tw_widget->tw_render( array(
        'app'     => $app,
        'cols'        => $cols,
        'height'        => $height,
        'scroll'        => $scroll,
        'topic'        => $topic,
        'width'        => $width
    ) );
}
add_shortcode( 'twinesocial', 'twinesocial_shortcode' );

?>
