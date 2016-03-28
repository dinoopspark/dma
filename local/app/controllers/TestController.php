<?php

class TestController extends BaseController {

    public static $column = 25;

    function test() {
        Category::create_table();
    }
    
    
    function test_template() {
         View::make("templatetest.index");
    }

}
