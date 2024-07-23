
{{-- @include('partials.menu'); --}}

@extends('partials.menu')

@section('title')
    Resultat classement general des coureurs par etape
@endsection

@section('meta-description')
    Le reusltat du classement general des coureur par etape en prennant en compte le coefficient
@endsection


<!-- Layout container -->
@section('content')


<!-- Layout container -->
<div class="layout-page">

    @include('partials.navbar');

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">

        {{-- miova ho table --}}
        <div class="card">
            <h1 class="mb-0" id="acc_h1" style="
                                font-size: x-large;
                                margin-top: 1%;
                                margin-left: 3%;"
            ><small>Le classement general des coureurs par etape</small></h1>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>genre</th>
                            <th>chrono</th>
                            <th>penalite</th>
                            <th>temps_final</th>
                            <th>rang</th>
                            <th>points</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($query as $etapy)
                            <tr>
                                <td>{{ $etapy->nom }}</td>
                                <td>{{ $etapy->genre }}</td>
                                <td>{{ $etapy->chrono }}</td>
                                <td>{{ $etapy->penalite }}</td>
                                <td>{{ $etapy->temps_final }}</td>
                                <td>{{ $etapy->rang }}</td>
                                <td>{{ $etapy->points }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
