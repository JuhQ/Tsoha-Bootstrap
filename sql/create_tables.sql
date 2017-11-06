
CREATE TABLE kayttaja (
  id SERIAL PRIMARY KEY,
  tunnus VARCHAR(50) NOT NULL,
  salasana VARCHAR(50) NOT NULL,
  rekisteroitymisPaiva DATE DEFAULT CURRENT_DATE
);

CREATE TABLE askare (
  id SERIAL PRIMARY KEY,
  teksti VARCHAR(400) NOT NULL,
  tarkaysaste INTEGER DEFAULT 0,
  luontipaiva DATE DEFAULT CURRENT_DATE
);

CREATE TABLE luokka (
  id SERIAL PRIMARY KEY,
  nimi VARCHAR(50) NOT NULL,
  vari VARCHAR(10) NOT NULL
);

CREATE TABLE kayttajaAskare (
  kayttaja_id INTEGER REFERENCES kayttaja(id),
  askare_id INTEGER REFERENCES askare(id)
);

CREATE TABLE kayttajaLuokka (
  kayttaja_id INTEGER REFERENCES kayttaja(id),
  luokka_id INTEGER REFERENCES luokka(id)
);

CREATE TABLE askareLuokka (
  askare_id INTEGER REFERENCES askare(id),
  luokka_id INTEGER REFERENCES luokka(id)
);
