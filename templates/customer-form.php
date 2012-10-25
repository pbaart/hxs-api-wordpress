
<ul class="breadcrumb">
	<li>
		<a href="<?PHP echo get_option( "hxs-domain-c-page" ); ?>"><?PHP echo __("domain check"); ?></a> <span class="divider">/</span>
	</li>
	<li class="active">
		<?PHP echo __("customer"); ?> <span class="divider">/</span>
	</li>
	<li>
		<?PHP echo __("review"); ?> <span class="divider">/</span>
	</li>
	<li>
		<?PHP echo __("finished"); ?></a>
	</li>
</ul>

<form method="POST" action="?step=validate" class="form-horizontal" id="hxs-login">
	<fieldset><legend><?PHP echo ( get_option( "hxs-reseller-license" ) != "reseller" ? __("Existing HostingXS B.V. customer") : __("Existing customer") ); ?></legend>
		<br>
		<?PHP if( isset($error['login'])) { ?>
		<div class="alert alert-danger">
			<?PHP echo $error['login']; ?>
		</div>
		<?PHP } else { ?>
		<div class="alert alert-info">
			<?PHP echo __("Existing customer please log in below; otherwise <a href='#hxs-sign-up'>scroll down</a> to sign up."); ?>
		</div>
		<?PHP } ?>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Username"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-login[un]" id="hxs-username" class="hxs-login-username" /><span class="help-inline"></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Password"); ?></label>
			<div class="controls">
				<input type="password" name="hxs-login[pw]" class="hxs-login-password" /><span class="help-inline"></span>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<a href="<?PHP echo get_option( "hxs-domain-c-page" ); ?>" class="btn"><?PHP echo __("go back"); ?></a>&nbsp;
		<input type="submit" class="btn btn-primary" name="submit" value="<?PHP echo __("Login - review order"); ?>" />
	</div>
	<script>
		jQuery(function() {
			jQuery("form#hxs-login").submit( function( e ) {

				var $form		= jQuery(this);
				var $unfield		= $form.find(".hxs-login-username");
				var $pwfield		= $form.find(".hxs-login-password");
				$unfield.data('valid',false);
				if( $pwfield.val() == "" ) {
					$pwfield.closest(".control-group").addClass("error").find("span.help-inline").text("<?PHP echo __("Please enter a password."); ?>");
					return false;
				}
				
				jQuery.ajax({
					url: 		"<?PHP echo admin_url( 'admin-ajax.php' ); ?>",
					data:		{
						action:		"hxs_account_check",
						username: 	$unfield.val(),
					},
					async: 		false,
					type:		'POST',
					success:	function( html ) {
						// account does not exist
						if( html != "true" ) {
							$unfield.closest(".control-group").addClass("error").find("span.help-inline").text("<?PHP echo __("Account is unknown, please create a new account or enter correct accountname."); ?>");
							e.preventDefault();
						// account does exist
						} else {
							$unfield.closest(".control-group").removeClass("error").find("span.help-inline").text("");
							valid = 1;
							$unfield.data('valid',true);
						} 
					}
				});
				return $unfield.data('valid');
				
			});
		});
	</script>
