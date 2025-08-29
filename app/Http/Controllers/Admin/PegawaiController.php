<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\PegawaiSk;
use App\Models\PegawaiSertifikat;
use App\Models\GuruDetail;
use App\Models\GuruMapel;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::latest()->get();
        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function show($id)
    {
        $pegawai = Pegawai::with(['sks', 'sertifikats', 'guruDetail', 'mapels'])->findOrFail($id);
        return view('admin.pegawai.show', compact('pegawai'));
    }

    public function edit($id)
    {
        $pegawai = Pegawai::with(['guruDetail', 'mapels', 'sks', 'sertifikats'])->findOrFail($id);
        return view('admin.pegawai.edit', compact('pegawai'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'jumlah_jam' => 'required_if:jenis_pegawai,guru|numeric|min:0',
        'senin' => 'nullable|numeric|min:0',
        'selasa' => 'nullable|numeric|min:0',
        'rabu' => 'nullable|numeric|min:0',
        'kamis' => 'nullable|numeric|min:0',
        'jumat' => 'nullable|numeric|min:0',
        'sks.*' => 'nullable|file|mimes:pdf|max:2048',
        'sertifikats.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $pegawai = Pegawai::findOrFail($id);

    // Update data pegawai
    $pegawai->update([
        'nama' => $request->nama,
        'email' => $request->email,
        'nip' => $request->nip,
        'jabatan' => $request->jabatan,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
        'ttl' => $request->ttl,
        'tahun_masuk' => $request->tahun_masuk,
        'jenis_pegawai' => $request->jenis_pegawai,
        'senin' => $request->senin ?? 0,
        'selasa' => $request->selasa ?? 0,
        'rabu' => $request->rabu ?? 0,
        'kamis' => $request->kamis ?? 0,
        'jumat' => $request->jumat ?? 0,
    ]);

    // Update foto jika ada
    if ($request->hasFile('foto')) {
        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $fotoPath = $request->file('foto')->store('pegawai/foto', 'public');
        $pegawai->foto = $fotoPath;
        $pegawai->save();
    }

    // Update data khusus guru
    if ($request->jenis_pegawai === 'guru') {
        $pegawai->guruDetail()->updateOrCreate(
            ['pegawai_id' => $pegawai->id],
            [
                'jumlah_kelas_mengajar' => $request->jumlah_kelas_mengajar,
                'jumlah_hari_mengajar' => $request->jumlah_hari_mengajar,
                'jumlah_jam' => $request->jumlah_jam,
                'wali_kelas' => $request->wali_kelas ? 1 : 0,
            ]
        );

        $pegawai->mapels()->delete();
        if ($request->mata_pelajaran) {
            foreach ($request->mata_pelajaran as $mapel) {
                $pegawai->mapels()->create(['mata_pelajaran' => $mapel]);
            }
        }
    }

    // Tambah file SK baru
    if ($request->hasFile('sks')) {
        foreach ($request->file('sks') as $file) {
            $path = $file->store('sks', 'public');
            PegawaiSk::create([
                'pegawai_id' => $pegawai->id,
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
            ]);
        }
    }

    // Tambah file Sertifikat baru
    if ($request->hasFile('sertifikats')) {
        foreach ($request->file('sertifikats') as $file) {
            $path = $file->store('sertifikats', 'public');
            PegawaiSertifikat::create([
                'pegawai_id' => $pegawai->id,
                'nama_sertifikat' => $file->getClientOriginalName(),
                'path_file' => $path,
            ]);
        }
    }

    return redirect()->route('pegawai.show', $pegawai->id)->with('success', 'Data pegawai berhasil diperbarui.');
}


    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();
        return back()->with('success', 'Pegawai berhasil dihapus.');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:pegawais',
            'jenis_pegawai' => 'required|in:guru,tenaga_kependidikan',
            'jumlah_jam' => 'nullable|numeric|min:0',
            'senin' => 'nullable|numeric|min:0',
            'selasa' => 'nullable|numeric|min:0',
            'rabu' => 'nullable|numeric|min:0',
            'kamis' => 'nullable|numeric|min:0',
            'jumat' => 'nullable|numeric|min:0',
            'sks.*' => 'nullable|file|mimes:pdf|max:2048',
            'sertifikats.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pegawai/foto', 'public');
        }

        // Simpan pegawai
        $pegawai = Pegawai::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'ttl' => $request->ttl,
            'tahun_masuk' => $request->tahun_masuk,
            'jenis_pegawai' => $request->jenis_pegawai,
            'foto' => $fotoPath,
            'senin' => $request->senin ?? 0,
            'selasa' => $request->selasa ?? 0,
            'rabu' => $request->rabu ?? 0,
            'kamis' => $request->kamis ?? 0,
            'jumat' => $request->jumat ?? 0,
        ]);

        // Simpan file SK
        if ($request->hasFile('sks')) {
            foreach ($request->file('sks') as $file) {
                $path = $file->store('sks', 'public');
                PegawaiSk::create([
                    'pegawai_id' => $pegawai->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                ]);
            }
        }

        // Simpan file Sertifikat
        if ($request->hasFile('sertifikats')) {
            foreach ($request->file('sertifikats') as $file) {
                $path = $file->store('sertifikats', 'public');
                PegawaiSertifikat::create([
                    'pegawai_id' => $pegawai->id,
                    'nama_sertifikat' => $file->getClientOriginalName(),
                    'path_file' => $path,
                ]);
            }
        }

        // Simpan data khusus guru
        if ($pegawai->jenis_pegawai === 'guru') {
            GuruDetail::create([
                'pegawai_id' => $pegawai->id,
                'jumlah_kelas_mengajar' => $request->jumlah_kelas_mengajar,
                'wali_kelas' => $request->wali_kelas ? 1 : 0,
                'jumlah_hari_mengajar' => $request->jumlah_hari_mengajar,
                'jumlah_jam' => $request->jumlah_jam,
            ]);

            if ($request->mata_pelajaran) {
                foreach ($request->mata_pelajaran as $mapel) {
                    GuruMapel::create([
                        'pegawai_id' => $pegawai->id,
                        'mata_pelajaran' => $mapel
                    ]);
                }
            }
        }

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil disimpan.');
    }
}
