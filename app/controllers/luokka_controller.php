<?php

class LuokkaController extends BaseController {

  public static function list() {
    $content = array(
      'luokat' => Luokka::getAll(),
      'title' => 'Luokkalistaus'
    );

    View::make('luokat/list.html', $content);
  }

  public static function viewSingle($nimi) {
    View::make('luokat/single.html', array(
      'luokka' => Luokka::getByNimi($nimi)
    ));
  }

}
