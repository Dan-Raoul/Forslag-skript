;<?php
;die(); // For further security
;/*

[Variablar]
; Variablar som kan settast for bruk
; Slå av/på skjemaet: TRUE er på, FALSE er av
forslag_opent 							= 		FALSE
; Kven som skal få e-posten
forslag_mottaker 						= 		"" 
; Namn på kven som skal få e-posten
forslag_mottaker_namn 				= 		""
; Passord
forslag_passord 						= 		""
; Tittel for arrangement - t.d. HEFLM, HULM m.m.
forslag_tittel 								= 		""
; Kven som har ansvaret - dvs. kven dei skal ta kontakt med om det ikkje kjem e-post
forslag_kontaktperson 				= 		""
; Viss me skulle trenge det på eit tidspunkt, er det nyttig å fylle det ut her.
forslag_baseurl 							= 		""
; Brukast til diverse e-postrelaterte settings - domene til forslag_mottaker
forslag_epost_domene				= 		""
; Settast manuelt til TRUE når ein har oppretta databasetabell via start.php
forslag_dbtabell_oppretta			= 		FALSE

[Saksliste]
; Saksliste - fyll inn det du vil ha i formatet: <option value="01/15">01/15 Åpning og konstituering</option>. Viss du ikkje vil ferdig saksliste, vel FALSE på $saksliste_brukes.
forslag_saksliste_brukes 			=		TRUE;
forslag_saksliste 						=		'
						<option value="01/15">01/15 Åpning og konstituering</option>
						<option value="01/15a">01/15a Godkjenning av innkalling</option>
						<option value="01/15b">01/15b Valg av møtefunksjonærer</option>
						<option value="01/15c">01/15c Godkjenning av saksliste</option>
						<option value="01/15d">01/15d Godkjenning av landsmøtets forretningsorden</option>
						<option value="02/15">02/15 Årsberetning og regnskap for 2013 og 2014</option>
						<option value="03/15">03/15 Rapportering på Arbeidsprogram for Human-Etisk Forbund 2013-2015</option>
						<option value="04/15">04/15 Kontingent 2016-2017</option>
						<option value="05/15">05/15 Innkomne forslag:</option>
						<option value="05/15a">05/15a Vedtektsendringsforslag fra Akershus fylkeslag</option>
						<option value="05/15b">05/15b Vedtektsendringsforslag fra Aust-Agder fylkeslag</option>
						<option value="05/15c">05/15c Vedtektsendringsforslag fra Nordland fylkeslag</option>
						<option value="05/15d">05/15d Vedtektsendringsforslag fra Østfold fylkeslag</option>
						<option value="05/15e">05/15e Nasjonal gravferdstelefon</option>
						<option value="05/15f">05/15f Ny modell for tildeling av midler til lokal- og fylkeslag</option>
						<option value="05/15g">05/15g Årlig pott for belønning av lokal- og fylkeslag</option>
						<option value="05/15h">05/15h Uttalelse om miljø og klima</option>
						<option value="06/15">06/15 Arbeidsprogram for Human-Etisk Forbund 2015-2017</option>
						<option value="07/15">07/15 Valg</option>
						<option value="07/15a">07/15a Valg av hovedstyre</option>
						<option value="07/15b">07/15b Valg av revisor</option>
						<option value="07/15c">07/15c Valg av valgkomité for hovedstyre</option>
						<option value="08/15">08/15 Uttalelser</option>
						<option value="08/15a">08/15a Fordømmer terror i religionens navn</option>
						<option value="08/15b">08/15b Humanistisk Klimaansvar</option>
						<option value="08/15c">08/15c Religiøs diskriminering i Myanmar</option>
	';

[Database]
; Kople til database
; MySQL-tener
forslag_dbserver 					= 		""
; og brukarnamn
forslag_dbbrukar 					= 		""
; og passord
forslag_dbpassord 				= 		""
; og databasenamn
forslag_dbnamn 					= 		""
; og teiknkoding - la helst stå
forslag_dbteiknkoding			=		"utf8mb4"
; Og kva tabell - vil bli slått saman med tittel for for arrangementet, med understrek mellom
forslag_dbtabell 					= 		"forslag"
	
;*/

;?>
