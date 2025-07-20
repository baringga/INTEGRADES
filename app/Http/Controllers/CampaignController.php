<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\AkunKomunitas;
use App\Models\GambarCampaign;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function show($id)
    {
        $user = auth()->user();

        // Ambil campaign beserta gambar
        $campaign = \App\Models\Campaign::with([
            'akun',
            'gambar_campaign',
            'partisipanCampaigns.akun'
        ])->findOrFail($id);

        // Ambil komentar
        $komentar = \App\Models\Komentar::with(['akun', 'likes'])
            ->where('campaign_id', $id)
            ->orderBy('waktu', 'desc')
            ->get();

        // Cek role berdasarkan jenis_akun_id
        if ($user->jenis_akun_id == 1) {
            return view('detailcam', compact('campaign', 'komentar'));
        } elseif ($user->jenis_akun_id == 2) {
            if ($campaign->akun_id == $user->id) {
                return view('detailcommunity', compact('campaign', 'komentar'));
            } else {
                return view('detailcam', compact('campaign', 'komentar'));
            }
        } else {
            abort(403, 'Role tidak dikenali');
        }
    }

    public function showCom($id)
    {
        // Ambil campaign beserta gambar dan partisipan+usernya sekaligus (eager loading)
        $campaign = \App\Models\Campaign::with([
            'gambar_campaign',
            'partisipanCampaigns.akun'
        ])->findOrFail($id);

        // Kirim ke blade
        return view('detailcommunity', compact('campaign'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_campaign' => 'required|string|max:100',
            'deskripsi_campaign' => 'required|string',
            'waktu' => 'required|date_format:d-m-Y H:i',
            'kuota_partisipan' => 'required|integer|min:1',
            'alamat_campaign' => 'required|string',
            'gambar_latar' => 'required|array|max:3',
            'gambar_latar.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'gambar_latar.required' => 'Setidaknya satu gambar harus diunggah.',
            'gambar_latar.max' => 'Anda dapat mengunggah hingga 3 gambar.',
            'gambar_latar.*.image' => 'File harus berupa gambar.',
            'gambar_latar.*.mimes' => 'Gambar harus berformat JPEG, PNG, JPG, atau SVG.',
            'gambar_latar.*.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'nama_campaign.required' => 'Nama campaign wajib diisi.',
            'deskripsi_campaign.required' => 'Deskripsi campaign wajib diisi.',
            'waktu.required' => 'Waktu pelaksanaan wajib diisi.',
            'kuota_partisipan.required' => 'Kuota partisipan wajib diisi.',
            'alamat_campaign.required' => 'Alamat campaign wajib diisi.',
        ]);

        // Cek apakah user adalah komunitas
        $user = Auth::user();
        if ($user->jenisAkun->jenisAkun !== 'Komunitas') {
            abort(403, 'Hanya akun komunitas yang dapat membuat campaign.');
        }

        // 2. Simpan data campaign
        $campaign = new Campaign();
        $campaign->akun_id = $user->id;
        $campaign->nama = $request->nama_campaign;
        $campaign->waktu = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->waktu)->format('Y-m-d H:i:s');
        $campaign->waktu_diperbarui = now();
        $campaign->deskripsi = $request->deskripsi_campaign;
        $campaign->lokasi = $request->alamat_campaign;
        $campaign->kontak = $user->email;
        $campaign->kuota_partisipan = $request->kuota_partisipan;
        $campaign->save();

        // 3. Upload dan simpan gambar
        $files = $request->file('gambar_latar');
        foreach ($files as $index => $file) {
            $path = $file->store('gambar_campaign', 'public');
            GambarCampaign::create([
                'campaign_id' => $campaign->id,
                'gambar' => $path,
                'isCover' => ($index === 0), // Gambar pertama menjadi cover
            ]);
        }

        // 4. Redirect ke halaman detail campaign yang baru dibuat
        return redirect()->route('campaign.tambah')->with([
            'success' => 'Campaign berhasil dibuat!',
            'new_campaign_id' => $campaign->id
        ]);
    }

    public function bookmark($id, Request $request)
    {
        $akunId = Auth::id();
        // Cek jika sudah pernah bookmark
        $exists = DB::table('campaign_ditandai')
            ->where('akun_id', $akunId)
            ->where('campaign_id', $id)
            ->exists();

        if (!$exists) {
            DB::table('campaign_ditandai')->insert([
                'akun_id' => $akunId,
                'campaign_id' => $id,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Campaign berhasil ditandai!');
    }

    public function unbookmark($id, Request $request)
    {
        $akunId = auth()->id();
        \DB::table('campaign_ditandai')
            ->where('akun_id', $akunId)
            ->where('campaign_id', $id)
            ->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Bookmark dihapus!');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $campaign = Campaign::findOrFail($id);

        // Hanya izinkan jika user komunitas dan pemilik campaign
        if ($user->jenis_akun_id == 2 && $campaign->akun_id == $user->id) {
            return view('editcampaign', compact('campaign'));
        } else {
            abort(403, 'Anda tidak memiliki akses untuk mengedit campaign ini');
        }
    }

    public function update(Request $request, $id){
    // 1. Validasi input
    $request->validate([
        'nama_campaign' => 'required|string|max:100',
        'deskripsi_campaign' => 'required|string',
        'waktu' => 'required|date_format:d-m-Y H:i',
        'kuota_partisipan' => 'required|integer|min:1',
        'alamat_campaign' => 'required|string',
        // Validasi untuk gambar baru. `nullable` karena tidak wajib upload baru.
        'gambar_latar' => 'nullable|array',
        'gambar_latar.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
    ], [
        'gambar_latar.*.image' => 'File yang diunggah harus berupa gambar.',
        'gambar_latar.*.mimes' => 'Gambar harus berformat: jpeg, png, jpg, atau svg.',
        'gambar_latar.*.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
    ]);

    $campaign = Campaign::findOrFail($id);

    // 2. Update data teks campaign
    $campaign->nama = $request->nama_campaign;
    $campaign->deskripsi = $request->deskripsi_campaign;
    $campaign->waktu = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->waktu)->format('Y-m-d H:i:s');
    $campaign->kuota_partisipan = $request->kuota_partisipan;
    $campaign->lokasi = $request->alamat_campaign;
    $campaign->waktu_diperbarui = now();
    $campaign->save();

    // 3. Hapus gambar lama (jika ada yang ditandai untuk dihapus)
    if ($request->has('gambar_dihapus')) {
        $gambarIdsToDelete = $request->input('gambar_dihapus', []);
        $gambarsToDelete = GambarCampaign::whereIn('id', $gambarIdsToDelete)->get();

        foreach ($gambarsToDelete as $gambar) {
            // Hapus file dari storage jika bukan URL
            if (!filter_var($gambar->gambar, FILTER_VALIDATE_URL)) {
                \Storage::disk('public')->delete($gambar->gambar);
            }
            $gambar->delete();
        }
    }

    // 4. Tambah gambar baru
    if ($request->hasFile('gambar_latar')) {
        $files = $request->file('gambar_latar');
        if (!is_array($files)) {
            $files = [$files];
        }
        // Cek apakah sudah ada gambar cover
        $sudahAdaCover = GambarCampaign::where('campaign_id', $campaign->id)->where('isCover', 1)->exists();
        foreach ($files as $idx => $file) {
            if ($file && $file->isValid()) {
                $path = $file->store('gambar_campaign', 'public');
                GambarCampaign::create([
                    'campaign_id' => $campaign->id,
                    'gambar' => $path,
                    // Jika sudah ada cover, semua gambar baru isCover = 0
                    // Jika belum ada cover, gambar pertama jadi cover
                    'isCover' => (!$sudahAdaCover && $idx === 0) ? 1 : 0,
                ]);
            }
        }
    }

    return redirect()->back()->with('success', 'Campaign berhasil diperbarui!');
    }


    public function akun()
    {
        return $this->belongsTo(\App\Models\User::class, 'akun_id');
    }

    public function nullify($id)
    {
        $campaign = \App\Models\Campaign::findOrFail($id);

        // Set semua kolom selain id menjadi NULL
        $campaign->nama = null;
        $campaign->waktu = null;
        $campaign->waktu_diperbarui = null;
        $campaign->deskripsi = null;
        $campaign->lokasi = null;
        $campaign->kontak = null;
        $campaign->kuota_partisipan = null;
        $campaign->save();

        return redirect()->route('dashboard')->with('success', 'Data campaign telah dinull-kan!');
    }

    public function hapusGambar($id)
    {
        $gambar = GambarCampaign::find($id);
        if ($gambar) {
            $campaignId = $gambar->campaign_id;
            $wasCover = $gambar->isCover == 1;
            // Hapus file dari storage jika bukan URL
            if (!filter_var($gambar->gambar, FILTER_VALIDATE_URL)) {
                \Storage::disk('public')->delete($gambar->gambar);
            }
            $gambar->delete();
            // Jika yang dihapus adalah cover, set 1 gambar lain jadi cover
            if ($wasCover) {
                $gambarLain = GambarCampaign::where('campaign_id', $campaignId)->first();
                if ($gambarLain) {
                    $gambarLain->isCover = 1;
                    $gambarLain->save();
                }
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
