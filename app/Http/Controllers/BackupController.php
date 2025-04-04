<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Storage::disk('public')->files('backups');
        return view('backup.index', compact('backups'));
    }

    public function create()
    {
        $dbhost = "localhost"; 
        $dbuser = "root"; 
        $dbpass = ""; 
        $dbname = "lavarellogin"; 

        $mysqldump = "C:\\xampp\\mysql\\bin\\mysqldump.exe"; 

        $backupDir = storage_path('app/public/backups');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0777, true);
        }

        $backupFile = $backupDir . "/backup_" . Carbon::now()->format('Y-m-d_H-i-s') . ".sql";

        $command = "\"$mysqldump\" --host=$dbhost --user=$dbuser --password=$dbpass --routines --no-tablespaces --databases $dbname --result-file=\"$backupFile\"";

        exec($command, $output, $result);

        if ($result === 0 && filesize($backupFile) > 0) {
            return redirect()->route('backup.index')->with('info', 'Copia de seguridad creada correctamente.');
        } else {
            unlink($backupFile);
            return redirect()->route('backup.index')->with('info', 'Error al crear la copia de seguridad.');
        }
        
    }

    public function restore(Request $request)
    {
        $dbhost = "localhost"; 
        $dbuser = "root"; 
        $dbpass = ""; 
        $dbname = "lavarellogin"; 

        $backupFile = storage_path('app/public/backups/' . $request->backup_file);

        if (!file_exists($backupFile) || filesize($backupFile) == 0) {
            return redirect()->back()->with('error', '❌ El archivo de respaldo no es válido.');
        }

        $mysql = "C:\\xampp\\mysql\\bin\\mysql.exe";
        $command = "\"$mysql\" --host=$dbhost --user=$dbuser --password=$dbpass $dbname < \"$backupFile\"";

        exec($command, $output, $result);

        if ($result === 0) {
            return redirect()->route('backup.index')->with('info', 'Base de datos restaurada correctamente.');
        } else {
            return redirect()->route('backup.index')->with('info', 'Error al restaurar la base de datos.');
        }
    }

    public function destroy(Request $request)
    {
        $backupFile = 'backups/' . $request->backup_file;

        if (Storage::disk('public')->exists($backupFile)) {
            Storage::disk('public')->delete($backupFile);
            return redirect()->route('backup.index')->with('info', 'Punto de restauración eliminado correctamente.');
        } else {
            return redirect()->route('backup.index')->with('info', 'El archivo de respaldo no existe.');
        }
    }
    
}

