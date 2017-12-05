<?php

class Luokka extends BaseModel {

  public $id, $nimi, $vari;

  public static function getAll() {
    $query = DB::connection()->prepare('
      SELECT
        id, nimi, vari
      FROM
        luokka
      ORDER BY nimi
    ');

    $query->execute();

    return array_map(function($row) {
      return new Luokka($row);
    }, $query->fetchAll());
  }

  public static function getByNimi($nimi) {
    $query = DB::connection()->prepare('
      SELECT
        id, nimi, vari
      FROM
        luokka
      WHERE
        nimi = :nimi
    ');

    $query->execute(array('nimi' => $nimi));
    $row = $query->fetch();

    if (!$row) {
      return false;
    }

    return new Luokka($row);
  }

  public static function getById($id) {
    $query = DB::connection()->prepare('
      SELECT
        id, nimi, vari
      FROM
        luokka
      WHERE
        id = :id
    ');

    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if (!$row) {
      return false;
    }

    return new Luokka($row);
  }

  public static function save($nimi, $vari) {
    $query = DB::connection()->prepare('
      INSERT INTO
        luokka (nimi, vari)
      VALUES
        (:nimi, :vari)
      RETURNING id
    ');

    $query->execute(array(
      'nimi' => $nimi,
      'vari' => $vari
    ));
    $row = $query->fetch();

    return $row['id'];
  }

  public static function edit($id, $nimi, $vari) {
    $query = DB::connection()->prepare('
      UPDATE
        luokka
      SET
        nimi = :nimi,
        vari = :vari
      WHERE
        id = :id
    ');

    $query->execute(array(
      'id' => $id,
      'nimi' => $nimi,
      'vari' => $vari
    ));
    $row = $query->fetch();

    return true;
  }

  public static function removeByNimi($nimi) {
    $luokka = Luokka::getByNimi($nimi);
    if (!$luokka) {
      return false;
    }

    AskareLuokka::removeByLuokkaId($luokka->id);
    KayttajaLuokka::removeByLuokkaId($luokka->id);

    $query = DB::connection()->prepare('
      DELETE FROM
        luokka
      WHERE
        id = :id
    ');

    $query->execute(array(
      'id' => $luokka->id
    ));

    return true;
  }
}
