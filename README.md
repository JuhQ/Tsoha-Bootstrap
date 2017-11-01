# Tietokantasovelluksen esittelysivu

Yleisiä linkkejä:

* [Linkki sovellukseeni](http://juhataur.users.cs.helsinki.fi/tsoha/)
* [Linkki dokumentaatiooni](https://github.com/JuhQ/Tsoha-Bootstrap/blob/master/doc/dokumentaatio.pdf)

## Työn aihe

Työn aiheena [muistilista](http://advancedkittenry.github.io/suunnittelu_ja_tyoymparisto/aiheet/Muistilista.html)



### TODO
Toimintoja:

- [ ] Rekisteröityminen
- [ ] Kirjautuminen
- [ ] Askareen lisäys, muokkaus ja poisto
- [ ] Tärkeysasteen lisäys ja poisto
- [ ] Askareen tärkeyttäminen lisäyksessä tai myöhemmin
- [ ] Luokkien lisäys ja poisto
- [ ] Askareiden luokittelu
- [ ] Luokat voivat olla sisäkkäisiä
- [ ] Yhdellä askareella voi olla monta luokkaa


### Johdanto
#### TODO: siirrä doc/dokumentaatio.pdf tiedostoon

Järjestelmän tarkoituksena on mahdollistaa henkilökohtaisten muistilistojen luonti ja ylläpito.
Järjestelmä mahdollistaa muistilistan tarjoamisen usealle käyttäjälle.

Järjestelmän tavoitteet on hepottaa käyttäjän elämää siirtämällä muistettavat asiat palvelun muistiin jotta käyttäjä voi keskittyä olennaiseen, eli bailaamiseen ja opiskeluun.

Toimintaympäristönä käytetään koulun users palvelinta.
Työ toteutetaan Apachen-palvelimen alla users palvelimella.
Alustan täytyy tukea PHP:tä
Palvelu toimii ilman javascriptiä, mutta javascript lisää käyttäjän käyttökokemusta.
Tietokantana käytetään PostgreSQL:ää.


### Käyttötapaukset
#### TODO: siirrä doc/dokumentaatio.pdf tiedostoon


Kirjautuminen
 - Muistilistaa voi käyttää kirjautumalla sisään henkilökohtaisille tunnuksilla
 - Tunnuksen voi luoda kuka tahansa
 - Käyttäjä voi myös kirjautua ulos
 - Käyttäjä voi vaihtaa salasanaa

Askareet
 - Sisäänkirjautunut käyttäjä voi luoda askareita
 - Sisäänkirjautunut käyttäjä voi muokata tallentamiaan askareita
 - Sisäänkirjautunut käyttäjä voi poistaa tallentamiaan askareita
 - Askareellek kuuluu tekstisisältö ja valinnaisesti nimi, luokka tai tärkeysaste

Priorisointi
 - Askareelle voi lisätä prioriteetin luomisvaiheessa
 - Askareen prioriteettiä voi muokata tallentamisen jälkeen
 - Askareen prioriteetin voi poistaa

Luokat
 - Askareelle voi lisätä luokkia joiden avulla askareita löytää helpommin
 - Askare voi kuulua useaan luokkaan
 - Yhteen luokkaan voi kuulua useita askareita
 - Askareesta voi poistaa luokkia
 - Luokkia voi uudelleen nimetä


### Käyttäjäryhmät
#### TODO: siirrä doc/dokumentaatio.pdf tiedostoon

Käyttäjä
  Muistilistaa voi käyttää kuka tahansa, joka on luonut järjestelmään tunnuksen.

