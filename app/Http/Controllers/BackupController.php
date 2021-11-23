<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Backup\Tasks\Backup\Zip as SpatieZip;
use Symfony\Component\Process\Process;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $path = 'Laravel-sgpe';
        $directories = Storage::files($path);
        $res = [];
        
        foreach(Storage::files($path) as $file){
            $res[] = [
                "name" => File::basename($file),
                "date" => Storage::lastModified($file)
            ];
        }

        return response()->json($res);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $file
     * @return \Illuminate\Http\Response
     */
    public function restore($file)
    {
        //
        exec('php artisan migrate:fresh');

        $zip = new ZipArchive;
        $res = $zip->open(storage_path( '/app/Laravel-sgpe/' ).$file);
    
        Log::info("\Descompress -- Descompress file: ".$file." \r\n");

        $zip->extractTo(storage_path( '/app/Laravel-sgpe/' ));
        $zip->close();

        $path = storage_path('/app/Laravel-sgpe/db-dumps/postgresql-laravel-sgpe.sql');
        //Artisan::call('db:restore --path=storage/app/Laravel-sgpe/db-dumps/postgresql-laravel-sgpe.sql');
    Artisan::call('migrate:fresh');
    exec(sprintf(
      'psql -U %s -h %s %s < %s',
      env('DB_USERNAME'),
      env('DB_HOST'),
      env('DB_DATABASE'),
      $path
    ));
    Log::info("\Restore -- new restore started from admin interface \r\n");

        //Storage::deleteDirectory('Laravel-sgpe/db-dumps');
        Log::info("\Delete -- Delete folder and file with backup \r\n");
        $msg = "Restauración completa";
    
        //return response()->json([ "message" => $msg ]);
        return response()->json([ "message" => $msg, "file" => $file ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
          // start the backup process
          \Illuminate\Support\Facades\Artisan::call('backup:run');
          $output = \Illuminate\Support\Facades\Artisan::output();
          // log the results
          Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
          // return the results as a response to the ajax call
          return response()->json([
            "message" => 'Backup Created Successfully!',
            "alertType" => 'alert-success'
          ]);
        } catch (Exception $e) {
          Log::info("Backpack\BackupManager -- error create new backup \r\n" . $e);
          return response()->json([
            "message" => 'Backup Failed, Try again',
            "alertType" => 'alert-warning'
          ]);
        }
    }  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
