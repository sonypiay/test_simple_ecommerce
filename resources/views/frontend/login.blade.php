@extends('frontend.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  <div class="uk-container">
    <div class="uk-width-1-3@s uk-align-center">
      <div class="uk-card uk-card-body uk-card-default uk-margin-large-top">
        <h3 class="uk-text-center">Login</h3>

        @if( \Session::has('alert') AND ! empty( \Session::get('alert') ) )
          <div class="uk-alert-{{ \Session::get('alert') == 'error' ? 'danger' : 'success' }}" uk-alert>
            {!! \Session::get('message') !!}
          </div>
        @endif

        <form class="uk-form-stacked" method="post" action="{{ route('frontend.login.dologin') }}" onsubmit="return Users.onValidateLogin();">
          {{ csrf_field() }}

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
            <label class="uk-form-label">Login Sebagai</label>
            <div class="uk-form-controls">
              <select class="uk-width-1-1 uk-select" name="user_type">
                <option value="admin">Administrator</option>
                <option value="user">User</option>
              </select>
            </div>
          </div>

          <div class="uk-margin">
            <input type="submit" class="uk-width-1-1 uk-button uk-button-primary" value="Login">
          </div>
          <div class="uk-margin-top uk-text-center">
            <a href="{{ route('frontend.register.index') }}">Belum punya akun? Registrasi disini</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
