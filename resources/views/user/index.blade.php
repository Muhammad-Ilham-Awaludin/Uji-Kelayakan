<html>

<head>
    <title>Kelola Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-reset {
            background-color: #007bff;
            color: white;
        }

        .btn-reset:hover {
            background-color: #0056b3;
            color: white;
        }

        .btn-hapus {
            background-color: #dc3545;
            color: white;
        }

        .btn-hapus:hover {
            background-color: #c82333;
            color: white;
        }

        .btn-buat {
            background-color: #343a40;
            color: white;
        }

        .btn-buat:hover {
            background-color: #1d2124;
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-globe"></i>
                Kelola Akun
            </a>
            <a class="btn btn-outline-secondary" type="button" href="{{ route('logout') }}">Logout</a>
            {{-- <a href="{{ route('logout') }}" class="nav-link">Logout</a> --}}
        </div>
    </nav>
    <div class="container">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('deleted'))
            <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Akun Staff Daerah JAWA BARAT</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <form action="{{ route('user.reset', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-reset">Reset</button>
                                            </form>
                                            <form action="{{ route('user.delete', $item['id']) }}" method="POST" class="mt-1"
                                                onsubmit="return confirm('serous')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Buat Akun Staff</h5>
                        <form action="{{ route('user.store') }}" method="POST" class="card p-5">
                            @csrf
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Sandi</label>
                                <input type="password" class="form-control" id="password" value="" name="password">
                            </div>
                            <button type="submit" class="btn btn-secondary">Buat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
