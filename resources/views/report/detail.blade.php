@extends('layouts.layout')

@section('content')
    <!-- Artikel -->
    <div class="col-lg-8">
        <div class="article-card bg-white p-4 border rounded">
            <!-- Gambar laporan -->
            @if ($report->image)
                <div class="text-center mb-4">
                    <img src="{{ asset('/storage/' . $report->image) }}" class="img-fluid rounded" alt="Article Image">
                </div>
            @endif

            <!-- Informasi laporan -->
            <div class="content">
                <p class="text-muted mb-2">{{ $report->created_at->format('d F Y') }}</p>
                <h4 class="fw-bold mb-3">{{ $report->description }}</h4>
                <span class="badge bg-primary">{{ $report->type }}</span>
            </div>
        </div>

        <!-- Bagian Komentar -->
        <div class="comments-section mt-5">
            <h5 class="fw-bold">Komentar</h5>
            
            <!-- Tampilkan daftar komentar -->
            @forelse ($report->comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="fw-bold mb-1">{{ $comment->user->email ?? 'Email tidak tersedia' }}</p>
                        <p class="mb-1">{{ $comment->comment }}</p>
                        <small class="text-muted">{{ $comment->created_at->format('d F Y') }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada komentar. Jadilah yang pertama memberikan komentar!</p>
            @endforelse
        </div>

        <!-- Form Tambah Komentar -->
        <div class="comment-box mt-4">
            @auth
                <form action="{{ route('report.storeComment') }}" method="POST" class="mb-3">
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $report->id }}">
                    <div class="mb-3">
                        <textarea name="comment" class="form-control" rows="3" placeholder="Tambahkan komentar..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            @else
                <p class="text-muted">Anda harus <a href="{{ route('login') }}">login</a> untuk memberikan komentar.</p>
            @endauth
        </div>
    </div>
@endsection
