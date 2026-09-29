<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    private function pageData(Request $request): array
    {
        return [
            'profile' => config('academic'),
            'isDark' => $request->query('mode') === 'dark',
            'themeQuery' => $request->query('mode') === 'dark' ? ['mode' => 'dark'] : [],
        ];
    }

    public function home(Request $request): View
    {
        $user = $request->query('user');

        return view('pages.home', $this->pageData($request) + [
            'visitor' => is_string($user) ? mb_substr(trim($user), 0, 80) : '',
        ]);
    }

    public function profile(Request $request): View
    {
        return view('pages.profile', $this->pageData($request));
    }

    public function ideas(Request $request): View
    {
        return view('pages.ideas', $this->pageData($request) + [
            'ideas' => $request->session()->get('ideas', []),
            'categories' => ['Quality Assurance', 'Security Testing', 'Automated Repair', 'Ide Lainnya'],
        ]);
    }

    public function storeIdea(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'min:5', 'max:120'],
            'category' => ['required', 'in:Quality Assurance,Security Testing,Automated Repair,Ide Lainnya'],
            'description' => ['required', 'string', 'min:20', 'max:2000'],
        ], [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'in' => 'Pilih kategori yang tersedia.',
        ], [
            'name' => 'Nama', 'title' => 'Judul ide', 'category' => 'Kategori', 'description' => 'Deskripsi ide',
        ]);

        // Demo pertemuan 4 menggunakan sesi, tanpa database.
        $ideas = $request->session()->get('ideas', []);
        array_unshift($ideas, $validated + ['submitted_at' => now()->format('d M Y, H:i')]);
        $request->session()->put('ideas', array_slice($ideas, 0, 20));

        return to_route('ideas', $request->query('mode') === 'dark' ? ['mode' => 'dark'] : [])
            ->withFragment('form-ide')
            ->with('status', 'Ide berhasil dikirim. Terima kasih sudah ikut mengembangkan riset ini!');
    }
}
