<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use function storage_path;

class BackUpDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will backup the database';

    /**
     * @var Process
     */
    protected $process;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $date = now()->format('Y-m-d-hh_mm-ss');
        $this->process = Process::fromShellCommandline('pg_dump -U postgres -h 127.0.0.1 "laravel-sgpe" > storage/app/backups/backup_'.$date.'.sql');
        //$directories = Storage::allFiles('app/backups');
        //foreach($directories as $dir){
        //foreach ($archivos_del_mes as $archivo_del_mes) {
            //$temp_array = explode('/', $archivo_del_mes);
            //// obtienes el último elemento (el nombre del archivo).
            //$filename = end( $temp_array );
            //// obtienes la url que corresponde a ese archivo.
            //$url = Storage::url($archivo_del_mes);
            //// guardas en tu array el nombre y la url del archivo, 
            //// haciendo que el array sea multidimensional por año y mes.
            ////$tree_array[$year][$month][] = [
                ////'filename' => $filename,
                ////'url' => $url
            ////];
        //}
    //}
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //$directories = Storage::allFiles('app/backups');
        //foreach($directories as $dir){
          //$this->info( $dir );
        //foreach ($dir as $archivo_del_mes) {
            //$temp_array = explode('/', $archivo_del_mes);
            //// obtienes el último elemento (el nombre del archivo).
            //$filename = end( $temp_array );
            //$this->info($filename);
            //// obtienes la url que corresponde a ese archivo.
            //$url = Storage::url($archivo_del_mes);
            //$this->info($url);
            //// guardas en tu array el nombre y la url del archivo, 
            //// haciendo que el array sea multidimensional por año y mes.
            ////$tree_array[$year][$month][] = [
                ////'filename' => $filename,
                ////'url' => $url
            ////];
        //}}
        try {
            $this->info('The backup has been started');
            $this->process->mustRun();
            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $exception) {
            logger()->error('Backup exception', compact('exception'));
            $this->error('The backup process has been failed.');
        }
    }
}
