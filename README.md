# Forslag-skript
Send forslag til møte, årsmøte, landsmøte

Eit skript tilpassa å sende inn forslag til eit møte på ryddigast mogleg måte, med visning av innsendte forslag, statistikk på sak og delegat, og i stor grad relativt mobiltilpassa.

# Kravspesifikasjon:
Server:
* PHP (5.3+ prøvd)
* MySQL

Forståelse for PHP, HTML, CSS og litt MySQL, JavaScript for å tilpasse skjemaet meir enn standard

#Oppsett:
Fyll ut variablar i variablar.php. Du må ha ein MySQL-database tilgjengeleg, med rettar til å opprette, slette tabellar og oppføringar. Alt dette fyllast ut i variablar.php, som skal vere einaste filen du treng å tilpasse.

#Filliste:
* .gitattributes - GitHub-fil
* .htaccess - For å kontrollere tilgong til serveren (Ved Apache-server).
* README.md - Denne fila.
* config.php - Hovudfil som driftar heile skriptet. Ikkje rør med mindre du veit godt kva du gjer.
* forslag.php - Til å vise frem forslaga. HTML kan lett tilpassast, men ein må vere forsiktig med å øydeleggje PHPen.
* functions.php - Funksjonar som brukast i skriptet. Ikkje rør.
* index.php - Hovudsida. Dette er skjemaet som skal sendast inn - HTML kan tilpassast, men bruk helst CSS - verdiane i skjemaet må helst ikkje rørast.
* lesdb.php - For å lese innkomne forslag. Brukast av forslag.php. Ikkje rør.
* printdb.php - Ikkje lengre i bruk - skal potensielt slettast.
* robots.txt - For å avgrense søkemotorar frå å indeksere forslag. Trengs ikkje brukast, men anbefalast. Browsershots er tillatt for å sjekke korleis skjemaet ser ut.
* skrivdb.php - For å skrive innkomne forslag. Brukast i hovudsak av index.php. Ein må avkommentere (og så kommentera ut igjen) tabellopprettinga ved første gongs bruk, etter det skal det vere ganske sjølvgåande. Forsiktig bruk.
* standard.css - Stilark. Brukast for å få skjemaet til å sjå ut som ein vil det skal sjå ut. Kan tilpassast så mykje ein vil, men ein bør vere forsiktig - akkurat no skal skjemaet fungere greitt uavhengig av nettlesar og plattform.
* statistikk.php - Brukast for å vise kva sak som har fått flest forslag, samt kva delegat som har sendt inn flest forslag. Gimmick, som ikkje trengs - men slett lenkje til på index.php og forslag.php viss den ikkje skal brukast.
* variablar.php - Bruast for å sette variablar til bruk i skjemaet. Må tilpassast før bruk, men hald deg innanfor "" eller ''.
