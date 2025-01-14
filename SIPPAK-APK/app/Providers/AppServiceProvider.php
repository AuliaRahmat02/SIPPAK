<?php

namespace App\Providers;

// use App\Models\kontrolModel;
use Carbon\Carbon;
use App\Models\users;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Carbon::setLocale('id');
        //memmbuat gate untuk menentukan hanya admin yang boleh mengakses bagian tertentu seperti middleware
        Gate::define('admin', function(users $user){
            return $user->biro === "Admin";
        });

        // gate untuk memfilter JFT atau bukan
        Gate::define('jft', function(users $user){
            return ($user->jft === 1) AND ($user->biro === "Biro Administrasi Pimpinan");
        });


        // gate untuk memfilter kabiro atau bukan
        Gate::define('kabiro', function(users $user){
            return ($user->kabiro === 1) AND ($user->kabag === 0) AND ($user->biro === "Biro Administrasi Pimpinan");
        });
        // gate untuk memfilter kabag atau bukan
        Gate::define('kabag', function(users $user){
            return ($user->kabag === 1) AND ($user->biro === "Biro Administrasi Pimpinan") AND ($user->kabiro === 0);
        });

        // gate untuk memfilter operator atau bukan
        Gate::define('operator', function(users $user){
            return ($user->biro === "Biro Administrasi Pimpinan")AND ($user->opadpim === 1);
        });

        // gate untuk memfilter operator TU atau bukan
        Gate::define('opAdpim', function(users $user){
            return ($user->biro === "Biro Administrasi Pimpinan")AND ($user->kabag == 0) AND ($user->kabiro == 0) AND ($user->jft == 0)AND ($user->opadpim == 0);
        });

        // gate untuk memfilter operator atau bukan
        Gate::define('opAdpem', function(users $user){
            return ($user->biro === "Biro Administrasi Pembangunan");
        });
        // gate untuk memfilter operator atau bukan
        Gate::define('opPemerintahan', function(users $user){
            return ($user->biro === 'Biro Pemerintahan dan Otonomi Daerah');
        });
        // gate untuk memfilter operator atau bukan
        Gate::define('opHukum', function(users $user){
            return ($user->biro === 'Biro Hukum');
        });
        // gate untuk memfilter operator atau bukan
        Gate::define('opKesra', function(users $user){
            return ($user->biro === 'Biro Kesejahteraan Rakyat');
        });
        // gate untuk memfilter operator atau bukan
        Gate::define('opPerekonomian', function(users $user){
            return ($user->biro === 'Biro Perekonomian');
        });
        // gate untuk memfilter operator atau bukan
        Gate::define('opPBJ', function(users $user){
            return ($user->biro === 'Biro Pengadaan Barang dan Jasa');
        });
        // gate untuk memfilter operator atau bukan
        Gate::define('opOrganisasi', function(users $user){
            return ($user->biro === 'Biro Organisasi');
        });
        // gate untuk memfilter operator atau bukan
        Gate::define('opUmum', function(users $user){
            return ($user->biro === 'Biro Umum');
        });
    }
}
