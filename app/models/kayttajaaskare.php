<?php

class KayttajaAskare extends BaseModel {

  public $askare_id, $kayttaja_id;

  public static function getByIds($kayttaja_id, $askare_id) {
    $query = DB::connection()->prepare('
      SELECT
        askare_id, kayttaja_id
      FROM
        kayttajaaskare
      WHERE
        askare_id = :askare_id AND
        kayttaja_id = :kayttaja_id
      ');
    $query->execute(array('kayttaja_id' => $kayttaja_id, 'askare_id' => $askare_id));

    return new KayttajaAskare($query->fetch());
  }

  // TODO: Tarviiko tämän returnaa mitään
  public static function save($kayttaja_id, $askare_id) {
    $query = DB::connection()->prepare('INSERT INTO kayttajaaskare (askare_id, kayttaja_id) VALUES (:askare_id, :kayttaja_id)');
    $query->execute(array('kayttaja_id' => $kayttaja_id, 'askare_id' => $askare_id));
    $row = $query->fetch();

    return $row;
  }

  public static function remove($kayttaja_id, $askare_id) {
    $query = DB::connection()->prepare('REMOVE FROM kayttajaaskare WHERE askare_id = :askare_id AND kayttaja_id = :kayttaja_id LIMIT 1');
    $query->execute(array('kayttaja_id' => $kayttaja_id, 'askare_id' => $askare_id));
  }

  // TODO: might not be needed
  // public static function removeByAskareId($askare_id) {
  //   $query = DB::connection()->prepare('REMOVE FROM kayttajaaskare WHERE askare_id = :askare_id');
  //   $query->execute(array('askare_id' => $askare_id));
  // }
}