
{{-- @include('partials.menu'); --}}

@extends('partials.menu')

@section('title')
    Resultat du classement general par equipe
@endsection

@section('meta-description')
    Resultat du classement general par equipe, points, duree parcouru et rang de l'equipe
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
            <h1 class="mb-0" id="acc_h1" style="
                                font-size: x-large;
                                margin-top: 1%;
                                margin-left: 3%;"
                ><small>Resultat du classement general par equipe</small></h1>

            <div class="table-responsive text-nowrap">

                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Equipe</th>
                            <th>duree_equipe</th>
                            <th>points</th>
                            <th>Rang</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($query as $classmEtape)
                            <tr>
                                <td>
                                    <form action="{{ route('alea.detailPointEquipe') }}" method="get">
                                        @csrf
                                        <input type="hidden" name="id_equipe" value="{{$classmEtape->id_equipe}}">
                                        <input type="submit" value="{{$classmEtape->nom }}">
                                    </form>
                                {{-- <td>{{ $classmEtape->nom }}</td> --}}
                                <td>{{ $classmEtape->duree }}</td>
                                <td>{{ $classmEtape->points }}</td>
                                <td>{{ $classmEtape->rang }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div>
                    <canvas id="pieChart" data-labels="{{ json_encode($data['labels']) }}" data-values="{{ json_encode($data['values']) }}"></canvas>
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
  @endsection
