<?php

  class UserController extends BaseController {
    public static function login() {
      View::make('users/login.html', array('title' => 'Luo tunnus'));
    }

    public static function signup() {
      View::make('users/signup.html', array('title' => 'Rekisteröidy'));
    }

    public static function loginAction() {
      echo 'Jos login toimisi, tässä oltaisiin';
    }

    public static function signupAction() {
      echo 'Jos signup toimisi, tässä oltaisiin';
    }

  }
