
@include('partials.menu');


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
                <small class="text-muted float-end">Default label</small>
              </div>
              <div class="card-body">

                <form action="{{ route('temps_coureur.insertTempsCoureur') }}" method="POST">
                    @csrf
                    <p>Etape: {{ $idetape }}</p>
                    <input type="hidden" name="etape" value="{{ $idetape }}">
                    @foreach ($coureur as $courera)
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label" for="coureur-{{ $courera->id_coureur }}">Coureur</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="coureur_ids[]" value="{{ $courera->id_coureur }}">
                                <input type="text" class="form-control" id="coureur-{{ $courera->id_coureur }}" value="{{ $courera->nom_coureur }}" disabled>
                            </div>
                        </div>

                        {{-- <div class="mb-3 row">
                            <label for="depart-{{ $courera->id_coureur }}" class="col-md-2 col-form-label">Depart</label>
                            <div class="col-md-10">
                                <input
                                    class="form-control"
                                    type="datetime-local"
                                    name="departs[{{ $courera->id_coureur }}]"
                                    id="depart-{{ $courera->id_coureur }}"
                                />
                            </div>
                        </div> --}}

                        <div class="mb-3 row">
                            <label for="arrive-{{ $courera->id_coureur }}" class="col-md-2 col-form-label">Arrive</label>
                            <div class="col-md-10">
                                <input
                                    class="form-control"
                                    type="datetime-local"
                                    name="arrives[{{ $courera->id_coureur }}]"
                                    id="arrive-{{ $courera->id_coureur }}"
                                />
                            </div>
                        </div>
                    @endforeach

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">VALIDER</button>
                        </div>
                    </div>
                </form>


                {{-- <form action="{{ route('temps_coureur.insertTempsCoureur') }}" method="POST">
                    @csrf
                    {{-- <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Etape</label>
                        <div class="col-sm-10">
                            <select id="defaultSelect" class="form-select" name="etape">
                                @foreach ($etape as $etapy)
                                    <option value="{{ $etapy->id_etape }}">{{ $etapy->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p>etape: {{ $idetape }}</p>
                    <input type="hidden" name="etape" value="{{ $idetape }}">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Coureur</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="coureur">
                                @foreach ($coureur as $courera)
                                    <option value="{{ $courera->id_coureur }}">{{ $courera->nom_coureur }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Depart</label>
                        <div class="col-md-10">
                          <input
                            class="form-control"
                            type="datetime-local"
                            name="depart"
                            id="html5-datetime-local-input"
                          />
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="html5-datetime-local-input" class="col-md-2 col-form-label">Arrive</label>
                        <div class="col-md-10">
                          <input
                            class="form-control"
                            type="datetime-local"
                            name="arrive"
                            id="html5-datetime-local-input"
                          />
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">VALIDER</button>
                        </div>
                    </div>
                </form> --}}

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

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
