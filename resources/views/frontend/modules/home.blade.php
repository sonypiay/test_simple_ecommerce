@extends('frontend.layout.master')
@section('meta_title', $title_page)
@section('main_content')
  @include('frontend.layout.navbar')

  <div class="uk-container uk-margin-large">
    <form class="uk-form-stacked" method="get">
      <input class="uk-input uk-width-1-4@s" type="search" id="keywords" name="keywords" value="{{ request()->keywords }}" placeholder="Cari produk ...">
    </form>

    @if( $getProduct->total() == 0 )
      <div class="uk-alert-warning" uk-alert>
        Produk belum ada
      </div>
    @else
      <div class="uk-grid-small uk-grid-match uk-margin" uk-grid>
        @foreach( $getProduct as $product )
        <div class="uk-width-1-3@s">
          <div class="uk-card uk-card-default">
            <div class="uk-card-media-top">
              <div class="uk-cover-container uk-height-medium">
                <img src="{{ asset('storage/produk/' . $product->product_image) }}" alt="" uk-cover />
              </div>
            </div>
            <div class="uk-card-body">
              <h3 class="uk-card-title">
                {{ $product->product_name }}
              </h3>
              <p>
                Rp. {{ number_format( $product->price ) }}
              </p>
              <div class="uk-margin-top">
                <a onclick="onAddToCart(`{{ $product->id }}`, `{{ $product->price }}`, 1)" class="uk-width-1-1 uk-button uk-button-primary">
                  <span uk-icon="icon: cart; ratio: .7"></span>
                  Beli
                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    @endif
  </div>

  <script type="text/javascript">
    let onAddToCart = function(product_id, price, qty)
    {
      let url = `{{ route('frontend.user.carts.store') }}`;
      let result = Carts.onCreateOrUpdate( url, product_id, price, qty, 'add' );

      result.then( response => {
        let nav_total_cart = document.querySelector('#nav_total_cart');

        if( response.status_code == 201 )
        {
          nav_total_cart.innerHTML = `<strong>(${response.result.carts.total_cart})</strong>`;

          swal({
            title: 'Berhasil',
            text: 'Berhasil menambah keranjang',
            icon: 'success',
            timer: 2000
          });
        }
      });
    }
  </script>
@endsection