</form>
<a name="hxs-sign-up"></a>
<form method="POST" action="?validate=" class="form-horizontal">
	<fieldset><legend><?PHP echo sprintf("%s - %s" , __("Sign up"), __("Personal information")); ?></legend>
		<?PHP if( isset($error['signup'])) { ?>
		<br>
		<div class="alert alert-danger">
			<?PHP echo $error['signup']; ?>
		</div>
		<?PHP } ?>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Initials"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[initials]"<?PHP if(isset($signup) && $signup['initials']) { echo " value='". $signup['initials']."'"; } ?> />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("First name"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[firstname]"<?PHP if(isset($signup) && $signup['firstname']) { echo " value='". $signup['firstname']."'"; } ?> />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Last name"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[lastname]"<?PHP if(isset($signup) && $signup['lastname']) { echo " value='". $signup['lastname']."'"; } ?> />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Gender"); ?></label>
			<div class="controls">
				<label class="checkbox">
					<input type="radio" name="hxs-customer[gender]" value="1"<?PHP if(isset($signup) && $signup['gender'] == 1) { echo " checked"; } ?> />
					<?PHP echo __("Male"); ?>
				</label>
				<label class="checkbox">
					<input type="radio" name="hxs-customer[gender]" value="0"<?PHP if(isset($signup) && $signup['gender'] == 0) { echo " checked"; } ?> />
					<?PHP echo __("Female"); ?>
				</label>
			</div>
		</div>
	</fieldset>
	<fieldset><legend><?PHP echo __("Commercial information"); ?></legend>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Your are or represent"); ?></label>
			<div class="controls">
				<select type="text" name="hxs-customer[legal]" id="hxs-legal" />
					<option value="9"<?PHP if(isset($signup) && $signup['legal'] == 9) { echo " checked"; } ?>><?PHP echo __("Private person"); ?></option>
					<option value="1"<?PHP if(isset($signup) && $signup['legal'] == 1) { echo " checked"; } ?>><?PHP echo __("Dutch `eenmanszaak`"); ?></option>
					<option value="2"<?PHP if(isset($signup) && $signup['legal'] == 2) { echo " checked"; } ?>><?PHP echo __("Dutch `VoF`"); ?></option>
					<option value="3"<?PHP if(isset($signup) && $signup['legal'] == 3) { echo " checked"; } ?>><?PHP echo __("Dutch `CV`"); ?></option>
					<option value="4"<?PHP if(isset($signup) && $signup['legal'] == 4) { echo " checked"; } ?>><?PHP echo __("Dutch `maatschap`"); ?></option>
					<option value="5"<?PHP if(isset($signup) && $signup['legal'] == 5) { echo " checked"; } ?>><?PHP echo __("Dutch `BV`"); ?></option>
					<option value="6"<?PHP if(isset($signup) && $signup['legal'] == 6) { echo " checked"; } ?>><?PHP echo __("Dutch `stichting`"); ?></option>
					<option value="7"<?PHP if(isset($signup) && $signup['legal'] == 7) { echo " checked"; } ?>><?PHP echo __("Dutch `vereniging`"); ?></option>
					<option value="8"<?PHP if(isset($signup) && $signup['legal'] == 8) { echo " checked"; } ?>><?PHP echo __("Dutch `NV`"); ?></option>
					<option value="11"<?PHP if(isset($signup) && $signup['legal'] == 11) { echo " checked"; } ?>><?PHP echo __("Dutch `co&ouml;peratie`"); ?></option>
					<option value="12"<?PHP if(isset($signup) && $signup['legal'] == 12) { echo " checked"; } ?>><?PHP echo __("Dutch `kerk`"); ?></option>
					<option value="13"<?PHP if(isset($signup) && $signup['legal'] == 13) { echo " checked"; } ?>><?PHP echo __("Dutch `BV in oprichting`"); ?></option>
					<option value="14"<?PHP if(isset($signup) && $signup['legal'] == 14) { echo " checked"; } ?>><?PHP echo __("Dutch `onderlinge waarborg maatschappij`"); ?></option>
					<option value="15"<?PHP if(isset($signup) && $signup['legal'] == 15) { echo " checked"; } ?>><?PHP echo __("Dutch `rederij`"); ?></option>

					<option value="10"<?PHP if(isset($signup) && $signup['legal'] == 10) { echo " checked"; } ?>><?PHP echo __("Foreign company"); ?></option>

					<option value="16"<?PHP if(isset($signup) && $signup['legal'] == 16) { echo " checked"; } ?>><?PHP echo __("European Corporation"); ?></option>
					<option value="17"<?PHP if(isset($signup) && $signup['legal'] == 17) { echo " checked"; } ?>><?PHP echo __("European Economical Collaboration"); ?></option>
				</select>
			</div>
			<script>
			jQuery(function() {
				jQuery(".legal-show").hide();
				jQuery( "#hxs-legal").change( function() {
					if( jQuery(this).val() != 9  ) {
						jQuery( ".legal-9" ).hide();
						jQuery( ".legal-show" ).show();
					} else if( jQuery(this).val() == 9 ) {
						jQuery( ".legal-9" ).show();
						jQuery( ".legal-show" ).hide();
					} 
				});
			});
			</script>
			
		</div>
		<div class="control-group legal-9">
			<label class="control-label"><?PHP echo __("Date of birth"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[dob]" placeholder="YYYY-MM-DD"<?PHP if(isset($signup) && $signup['dob']) { echo " value='". $signup['dob']."'"; } ?> />
			</div>
		</div>
		<div class="control-group legal-show">
			<label class="control-label"><?PHP echo __("Company name"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[company]"<?PHP if(isset($signup) && $signup['company']) { echo " value='". $signup['company']."'"; } ?> />
			</div>
		</div>
		<div class="control-group legal-show">
			<label class="control-label"><?PHP echo __("VAT number"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[vat]" placeholder="NL00000000001B01"<?PHP if(isset($signup) && $signup['vat']) { echo " value='". $signup['vat']."'"; } ?> />
				<span class="help-inline"><?PHP echo __("International Tax Number"); ?></span>
			</div>
		</div>
		<div class="control-group legal-show">
			<label class="control-label"><?PHP echo __("CoC number"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[coc]"<?PHP if(isset($signup) && $signup['coc']) { echo " value='". $signup['coc']."'"; } ?> />
				<span class="help-inline"><?PHP echo __("Chamber of Commerce"); ?></span>
			</div>
		</div>
	</fieldset>
	<fieldset><legend><?PHP echo __("Address information"); ?></legend>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Street & housenumber"); ?></label>
			<div class="controls">
				<div>
					<input type="text" name="hxs-customer[address]"<?PHP if(isset($signup) && $signup['address']) { echo " value='". $signup['address']."'"; } ?> />
					<input type="text" name="hxs-customer[houseno]" class="span1"<?PHP if(isset($signup) && $signup['houseno']) { echo " value='". $signup['houseno']."'"; } ?> />
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Postal code"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[postal]"<?PHP if(isset($signup) && $signup['postal']) { echo " value='". $signup['postal']."'"; } ?> />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("City"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[city]"<?PHP if(isset($signup) && $signup['city']) { echo " value='". $signup['city']."'"; } ?> />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Country"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[country]" placeholder="UK"<?PHP if(isset($signup) && $signup['country']) { echo " value='". $signup['country']."'"; } ?> />
				<span class="help-inline"><?PHP echo __("Use the ISO-code of your country."); ?></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("E-mail address"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[email]" placeholder="<?PHP echo __("yourname@email.com"); ?>"<?PHP if(isset($signup) && $signup['email']) { echo " value='". $signup['email']."'"; } ?> />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Phone"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[phone]" placeholder="+31243249177"<?PHP if(isset($signup) && $signup['phone']) { echo " value='". $signup['phone']."'"; } ?> />
				<span class="help-inline"><?PHP echo __("Use the international format."); ?></span>
			</div>
		</div>
	</fieldset>
	<fieldset><legend><?PHP echo __("Login information"); ?></legend>
		<br>
		<div class="alert alert-info">
			<?PHP echo __("The following username and password combination is used for managing your products and services."); ?>
		</div>
		<div class="control-group well well-small">
			<label class="control-label"><?PHP echo __("Username"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[un]" id="hxs-username" class="hxs-username"<?PHP if(isset($signup) && $signup['un']) { echo " value='". $signup['un']."'"; } ?> /><span class="help-inline"></span>
				<p class="help-block"><?PHP echo __("Between 3 and 32 characters, only lowercase, numbers and _ or -. Must start with a letter."); ?></p>
			</div>
			<script>
			jQuery(function() {
				jQuery( ".hxs-username").keyup( function() {
					var regx	= /^[a-z]([-_a-z0-9]){2,31}$/;
					var $field	= jQuery(this);
					if( !regx.test(jQuery(this).val()) && !jQuery(this).closest(".control-group").hasClass("error")) {
						jQuery(this).closest(".control-group").addClass("error");
					} else if( regx.test( jQuery(this).val() )) {
						if( this.ajxr ) {
							this.ajxr.abort();
						}
						this.ajxr =
							jQuery.ajax({
								url: 		"<?PHP echo admin_url( 'admin-ajax.php' ); ?>",
								data:		{
									action:		"hxs_account_check",
									username: 	$field.val(),
								},
								type:		'POST',
								success:	function( html ) {
									if( html != "false" ) {
										$field.closest(".control-group").addClass("error").find("span.help-inline").text("<?PHP echo __("Account is already taken, please select a different name."); ?>");
										
										return false;
									} else {
										$field.closest(".controls").find("span.help-inline").html("");
										$field.closest(".control-group").removeClass("error");
										return true;
									} 
								}
							});
						
					}
				});
			});
			</script>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Password"); ?></label>
			<div class="controls">
				<input class="pw" type="password" name="hxs-customer[pw]"<?PHP if(isset($signup) && $signup['pw']) { echo " value='". $signup['pw']."'"; } ?> /><span class="help-inline"></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Password repeat"); ?></label>
			<div class="controls">
				<input class="pw-repeat" type="password" name="hxs-customer[pw-repeat]"<?PHP if(isset($signup) && $signup['pw-repeat']) { echo " value='". $signup['pw-repeat']."'"; } ?> /><span class="help-inline"></span>
			</div>
		</div>
		<script>
		jQuery(function() {
			jQuery(".pw-repeat").keyup( function() {
				if( jQuery(this).val() != jQuery(".pw").val() ) {
					jQuery(this).closest(".control-group").addClass("error").find("span.help-inline").text("<?PHP echo __("Passwords do not match."); ?>");
				} else {
					jQuery(this).closest(".control-group").removeClass("error").find("span.help-inline").text("");
				}
			});
		});
		</script>
	</fieldset>
	<div class="form-actions">
		<a href="<?PHP echo get_option( "hxs-domain-c-page" ); ?>" class="btn"><?PHP echo __("go back"); ?></a>&nbsp;
		<input type="submit" class="btn btn-primary" name="submit" value="<?PHP echo __("Continue - review order"); ?>" />
	</div>
</form> 
