<?php

class AskareLuokka extends BaseModel {

  public $askare_id, $luokka_id;

  public static function getByIds($askare_id, $luokka_id) {
    $query = DB::connection()->prepare('
      SELECT
        askare_id, luokka_id
      FROM
        askareluokka
      WHERE
        askare_id = :askare_id AND
        luokka_id = :luokka_id
      ');
    $query->execute(array('askare_id' => $askare_id, 'luokka_id' => $luokka_id));

    return new AskareLuokka($query->fetch());
  }

  // TODO: Tarviiko tämän returnaa mitään
  public static function save($askare_id, $luokka_id) {
    $query = DB::connection()->prepare('INSERT INTO askareluokka (askare_id, luokka_id) VALUES (:askare_id, :luokka_id)');
    $query->execute(array('askare_id' => $askare_id, 'luokka_id' => $luokka_id));
    $row = $query->fetch();

    return $row;
  }

  // TODO: not yet used
  public static function remove($askare_id, $luokka_id) {
    $query = DB::connection()->prepare('REMOVE FROM askareluokka WHERE askare_id = :askare_id AND luokka_id = :luokka_id LIMIT 1');
    $query->execute(array('askare_id' => $askare_id, 'luokka_id' => $luokka_id));
  }

  public static function removeByAskareId($askare_id) {
    $query = DB::connection()->prepare('REMOVE FROM askareluokka WHERE askare_id = :askare_id LIMIT 1');
    $query->execute(array('askare_id' => $askare_id));
  }
}
