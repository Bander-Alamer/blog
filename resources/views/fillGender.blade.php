@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('fillGender') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('fillGender') }}">
                        @csrf
                        @method('PUT')
                        <fieldset class="form-group">
                            <div class="row">
                              <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                              <div class="col-sm-10">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="gender" id="gender1" value="male" checked>
                                  <label class="form-check-label" for="gridRadios1">
                                    Male
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="gender" id="gender2" value="female">
                                  <label class="form-check-label" for="gridRadios2">
                                    Female
                                  </label>
                                </div>
                              </div>
                            </div>
                          </fieldset>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('update') }}
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
