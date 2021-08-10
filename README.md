# laravel-prune-database-table
Clear (prune) table rows in the database that older than given value (just like telescope:prune command)

# installation:
1) run in console command: composer install lex10000/laravel-prune-database-table
2) add LaravelPruneDatabaseTableProvider class to app/config/app.php
3) if you want to start command in the crone, add command to app/console/kernel.php in shedule method
(ex, $schedule->command('table:prune activity_log --hours=48')->daily();)
4) optionally you can publisj config file by command php artisan vendor:publish (just choose prune-table-config)

