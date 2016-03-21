<?php

class UsersController extends BaseController {

    public function index() {

        if (!User::hasrole("view_user_lists")) {
            return Redirect::to('admin/profile');
        }

        $users = User::paginate(10);
        return View::make('users.index', compact('users'));
    }

    public function create() {

        $form = FormController::prepare_form(User::$form);
        return View::make('users.create', compact('form'));
    }

    public function store() {
        $input = Input::all();
        $validation = Validator::make($input, User::$rules);

        if ($validation->passes()) {

            $input['password'] = Hash::make($input['password']);

            User::create($input);

            return Redirect::route('users.index');
        }

        return Redirect::route('users.create')
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
    }

    /**
     * 
     * Not using
     * @param type $id
     * @return type
     */
    public function show($id) {
        $user = User::find($id);
        if (is_null($user)) {
            return Redirect::route('users.index');
        }
        return View::make('users.show', compact('user'));
    }

    public function edit($id) {

        if (Auth::user()->id != $id && !User::hasrole('user_edit')) {
            return Redirect::to('admin/profile');
        }
        
        $user = User::find($id);
        if (is_null($user)) {
            return Redirect::route('users.index');
        }


        // Create form to update user data

        $form = FormController::prepare_form(User::$form);
        $form['form_id'] = 'user_edit';

        $form['fields'] = FormController::set_not_required_fields($form, array('password', 'password_confirmation'));
        if ($id == Auth::user()->id) {
            $form['fields'] = FormController::set_not_required_fields($form, array('role'));
        }

        $form['ajax'] = true;
        $form['route'] = 'users.update';
        $form['method'] = 'PATCH';
        $form['action'] = 'user_edit';
        $form['model'] = $user;

        // Create form to update password

        $password_change_form = FormController::prepare_form(User::$form);
        $password_change_form['form_id'] = 'change_password';
        $password_change_form['fields'] = FormController::set_required_fields($password_change_form, array('password', 'password_confirmation'));
        $password_change_form['action'] = 'user_update_password';
        $password_change_form['ajax'] = true;
        $password_change_form['cancel'] = false;

        $password_change_form['route'] = 'users.update';
        $password_change_form['method'] = 'PATCH';
        $password_change_form['model'] = $user;


        return View::make('users.edit', compact('user', 'form', 'password_change_form'));
    }

    /**
     * 
     * 
     * Replaced with ajax_update
     */
    public function update($id) {

        $input = Input::all();
        $validation = Validator::make($input, User::$rules_edit);

        if ($validation->passes()) {
            $user = User::find($id);
            $user->update($input);
            return Redirect::route('users.index');
        }

        return Redirect::route('users.edit', $id)
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
    }

    public function destroy($id) {
        User::find($id)->delete();
        return Redirect::route('users.index');
    }

    // custom function 

    public static function ajax_update_password($input) {
        if (!User::hasrole('user_edit')) {
            die();
        }

        $validation = Validator::make($input, User::$rules_update_password);

        if ($validation->passes()) {

            $input['password'] = Hash::make($input['password']);

            $id = $input['model_id'];
            $user = User::find($id);
            $user->update($input);

            $result = array(
                'result' => true,
                'message' => "Password cahnged successfully",
                'type' => 'success',
            );
        } else {

            $result = array(
                'type' => 'danger',
                'result' => true,
                'message' => "Couldnot change password",
            );
        }

        echo json_encode($result);

        die();
    }

    public static function ajax_update($input) {

        if (!User::hasrole('user_edit')) {
            die();
        }


        $validation = Validator::make($input, User::$rules_edit);

        if ($validation->passes()) {
            $id = $input['model_id'];
            $user = User::find($id);
            $user->update($input);

            $result = array(
                'result' => true,
                'message' => "Your changes have updated successfully.",
                'type' => 'success',
            );
        } else {

            $result = array(
                'type' => 'danger',
                'result' => true,
                'message' => "Error occured in updation",
            );
        }

        echo json_encode($result);

        die();
    }

    public static function ajax_delete($input) {

        if (User::hasrole('user_delete')) {

            $id = $input['model_id'];
            
            $action = $input['action'];

            if ($id == Auth::user()->id) {
                die();
            }

            if ($action == 'user_delete') {
                User::find($id)->delete();
                echo true;
            }
            
        }
        die();
    }

    public function login() {

        $input = Input::all();

        if (isset($input['username'], $input['password'])) {

            if (Auth::attempt(array('username' => $input['username'], 'password' => $input['password']))) {
                return Redirect::to('admin/profile');
            } else {
                $message = "Invalid username or password.";
                return View::make('users.login', compact('message'));
            }
        }

        if (Auth::check()) {
            return Redirect::to('admin/profile');
        } else {
            return View::make('users.login');
        }
    }

    function logout() {
        Auth::logout();
        return Redirect::to('admin/login');
    }

    function profile() {

        if (!isset(Auth::user()->id)) {
            return Redirect::to('admin/login');
        }

        return Redirect::to('users/' . Auth::user()->id . '/edit');
    }

}
