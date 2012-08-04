<?PHP

 
add_action( "admin_menu" , "hxs_create_adminpage");

function hxs_create_adminpage() {
	add_options_page( 	"HXS Plugin Settings" ,
				"HostingXS Settings",
				"manage_options",
				"hxs",
				"hxs_settings_page" );
}

function hxs_settings_page() {
?>
<div class="wrap">
<h2>HXS Settings</h2>
	
	<form method="POST" action="options.php">
		<?PHP settings_fields( "hxs-settings" ); ?>
		<?PHP do_settings_sections( "hxs" ); ?>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>

</div>
<?
}

add_action( "admin_init" , "hxs_admin_init" );
function hxs_admin_init() {
	register_setting( "hxs-settings" , "hxs-reseller-id" , "hxs_validate_id" );
	register_setting( "hxs-settings" , "hxs-reseller-pw" , "hxs_validate_pw" );
	register_setting( "hxs-settings" , "hxs-domain-c-page" , "hxs_validate_nothing" );
	register_setting( "hxs-settings" , "hxs-domain-c-widget" , "hxs_validate_nothing" );
	add_settings_section( "hxs_settings_main" , "HostingXS Reseller info" , "hxs_settings_page_text" , "hxs" );
	add_settings_field( "reseller-id" , "HostingXS Reseller ID" , "hxs_input_reseller_id" , "hxs" , "hxs_settings_main" );
	add_settings_field( "reseller-pw" , "HostingXS Reseller Password" , "hxs_input_reseller_pw" , "hxs" , "hxs_settings_main" );
	add_settings_field( "domain-c-page" , "Send domain check requests to page" , "hxs_input_domain_c_page" , "hxs" , "hxs_settings_main" );
	add_settings_field( "domain-c-widget" , "Default value for domain check input box" , "hxs_input_domain_c_widget" , "hxs" , "hxs_settings_main" );
}
function hxs_validate_id($input) {
	$input		= (int) $input;
	if( !is_int($input) || $input < 0 ) {
		return false;
	}
	return $input;
}
function hxs_validate_pw($input) {
	return $input;
}
function hxs_validate_nothing($input) {
	return $input;
}
function hxs_input_domain_c_widget(  ) {
	$options = get_option( "hxs-domain-c-widget" );
	echo "<input id='hxs-domain-c-widget' type='text' name='hxs-domain-c-widget' value='{$options}' />";
}
function hxs_input_domain_c_page(  ) {
	$options = get_option( "hxs-domain-c-page" );
	echo "<input id='hxs-domain-c-page' type='text' name='hxs-domain-c-page' value='{$options}' />";
}
function hxs_input_reseller_id() {
	$options = get_option( "hxs-reseller-id" );
	echo "<input id='hxs-reseller-id' type='text' name='hxs-reseller-id' value='{$options}' />";
}
function hxs_input_reseller_pw() {
	$options = get_option( "hxs-reseller-pw" );
	echo "<input id='hxs-reseller-pw' type='password' name='hxs-reseller-pw' value='{$options}' />";
}
function hxs_settings_page_text() {
	echo "<p>Setup your reseller credentials provided by <a href='http://www.hostingxs.nl'>HostingXS</a>.</p>";
}