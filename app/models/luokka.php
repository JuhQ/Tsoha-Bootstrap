<?php

class Luokka extends BaseModel {

  public $id, $nimi, $vari;

  public static function getAll() {
    $query = DB::connection()->prepare('SELECT nimi, vari FROM luokka ORDER BY nimi');
    $query->execute();

    return array_map(function($row) {
      return new Luokka($row);
    }, $query->fetchAll());
  }

  public static function getByNimi($nimi) {
    $query = DB::connection()->prepare('
      SELECT
        nimi, vari
      FROM
        luokka
      WHERE
        nimi = :nimi
      ');
    $query->execute(array('nimi' => $nimi));

    return new Luokka($query->fetch());
  }

  public static function save($nimi, $vari) {
    $query = DB::connection()->prepare('INSERT INTO luokka (nimi, vari) VALUES (:nimi, :vari) RETURNING id');
    $query->execute(array('nimi' => $nimi, 'vari' => $vari));
    $row = $query->fetch();

    return $row['id'];
  }
}