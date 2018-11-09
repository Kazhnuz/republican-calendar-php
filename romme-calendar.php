<?php
/* romme-calendar.php
 *
 * A romme french republican calendar converting library, and some republican
 * calendar utils.
 *
 * Copyright 2016-2013 Kazhnuz
 *
 * This programm is free software. You can redistribute it and/or modify
 * it under terms of the MIT Licence 
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/*  1. Converting to romme string functions

    This library use a romme string, formated the following way "month/day/year",
    using the american way of working, in order to work like php common functions.
    
    These functions convert the gregorian date and julian day counts to the romme
    string.
 */


function jdtoromme( $juliandaycount ) {
  // get a romme string from a julian day count
  $debugCalendar = 0;

  if (($juliandaycount > gregoriantojd (9, 22, 1805)) or ($debugCalendar==1)) { // Ce calcul prend le relais à partir du 23 septembre 1805
    // On commence par déclarer les variables, qui nous servirons à calculer ou on en est rendu.
    $franciade_simple_nbr_jours = (3*365)+366;
    $siecle_simple_nbr_jour = (25*$franciade_simple_nbr_jours)-1;
    $siecle_quatrieme_nbr_jour = 25*$franciade_simple_nbr_jours;
    $franciade_seculaire_nbr_jours = 3*$siecle_simple_nbr_jour+$siecle_quatrieme_nbr_jour;
    $franciade_millenaire_nbr_jours = (10*$franciade_seculaire_nbr_jours)-1;
    // On obtien le jour courrant par rapport au début du calendrier révolutionaire
    $rommedate = $juliandaycount - gregoriantojd (9, 22, 1792);

    if ($debugCalendar==1) {
      echo $rommedate . " jours se sont écoulés depuis le debut du calendrier revolutionnaire. <br />";
    }
 
    // On découpe ce jour courrant suivant les années.
    $franciade_millenaire = floor($rommedate/$franciade_millenaire_nbr_jours);
    $rommedate = $rommedate % $franciade_millenaire_nbr_jours;

    if ($debugCalendar==1) {
      echo $franciade_millenaire . " franciades millénaires ( de " . $franciade_millenaire_nbr_jours . " jours ) se sont écoulées depuis le début du calendrier révolutionnaire. " . $rommedate . " jours se sont écoulés depuis le début de la franciade millénaire actuelle <br />";
    }

    $franciade_seculaire = floor($rommedate/$franciade_seculaire_nbr_jours);
    $rommedate = $rommedate % $franciade_seculaire_nbr_jours;

    if ($debugCalendar==1) {
      echo $franciade_seculaire . " franciades séculaires ( de " . $franciade_seculaire_nbr_jours . " jours ) se sont écoulées depuis le début de la franciade millénaire. " . $rommedate . " jours se sont écoulé depuis le début de la franciade séculaire actuelle <br />";
    }

    if ($rommedate < (3*$siecle_simple_nbr_jour)) {
      $siecle = floor($rommedate/$siecle_simple_nbr_jour);
      $rommedate = $rommedate % $siecle_simple_nbr_jour;
    } else {
      $siecle = 3;
      $rommedate = $rommedate - (3*$siecle_simple_nbr_jour);
    }

    if ($debugCalendar==1) {
      echo $siecle . " siècles ( de " . $siecle_simple_nbr_jour . " jours ) se sont écoulées depuis le début de la franciade séculaire. " . $rommedate . " jours se sont écoulé depuis le début du siècle actuel <br />";
    }

    $franciade_simple = floor($rommedate/$franciade_simple_nbr_jours);
    $rommedate = $rommedate % $franciade_simple_nbr_jours;

    if ($debugCalendar==1) {
      echo $franciade_simple . " franciades simples ( de " . $franciade_simple_nbr_jours . " jours ) se sont écoulées depuis le début du siècle. " . $rommedate . " jours se sont écoulé depuis le début de la franciade actuelle <br />";
    }

    if ($rommedate < (3*365)) {
      $annees = floor($rommedate/365);
      $rommedate = $rommedate % 365;
    } else {
      $annees = 3;
      $rommedate = $rommedate - (3*365);
    }

    if ($debugCalendar==1) {
      echo $annees . " années non-sextiles ( de 365 jours ) se sont écoulées depuis le début de la franciade. " . $rommedate . " jours se sont écoulé depuis le début de l'année <br />";
    }

    $annees = ($franciade_millenaire*4000)+($franciade_seculaire*400)+($siecle*100)+($franciade_simple*4)+$annees;
    $mois = floor($rommedate/30);
    $jours = ($rommedate % 30);

    if ($debugCalendar==1) {
      echo $mois . " mois ( de 30 jours ) se sont écoulées depuis le début de l'année. " . $jours . " jours se sont écoulé depuis le début du mois <br />";
    }

    // On rajoute à chaque élément un numéro en plus, parce qu'une date ne commence jamais par 0 :)
    $annees = $annees+1;
    $mois = $mois+1;
    $jours = $jours+1;

    $romme_date_string = $mois . "/" . $jours . "/" . $annees;
  } else {
    // Sinon on utilise le calcul de la fonction normal, qui nous permet d'avoir les valeurs révolutionnaires exactes
    $romme_date_string = jdtofrench ( $juliandaycount );
  }
 
  return $romme_date_string;
}

