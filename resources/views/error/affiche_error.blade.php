
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
            <h5 class="card-header">Gestion Erreur</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Ligne</th>
                            <th>Valeur</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($errors as $error)
                            <tr>
                                <td>{{ $error->numligne }}</td>
                                <td>{{ $error->valeur }}</td>
                                <td>{{ $error->typeerreur }}</td>
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
