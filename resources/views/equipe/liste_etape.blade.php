
@include('partials.menu_equipe',['userId' => $userId]);


<!-- Layout container -->
<div class="layout-page">

    @include('partials.navbar');

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>UserId: {{$userId}}</h4>
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Affectation temps coureur</h4>

        {{-- miova ho table --}}
        <div class="card">
            <h5 class="card-header">Light Table head</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Longueur (km)</th>
                            <th>Rang d'Étape</th>
                            <th>Heure de Départ</th>
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
                                <td>
                                    <form action="{{ route('etape.to_insert_coureur', ['userId' => $userId]) }}" method="get">
                                        <input type="hidden" name="id_etape" value="{{ $etapy->id_etape }}">
                                        <button type="submit" class="btn rounded-pill btn-success">Insérer coureur</button>
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
  <!-- / Layout page -->
