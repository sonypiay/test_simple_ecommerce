<!DOCTYPE html>
<html lang="id">
<head>
  @include('backoffice.layout.meta')
  @include('backoffice.layout.script-assets')
  @yield('script_js')
  <title>@yield('meta_title')</title>
</head>
<body>
  @yield('main_content')

  @if( \Session::has('alert') AND ! empty( \Session::get('alert') ) )
  <script type="text/javascript">
    swal(`{!! \Session::get('message') !!}`, {
      title: 'Berhasil',
      icon: `{{ \Session::get('alert') }}`,
      timer: 2000
    });
  </script>
  @endif
</body>
</html>
