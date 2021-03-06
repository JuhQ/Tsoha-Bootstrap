<?php

class KayttajaLuokka extends BaseModel {

  public $kayttaja_id, $luokka_id;

  public static function getByids($kayttaja_id, $luokka_id) {
    $query = DB::connection()->prepare('
      SELECT
        kayttaja_id, luokka_id
      FROM
        kayttajaluokka
      WHERE
        kayttaja_id = :kayttaja_id AND
        luokka_id = :luokka_id
    ');

    $query->execute(array(
      'kayttaja_id' => $kayttaja_id,
      'luokka_id' => $luokka_id
    ));

    $row = $query->fetch();
    if (!$row) {
      return false;
    }

    return new KayttajaLuokka($row);
  }

  // TODO: Tarviiko tämän returnaa mitään
  public static function save($kayttaja_id, $luokka_id) {
    $query = DB::connection()->prepare('
      INSERT INTO
        kayttajaluokka (kayttaja_id, luokka_id)
      VALUES
        (:kayttaja_id, :luokka_id)
    ');

    $query->execute(array(
      'kayttaja_id' => $kayttaja_id,
      'luokka_id' => $luokka_id
    ));
    $row = $query->fetch();

    return $row;
  }

  public static function remove($kayttaja_id, $luokka_id) {
    $query = DB::connection()->prepare('
      DELETE FROM
        kayttajaluokka
      WHERE
        kayttaja_id = :kayttaja_id AND
        luokka_id = :luokka_id
    ');

    $query->execute(array(
      'kayttaja_id' => $kayttaja_id,
      'luokka_id' => $luokka_id
    ));
  }

  public static function removeByLuokkaId($luokka_id) {
    $query = DB::connection()->prepare('
      DELETE FROM
        kayttajaluokka
      WHERE
        luokka_id = :luokka_id
    ');

    $query->execute(array(
      'luokka_id' => $luokka_id
    ));
  }
}
