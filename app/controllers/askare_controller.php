<?php

function cleanData($data) {
  // Sallitaan max 10 luokkaa per askare
  $maxMaaraLuokkia = 10;
  if (isset($data['luokat']) && is_string($data['luokat'])) {
    $luokat = explode(',', trim($data['luokat']));
    $data['luokat'] = implode(',', array_slice($luokat, 0, $maxMaaraLuokkia));
  }

  if (empty($data['luokat'])) {
    $data['luokat'] = array();
  }

  if (empty($data['tarkeysaste']) || !is_numeric($data['tarkeysaste'])) {
    $data['tarkeysaste'] = 0;
  }

  if (isset($data['teksti'])) {
    $data['teksti'] = trim($data['teksti']);
  }

  return $data;
}

class AskareController extends BaseController {

  private static function get_current_user_id() {
    return self::get_user_logged_in()->id;
  }

  private static function check_login_status() {
    if (!self::get_user_logged_in()) {
      Redirect::to('/', array(
        'message' => 'Et ole kirjautunut sisään',
        'error' => true
      ));
      return false;
    }

    return true;
  }

  public static function list($luokka = false) {
    if (!self::check_login_status()) {
      return false;
    }

    $content = array(
      'list' => array_chunk(Askare::getAll(self::get_current_user_id()), 4),
      'title' => 'Listaus'
    );

    View::make('askareet/list.html', $content);
  }

  public static function edit($id) {
    if (!self::check_login_status()) {
      return false;
    }

    View::make('askareet/edit.html', array(
      'item' => Askare::getById(self::get_current_user_id(), $id)
    ));
  }

  public static function viewSingle($id) {
    if (!self::check_login_status()) {
      return false;
    }

    View::make('askareet/single-askare.html', array(
      'item' => Askare::getById(self::get_current_user_id(), $id)
    ));
  }

  public static function create() {
    if (!self::check_login_status()) {
      return false;
    }

    View::make('askareet/add-askare.html');
  }

  private static function setSaveErrorData($data) {
    if (isset($data['luokat']) && !empty($data['luokat'])) {
      $data['luokatString'] = $data['luokat'];
    }

    if (isset($data['tarkeysaste']) && !empty($data['tarkeysaste'])) {
      $data['tarkeysaste'] = (int) $data['tarkeysaste'];
    }

    return $data;
  }

  public static function save($data) {
    if (!self::check_login_status()) {
      return false;
    }

    $data = cleanData($data);

    if (!isset($data['teksti']) || empty($data['teksti'])) {
      self::setSaveErrorData($data);

      Redirect::to('/add', array(
        'highlight' => 'teksti',
        'message' => '⚠️ Askareen lisäyksessä ongelma, et voi tallentaa tyhjää tekstiä! Askareellasi täytyy olla jotain sisältöä, kuten myös elämällä. Life is like a box of askares.',
        'error' => true,
        'item' => $data
      ));

      return false;
    }

    Askare::save(self::get_current_user_id(), $data['teksti'], $data['tarkeysaste'], $data['luokat']);
    Redirect::to('/list', array('message' => 'Askare luotu'));
    return true;
  }

  public static function saveEdit($id, $data) {
    if (!self::check_login_status()) {
      return false;
    }

    $data = cleanData($data);

    if (!isset($id, $data['id']) || empty($id) || empty($data['id'])) {
      Redirect::to('/list', array(
        'highlight' => 'id',
        'message' => 'Askareen muokkauksessa ongelma, jostain kumman syystä ID puuttuu! Käytithän virallista(tm) askarelomaketta?',
        'error' => true
      ));
      return false;
    }

    if (!isset($data['teksti']) || empty($data['teksti'])) {
      Redirect::to('/list', array(
        'highlight' => 'teksti',
        'message' => 'Askareen muokkauksessa ongelma, et voi tallentaa tyhjää tekstiä! Askareellasi täytyy olla jotain sisältöä, kuten myös elämällä. Life is like a box of askares.',
        'error' => true
      ));
      return false;
    }

    Askare::update($id, self::get_current_user_id(), $data['teksti'], $data['tarkeysaste'], $data['luokat']);
    Redirect::to('/view/' . $data['id'], array('message' => 'Askaretta muokattu'));
    return true;
  }

  public static function remove($id) {
    if (!self::check_login_status()) {
      return false;
    }

    if (!isset($id) || empty($id)) {
      Redirect::to('/list', array('message' => 'Askareen id puuttuu, ei voida poistaa'));
      return false;
    }

    Askare::remove(self::get_current_user_id(), $id);
    Redirect::to('/list', array('message' => 'Askare poistettu'));
    return true;
  }
}
