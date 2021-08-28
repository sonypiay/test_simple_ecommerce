@extends('backoffice.layout.master')
@section('meta_title', $title_page)
@section('script_js')
  <script type="text/javascript" src="{{ asset('js/modules/product.js') }}"></script>
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
          <label class="uk-form-label">Kode Produk</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input" id="kode_produk" name="kode_produk" value="{{ $getResult ? $getResult->product_code : request()->old('kode_produk') }}">
          </div>
          <div id="error-kode-produk"></div>
        </div>

        <div class="uk-margin">
          <label class="uk-form-label">Nama Produk</label>
          <div class="uk-form-controls">
            <input type="text" class="uk-width-1-1 uk-input" id="nama_produk" name="nama_produk" value="{{ $getResult ? $getResult->product_name : request()->old('nama_produk') }}">
          </div>
          <div id="error-nama-produk"></div>
        </div>

        <div class="uk-margin">
          <label class="uk-form-label">Harga</label>
          <div class="uk-form-controls">
            <input type="number" min="1000" class="uk-width-1-1 uk-input" id="harga_produk" name="harga_produk" value="{{ $getResult ? $getResult->price : request()->old('harga_produk') }}">
          </div>
          <div id="error-harga-produk"></div>
        </div>

        <div class="uk-margin">
          <label class="uk-form-label">Foto</label>
          <div class="uk-form-controls">
            @if( $getResult && ! empty( $getResult->product_image ) )
              <div class="uk-margin">
                <img src="{{ asset('storage/produk/' . $getResult->product_image) }}" class="uk-width-1-6@s">
              </div>
            @endif
            <input type="file" id="foto_produk" accept="image/*" name="foto_produk">
          </div>
          <div id="error-foto-produk"></div>
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
          <a href="{{ route('backoffice.product.index') }}" class="uk-button uk-button-default">Kembali</a>
        </div>

      </form>

    </div>
  </div>
@endsection
