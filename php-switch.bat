@echo off

:: #################################################################################################
:: PHP Switch batch file 
:: @author      Murat Purc <murat@purc.de>
:: @copyright 	2009 Murat Purc
:: @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
:: @category    Development
:: @package 	PHPSwitch
:: @version     $Id$
:: #################################################################################################



:: set directory of this batch file
set batchFileDir=%~dp0

:: some default settings
set phpExePath=""
set phpSwitchPath=""
set apacheService=""

:: read config.ini
for /f "tokens=1,2 delims==" %%a in (%batchFileDir%config.ini) do (
    if %%a==phpExePath set phpExePath=%%b
    if %%a==apacheService set apacheService=%%b
)
::echo %phpExePath% %phpSwitchPath% %apacheService%
::goto END


:: php.exe check
if not exist %phpExePath%php.exe goto Abort


:: Continue further batch processing

if "%apacheService%"=="" goto apacheStopEND
net stop %apacheService%
:apacheStopEND


:: Call the switch script
%phpExePath%php.exe -n -d output_buffering=0 %batchFileDir%php-switch.php


if "%apacheService%"=="" goto apacheStartEND
net start %apacheService%
:apacheStartEND

goto END


:: Abort further batch processing
:Abort
echo Cannot find php cli, must abort these process!
goto END

:END
pause
