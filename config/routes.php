<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/playedcourses', function() {
    PlayedCourseController::index();
  });

  $routes->get('/playedcourses/new', function() {
    PlayedCourseController::create();
  });

  $routes->post('/playedcourses/new2', function() {
    PlayedCourseController::create2();
  }); 

  $routes->post('/playedcourses/new', function() {
    PlayedCourseController::store();
  });


  $routes->get('/user/:id', function($id) {
    UserController::show($id);
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

  $routes->post('/logout', function(){
    UserController::logout();
  });

  $routes->get('/login', function() {
    UserController::login();
  });

  $routes->post('/login', function() {
    UserController::handle_login();
  });

  $routes->get('/playedcourses/:id', function($id) {
    PlayedCourseController::show($id);
  });
