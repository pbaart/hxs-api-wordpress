<?PHP

class HXSwidget extends WP_Widget {
	function HXSWidget() {
		parent::__construct( "hxs-dc" , "Domeincontrole" , array( "Domeincontrole widget van HostingXS" ));
	}
	function widget( $args , $instance ) {
		if( !is_user_logged_in()) { return; }
		extract($args);
		$title 		= apply_filters( 'widget_title', $instance['hxs-c-title'] );
		echo $before_widget;
#		if( $title )
			echo $before_title . __("Domain Check") . $after_title;
		echo "<form method='POST' action='".get_option( "hxs-domain-c-page" )."'><input type='text' name='hxs-check' value='".( isset($_POST['hxs-check']) ? $_POST['hxs-check'] : get_option( "hxs-domain-c-widget" ))."' /><input type='submit' name='hxs-check-submit' value='".__("check","hxs")."' /></form>";
		echo $after_widget;

	}
	function form( $instance ) {
		$defaults = array( 
			'title' => __('Domain Check', 'hxs'));
			
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<h3>General Settings</h3>
		<!-- Widget Title: Text Input -->
		<p>
			<label for="hxs-c-title">Title</label>
			<input id="hxs-c-title" name="hxs-c-title" value="<?php echo $instance['title']; ?>" style="width:85%;" />
		</p><?PHP
		// admin widget options form
	}
	function update( $new_instance , $old_instance ) {
		$instance		= $old_instance;
		$instance['hxs-c-title']= $new_instance['hxs-c-title'];
		return $instance;
	}
}

function hxs_register_widgets() {
	register_widget( "HXSWidget" );
}

add_action( 'widgets_init' , 'hxs_register_widgets'); 
