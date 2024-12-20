<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Complaint Page
    </title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #ff7f00;
        }

        .card {
            margin-bottom: 20px;
        }

        .info-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }

        .info-box h5 {
            color: #ffc107;
        }

        .floating-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .floating-buttons .btn {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="container mt-4 d-flex">
        <div class="row">
            @yield('content')
            <div class="col-md-4">
                <div class="info-box">
                    <h5>
                        <i class="fas fa-info-circle">
                        </i>
                        Informasi Pembuatan Pengaduan
                    </h5>
                    <ol>
                        <li>
                            Pengaduan bisa dibuat hanya jika Anda telah membuat akun sebelumnya,
                        </li>
                        <li>
                            Keseluruhan data pada pengaduan bernilai BENAR dan DAPAT DIPERTANGGUNG JAWABKAN,
                        </li>
                        <li>
                            Seluruh bagian data perlu diisi
                        </li>
                        <li>
                            Pengaduan Anda akan ditanggapi dalam 2x24 Jam,
                        </li>
                        <li>
                            Periksa tanggapan Kami, pada
                            <strong>
                                Dashboard
                            </strong>
                            setelah Anda
                            <strong>
                                Login
                            </strong>
                            ,
                        </li>
                        <li>
                            Pembuatan pengaduan dapat dilakukan pada halaman berikut :
                            <a href="#">
                                Ikuti Tautan
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="floating-buttons">
        <a class="btn btn-primary" href="{{ route('report.index') }}">
            <i class="fas fa-home">
            </i>
        </a>
        <a class="btn btn-warning" href="{{ route('report.me') }}">
            <i class="fas fa-exclamation">
            </i>
        </a>
        {{-- <form action="{{ route('report.create') }}">
            <button type="submit">bikin</button>
        </form>         --}}
        <a class="btn btn-success" href="{{ route('report.create') }}">
            <i class="fas fa-pen">
            </i>
        </a>
    </div>

    <script crossorigin="anonymous" integrity="sha384-oBqDVmMz4fnFO9gybBogGzOg6tv6kLkKtbFfHfviM0lvY73eDXL8uWe0pNyh7K+N"
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>
