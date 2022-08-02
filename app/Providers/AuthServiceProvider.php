<?php

namespace App\Providers;

use App\Models\Petugas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function($petugas, $ability){
            return $petugas->isAdmin();
        });
        $permissions = DB::table('permission')->select('nama_permission')->where('status', 'a')->get();
        foreach ($permissions as $permission) {
            Gate::define($permission->nama_permission, function(Petugas $petugas) use ($permission){
                return $petugas->hasAccess($permission->nama_permission);
            });
        }
    }
}
