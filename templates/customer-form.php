
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

<form method="POST" action="?validate=" class="form-horizontal" id="hxs-login">
	<fieldset><legend><?PHP echo ( get_option( "hxs-reseller-license" ) != "reseller" ? __("Existing HostingXS B.V. customer") : __("Existing customer") ); ?></legend>
		
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Username"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-login[un]" id="hxs-username" class="hxs-username" /><span class="help-inline"></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Password"); ?></label>
			<div class="controls">
				<input type="password" name="hxs-login[pw]" class="hxs-password" /><span class="help-inline"></span>
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<a href="<?PHP echo get_option( "hxs-domain-c-page" ); ?>" class="btn"><?PHP echo __("go back"); ?></a>&nbsp;
		<input type="submit" class="btn btn-primary" name="submit" value="<?PHP echo __("Continue - review order"); ?>" />
	</div>
	<script>
		jQuery(function() {
			jQuery("#hxs-login").submit( function(e) {
				e.preventDefault();
				var $form		= jQuery(this);
				var $unfield		= $form.find(".hxs-username");
				var $pwfield		= $form.find(".hxs-password");
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
					type:		'POST',
					success:	function( html ) {
						if( html == "false" ) {
							$unfield.closest(".control-group").addClass("error").find("span.help-inline").text("<?PHP echo __("Account is unknown, please create a new account."); ?>");
							
							return false;
						} else {
							return true;
						} 
					}
				});
			});
		});
	</script>
</form>

<form method="POST" action="?validate=" class="form-horizontal">
	<fieldset><legend><?PHP echo __("Personal information"); ?></legend>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Initials"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[initials]" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("First name"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[firstname]" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Last name"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[lastname]" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Gender"); ?></label>
			<div class="controls">
				<label class="checkbox">
					<input type="radio" name="hxs-customer[gender]" value="1" />
					<?PHP echo __("Male"); ?>
				</label>
				<label class="checkbox">
					<input type="radio" name="hxs-customer[gender]" value="0" />
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
					<option value="9"><?PHP echo __("Private person"); ?></option>
					<option value="1"><?PHP echo __("Dutch `eenmanszaak`"); ?></option>
					<option value="2"><?PHP echo __("Dutch `VoF`"); ?></option>
					<option value="3"><?PHP echo __("Dutch `CV`"); ?></option>
					<option value="4"><?PHP echo __("Dutch `maatschap`"); ?></option>
					<option value="5"><?PHP echo __("Dutch `BV`"); ?></option>
					<option value="6"><?PHP echo __("Dutch `stichting`"); ?></option>
					<option value="7"><?PHP echo __("Dutch `vereniging`"); ?></option>
					<option value="8"><?PHP echo __("Dutch `NV`"); ?></option>
					<option value="11"><?PHP echo __("Dutch `co&ouml;peratie`"); ?></option>
					<option value="12"><?PHP echo __("Dutch `kerk`"); ?></option>
					<option value="13"><?PHP echo __("Dutch `BV in oprichting`"); ?></option>
					<option value="14"><?PHP echo __("Dutch `onderlinge waarborg maatschappij`"); ?></option>
					<option value="15"><?PHP echo __("Dutch `rederij`"); ?></option>

					<option value="10"><?PHP echo __("Foreign company"); ?></option>

					<option value="16"><?PHP echo __("European Corporation"); ?></option>
					<option value="17"><?PHP echo __("European Economical Collaboration"); ?></option>
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
				<input type="text" name="hxs-customer[dob]" placeholder="YYYY-MM-DD" />
			</div>
		</div>
		<div class="control-group legal-show">
			<label class="control-label"><?PHP echo __("Company name"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[company]" />
			</div>
		</div>
		<div class="control-group legal-show">
			<label class="control-label"><?PHP echo __("VAT number"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[vat]" placeholder="NL00000000001B01" />
				<span class="help-inline"><?PHP echo __("International Tax Number"); ?></span>
			</div>
		</div>
		<div class="control-group legal-show">
			<label class="control-label"><?PHP echo __("CoC number"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[coc]" />
				<span class="help-inline"><?PHP echo __("Chamber of Commerce"); ?></span>
			</div>
		</div>
	</fieldset>
	<fieldset><legend><?PHP echo __("Address information"); ?></legend>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Street & housenumber"); ?></label>
			<div class="controls">
				<div>
					<input type="text" name="hxs-customer[address]" />
					<input type="text" name="hxs-customer[houseno]" class="span1" />
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Postal code"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[postal]" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("City"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[city]" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Country"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[country]" placeholder="UK" />
				<span class="help-inline"><?PHP echo __("Use the ISO-code of your country."); ?></span>
			</div>
		</div>
	</fieldset>
	<fieldset><legend><?PHP echo __("Login information"); ?></legend>
		<div class="alert alert-info">
			<?PHP echo __("This username and password combination is used for logging into the controlpanel to manage your products and services."); ?>
		</div>
		<div class="control-group well well-small">
			<label class="control-label"><?PHP echo __("Username"); ?></label>
			<div class="controls">
				<input type="text" name="hxs-customer[un]" id="hxs-username" class="hxs-username" /><span class="help-inline"></span>
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
						$field.closest(".controls").find("span.help-inline").html("");
						$field.closest(".control-group").removeClass("error");
						
					}
				});
			});
			</script>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Password"); ?></label>
			<div class="controls">
				<input type="password" name="hxs-customer[pw]" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"><?PHP echo __("Password repeat"); ?></label>
			<div class="controls">
				<input type="password" name="hxs-customer[pw-repeat]" />
			</div>
		</div>
	</fieldset>
	<div class="form-actions">
		<a href="<?PHP echo get_option( "hxs-domain-c-page" ); ?>" class="btn"><?PHP echo __("go back"); ?></a>&nbsp;
		<input type="submit" class="btn btn-primary" name="submit" value="<?PHP echo __("Continue - review order"); ?>" />
	</div>
</form> 
