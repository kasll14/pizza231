@echo off
echo Импорт базы данных frutiger_courses...
mysql -u root -p frutiger_courses < database.sql
echo.
echo База данных импортирована успешно!
pause
