<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('index.html');
    }

    public static function sandbox(){
      $course = new Course(array(
        'name' => 'd',
        'city' => 'e',
        'holes' => 'kaka'
        ));
      $errors = $course->errors();

      Kint::dump($errors);
    }

    public static function login(){
      View::make('login.html');
    }
    
  }
