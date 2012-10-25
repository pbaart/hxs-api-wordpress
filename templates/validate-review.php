
<ul class="breadcrumb">
	<li>
		<a href="<?PHP echo get_option( "hxs-domain-c-page" ); ?>"><?PHP echo __("domain check"); ?></a> <span class="divider">/</span>
	</li>
	<li>
		<a href="?customer="><?PHP echo __("customer"); ?></a> <span class="divider">/</span>
	</li>
	<li class="active">
		<?PHP echo __("review"); ?> <span class="divider">/</span>
	</li>
	<li>
		<?PHP echo __("finished"); ?></a>
	</li>
</ul>

<h1 class="page-header"><?PHP echo __("Review your order"); ?></h1>
<table class="table table-striped">
	<tr>
		<th>
			<?PHP echo __("Your details"); ?>
		</th>
		<td>
			<a href="?step=customer"><?PHP
			if( $customer -> customerid > 0 ) {
				echo sprintf( "%s %s %s" , __("Existing customer: ") , $customer -> firstname , $customer -> lastname );
			} else {
				echo sprintf( "%s %s %s" , __("New customer: ") , $customer -> firstname , $customer -> lastname );
			}
			?></a>
		</td>
	</tr>
	<tr>
		<th>
			<?PHP echo __("Your order"); ?>
		</th>
		<td> 
			<a href="<?PHP echo get_option( "hxs-domain-c-page" ); ?>"><?PHP
			echo $dom -> name;
			?></a>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="form-actions">
			<form method="POST" action="?action=order">
				<input type="submit" class="btn btn-primary" value="<?PHP echo __("confirm your order"); ?>" />
			</form>
		</td>
	</tr>
</table>
