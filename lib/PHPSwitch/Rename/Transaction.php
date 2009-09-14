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
 * Transaction class, provides multiple renaimings with rollback possibility.
 *
 * @author		Murat Purc <murat@purc.de>
 * @copyright 	2009 Murat Purc
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @category    Development
 * @package 	PHPSwitch
 * @subpackage  Rename
 */
class PHPSwitch_Rename_Transaction
{
    /**
     * List of PHPSwitch_Rename instances
     * @var  array
     */
    private $_instances = array();
   
    /**
     * Flag to store the transaction status
     * @var  bool
     */
    private $_failure = false;


    /**
     * Constructor
     */
    public function __construct()
    {
        // donut
    }


    /**
     * Adds a PHPSwitch_Rename to the list
     *
     * @param  PHPSwitch_Rename  $obj
     */
    public function add(PHPSwitch_Rename $obj)
    {
        $this->_instances[] = $obj;
    }


    /**
     * Runs the transaction. If one of of the existing steps return a failure, further 
     * processing will be skipped.
     *
     * @return  bool  True in success otherwhise false
     */
    public function run()
    {
        foreach ($this->_instances as $obj) {
            if (!$res = $obj->execute()) {
                $this->_failure = true;
                return false;
            }
        }
        return true;
    }


    /**
     * Runs the rollback of previous executed commands. The rollback should reset all previous done 
     * changes. If the rollback for whatever reason also fails, it's manual time ;-)
     *
     * @return  bool  True in success otherwhise false
     */
    public function rollback()
    {
        if (!$this->_failure) {
            return true;
        }

        foreach ($this->_instances as $obj) {
            if (!$res = $obj->undo()) {
                $this->_failure = true;
                return false;
            }
        }
        $this->_failure = false;
        return true;
    }
}


