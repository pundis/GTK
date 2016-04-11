<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('index.html');
    }

    public static function sandbox(){
      $forest = Course::find(1);
      $courses = Course::all();
      Kint::dump($forest);
      Kint::dump($courses);
    }

    public static function login(){
      View::make('login.html');
    }
    
  }
