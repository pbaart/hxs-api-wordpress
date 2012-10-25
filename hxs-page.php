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
	
	
	if( isset( $_POST['hxs-check'] ) || (isset($_SESSION["domain"]) && $_SESSION["domain"] ) ) {
		if( !isset( $_POST['hxs-check'] ) ) {
			$check	= $_SESSION['domain'];
		} else {
			$check	= $_POST["hxs-check"];
		}
		
		$dom	= $c -> checkDomain( $check );
		if( isset($_POST['hxs-order'])) {
			$order	= $_POST["hxs-order"];
			$dom -> years	= $order['years'];
			$dom -> order 	= true;
		}
	} else {
		$dom	= false;
	}
	$g	= isset($_GET["step"]) ? $_GET["step"] : false;

	if( $g ) {
		if( $g == "order" ) {
		
		} else
		// customer login or creation
		if( $g == "validate") {
			$error 				= false;
			if( !$dom ) {
				$error[]		= __("No domain checked or session timed out.");
			}
			elseif( isset($_POST['hxs-login'])) {
				$login			= $_POST['hxs-login'];
				if( !isset($login['un']) || !isset($login['pw'])) {
					$customer	= false;
				} else {
					$customer	= $c -> loginCustomer( $login['un'] , $login['pw'] );
				}
			
				if( !$customer ) {
					$error['login']	= sprintf( "<strong>%s</strong><br><br>%s<br><br><a href='#hxs-sign-up'>sign up</a>" , __("Login failed") , $c -> error );
				} else {
					$_SESSION["existing-customer"]	= $customer;
				}
			}
			elseif(isset($_POST['hxs-customer'])) {
				$signup			= $_POST['hxs-customer'];
				if( $signup['pw'] != $signup['pw-repeat'] ) {
					$error['signup']= __("Passwords do not match.");
				} elseif( !hxs_customer::pwstrength( $signup['pw'] ) ) {
					$error['signup']= __("Password strength too low, use a more complex password.");
				}
				$customer		= new hxs_customer($signup);
				if( !$customer ) {
					$error['signup']= sprintf( "<strong>%s</strong><br><br>%s" , __("Sign up failed") , $c -> error );
				} else {
					$_SESSION["new-customer"]	= $customer;
				}				
			}
			
			if( !$error ) {
				include_once HXS_PLUGIN_PATH_TPL . "validate-review.php";
			} else {
				$g		= "customer";
			}
		} 
		if( $g == "customer" ) {
			include_once HXS_PLUGIN_PATH_TPL . "customer-form.php";
		}
	} else {
		include_once HXS_PLUGIN_PATH_TPL . "domain-check-form.php";
	}
	$_SESSION["domain"]	 	= ( $dom ? $dom -> name : false );
}

function wp_hxs_account_check() {
	$c		= new hxsclient( get_option( "hxs-reseller-id" ) , get_option( "hxs-reseller-pw") );
	echo json_encode( (bool) $c -> getAccount( $_POST['username'] ) );
	exit( );
}
