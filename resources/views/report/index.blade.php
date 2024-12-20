@extends('layouts.layout')

@section('content')
    <div class="col-md-8">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <h1>Cari Laporan Berdasarkan Provinsi</h1>

        <!-- Form Pencarian -->
        <div class="input-group mb-3">
            <form action="{{ route('report.index') }}" method="GET" class="w-100">
                <div class="row">
                    <div class="col-md-4">
                        <select name="province" id="province" class="form-select">
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province['name'] }}"
                                    {{ request('province') == $province['name'] ? 'selected' : '' }}>
                                    {{ $province['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        {{-- <a href="{{ route('report.index') }}" class="btn btn-secondary">Reset</a> --}}
                    </div>
                </div>
            </form>
        </div>

        <!-- Tampilkan Hasil Pencarian -->
        <div id="results">
            @if ($reports->isNotEmpty())
                @foreach ($reports as $item)
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('/storage/' . $item->image) }}" alt="Image for {{ $item->description }}"
                                    class="img-fluid rounded-start" height="200" width="300">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('report.detail', $item->id) }}" class="text-decoration-none fw-bold">
                                            {{ $item->description }}
                                        </a>
                                    </h5>
                                    <p class="card-text">
                                        <i class="fas fa-eye"></i> {{ $item->viewers }} views
                                    </p>
                                    {{-- <p class="card-text">
                                        <span class="like-count" id="like-count-{{ $item->id }}">{{ $item->likes }}</span> likes
                                    </p> --}}
                                    <p class="card-text">
                                        {{ $item->user->name }}
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                    </p>
                                    <form action="{{ route('report.vote', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-heart"></i> Vote
                                        </button>
                                    </form>
                                    <p class="mt-2">
                                        Total Votes: {{ count(json_decode($item->voting, true)) }}
                                    </p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Tidak ada laporan untuk provinsi ini.</p>
            @endif
        </div>

        <!-- Pagination -->
        {{ $reports->links() }}
    </div>
@endsection
