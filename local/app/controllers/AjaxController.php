<?php

class AjaxController extends BaseController {

    public function index() {
        $input = Input::all();
        

        if ($input['action'] == 'user_edit') {
            UsersController::ajax_update($input);
        }

        if ($input['action'] == 'user_delete') {
            UsersController::ajax_delete($input);
        }
        
        if ($input['action'] == 'user_update_password') {
            UsersController::ajax_update_password($input);
        }
        
        if ($input['action'] == 'category_delete') {
            CategoryController::ajax_delete($input);
        }
        
        if($input['action'] == 'get_field_set'){
            $id = $input['model_id'];
            CategoryController::ng_get_field_set($id);
        }
    }

}
