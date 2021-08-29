@extends('frontend.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  @include('frontend.layout.navbar')

  <div class="uk-container uk-margin-large">
    <div class="uk-margin">
      <h2>{{ $title_page }}</h2>
    </div>

    <div class="uk-card uk-card-default uk-card-body">
      <h3>Informasi Transaksi</h3>
      <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
        <tbody>
          <tr>
            <td>No. Transaksi</td>
            <td>: {{ $getDetailTransaction->transaction_no }}</td>
          </tr>
          <tr>
            <td>Tanggal Transaksi</td>
            <td>: {{ $getDetailTransaction->created_at->format('d M Y H:i') }}</td>
          </tr>
          <tr>
            <td>Qty</td>
            <td>: {{ $getDetailTransaction->total_qty }}</td>
          </tr>
          <tr>
            <td>Grand Total</td>
            <td>: Rp. {{ number_format( $getDetailTransaction->total_price ) }}</td>
          </tr>
        </tbody>
      </table>
      <hr>
      <h3>Produk</h3>
      <table class="uk-table uk-table-divider uk-table-striped uk-table-small uk-table-middle uk-table-responsive">
        <thead>
          <tr>
            <th>Nama Produk</th>
            <th>Foto</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach( $getItemTransaction as $index => $item )
            <tr>
              <td>{{ $item->product_name }}</td>
              <td class="uk-width-small">
                <img class="uk-width-1-3" src="{{ asset('storage/produk/' . $item->product_image) }}" alt="" />
              </td>
              <td class="uk-width-small">{{ $item->total_qty }}</td>
              <td>Rp. {{ number_format( $item->price ) }}</td>
              <td>Rp. {{ number_format( $item->subtotal_price ) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="uk-margin">
        <a href="{{ route('frontend.user.transaction.index') }}" class="uk-button uk-button-small uk-button-primary">
          Kembali
        </a>
      </div>
    </div>
  </div>
@endsection
