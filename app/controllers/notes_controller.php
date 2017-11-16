<?php

function cleanData($data) {
  if (empty($data['luokat'])) {
    $data['luokat'] = array();
  }
  if (empty($data['tarkeysaste'])) {
    $data['tarkeysaste'] = 1;
  }
  return $data;
}

class NotesController extends BaseController {
  public static function list($luokka = false) {
    // Kayttajan id toistaiseksi kovakoodattu
    $kayttaja_id = 1;
    $content = array(
      'list' => array_chunk(Askare::getAll($kayttaja_id), 4),
      'title' => 'Listaus'
    );
    View::make('notes/list.html', $content);
  }

  public static function edit($id) {
    // Kayttajan id toistaiseksi kovakoodattu
    $kayttaja_id = 1;
    View::make('notes/edit.html', array('item' => Askare::getById($kayttaja_id, $id)));
  }

  public static function viewSingle($id) {
    // Kayttajan id toistaiseksi kovakoodattu
    $kayttaja_id = 1;
    View::make('notes/single-note.html', array('item' => Askare::getById($kayttaja_id, $id)));
  }

  public static function save($data) {
    // Kayttajan id toistaiseksi kovakoodattu
    $kayttaja_id = 1;
    $data = cleanData($data);

    if (empty($data['teksti'])) {
      Redirect::to('/list');
      returm;
    }

    Askare::save($kayttaja_id, $data['teksti'], $data['tarkeysaste'], $data['luokat']);
    Redirect::to('/list', array('message' => 'Askare luotu'));
  }

  public static function saveEdit($data) {
    // Kayttajan id toistaiseksi kovakoodattu
    $kayttaja_id = 1;
    $data = cleanData($data);
    if (empty($data['teksti'])) {
      Redirect::to('/list');
      returm;
    }

    Askare::saveEdit($kayttaja_id, $data['id'], $data['teksti'], $data['tarkeysaste'], $data['luokat']);
    Redirect::to('/view/' . $data['id'], array('message' => 'Askaretta muokattu'));
  }

  public static function remove($id) {
    // Kayttajan id toistaiseksi kovakoodattu
    $kayttaja_id = 1;
    Askare::remove($kayttaja_id, $id);
    Redirect::to('/list', array('message' => 'Askare poistettu'));
  }

  public static function notImplemented() {
    echo "Tätä askareeseen liitettyä toimintoa ei ole vielä toteutettu";
  }

}
