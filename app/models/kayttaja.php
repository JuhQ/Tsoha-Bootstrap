<?php

class Kayttaja extends BaseModel {

  public $id, $luokka_id;

  public static function getById($id) {
    $query = DB::connection()->prepare('
      SELECT
        id, tunnus, rekisteroitymispaiva
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
        id, tunnus, rekisteroitymisPaiva
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

  public static function save($tunnus, $salasana) {
    $salasana = password_hash($salasana, PASSWORD_BCRYPT);
    $query = DB::connection()->prepare('INSERT INTO kayttaja (tunnus, salasana) VALUES (:tunnus, :salasana) RETURNING id');
    $query->execute(array('tunnus' => $tunnus, 'salasana' => $salasana));
    $row = $query->fetch();

    return $row['id'];
  }

  public static function authenticate($tunnus, $salasana) {
    $tunnus = Kayttaja::getByTunnus($tunnus);
    return password_verify($tunnus['salasana'], $salasana) ? $tunnus : false;
  }

  public static function validate_tunnus($tunnus) {
    $minLength = 3;
    return !empty($tunnus) && $tunnus !== null && strlen($tunnus) >= $minLength;
  }
}
