set SWI_PROLOG_PATH=c:/program files/swipl
set path=%path%;%SWI_PROLOG_PATH%\bin\;%SWI_PROLOG_PATH%\lib\
swipl.exe --dump-runtime-variables=cmd > plvars.bat
call plvars.bat
java -jar API.jar
del plvars.bat
del examples\call2.pl