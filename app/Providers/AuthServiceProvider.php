<?php

namespace App\Providers;

use App\Models\Content\ContentArticle;
use App\Models\Content\ContentCategory;
use App\Models\Content\ContentComment;
use App\Models\Content\ContentPage;
use App\Models\Peta\PetaArea;
use App\Models\Peta\PetaGambar;
use App\Models\Peta\PetaGaris;
use App\Models\Peta\PetaKategori;
use App\Models\Peta\PetaSimbol;
use App\Models\Peta\PetaTitik;
use App\Models\Peta\PetaWarna;
use App\Models\Sid\Kelompok\SidKelompok;
use App\Models\Sid\Kelompok\SidKelompokKategori;
use App\Models\Sid\Pamong\SidPamong;
use App\Models\Sid\SidBantuan;
use App\Models\Sid\SidKeluarga;
use App\Models\Sid\SidPenduduk;
use App\Models\Sid\Surat\SidSurat;
use App\Models\Sid\Surat\SidSuratKeluar;
use App\Models\Sid\Wilayah\SidWilayahLingkungan;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Models\Sid\Wilayah\SidWilayahRukunWarga;
use App\Models\Team;
use App\Models\User;
use App\Policies\Content\ArticlePolicy;
use App\Policies\Content\CategoryPolicy;
use App\Policies\Content\CommentPolicy;
use App\Policies\Content\PagePolicy;
use App\Policies\Peta\AreaPolicy;
use App\Policies\Peta\GambarPolicy;
use App\Policies\Peta\GarisPolicy;
use App\Policies\Peta\KategoriPolicy as PetaKategoriPolicy;
use App\Policies\Peta\SimbolPolicy;
use App\Policies\Peta\TitikPolicy;
use App\Policies\Peta\WarnaPolicy;
use App\Policies\Sid\BantuanPolicy;
use App\Policies\Sid\Kelompok\KategoriPolicy;
use App\Policies\Sid\Kelompok\KelompokPolicy;
use App\Policies\Sid\KeluargaPolicy;
use App\Policies\Sid\PamongPolicy;
use App\Policies\Sid\PendudukPolicy;
use App\Policies\Sid\Surat\SuratKeluarPolicy;
use App\Policies\Sid\Surat\SuratPolicy;
use App\Policies\Sid\Wilayah\LingkunganPolicy;
use App\Policies\Sid\Wilayah\RukunTetanggaPolicy;
use App\Policies\Sid\Wilayah\RukunWargaPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Team::class => TeamPolicy::class,

        ContentArticle::class => ArticlePolicy::class,
        ContentCategory::class => CategoryPolicy::class,
        ContentComment::class => CommentPolicy::class,
        ContentPage::class => PagePolicy::class,

        SidBantuan::class => BantuanPolicy::class,
        SidKeluarga::class => KeluargaPolicy::class,
        SidPamong::class => PamongPolicy::class,
        SidPenduduk::class => PendudukPolicy::class,
        SidSurat::class => SuratPolicy::class,
        SidSuratKeluar::class => SuratKeluarPolicy::class,

        SidKelompokKategori::class => KategoriPolicy::class,
        SidKelompok::class => KelompokPolicy::class,

        SidWilayahLingkungan::class => LingkunganPolicy::class,
        SidWilayahRukunWarga::class => RukunWargaPolicy::class,
        SidWilayahRukunTetangga::class => RukunTetanggaPolicy::class,

        PetaArea::class => AreaPolicy::class,
        PetaGaris::class => GarisPolicy::class,
        PetaTitik::class => TitikPolicy::class,
        PetaSimbol::class => SimbolPolicy::class,
        PetaWarna::class => WarnaPolicy::class,
        PetaKategori::class => PetaKategoriPolicy::class,
        PetaGambar::class => GambarPolicy::class,
    ];

    /**
     * Register any authentication / userization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::after(fn (User $user) => $user->hasRole('super') ?: null);
    }
}
