<?php

class Kayttaja extends BaseModel {

  public $id, $luokka_id, $salasana, $rekisteroitymispaiva;

  public static function getById($id) {
    $query = DB::connection()->prepare('
      SELECT
        id, tunnus, salasana, rekisteroitymispaiva
      FROM
        kayttaja
      WHERE
        id = :id
      ');
    $query->execute(array('id' => $id));
    $row = $query->fetch();
    if (!$row) {
      return false;
    }

    return new Kayttaja($row);
  }

  public static function getByTunnus($tunnus) {
    $query = DB::connection()->prepare('
      SELECT
        id, tunnus, salasana, rekisteroitymispaiva
      FROM
        kayttaja
      WHERE
        tunnus = :tunnus
      ');
    $query->execute(array('tunnus' => $tunnus));
    $row = $query->fetch();
    if (!$row) {
      return false;
    }

    return new Kayttaja($row);
  }

  public static function save($tunnus, $salasana, $salasana2) {
    $salasana = password_hash($salasana, PASSWORD_BCRYPT);
    $query = DB::connection()->prepare('INSERT INTO kayttaja (tunnus, salasana) VALUES (:tunnus, :salasana) RETURNING id');
    $query->execute(array('tunnus' => $tunnus, 'salasana' => $salasana));
    $row = $query->fetch();

    return $row['id'];
  }

  public static function authenticate($tunnus, $salasana) {
    if (!isset($tunnus, $salasana) || empty($tunnus) || empty($salasana)) {
      return false;
    }

    $kayttaja = Kayttaja::getByTunnus($tunnus);
    if (!$kayttaja) {
      return false;
    }

    return password_verify($salasana, $kayttaja->salasana) ? $kayttaja : false;
  }

  public static function validate_tunnus($tunnus) {
    $minLength = 3;
    return !empty($tunnus) && $tunnus !== null && strlen($tunnus) >= $minLength;
  }

  public static function min_salasana() {
    return 3;
  }

  public static function validate_password($password, $password2) {
    return $password === $password2 && !empty($password) && strlen($password) >= self::min_salasana();
  }
}
