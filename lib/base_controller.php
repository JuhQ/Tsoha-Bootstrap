<?php

  class BaseController{

    public static function get_user_logged_in(){
      // Toteuta kirjautuneen käyttäjän haku tähän
      $kayttaja_id = 1;
      $user = Kayttaja::getById($kayttaja_id);

      // TODO: ehkä vaan
      // return $user;

      if ($user) {
        return $user;
      }

      return null;
    }

    public static function check_logged_in(){
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

  }
