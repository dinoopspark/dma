<?php

class TestController extends BaseController {

    public static $column = 25;

    function test() {
        
        echo Hash::make('testuser09');
            
        
    }
    
    
    function test_template() {
        return View::make("templatetest.index");
    }

    static function test249() {
        $hit = Post::getpost(37);
        echo 'post tilel: ' . $hit->post_title . '<br />';
        echo 'post description: ' . $hit->post_content . '<br />';
        echo 'Location:' . $hit->postmeta->location . '<br />';
    }

    static function test250() {
        $hit = Post::getpost(37);
        echo '<pre>', print_r($hit), '</pre>';
        exit();
    }
    
    static function test251() {
        Post::remove(39);
    }

    function need() {
        self::$column = 2;
    }

    static function looktoday() {
        $opt_val = date('Y-m-d H:i:s');
        Option::add('looktoday', $opt_val);
    }

    static function lookweekday() {
        $opt_val = date('l');
        Option::add('lookweekday', $opt_val);
    }

    static function lookmonth() {
        $opt_val = date('F');
        Option::add('lookmonth', $opt_val);
    }

}
