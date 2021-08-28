@extends('backoffice.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  @include('backoffice.layout.navbar')

  <div class="uk-container uk-margin-large">
    <div class="uk-margin">
      <h2>{{ $title_page }}</h2>
    </div>

    <div class="uk-card uk-card-default uk-card-body">

      <table class="uk-table uk-table-striped uk-table-divider uk-table-middle uk-table-responsive">
        <tbody>
          <tr>
            <td class="uk-width-medium">Nama Lengkap</td>
            <td>: {{ $getResult->nama }}</td>
          </tr>
          <tr>
            <td class="uk-width-medium">Email</td>
            <td>: {{ $getResult->email }}</td>
          </tr>
          <tr>
            <td class="uk-width-medium">Role</td>
            <td class="uk-text-uppercase">: {{ $getResult->roles }}</td>
          </tr>
          <tr>
            <td class="uk-width-medium">Tanggal Registrasi</td>
            <td>: {{ $getResult->created_at->format('d M Y H:i') }}</td>
          </tr>
          <tr>
            <td class="uk-width-medium">Aktif</td>
            <td>:
              @if( $getResult->publish == 'Y' )
                <label class="uk-label uk-label-success">Ya</label>
              @else
                <label class="uk-label uk-label-danger">Tidak</label>
              @endif
            </td>
          </tr>
          @if( $getResult->id != \Session::get('user_detail')['id'] )
          <tr>
            <td class="uk-width-medium">Ubah Status Aktif</td>
            <td>
              <select class="uk-select" onchange="setPublish(this.value);">
                <option value="Y" {{ $getResult->publish == 'Y' ? 'selected' : '' }}>Aktif</option>
                <option value="N" {{ $getResult->publish == 'N' ? 'selected' : '' }}>Non Aktif</option>
              </select>
            </td>
          </tr>
          @endif
        </tbody>
      </table>

      <div class="uk-margin">
        <a href="{{ route('backoffice.users.index', ['user_type' => $getResult->roles]) }}" class="uk-button uk-button-default">Kembali</a>
      </div>

    </div>
  </div>

  <script type="text/javascript">
    let setPublish = async function(value)
    {
      let url     = `{{ route('backoffice.users.set_status', ['id' => $getResult->id]) }}`;
      let request = {
        status: value,
      };

      let fetchData = await fetch(url, {
        method: 'put',
        mode: 'cors',
        cache: 'no-cache',
        body: JSON.stringify(request),
        headers: {
          'content-type': 'application/json',
          'x-requested-with': 'XMLHttpRequest',
          'x-csrf-token': '{{ csrf_token() }}'
        }
      });

      if( fetchData.status == 201 )
      {
        let result = fetchData.json();
        swal({
          title: 'Berhasil',
          text: 'Berhasil mengubah status user',
          icon: 'success',
        });

        setTimeout(() => {
          document.location = '';
        }, 500);
      }
      else
      {
        swal({
          title: 'Gagal',
          text: 'Gagal mengubah status user',
          icon: 'error',
          dangerType: true
        });
      }
    }
  </script>
@endsection