function gregoriantoromme($m, $d, $y) {
  // get a romme string from a gregorian date
  $juliandaycount     = gregoriantojd($m, $d, $y);
  $romme_date_string  = jdtoromme($juliandaycount);
  
  return $romme_date_string;
}

function datetoromme() {
  return gregoriantoromme(date('n'), date('j'), date('Y'));
}

/*  2. getting the romme array

    These functions report an array instead of the romme string.
 */

function romme_getArray($romme_date_string) {
  // get a romme array from a romme string
  $rommeArray = explode("/", $romme_date_string);
  
  return $rommeArray;
}

function jdtoromme_getArray($juliandaycount) {
  // get a romme array from a julian day count
  $romme_date_string = jdtoromme($juliandaycount);
  
  $rommeArray = romme_getArray($romme_date_string);
  
  return $rommeArray;
}

function gregoriantoromme_getArray($m, $d, $y) {
  // get a romme array from a gregorian date
  $romme_date_string = gregoriantoromme($m, $d, $y);
  
  $rommeArray = romme_getArray($romme_date_string);
  
  return $rommeArray;
}

/*  2.1. Getting the different numerical elements from a romme array
 */

function romme_getDay($romme_date_string) {
  $rommeArray = romme_getArray($romme_date_string);
  
  return $rommeArray[1];
}

function romme_getMonth($romme_date_string) {
  $rommeArray = romme_getArray($romme_date_string);
  
  return $rommeArray[0];
}

function romme_getYear($romme_date_string) {
  $rommeArray = romme_getArray($romme_date_string);
  
  return $rommeArray[2];
}

/*  3. Getting republican calendar names

    Get the names of the month, days, etc. of the revolutionnary calendar. Theses functions are prefixed with repcal_ as they don't use the romme date string.
 */

function repcal_getMonthName($month)
{
  // Convert a month number to the right republican calendar month name.
  
  // Month names comes from Fabre d'Eglantine : https://en.wikipedia.org/wiki/French_Republican_calendar#Months
  $monthArray = array("Vendémiaire",
                      "Brumaire",
                      "Frimaire",
                      "Nivôse",
                      "Pluviôse",
                      "Ventôse",
                      "Germinal",
                      "Floréal",
                      "Prairial",
                      "Messidor",
                      "Thermidor",
                      "Fructidor",
                      "Sansculottide"); // The "13th" month is a special case for the sanscullotide,
                                        // the leap days of the republican calendar.
  if($month < count($monthArray)+1) {
    return $monthArray[$month-1];
  }
}

function repcal_getDayName($day)
{
  // Convert a month day number to the right republican calendar day name. 
  // /!\ Do not use if you are in the sansculottides days, as *technically*, they aren't part of any decade.
  
  // Days names comes from Fabre d'Eglantine : https://en.wikipedia.org/wiki/French_Republican_calendar#Ten_days_of_the_week
  $dayArray = array( "Primidi",
                  "Duodi",
                  "Tridi",
                  "Quartidi",
                  "Quintidi",
                  "Sextidi",
                  "Septidi",
                  "Octidi",
                  "Nonidi",
                  "Décadi") ;


  // As the republican calendar use a ten-day decade and a thirty-day month, just derive the decade day from day month modulo ten.
  
  return $dayArray[($day-1) % 10];   
}

