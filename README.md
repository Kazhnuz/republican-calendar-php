# PHP Romme Republican Calendar

Une librairie PHP pour couvertir facilement une date dans le calendrier républicain, utilisant le [système Romme](http://prairial.free.fr/calendrier/calendrier.php?lien=discoursromme).

Le script peut afficher soit une date minimale (style 23 Brumaire, an 225) soit une date plus complexe (Tridi, 23 Brumaire, an 225 - Garance).

## Comment l'utiliser.

````php
include(republicandate.php);
echo gregorian2FrenchDateString($m,$d,$y); //affiche la date complète + la plante du jour.
echo gregorian2FrenchDateStringShort($m,$d,$y); //affiche la date réduite
````

## Crédits

- extended_jdtofrench par [pieterc](http://php.net/manual/en/function.jdtofrench.php)

- une grande autre partie du script par [squenz](http://php.net/manual/en/function.jdtofrench.php)
