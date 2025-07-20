<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('q');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $location = $request->query('location');
        $quota = $request->query('quota');

        $campaigns = Campaign::query();

        // Filter berdasarkan kata kunci pencarian
        if ($query) {
            $campaigns->where(function($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$query}%");
            });
        }

        // Filter berdasarkan tanggal
        if ($startDate) {
            $campaigns->where('waktu', '>=', $startDate);
        }
        if ($endDate) {
            $campaigns->where('waktu', '<=', $endDate);
        }

        // Filter berdasarkan lokasi
        if ($location) {
            $campaigns->where('lokasi', 'LIKE', "%{$location}%");
        }

        // Filter berdasarkan kuota
        if ($quota) {
            switch ($quota) {
                case '1-10':
                    $campaigns->where('kuota_partisipan', '<=', 10);
                    break;
                case '11-50':
                    $campaigns->whereBetween('kuota_partisipan', [11, 50]);
                    break;
                case '51-100':
                    $campaigns->whereBetween('kuota_partisipan', [51, 100]);
                    break;
                case '100+':
                    $campaigns->where('kuota_partisipan', '>', 100);
                    break;
            }
        }

        $campaigns = $campaigns->paginate(9)->withQueryString();

        return view('search', [
            'campaigns' => $campaigns,
            'query' => $query,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'location' => $location,
            'quota' => $quota
        ]);
    }
}