function repcal_getDayMonthNames($month, $day, $showDecadeDayName) {
  if ($month < 13) {
    $dayString   = repcal_getDayName($day);
    $monthString = repcal_getMonthName($month);
    
    $dayMonthString = $day . " " . $monthString;
  
    if ($showDecadeDayName == true) {
      $dayMonthString = $dayString . " " . $dayMonthString;
    }
  } else {
    $dayMonthString   = repcal_getComplementaryDay($day);
  }
  
  return $dayMonthString;
}

function repcal_getComplementaryDay($day) {
  // Convert the sansculottide day number to a string.

  $ordinalnumberArray = array("Premier",
                "Deuxième",
                "Troisième",
                "Quatrième",
                "Cinquième",
                "Sixième");

  if($day < count($ordinalnumberArray) + 1) {
    $ordinalName = $ordinalnumberArray[$day-1];
    $ordinalString = $ordinalName . " jour des Sanscullotides";
    
    return $ordinalString;
  }
}

function repcal_getEpiphany($month, $day) {
  // Convert a romme day and month number to the corresponding epiphany name.

  // Days names comes from Fabre d'Eglantine : https://en.wikipedia.org/wiki/French_Republican_calendar#Rural_Calendar
  $epiphanyArray = array('Raisin','Safran','Châtaigne','Colchique','Cheval','Balsamine','Carotte','Amaranthe','Panais','Cuve','Pomme de terre','Immortelle','Potiron','Réséda','Âne','Belle de nuit','Citrouille','Sarrasin','Tournesol','Pressoir','Chanvre','Pêche','Navet','Amaryllis','Bœuf','Aubergine','Piment','Tomate','Orge','Tonneau', 'Pomme','Céleri','Poire','Betterave','Oie','Héliotrope','Figue','Scorsonère','Alisier','Charrue','Salsifis','Mâcre','Topinambour','Endive','Dindon','Chervis','Cresson','Dentelaire','Grenade','Herse','Bacchante','Azerole','Garance','Orange','Faisan','Pistache','Macjonc','Coing','Cormier','Rouleau', 'Raiponce','Turneps','Chicorée','Nèfle','Cochon','Mâche','Chou-fleur','Miel','Genièvre','Pioche','Cire','Raifort','Cèdre','Sapin','Chevreuil','Ajonc','Cyprès','Lierre','Sabine','Hoyau','Érable sucré','Bruyère','Roseau','Oseille','Grillon','Pignon','Liège','Truffe','Olive','Pelle', 'Tourbe','Houille','Bitume','Soufre','Chien','Lave','Terre végétale','Fumier','Salpêtre','Fléau','Granit','Argile','Ardoise','Grès','Lapin','Silex','Marne','Pierre à chaux','Marbre','Van','Pierre à plâtre','Sel','Fer','Cuivre','Chat','Étain','Plomb','Zinc','Mercure','Crible', 'Lauréole','Mousse','Fragon','Perce-neige','Taureau','Laurier tin','Amadouvier','Mézéréon','Peuplier','Coignée','Ellébore','Brocoli','Laurier','Avelinier','Vache','Buis','Lichen','If','Pulmonaire','Serpette','Thlaspi','Thimele','Chiendent','Trainasse','Lièvre','Guède','Noisetier','Cyclamen','Chélidoine','Traîneau', 'Tussilage','Cornouiller','Violier','Troène','Bouc','Asaret','Alaterne','Violette','Marceau','Bêche','Narcisse','Orme','Fumeterre','Vélar','Chèvre','Épinard','Doronic','Mouron','Cerfeuil','Cordeau','Mandragore','Persil','Cochléaria','Pâquerette','Thon','Pissenlit','Sylvie','Capillaire','Frêne','Plantoir', 'Primevère','Platane','Asperge','Tulipe','Poule','Bette','Bouleau','Jonquille','Aulne','Couvoir','Pervenche','Charme','Morille','Hêtre','Abeille','Laitue','Mélèze','Ciguë','Radis','Ruche','Gainier','Romaine','Marronnier','Roquette','Pigeon','Lilas (commun)','Anémone','Pensée','Myrtile','Greffoir', 'Rose','Chêne','Fougère','Aubépine','Rossignol','Ancolie','Muguet','Champignon','Hyacinthe','Râteau','Rhubarbe','Sainfoin','Bâton-d´or','Chamerops','Ver à soie','Consoude','Pimprenelle','Corbeille d´or','Arroche','Sarcloir','Statice','Fritillaire','Bourrache','Valériane','Carpe','Fusain','Civette','Buglosse','Sénevé','Houlette', 'Luzerne','Hémérocalle','Trèfle','Angélique','Canard','Mélisse','Fromental','Martagon','Serpolet','Faux','Fraise','Bétoine','Pois','Acacia','Caille','Œillet','Sureau','Pavot','Tilleul','Fourche','Barbeau','Camomille','Chèvrefeuille','Caille-lait','Tanche','Jasmin','Verveine','Thym','Pivoine','Chariot', 'Seigle','Avoine','Oignon','Véronique','Mulet','Romarin','Concombre','Échalote','Absinthe','Faucille','Coriandre','Artichaut','Girofle','Lavande','Chamois','Tabac','Groseille','Gesse','Cerise','Parc','Menthe','Cumin','Haricot','Orcanète','Pintade','Sauge','Ail','Vesce','Blé','Chalemie', 'Épeautre','Bouillon-blanc','Melon','Ivraie','Bélier','Prêle','Armoise','Carthame','Mûre','Arrosoir','Panic','Salicorne','Abricot','Basilic','Brebis','Guimauve','Lin','Amande','Gentiane','Écluse','Carline','Câprier','Lentille','Aunée','Loutre','Myrte','Colza','Lupin','Coton','Moulin', 'Prune','Millet','Lycoperdon','Escourgeon','Saumon','Tubéreuse','Sucrion','Apocyn','Réglisse','Échelle','Pastèque','Fenouil','Épine vinette','Noix','Truite','Citron','Cardère','Nerprun','Tagette','Hotte','Églantier','Noisette','Houblon','Sorgho','Écrevisse','Bigarade','Verge d´or','Maïs','Marron','Panier');
  
  if ($month < 13) {
    $absoluteDay = (($month-1)*30)+$day;
    if($absoluteDay < count($epiphanyArray)+1) {
      return $epiphanyArray[$absoluteDay-1];
    }
  } else {
    return repcal_getComplementaryDayName($day);
  }
}

