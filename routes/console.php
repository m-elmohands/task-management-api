<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('tasks:check-overdue')->daily();
