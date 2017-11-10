<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });


  // Notes
  $routes->get('/esimerkkilistaus', function() {
    NotesController::exampleList();
  });

  $routes->post('/create', function() {
    NotesController::notImplemented();
  });

  $routes->get('/edit/:id', function($id) {
    NotesController::edit($id);
  });

  $routes->post('/edit/:id', function($id) {
    NotesController::notImplemented($id);
  });

  $routes->get('/remove/:id', function($id) {
    NotesController::notImplemented($id);
  });

  $routes->get('/view/:id', function($id) {
    NotesController::viewSingle($id);
  });



  // users
  $routes->get('/login', function() {
    UserController::login();
  });

  $routes->get('/signup', function() {
    UserController::signup();
  });

  $routes->post('/login', function() {
    UserController::loginAction();
  });

  $routes->post('/signup', function() {
    UserController::signupAction();
  });
