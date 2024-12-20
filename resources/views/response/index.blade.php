<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome (optional for icons) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .header .title {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
        }

        .export-btn {
            background-color: #28a745;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .export-btn:hover {
            background-color: #218838;
        }

        .container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .alert {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }

        table th {
            background-color: #f9fafb;
            font-weight: 600;
        }

        table tr:hover {
            background-color: #f1f5f9;
        }

        .action-btn {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #0056b3;
        }

        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #00695c;
            color: #ffffff;
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 20px;
            text-align: center;
        }

        .header a {
            text-decoration: none;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Pengaduan</div>
        <a class="btn btn-outline-secondary" type="button" href="{{ route('logout') }}">Logout</a>
    </div>
    <div class="container">
        <!-- Alerts -->
        @if (Session::get('success'))
            <div class="alert alert-success">
                <strong>Berhasil!</strong> {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::get('failed'))
            <div class="alert alert-error">
                <strong>Kesalahan!</strong> {{ Session::get('failed') }}
            </div>
        @endif

        <!-- Table -->
        <h2>Daftar Pengaduan</h2>
        <div class="dropdown">
            <button id="downloadButton" class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-file-excel me-2"></i>
                Download Excel
            </button>
            <ul id="dropdownContent" class="dropdown-menu">
                <li>
                    <a href="{{ route('response.exportExcel') }}" class="dropdown-item">Download Semua Data</a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="showDateForm(event)" class="dropdown-item">Download
                        Berdasarkan Tanggal</a>
                </li>
            </ul>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Gambar & Pengirim</th>
                    <th>Lokasi & Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Vote</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <img src="{{ asset('/storage/' . $report->image) }}" alt="Foto Profil"
                                    style="border-radius: 50%; margin-right: 10px; width: 50px; height: 50px;">
                                <span>{{ $report->user->email }}</span>
                            </div>
                        </td>
                        <td>
                            <div>{{ strtolower($report->village) }}, {{ strtolower($report->subdistrict) }},
                                {{ strtolower($report->regency) }}, {{ strtolower($report->province) }}</div>
                            <small>{{ $report->created_at->translatedFormat('j F Y') }}</small>
                        </td>
                        <td>{{ implode(' ', array_slice(explode(' ', $report->description), 0, 5)) }}...</td>
                        <td class="text-center">
                            {{-- {{ is_array($report->voting) ? count($report->voting) : 0 }} --}}
                            {{ count(json_decode($report->voting, true)) }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="#" class="action-btn">Proses</a>
                                {{-- <a href="{{ route('response.response', $report->id) }}" class="action-btn">Proses</a> --}}
                                <form action="{{ route('response.reject', $report->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menolak laporan ini?')">
                                    @csrf
                                    <button type="submit" class="action-btn"
                                        style="background-color: #dc3545;">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="floating-button">🏠</div>
</body>

</html>
