
@include('partials.menu');

<style>
    .highlight{
        background-color: pink;
    }
</style>
<!-- Layout container -->
<div class="layout-page">

    @include('partials.navbar');


    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
          <!-- Basic Layout -->
          <div class="col-xxl">
            <div class="card mb-4"
                style="    width: 65%;
                margin-left: 18%;">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Classement categorie</h5>
              </div>
              <div class="card-body">


                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Equipe</th>
                                <th>Coureur</th>
                                <th>points</th>
                                <th>duree</th>
                                <th>rang</th>
                            </tr>
                        </thead>
                        <?php
                            $pointsGroups = [];
                            foreach ($result as $resultat) {
                                $pointsGroups[$resultat->points][] = $resultat;
                            }
                        ?>
                        <tbody class="table-border-bottom-0">
                            @foreach ($result as $resultat)
                                <tr>
                                    <td>
                                        {{ $resultat->equipe }}
                                    </td>
                                    <td>{{ $resultat->nom }}</td>
                                    <td>{{ $resultat->points }}</td>
                                    <td>{{ $resultat->duree }}</td>
                                    <td>{{ $resultat->rang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <p> {{ $sum_points }} </p>

                    {{-- <div>
                        <canvas id="pieChart" data-labels="{{ json_encode($data['labels']) }}" data-values="{{ json_encode($data['values']) }}"></canvas>
                    </div> --}}

                    {{-- <div>
                        <h5 class="card-title">Camembert Chart</h5>

                        <!-- Pie Chart -->
                        <canvas id="camembertChart" style="max-width: 600px; max-height: 400px;"></canvas>
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                var equipe = {!! json_encode($data['equipe'])!!};
                                var points = {!! json_encode($data['point'])!!};

                                var ctx = document.getElementById('camembertChart').getContext('2d');
                                new Chart(ctx, {
                                    type: 'pie', // Change this to 'pie' for a pie chart
                                    data: {
                                        labels: equipe,
                                        datasets: [{
                                            data: points,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgb(255, 99, 132)',
                                                'rgb(54, 162, 235)',
                                                'rgb(255, 206, 86)',
                                                'rgb(75, 192, 192)',
                                                'rgb(153, 102, 255)',
                                                'rgb(255, 159, 64)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            title: {
                                                display: true,
                                                text: 'Répartition des Points par Équipe'
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    </div> --}}

                </div>

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

      <script src="{{ asset('assets/js_pie_chart/chart.js') }}"></script>
      <script src="{{ asset('assets/js_pie_chart/Chart.min.js') }}"></script>
      <script src="{{ asset('assets/js_pie_chart/vendor.bundle.base.js') }}"></script>

      <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
  </div>
  <!-- / Layout page -->
