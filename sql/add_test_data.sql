
INSERT INTO kayttaja (tunnus, salasana) VALUES ('tunnus1', 'salasana');
INSERT INTO kayttaja (tunnus, salasana) VALUES ('tunnus2', 'salasana');

INSERT INTO askare (teksti, tarkeysaste) VALUES ('hello', 1);

INSERT INTO luokka (nimi, vari) VALUES (
  'testiluokka1',
  '#d73a49'
);

INSERT INTO kayttajaAskare (kayttaja_id, askare_id) VALUES (
  (SELECT id FROM kayttaja WHERE tunnus='tunnus1'),
  (SELECT id FROM askare WHERE teksti='hello')
);

INSERT INTO kayttajaLuokka (kayttaja_id, luokka_id) VALUES (
  (SELECT id FROM kayttaja WHERE tunnus='tunnus1'),
  (SELECT id FROM luokka WHERE nimi='testiluokka1')
);

INSERT INTO askareLuokka (askare_id, luokka_id) VALUES (
  (SELECT id FROM askare WHERE teksti='hello'),
  (SELECT id FROM luokka WHERE nimi='testiluokka1')
);
