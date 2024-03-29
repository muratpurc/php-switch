PHP Switch {%PHPSWITCH_VERSION%}

####################################################################################################
TOC (Table of contents)

- BESCHREIBUNG
- CHANGELOG
- VORAUSSETZUNGEN
- INSTALLATION/VERWENDUNG
- HINWEISE
- FAQ
- SCHLUSSBEMERKUNG


####################################################################################################
BESCHREIBUNG

Unterst�tzt das Wechseln zwischen verschiedenen PHP 5 Versionen auf einem Windows Rechner (XP/Vista/2003).

PHP Switch ist zwar f�r eine XAMPP Installation gemacht, kann aber f�r andere Systeme verwendet werden.

Im Folgenden wird bei den Erkl�rungen/Beispielen davon ausgegangen, dass XAMPP unter "C:\xampp" 
installiert ist. Dies kann je nach Installation ganz anders sein.



####################################################################################################
CHANGELOG

2009-09-13: PHP Switch 0.1rc
    * first release



####################################################################################################
VORAUSSETZUNGEN

Eine vollst�ndige und funktionsf�hige XAMPP (oder jeder andere WAMPP Server-Stack) Installation 
auf einem Windows System (XP/Vista/2003).



####################################################################################################
INSTALLATION/VERWENDUNG

Angenommen, es wurde auf dem System XAMPP 1.7.2 mit PHP 5.3.0 in das Verzeichnis "C:\xampp\" 
installiert.

PHP-Installationen
------------------
1. Eine Datei PHP_VERSION (ohne Dateiendung) im Verzeichnis "C:\xampp\php\" erstellen, und die 
   Version von PHP (z. B. 5.3.0) in die Datei schreiben.

