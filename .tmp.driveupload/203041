@echo off
:: %1 is the first argument passed to the batch file (the scheduled_tasks.id)
:: Make sure PHP path is absolute

echo %DATE% %TIME% >> "V:\xampp\htdocs\tex\schedule_report_log.txt"

V:\xampp\php\php.exe "V:\xampp\htdocs\tex\sendScheduledReport.php" %1 >> "V:\xampp\htdocs\tex\schedule_report_log.txt" 2>&1
