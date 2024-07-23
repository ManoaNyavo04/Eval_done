
{{-- @include('partials.menu'); --}}
@extends('partials.menu')

@section('title')
    Le resultat general des coureurs par etape avec coefficient
@endsection

@section('meta-description')
    Liste des etapes pour voir le resultat general des coureurs par etapes avec le coefficient
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
            ><small>Le resultat general des coureurs par etape avec coefficient</small></h1>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Longueur (km)</th>
                            <th>Rang d'Étape</th>
                            <th>Heure de Départ</th>
                            <th>Coeff</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($etape as $etapy)
                            <tr>
                                <td>{{ $etapy->nom }}</td>
                                <td>{{ $etapy->longueur_km }}</td>
                                <td>{{ $etapy->rang_etape }}</td>
                                <td>{{ $etapy->heure_depart }}</td>
                                <td>{{ $etapy->coefficient }}</td>
                                <td>
                                    <form action="{{ route('classement.resulatGeneralAdmin') }}" method="get">
                                        <input type="hidden" name="id_etape" value="{{ $etapy->id_etape }}">
                                        <button type="submit" class="btn rounded-pill btn-success">Voir details</button>
                                    </form>
                                </td>
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