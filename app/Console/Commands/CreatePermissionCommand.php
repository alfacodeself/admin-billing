<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreatePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create {--permission=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat permission baru (ex. tambah produk, edit produk, dll)';

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
        $check = DB::table('permission')->select(DB::raw('MAX(RIGHT(id_permission, 3)) AS kode'));
        if ($check->count() > 0) {
            foreach ($check->get() as $c) {
                $temp = ((int) $c->kode) + 1;
                $code = sprintf("%'.03d", $temp);
            }
        } else {
            $code = "001";
        }
        $nama = $this->option('permission');
        Permission::create([
            'id_permission' => 'PERM' . $code,
            'nama_permission' => $nama,
            'status' => 'a'
        ]);
        $this->info('Berhasil membuat permission ' . $nama . '.');
    }
}
