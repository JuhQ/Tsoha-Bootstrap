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

  public static function edit($nimi) {
    $luokka = Luokka::getByNimi($nimi);
    if (!$luokka) {
      Redirect::to('/luokat', array(
        'message' => 'Luokkaa ei löydy',
        'error' => true
      ));
      return false;
    }

    View::make('luokat/edit.html', array(
      'luokka' => $luokka
    ));

    return true;
  }

  public static function saveEdit($id, $nimi, $vari) {
    if (empty(trim($nimi))) {
      Redirect::to('/luokat', array(
        'message' => 'Luokan nimi ei voi olla tyhjä',
        'error' => true
      ));
      return false;
    }

    if (empty(trim($vari))) {
      Redirect::to('/luokat', array(
        'message' => 'Luokan väri ei voi olla tyhjä',
        'error' => true
      ));
      return false;
    }

    $luokka = Luokka::getById($id);
    $existing = Luokka::getByNimi($nimi);
    if ($existing && $luokka && $existing->id !== $luokka->id) {
      Redirect::to('/luokat/' . $existing->nimi . '/edit', array(
        'message' => 'Luokan muokkaaminen ei onnistu, uuden nimen niminen luokka on jo olemassa',
        'error' => true,
        'luokka' => array(
          'id' => $id,
          'nimi' => $nimi,
          'vari' => $vari
        )
      ));
      return false;
    }

    if (!$luokka) {
      Redirect::to('/luokat/', array(
        'message' => 'Luokan muokkaaminen ei onnistu, annetulla id:llä ei löydy luokkaa (ehkä se on poistettu?)',
        'error' => true
      ));
      return false;
    }

    Luokka::edit($luokka->id, trim($nimi), trim($vari));

    Redirect::to('/luokat/' . $luokka->nimi, array(
      'message' => 'Luokkaa muokattu, jee!'
    ));

    return true;
  }

  public static function remove($nimi) {
    $success = Luokka::removeByNimi($nimi);

    if ($success) {
      Redirect::to('/luokat', array(
        'message' => 'Luokka ' . $nimi . ' poistettu listasta'
      ));
    } else {
      Redirect::to('/luokat/' . $nimi, array(
        'message' => 'Luokan ' . $nimi . ' poistaminen ei onnistunut',
        'error' => true
      ));
    }
  }

}
