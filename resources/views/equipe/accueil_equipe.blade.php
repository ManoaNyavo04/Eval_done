@include('partials.menu_equipe', ['userId' => $userId])

<!-- Layout container -->
<div class="layout-page">
    @include('partials.navbar')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Hello user_id: {{$userId}}</h4>

            <!-- Card for displaying coureurs by etape -->
            <div class="card">
                <h5 class="card-header">Hello user_id: {{$userId}}</h5>

                @foreach ($etapes as $etape)
                    <div class="card-body">
                        <h6 class="card-title">Etape {{ $etape->id_etape }}: {{ $etape->nom }}</h6>

                        <!-- Table for coureurs of this etape -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Coureur</th>
                                    <th>Nom</th>
                                    <th>ID Equipe</th>
                                    <th>Durée</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($coureurEtapeEquipe->get($etape->id_etape, collect()) as $coureur)
                                    <tr>
                                        <td>{{ $coureur->id_coureur }}</td>
                                        <td>{{ $coureur->nom }}</td>
                                        <td>{{ $coureur->id_equipe }}</td>
                                        <td>{{ $coureur->duree }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Aucun coureur pour cette étape.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Form to add coureur to this etape -->
                        <form action="{{ route('etape.to_insert_coureur', ['userId' => $userId]) }}" method="GET">
                            @csrf
                            <input type="hidden" name="id_etape" value="{{ $etape->id_etape }}">
                            <button type="submit" class="btn btn-primary">Ajouter coureur pour l'étape {{ $etape->id_etape }}</button>
                        </form>

                        <!-- Display error message for this etape if exists -->
                        @if ($errors->has($etape->id_etape))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first($etape->id_etape) }}
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>
        <!-- / Content -->

        @include('partials.footer')

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->
