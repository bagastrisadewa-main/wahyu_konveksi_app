<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $backupPath = storage_path('app/database-backups');

        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $backups = collect(glob($backupPath . '/*.sql'))
            ->sortByDesc(fn ($f) => filemtime($f))
            ->map(fn ($f) => 'database-backups/' . basename($f));

        return view('pages.database.index', compact('backups'));
    }

    /*
    |--------------------------------------------------------------------------
    | BACKUP
    |--------------------------------------------------------------------------
    */
    public function backup()
    {
        try {
            $backupDir = storage_path('app/database-backups');

            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $filename   = 'backup_' . now()->format('Ymd_His') . '.sql';
            $backupFile = $backupDir . '/' . $filename;

            $host = env('DB_HOST');
            $port = env('DB_PORT');
            $db   = env('DB_DATABASE');
            $user = env('DB_USERNAME');
            $pass = env('DB_PASSWORD');

            $command = sprintf(
                'MYSQL_PWD="%s" mysqldump -h %s -P %s -u %s --skip-ssl --no-tablespaces %s > %s 2>> %s',
                $pass,
                $host,
                $port,
                $user,
                $db,
                escapeshellarg($backupFile),
                storage_path('logs/backup.log')
            );

            exec($command, $output, $status);

            if ($status !== 0 || !file_exists($backupFile) || filesize($backupFile) === 0) {
                Log::error('DB BACKUP FAILED', [
                    'status' => $status,
                    'output' => $output
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Backup gagal. Cek log.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Backup berhasil dibuat'
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RESTORE
    |--------------------------------------------------------------------------
    */

public function restore(Request $request)
{
    try {

        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $db   = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');

        /*
        |--------------------------------------------------------------------------
        | MODE 1: RESTORE DARI FILE UPLOAD
        |--------------------------------------------------------------------------
        */
                if ($request->hasFile('backup_upload')) {

                    $request->validate([
                        'backup_upload' => 'required|file|max:20480'
                    ]);

                    $file = $request->file('backup_upload');

                    // DEBUG INFO (kalau masih error nanti kelihatan penyebabnya)
                    \Log::info('UPLOAD DEBUG', [
                        'original_name' => $file->getClientOriginalName(),
                        'extension'     => $file->getClientOriginalExtension(),
                        'mime'          => $file->getMimeType(),
                        'size'          => $file->getSize(),
                    ]);

                    if (strtolower($file->getClientOriginalExtension()) !== 'sql') {
                        return response()->json([
                            'success' => false,
                            'message' => 'File harus berekstensi .sql | Terbaca: ' 
                                        . $file->getClientOriginalExtension()
                                        . ' | Mime: ' . $file->getMimeType()
                        ], 422);
                    }

                    $filename = 'upload_restore_' . now()->format('Ymd_His') . '.sql';

                    $path = storage_path('app/database-backups');

                    if (!is_dir($path)) {
                        mkdir($path, 0755, true);
                    }

                    $file->move($path, $filename);

                    $filePath = $path . '/' . $filename;
                }

        /*
        |--------------------------------------------------------------------------
        | MODE 2: RESTORE DARI LIST BACKUP
        |--------------------------------------------------------------------------
        */
        elseif ($request->backup_file) {

            $filePath = storage_path('app/' . $request->backup_file);

            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan'
                ], 404);
            }
        }

        else {
            return response()->json([
                'success' => false,
                'message' => 'File backup tidak valid'
            ], 400);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $command = sprintf(
            'MYSQL_PWD="%s" mysql -h %s -P %s -u %s --skip-ssl %s < %s 2>&1',
            $pass,
            $host,
            $port,
            $user,
            $db,
            escapeshellarg($filePath)
        );

        exec($command, $output, $status);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        if ($status !== 0) {
            return response()->json([
                'success' => false,
                'message' => implode("\n", $output)
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Database berhasil direstore'
        ]);

    } catch (\Throwable $e) {

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
    // public function restore(Request $request)
    // {
    //     $request->validate([
    //         'backup_file' => 'required|string'
    //     ]);

    //     $filePath = storage_path('app/' . $request->backup_file);

    //     if (!file_exists($filePath)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'File tidak ditemukan'
    //         ]);
    //     }

    //     try {

    //         $host = env('DB_HOST');
    //         $port = env('DB_PORT');
    //         $db   = env('DB_DATABASE');
    //         $user = env('DB_USERNAME');
    //         $pass = env('DB_PASSWORD');

    //         DB::statement('SET FOREIGN_KEY_CHECKS=0');

    //         $command = sprintf(
    //             'MYSQL_PWD="%s" mysql -h %s -P %s -u %s --skip-ssl %s < %s',
    //             $pass,
    //             $host,
    //             $port,
    //             $user,
    //             $db,
    //             escapeshellarg($filePath)
    //         );

    //         exec($command, $output, $status);

    //         DB::statement('SET FOREIGN_KEY_CHECKS=1');

    //         if ($status !== 0) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Restore gagal'
    //             ]);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Database berhasil direstore'
    //         ]);
    //     } catch (\Throwable $e) {

    //         DB::statement('SET FOREIGN_KEY_CHECKS=1');

    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD
    |--------------------------------------------------------------------------
    */
    public function download($file)
    {
        $file = basename($file);

        $path = storage_path('app/database-backups/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }

    /*
    |--------------------------------------------------------------------------
    | RESET DATABASE (PASSWORD MANUAL)
    |--------------------------------------------------------------------------
    */
    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        // PASSWORD YANG KAMU TENTUKAN
        if ($request->password !== 'Yayan1234!@#$') {
            return response()->json([
                'success' => false,
                'message' => 'Password salah!'
            ], 403);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // =========================
        // TABEL WHS KONVEKSI
        // =========================
        DB::table('about_us')->truncate();
        DB::table('activity_logs')->truncate();
        DB::table('articles')->truncate();
        DB::table('article_images')->truncate();
        DB::table('categories')->truncate();
        DB::table('comments')->truncate();
        DB::table('customers')->truncate();
        DB::table('galleries')->truncate();
        DB::table('orders')->truncate();
        DB::table('order_items')->truncate();
        DB::table('order_item_options')->truncate();
        DB::table('order_item_processes')->truncate();
        // DB::table('order_statuses')->truncate();
        DB::table('products')->truncate();
        DB::table('product_options')->truncate();
        DB::table('product_option_values')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return response()->json([
            'success' => true,
            'message' => 'Database WHS Konveksi berhasil direset'
        ]);
    }
}