2. Falls im PHP-Verzeichnis ("C:\xampp\php\") die DLLs php5apache2_2.dll und 
   php5apache2_2_filter.dll fehlen, sind aus dem Apache Modules-Verzeichnis die PHP DLL's in 
   das PHP-Verzeichnis zu kopieren.
   - Kopieren von "C:\xampp\apache\modules\php5apache2_2.dll" in "C:\xampp\php\php5apache2_2.dll"
   - Kopieren von "C:\xampp\apache\modules\php5apache2_2_filter.dll" 
     in "C:\xampp\php\php5apache2_2_filter.dll"

3. Download einer XAMPP Installation, mit einer �lteren PHP Version als 5.3.0, z. B. 
   die XAMPP 1.7.1, in der PHP 5.2.9 enthalten ist.
   (http://sourceforge.net/projects/xampp/files/XAMPP%20Windows/1.7/xampp-win32-1.7.1.zip/download)
   HINWEIS:
   Wir brauchen nur die zip-Version, da wir keine erneute Installation durchf�hren.

4. Kopieren des PHP-Ordners aus xampp-win32-1.7.1.zip in das XAMPP-Installationsverzeichnis.
   z. B.
   Kopieren von "xampp-win32-1.7.1.zip\xampp\php\" in "C:\xampp\php_5.2.9\".
   HINWEIS:
   Das Zielverzeichnis hei�t diesmal php_5.2.9, enth�lt also das Format php_{version}
   Das gilt auch f�r alle anderen PHP-Installationen.

5. Eine Datei PHP_VERSION (ohne Dateiendung) im Verzeichnis "C:\xampp\php_5.2.9\" erstellen, und die 
   Version von PHP (z. B. 5.2.9) in die Datei schreiben.

6. Falls im PHP-Verzeichnis ("C:\xampp\php_5.2.9\") die DLLs php5apache2_2.dll und 
   php5apache2_2_filter.dll fehlen, sind diese aus dem Apache Modules-Verzeichnis die PHP DLL's in 
   das PHP-Verzeichnis zu kopieren.
   - Kopieren von "xampp-win32-1.7.1.zip\apache\modules\php5apache2_2.dll" 
     in "C:\xampp\php_5.2.9\php5apache2_2.dll"
   - Kopieren von "xampp-win32-1.7.1.zip\apache\modules\php5apache2_2_filter.dll" 
     in "C:\xampp\php_5.2.9\php5apache2_2_filter.dll"


F�r jede weitere PHP-Installation sind die Schritte 3 - 6 erneut durchzuf�hren.


Apache Konfiguration
--------------------
1. Das PHP-Modul Setup in der Apache Konfiguration anpassen.

   Eventuell steht in der LoadModule Direktive der relative Pfad zur php5apache2_2.dll im Apache 
   Modules Verzeichnis drin:
   [code]
   LoadModule php5_module modules/php5apache2_2.dll
   [/code]

   Da nun jede PHP-Installation seine eigene php5apache2_2.dll enth�lt, ist diese Direktive 
   anzupassen in
   [code]
   LoadModule php5_module "C:\\xampp\\php\\php5apache2_2.dll"
   [/code]

2. Apache neu starten.


PHP Switch installation:
------------------------
1. Kopieren von PHP Switch in ein Verzeichnis, z. B. in "C:\Programme\phpswitch"

2. Anpassen der Konfiguration aus PHP Switch "C:\Programme\phpswitch\config.ini"
   - phpInstallationsPath:
     Der Pfad zu den PHP-Installationen (inkl. abschlie�endem Backslash).
     Wert: "C:\xampp\"

   - phpIgnoreDirs:
     Verzeichnisse, die in "phpInstallationsPath" vorkommen, aber ignoriert werden sollen.
     HINWEIS:
     Mehrere Verzeichnisse mit einem Komma trennen.
     Wert: "phpMyAdmin" oder "phpMyAdmin,phpOrdner,phpOrdner2"

   - phpExePath:
     Verzeichnis, in dem die php.exe liegt (inkl. abschlie�endem Backslash).
     Wert: "C:\xampp\php\"

   - phpDirName:
     Name des PHP Ordners, der in "phpInstallationsPath" liegt.
     HINWEIS:
     Der Ordnername ist per Default "php" und sollte nicht ge�ndert werden.
     Wert: "php"

   - apacheService:
     Name des Apache Services, sofern Apache als Service installiert ist. Ist der Servicename 
     angegeben, wird versucht den Dienst vorher zu stoppen und nach dem Wechsel wieder zu starten.
     Ist Apache nicht als Dienst installiert, oder das Stoppen/Starten nicht erw�nscht, den Wert
     leer lassen.
     Wert: "Apache2.2" oder ""

   - debugEnable:
     Flag zum Aktivieren des Debugging. Dabei werden etwas mehr Informationen ausgegeben.
     Wert: "1" oder "0"


Verwendung:
-----------
1. Durch Doppelklick auf die "php-switch.bat"
2. Durch die Kommandozeile
   - Windows-Taste + R dr�cken, cmd Eingeben und auf Enter-Taste dr�cken
   - Zum phpswitch Installationsverzeichnis wechseln
   - php-switch.bat in die Kommandozeile eingeben und Enter-Taste dr�cken



####################################################################################################
HINWEISE

F�r die Verwendung von PHP Switch gibt es ein paar Konventionen, die zu beachten sind.

1. Jede PHP Installation sollte innerhalb des gleichen Verzeichnisses abgelegt werden.
   Beispiel:
   C:\xampp\
      php\
      php_5.2.9\
      php_5.2.0\
      ...

2. Jeder PHP Installationsordner sollte mit dem gleichen Pr�fix beginnen. Das Format ist immer 
   php_{version}.
   Beispiel:
   php, php_5.2.9, php_5.2.0

3. In jedem PHP Installationsordner ist eine Datei mit der Bezeichnung PHP_VERSION (ohne Dateiendung) 
   abzulegen. Der Inhalt der Datei ist die PHP Version.
   Beispiel:
   Beispiel:
   C:\xampp\
      php\PHP_VERSION  ->  Inhalt 5.3.0
      php_5.2.9\PHP_VERSION  ->  Inhalt 5.2.9
      php_5.2.0\PHP_VERSION  ->  Inhalt 5.2.0

4. PHP Switch wechselt die PHP Installation, indem es die Verzeichnisse umbenennt.
   Die aktuelle PHP Installation hat immer die Bezeichnung "php". Wird zur einer anderen 
   PHP Version gewechselt, �ndert PHP Switch den Ordnernamen in php_{version} um.

5. Jede PHP Installation ist komplett eigenst�ndig, es gibt keine Abh�ngigkeiten untereinander.
   Aktualisierungen/�nderungen in den PEAR-Packages oder PHP-Modulen wirken sich nicht auf die 
   anderen PHP-Installationen aus.


####################################################################################################
FAQ

Bei mir kann unter Vista der Apache Service nicht gestoppt/gestartet werden, was kann ich da machen?
----------------------------------------------------------------------------------------------------
a.) Entweder den Apache Service manuell starten/stoppen. Damit PHP-Switch den Servicestatus nicht 
    steuert, in der Konfiguration (config.ini) den Wert f�r apacheService leer lassen.
b.) Unter Vista kann je nach Benutzer/Einstellung die Berechtigung zum Ausf�hren solcher Prozesse
    nicht ausreichen, das das Starten und Stoppen von Diensten Administratorrechte ben�tigt.
    Es ist aber mit folgender Vorgehensweise dennoch machbar:
    - Eine Verkn�pfung von "php-switch.bat" erstellen
    - Verkn�pfung markieren, rechte Maustaste klicken, danach im Kontextmen� auf "Eigenschaften"
      klicken
    - Zum Register "Verkn�pfung" wechseln
    - Auf den Button "Erweitert" klicken
    - Im neuen Fenster die Checkbox "Als Administrator ausf�hren" setzen
    - Alle Fenster mit Klick auf "OK" schlie�en
    Eine bebilderte Beschreibung gibt es unter:
    http://www.vistaclues.com/run-a-batch-file-as-an-administrator/


Warum st�rzt Apache beim Erstellen einer DB-Verbindung ab?
----------------------------------------------------------
Verschiedene PHP Versionen brauchen in der Regel verschiedene libmysql.dll. Wenn z. B. auf dem 
System XAMPP 1.7.2 mit PHP 5.3.0 und danach noch PHP 5.2.11 installiert wurde, wird die 
DB-Verbindung mit einer libmysql.dll aufgebaut, die aber nicht kompatibel zu PHP 5.2.11 ist. 
Das bringt dann den Apachen zum Absturz. In der Ereignisanzeige findet man dann eine Fehlermeldung 
wie:

    Fehlerhafte Anwendung httpd.exe, Version 2.2.12.0, Zeitstempel 0x4a66dd7b, fehlerhaftes Modul 
    php5ts.dll, Version 5.2.11.11, Zeitstempel 0x4ab130e3, Ausnahmecode 0xc0000005, Fehleroffset 
    0x0000abbe, Prozess-ID 0x1318, Anwendungsstartzeit 01ca50dbe37eda67

Um dieses Problem zu umgehen, sollte die richtige Version der libmysql.dll entsprechend der aktuell 
laufenden PHP Version geladen werden. Das kann man erreichen, in dem z. B. die libmysql.dll aus den 
verschiedenen Installationen jeweils in das PHP-Installationsverzeichnis kopiert wird.

In XAMPP 1.7.2 liegt die libmysql.dll zus�tzlich noch in folgenden Verzeichnissen:
- C:\xampp\mysql\bin\
- C:\xampp\apache\bin\

Diese Versionen der libmysql.dll sollten entweder gel�scht oder z. B. in libmysql_old.dll umbenannt 
werden.

Damit die libmysql.dll aus dem PHP-Ordner auch anderen Applikationen bei Bedarf zur Verf�gung steht, 
sollte der Pfad zum PHP-Ordner noch der Umgebungsvariable PATH hinzuf�gt werden 
(z. B. mit C:\xampp\php\).



####################################################################################################
SCHLUSSBEMERKUNG

Benutzung des Scripts auf eigene Gefahr und bitte vorher immer ein Backup machen!

Murat Purc, murat@purc.de
