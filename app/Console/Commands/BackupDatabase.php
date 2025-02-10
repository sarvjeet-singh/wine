<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    protected $signature = 'database:backup';
    protected $description = 'Backup the database and store it in storage/backups';

    public function handle()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $backupPath = storage_path('backups');
        
        // Ensure the backup directory exists
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $fileName = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        $filePath = $backupPath . '/' . $fileName;

        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$filePath}";

        $result = system($command);

        if ($result === false) {
            $this->error('Database backup failed.');
        } else {
            $this->info('Database backup completed successfully: ' . $filePath);
        }
    }
}