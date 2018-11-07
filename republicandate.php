<?php

function jdtoromme( $juliandaycount ) {
  $debugCalendar = 0;
  // jdtofrench () n'accepte que les dates dépassant . On calcule donc grace au systeme Romme la date révolutionaire

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
  $juliandaycount     = gregoriantojd($m, $d, $y);
  $romme_date_string  = jdtoromme($juliandaycount);
  
  return $romme_date_string;
}

function jdtoromme_getArray($juliandaycount) {
  $romme_date_string = jdtoromme($juliandaycount);
  
  $rommeArray = romme_getArray($romme_date_string);
  
  return $rommeArray;
}

function gregoriantoromme_getArray($m, $d, $y) {
  $romme_date_string = gregoriantoromme($m, $d, $y);
  
  $rommeArray = romme_getArray($romme_date_string);
  
  return $rommeArray;
}

function romme_getArray($romme_date_string) {
  $rommeArray = explode("/", $romme_date_string);
  
  return $rommeArray;
}

function FrenchMonthNames($month)
{
    /* The names have been invented by Fabre d'Églantine, a second or rather third rank poet
of primarily pastoral poems, with each name referring to the respective period in the agricultural year; e.g. "Vendémiaire" (approx. September) is derived from "vendange" ("harvest"), "Brumaire" (Ocotober/November) from "brume" ("fog") and so on ...     */
   
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
                      "Sansculottide") ;
  if($month < count($monthArray)+1) {
    return $monthArray[$month-1;
  }
}

function FrenchDayNames($Day)
{
  /* The names have been invented by Fabre d'Églantine, a second or rather third rank poet
of primarily pastoral poems, with each name referring to the respective period in the agricultural year; e.g. "Vendémiaire" (approx. September) is derived from "vendange" ("harvest"), "Brumaire" (Ocotober/November) from "brume" ("fog") and so on ...     */
   
   
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

  return $dayArray[($Day-1) % 10] ;   
}

