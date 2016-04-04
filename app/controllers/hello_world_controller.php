<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('index.html');
    }

    public static function sandbox(){
      View::make('helloworld.html');
    }

    public static function courses(){
    	View::make('courses.html');
    }
    
  }
