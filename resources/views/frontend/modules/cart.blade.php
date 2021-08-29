@extends('frontend.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  @include('frontend.layout.navbar')

  <div class="uk-container uk-margin-large">
    @if( ! $getCarts )
      <div class="uk-alert-warning" uk-alert>
        Keranjang masih kosong.
      </div>
    @else
      <div class="uk-card uk-card-body uk-card-default uk-margin-top">
        <table class="uk-table uk-table-divider uk-table-striped uk-table-small uk-table-middle uk-table-responsive">
          <thead>
            <tr>
              <th>Aksi</th>
              <th>Nama Produk</th>
              <th>Foto</th>
              <th>Qty</th>
              <th>Harga</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach( $getCartsItem as $index => $item )
              <tr>
                <td>
                  <a class="uk-button uk-button-small uk-button-danger" onclick="onDeleteItem(`{{ $item->item_cart_id }}`)">
                    <span uk-icon="icon: trash; ratio: .7"></span>
                  </a>
                </td>
                <td>{{ $item->product_name }}</td>
                <td class="uk-width-small">
                  <img class="uk-width-1-3" src="{{ asset('storage/produk/' . $item->product_image) }}" alt="" />
                </td>
                <td class="uk-width-small">
                  <input class="uk-input" type="number" min="1" id="update-cart-qty{{ $index }}" value="{{ $item->qty }}" onchange="onAddToCart({{ $index }}, `{{ $item->item_cart_id }}`, {{ $item->product_price }}, this.value);" />
                </td>
                <td>
                  <span id="itemprice-{{ $index }}">Rp. {{ number_format( $item->price ) }}</span>
                </td>
                <td>
                  <span id="subtotalprice-{{ $index }}">Rp. {{ number_format( $item->subtotal_price ) }}</span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="uk-width-1-3@s uk-float-right">
          <table class="uk-table uk-table-divider uk-table-small uk-table-middle uk-table-responsive">
            <tbody>
              <tr>
                <td>Grand Total</td>
                <td>: <span id="grandtotal">Rp. {{ number_format( $getCarts->total_price ) }}</span> </td>
              </tr>
            </tbody>
          </table>
          <hr>
          <a onclick="onSubmitCheckout();" class="uk-width-1-1 uk-button uk-button-primary">Checkout</a>
        </div>
      </div>
    @endif
  </div>

  <script type="text/javascript">
    let onAddToCart = function(index, item_id, price, qty)
    {
      if( qty == 0 || qty == '' ) return false;

      let url = `{{ route('frontend.user.carts.update_qty') }}`;
      let result = Carts.onUpdateQty( url, item_id, price, qty );

      result.then( response => {
        let subtotalprice   = document.querySelector(`#subtotalprice-${index}`);
        let grandtotal      = document.querySelector('#grandtotal');
        let nav_total_cart  = document.querySelector('#nav_total_cart');

        if( response.status_code == 201 )
        {
          let result = response.result;

          nav_total_cart.innerHTML  = `<strong>(${result.carts.total_cart})</strong>`;
          subtotalprice.innerHTML   = `Rp. ${new Intl.NumberFormat().format(result.carts_item.subtotal_price)}`;
          grandtotal.innerHTML      = `Rp. ${new Intl.NumberFormat().format(result.carts.total_all_price)}`;
        }
      });
    }

    let onDeleteItem = function( item_id )
    {
      let url     = `{{ route('frontend.user.carts.delete_item') }}`;
      let result  = Carts.onDeleteItem( url, item_id );

      result.then( response => {
        if( response.status_code  == 200 )
        {
          swal({
            title: 'Berhasil',
            text: 'Item berhasil dihapus',
            icon: 'success',
            timer: 2000,
          });

          setTimeout(() => { document.location = ''; }, 2000);
        }
      });
    }

    @if( $getCarts )
    let onSubmitCheckout = function()
    {
      swal({
        title: 'Konfirmasi',
        text: 'Apakah anda ingin melakukan transaksi?',
        icon: 'warning',
        buttons: true
      }).then( willConfirm => {
        if( willConfirm )
        {
          document.location = `{{ route('frontend.user.carts.checkout', ['cart_id' => $getCarts->cart_id]) }}`;
        }
      });
    }
    @endif
  </script>
@endsection
