
{{-- @include('partials.menu'); --}}

@extends('partials.menu')

@section('title')
    Le classement general des equipes pour chaque categorie
@endsection

@section('meta-description')
    Voici le classement general des equipes pour chaque categorie,
    avec un trie par categorie
@endsection



<!-- Layout container -->
@section('content')
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
                <h1 class="mb-0" id="acc_h1" style="
                                font-size: x-large;
                                margin-top: 1%;
                                margin-left: 3%;"
                ><small>Le classement general des equipes pour chaque categorie</small></h1>

                </h5>
              </div>
              <div class="card-body">

                <form action="{{ route('classement.get_calssementAdmin') }}" id="classement-form" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Categorie</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="categorie-select" aria-label="Default select example" name="idcategorie">
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id_categorie }}">{{ $categorie->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Voir</button>
                        </div>
                    </div>
                </form>

                <div id="resultat" class="table-responsive text-nowrap mt-4">
                    <!-- Les résultats et le graphique seront insérés ici -->
                </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        $('#classement-form').on('submit', function(event) {
            event.preventDefault();
            var idcategorie = $('#categorie-select').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('classement.get_calssementAdmin') }}",
                method: "POST",
                data: {
                    idcategorie: idcategorie,
                    _token: _token
                },
                success: function(data) {
                    // Construire le tableau des résultats
                    var tableRows = data.result.map(resultat => {
                        var url = `{{ route('classement.details_points_eq_cate', ['id_categorie' => ':idcategorie', 'id_equipe' => ':id_equipe']) }}`;
                        url = url.replace(':idcategorie', idcategorie).replace(':id_equipe', resultat.id_equipe);


                        return `
                            <tr>
                                <td>
                                    <a href="${url}">
                                        ${resultat.nom}
                                    </a>
                                </td>
                                <td>${resultat.points}</td>
                                <td>${resultat.duree}</td>
                                <td>${resultat.rang}</td>
                            </tr>
                        `;
                    }).join('');

                    $('#resultat').html(`
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Points</th>
                                    <th>Duree</th>
                                    <th>Rang</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                ${tableRows}
                            </tbody>
                        </table>
                        <div>
                            <canvas id="pieChart"></canvas>
                        </div>
                    `);

                    // Générer le graphique en secteurs (pie chart)
                    var ctx = document.getElementById('pieChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.values,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#resultat').html('<p>Une erreur est survenue.</p>');
                }
            });
        });
    });
</script>

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

  @endsection


