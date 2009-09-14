@echo off

:: configurable area:
:: ------------------
:: phpExePath    = The path to the php.exe (without the trailing backslash)
:: phpSwitchPath = The path to the script, which does the php switch (without the trailing backslash)
:: apacheService = Name of the Apache Service, if Apache is installed as a service
::: set phpExePath=C:\Progs\xampp\php
::: set phpSwitchPath=C:\Progs\phpswitch
::: set apacheService=Apache2.2

:: set directory of this batch file
set batchFileDir=%~dp0
::echo  %CD%
::echo %batchFileDir%
::goto END

set phpExePath=""
set phpSwitchPath=""
set apacheService=""

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
