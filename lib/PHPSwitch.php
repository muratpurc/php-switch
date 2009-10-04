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
 * PHP switch class, does the main job.
 *
 * @author		Murat Purc <murat@purc.de>
 * @copyright 	2009 Murat Purc
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @category    Development
 * @package 	PHPSwitch
 */
class PHPSwitch
{
    /**
     * Self instance
     * @var  PHPSwitch
     */
    private static $_instance = null;

    /**
     * Debug status
     * @var  bool
     */
    private static $_debug = true;

    /**
     * Configuration array
     * @var  array
     */
    private $_cfg = array();

    /**
     * List of found installations
     * @var  array
     */
    private $_installations = array();

    /**
     * Internal counter, will be incremented on each installation, where the version is not detectable
     * @var  int
     */
    private $_unknownCounter = 0;


    /**
     * Constructor (prevent public instantiation)
     */
    protected function __construct()
    {
        // donut
    }


    /**
     * Prevent cloning
     */
    private function __clone()
    {
        // donut
    }


    /**
     * Returns self instance which will be creatd once.
     *
     * @return  PHPSwitch
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    /**
     * Checks, if apache is running.
     *
     * @return  bool
     */
    public function isApacheRunning()
    {
        $isRunning = false;
        ini_set('default_socket_timeout', '3');
        if (false !== ($handle = @fopen('http://127.0.0.1/', 'r'))) {
            fclose($handle);
            $isRunning = true;
        }
        unset($handle);
        return $isRunning;
    }


    /**
     * Initializes the PHP switch, read the configuration file (ini file) and an found PHP 
     * installations.
     *
     * @return  int|bool  Either true on success or a digit less than 0 as a error status as follows:
     *                    - -1 = Invalid PHP installation path
     *                    - -2 = No PHP installation found
     *                    - -3 = The exists only one installation, nothing to switch
     */
    public function initialize()
    {
        // some settings
        $cfg = parse_ini_file(PHPSWITCH_DIR . 'config.ini');
        $this->_cfg = array_merge($this->_cfg, $cfg);

        if (!isset($this->_cfg['phpInstallationsPath']) || !is_dir($this->_cfg['phpInstallationsPath'])) {
            return -1;
        }

        if (!isset($this->_cfg['phpIgnoreDirs']) && $this->_cfg['phpIgnoreDirs'] == '') {
            $this->_cfg['phpIgnoreDirs'] = array();
        } else {
            $this->_cfg['phpIgnoreDirs'] = explode(',', $this->_cfg['phpIgnoreDirs']);
        }

        if (isset($this->_cfg['debugEnable'])) {
            self::$_debug = ($this->_cfg['debugEnable'] == '1') ? true : false;
        }

        if (!isset($this->_cfg['phpDirName']) || $this->_cfg['phpDirName'] == '') {
            $this->_cfg['phpDirName'] = 'php';
        }

        // set all installations
        $this->_setInstallations();

        if (count($this->_installations) == 0) {
            return -2;
        }

        $installations = $this->getInstallationsExceptCurrent();
        if (count($installations) == 0) {
            return -3;
        }

        return true;
    }


    /**
     * Returns the current active installation
     *
     * @return  array|null  The current installation array or null, if nothing exists.
     */
    public function getCurrentInstallation()
    {
        foreach ($this->_installations as $pos => $item) {
            if ($item['current']) {
                return $item;
            }
        }
        return null;
    }


    /**
     * Returns all found PHP installations except the current active one
     *
     * @return  array  The php installations array
     */
    public function getInstallationsExceptCurrent()
    {
        $installations = array();
        foreach ($this->_installations as $pos => $item) {
            if ($item['current']) {
                continue;
            }
            $installations[] = $item;
        }
        return $installations;
    }


    /**
     * Handles the userinteraction by using stdin and returns back the user selection
     *
     * @return  string  Either 'x' to exit or a digit ('1', '2', '3', etc.), representing the 
     *                  selected option position.
     */
    public function getUserSelection()
    {
        $currInstallation = $this->getCurrentInstallation();
        $installations    = $this->getInstallationsExceptCurrent();

        $userInput = '0';

        set_time_limit(0);
        $hStdin = fopen('php://stdin', 'r');
        while ($userInput == '0') {

            if ($currInstallation) {
                self::_('Current running PHP version is ' . $currInstallation['version'] . LF
                    . 'Die aktuell laufende PHP Version ist ' . $currInstallation['version'] . '!'
                );
            }

            self::_('Type number or "x" (exit) for selecting your choice!' . LF
                . 'Gebe nun Nummer oder "x" (exit) zum auswaehlen ein!'
            );

            $options = '';
            foreach ($installations as $pos => $item) {
                $p = $pos + 1;
                $v = $item['version'];
                $options .= $p . ') Switch to PHP ' . $v . ' (zu PHP ' . $v . ' wechseln)' . LF;
            }
            $options .= 'x) Exit (Beenden)';
            self::_($options);

            $userInput = (trim(fgets($hStdin, 256)));
            sleep(1);
            if ($userInput == 'x') {
                break;
            } else {
                $pos = ((int) $userInput);
                if ($pos <= 0 || $pos > count($installations)) {
                    self::_('Invalid selection. Type number or "x" (exit) for selecting your choice!' . LF
                        . 'Ungueltige Auswahl. Gebe die Nummer oder "x" (exit) zum auswaehlen ein!'
                    );
                } else {
                    break;
                }
            }
        }
        fclose($hStdin);

        return $userInput;
    }


