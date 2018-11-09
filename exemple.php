<?php 
//
// romme_calendar :: exemple.php
//
// Some exemple to see if everything works in the romme calendar library
// 
// 

// On commence par inclure le fichier pour pouvoir convertir la date en calendrier romme

include("romme-calendar.php");

$testMois   = date('n');
$testJour   = date('j');
$testAnnee  = date('Y');

$testJulianday  = gregoriantojd($testMois, $testJour, $testAnnee);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PHP Romme Republican Calendar exemple</title>
  </head>
  <body>
    <h1>PHP Romme Republican Calendar exemples</h1>
    <h2>Date d'aujourd'hui</h2>
    <p>
      <strong>Date utilisée :</strong> <?php echo $testJour;?>/<?php echo $testMois;?>/<?php echo $testAnnee;?><br />
      <strong>Jour julien :</strong> <?php echo $testJulianday; ?> <br />
    </p>
    
    <h2>Getting the "romme date string"</h2>
    <p>
      <strong>jdtoromme :</strong> <?php echo jdtoromme( $testJulianday );?> <br />
      <strong>gregoriantoromme :</strong> <?php echo gregoriantoromme($testMois, $testJour, $testAnnee);?><br />
      <strong>date_romme :</strong> <?php echo datetoromme();?><br />
    </p>
    
    <h2>Getting the month/day/year</h2>
    <p>
      <strong>romme_getDay :</strong> <?php echo romme_getDay( jdtoromme( $testJulianday ) );?> <br />
      <strong>romme_getMonth :</strong> <?php echo romme_getMonth( jdtoromme( $testJulianday ) );?> <br />
      <strong>romme_getYear :</strong> <?php echo romme_getYear( jdtoromme( $testJulianday ) );?> <br />
    </p>
    
    <h2>Getting the month/day/year… names</h2>
    <p>
      <strong>romme_getDayName :</strong> <?php echo romme_getDayName( jdtoromme( $testJulianday ) );?> <br />
      <strong>romme_getMonthName :</strong> <?php echo romme_getMonthName( jdtoromme( $testJulianday ) );?> <br />
      <strong>romme_getDayMonthNames :</strong> <?php echo romme_getDayMonthNames( jdtoromme( $testJulianday ), true );?> <br />
      <strong>romme_getComplementaryDay :</strong> <?php echo romme_getComplementaryDay( jdtoromme( $testJulianday ) );?> <br />
      <strong>romme_getEpiphany :</strong> <?php echo romme_getEpiphany( jdtoromme( $testJulianday ) );?> <br />
      <strong>romme_getComplementaryDayName :</strong> <?php echo romme_getComplementaryDayName( jdtoromme( $testJulianday ) );?> <br />
    </p>
    
    <h2>Getting an automated string</h2>
    <p>
      <strong>romme_getFormattedString :</strong> <?php echo romme_getFormattedString( jdtoromme( $testJulianday ), false );?> <br />
      <strong>romme_getFormattedStringComplete :</strong> <?php echo romme_getFormattedStringComplete( jdtoromme( $testJulianday ) );?> <br />
      
      <strong>gregoriantoromme_getFormattedString :</strong> <?php echo gregoriantoromme_getFormattedString($testMois, $testJour, $testAnnee, false);?><br />
      <strong>gregoriantoromme_getFormattedStringComplete :</strong> <?php echo gregoriantoromme_getFormattedStringComplete($testMois, $testJour, $testAnnee);?><br />
      
      <strong>jdtoromme_getFormattedString :</strong> <?php echo jdtoromme_getFormattedString($testJulianday, false);?><br />
      <strong>jdtoromme_getFormattedStringComplete :</strong> <?php echo jdtoromme_getFormattedStringComplete($testJulianday);?><br />
      
      <strong>datetoromme_getFormattedString :</strong> <?php echo datetoromme_getFormattedString(false);?><br />
      <strong>datetoromme_getFormattedStringComplete :</strong> <?php echo datetoromme_getFormattedStringComplete();?><br />
      
    </p>
  </body>
</html>
