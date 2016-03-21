<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    protected $table = 'users';
    protected $hidden = array('password', 'remember_token');
    protected $guarded = array('id', 'password');
    protected $fillable = array('username', 'password', 'name', 'email', 'phone', 'role');
    public static $rules = array(
        'username' => 'required|unique:users',
        'email' => 'required|email',
        'password' => 'required|same:password_confirmation'
    );
    public static $rules_edit = array(
        'email' => 'required|email',
    );
    public static $rules_update_password = array(
        'password' => 'required',
        'password_confirmation' => 'required|same:password'
    );
    public static $system_roles = array(
        'sup_admin' => array(
            'name' => 'Super admin',
            'capabilities' => array(
                'view_user_lists',
                'user_add',
                'user_edit',
                'user_delete',
                'case_add',
                'case_edit',
                
            ),
        ),
        'sub_admin' => array(
            'name' => 'Sub admin',
            'capabilities' => array(
                'view_user_lists',
                'user_add',
                'user_edit',
                'user_delete',
            ),
        ),
        'client' => array(
            'capabilities' => array(),
        ),
    );
    public static $form = array(
        'form_id' => 'userform',
        'route' => 'users.store',
        'submit' => 'Save',
        'cancel' => true,
        'fields' => array(
            array(
                'type' => 'text',
                'label' => 'Name',
                'name' => 'name',
            ),
            array(
                'type' => 'select',
                'label' => 'Role',
                'name' => 'role',
                'options' => array(
                    'sup_admin' => 'Super admin',
                    'sub_admin' => 'Sub admin'
                ),
            ),
            array(
                'type' => 'text',
                'label' => 'Username',
                'name' => 'username',
            ),
            array(
                'type' => 'password',
                'label' => 'Password',
                'name' => 'password',
            ),
            array(
                'type' => 'password',
                'label' => 'Confirm password',
                'name' => 'password_confirmation',
            ),
            array(
                'type' => 'email',
                'label' => 'Email',
                'name' => 'email',
            ),
            array(
                'type' => 'text',
                'label' => 'Phone',
                'name' => 'phone',
            ),
        )
    );

    public static function hasrole($capability, $condition = 'AND') {

        if (!isset(Auth::user()->role)) {
            return false;
        }

        $role = Auth::user()->role;

        if (array_key_exists($role, self::$system_roles)) {

            if (is_array($capability)) {

                if ($condition == 'OR') {
                    foreach ($capability as $value) {
                        if (in_array($value, self::$system_roles[$role]['capabilities'])) {
                            return true;
                        }
                    }
                }

                if ($condition == 'AND') {
                    $have = array();
                    foreach ($capability as $key => $value) {

                        if (in_array($value, self::$system_roles[$role]['capabilities'])) {
                            $have[] = 1;
                        }
                    }

                    if (count($capability) == count($have)) {
                        return true;
                    }
                }
            } else {
                if (in_array($capability, self::$system_roles[$role]['capabilities'])) {

                    return true;
                }
            }
        }

        return false;
    }

    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

    public function getRememberToken() {
        return $this->remember_token;
    }

    public function setRememberToken($value) {
        $this->remember_token = $value;
    }

    public function getRememberTokenName() {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail() {
        return $this->email;
    }

    public static function prepare_form() {
        $form = self::$form;
        $new_fields = array();
        foreach ($form['fields'] as $value) {
            if (!isset($value['name'])) {
                if (in_array($value['type'], array('heading', 'para'))) {
                    $heading = 'heading_' . rand();
                    $new_fields[$heading] = $value;
                }
                continue;
            }
            $new_fields[$value['name']] = $value;
        }
        $form['fields'] = $new_fields;
        return $form;
    }

    public static function prepare_edit_form() {
        $form = self::prepare_form();
        $form['route'] = 'users.update';
        $form['submit'] = 'Save Changes';
        $non_required_fields = array('password', 'password_confirmation');
        $non_required_fields = array_fill_keys($non_required_fields, '');
        $form['fields'] = array_diff_key($form['fields'], $non_required_fields);
        return $form;
    }

    public static function prepare_change_password_form() {
        $form = self::prepare_form();

        $form['submit'] = 'Save Password';
        $form['cancel'] = false;
        $required_fields = array('password', 'password_confirmation');

        $fields = array();
        foreach ($required_fields as $value) {
            if (isset($form['fields'][$value])) {
                $fields[$value] = $form['fields'][$value];
            }
        }
        $form['fields'] = $fields;

        return $form;
    }

}
