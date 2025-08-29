<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pegawai;

class GuruProfileController extends Controller
{
    // Halaman dashboard/profile guru
    public function index()
    {
        // Cari Pegawai berdasarkan user_id
        $pegawai = Pegawai::with(['sks', 'sertifikats', 'guruDetail'])
            ->where('user_id', Auth::id())
            ->first();

        // Jika belum ada, cek Pegawai dengan email sama, lalu tautkan user_id
        if (!$pegawai) {
            $pegawai = Pegawai::where('email', Auth::user()->email)->first();
            if ($pegawai) {
                $pegawai->user_id = Auth::id();
                $pegawai->save();
            }
        }

        // Jika masih belum ada, arahkan ke create profile
        if (!$pegawai) {
            return redirect()->route('guru.profile.createprofile')
                ->with('info', 'Silakan lengkapi profile Anda terlebih dahulu.');
        }

        return view('guru.profile.indexprofile', compact('pegawai'));
    }

    // Form untuk membuat profile
    public function create()
    {
        return view('guru.profile.createprofile');
    }

    // Simpan data profile baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:pegawais,email',
            'nip' => 'nullable|string|unique:pegawais,nip',
            'jabatan' => 'nullable|string',
            'ttl' => 'nullable|string',
            'tahun_masuk' => 'required|numeric',
            'jenis_pegawai' => 'required|string|in:guru,staff',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'jumlah_kelas_mengajar' => 'nullable|numeric',
            'jumlah_hari_mengajar' => 'nullable|numeric',
            'wali_kelas' => 'nullable|boolean',
            'mata_pelajaran' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sk_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sertifikat_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Simpan data pegawai dasar + user_id
        $pegawai = Pegawai::create([
            'user_id' => Auth::id(), // penting supaya relasi Auth->Pegawai jalan
            'nama' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'ttl' => $request->ttl,
            'tahun_masuk' => $request->tahun_masuk,
            'jenis_pegawai' => $request->jenis_pegawai,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'senin' => $request->senin ?? 0,
            'selasa' => $request->selasa ?? 0,
            'rabu' => $request->rabu ?? 0,
            'kamis' => $request->kamis ?? 0,
            'jumat' => $request->jumat ?? 0,
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            $pegawai->foto = $request->file('foto')->store('pegawai/foto', 'public');
            $pegawai->save();
        }

        // Simpan data guru_detail jika jenis pegawai guru
        if ($request->jenis_pegawai === 'guru') {
            $pegawai->guruDetail()->create([
                'jumlah_kelas_mengajar' => $request->jumlah_kelas_mengajar,
                'jumlah_hari_mengajar' => $request->jumlah_hari_mengajar,
                'wali_kelas' => $request->wali_kelas ?? 0,
            ]);

            // Simpan mata pelajaran
            if ($request->mata_pelajaran) {
                $mataPelajarans = explode(',', $request->mata_pelajaran);
                foreach ($mataPelajarans as $mp) {
                    $pegawai->mapels()->create([
                        'mata_pelajaran' => trim($mp)
                    ]);
                }
            }
        }

        // Upload file SK
        if ($request->hasFile('sk_file')) {
            $pegawai->sks()->create([
                'nama_file' => $request->file('sk_file')->getClientOriginalName(),
                'path_file' => $request->file('sk_file')->store('pegawai/sk', 'public')
            ]);
        }

        // Upload file Sertifikat
        if ($request->hasFile('sertifikat_file')) {
            $pegawai->sertifikats()->create([
                'nama_sertifikat' => $request->file('sertifikat_file')->getClientOriginalName(),
                'path_file' => $request->file('sertifikat_file')->store('pegawai/sertifikat', 'public')
            ]);
        }

        // Setelah selesai, langsung redirect ke indexprofile
        return redirect()->route('guru.profile.index')
            ->with('success', 'Profile berhasil disimpan.');
    }
    // Form edit profile
public function edit()
{
    $pegawai = Auth::user()->pegawai;

    if (!$pegawai) {
        return redirect()->route('guru.profile.createprofile')
            ->with('error', 'Data pegawai belum tersedia.');
    }

    return view('guru.profile.editprofile', compact('pegawai'));
}

    
    // Update profile
public function update(Request $request)
{
    $pegawai = Auth::user()->pegawai;

    if (!$pegawai) {
        return redirect()->route('guru.profile.createprofile')
            ->with('error', 'Data pegawai belum tersedia.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:pegawais,email,' . $pegawai->id,
        'alamat' => 'nullable|string',
        'nip' => 'nullable|string|unique:pegawais,nip,' . $pegawai->id,
        'jabatan' => 'nullable|string',
        'ttl' => 'nullable|string',
        'tahun_masuk' => 'nullable|integer',
        'jenis_pegawai' => 'nullable|string',
        'no_hp' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update data pegawai
    $pegawai->update($validated);

    // Upload foto baru jika ada
    if ($request->hasFile('foto')) {
        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }
        $pegawai->foto = $request->file('foto')->store('pegawai/foto', 'public');
        $pegawai->save();
    }

    // Update guruDetail jika jenis pegawai guru
    if ($pegawai->jenis_pegawai === 'guru') {
        $guruDetail = $pegawai->guruDetail;
        if ($guruDetail) {
            $guruDetail->update([
                'jumlah_kelas_mengajar' => $request->jumlah_kelas_mengajar ?? $guruDetail->jumlah_kelas_mengajar,
                'jumlah_hari_mengajar' => $request->jumlah_hari_mengajar ?? $guruDetail->jumlah_hari_mengajar,
                'wali_kelas' => $request->wali_kelas ?? $guruDetail->wali_kelas,
            ]);
        }

        // Update mata pelajaran
        if ($request->mata_pelajaran) {
            // Hapus mata pelajaran lama
            $pegawai->mapels()->delete();
            $mataPelajarans = explode(',', $request->mata_pelajaran);
            foreach ($mataPelajarans as $mp) {
                $pegawai->mapels()->create([
                    'mata_pelajaran' => trim($mp)
                ]);
            }
        }
    }

    return redirect()->route('guru.profile.index')
        ->with('success', 'Profile berhasil diperbarui.');
}

}
