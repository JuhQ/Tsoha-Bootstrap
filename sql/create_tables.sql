
CREATE TABLE kayttaja (
  id SERIAL PRIMARY KEY,
  tunnus VARCHAR(50) NOT NULL,
  salasana VARCHAR(70) NOT NULL,
  rekisteroitymisPaiva DATE DEFAULT CURRENT_DATE
);

CREATE TABLE askare (
  id SERIAL PRIMARY KEY,
  teksti VARCHAR(400) NOT NULL,
  tarkeysaste INTEGER DEFAULT 0,
  luontipaiva DATE DEFAULT CURRENT_DATE
);

CREATE TABLE luokka (
  id SERIAL PRIMARY KEY,
  nimi VARCHAR(50) NOT NULL,
  vari VARCHAR(10) NOT NULL
);

CREATE TABLE kayttajaaskare (
  FOREIGN KEY kayttaja_id INTEGER REFERENCES kayttaja(id),
  FOREIGN KEY askare_id INTEGER REFERENCES askare(id)
);

CREATE TABLE kayttajaluokka (
  FOREIGN KEY kayttaja_id INTEGER REFERENCES kayttaja(id),
  FOREIGN KEY luokka_id INTEGER REFERENCES luokka(id)
);

CREATE TABLE askareluokka (
  FOREIGN KEY askare_id INTEGER REFERENCES askare(id),
  FOREIGN KEY luokka_id INTEGER REFERENCES luokka(id)
);
