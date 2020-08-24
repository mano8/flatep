<?php 
 $name = get_query_var('flatep_meta_years_name');
?>
<fieldset>
    <div id="gwp-flatep_meta_years" class="inline-edit-col">
        <label>
            <span class="title"><?php _e( 'Year', 'woocommerce' ); ?></span>
            <span class="input-text-wrap"><input type="text" name="<?php echo esc_attr( $name ); ?>" class="ptitle" value=""></span>
        </label>
    </div>
</fieldset>