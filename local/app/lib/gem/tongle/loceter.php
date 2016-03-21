<?php

namespace gem\tongle;

use app\models\User;

class loceter  {

    function __construct() {
        
    }
    
    function not() {
        
        $users = User::paginate(10);
        print_r($users);
        
        return 'test '. __CLASS__;
    }

}