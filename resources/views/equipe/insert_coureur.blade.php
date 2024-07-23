
@include('partials.menu_equipe',['userId' => $userId]);


<!-- Layout container -->
<div class="layout-page">

    @include('partials.navbar');

    <!-- Content wrapper -->
    <div class="content-wrapper">
      <!-- Content -->

      <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>User Id : {{$userId}}</h4>

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Affectation coureur</h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
          <!-- Basic Layout -->
          <div class="col-xxl">
            <div class="card mb-4"
                style="    width: 65%;
                margin-left: 18%;">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Insertion coureur</h5>
              </div>
              <div class="card-body">

                <form action="{{ route('etape.insertCoureurEtape', ['userId' => $userId]) }}" method="POST">
                    @csrf
                    <p>etape: {{ $id_etape }}</p>
                    <input type="hidden" name="etape" value="{{ $id_etape }}">

                    {{-- @foreach($coureurEquip as $coureur)
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="coureurs[]" value="{{ $coureur->id_coureur }}" id="defaultCheck1" />
                            <label class="form-check-label" for="defaultCheck1"> {{ $coureur->nom }} </label>
                        </div>
                    @endforeach --}}


                    <div class="mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Coureur</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="exampleFormControlSelect1" name="coureur" aria-label="Default select example">
                                @foreach($coureurEquip as $coureur)
                                    <option value="{{ $coureur->id_coureur }}">{{ $coureur->nom }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>


                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </div>
                </form>

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

