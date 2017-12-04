<?php

  function check_logged_in() {
    BaseController::check_logged_in();
  }

  $routes->get('/', function() {
    HomeController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HomeController::sandbox();
  });


  // Notes
  $routes->get('/list', 'check_logged_in', function() {
    AskareController::list();
  });

  // TODO: deprekoi tai lisää filtteröintitoiminnallisuus
  $routes->get('/list/:luokka', 'check_logged_in', function($luokka) {
    AskareController::list($luokka);
  });

  $routes->get('/add', 'check_logged_in', function() {
    AskareController::create();
  });

  $routes->post('/create', 'check_logged_in', function() {
    AskareController::save($_POST);
  });

  $routes->get('/edit/:id', 'check_logged_in', function($id) {
    AskareController::edit($id);
  });

  $routes->post('/edit/:id', 'check_logged_in', function($id) {
    AskareController::saveEdit($id, $_POST);
  });

  $routes->get('/remove/:id', 'check_logged_in', function($id) {
    AskareController::remove($id);
  });

  $routes->get('/view/:id', 'check_logged_in', function($id) {
    AskareController::viewSingle($id);
  });


  // users
  $routes->get('/login', function() {
    UserController::login();
  });

  $routes->get('/logout', function() {
    UserController::logout();
  });

  $routes->get('/signup', function() {
    UserController::signup();
  });

  $routes->post('/login', function() {
    UserController::loginAction($_POST['username'], $_POST['password']);
  });

  $routes->post('/signup', function() {
    UserController::signupAction($_POST['username'], $_POST['password'], $_POST['password2']);
  });


  // luokat
  $routes->get('/luokat', function() {
    LuokkaController::list();
  });

  $routes->get('/luokat/:nimi', function($nimi) {
    LuokkaController::viewSingle($nimi);
  });
