@extends('frontend.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  <div class="uk-container">
    <div class="uk-width-1-3@s uk-align-center">
      <div class="uk-card uk-card-body uk-card-default uk-margin-large-top">
        <h3 class="uk-text-center">Registrasi</h3>

        @if( \Session::has('alert') AND ! empty( \Session::get('alert') ) )
          <div class="uk-alert-{{ \Session::get('alert') == 'error' ? 'danger' : 'success' }}" uk-alert>
            {!! \Session::get('message') !!}
          </div>
        @endif

        <form class="uk-form-stacked" method="post" action="{{ route('frontend.register.create') }}" onsubmit="return Users.onValidateUserRegiter();">
          {{ csrf_field() }}

          <div class="uk-margin">
            <label class="uk-form-label">Nama Lengkap</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input" name="fullname" value="{{ request()->old('fullname') }}" id="fullname" />
            </div>
            <div id="error-fullname"></div>
          </div>

          <div class="uk-margin">
            <label class="uk-form-label">Email</label>
            <div class="uk-form-controls">
              <input type="email" class="uk-width-1-1 uk-input" name="email" value="{{ old('email') }}" id="email" />
            </div>
            <div id="error-email"></div>
          </div>

          <div class="uk-margin">
            <label class="uk-form-label">Password</label>
            <div class="uk-form-controls">
              <input type="password" class="uk-width-1-1 uk-input" name="password" value="{{ old('password') }}" id="password" />
            </div>
            <div id="error-password"></div>
          </div>

          <div class="uk-margin">
            <input type="submit" class="uk-width-1-1 uk-button uk-button-primary" value="Registrasi">
          </div>
          <div class="uk-margin-top uk-text-center">
            <a href="{{ route('frontend.login.index') }}">Sudah punya akun? Login disini</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
