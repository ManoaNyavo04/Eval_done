
create view v_penalite_ajouter as(
    SELECT
        penalite.id_penalite,
        penalite.id_etape,
        penalite.id_equipe,
        penalite.heure_penalite,
        etape.nom AS etape,
        equipe.nom AS equipe
    FROM
        penalite
    JOIN
        etape ON etape.id_etape = penalite.id_etape
    JOIN
        equipe ON equipe.id_equipe = penalite.id_equipe
);

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des coureurs</title>
    <style>
        .highlight {
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
            @include('partials.menu')
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"></h4>
                <p class="card-description">
                  {{-- Add class <code>.table</code> --}}
                </p>
                {{-- <div class="table-responsive"> --}}
                  <table class="table">
                    <thead>
                      <tr>
                        <th>nom coureur</th>
                        <th>genre</th>
                        <th>chrono</th>
                        <th>penalite</th>
                        <th>rang</th>
                        <th>temps final</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($resultats as $result)
                      <tr @if ($result->rang == 1) class="highlight" @endif>
                        <td>{{ $result->nom }}</td>
                        <td>{{ $result->genre }}</td>
                        <td>{{ $result->chrono }}</td>
                        <td>{{ $result->penalite }}</td>
                        <td>{{ $result->rang }}</td>
                        <td>{{ $result->temps_final }}</td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>liste des coureurs</title>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <style>
        .highlight {
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
            @include('partials.menu')
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"></h4>
                <p class="card-description">
                  {{-- Add class <code>.table</code> --}}
                </p>
                {{-- <div class="table-responsive"> --}}
                  <table class="table">
                    <thead>
                      <tr>
                        <th>nom </th>
                        <th>points</th>
                        <th>duree</th>
                        <th>rang</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $pointsGroups = [];
                    foreach ($classement as $cl) {
                        $pointsGroups[$cl->points][] = $cl;
                    }
                    ?>
                    @foreach ($classement as $cl)
                      <tr @if (count($pointsGroups[$cl->points]) > 1) class="highlight" @endif>
                        <td>{{ $cl->nom }}</td>
                        <td>{{ $cl->points }}</td>
                        <td>{{ $cl->duree }}</td>
                        <td>{{ $cl->rang }}</td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Pie Chart</h4>
                      <canvas id="pieChart" data-labels="{{ json_encode($data['labels']) }}" data-values="{{ json_encode($data['values']) }}"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>

</body>
</html>

-- <?php
--     $color="blue";
--     foreach($list as $row) {
--         if($row["effectue"] > 50){
--             $color = "green";
--         }
--         if($row["effectue"] < 50){
--             $color = "red";
--         }
-- ?>
-- <tr style="color: <?= $color ?> ;">
--     <td> Colonne </td>
--     <td> Colonne </td>
-- </tr>
-- <?php } ?>



/*create or replace view v_somme_penalite_etape_equipe as(
    SELECT
        p.id_etape,
        p.id_equipe,
        sum(p.temps_penalite) as pena_etape_equipe
    from penalite p
    GROUP by
        p.id_etape,
        p.id_equipe
);

select
    ct.id_coureur,
    ct.id_etape,
    c.id_equipe,
    spee.pena_etape_equipe,
    (ct.duree+spee.pena_etape_equipe) as new_duree
from coureur_temps ct
left join penalite p on p.id_etape=ct.id_etape
join v_somme_penalite_etape_equipe spee on spee.id_etape=ct.id_etape
join coureur c on c.id_coureur=ct.id_coureur
where c.id_equipe=2
group by
    ct.id_coureur,
    ct.id_etape,
    spee.pena_etape_equipe,
    ct.duree,
    c.id_equipe
order by
    ct.id_etape,
    ct.id_coureur;




