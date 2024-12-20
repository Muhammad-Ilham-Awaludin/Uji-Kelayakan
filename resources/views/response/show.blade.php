@extends('layouts.layout')
@section('content')
    @if ($report)
        <form action="{{ route('response.store', $report->id) }}" method="POST" enctype="multipart/form-data"
            id="responseForm">
            @csrf
            <div class="max-w-4xl mx-auto bg-white/10 text-black shadow-lg rounded-lg p-6">
                <!-- Header Section -->
                <div class="mb-6">
                    <h1 class="text-xl font-bold ">{{ $report->user->email }}</h1>
                    <p class="text-sm text-blue-500">{{ $report->created_at->translatedFormat('j F Y') }}</p>
                    <div class="mt-2 inline-block bg-green-500 text-black text-sm font-semibold px-3 py-1 rounded">
                        {{ $report->type }}</div>
                </div>

                <!-- Content Section -->
                <div class="border-t pt-4">
                    <h2 class="text-lg font-bold ">{{ $report->village }}, {{ $report->subdistrict }},
                        {{ $report->regency }},
                        {{ $report->province }}</h2>
                    <p class="mt-4 text-blue-600 leading-relaxed">
                        {{ $report->description }}
                    </p>
                    <div class="mt-4">
                        <img src="{{ asset('storage/images/' . $report->image) }}" alt="Construction Site"
                            class="rounded-lg shadow">
                    </div>
                </div>

                <!-- Progress Section -->
                <div class="mt-6 border-t pt-4 text-blue-600">
                    <p>Belum ada riwayat progress perbaikan/penyelesaian apapun</p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-end space-x-4">
                    <button class="bg-green-500 text-black px-4 py-2 rounded shadow hover:bg-green-600"
                        type="submit">Nyatakan
                        Selesai</button>
                    <a href="{{ route('response.progres', $report->id) }}"
                        class="bg-blue-500 text-black px-4 py-2 rounded shadow hover:bg-blue-600">Tambah
                        Progres</a>
                </div>
            </div>
        </form>
    @else
        <p class="text-red-500">Laporan tidak ditemukan.</p>
    @endif
@endsection
