# PHP Romme Republican Calendar

Une librairie PHP pour couvertir facilement une date dans le calendrier républicain, utilisant le [système Romme](http://prairial.free.fr/calendrier/calendrier.php?lien=discoursromme).

Le script peut afficher soit une date minimale (style 23 Brumaire, an 225) soit une date plus complexe (Tridi, 23 Brumaire, an 225 - Garance).

## Comment l'utiliser.

### Obtenir la date d'aujourd'hui dans le calendrier révolutionnaire romme

````php
include(romme-calendar.php);
// Comment afficher la date "simple" (jour+mois+année). $showDecadeDayName détermine si vous affichez le nom du jour de la décade
echo datetoromme_getFormattedString($showDecadeDayName);
// Comment afficher la date "complete" (jour+mois+épiphany+année) 
echo datetoromme_getFormattedStringComplete();
````

## Crédits

- extended_jdtofrench par [pieterc](http://php.net/manual/en/function.jdtofrench.php)

- une grande autre partie du script par [squenz](http://php.net/manual/en/function.jdtofrench.php)
