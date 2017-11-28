<?php

  class BaseController{

    public static function get_user_logged_in() {
      // Toteuta kirjautuneen käyttäjän haku tähän
      if (!isset($_SESSION['user'])) {
        return false;
      }

      return Kayttaja::getById($_SESSION['user']);
    }

    public static function check_logged_in() {
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).

      if (!isset($_SESSION['user'])) {
        Redirect::to('/login', array(
          'message' => 'Et ole vielä kirjautunut sisälle.',
          'error' => true
        ));
        return false;
      }

      return self::get_user_logged_in();
    }

  }
