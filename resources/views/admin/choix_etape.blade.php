
{{-- @include('partials.menu'); --}}
@extends('partials.menu')

@section('title')
    Choix d'etape pour le classement general pour chaque etape
@endsection

@section('meta-description')
    Trie des etapes pour voir le classement des coureurs par etapes
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
                <h1 class="mb-0" id="acc_h1" style="
                                font-size: x-large;
                                margin-top: 1%;
                                margin-left: 3%;"
                ><small>Le classement general des coureurs pour chaque etape</small></h1>


              </div>

              <div class="card-body">
                <h2 class="mb-0" id="acc_h2" style="font-size: large;
                                margin-left: 3%;
                                margin-top: 1%;"
                ><small>Trie de classement pour chaque etape</small></h2>
                <form action="{{ route('classement.liste_classm_etape') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Etape</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="exampleFormControlSelect1" name="etape" aria-label="Default select example">
                                @foreach ($etape as $etap)
                                    <option value="{{ $etap->id_etape }}">{{ $etap->nom }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>
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
  @endsection
  <!-- / Layout page -->
