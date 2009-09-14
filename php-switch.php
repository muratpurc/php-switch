<?php
/**
 * Copyright (c) 2009, Murat Purc <murat@purc.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 *
 *  * Redistributions of source code must retain the above copyright notice, this 
 *    list of conditions and the following disclaimer.
 *
 *  * Redistributions in binary form must reproduce the above copyright notice, 
 *    this list of conditions and the following disclaimer in the documentation 
 *    and/or other materials provided with the distribution.
 *
 *  * Neither the name of Murat Purc nor the names of his contributors may 
 *    be used to endorse or promote products derived from this software without 
 *    specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, 
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, 
 * OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, 
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @author		Murat Purc <murat@purc.de>
 * @copyright 	2009 Murat Purc
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @category    Development
 * @package 	PHPSwitch
 * @version     $Id$
 */


/**
 * PHP-Switch
 * Based on ApacheFriends XAMPP PHP Switch
 * Author: Kay Vogelgesang & Carsten Wiedmann for www.apachefriends.org 2006
 * Author: Murat Purc
 */


// some constants
define(LF, "\r\n");
define(LFD, "\r\n\r\n");
define(PHPSWITCH_DIR, str_replace('\\', '/', realpath(dirname(__FILE__) . '/')) . '/');

require_once(PHPSWITCH_DIR . 'lib/PHPSwitch.php');
require_once(PHPSWITCH_DIR . 'lib/PHPSwitch/Rename.php');
require_once(PHPSWITCH_DIR . 'lib/PHPSwitch/Rename/Transaction.php');


echo LF
   . "  ########################################################################" . LF
   . "  # PHP Switch, switches between different PHP 5 Versions                #" . LF
   . "  #----------------------------------------------------------------------#" . LF
   . "  # Copyright (c) 2009 Murat Purc, murat@purc.de                         #" . LF
   . "  #----------------------------------------------------------------------#" . LF
   . "  # Author: Murat Purc <murat@purc.de>                                   #" . LF
   . "  ########################################################################" . LFD;



$switch = PHPSwitch::getInstance();


// apache check
if ($switch->isApacheRunning()) {
    PHPSwitch::_('The Apache is running! Please stop the Apache before make this procedure!' . LF
        . 'Der Apache laeuft gerade! Bitte den Apache fuer diese Prozedur stoppen!' . LF
        . 'PHP Switch exit ...'
    );
    exit;
}


// initialize php switch
$res = $switch->initialize();
if ($res === -1) {
    PHPSwitch::_('Missing or invalid configuration "phpInstallationsPath"!' . LF
        . 'Fehlende oder ungueltige Konfiguration "phpInstallationsPath"!' . LF
        . 'PHP Switch exit ...'
    );
    exit;
} elseif ($res === -2) {
    PHPSwitch::_('Could not find any installed PHP Versions, ' . LF
        . '  please check your configuration "phpInstallationsPath"!' . LF
        . 'Konnte keine installierten PHP Versionen finden, ' . LF
        . '  bitte ueberpruefe die Konfiguration "phpInstallationsPath"!' . LF
        . 'PHP Switch exit ...'
    );
    exit;
} elseif ($res === -3) {
    $curr = $switch->getCurrentInstallation();
    PHPSwitch::_('Could not find further installed PHP Versions ' . LF
        . '  other than current running one ' . $curr['version'] . '!' . LF
        . 'Konnte keine weiteren installierten PHP Versionen, ' . LF 
        . '  außer den aktuellen' . $curr['version'] . ', finden!' . LF
        . 'PHP Switch exit ...'
    );
    exit;
}


// get user selection
$selection = $switch->getUserSelection();
if ($selection == 'x') {
    PHPSwitch::_('PHP Switch is terminating on demand ...' . LF
        . 'PHP Switch wurde auf Wunsch abgebrochen ...' . LF
        . 'PHP Switch exit ...'
    );
    sleep(1);
    exit;
}


// handle the switch
$res = $switch->doTheSwitch($selection);
if ($res === -1) {
    PHPSwitch::_('Invalid switch selection ' . $selection . LF
        . 'Ungueltige switch Auswahl' . $selection . LF
        . 'PHP Switch exit ...'
    );
    exit;
}


return;


####################################################################################################



