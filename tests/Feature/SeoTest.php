<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_have_seo_tags(): void
    {
        foreach (['home', 'gallery', 'skm', 'pengaduan.create', 'news.index'] as $name) {
            $this->get(route($name))
                ->assertOk()
                ->assertSee('<meta name="description"', false)
                ->assertSee('<link rel="canonical"', false)
                ->assertSee('property="og:image"', false)
                ->assertSee('name="twitter:card"', false)
                ->assertSee('rel="icon"', false)
                ->assertDontSee('noindex');
        }
    }

    public function test_news_detail_uses_news_content_for_seo(): void
    {
        $news = News::create([
            'judul' => 'Penataan Parkir Tepi Jalan',
            'slug' => 'penataan-parkir-tepi-jalan',
            'kategori' => 'Kegiatan',
            'ringkasan' => 'Ringkasan penataan parkir.',
            'konten' => 'Isi berita penataan parkir.',
            'gambar' => 'news/penataan.jpg',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->get(route('news.show', $news))
            ->assertOk()
            ->assertSee('<title>Penataan Parkir Tepi Jalan | SAPA JUKIR Kabupaten Sinjai</title>', false)
            ->assertSee('content="Ringkasan penataan parkir."', false)
            ->assertSee('property="og:image" content="'.asset('storage/news/penataan.jpg').'"', false)
            ->assertSee('property="og:type" content="article"', false);
    }

    public function test_canonical_follows_app_url(): void
    {
        config(['app.url' => 'https://dishub.sinjaikab.go.id/sapajukir']);

        $this->get(route('gallery'))
            ->assertSee('<link rel="canonical" href="https://dishub.sinjaikab.go.id/sapajukir/gallery">', false);
    }

    public function test_login_and_admin_pages_are_noindex(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false)
            ->assertDontSee('<link rel="canonical"', false);

        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);
    }

    public function test_home_title_does_not_repeat_brand_name(): void
    {
        \App\Models\SiteSetting::create(['hero_title' => 'Selamat Datang di SAPA JUKIR']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<title>Selamat Datang di SAPA JUKIR</title>', false);
    }
}
