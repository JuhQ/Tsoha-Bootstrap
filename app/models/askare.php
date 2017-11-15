<?php


class Askare extends BaseModel {

  public $id, $teksti, $tarkeysaste, $luontipaiva, $luokat;

  public function __construct($attributes = array()) {
    // TODO: luokat tulee kannasta json stringinä, pitää tutkia asiaa lisää
    if (isset($attributes['luokat'])) {
      $attributes['luokat'] = array_filter(json_decode($attributes['luokat']));
    }

    parent::__construct($attributes);
  }

  public static function getAll($kayttaja_id) {
    $query = DB::connection()->prepare('
      SELECT
        askare.*,
        json_agg(luokka) AS luokat
      FROM
        kayttajaaskare
      LEFT JOIN
        askare ON askare.id = kayttajaaskare.askare_id
      LEFT JOIN
        askareluokka ON askareluokka.askare_id = askare.id
      LEFT JOIN
        luokka ON luokka.id = askareluokka.luokka_id
      WHERE
        kayttajaaskare.kayttaja_id = :kayttaja_id
      GROUP BY
        askare.id
    ');
    $query->execute(array('kayttaja_id' => $kayttaja_id));
    $rows = $query->fetchAll();

    return array_map(function($row) {
      return new Askare($row);
    }, $rows);
  }

  public static function getById($kayttaja_id, $id) {
    $query = DB::connection()->prepare('
      SELECT
        askare.*,
        json_agg(luokka) AS luokat
      FROM
        kayttajaaskare
      LEFT JOIN
        askare ON askare.id = kayttajaaskare.askare_id
      LEFT JOIN
        askareluokka ON askareluokka.askare_id = askare.id
      LEFT JOIN
        luokka ON luokka.id = askareluokka.luokka_id
      WHERE
        askare.id = :id AND
        kayttajaaskare.kayttaja_id = :kayttaja_id
      GROUP BY
        askare.id
      ');
    $query->execute(array('id' => $id, 'kayttaja_id' => $kayttaja_id));

    return new Askare($query->fetch());
  }

  public static function save($kayttaja_id, $teksti, $tarkeysaste, $luokat = array()) {
    $query = DB::connection()->prepare('INSERT INTO askare (teksti, tarkeysaste) VALUES (:teksti, :tarkeysaste) RETURNING id');
    $query->execute(array('teksti' => $teksti, 'tarkeysaste' => $tarkeysaste));
    $row = $query->fetch();
    Kint::dump($row);

    $askare_id = $row['id'];

    KayttajaAskare::save($kayttaja_id, $askare_id);

    if (!empty($luokat) && is_array($luokat)) {
      $luokkaIds = array_map(function($luokka) {
        $existingLuokka = Luokka::findByName($luokka);
        return $existingLuokka ?
          $existingLuokka->id :
          Luokka::save($luokka['nimi'], $luokka['vari']);
      }, $luokat);

      foreach ($luokkaIds as $luokkaId) {
        Askareluokka::save($askare_id, $luokkaId);
        KayttajaLuokka::save($kayttaja_id, $luokkaId);
      }
    }
  }

  public static function remove($kayttaja_id, $id) {
    $row = Askare::getById($id);

    if ($row['kayttaja_id'] === $kayttaja_id) {
      $query = DB::connection()->prepare('REMOVE FROM askare WHERE id = :id LIMIT 1');
      $query->execute(array('id' => $id));

      Askareluokka::removeByAskareId($id);
      KayttajaAskare::remove($kayttaja_id, $id);
    }
  }
}
