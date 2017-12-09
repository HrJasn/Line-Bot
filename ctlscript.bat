@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist C:\web\hypersonic\scripts\ctl.bat (start /MIN /B C:\web\server\hsql-sample-database\scripts\ctl.bat START)
if exist C:\web\ingres\scripts\ctl.bat (start /MIN /B C:\web\ingres\scripts\ctl.bat START)
if exist C:\web\mysql\scripts\ctl.bat (start /MIN /B C:\web\mysql\scripts\ctl.bat START)
if exist C:\web\postgresql\scripts\ctl.bat (start /MIN /B C:\web\postgresql\scripts\ctl.bat START)
if exist C:\web\apache\scripts\ctl.bat (start /MIN /B C:\web\apache\scripts\ctl.bat START)
if exist C:\web\openoffice\scripts\ctl.bat (start /MIN /B C:\web\openoffice\scripts\ctl.bat START)
if exist C:\web\apache-tomcat\scripts\ctl.bat (start /MIN /B C:\web\apache-tomcat\scripts\ctl.bat START)
if exist C:\web\resin\scripts\ctl.bat (start /MIN /B C:\web\resin\scripts\ctl.bat START)
if exist C:\web\jboss\scripts\ctl.bat (start /MIN /B C:\web\jboss\scripts\ctl.bat START)
if exist C:\web\jetty\scripts\ctl.bat (start /MIN /B C:\web\jetty\scripts\ctl.bat START)
if exist C:\web\subversion\scripts\ctl.bat (start /MIN /B C:\web\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist C:\web\lucene\scripts\ctl.bat (start /MIN /B C:\web\lucene\scripts\ctl.bat START)
if exist C:\web\third_application\scripts\ctl.bat (start /MIN /B C:\web\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist C:\web\third_application\scripts\ctl.bat (start /MIN /B C:\web\third_application\scripts\ctl.bat STOP)
if exist C:\web\lucene\scripts\ctl.bat (start /MIN /B C:\web\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist C:\web\subversion\scripts\ctl.bat (start /MIN /B C:\web\subversion\scripts\ctl.bat STOP)
if exist C:\web\jetty\scripts\ctl.bat (start /MIN /B C:\web\jetty\scripts\ctl.bat STOP)
if exist C:\web\hypersonic\scripts\ctl.bat (start /MIN /B C:\web\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist C:\web\jboss\scripts\ctl.bat (start /MIN /B C:\web\jboss\scripts\ctl.bat STOP)
if exist C:\web\resin\scripts\ctl.bat (start /MIN /B C:\web\resin\scripts\ctl.bat STOP)
if exist C:\web\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT C:\web\apache-tomcat\scripts\ctl.bat STOP)
if exist C:\web\openoffice\scripts\ctl.bat (start /MIN /B C:\web\openoffice\scripts\ctl.bat STOP)
if exist C:\web\apache\scripts\ctl.bat (start /MIN /B C:\web\apache\scripts\ctl.bat STOP)
if exist C:\web\ingres\scripts\ctl.bat (start /MIN /B C:\web\ingres\scripts\ctl.bat STOP)
if exist C:\web\mysql\scripts\ctl.bat (start /MIN /B C:\web\mysql\scripts\ctl.bat STOP)
if exist C:\web\postgresql\scripts\ctl.bat (start /MIN /B C:\web\postgresql\scripts\ctl.bat STOP)

:end

