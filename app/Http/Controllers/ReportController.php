<?php

namespace App\Http\Controllers;

use App\Models\Report;
use GuzzleHttp\Client;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Ambil parameter `province` dari query string
        $searchProvince = $request->province;

        // Query berdasarkan provinsi (jika `province` diisi)
        $reports = Report::when($searchProvince, function ($query, $searchProvince) {
            return $query->where('province', $searchProvince);
        })->orderBy('created_at', 'ASC')->simplePaginate(10);

        // Ambil data provinsi dari API
        $provinces = $this->getProvinces();

        return view('report.index', compact('reports', 'provinces'));
    }

    private function getProvinces()
    {
        $response = file_get_contents('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        return json_decode($response, true);
    }

    public function detail($id)
    {
        // Cari laporan berdasarkan ID
        $report = Report::findOrFail($id);

        // Tambahkan jumlah viewer
        $report->increment('viewers');

        // Kirim data laporan ke view
        return view('report.detail', compact('report'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('report.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk membuat laporan.');
        }

        $request->validate([
            'description' => 'required',
            'type' => 'required|in:KEJAHATAN,PEMBANGUNAN,SOSIAL',
            'province' => 'required',
            'regency' => 'required',
            'subdistrict' => 'required',
            'village' => 'required',
            'image' => 'nullable|image|max:2048',
            'statement' => 'accepted',
        ]);
        // dd($request->all());

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Report::create([
            'user_id' => auth()->id(), // Asumsikan user login
            'description' => $request->description,
            'type' => $request->type,
            'province' => $request->province,
            'regency' => $request->regency,
            'subdistrict' => $request->subdistrict,
            'village' => $request->village,
            'voting' => json_encode([]), // Voting default array kosong
            'viewers' => 0,
            'image' => $imagePath,
            'statement' => true,
        ]);

        return redirect()->route('report.me')->with('success', 'Laporan berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $reports = Report::with(['comments'])->findOrFail($id);
        // $reports->increment('viewers');
        // return view('report.index', compact('reports'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // public function prosess()
    // {
    //     // Ambil laporan tertentu, misalnya dengan ID 1
    //     $report = Report::findOrFail(1);  // Sesuaikan ID sesuai kebutuhan

    //     // Pass data $report ke view
    //     return view('report.prosess', compact('reports'));
    // }

    public function me()
    {
        $reports = Report::where('user_id', auth()->id())
            ->with(['responses', 'user'])
            ->get();
        return view('report.me', compact('reports'));
    }


    /******  78722433-68a5-4116-a622-50215b98857f  *******/
    public function indexComment($id)
    {
        $reports = Report::with(['conments', 'user'])->where('id', $id)->get();

        Log::info('Report Data:', $reports->toArray()); // Logging data laporan

        if ($reports->isEmpty()) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }
        return view('report.detail', compact('reports'));
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        Comment::create([
            'report_id' => $request->report_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        $comments = Comment::with('user')->where('report_id', $request->report_id)->latest()->get();

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function vote(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $userId = Auth::id();
        $voting = json_decode($report->voting, true) ?: [];

        if (in_array($userId, $voting)) {
            $voting = array_filter($voting, function ($value) use ($userId) {
                return $value !== $userId;
            });

            $message = 'Vote berhasil dibatalkan';
        } else {
            $voting[] = $userId;
            $message = 'Vote berhasil diberikan';
        }

        $report->voting = json_encode($voting);
        $report->save();

        return redirect()->back()->with('success', $message);
    }

    public function delete($id)
    {
        $report = Report::find($id);
        if ($report) {
            $report->delete();
            return redirect()->route('report.article.me')->with('success', 'Artikel berhasil dihapus!');
        }
        return redirect()->route('report.me')->with('failed', 'Artikel gagal dihapus!');
    }
    
}
