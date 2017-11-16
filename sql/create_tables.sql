
CREATE TABLE kayttaja (
  id SERIAL PRIMARY KEY,
  tunnus VARCHAR(50) NOT NULL UNIQUE,
  salasana VARCHAR(70) NOT NULL,
  rekisteroitymispaiva TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE askare (
  id SERIAL PRIMARY KEY,
  teksti VARCHAR(400) NOT NULL,
  tarkeysaste INTEGER DEFAULT 0,
  luontipaiva TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE luokka (
  id SERIAL PRIMARY KEY,
  nimi VARCHAR(50) NOT NULL,
  vari VARCHAR(10) NOT NULL DEFAULT 'pink'
);

CREATE TABLE kayttajaaskare (
  kayttaja_id INTEGER REFERENCES kayttaja(id),
  askare_id INTEGER REFERENCES askare(id)
);

CREATE TABLE kayttajaluokka (
  kayttaja_id INTEGER REFERENCES kayttaja(id),
  luokka_id INTEGER REFERENCES luokka(id)
);

CREATE TABLE askareluokka (
  askare_id INTEGER REFERENCES askare(id),
  luokka_id INTEGER REFERENCES luokka(id)
);
