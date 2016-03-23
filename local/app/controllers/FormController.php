<?php

class FormController extends BaseController {

    public static function prepare_form($form) {

        $new_fields = array();
        foreach ($form['fields'] as $value) {
            if (!isset($value['name'])) {
                
                if (in_array($value['type'], array('heading', 'para', 'html'))) {
                    $heading = 'node_' . rand();
                    $new_fields[$heading] = $value;
                }
                continue;
            }
            $value['field_id'] = $form['form_id'] . '_' . $value['name'];
            $new_fields[$value['name']] = $value;
        }
        $form['fields'] = $new_fields;
        return $form;
    }

    public static function set_not_required_fields($form, $not_required_fields) {
        $not_required_fields = array_fill_keys($not_required_fields, '');
        return array_diff_key($form['fields'], $not_required_fields);
    }

    public static function set_required_fields($form, $required_fields) {
        $fields = array();
        foreach ($required_fields as $value) {
            if (isset($form['fields'][$value])) {
                $fields[$value] = $form['fields'][$value];
            }
        }
        return $fields;
    }

}
