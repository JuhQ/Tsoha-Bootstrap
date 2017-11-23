<?php

function cleanData($data) {
  // Sallitaan max 10 luokkaa per askare
  $maxClasses = 10;
  if (isset($data['luokat']) && is_string($data['luokat'])) {
    $data['luokat'] = implode(',', array_slice(explode(',', $data['luokat']), 0, $maxClasses));
  }

  if (empty($data['luokat'])) {
    $data['luokat'] = array();
  }

  if (empty($data['tarkeysaste'])) {
    $data['tarkeysaste'] = 0;
  }

  return $data;
}

class NotesController extends BaseController {

  private static function get_current_user_id() {
    return self::get_user_logged_in()->id;
  }

  private static function check_login_status() {
    $kayttaja = self::get_user_logged_in();
    if ($kayttaja === false) {
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
    View::make('notes/list.html', $content);
  }

  public static function edit($id) {
    if (!self::check_login_status()) {
      return false;
    }

    View::make('notes/edit.html', array('item' => Askare::getById(self::get_current_user_id(), $id)));
  }

  public static function viewSingle($id) {
    if (!self::check_login_status()) {
      return false;
    }

    View::make('notes/single-note.html', array('item' => Askare::getById(self::get_current_user_id(), $id)));
  }

  public static function create() {
    if (!self::check_login_status()) {
      return false;
    }

    View::make('notes/add-note.html');
  }

  public static function save($data) {
    if (!self::check_login_status()) {
      return false;
    }

    $data = cleanData($data);

    if (!isset($data['teksti']) || empty($data['teksti'])) {
      $data['luokatString'] = $data['luokat'];
      $data['tarkeysaste'] = (int) $data['tarkeysaste'];

      Redirect::to('/add', array(
        'message' => 'Askareen lisäyksessä ongelma',
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

    if (!isset($id, $data['id'], $data['teksti']) || empty($id)  || empty($data['id']) || empty($data['teksti'])) {
      Redirect::to('/list', array('message' => 'Askareen muokkauksessa ongelma', 'error' => true));
      return;
    }

    Askare::update($id, self::get_current_user_id(), $data['teksti'], $data['tarkeysaste'], $data['luokat']);
    Redirect::to('/view/' . $data['id'], array('message' => 'Askaretta muokattu'));
  }

  public static function remove($id) {
    if (!self::check_login_status()) {
      return false;
    }

    if (!isset($id) || empty($id)) {
      Redirect::to('/list', array('message' => 'Askareen id puuttuu, ei voida poistaa'));
      return;
    }

    Askare::remove(self::get_current_user_id(), $id);
    Redirect::to('/list', array('message' => 'Askare poistettu'));
  }
}
