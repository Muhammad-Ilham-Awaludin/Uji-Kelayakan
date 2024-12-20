<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // public function store(Request $request, Report $report)
    // {
    //     $request->validate([
    //         'report_id' => 'required',
    //         'comment' => 'required'
    //     ]);

    //     $report->comments()->create([
    //         'report_id' => $request->report_id,
    //         'user_id' => auth()->id(),
    //         'comment' => $request->comment
    //     ]);

    //     return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    // }

}
