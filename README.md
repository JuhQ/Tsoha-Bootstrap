# Tietokantasovelluksen esittelysivu

Yleisiä linkkejä:

* [Linkki sovellukseeni](http://juhataur.users.cs.helsinki.fi/tsoha/)
* [Linkki dokumentaatiooni](https://github.com/JuhQ/Tsoha-Bootstrap/blob/master/doc/dokumentaatio.pdf)

Linkit staattisiin sivuihin
* [Etusivu](staattiset-tiedostot/Tietokantasovellus.htm)
* [Listaus](staattiset-tiedostot/Tietokantasovellus-listaus.htm)
* [Yksittäisen muistiinpanon näkymä](staattiset-tiedostot/Tietokantasovellus-yksittainen.htm)
* [Muistiinpanon muokkaus](staattiset-tiedostot/Tietokantasovellus-muokkaus.htm)

## Työn aihe

Työn aiheena [muistilista](http://advancedkittenry.github.io/suunnittelu_ja_tyoymparisto/aiheet/Muistilista.html)



## Käyttöohjeet
Työ sijaitsee osoitteessa [http://juhataur.users.cs.helsinki.fi/tsoha/](http://juhataur.users.cs.helsinki.fi/tsoha/).

Pääset kirjautumaan sisälle tunnuksilla `tunnus1`/`salasana`

Koska kyseessä on henkilökohtaiset muistiinpanot, järjestelmässä ei ole mitään admin näkymää eikä admin tunnuksia.
Kirjaudu sisään (tai luo uusi tunnus) ja anna palaa! 📝


### Puutteet/ongelmat
 - Muistiinpanoissa on luokat (tagit) joita voi klikata, mutta näkymä ei vielä muutu.
 - notes_controller luokka tekee turhan monta tietokantahakua käyttäjätauluun



#### TODO
Toimintoja:

- [x] Rekisteröityminen
- [x] Kirjautuminen
- [x] Käyttöohjeet
- [x] Askareen lisäys, muokkaus ja poisto
  - [x] lisäys
  - [x] muokkaus
  - [x] poisto
- [x] Tärkeysasteen lisäys ja poisto
  - [x] lisäys
  - [x] poisto
- [x] Askareen tärkeyttäminen lisäyksessä tai myöhemmin
- [x] Luokkien lisäys ja poisto
  - [x] lisäys
  - [x] poisto
- [x] Askareiden luokittelu
- [ ] Luokat voivat olla sisäkkäisiä
- [x] Yhdellä askareella voi olla monta luokkaa
