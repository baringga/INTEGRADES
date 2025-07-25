<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\AkunKomunitas;
use App\Models\GambarCampaign;
use App\Models\PartisipanCampaign;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    /**
     * Menampilkan halaman detail campaign untuk semua pengguna.
     */
    public function show($id)
    {
        $campaign = Campaign::with('partisipanCampaigns')->findOrFail($id);
        $komentar = \App\Models\Komentar::with(['akun', 'likes'])
            ->where('campaign_id', $id)
            ->orderBy('waktu', 'desc')
            ->get();

        return view('detailcam', compact('campaign', 'komentar'));
    }

    /**
     * Menampilkan form untuk membuat campaign baru.
     * Hanya bisa diakses oleh Volunteer Desa yang sudah melengkapi portofolio.
     */
    public function create()
    {
        $user = Auth::user();

        // Hapus/komentari seluruh pengecekan portofolio
        // $profilVolunteer = AkunKomunitas::where('akun_id', $user->id)->first();
        // if (!$profilVolunteer || trim($profilVolunteer->portofolio) === '') {
        //     return redirect()->route('profil')->with('error', 'Harap lengkapi URL portofolio Anda di profil sebelum membuat campaign.');
        // }

        return view('TambahCampaign');
    }

    /**
     * Menyimpan campaign baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_campaign' => 'required|string|max:100',
            'deskripsi_campaign' => 'required|string',
            'waktu' => 'required|date_format:d-m-Y H:i',
            'kuota_partisipan' => 'required|integer|min:1',
            'alamat_campaign' => 'required|string',
            'gambar_latar' => 'required|array|max:3',
            'gambar_latar.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $user = Auth::user();

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

        foreach ($request->file('gambar_latar') as $index => $file) {
            $path = $file->store('gambar_campaign', 'public');
            GambarCampaign::create([
                'campaign_id' => $campaign->id,
                'gambar' => $path,
                'isCover' => ($index === 0),
            ]);
        }

        return redirect()->route('campaign.tambah')->with([
            'success' => 'Campaign berhasil dibuat!',
            'new_campaign_id' => $campaign->id
        ]);
    }

    /**
     * Menampilkan halaman untuk mengedit campaign.
     */
    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);

        // Pastikan hanya pembuat campaign yang bisa mengedit
        if ($campaign->akun_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit campaign ini.');
        }

        return view('editcampaign', compact('campaign'));
    }

    /**
     * Memperbarui data campaign di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_campaign' => 'required|string|max:100',
            'deskripsi_campaign' => 'required|string',
            'waktu' => 'required|date_format:d-m-Y H:i',
            'kuota_partisipan' => 'required|integer|min:1',
            'alamat_campaign' => 'required|string',
            'gambar_latar' => 'nullable|array',
            'gambar_latar.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $campaign = Campaign::findOrFail($id);

        // Pastikan hanya pembuat campaign yang bisa mengupdate
        if ($campaign->akun_id !== Auth::id()) {
            abort(403);
        }

        $campaign->nama = $request->nama_campaign;
        $campaign->deskripsi = $request->deskripsi_campaign;
        $campaign->waktu = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->waktu)->format('Y-m-d H:i:s');
        $campaign->kuota_partisipan = $request->kuota_partisipan;
        $campaign->lokasi = $request->alamat_campaign;
        $campaign->waktu_diperbarui = now();
        $campaign->save();

        if ($request->hasFile('gambar_latar')) {
            foreach ($request->file('gambar_latar') as $file) {
                $path = $file->store('gambar_campaign', 'public');
                GambarCampaign::create(['campaign_id' => $campaign->id, 'gambar' => $path]);
            }
        }

        return redirect()->route('editcampaign', $campaign->id)->with('success', 'Campaign berhasil diperbarui!');
    }

    /**
     * Menampilkan halaman manajemen partisipan.
     */
    public function manage($id)
    {
        $campaign = \App\Models\Campaign::with('partisipanCampaigns.akun')->findOrFail($id);

        if ($campaign->akun_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('campaign.manage', compact('campaign'));
    }

    /**
     * Mengubah status partisipan (Approve/Reject).
     */
    public function updateStatus(Request $request, $partisipanId)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $partisipan = \App\Models\PartisipanCampaign::findOrFail($partisipanId);
        $campaign = $partisipan->campaign;

        if ($campaign->akun_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $partisipan->status = $request->status;
        $partisipan->save();

        return back()->with('success', 'Status partisipan berhasil diperbarui.');
    }

    /**
     * Menambahkan bookmark.
     */
    public function bookmark($id)
    {
        $user = Auth::user();
        $isBookmarked = DB::table('campaign_ditandai')->where('akun_id', $user->id)->where('campaign_id', $id)->exists();

        if (!$isBookmarked) {
            DB::table('campaign_ditandai')->insert(['akun_id' => $user->id, 'campaign_id' => $id]);
        }
        return back();
    }

    /**
     * Menghapus bookmark.
     */
    public function unbookmark($id)
    {
        DB::table('campaign_ditandai')->where('akun_id', Auth::id())->where('campaign_id', $id)->delete();
        return back();
    }

    /**
     * Menyimpan komentar baru ke database.
     */
    public function storeKomentar(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:280',
        ]);
        \App\Models\Komentar::create([
            'akun_id' => auth()->id(),
            'campaign_id' => $id,
            'komentar' => $request->komentar,
            'waktu' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Komentar berhasil dikirim!');
    }

    /**
     * Menampilkan semua campaign.
     */
    public function listAll()
    {
        $campaigns = \App\Models\Campaign::with('coverImage', 'partisipanCampaigns')
            ->orderBy('waktu', 'desc')
            ->paginate(9);

        return view('all-campaigns', [
            'title' => 'Semua Campaign',
            'campaigns' => $campaigns,
            'emptyMessage' => 'Tidak ada campaign untuk ditampilkan'
        ]);
    }
}
