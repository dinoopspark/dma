<?php

class TestController extends BaseController {

    public static $column = 25;

    function test() {
        
        Category::create_table_sql();
            
        
    }
    
    
    function test_template() {
        return View::make("templatetest.index");
    }

}
