<?php

function sortByPriority($a, $b) {
  return $a['tarkeysaste'] < $b['tarkeysaste'] ? -1 : 1;
}

class NotesController extends BaseController {
  public static function exampleList() {
    $quotes = array();
    $quotes[] = "The world is, of course, nothing but our conception of it.";
    $quotes[] = "Life has no meaning a priori… It is up to you to give it a meaning, and value is nothing but the meaning that you choose.";
    $quotes[] = "One repays a teacher badly if one always remains nothing but a pupil.";
    $quotes[] = "Try again. Fail again. Fail better.";
    $quotes[] = "One must not let oneself be misled: they say 'Judge not!' but they send to Hell everything that stands in their way.";
    $quotes[] = "One thought-murder a day keeps the psychiatrist away.";


    $list = array();
    $list[] = array('id' => 1, 'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 1, 'luontipaiva' => time()-10000);
    $list[] = array('id' => 2,'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 2, 'luontipaiva' => time());
    $list[] = array('id' => 3,'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 3, 'luontipaiva' => time());
    $list[] = array('id' => 1, 'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 4, 'luontipaiva' => time()-100003);
    $list[] = array('id' => 2,'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 5, 'luontipaiva' => time());
    $list[] = array('id' => 3,'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 3, 'luontipaiva' => time());
    $list[] = array('id' => 1, 'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 1, 'luontipaiva' => time()-100002);
    $list[] = array('id' => 2,'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 2, 'luontipaiva' => time());
    $list[] = array('id' => 3,'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 3, 'luontipaiva' => time());
    $list[] = array('id' => 1, 'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 1, 'luontipaiva' => time()-100004);
    $list[] = array('id' => 2,'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 5, 'luontipaiva' => time());
    $list[] = array('id' => 3,'teksti' => $quotes[array_rand($quotes)], 'tarkeysaste' => 4, 'luontipaiva' => time());
    $list[] = array('id' => 4,'teksti' => '<h2>html:ää ei saa rendata</h2>', 'tarkeysaste' => 1, 'luontipaiva' => time());
    $list[] = array('id' => 4,'teksti' => 'tässä on rivinvaihto
      tässä kohtaa', 'tarkeysaste' => 1, 'luontipaiva' => time());


    usort($list, "sortByPriority");

    $content = array('list' => array_chunk($list, 4), 'title' => 'Esimerkkilistaus');
    View::make('notes/list.html', $content);
  }

  public static function edit($id) {
    $content = array('item' => array('id' => 3,'teksti' => 'editoidaan tätä tekstiä, kovakoodattu arvo', 'tarkeysaste' => 4, 'luontipaiva' => time()));
    View::make('notes/edit.html', $content);
  }

  public static function viewSingle($id) {
    $content = array('item' => array('id' => 3,'teksti' => 'One repays a teacher badly if one always remains nothing but a pupil.', 'tarkeysaste' => 4, 'luontipaiva' => time()));

    View::make('notes/single-note.html', $content);
  }

  public static function notImplemented() {
    echo "Tätä askareeseen liitettyä toimintoa ei ole vielä toteutettu";
  }

}
