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

      <form class="uk-form-stacked" method="post" action="{{ route('backoffice.profile.update') }}" enctype="multipart/form-data"
      onsubmit="return onValidateEditProfile();">
        {{ csrf_field() }}

        <div class="uk-margin">
          <label class="uk-form-label">Nama Lengkap</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input" id="nama" name="nama" value="{{ $getResult->nama  }}">
          </div>
          <div id="error-nama"></div>
        </div>

        <div class="uk-margin">
          <label class="uk-form-label">Email</label>
          <div class="uk-form-controls">
            <input type="email" class="uk-width-1-1 uk-input" id="email" name="email" value="{{ $getResult->email }}">
          </div>
          <div id="error-email"></div>
        </div>

        <div class="uk-margin">
          <button type="submit" class="uk-button uk-button-primary">Simpan</button>
        </div>

      </form>

    </div>
  </div>
@endsection
