<!DOCTYPE html>
<html>
<head>
    <title>Vainqueur</title>
    <style>
        /* Custom Styles for Vainqueur Page */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .layout-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .container-xxl {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
        }

        h4 {
            color: #444;
            margin-bottom: 30px;
            text-align: center;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .card-header h5 {
            margin: 0;
        }

        .card-body {
            padding: 20px;
        }

        .row {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }

        .row label {
            flex: 1;
            font-weight: bold;
            color: #555;
        }

        .row .value {
            flex: 2;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 20px;
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
    </style>
</head>
<body>
    {{-- @include('partials.menu') --}}
    @extends('partials.menu')

    @section('title')
        Vainqueur du tournoi
    @endsection

    @section('meta-description')
        L'equipe vainqueur de Ultimate team race, points totaux, duree parcouru et rang
    @endsection

    @section('content')
    <!-- Layout container -->
    <div class="layout-page">
        @include('partials.navbar')

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">


                <!-- Basic Layout & Basic with Icons -->
                <div class="row">
                    <!-- Basic Layout -->
                    <div class="col-xxl">
                        <div class="card mb-4" style="width: 65%; margin-left: 18%;">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h1 class="mb-0" id="acc_h1" style="
                                                                    font-size: x-large;
                                                                    margin-top: 1%;
                                                                    margin-left: 3%;"
                                ><small>Le vainqueur du course Ultimate team race!!</small></h1>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Equipe vainqueur</label>
                                    <div class="col-sm-10">
                                        <div class="value">{{ $vainc->nom }}</div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Points totaux</label>
                                    <div class="col-sm-10">
                                        <div class="value">{{ $vainc->points }}</div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Duree</label>
                                    <div class="col-sm-10">
                                        <div class="value">{{ $vainc->duree }}</div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Rang</label>
                                    <div class="col-sm-10">
                                        <div class="value">{{ $vainc->rang }}</div>
                                    </div>
                                </div>

                                <form action="{{ route('pdf.export') }}" method="post">
                                    @csrf
                                    <div class="row justify-content-end">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary">Exporter pdf</button>
                                        </div>
                                    </div>
                                </form>

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-error">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Content -->

            @include('partials.footer').
            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
    @endsection
</body>
</html>
