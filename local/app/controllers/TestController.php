<?php

class TestController extends BaseController {

    public static $column = 25;

    function test() {
        
    }
    
    
    function test_template() {
        return View::make("templatetest.index");
    }

}
