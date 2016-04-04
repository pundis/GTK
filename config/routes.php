<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/courses', function() {
  	HelloWorldController::courses();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });

