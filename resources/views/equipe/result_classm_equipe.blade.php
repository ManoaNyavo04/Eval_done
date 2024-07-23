
@include('partials.menu_equipe');


<!-- Layout container -->
<div class="layout-page">

    @include('partials.navbar');

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Affectation temps coureur</h4>

        {{-- miova ho table --}}
        <div class="card">
            <h5 class="card-header">Light Table head</h5>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Equipe</th>
                            <th>duree_equipe</th>
                            <th>Points</th>
                            <th>Rang</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($query as $classmEtape)
                            <tr>
                                <td>{{ $classmEtape->nom }}</td>
                                <td>{{ $classmEtape->duree }}</td>
                                <td>{{ $classmEtape->points }}</td>
                                <td>{{ $classmEtape->rang }}</td>
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
