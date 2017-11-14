<?php

class NotesController extends BaseController {
  public static function list($luokka = false) {
    // Kayttajan id toistaiseksi kovakoodattu
    $kayttaja_id = 1;
    $content = array(
      'list' => array_chunk(Askare::getAll($kayttaja_id), 4),
      'title' => 'Esimerkkilistaus'
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
    $luokat = array();
    if (isset($data['luokat'])) {
      $luokat = $data['luokat'];
    }
    Askare::save($kayttaja_id, $data['teksti'], $data['tarkeysaste'], $luokat);
  }

  public static function saveEdit($data) {
    // Kayttajan id toistaiseksi kovakoodattu
    $kayttaja_id = 1;
    $luokat = array();
    if (isset($data['luokat'])) {
      $luokat = $data['luokat'];
    }
    Askare::saveEdit($kayttaja_id, $data['teksti'], $data['tarkeysaste'], $luokat);
  }

  public static function remove($id) {
    // Kayttajan id toistaiseksi kovakoodattu
    $kayttaja_id = 1;
    Askare::remove($kayttaja_id, $id);
  }

  public static function notImplemented() {
    echo "Tätä askareeseen liitettyä toimintoa ei ole vielä toteutettu";
  }

}
