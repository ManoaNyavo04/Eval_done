
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
            <h5 class="card-header">Details points</h5>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>nom_etape</th>
                            <th>nom_coureur</th>
                            <th>duree</th>
                            <th>points</th>
                            <th>rang</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($det as $details)
                            <tr>
                                <td>{{ $details->nom_etape }}</td>
                                <td>{{ $details->nom_coureur }}</td>
                                <td>{{ $details->duree }}</td>
                                <td>{{ $details->points }}</td>
                                <td>{{ $details->rang }}</td>
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
