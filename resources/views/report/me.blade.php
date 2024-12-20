<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan</title>
    <!-- Tambahkan Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .report-container {
            background-color: #ff8c00;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #ffa500;
        }

        .report-container a {
            background-color: transparent;
            border: none;
            color: #fff;
            font-weight: bold;
            padding: 0;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .tab-buttons a {
            background-color: transparent;
            border: none;
            font-weight: bold;
            color: #fff;
            padding: 10px 20px;
            border-bottom: 3px solid transparent;
            cursor: pointer;
        }

        .img-fluid {
            display: block;
            max-width: 25%;
            height: auto;
            margin: 20px auto;
            border-radius: 8px;
            border: 2px solid #fff;
        }

        .navbar navbar-light {
            background-color: gray;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-globe"></i>
                Kelola Akun
            </a>
            <a class="btn btn-outline-secondary" type="button" href="{{ route('logout') }}">Logout</a>
            {{-- <a href="{{ route('logout') }}" class="nav-link">Logout</a> --}}
        </div>
    </nav>
    <div class="container mt-5">
        @forelse ($reports as $report)
            <div id="report{{ $report->id }}" class="report-container">
                <a onclick="toggleDetails('details{{ $report->id }}')">
                    Pengaduan {{ $report->created_at->translatedFormat('j F Y') }}
                </a>

                <div id="details{{ $report->id }}" class="details mt-4">
                    <div class="tab-buttons d-flex justify-content-around border-bottom">
                        @foreach (['Data', 'Gambar', 'Status'] as $tab)
                            <a onclick="switchTab('tab-{{ strtolower($tab) }}-{{ $report->id }}', 'details{{ $report->id }}')"
                                id="tab-button-{{ strtolower($tab) }}-{{ $report->id }}">
                                {{ $tab }}
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <div id="tab-data-{{ $report->id }}" class="tab-content">
                            <h3 class="text-xl font-bold mb-4">Detail Pengaduan</h3>
                            <p>
                                <strong>Tipe:</strong> {{ $report->type }}<br>
                                <strong>Lokasi:</strong> {{ $report->village }}, {{ $report->subdistrict }},
                                {{ $report->regency }}, {{ $report->province }}<br>
                                <strong>Deskripsi:</strong> {{ $report->description }}
                            </p>
                        </div>
                        <div id="tab-gambar-{{ $report->id }}" class="tab-content">
                            <h3 class="text-xl font-bold mb-4">Gambar Pengaduan</h3>
                            @if ($report->image)
                                <img src="{{ asset('storage/' . $report->image) }}" alt="Gambar Pengaduan"
                                    class="img-fluid">
                            @else
                                <p>Tidak ada gambar yang diunggah.</p>
                            @endif

                        </div>
                        <div id="tab-status-{{ $report->id }}" class="tab-content">
                            <h3 class="text-xl font-bold mb-4">Status Pengaduan</h3>
                            <p>
                                Pengaduan
                                {{ $report->responses->isNotEmpty() ? 'telah ditanggapi' : 'sedang dalam proses' }},
                                dengan status:
                                <span
                                    class="{{ match ($report->responses->first()?->response_status) {
                                        'DONE' => 'bg-success text-white px-2 py-1 rounded',
                                        'ON_PROCESS' => 'bg-warning text-dark px-2 py-1 rounded',
                                        'REJECT' => 'bg-danger text-white px-2 py-1 rounded',
                                        default => 'bg-secondary text-white px-2 py-1 rounded',
                                    } }}">
                                    {{ $report->responses->first()?->response_status ?? 'PENDING' }}
                                </span>
                                <br>
                                @if ($report->responses->first()?->response_content)
                                    <strong>Progres:</strong>
                                    @foreach (json_decode($report->responses->first()->response_content, true) as $progres)
                                        <li>{{ $progres }}</li>
                                    @endforeach
                                @else
                                    <span class="text-black">Belum ada respon yang tersedia.</span>
                                @endif
                            </p>

                            @if ($report->responses->isEmpty())
                                <p class="text-blue-500">Apakah ingin menghapus?</p>
                                <form action="{{ route('report.delete', $report->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="button">
                                        Hapus Pengaduan
                                    </button>
                                </form>
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-secondary">Tidak ada pengaduan yang ditemukan.</p>
        @endforelse
    </div>

    <script>
        function toggleDetails(containerId) {
            const details = document.getElementById(containerId);
            details.classList.toggle("active");
        }

        function switchTab(tabId, containerId) {
            const container = document.getElementById(containerId);
            const tabs = container.querySelectorAll(".tab-content");
            const tabButtons = container.querySelectorAll(".tab-buttons button");

            tabs.forEach(tab => tab.classList.remove("active"));
            tabButtons.forEach(button => button.classList.remove("active"));

            document.getElementById(tabId).classList.add("active");
            document.getElementById(`tab-button-${tabId.split('-')[1]}-${containerId.split('details')[1]}`).classList.add(
                "active");
        }
    </script>
</body>

</html>
