<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.7.2/dist/css/uikit.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script type="text/javascript">
  var APP_URL   = `{{ url('/') }}`;
  var APP_TOKEN = `{{ csrf_token() }}`;
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.7.2/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.7.2/dist/js/uikit-icons.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
<script src="{{ asset('js/app-user.js') }}" type="text/javascript"></script>
