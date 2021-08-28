@extends('backoffice.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  @include('backoffice.layout.navbar')

  <div class="uk-container uk-margin-large-top">
    <div class="uk-margin">
      <h2>
        @if( $user_type == 'admin' )
          Admin
          <div class="uk-float-right">
            <a class="uk-button uk-button-small uk-button-primary" href="{{ route('backoffice.users.create_page') }}">
              Tambah Admin
            </a>
          </div>
        @else
          Users
        @endif
      </h2>
    </div>

    <div class="uk-clearfix"></div>

    <div class="uk-card uk-card-default uk-card-body">
      <form class="uk-form-stacked" method="get" action="{{ route('backoffice.users.index') }}">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-5">
            <label class="uk-form-label">Kata kunci: </label>
          </div>
          <div class="uk-width-expand">
            <input type="search" class="uk-width-1-4@s uk-input" name="keywords" value="{{ request()->keywords }}" placeholder="Cari users ...">
          </div>
        </div>
      </form>

      <div class="uk-margin">
        @if( $getResult->total() == 0 )
          <div class="uk-alert-warning uk-margin" uk-alert>
            Tidak ada data.
          </div>
        @endif

        <table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-table-responsive">
          <thead>
            <tr>
              <th>Aksi</th>
              <th>Nama Lengkap</th>
              <th>Email</th>
              <th>Tampilkan</th>
              <th>Tanggal Registrasi</th>
            </tr>
          </thead>
          <tbody>
            @foreach( $getResult as $data )
              <tr>
                <td>
                  <a href="{{ route('backoffice.users.view', ['id' => $data->id]) }}" class="uk-icon-button" uk-icon="forward"></a>
                  @if( $user_type == 'admin' )
                    <a href="{{ route('backoffice.users.edit_page', ['id' => $data->id]) }}" class="uk-icon-button" uk-icon="pencil"></a>
                    <a onclick="onDelete(`{{ $data->id }}`, `{{ $data->nama }}`)" class="uk-icon-button" uk-icon="trash"></a>
                  @endif
                </td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->email }}</td>
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
        text: `Apakah anda ingin menghapus user ${name}?`,
        icon: 'warning',
        buttons: true
      }).then( willConfirm => {
        if( willConfirm )
        {
          let url = `{{ route('backoffice.users.delete') }}?id=${id}&user_type={{ $user_type }}`;
          document.location = url;
        }
      });
    }
  </script>
@endsection
