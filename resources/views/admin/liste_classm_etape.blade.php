
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
            <h5 class="card-header">Classement general par etape</h5>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Nom coureur</th>
                            <th>Duree</th>
                            <th>Rang</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($query as $classmEtape)
                            <tr>
                                <td>{{ $classmEtape->nom_coureur }}</td>
                                <td>{{ $classmEtape->duree }}</td>
                                <td>{{ $classmEtape->rang }}</td>
                                <td>{{ $classmEtape->points }}</td>
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
