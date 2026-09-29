<?php

namespace Tests\Feature;

use Tests\TestCase;

class AcademicPortalTest extends TestCase
{
    public function test_all_pages_render_with_shared_layout_and_correct_title(): void
    {
        foreach (['/' => 'Beranda', '/profil-mahasiswa' => 'Profil Mahasiswa', '/ide-agent' => 'Ide &amp; Riset'] as $url => $title) {
            $response = $this->get($url);
            $response->assertOk()->assertSee('Institut Teknologi Sepuluh Nopember')
                ->assertSee('<title>'.$title.' · Ruang Akademik</title>', false);
            $this->assertSame(1, substr_count($response->getContent(), '<html'));
            $this->assertSame(1, substr_count($response->getContent(), '<nav'));
        }
    }

    public function test_profile_displays_the_provided_identity(): void
    {
        $this->get('/profil-mahasiswa')->assertOk()->assertSee('Mochammad Irfan Sandy')
            ->assertSee('5025241127')->assertSee('Teknik Informatika');
    }

    public function test_dark_mode_is_rendered_server_side_and_preserved_in_form_action(): void
    {
        $this->get('/ide-agent?mode=dark')->assertOk()
            ->assertSee('<html lang="id" class="dark">', false)
            ->assertSee('bg-slate-950 text-slate-100')
            ->assertSee('action="http://localhost/ide-agent?mode=dark"', false);
        $this->get('/ide-agent?mode=other')->assertOk()->assertSee('bg-stone-50 text-slate-900');
    }

    public function test_welcome_name_is_dynamic_and_html_is_escaped(): void
    {
        $this->get('/beranda?user=Andi')->assertOk()->assertSee('Selamat datang, Andi');
        $this->get('/beranda?user='.urlencode('<script>alert(1)</script>'))
            ->assertOk()->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
        $this->get('/beranda?user[]=Andi')->assertOk();
    }

    public function test_valid_idea_is_saved_in_session_and_dark_mode_survives_redirect(): void
    {
        $payload = ['name' => 'Andi', 'title' => 'Pengujian regresi otomatis', 'category' => 'Quality Assurance',
            'description' => 'Agen menjalankan pengujian regresi setelah patch kode diterapkan.'];
        $this->post('/ide-agent?mode=dark', $payload)->assertRedirect('/ide-agent?mode=dark#form-ide')
            ->assertSessionHas('status')->assertSessionHas('ideas.0.title', $payload['title']);
        $this->get('/ide-agent?mode=dark')->assertOk()->assertSee($payload['title'])->assertSee($payload['description']);
        $this->get('/ide-agent?mode=dark')->assertSee($payload['title'])->assertDontSee('Ide berhasil dikirim.');
    }

    public function test_invalid_idea_returns_errors_preserves_input_and_does_not_store(): void
    {
        $this->from('/ide-agent?mode=dark')->post('/ide-agent?mode=dark', [
            'name' => 'Andi', 'title' => 'abc', 'category' => 'Invalid', 'description' => 'pendek',
        ])->assertRedirect('/ide-agent?mode=dark')
            ->assertSessionHasErrors(['title', 'category', 'description'])
            ->assertSessionHasInput('name', 'Andi')->assertSessionMissing('ideas');
        $this->get('/ide-agent?mode=dark')->assertSee('Periksa kembali idemu')->assertSee('Judul ide minimal 5 karakter.');
    }

    public function test_empty_form_is_rejected_and_payloads_are_escaped_when_displayed(): void
    {
        $this->post('/ide-agent', [])->assertSessionHasErrors(['name', 'title', 'category', 'description']);
        $this->post('/ide-agent', ['name' => '<b>Andi</b>', 'title' => '<script>alert(1)</script>',
            'category' => 'Security Testing', 'description' => 'Periksa keamanan input dan output pada aplikasi.']);
        $this->get('/ide-agent')->assertOk()->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)->assertSee('&lt;b&gt;Andi&lt;/b&gt;', false);
    }

    public function test_session_history_is_limited_to_twenty_recent_ideas(): void
    {
        $idea = ['name' => 'Andi', 'title' => 'Ide pengujian', 'category' => 'Quality Assurance',
            'description' => 'Deskripsi ide yang cukup panjang untuk pengujian.', 'submitted_at' => '29 Sep 2026, 08:00'];
        $this->withSession(['ideas' => array_fill(0, 20, $idea)])
            ->post('/ide-agent', array_merge($idea, ['title' => 'Ide paling baru']))->assertRedirect();
        $this->assertCount(20, session('ideas'));
        $this->assertSame('Ide paling baru', session('ideas.0.title'));
    }
}
