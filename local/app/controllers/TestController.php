<?php

class TestController extends BaseController {

    public static $column = 25;

    function test() {
        CategoryController::ng_get_field_set(13);
    }
    
    
    function test_template() {
         View::make("templatetest.index");
    }

}