function repcal_getComplementaryDayName($day) {
  // Convert the sansculottide day number to its name.

  // Complentary Day names: https://en.wikipedia.org/wiki/French_Republican_calendar#Complementary_days 
  $sanscullotidesArray = array("Jour de la vertu",
                "Jour du génie",
                "Jour du travail",
                "Jour de l'opinion",
                "Jour des récompenses",
                "Jour de la révolution");

  if($day < count($sanscullotidesArray)+1)
    return $sanscullotidesArray[$day-1] ;
}

/*  3.1. Get names from the current month/day from a romme string

 */
 
function romme_getMonthName($romme_date_string) {
  // Get month name from the date string
  
  $dateArray = romme_getArray($romme_date_string);
  
  return repcal_getMonthName($dateArray[0]);
}

function romme_getDayName($romme_date_string) {
  // Get day name from the date string
  
  $dateArray = romme_getArray($romme_date_string);
  
  return repcal_getDayName($dateArray[1]);
}

function romme_getDayMonthNames($romme_date_string, $showDecadeDayName) {
  // Get day name from the date string
  
  $dateArray = romme_getArray($romme_date_string);
  
  return repcal_getDayMonthNames($dateArray[0], $dateArray[1], $showDecadeDayName);
}

function romme_getComplementaryDay($romme_date_string) {
  // Get the complementary day name from the date string
  
  $dateArray = romme_getArray($romme_date_string);
  
  return repcal_getComplementaryDay($dateArray[1]);
}

