<?php

class Askare extends BaseModel {

  public $id, $teksti, $tarkeysaste, $luontipaiva, $luokat, $kayttaja_id;
  public $luokatString;

  public function __construct($attributes = array()) {
    // TODO: luokat tulee kannasta json stringinä, pitää tutkia asiaa lisää
    if (isset($attributes['luokat'])) {
      $attributes['luokat'] = array_filter(json_decode($attributes['luokat']));
      $luokkienNimet = array_map(function($luokka) {
        return $luokka->nimi;
      }, $attributes['luokat']);

      $attributes['luokatString'] = implode($luokkienNimet, ',');
    }

    parent::__construct($attributes);
  }

  public static function getAll($kayttaja_id) {
    $query = DB::connection()->prepare('
      SELECT
        askare.*,
        kayttajaaskare.kayttaja_id,
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
        askare.id, kayttajaaskare.kayttaja_id
      ORDER BY
        askare.tarkeysaste DESC
    ');
    $query->execute(array('kayttaja_id' => $kayttaja_id));
    $rows = $query->fetchAll();
    if (!$rows) {
      return false;
    }

    return array_map(function($row) {
      return new Askare($row);
    }, $rows);
  }

  public static function getById($kayttaja_id, $id) {
    $query = DB::connection()->prepare('
      SELECT
        askare.*,
        kayttajaaskare.kayttaja_id,
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
        askare.id, kayttajaaskare.kayttaja_id
      ');
    $query->execute(array('id' => $id, 'kayttaja_id' => $kayttaja_id));
    $row = $query->fetch();
    if (!$row) {
      return false;
    }

    return new Askare($row);
  }

  private static function setTarkeysAste($tarkeysaste = 1) {
    if (empty($tarkeysaste)) {
      $tarkeysaste = 1;
    }

    return $tarkeysaste;
  }

  public static function save($kayttaja_id, $teksti, $tarkeysaste = 1, $luokat = array()) {
    $query = DB::connection()->prepare('INSERT INTO askare (teksti, tarkeysaste) VALUES (:teksti, :tarkeysaste) RETURNING id');
    $query->execute(array('teksti' => $teksti, 'tarkeysaste' => self::setTarkeysAste($tarkeysaste)));
    $row = $query->fetch();
    $askare_id = $row['id'];

    KayttajaAskare::save($kayttaja_id, $askare_id);
    self::saveRelations($kayttaja_id, $askare_id, $luokat);
  }

  public static function update($askare_id, $kayttaja_id, $teksti, $tarkeysaste = 1, $luokat = array()) {
    $row = Askare::getById($kayttaja_id, $askare_id);
    if (!$row || $row->kayttaja_id !== $kayttaja_id) {
      return false;
    }

    $query = DB::connection()->prepare('
      UPDATE
        askare
      SET
        teksti = :teksti,
        tarkeysaste = :tarkeysaste
      WHERE
        id = :id
    ');
    $query->execute(array(
      'teksti' => $teksti,
      'tarkeysaste' => self::setTarkeysAste($tarkeysaste),
      'id' => $askare_id)
    );
    $row = $query->fetch();

    // Poista vanhat luokat
    AskareLuokka::removeByAskareId($askare_id);
    // Lisää uudet luokat
    self::saveRelations($kayttaja_id, $askare_id, $luokat, true);

    return true;
  }

  private static function saveRelations($kayttaja_id, $askare_id, $luokat, $skipKayttajaLuokka = false) {
    $luokkia = !empty($luokat) && (is_array($luokat) || is_string($luokat));
    $luokatOnStringeja = $luokkia && is_string($luokat);

    if ($luokkia && is_string($luokat)) {
      $luokat = explode(',', $luokat);
    }

    if ($luokkia) {
      $luokkaIds = self::mapLuokat($luokat, $luokatOnStringeja);

      foreach ($luokkaIds as $luokkaId) {
        AskareLuokka::save($askare_id, $luokkaId);

        if (!$skipKayttajaLuokka) {
          KayttajaLuokka::save($kayttaja_id, $luokkaId);
        }
      }
    }
  }

  private static function random_color_part() {
    return str_pad(dechex(mt_rand(50, 255)), 2, '0', STR_PAD_LEFT);
  }

  private static function generateHex() {
    return '#' . self::random_color_part() . self::random_color_part() . self::random_color_part();
  }

  private static function mapLuokat($luokat, $luokatOnStringeja) {
    return array_map(function($luokka) use ($luokat, $luokatOnStringeja) {
      if ($luokatOnStringeja) {
        $nimi = $luokka;
        $vari = self::generateHex();
      } else {
        $nimi = $luokka['nimi'];
        $vari = $luokka['vari'];
      }

      $existingLuokka = Luokka::getByNimi($nimi);
      return $existingLuokka ? $existingLuokka->id : Luokka::save($nimi, $vari);
    }, $luokat);
  }

  public static function remove($kayttaja_id, $askare_id) {
    $row = Askare::getById($kayttaja_id, $askare_id);

    if (!$row || $row->kayttaja_id !== $kayttaja_id) {
      return false;
    }

    AskareLuokka::removeByAskareId($askare_id);
    KayttajaAskare::remove($kayttaja_id, $askare_id);

    $query = DB::connection()->prepare('DELETE FROM askare WHERE id = :id');
    $query->execute(array('id' => $askare_id));
  }
}
