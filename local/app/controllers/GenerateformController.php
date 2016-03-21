<?php

class GenerateformController extends BaseController {

    function validate_form($form) {
        foreach ($form as $key => $value) {
            
            if($key = 'heading'){
                $head_open = (isset($value['tag']))? $value['tag'] : '<h2>';
                
            }
            
        }
        
    }

}
