
@include('partials.menu_equipe', ['userId' => $userId]);


<!-- Layout container -->
<div class="layout-page">

    @include('partials.navbar');

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Affectation temps coureur</h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
          <!-- Basic Layout -->
          <div class="col-xxl">
            <div class="card mb-4"
                style="    width: 65%;
                margin-left: 18%;">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Insertion temps coureur</h5>
              </div>
              <div class="card-body">


                @if ($result)


                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>points</th>
                                <th>duree</th>
                                <th>rang</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($result as $resultat)
                                <tr>
                                    <td>{{ $resultat->nom }}</td>
                                    <td>{{ $resultat->points }}</td>
                                    <td>{{ $resultat->duree }}</td>
                                    <td>{{ $resultat->rang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                @endif

                {{-- @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif --}}

                @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif
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
  <!-- / Layout page -->
