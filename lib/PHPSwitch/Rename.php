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
 * @subpackage  Rename
 * @version     $Id$
 */


/**
 * Renaiming class, uses the command pattern with undo feature.
 *
 * @author		Murat Purc <murat@purc.de>
 * @copyright 	2009 Murat Purc
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @category    Development
 * @package 	PHPSwitch
 * @subpackage  Rename
 */
class PHPSwitch_Rename
{
    /**
     * Old file/folder name
     * @var  string
     */
    private $_oldName;

    /**
     * New file/folder name
     * @var  string
     */
    private $_newName;

    /**
     * Flag to store successfull renaming status
     * @var  bool
     */
    private $_renamed = false;


    /**
     * Constructor
     *
     * @param  string  $oldName  Old file/folder name
     * @param  string  $newName  New file/folder name
     */
    public function __construct($oldName, $newName)
    {
        $this->_oldName = $oldName;
        $this->_newName = $newName;
    }

    /**
     * The main function, which does the rename job
     *
     * @return  bool  True on success otherwhise false
     */
    public function execute()
    {
        PHPSwitch::_d("Old name: $this->_oldName" . LF . "New name: $this->_newName");
        if ($res = rename($this->_oldName, $this->_newName)) {
            $this->_renamed = true;
        }
        return $res;
    }

    /**
     * Function to undo a previous successfull rename command
     *
     * @return  bool  True on success otherwhise false
     */
    public function undo()
    {
        if ($this->_renamed == false) {
            return true;
        }
        PHPSwitch::_d("Undo: New name: $this->_newName" . LF . "Old name: $this->_oldName");
        if ($res = rename($this->_newName, $this->_oldName)) {
            $this->_renamed = false;
        }
        return $res;
    }
}
