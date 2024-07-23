{{-- @include('partials.menu'); --}}
@extends('partials.menu')

@section('title')
    Bienvenue a l'Ultimate Team Race
@endsection

@section('meta-description')
    L'Ultimate Team Race est une compétition de course à pied unique en son genre, organisée sur deux jours et composée de plusieurs étapes palpitantes.
     Rejoignez-nous pour découvrir les équipes, suivre les étapes en direct et consulter les résultats en temps réel.
@endsection



<!-- Layout container -->
@section('content')
<div class="layout-page">

    @include('partials.navbar');

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">


        {{-- miova ho table --}}
        <div class="card">
            <img id="acc_img" src="{{ asset('assets/img/une-course-a-pieds-en-equipe-ultimate-team-race.png') }}"
            alt="Une course a pieds en equipe ultimate team race."
            style="
                width: 65%;
                margin-left: 14%;
                margin-top: 5%;
                        ">
            <h1 class="mb-0" id="acc_h1" style="
                                                font-size: xx-large;
                                                margin-top: 1%;
                                                margin-left: -9%;
                                                text-align: center;"
            ><small>Bienvenue à l'Ultimate Team Race!!</small></h1>

            <h2 class="mb-0" id="acc_h2" style="font-size: x-large;
                                                margin-left: 15%;
                                                margin-top: 4%;"
            ><small>La Course à Pied en Équipe sur 2 Jours</small></h2>

            <h3 class="mb-0" id="acc_h3" style="
                                                font-size: large;
                                                margin-top: 1%;
                                                margin-left: 15%;"
            ><small>Découvrez les Équipes, les Étapes et les Résultats</small></h3>

            <p class="mb-0" id="acc_para" style="
                                                font-size: small;
                                                margin-top: 1%;
                                                margin-left: 15%;
                                                padding-bottom: 3%;">
                L' <strong>Ultimate Team Race </strong> est une compétition de <strong>course à pied </strong> unique en son genre,
                organisée sur deux jours et composée <br> de plusieurs étapes palpitantes.
                Chaque équipe, composée de plusieurs coureurs, se relaie pour compléter chaque étape, <br>
                mettant à l'épreuve leur endurance, leur stratégie et leur esprit d'équipe.
                Découvrez les équipes participantes, <br> suivez le déroulement des étapes en direct et
                consultez les résultats en temps réel grâce à notre application web dédiée. <br>
                Rejoignez-nous dans cette aventure sportive exceptionnelle et vivez l'excitation de l'Ultimate Team Race ! <br>
            </p>
          </div>
      </div>
      <!-- / Content -->

      @include('partials.footer');

      <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
  </div>
  <!-- / Layout page -->
@endsection
