<form class="form-horizontal well well-large" action="<?PHP echo get_option( "hxs-domain-c-page" ); ?>" method="POST">
	<div class="control-group">
		<label class="control-label"><?PHP echo __("Domain Check"); ?></label>
		<div class="controls">
			<div class="input-append">
				<input type="text" name="hxs-check" placeholder="<?PHP echo get_option( "hxs-domain-c-widget" ); ?>" value="<?PHP echo ($dom ? $dom -> name : ""); ?>" />
				<input class="btn" type="submit" name="submit" value="<?PHP echo __("check","hxs"); ?>" />
			</div>
		</div>
	</div>
</form>

<?PHP
	if( $dom ) { 		?>


<ul class="breadcrumb">
	<li class="active">
		<?PHP echo __("domain check"); ?> <span class="divider">/</span>
	</li>
	<li>
		<?PHP echo __("customer"); ?> <span class="divider">/</span>
	</li>
	<li>
		<?PHP echo __("review"); ?> <span class="divider">/</span>
	</li>
	<li>
		<?PHP echo __("finished"); ?>
	</li>
</ul>
<h3><?PHP echo $dom -> name; ?></h3>
<form class="form-horizontal" method='POST' action='?customer=' id="years">
	<div class="control-group">
		
		
			
			<?PHP
			foreach( $dom -> prices as $years => $price ) {		?>
		<label class="control-label"><?PHP echo $years; echo ($years > 1 ? __(" years") : __(" year ")); ?></label>
		<div class="controls">
			<div class="input-append">
				<input type="radio" name="hxs-order[years]" value="<?PHP echo $years; ?>" />
				<span class="add-on span2"><?PHP echo "&euro; "; echo number_format($price,2,",","."); echo __(" /year"); ?></span>
			</div>
		</div>
			<?PHP
			}							?>
			
		
	</div>
	<div class="form-actions">
		<input type="hidden" name="hxs-check" value="<?PHP echo $dom -> name; ?>" />
		<input class="btn btn-primary" type="submit" name="submit" value="<?PHP echo __("Continue - your details"); ?>" />
	</div>
	<script>
		jQuery(function() {
			jQuery("form#years").submit( function(e) {
//				return this.hxs-order
			});
		});
	</script>
</form>

<?PHP
	}			?>

<!--
		if( $c -> error ) {
			foreach( $c -> error as $e ) {
				$ret .= "<h4>".$e."</h4>";
			}
		}
		if( isset( $doms ) && count( $doms )) {
			$ret		.= "<form method='POST' action='?customer='>";
			foreach( $doms as $dom ) {
				$ret	.=  "<h3>". $dom -> name . "</h3>";
				$ret	.=   "<p class='dom-". ($dom -> free ? "free" : "move" ). "'>";
				if( !$dom -> free ) {
					$ret 	.= __("This domain is already registered, if it is yours and you wish to move it or contact us later to finish the transfer.");
					$ret	.= "<input id='authcode-".$dom -> name."' type='text' name='authcode[".$dom -> name."]' size='40' value='authcode for ".$dom -> name."' />";
				}
				$ret	.= "<ul>";
				foreach( $dom -> prices as $jaren => $p ) {
					$ret	.=   "<li><input style='margin-right: 15px;' type='radio' name='order[".$dom -> name."]' value='".$jaren."' />&euro; ".$p."/".__("year")." ".__("for")." ".$jaren." ".($jaren > 1 ? __("years") : __("year"))."</li>";
				}
				$ret	.=   "</ul>";
				$ret	.=   "</p>";
			}
			$ret		.= "<input type='hidden' name='hxs-check' value='".$dom -> name."' /><input type='submit' name='order-submit' value='".__("Continue order")."' />";
			$ret		.= "</form>";
-->