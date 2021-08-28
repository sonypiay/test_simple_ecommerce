@extends('frontend.layout.master')
@section('meta_title', $title_page)
@section('script_js')
  <script type="text/javascript" src="{{ asset('js/modules/users.js') }}"></script>
@endsection
@section('main_content')
  @include('frontend.layout.navbar')

  <div class="uk-container uk-margin-large">
    <div class="uk-margin">
      <h2>{{ $title_page }}</h2>
    </div>

    <div class="uk-card uk-card-default uk-card-body">

      @if( \Session::has('alert') AND ! empty( \Session::get('alert') ) )
        <div class="uk-alert-{{ \Session::get('alert') == 'error' ? 'danger' : 'success' }}" uk-alert>
          {!! \Session::get('message') !!}
        </div>
      @endif

      <form class="uk-form-stacked" method="post" action="{{ route('frontend.user.change_password.update') }}" enctype="multipart/form-data"
      onsubmit="return onChangePassword();">
        {{ csrf_field() }}

        <div class="uk-margin">
          <label class="uk-form-label">Password Baru</label>
          <div class="uk-form-controls">
            <input type="password" class="uk-width-1-1 uk-input" id="new_password" name="new_password">
          </div>
          <div id="error-password"></div>
        </div>

        <div class="uk-margin">
          <label class="uk-form-label">Konfirmasi Password</label>
          <div class="uk-form-controls">
            <input type="password" class="uk-width-1-1 uk-input" id="confirm_password" name="confirm_password">
          </div>
          <div id="error-confirm-password"></div>
        </div>

        <div class="uk-margin">
          <button type="submit" class="uk-button uk-button-primary">Ganti Password</button>
        </div>

      </form>

    </div>
  </div>
@endsection
