<?php

namespace App\Console\Commands;

use App\Models\JenisJabatan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateJabatanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jabatan:create {--jabatan=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat jabatan baru (ex. superadmin, sales, billing, dll)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jabatan = $this->option('jabatan');
        $check = DB::table('jenis_jabatan')->select(DB::raw('MAX(RIGHT(id_jenis_jabatan, 3)) AS kode'));
        if ($check->count() > 0) {
            foreach ($check->get() as $c) {
                $temp = ((int) $c->kode) + 1;
                $code = sprintf("%'.03d", $temp);
            }
        } else {
            $code = "001";
        }
        JenisJabatan::create([
            'id_jenis_jabatan' => 'JJ' . $code,
            'nama_jabatan' => $jabatan,
            'status' => 'a'
        ]);
        $this->info('Berhasil membuat jabatan ' . $jabatan . '.');
    }
}
