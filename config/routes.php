<?php

  $routes->get('/', function() {
    HomeController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HomeController::sandbox();
  });


  // Notes
  $routes->get('/list', function() {
    NotesController::list();
  });

  $routes->get('/list/:luokka', function($luokka) {
    NotesController::list($luokka);
  });

  $routes->post('/create', function() {
    NotesController::save($_POST);
  });

  $routes->get('/edit/:id', function($id) {
    NotesController::edit($id);
  });

  $routes->post('/edit/:id', function($id) {
    NotesController::notImplemented($id);
  });

  $routes->get('/remove/:id', function($id) {
    NotesController::remove($id);
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
    echo 'Kirjautuminen ei toimi vielä 😭';
    exit;
    if (isset($_POST['tunnus'], $_POST['salasana'])) {
      UserController::loginAction($_POST['tunnus'], $_POST['salasana']);
    } else {
      echo 'nope';
    }
  });

  $routes->post('/signup', function() {
    echo 'Rekisteröinti ei toimi vielä 😭';
    exit;
    if (isset($_POST['tunnus'], $_POST['salasana'])) {
      UserController::signupAction($_POST['tunnus'], $_POST['salasana']);
    } else {
      echo 'nope';
    }
  });
