<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->post('/courses/:id/destroy', function($id){
    CourseController::destroy($id);
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

  $routes->get('/courses/:id', function($id){
    CourseController::show($id);
  });

  $routes->get('/courses/:id/edit', function($id){
    CourseController::edit($id);
  });

  $routes->post('/courses/:id/edit', function($id){
    CourseController::update($id);
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    UserController::login();
  });

  $routes->post('/login', function() {
    UserController::handle_login();
  });
