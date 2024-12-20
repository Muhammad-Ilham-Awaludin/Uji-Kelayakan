<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan</title>
    <!-- Tambahkan Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card p-4 bg-warning text-white">
            @foreach ($reports as $report)

            <h2 class="font-weight-bold">Pengaduan {{ \Carbon\Carbon::parse($report->created_at)->format('d F Y') }}</h2>
            <p>Pengaduan telah ditanggapi, dengan status: <strong>{{ $report->statement ? 'DONE' : 'PENDING' }}</strong></p>

            <div class="d-flex justify-content-around">
                <button class="btn btn-primary" id="btnData">Data</button>
                <button class="btn btn-primary" id="btnGambar">Gambar</button>
                <button class="btn btn-primary" id="btnStatus">Status</button>
            </div>
            
            <!-- Elemen untuk menampilkan data -->
            <div id="dataInfo" class="mt-3" style="display: none;">
                <div class="alert alert-light text-dark">
                    <ul>
                        <li><strong>Tipe Lokasi:</strong> {{ $report->type }}</li>
                        <li><strong>Deskripsi:</strong> {{ $report->description }}</li>
                        <li><strong>Provinsi:</strong> {{ $report->province }}</li>
                        <li><strong>Kabupaten:</strong> {{ $report->regency }}</li>
                        <li><strong>Kecamatan:</strong> {{ $report->subdistrict }}</li>
                        <li><strong>Desa:</strong> {{ $report->village }}</li>
                    </ul>
                </div>
            </div>

            <!-- Elemen untuk menampilkan gambar -->
            <div id="gambar" class="mt-3" style="display: none;">
                @if ($report->image)
                    <img src="{{ asset('storage/' . $report->image) }}" alt="Gambar Pengaduan" class="img-fluid">
                @else
                    <p>Tidak ada gambar yang diunggah.</p>
                @endif
            </div>

            <!-- Elemen untuk menampilkan status -->
            <div id="status" class="mt-3" style="display: none;">
                <div class="alert alert-light text-dark">
                    <ul>
                        @foreach($report->comments as $comment)
                            <li><strong>{{ $comment->user->name ?? 'Anonim' }}:</strong> {{ $comment->comment }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>                
    @endforeach

    <!-- Tambahkan Bootstrap JS dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // JavaScript untuk menampilkan data saat tombol "Data" diklik
        $('#btnData').click(function() {
            $('#dataInfo').slideToggle();
        });

        // JavaScript untuk menampilkan gambar saat tombol "Gambar" diklik
        $('#btnGambar').click(function() {
            $('#gambar').slideToggle();
        });

        // JavaScript untuk menampilkan status saat tombol "Status" diklik
        $('#btnStatus').click(function() {
            $('#status').slideToggle();
        });
    </script>
</body>
</html>