function FrenchSaintNames($Month, $Day) {
  $epiphanyArray = array('Raisin','Safran','Châtaigne','Colchique','Cheval','Balsamine','Carotte','Amaranthe','Panais','Cuve','Pomme de terre','Immortelle','Potiron','Réséda','Âne','Belle de nuit','Citrouille','Sarrasin','Tournesol','Pressoir','Chanvre','Pêche','Navet','Amaryllis','Bœuf','Aubergine','Piment','Tomate','Orge','Tonneau', 'Pomme','Céleri','Poire','Betterave','Oie','Héliotrope','Figue','Scorsonère','Alisier','Charrue','Salsifis','Mâcre','Topinambour','Endive','Dindon','Chervis','Cresson','Dentelaire','Grenade','Herse','Bacchante','Azerole','Garance','Orange','Faisan','Pistache','Macjonc','Coing','Cormier','Rouleau', 'Raiponce','Turneps','Chicorée','Nèfle','Cochon','Mâche','Chou-fleur','Miel','Genièvre','Pioche','Cire','Raifort','Cèdre','Sapin','Chevreuil','Ajonc','Cyprès','Lierre','Sabine','Hoyau','Érable sucré','Bruyère','Roseau','Oseille','Grillon','Pignon','Liège','Truffe','Olive','Pelle', 'Tourbe','Houille','Bitume','Soufre','Chien','Lave','Terre végétale','Fumier','Salpêtre','Fléau','Granit','Argile','Ardoise','Grès','Lapin','Silex','Marne','Pierre à chaux','Marbre','Van','Pierre à plâtre','Sel','Fer','Cuivre','Chat','Étain','Plomb','Zinc','Mercure','Crible', 'Lauréole','Mousse','Fragon','Perce-neige','Taureau','Laurier tin','Amadouvier','Mézéréon','Peuplier','Coignée','Ellébore','Brocoli','Laurier','Avelinier','Vache','Buis','Lichen','If','Pulmonaire','Serpette','Thlaspi','Thimele','Chiendent','Trainasse','Lièvre','Guède','Noisetier','Cyclamen','Chélidoine','Traîneau', 'Tussilage','Cornouiller','Violier','Troène','Bouc','Asaret','Alaterne','Violette','Marceau','Bêche','Narcisse','Orme','Fumeterre','Vélar','Chèvre','Épinard','Doronic','Mouron','Cerfeuil','Cordeau','Mandragore','Persil','Cochléaria','Pâquerette','Thon','Pissenlit','Sylvie','Capillaire','Frêne','Plantoir', 'Primevère','Platane','Asperge','Tulipe','Poule','Bette','Bouleau','Jonquille','Aulne','Couvoir','Pervenche','Charme','Morille','Hêtre','Abeille','Laitue','Mélèze','Ciguë','Radis','Ruche','Gainier','Romaine','Marronnier','Roquette','Pigeon','Lilas (commun)','Anémone','Pensée','Myrtile','Greffoir', 'Rose','Chêne','Fougère','Aubépine','Rossignol','Ancolie','Muguet','Champignon','Hyacinthe','Râteau','Rhubarbe','Sainfoin','Bâton-d´or','Chamerops','Ver à soie','Consoude','Pimprenelle','Corbeille d´or','Arroche','Sarcloir','Statice','Fritillaire','Bourrache','Valériane','Carpe','Fusain','Civette','Buglosse','Sénevé','Houlette', 'Luzerne','Hémérocalle','Trèfle','Angélique','Canard','Mélisse','Fromental','Martagon','Serpolet','Faux','Fraise','Bétoine','Pois','Acacia','Caille','Œillet','Sureau','Pavot','Tilleul','Fourche','Barbeau','Camomille','Chèvrefeuille','Caille-lait','Tanche','Jasmin','Verveine','Thym','Pivoine','Chariot', 'Seigle','Avoine','Oignon','Véronique','Mulet','Romarin','Concombre','Échalote','Absinthe','Faucille','Coriandre','Artichaut','Girofle','Lavande','Chamois','Tabac','Groseille','Gesse','Cerise','Parc','Menthe','Cumin','Haricot','Orcanète','Pintade','Sauge','Ail','Vesce','Blé','Chalemie', 'Épeautre','Bouillon-blanc','Melon','Ivraie','Bélier','Prêle','Armoise','Carthame','Mûre','Arrosoir','Panic','Salicorne','Abricot','Basilic','Brebis','Guimauve','Lin','Amande','Gentiane','Écluse','Carline','Câprier','Lentille','Aunée','Loutre','Myrte','Colza','Lupin','Coton','Moulin', 'Prune','Millet','Lycoperdon','Escourgeon','Saumon','Tubéreuse','Sucrion','Apocyn','Réglisse','Échelle','Pastèque','Fenouil','Épine vinette','Noix','Truite','Citron','Cardère','Nerprun','Tagette','Hotte','Églantier','Noisette','Houblon','Sorgho','Écrevisse','Bigarade','Verge d´or','Maïs','Marron','Panier');
  
  $absoluteDay = (($Month-1)*30)+$Day;
  
    if($absoluteDay < count($epiphanyArray)+1)
      return $epiphanyArray[$absoluteDay-1];
}
function FrenchSansCullotidesNames($Day) {
  $sanscullotidesArray = array("Jour de la vertu",
                "Jour du génie",
                "Jour du travail",
                "Jour de l'opinion",
                "Jour des récompenses",
                "Jour de la révolution");

  if($Day < count($sanscullotidesArray)+1)
    return $sanscullotidesArray[$Day-1] ;
}
function FrenchOrdinalNumber($Day) {
  $ordinalnumberArray = array("Premier",
                "Deuxième",
                "Troisième",
                "Quatrième",
                "Cinquième",
                "Sixième");

  if($Day < count($ordinalnumberArray)+1)
    return $ordinalnumberArray[$Day-1] ;
}

function gregorian2FrenchDateString($m,$d,$y) {
  $dateArray = gregoriantoromme_getArray($m,$d,$y);
  
  $monthname = FrenchMonthNames($dateArray[0]) ;
  $dayname = FrenchDayNames($dateArray[1]);

  if ($dateArray[0]==13) {
    $dayMonthString = FrenchSansCullotidesNames($dateArray[1]) . ", ";
    $saintString = FrenchOrdinalNumber($dateArray[1]) . " jour des " . $monthname;
  } else {
    $dayMonthString = $dayname . ", " . $dateArray[1] . " " . $monthname . ", ";
    $saintString = FrenchSaintNames($dateArray[0],$dateArray[1]);
  }

  $yearString = "an " . $dateArray[2];

  return $dayMonthString . $yearString . "<br /><em>" . $saintString . "</em>";
}

function gregorian2FrenchDateStringShort($m,$d,$y) {
  $dateArray = gregoriantoromme_getArray($m,$d,$y);
  
  $monthname = FrenchMonthNames($dateArray[0]);
  $dayname = FrenchDayNames($dateArray[1]);

  if ($dateArray[0]==13) {
    $dayMonthString = FrenchSansCullotidesNames($dateArray[1]) . ", ";
    $saintString = FrenchOrdinalNumber($dateArray[1]) . " jour des " . $monthname;
  } else {
    $dayMonthString = $dateArray[1] . " " . $monthname . ", ";
    $saintString = FrenchSaintNames($dateArray[0],$dateArray[1]);
  }
  
  $yearString = "an " . $dateArray[2];

  return $dayMonthString . $yearString;
}
?>
