@extends('backoffice.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  @include('backoffice.layout.navbar')

  <div class="uk-container uk-margin-large-top">
    <div class="uk-margin">
      <h2>
        Produk
        <div class="uk-float-right">
          <a class="uk-button uk-button-small uk-button-primary" href="{{ route('backoffice.product.create_page') }}">
            Tambah Produk
          </a>
        </div>
      </h2>
    </div>

    <div class="uk-clearfix"></div>

    <div class="uk-card uk-card-default uk-card-body">
      <form class="uk-form-stacked" method="get" action="{{ route('backoffice.product.index') }}">
        <div class="uk-form-controls">
          <input type="search" class="uk-width-1-4@s uk-input" name="keywords" value="{{ request()->keywords }}" placeholder="Cari produk ...">
        </div>
      </form>

      <div class="uk-margin">
        @if( $getProduct->total() == 0 )
          <div class="uk-alert-warning uk-margin" uk-alert>
            Tidak ada data.
          </div>
        @endif

        <table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-table-responsive">
          <thead>
            <tr>
              <th>Aksi</th>
              <th>Kode Produk</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th class="uk-width-small">Foto</th>
              <th>Tampilkan</th>
              <th>Tanggal Input</th>
            </tr>
          </thead>
          <tbody>
            @foreach( $getProduct as $data )
              <tr>
                <td>
                  <a href="{{ route('backoffice.product.edit_page', ['id' => $data->id]) }}" class="uk-icon-button" uk-icon="pencil"></a>
                  <a onclick="onDelete(`{{ $data->id }}`, `{{ $data->product_name }}`)" class="uk-icon-button" uk-icon="trash"></a>
                </td>
                <td>{{ $data->product_code }}</td>
                <td>{{ $data->product_name }}</td>
                <td>Rp. {{ number_format( $data->price ) }}</td>
                <td>
                  <img src="{{ asset('storage/produk/' . $data->product_image) }}" alt="" class="uk-width-1-2" />
                </td>
                <td>
                  @if( $data->publish == 'Y' )
                    <label class="uk-label uk-label-success">Ya</label>
                  @else
                    <label class="uk-label uk-label-danger">Tidak</label>
                  @endif
                </td>
                <td>{{ $data->created_at->format('d M Y H:i') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    let onDelete = function(id, name)
    {
      swal({
        title: 'Konfirmasi',
        text: `Apakah anda ingin menghapus produk ${name}?`,
        icon: 'warning',
        buttons: true
      }).then( willConfirm => {
        if( willConfirm )
        {
          let url = `{{ route('backoffice.product.delete') }}?id=${id}`;
          document.location = url;
        }
      });
    }
  </script>
@endsection
