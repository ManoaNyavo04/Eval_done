
@include('partials.menu_equipe', ['userId' => $userId]);


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
                <h5 class="mb-0">Classement par categorie</h5>
              </div>
              <div class="card-body">

                <form action="{{ route('classement.get_calssement', ['userId' => $userId]) }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Categorie</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="idcategorie">
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
