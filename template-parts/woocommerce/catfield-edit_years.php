<?php 
$flatep_meta_years = get_query_var('flatep_meta_years_value');
?>
<tr class="form-field">
    <th scope="row" valign="top"><label for="flatep_meta_years"><?php _e('Meta Years', 'flatep'); ?></label></th>
    <td>
        <input type="text" name="flatep_meta_years" id="flatep_meta_years" value="<?php if (isset($flatep_meta_years)) { echo esc_attr($flatep_meta_years); } ?>">
        <p class="description"><?php _e('Enter years of category, eg ( 2016 or 2015 - 2017 )', 'flatep'); ?></p>
    </td>
</tr>