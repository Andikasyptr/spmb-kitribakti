<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfileAdmin;


class AdminTampilanController extends Controller
{
    // index
    public function index()
    {
    /** @var \App\Models\User $user */
        $user = Auth::user();
        // Ambil profil berdasarkan user yang sedang login
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
    return redirect()->route('admin.tampilan.edit', compact('profile'));
    }
    // Menampilkan form edit dengan data setting yang ada
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Ambil profil berdasarkan user yang sedang login
        $profile = ProfileAdmin::where('user_id', Auth::id())->first();
        // Ambil data setting dari database atau config
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.tampilan.edit', compact('settings','profile'));
    }

    // Menyimpan perubahan setting
 public function update(Request $request)
{
    $validated = $request->validate([
    'hero_title' => 'nullable|string|max:255',
    'hero_description' => 'nullable|string',
    'about_title' => 'nullable|string',
    'about_description' => 'nullable|string',
    'title_program1' => 'nullable|string',
    'des_program1' => 'nullable|string',
    'title_program2' => 'nullable|string',
    'des_program2' => 'nullable|string',
    'title_program3' => 'nullable|string|max:255',
    'des_program3' => 'nullable|string|max:255',
    'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'program_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'team_title' => 'nullable|string|max:255',
    'team_description' => 'nullable|string',
    'team_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'team_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'team_image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'team_image4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'team_image5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'team_image6' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'team_image7' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'team_nama1'=> 'nullable|string|max:255',
    'team_nama2'=> 'nullable|string|max:255',
    'team_nama3'=> 'nullable|string|max:255',
    'team_nama4'=> 'nullable|string|max:255',
    'team_nama5'=> 'nullable|string|max:255',
    'team_nama6'=> 'nullable|string|max:255',
    'team_nama7'=> 'nullable|string|max:255',
    'des_image1' => 'nullable|string|max:255',
    'des_image2' => 'nullable|string|max:255',
    'des_image3' => 'nullable|string|max:255',
    'des_image4' => 'nullable|string|max:255',
    'des_image5' => 'nullable|string|max:255',
    'des_image6' => 'nullable|string|max:255',
    'des_image7' => 'nullable|string|max:255',
    'title_harga'=> 'nullable|string|max:255',
    'des_harga'=>'nullable|string|max:255',
    'nama_kelas1'=> 'nullable|string|max:255',
    'des_kelas1'=>'nullable|string|max:500',
    'nama_kelas2'=> 'nullable|string|max:255',
    'des_kelas2'=>'nullable|string|max:500',
    'harga_member'=> 'nullable|string|max:255',
    'ben_member1'=>'nullable|string|max:255',
    'ben_member2'=> 'nullable|string|max:255',
    'ben_member3'=> 'nullable|string|max:255',
    'ben_member4'=> 'nullable|string|max:255',
    'ben_member5'=> 'nullable|string|max:255',
    'harga_kunjungan'=>'nullable|string|max:255',
    'ben_kunjungan1'=>'nullable|string|max:255',
    'ben_kunjungan2'=> 'nullable|string|max:255',
    'ben_kunjungan3'=> 'nullable|string|max:255',
    'ben_kunjungan4'=> 'nullable|string|max:255',
    'ben_kunjungan5'=> 'nullable|string|max:255',
    'question1'=> 'nullable|string',
    'answer1'=> 'nullable|string',
    'question2'=> 'nullable|string',
    'answer2'=> 'nullable|string',
    'question3'=> 'nullable|string',
    'answer3'=> 'nullable|string',
    'question4'=> 'nullable|string',
    'answer4'=> 'nullable|string',
    'question5'=> 'nullable|string',
    'answer5'=> 'nullable|string',
    'title_jadwal'=> 'nullable|string',
    'des_jadwal'=> 'nullable|string',
    'jadwal1'=> 'nullable|string',
    'jadwal2'=> 'nullable|string',
    'des_jadwal1'=> 'nullable|string',
    'des_jadwal2'=> 'nullable|string',
    

    
]);

    // Simpan text setting
    $textKeys = [
        'hero_title', 'hero_description', 'about_title', 'about_description',
        'title_program1', 'des_program1', 'title_program2', 'des_program2',
        'title_program3', 'des_program3', 'team_title', 'team_description',
        'team_nama1', 'team_nama2', 'team_nama3', 'team_nama4', 'team_nama5', 'team_nama6', 'team_nama7',
        'des_image1', 'des_image2', 'des_image3', 'des_image4', 'des_image5', 'des_image6', 'des_image7',
        'title_harga','des_harga', 'nama_kelas1', 'des_kelas1', 'nama_kelas2', 'des_kelas2',
        'harga_member', 'ben_member1', 'ben_member2', 'ben_member3', 'ben_member4', 'ben_member5',
        'harga_kunjungan', 'ben_kunjungan1', 'ben_kunjungan2', 'ben_kunjungan3', 'ben_kunjungan4', 'ben_kunjungan5',
        'question1','question2','question3','question4','question5','answer1','answer2','answer3','answer4','answer5',
        'title_jadwal','des_jadwal', 'jadwal1','jadwal2','des_jadwal1','des_jadwal2'
    ];

    foreach ($textKeys as $key) {
    Setting::updateOrCreate(
        ['key' => $key],
        ['value' => $validated[$key] ?? null]
    );
}


    // Fungsi bantu upload gambar agar DRY (Don't Repeat Yourself)
    $uploadAndSave = function($fileInputName, $prefix) use ($request) {
        if ($request->hasFile($fileInputName)) {
            $file = $request->file($fileInputName);
            $filename = time() . '_' . $prefix . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

            Setting::updateOrCreate(
                ['key' => $fileInputName],
                ['value' => 'uploads/' . $filename]
            );
        }
    };

    // Upload gambar utama
    $uploadAndSave('hero_image', 'hero');
    $uploadAndSave('program_image', 'program');

    // Upload gambar team dalam loop agar lebih rapi
    for ($i = 1; $i <= 7; $i++) {
        $uploadAndSave('team_image' . $i, 'team' . $i);
    }

    return redirect()->route('admin.tampilan.edit')->with('success', 'Pengaturan berhasil diperbarui');
}


}
