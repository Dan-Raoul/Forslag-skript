<?php
// Variablar som kan settast for bruk
$forslag_opent 					= FALSE; // Slå av/på skjemaet: TRUE er på, FALSE er av
$forslag_mottaker 				= ""; // Kven som skal få e-posten
$forslag_mottaker_namn 	= ""; // Namn på kven som skal få e-posten
$forslag_passord 				= ""; // Passord.
$forslag_tittel 					= ""; // Tittel for arrangement - t.d. HEFLM, HULM m.m.
$forslag_sak_aar				= "[1][7]"; // Årstal for møtet - ikkje bryt formatet.
$forslag_kontaktperson 		= ""; // Kven som har ansvaret - dvs. kven dei skal ta kontakt med om det ikkje kjem e-post
$forslag_baseurl 				= ""; // Viss me skulle trenge det på eit tidspunkt, er det nyttig å fylle det ut her.
$forslag_epost_domene		= ""; // Brukast til diverse e-postrelaterte settings
$forslag_masterpassord		= ""; // Brukast til å endre forslag.
$forslag_salt						= ""; // For å salte hasher - lag gjerne ein lang, intetseiande alfanumerisk string [a-zA-Z0-9]
$forslag_dbtabell_oppretta	= FALSE; // Settast manuelt til TRUE når ein har oppretta databasetabell via start.php

// Sette opp SMTP viss det skal brukast
$forslag_mail_smtp			=	FALSE; // Bruke/ikkje bruke SMTP. TRUE - bruke SMTP, FALSE - bruke sendmail
$forslag_mail_server			=	""; // SMTP-server
$forslag_mail_port				=	""; // Port til SMTP-server
$forslag_mail_auth				=	FALSE; // Treng autentisering for SMTP
$forslag_mail_user				=	""; // Settast viss SMTP treng autentisering
$forslag_mail_pass			=	""; // Settast viss SMTP treng autentisering

// Saksliste - fyll inn det du vil ha i formatet: <option value="01/17">01/17 Åpning og konstituering</option>. Viss du ikkje vil ferdig saksliste, vel FALSE på $saksliste_brukes.
$forslag_saksliste_brukes 	= TRUE;
$forslag_saksliste 				= '
						<option value="01/17">01/17 Åpning og konstituering</option>
						<option value="01/17a">01/17a Godkjenning av innkalling</option>
						<option value="01/17b">01/17b Valg av møtefunksjonærer</option>
						<option value="01/17c">01/17c Godkjenning av saksliste</option>
						<option value="01/17d">01/17d Godkjenning av landsmøtets forretningsorden</option>
						<option value="02/17">02/17 Årsberetning og regnskap for 2013 og 2014</option>
						<option value="03/17">03/17 Rapportering på Arbeidsprogram for Human-Etisk Forbund 2013-2015</option>
						<option value="04/17">04/17 Kontingent 2016-2017</option>
						<option value="05/17">05/17 Innkomne forslag:</option>
						<option value="05/17a">05/17a Vedtektsendringsforslag fra Akershus fylkeslag</option>
						<option value="05/17b">05/17b Vedtektsendringsforslag fra Aust-Agder fylkeslag</option>
						<option value="05/17c">05/17c Vedtektsendringsforslag fra Nordland fylkeslag</option>
						<option value="05/17d">05/17d Vedtektsendringsforslag fra Østfold fylkeslag</option>
						<option value="05/17e">05/17e Nasjonal gravferdstelefon</option>
						<option value="05/17f">05/17f Ny modell for tildeling av midler til lokal- og fylkeslag</option>
						<option value="05/17g">05/17g Årlig pott for belønning av lokal- og fylkeslag</option>
						<option value="05/17h">05/17h Uttalelse om miljø og klima</option>
						<option value="06/17">06/17 Arbeidsprogram for Human-Etisk Forbund 2015-2017</option>
						<option value="07/17">07/17 Valg</option>
						<option value="07/17a">07/17a Valg av hovedstyre</option>
						<option value="07/17b">07/17b Valg av revisor</option>
						<option value="07/17c">07/17c Valg av valgkomité for hovedstyre</option>
						<option value="08/17">08/17 Uttalelser</option>
						<option value="08/17a">08/17a Fordømmer terror i religionens navn</option>
						<option value="08/17b">08/17b Humanistisk Klimaansvar</option>
						<option value="08/17c">08/17c Religiøs diskriminering i Myanmar</option>
	';

// Kople til database
$forslag_dbserver 				= ""; // MySQL-tener
$forslag_dbbrukar 				= ""; // og brukarnamn
$forslag_dbpassord 			= ""; // og passord
$forslag_dbnamn 				= ""; // og databasenamn
$forslag_dbteiknkoding		=	"utf8mb4"; // og teiknkoding - la helst stå
$forslag_dbtabell 				= "forslag_" . $forslag_tittel; // Og kva tabell, med basis i kva tittelen på arrangementet er

// Sjekke at variablar er satt
$forslag_variablar				= array(
							"forslag_opent", 
							"forslag_mottaker", 
							"forslag_mottaker_namn", 
							"forslag_passord", 
							"forslag_tittel", 
							"forslag_sak_aar", 
							"forslag_kontaktperson", 
							"forslag_baseurl", 
							"forslag_epost_domene", 
							"forslag_masterpassord", 
							"forslag_salt", 
							"forslag_dbtabell_oppretta", 
							"forslag_dbserver", 
							"forslag_dbbrukar", 
							"forslag_dbpassord", 
							"forslag_dbnamn", 
							"forslag_dbteiknkoding", 
							"forslag_dbtabell");
$forslag_variablar_satt	= compact($forslag_variablar);
?>