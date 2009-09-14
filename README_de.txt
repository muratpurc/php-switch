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

Unterstützt das Wechseln zwischen verschiedenen PHP 5 Versionen auf einem Windows Rechner (XP/Vista/2003).

PHP Switch ist zwar für eine XAMPP Installation gemacht, kann aber für andere Systeme verwendet werden.

Bei den folgenden Beispielen wird der XAMPP Installations-Pfad als "C:\xampp" angegeben. Dies kann
je nach Installation ganz anders sein.



####################################################################################################
CHANGELOG

2009-09-13: PHP Switch 0.1rc
    * first release



####################################################################################################
VORAUSSETZUNGEN

Eine vollständige und funktionsfähige XAMPP (oder jede andere WAMPP Server-Stack) Installation 
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
   php5apache2_2_filter.dll fehlen, sind diese aus dem Apache Modules-Verzeichnis die PHP DLL's in 
   das PHP-Verzeichnis zu kopieren.
   - Kopieren von "C:\xampp\apache\modules\php5apache2_2.dll" in "C:\xampp\php\php5apache2_2.dll"
   - Kopieren von "C:\xampp\apache\modules\php5apache2_2_filter.dll" 
     in "C:\xampp\php\php5apache2_2_filter.dll"

3. Download einer XAMPP Installation, mit einer älteren PHP Version als 5.3.0, z. B. 
   die XAMPP 1.7.0, in der PHP 5.2.8 enthalten ist.
   (http://sourceforge.net/projects/xampp/files/XAMPP%20Windows/1.7/xampp-win32-1.7.0.zip/download)
   HINWEIS:
   Wir brauchen nur die zip-Version, da wir keine erneuete Installation durchführen.

4. Kopieren des PHP-Ordners aus xampp-win32-1.7.0.zip in das XAMPP-Installationsverzeichnis.
   z. B.
   Kopieren von "xampp-win32-1.7.0.zip\xampp\php\" in "C:\xampp\php_5.2.8\".
   HINWEIS:
   Das Zielverzeichnis heißt diesmal php_5.2.8, enthält also das Format php_{version}
   Das gilt auch für alle anderen PHP-Installationen.

5. Eine Datei PHP_VERSION (ohne Dateiendung) im Verzeichnis "C:\xampp\php_5.2.8\" erstellen, und die 
   Version von PHP (z. B. 5.2.8) in die Datei schreiben.

6. Falls im PHP-Verzeichnis ("C:\xampp\php_5.2.8\") die DLLs php5apache2_2.dll und 
   php5apache2_2_filter.dll fehlen, sind diese aus dem Apache Modules-Verzeichnis die PHP DLL's in 
   das PHP-Verzeichnis zu kopieren.
   - Kopieren von "xampp-win32-1.7.0.zip\apache\modules\php5apache2_2.dll" 
     in "C:\xampp\php_5.2.8\php5apache2_2.dll"
   - Kopieren von "xampp-win32-1.7.0.zip\apache\modules\php5apache2_2_filter.dll" 
     in "C:\xampp\php_5.2.8\php5apache2_2_filter.dll"


Für jede weitere PHP-Installation sind die Schritte 3 - 6 erneuit durchzuführen.


Apache Konfiguration
--------------------
1. Das PHP-Modul Setup in der Apache Konfiguration anpassen.

   Eventuell steht in der LoadModule Direktive der relative Pfad zur php5apache2_2.dll im Apache 
   Modules Verzeichnis drin:
   [code]
   LoadModule php5_module modules/php5apache2_2.dll
   [/code]

   Da nun jede PHP-Installation seine eigene php5apache2_2.dll enthält, ist diese Direktive 
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
     Der Pfad zu den PHP-Installationen (inkl. abschließendem Backslash).
     Wert: "C:\xampp\"

   - phpIgnoreDirs:
     Verzeichnisse, die in "phpInstallationsPath" vorkommen, aber ignoeriert werden sollen.
     HINWEIS:
     Mehrere Verzeichnisse mit einem Komma trennen.
     Wert: "phpMyAdmin" oder "phpMyAdmin,phpOrdner,phpOrdner2"

   - phpExePath:
     Verzeichnis, in dem die php.exe liegt (inkl. abschließendem Backslash).
     Wert: "C:\xampp\php\"

   - phpDirName:
     Name des PHP Ordners, der in "phpInstallationsPath" liegt.
     HINWEIS:
     Der Ordnername ist per Default "php" und sollte nicht geändert werden.
     Wert: "php"

   - apacheService:
     Name des Apache Services, sofern Apache als Service installiert ist. Ist der Servicename 
     angegeben, wird versucht den Dienst vorher zu stoppen und nach dem Wechsel wieder zu starten.
     Ist Apache nicht als Dienst installiert, oder das Stoppen/Starten nicht erwünscht, den Wert
     leer lassen.
     Wert: "Apache2.2" oder ""

   - debugEnable:
     Flag zum Aktivieren des Debugging. Dabei werden etwas mehr Informationen ausgegeben.
     Wert: "1" oder "0"


Verwendung:
-----------
1. Durch Doppelklick auf die "php-switch.bat"
2. Durch die Kommandozeile
   - Windows-Taste + R drücken, cmd Eingeben und auf Enter-Taste drücken
   - Zum phpswitch Installationsverzeichnis wechseln
   - php-switch.bat in die Kommandozeile eingeben und Enter-Taste drücken



####################################################################################################
HINWEISE

Für die Verwendung von PHP Switch gibt es ein paar Konventionen, die zu beachten sind.

1. Jede PHP Installation sollte innerhalb des gleichen Verzeichnisses abgelegt werden.
   Beispiel:
   C:\xampp\
      php\
      php_5.2.8\
      php_5.2.0\
      ...

2. Jeder PHP Installationsordner sollte mit dem gleichen Prefix beginnen. Das Format ist immer 
   php_{version}.
   Beispiel:
   php, php_5.2.8, php_5.2.0

3. In jedem PHP Installationsordner ist eine Datei mit der Bezeichnung PHP_VERSION (ohne Dateiendung) 
   abzulegen. Der Inhalt der Datei ist die PHP Version.
   Beispiel:
   Beispiel:
   C:\xampp\
      php\PHP_VERSION  ->  Inhalt 5.3.0
      php_5.2.8\PHP_VERSION  ->  Inhalt 5.2.8
      php_5.2.0\PHP_VERSION  ->  Inhalt 5.2.0

4. PHP Switch wechselt die PHP Installation, indem es die Verzeichnisse umbenennt.
   Die aktuelle PHP Installation hat immer die Bezeichnung "php". Wird zur einer anderen 
   PHP Version gewechselt, ändert PHP den Ordnernamen in php_{version} um

5. Jede PHP Installation ist komplett eigenständig, es gibt keine Abhängigkeiten untereinander.
   Aktualisierungen/Änderungen in den PEAR-Packages oder PHP-Modulen sind wirken sich nicht auf 
   die anderen PHP-Installationen aus.


####################################################################################################
FAQ

Bei mir kann unter Vista der Apache Service nicht gestoppt/gestartet werden, was kann ich da machen?
----------------------------------------------------------------------------------------------------
a.) Endweder den Apache Service manuell starten/stoppen. Damit PHP-Switch den Servicestatus nicht 
    steuert, in der Konfiguration (config.ini) den Wert für apacheService leer lassen.
b.) Unter Vista kann je nach Benutzer/Einstellung die Berechtigung zum Ausführen solcher Prozesse
    nicht ausreichen, das das Starten und Stoppen von Diensten Administratorrechte benötigt.
    Es ist aber mit folgender Vorgehensweise dennoch machbar:
    - Eine Verküpfung von "php-switch.bat" erstellen
    - Verküpfung markieren, rechte Maustaste klicken, danach im Kontextmenü auf "Eigenschaften"
      klicken
    - Zum Register "Vernüpfung" wechseln
    - Auf den Button "Erweitert" klicken
    - Im neuen Fenster die Checkbox "Als Administrator ausführen" setzen
    - Alle Fenster mit Klick auf "OK" schließen
    Eine bebilderte Beschreibung gibt es unter:
    http://www.vistaclues.com/run-a-batch-file-as-an-administrator/



####################################################################################################
SCHLUSSBEMERKUNG

Benutzung des Scripts auf eigene Gefahr und bitte vorher immer ein Backup machen!

Murat Purc, murat@purc.de
