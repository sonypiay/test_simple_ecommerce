@extends('backoffice.layout.master')
@section('meta_title', $title_page)
@section('script_js')
  <script type="text/javascript" src="{{ asset('js/modules/users.js') }}"></script>
@endsection
@section('main_content')
  @include('backoffice.layout.navbar')

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

      <form class="uk-form-stacked" method="post" action="{{ $url_action }}" enctype="multipart/form-data"
      onsubmit="return onValidateCreateOrUpdate(`{{ $action_name }}`);">
        {{ csrf_field() }}
        <input type="hidden" name="action_name" value="{{ $action_name }}">

        <div class="uk-margin">
          <label class="uk-form-label">Nama Lengkap</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input" id="nama" name="nama" value="{{ $getResult ? $getResult->nama : request()->old('nama') }}">
          </div>
          <div id="error-nama"></div>
        </div>

        <div class="uk-margin">
          <label class="uk-form-label">Email</label>
          <div class="uk-form-controls">
            <input type="email" class="uk-width-1-1 uk-input" id="email" name="email" value="{{ $getResult ? $getResult->email : request()->old('email') }}">
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
          <label class="uk-form-label">Tampilkan</label>
          <div class="uk-form-controls">
            <select class="uk-width-1-1 uk-select" id="publish" name="publish">
              <option value="Y" @if( $getResult && $getResult->publish == 'Y' ) selected @endif>Ya</option>
              <option value="N" @if( $getResult && $getResult->publish == 'N' ) selected @endif>Tidak</option>
            </select>
          </div>
        </div>

        <div class="uk-margin">
          <button type="submit" class="uk-button uk-button-primary">Simpan</button>
          <a href="{{ route('backoffice.users.index') }}?user_type=admin" class="uk-button uk-button-default">Kembali</a>
        </div>

      </form>

    </div>
  </div>
@endsection
