<?php

  class UserController extends BaseController {
    public static function login() {
      View::make('users/login.html', array('title' => 'Luo tunnus'));
    }

    public static function signup() {
      View::make('users/signup.html', array('title' => 'Rekisteröidy'));
    }

    public static function loginAction($tunnus, $salasana) {
      $detailsExist = isset($salasana, $salasana);

      if (!$detailsExist) {
        Redirect::to('/signup', array(
          'message' => 'Tunnus ei ole validi! 😵 Tunnus tai salasana tyhjä.',
          'error' => true
        ));
        return false;
      }

      $user = Kayttaja::authenticate($tunnus, $salasana);

      if ($user) {
        $_SESSION['user'] = $user->id;

        Redirect::to('/list', array(
          'message' => 'Kirjauduttu sisälle samperi! 😎'
        ));
        return true;
      }

      Redirect::to('/signup', array(
        'message' => 'Kirjautuminen ei onnistu! 😵',
        'error' => true
      ));
      return false;
    }

    public static function signupAction($tunnus, $salasana, $salasana2) {
      $detailsExist = isset($salasana, $salasana, $salasana2);

      if (!$detailsExist) {
        Redirect::to('/signup', array(
          'message' => 'Tunnus ei ole validi! 😵 Tunnus tai salasana tyhjä.',
          'error' => true
        ));
        return false;
      }

      if (!$Kayttaja::validate_password($salasana, $salasana2)) {
        Redirect::to('/signup', array(
          'message' => 'Salasana ei ole validi! 😵 Salasanan pitää olla vähintään ' . Kayttaja::min_salasana() . ' merkkiä pitkä.',
          'error' => true
        ));
        return false;
      }

      if (!Kayttaja::validate_tunnus($tunnus)) {
        Redirect::to('/signup', array(
          'message' => 'Tunnus ei ole validi! 😵 Tunnuksen täytyy olla vähintään kolme (3) merkkiä.',
          'error' => true
        ));
        return false;
      }

      if (Kayttaja::getByTunnus($tunnus)) {
        Redirect::to('/signup', array(
          'message' => 'Käyttäjätunnus on jo varattu perhana! 😵',
          'error' => true
        ));
        return false;
      }

      $userid = Kayttaja::save($tunnus, $salasana);
      $_SESSION['user'] = $userid;
      Redirect::to('/list', array(
        'message' => 'Tunnuksesi on luotu onnistuneesti! Tervetuloa muistiinpanolistan jäseneksi, olet maailman paras ihminen! 😍💕'
      ));
      return true;
    }
  }
