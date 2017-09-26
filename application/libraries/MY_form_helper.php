<?php

function form_template($input, 
					   $error_msg = '', 
					   $label = '',
					   $template = '<div class="form-group{{has-error}}">{{label}} {{input}}</div>'
					  ){
    $form_str = $template;
    if ($error_msg != '') {
        $form_str = str_replace('{{has-error}}', ' has-error', $form_str);
        $form_str = str_replace('{{error-msg}}', $error_msg, $form_str);
    } else {
        $form_str = str_replace('{{has-error}}', '', $form_str);
        $form_str = str_replace('{{error-msg}}', '', $form_str);    
    }
	
	/*
	if ($label != '') {
		$label_tpl = '<label class="control-label">{{label-text}}</label>';
        $label_tpl = str_replace('{{label-text}}', $label, $label_tpl);
				
        $form_str = str_replace('{{label}}', $label_tpl, $form_str);
	} else {
        $form_str = str_replace('{{label}}', '', $form_str);		
	}
    */
	
    $form_str = str_replace('{{input}}', $input, $form_str);
    return $form_str;
}