    /**
     * Does the PHP switch. 
     *
     * @param   string  The selected position from the displayed options list.
     * @return  bool  True on success otherwhise false.
     */
    public function doTheSwitch($version)
    {
        $currInst = $this->getCurrentInstallation();
        $installations    = $this->getInstallationsExceptCurrent();
        $pos = (int) $version;
        if ($pos <= 0 || $pos > count($installations)) {
            return - 1;
        }
        $pos = $pos-1;

        $newInst = $installations[$pos];
        self::_('Starting switch to PHP ' . $newInst['version'] . LF
            . 'Beginne mit dem Wechsel zu PHP ' . $newInst['version']
        );

        $renameCur = new PHPSwitch_Rename($currInst['path'], $this->_cfg['phpInstallationsPath'] . $this->_cfg['phpDirName'] . '_' . $currInst['version']);
        $renameNew = new PHPSwitch_Rename($newInst['path'], $this->_cfg['phpInstallationsPath'] . $this->_cfg['phpDirName']);

        $transaction = new PHPSwitch_Rename_Transaction();
        $transaction->add($renameCur);
        $transaction->add($renameNew);
        if (!$transaction->run()) {
            $res = $transaction->rollback();
            return false;
        } else {
            return true;
        }
    }


    /**
     * Static function to print messages.
     *
     * @param  string  $msg
     */
    public static function _($msg)
    {
        $tmp = explode(LF, $msg);
        foreach($tmp as $p => $v) {
            $tmp[$p] = '  ' . $v;
        }
        $msg = implode(LF, $tmp);
        echo LF . $msg . LFD;
    }


    /**
     * Static function to print debug messages.
     *
     * The output will happen, if debugging is enabled (@see PHPSwitch::$_debug)
     *
     * @param  string  $msg
     */
    public static function _d($msg)
    {
        if (!self::$_debug) {
            return;
        }
        $tmp = explode(LF, $msg);
        foreach($tmp as $p => $v) {
            $tmp[$p] = '  ## ' . $v;
        }
        $msg = implode(LF, $tmp);
        echo LF . $msg . LFD;
    }


    /**
     * Reads the PHP installations path and collects all found PHP installations.
     */
    private function _setInstallations()
    {
        // open php installations dir
        if (!$handle = opendir($this->_cfg['phpInstallationsPath'])) {
            return;
        }

        // read all matching php directories
        $debug = '';
        while ($file = readdir($handle)) {
            if ($file == '.' || $file == '..' || !is_dir($this->_cfg['phpInstallationsPath'] . $file)) {
                continue;
            }
            if (strpos($file, $this->_cfg['phpDirName']) === 0 && !in_array($file, $this->_cfg['phpIgnoreDirs']) && 
                is_file($this->_cfg['phpInstallationsPath'] . $file . '/php.exe')) {
                $debug .= 'Found PHP installation: ' . $this->_cfg['phpInstallationsPath'] . $file . LF;
                $this->_installations[] = array(
                    'path'    => $this->_cfg['phpInstallationsPath'] . $file,
                    'current' => ($file == $this->_cfg['phpDirName']),
                    'version' => self::_readPHPVersion($this->_cfg['phpInstallationsPath'] . $file . '/PHP_VERSION')
                );
            }
        }
        self::_d($debug);
        
        closedir($handle);
    }


    /**
     * Reads the PHP version from a found PHP installation.
     * 
     * @param   string  $filePathName  The path and name of the file containing the PHP version
     * @return  string  The version
     */
    private function _readPHPVersion($filePathName)
    {
        $version = '';
        if (is_file($filePathName)) {
            $version = trim(file_get_contents($filePathName));
        }
        if ($version == '') {
            $version = $this->_getNextUnknownPos();
        }
        return $version;
    }


    /**
     * Returns the next unknown position string which will be used to mark unknown PHP versions.
     * 
     * @param  string  The unknown position string
     */
    private function _getNextUnknownPos()
    {
        return 'Unknown PHP version ' . (string) ++$this->_unknownCounter;
    }

}
