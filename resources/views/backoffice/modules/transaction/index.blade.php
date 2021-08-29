@extends('backoffice.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  @include('backoffice.layout.navbar')

  <div class="uk-container uk-margin-large">
    <h2>Daftar Transaksi</h2>

    <div class="uk-card uk-card-body uk-card-default uk-margin-top">
      <form class="uk-form-stacked" method="get" action="{{ route('backoffice.transaction.index') }}">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-1">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-6">
                <label class="uk-form-label">Kata kunci: </label>
              </div>
              <div class="uk-width-expand">
                <input type="search" class="uk-width-1-4@s uk-input" name="keywords" value="{{ request()->keywords }}" placeholder="Cari transaksi ...">
              </div>
            </div>
          </div>

          <div class="uk-width-1-1">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-6">
                <label class="uk-form-label">Tanggal Transaksi: </label>
              </div>
              <div class="uk-width-expand">
                <input type="text" class="uk-width-1-4@s uk-input" id="rangedate" />

                <input type="hidden" id="start_date" name="start_date" value="" />
                <input type="hidden" id="end_date" name="end_date" value="" />
              </div>
            </div>
          </div>
        </div>

        <div class="uk-margin">
          <input type="submit" class="uk-button uk-button-small uk-button-primary" value="Filter">
          <a href="{{ route('backoffice.transaction.export_xls') }}" class="uk-button uk-button-default uk-button-small">Export XLS</a>
        </div>
      </form>

      @if( $getResult->total() > 0 )
        <table class="uk-table uk-table-divider uk-table-striped uk-table-small uk-table-middle uk-table-responsive">
          <thead>
            <tr>
              <th>Nama</th>
              <th>No. Transaksi</th>
              <th>Produk</th>
              <th>Foto</th>
              <th>Qty</th>
              <th>Subtotal</th>
              <th>Tanggal Transaksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach( $getResult as $index => $item )
              <tr>
                <td>{{ $item->nama }}</td>
                <td>
                  <a href="{{ route('backoffice.transaction.index', ['transaction_id' => $item->transaction_id]) }}">
                    {{ $item->transaction_no }}
                  </a>
                </td>
                <td>{{ $item->product_name }}</td>
                <td class="uk-width-small">
                  <img class="uk-width-1-3" src="{{ asset('storage/produk/' . $item->product_image) }}" alt="" />
                </td>
                <td class="uk-width-small">{{ $item->total_qty }}</td>
                <td>Rp. {{ number_format( $item->total_price ) }}</td>
                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="uk-margin">
          <ul class="uk-pagination">
            <li>
              <a class="uk-button uk-button-small uk-button-default" href="{{ $getResult->previousPageUrl() }}">
                <span uk-icon="chevron-left"></span>
              </a>
            </li>
            <li>
              <a class="uk-button uk-button-small uk-button-default" href="{{ $getResult->nextPageUrl() }}">
                <span uk-icon="chevron-right"></span>
              </a>
            </li>
          </ul>
        </div>
      @else
        <div class="uk-alert-warning" uk-alert>
          Tidak ada transaksi.
        </div>
      @endif
    </div>
  </div>

  <script type="text/javascript">
    $("#rangedate").flatpickr({
      mode: 'range',
      maxDate: 'today',
      dateFormat: 'd F Y',
      inline: false,
      onChange: function( selectedDate, dateStr, instance )
      {
        var start_date  = selectedDate[0] ? selectedDate[0] : '';
        var end_date    = selectedDate[1] ? selectedDate[1] : '';

        document.querySelector('#start_date').value = formatDate( start_date );
        document.querySelector('#end_date').value   = formatDate( end_date );
      },
      @if( ! empty( request()->start_date ) AND ! empty( request()->end_date ) )
        @php $start_date  = date('d F Y', strtotime( request()->start_date )); @endphp
        @php $end_date    = date('d F Y', strtotime( request()->end_date )); @endphp
        defaultDate: ["{{ $start_date }}", "{{ $end_date }}"]
      @endif
    });
  </script>
@endsection
