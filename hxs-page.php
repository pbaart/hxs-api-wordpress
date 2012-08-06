<?PHP

add_action( "wp_enqueue_scripts" , "wp_hxs_enqueue_style" );

add_action( "wp_ajax_nopriv_hxs_account_check" 	, "wp_hxs_account_check" );
add_action( "wp_ajax_hxs_account_check" 	, "wp_hxs_account_check" );

add_shortcode( 'wp_hxs', 'wp_hxs_page' );



define( "HXS_PLUGIN_PATH" , plugin_dir_path( __FILE__ ) );
define( "HXS_PLUGIN_PATH_TPL" , plugin_dir_path( __FILE__ ) . "templates/" );

function wp_hxs_enqueue_style() {
	wp_register_style( "hxsapistyle" , plugins_url( "hxsapi.css" , __FILE__ ) );
	wp_enqueue_style( "hxsapistyle" );
}


function wp_hxs_page( $atts ) {
#	if( !is_user_logged_in()) { return; }

	$c		= new hxsclient( get_option( "hxs-reseller-id" ) , get_option( "hxs-reseller-pw") );

	if( isset( $_POST['hxs-check'] ) ) {
		$dom	= $c -> checkDomain( $_POST['hxs-check'] );
	} else {
		$dom	= false;
	} 
	$g	= $_GET;
	if( count($g) > 0 ) {
		if( isset($g["validate"])) {
			$login	= $_POST['hxs-login'];
			if( !isset($login['un']) || !isset($login['pw'])) {
				$customer	= false;
			} else {
				$customer	= $c -> loginCustomer( $login['un'] , $login['pw'] );
			}
			include_once HXS_PLUGIN_PATH_TPL . "validate-review.php";
		} 
		if( isset($g["customer"])) {
			include_once HXS_PLUGIN_PATH_TPL . "customer-form.php";
		}
	} else {
		include_once HXS_PLUGIN_PATH_TPL . "domain-check-form.php";
	}
}

function wp_hxs_account_check() {
	$c		= new hxsclient( get_option( "hxs-reseller-id" ) , get_option( "hxs-reseller-pw") );
	echo json_encode( $c -> getAccount( $_POST['username'] ) );
	exit( );
}