function romme_getEpiphany($romme_date_string) {
  // Get day name from the date string
  
  $dateArray = romme_getArray($romme_date_string);
  
  return repcal_getEpiphany($dateArray[0], $dateArray[1]);
}

function romme_getComplementaryDayName($romme_date_string) {
  // Get day name from the date string
  
  $dateArray = romme_getArray($romme_date_string);
  
  return repcal_getComplementaryDayName($dateArray[1]);
}

/*  4. Romme calendar string handling

    These functions help the user to get a more beautifull romme string,
    usable directly in their pages.
 */
 
/* 4.1. Converting the romme string to a better string

 */

function romme_getFormattedString($romme_date_string, $showDecadeDayName) {
  // Convert a romme date string to a formated romme date
  
  // Start by getting the romme array
  $dateArray = romme_getArray($romme_date_string);
  
  // Get the month and day names
  $dayMonthString = repcal_getDayMonthNames($dateArray[0], $dateArray[1], $showDecadeDayName);
  
  // Create the string for the year
  $yearString = "an " . $dateArray[2];

  return $dayMonthString . ", " . $yearString;
}

function romme_getFormattedStringComplete($romme_date_string) {
  // Convert a romme date string to a formated complete romme date

  // Start by getting the romme array
  $dateArray = romme_getArray($romme_date_string);
  
  // Get the month and day names
  $dayMonthString = repcal_getDayMonthNames($dateArray[0], $dateArray[1], true);
  
  $saintString = repcal_getEpiphany($dateArray[0], $dateArray[1]);

  // Create the string for the year
  $yearString = "an " . $dateArray[2];

  return $dayMonthString . " (<em>" . $saintString . "</em>)" . ", " . $yearString;
}

/* 4.2. Getting them from the gregorian date

 */

function gregoriantoromme_getFormattedString($m,$d,$y, $showDecadeDayName) {
  // Convert a gregorian date to a formatted romme date

  // Start by getting the romme date string from the gregorian date
  $romme_date_string = gregoriantoromme($m,$d,$y);
  
  // return the convertion of the romme date string to a formatted string
  return romme_getFormattedString($romme_date_string, $showDecadeDayName);
}

function gregoriantoromme_getFormattedStringComplete($m,$d,$y) {
  // Convert a gregorian date to a complete romme formatted string

  // Start by getting the romme date string from the gregorian date
  $romme_date_string = gregoriantoromme($m,$d,$y);
  
  // return the convertion of the romme date string to a formatted string
  return romme_getFormattedStringComplete($romme_date_string);
}

/* 4.3. Getting them from the julian day count

 */
 
function jdtoromme_getFormattedString($juliandaycount, $showDecadeDayName) {
  // Convert a gregorian date to a formatted romme date

  // Start by getting the romme date string from the gregorian date
  $romme_date_string = jdtoromme($juliandaycount);
  
  // return the convertion of the romme date string to a formatted string
  return romme_getFormattedString($romme_date_string, $showDecadeDayName);
}

function jdtoromme_getFormattedStringComplete($juliandaycount) {
  // Convert a gregorian date to a complete romme formatted string

  // Start by getting the romme date string from the gregorian date
  $romme_date_string = jdtoromme($juliandaycount);
  
  // return the convertion of the romme date string to a formatted string
  return romme_getFormattedStringComplete($romme_date_string);
}

/* 4.3. Getting them from the julian day count

 */
 
function datetoromme_getFormattedString($showDecadeDayName) {
  // Convert a gregorian date to a formatted romme date

  // Start by getting the romme date string from the gregorian date
  $romme_date_string = datetoromme();
  
  // return the convertion of the romme date string to a formatted string
  return romme_getFormattedString($romme_date_string, $showDecadeDayName);
}

function datetoromme_getFormattedStringComplete() {
  // Convert a gregorian date to a complete romme formatted string

  // Start by getting the romme date string from the gregorian date
  $romme_date_string = datetoromme();
  
  // return the convertion of the romme date string to a formatted string
  return romme_getFormattedStringComplete($romme_date_string);
}

?>
