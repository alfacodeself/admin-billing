<?php

namespace App\Providers;

use App\Models\Petugas;
use Illuminate\Auth\Access\AuthorizationException;
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

        $permissions = DB::table('permission')->select('nama_permission')->where('status', 'a')->get();
        foreach ($permissions as $permission) {
            Gate::define($permission->nama_permission, function(Petugas $petugas) use ($permission){
                if ($petugas->isAdmin()) {
                    return true;
                }else {
                    if ($petugas->hasAccess($permission->nama_permission)) {
                        return true;
                    }else {
                        throw new AuthorizationException('Maaf! anda tidak memiliki akses untuk ' . $permission->nama_permission);
                    }
                }
            });
        }
    }
}
