<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les penalites obtenus par equipe</title>
    <meta name="description" content="Listes des penalites obtenus par equipe avec l'etape, l'equipe, et le temps de penalite">
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    @include('partials.menu')


    <!-- Layout container -->
    <div class="layout-page">

        @include('partials.navbar')

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <h1 class="mb-0" id="acc_h1" style="
                                    font-size: x-large;
                                    margin-top: 1%;
                                    margin-left: 3%;"
                    ><small>Liste des penalites obtenus par equipe</small></h1>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addPenaltyModal">
                            Ajouter
                        </button>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Etape</th>
                                    <th>Equipe</th>
                                    <th>Temps penalite</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($penalites as $penalite)
                                    <tr>
                                        <td>{{ $penalite->etape }}</td>
                                        <td>{{ $penalite->equipe }}</td>
                                        <td>{{ $penalite->heure_penalite }}</td>
                                        <td>
                                            <a href="{{ route('penalite.delete', ['id_etape' => $penalite->id_etape, 'id_equipe' => $penalite->id_equipe]) }}" class="btn rounded-pill btn-danger delete-confirm" data-etape="{{ $penalite->etape }}" data-equipe="{{ $penalite->equipe }}">Supprimer</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal for Adding Penalty -->
            <div class="modal fade" id="addPenaltyModal" tabindex="-1" role="dialog" aria-labelledby="addPenaltyModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPenaltyModalLabel">Ajouter pénalité</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('penalite.insertPenalite') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="equipe">Etape</label>
                                    <select name="id_etape" id="id_etape" class="form-control">
                                        @foreach ($etapes as $etape)
                                            <option value="{{ $etape->id_etape }}">{{ $etape->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="temps">Equipe</label>
                                    <select name="id_equipe" id="id_equipe" class="form-control">
                                        @foreach ($equipes as $equipe)
                                            <option value="{{ $equipe->id_equipe }}">{{ $equipe->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="etape">Temps ajouté</label>
                                    <input type="text" class="form-control" id="temps" name="temps" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Content -->

            @include('partials.footer')

            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
    </div>

    <!-- / Layout page -->

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-confirm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const etape = this.getAttribute('data-etape');
                    const equipe = this.getAttribute('data-equipe');
                    const confirmation = confirm(`Voulez-vous vraiment supprimer la pénalité pour l'étape ${etape} et l'équipe ${equipe} ?`);

                    if (confirmation) {
                        window.location.href = this.href;
                    }
                });
            });
        });
    </script>

</body>
</html>
