<?php 
$task_id = 1;
$task_name = "MF_Report_Schedule_$task_id";
$time = "21:00";
$batch_file = "\\\\localhost\\V$\\xampp\\htdocs\\tex\\RunScheduledReport.bat";

// Delete existing task
exec("C:\\Windows\\System32\\schtasks.exe /delete /tn \"$task_name\" /f 2>&1");

// Create task
echo $taskCommand = "C:\\Windows\\System32\\schtasks.exe /create /tn \"$task_name\" /tr \"$batch_file $task_id\" /sc daily /st $time /RU SYSTEM 2>&1";
echo '<br />';
exec($taskCommand, $output, $return_var);

if ($return_var === 0) {
    echo "Task created successfully!\n";
} else {
    echo "Task creation failed! Exit code: $return_var\n";
    echo "Output:\n";
    print_r($output);
}
