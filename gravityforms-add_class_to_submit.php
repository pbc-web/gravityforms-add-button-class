<?php

/*
  Plugin Name: Gravity Forms: Add Class To Submit Button
  Plugin URI: http://wordpress.org/extend/plugins/gravityforms-add-class-to-submit/
  Description: Adds a Field to Gravity Forms' Form Settings that lets you add a collection of CSS classes 
  Author: poweredbycoffee
  Version: 1.0
  Author URI: http://poweredbycoffee.co.uk
 */


add_filter("gform_form_settings", "pbc_gf_add_class_to_button_ui", 10, 2);
function pbc_gf_add_class_to_button_ui($form_settings, $form){

    $form_settings["Form Button"]["button_class"] = '
    <tr id="form_button_text_setting" class="child_setting_row" style="' . $text_style_display . '">
            <th>
                ' .
      __( 'Button Class', 'gravityforms' ) . ' ' .
      gform_tooltip( 'form_button_class', '', true ) .
      '
    </th>
    <td>
      <input type="text" id="form_button_text_class" name="form_button_text_class" class="fieldwidth-3" value="' . esc_attr( rgars( $form, 'button/class' ) ) . '" />
            </td>
        </tr>';

    return $form_settings;

}



add_filter( 'gform_pre_form_settings_save', "pbc_gf_add_class_to_button_process", 10, 1);
 function pbc_gf_add_class_to_button_process($updated_form){
  $updated_form['button']['class'] = rgpost( 'form_button_text_class' );
  return $updated_form;
}


add_filter("gform_submit_button", "pbc_gf_add_class_to_button_front_end", 10, 2);
function pbc_gf_add_class_to_button_front_end($button, $form){

    

     preg_match("/class='[\.a-zA-Z_ -]+'/", $button, $classes);
     $classes[0] = substr($classes[0], 0, -1);
     $classes[0] .= ' ';
     $classes[0] .= esc_attr($form['button']['class']);
     $classes[0] .= "'";

    $button_pieces = preg_split(
              "/class='[\.a-zA-Z_ -]+'/", 
              $button,
              -1,
              PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
    );

    return $button_pieces[0] . $classes[0] . $button_pieces[1];

}