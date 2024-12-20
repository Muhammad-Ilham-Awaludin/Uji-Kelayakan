<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Pengaduan Masyarakat
    </title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container-fluid {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
        }

        .left-section {
            /* background-color: #ff7f00; */
            color: black;
            padding: 50px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-section {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .right-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.5;
        }

        .floating-icons {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .floating-icons a {
            background-color: #004d40;
            color: white;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
        }

        .btn-custom {
            background-color: #004d40;
            color: white;
            border: none;
            padding: 10px 20px;
            text-transform: uppercase;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        {{-- <div class="left-section"> --}}
            @yield('masuk')
        {{-- </div> --}}
        <div class="right-section">
            <img alt="Aerial view of a city with roads and buildings" height="600"
                src="https://storage.googleapis.com/a1aa/image/rd9lhi77ov6ZHJA17cLylHunqSfTQq8mkUmyzjLGfgIlbL6TA.jpg"
                width="800" />
            <div class="floating-icons">
                <a href="#">
                    <i class="fas fa-user">
                    </i>
                </a>
                <a href="#">
                    <i class="fas fa-exclamation">
                    </i>
                </a>
                <a href="{{ route('report.create') }}">
                    <i class="fas fa-pen">
                    </i>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
