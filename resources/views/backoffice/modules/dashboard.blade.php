@extends('backoffice.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  @include('backoffice.layout.navbar')

  <div class="uk-container uk-margin-large-top">
    <div class="uk-card uk-card-default uk-card-body">
      <h2>
        Selamat Datang, {{ $getUserDetail->nama }}. <br>
        Ini adalah Halaman Administrator
      </h2>
    </div>
  </div>
@endsection
