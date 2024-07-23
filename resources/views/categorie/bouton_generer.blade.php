
{{-- @include('partials.menu'); --}}

@extends('partials.menu')

@section('title')
    Generation du categorie de chaque coureur
@endsection

@section('meta-description')
    Generation du categorie de chaque coureur selon leur age, et sexe
@endsection



<!-- Layout container -->
@section('content')
<div class="layout-page">

    @include('partials.navbar');

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
          <!-- Basic Layout -->
          <div class="col-xxl">
            <div class="card mb-4"
                style="    width: 65%;
                margin-left: 18%;">
              <div class="card-header d-flex align-items-center justify-content-between">

              </div>
              <div class="card-body">
                <h1 class="mb-0" id="acc_h1" style="
                                                font-size: x-large;
                                                margin-top: 1%;
                                                margin-left: -9%;
                                                text-align: center;"
                ><small>Generation du categorie de chaque coureur</small></h1>

                <form action="{{ route('categorie.generateCate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Generer categorie</button>
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

      @include('partials.footer');

      <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
  </div>
  <!-- / Layout page -->
  @endsection
