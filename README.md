# PHP Romme Republican Calendar

Une librairie PHP pour couvertir facilement une date dans le calendrier républicain, utilisant le [système Romme](http://prairial.free.fr/calendrier/calendrier.php?lien=discoursromme).

Le script peut afficher soit une date minimale (style 23 Brumaire, an 225) soit une date plus complexe (Tridi, 23 Brumaire, an 225 - Garance).

## Comment l'utiliser.

### Obtenir la date d'aujourd'hui dans le calendrier révolutionnaire romme

#### Afficher la date "simple" (jour + mois + année)

````php
include(romme-calendar.php);
echo datetoromme_getFormattedString($showDecadeDayName);
````
**$showDecadeDayName** détermine si vous affichez le nom du jour de la décade

Retourne (si $showDecadeDayName est sur true) : Nonidi 19 Brumaire, an 227
Retourne (si $showDecadeDayName est sur false) : 19 Brumaire, an 227

#### Affiche la date "complete" (avec l'epiphanie du jour)

````php
include(romme-calendar.php);
echo datetoromme_getFormattedStringComplete();
````

Retourne : Nonidi 19 Brumaire (*Grenade*), an 227

## Crédits

- extended_jdtofrench par [pieterc](http://php.net/manual/en/function.jdtofrench.php)

- une grande autre partie du script par [squenz](http://php.net/manual/en/function.jdtofrench.php)
