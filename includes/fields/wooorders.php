<?php

/**
 * Register new Ninja Forms field
 */
function ninja_forms_register_field_wooorders()
{
	$args = array(
		'name'               =>  __( 'My Orders', 'ninja-forms' ),
		'sidebar'            =>  'template_fields',
		'edit_function'      =>  'ninja_forms_field_wooorders_edit',
		'display_function'   =>  'ninja_forms_field_wooorders_display',
		'save_function'      =>  '',
		'group'              =>  'standard_fields',
		'edit_label'         =>  true,
		'edit_label_pos'     =>  true,
		'edit_req'           =>  true,
		'edit_custom_class'  =>  true,
		'edit_help'          =>  true,
		'edit_desc'          =>  true,
		'edit_meta'          =>  false,
		'edit_conditional'   =>  true


	);

	ninja_forms_register_field( '_wooorders', $args );
}

add_action( 'init', 'ninja_forms_register_field_wooorders' );


/**
 * Edit field in admin
 */
function ninja_forms_field_wooorders_edit( $field_id, $data )
{
	$plugin_settings = nf_get_settings();
	

	
	$custom = '';
	
	// Default Value
	if( isset( $data['default_value'] ) ) {
		$default_value = $data['default_value'];
	} else {
		$default_value = '';
	}
	if( $default_value == 'none' ) {
		$default_value = '';
	}

	?>
	<div class="description description-thin">

		<label for="" id="default_value_label_<?php echo $field_id;?>" style="<?php if( $custom == 'no' ) { echo 'display:none;'; } ?>">
			<span class="field-option">
			<?php _e( 'Default Value' , 'ninja-forms' ); ?><br />
			<input type="text" class="widefat code" name="ninja_forms_field_<?php echo $field_id; ?>[default_value]" id="ninja_forms_field_<?php echo $field_id; ?>_default_value" value="<?php echo $default_value; ?>" />
			</span>
		</label>

	</div>

	<?php
}


/**
 * Display field on front-end
 */
function ninja_forms_field_wooorders_display( $field_id, $data )
{
	global $current_user;
	$field_class = ninja_forms_get_field_class( $field_id );

	if( isset( $data['default_value'] ) ) {
		$default_value = $data['default_value'];
	} else {
		$default_value = '';
	}

	if( isset( $data['label_pos'] ) ) {
		$label_pos = $data['label_pos'];
	} else {
		$label_pos = "left";
	}

	if( isset( $data['label'] ) ) {
		$label = $data['label'];
	} else {
		$label = '';
	}





	$values     = array();
	$labels     = array();

	$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
		'numberposts' => -1,
		'meta_key'    => '_customer_user',
		'meta_value'  => get_current_user_id(),
		'post_type'   => wc_get_order_types( 'view-orders' ),
		'post_status' => array_keys( wc_get_order_statuses() )
	) ) );


	$i = 0;

	foreach ( $customer_orders as $customer_order ) {
		$order = wc_get_order( $customer_order );
		$order->populate( $customer_order );
		$item_count = $order->get_item_count();

		$labels[$i] = '#'.$order->get_order_number().'( Status: '.wc_get_order_status_name( $order->get_status()) .')';
		$values[$i] = '#'.$order->get_order_number();
		$i++;
	}

	
	?>
	<!--input id="ninja_forms_field_<?php echo $field_id; ?>"    name="ninja_forms_field_<?php echo $field_id; ?>" type="text" class="<?php echo $field_class; ?> <?php echo $mask_class; ?> ninja-forms-date" value="<?php echo $default_value; ?>" rel="<?php echo $field_id; ?>" /-->
	<select name="ninja_forms_field_<?php echo $field_id;?>" id="ninja_forms_field_<?php echo $field_id;?>" class="<?php echo $field_class;?>" rel="<?php echo $field_id;?>">
		<?php
		if($label_pos == 'inside'){
			?>
			<option value=""><?php echo $label;?></option>
		<?php
		}

		foreach($labels as $k => $label){

			$value  = $values[$k];



			$value = htmlspecialchars( $value, ENT_QUOTES );
			$label = htmlspecialchars( $label, ENT_QUOTES );
			$label = stripslashes( $label );
			$label = str_replace( '&amp;', '&', $label );

			?>
			<option value="<?php echo $value;?>"  >  <?php echo $label;?> </option>
		<?php
		}
		?>
	</select>
	<?php

}


