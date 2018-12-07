@echo off
@setlocal
set CODECEPT_PATH=./vendor/bin/
"%CODECEPT_PATH%phpstan.bat" %*
@endlocal