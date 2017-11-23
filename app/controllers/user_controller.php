<?php

  class UserController extends BaseController {
    public static function login() {
      View::make('users/login.html', array('title' => 'Luo tunnus'));
    }

    public static function signup() {
      View::make('users/signup.html', array('title' => 'Rekisteröidy'));
    }

    public static function loginAction($tunnus, $salasana) {
      $user = Kayttaja::authenticate($tunnus, $salasana);
      if ($user) {
        echo 'Tunnus löytyi, tehdään jotain?<br>';
        $_SESSION['user'] = $user->id;
      }
      echo 'Jos login toimisi, tässä oltaisiin';
    }

    public static function signupAction($tunnus, $salasana) {
      if (!Kayttaja::validate_tunnus($tunnus)) {
        Redirect::to('/signup', array('message' => 'Tunnus ei ole validi! 😵 Tunnuksen täytyy olla vähintään kolme (3) merkkiä.', 'error' => true));
        return false;
      }

      if (Kayttaja::getByTunnus($tunnus)) {
        Redirect::to('/signup', array('message' => 'Käyttäjätunnus on jo varattu perhana! 😵', 'error' => true));
        return false;
      }

      $userid = Kayttaja::save($tunnus, $salasana);
      $_SESSION['user'] = $userid;
      Redirect::to('/list', array('message' => 'Tunnuksesi on luotu onnistuneesti! Tervetuloa muistiinpanolistan jäseneksi, olet maailman paras ihminen! 😍💕'));
      return true;
    }
  }
