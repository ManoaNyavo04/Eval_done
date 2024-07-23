
@include('partials.menu');


<!-- Layout container -->
<div class="layout-page">

    @include('partials.navbar');

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">

        {{-- miova ho table --}}
        <div class="card">
            <h5 class="card-header">Liste coureur a generer</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>numero_dossard</th>
                            <th>genre</th>
                            <th>date_naissance</th>
                            <th>age</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($coureurs as $coureur)
                            <tr>
                                <td>{{ $coureur->nom }}</td>
                                <td>{{ $coureur->numero_dossard }}</td>
                                <td>{{ $coureur->genre }}</td>
                                <td>{{ $coureur->date_naissance }}</td>
                                <td>{{ $coureur->age }}</td>
                                <td>
                                    <form action="{{ route('categorie.genererCategorie') }}" method="get">
                                        <input type="hidden" name="id_coureur" value="{{ $coureur->id_coureur }}">
                                        <button type="submit" class="btn rounded-pill btn-success">Generer categorie</button>
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
