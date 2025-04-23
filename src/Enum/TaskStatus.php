<?php
// src/Enum/TaskStatus.php
namespace App\Enum;

enum TaskStatus: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
    case OVERDUE = 'overdue';
}
?>