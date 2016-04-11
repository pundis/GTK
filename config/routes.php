<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/courses', function() {
  	CourseController::index();
  });

  $routes->get('/courses/new', function() {
    CourseController::create();
  });

  $routes->post('/courses', function() {
    CourseController::store();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/courses/:id', function($id){
    CourseController::show($id);
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

