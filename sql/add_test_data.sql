
/*
  Salasana on hashattu password_hash funktiolla ja PASSWORD_BCRYPT flagilla
  Hashin sisältämä salasana on: salasana
*/
INSERT INTO kayttaja (tunnus, salasana) VALUES ('tunnus1', '$2y$10$wLq/x9iI969DADB4ZHOLFergkomDoVE44iNurjFh.appVMEgu/XKe');
INSERT INTO kayttaja (tunnus, salasana) VALUES ('tunnus2', '$2y$10$wLq/x9iI969DADB4ZHOLFergkomDoVE44iNurjFh.appVMEgu/XKe');

INSERT INTO askare (teksti, tarkeysaste) VALUES ('hello', 1);
INSERT INTO askare (teksti, tarkeysaste) VALUES ('hello again', 2);

INSERT INTO luokka (nimi, vari) VALUES (
  'testiluokka1',
  '#d73a49'
);

INSERT INTO luokka (nimi, vari) VALUES (
  'testiluokka2',
  'pink'
);

INSERT INTO kayttajaaskare (kayttaja_id, askare_id) VALUES (
  (SELECT id FROM kayttaja WHERE tunnus='tunnus1'),
  (SELECT id FROM askare WHERE teksti='hello')
);

INSERT INTO kayttajaaskare (kayttaja_id, askare_id) VALUES (
  (SELECT id FROM kayttaja WHERE tunnus='tunnus1'),
  (SELECT id FROM askare WHERE teksti='hello again')
);

INSERT INTO kayttajaluokka (kayttaja_id, luokka_id) VALUES (
  (SELECT id FROM kayttaja WHERE tunnus='tunnus1'),
  (SELECT id FROM luokka WHERE nimi='testiluokka1')
);

INSERT INTO askareluokka (askare_id, luokka_id) VALUES (
  (SELECT id FROM askare WHERE teksti='hello'),
  (SELECT id FROM luokka WHERE nimi='testiluokka1')
);

INSERT INTO kayttajaluokka (kayttaja_id, luokka_id) VALUES (
  (SELECT id FROM kayttaja WHERE tunnus='tunnus1'),
  (SELECT id FROM luokka WHERE nimi='testiluokka2')
);

INSERT INTO askareluokka (askare_id, luokka_id) VALUES (
  (SELECT id FROM askare WHERE teksti='hello'),
  (SELECT id FROM luokka WHERE nimi='testiluokka2')
);
