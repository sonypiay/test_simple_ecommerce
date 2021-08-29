@php
  $getUserDetail  = \App\Model\Users::getDetail();
  $getTotalCart   = \App\Model\AT_Carts::getAll( $getUserDetail->id );
@endphp

<header class="uk-box-shadow-small">
  <div class="uk-container">
    <nav uk-navbar>
      <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
          <li><a href="{{ url('/') }}">Home</a></li>
        </ul>
      </div>

      <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
          <li>
            <a href="{{ route('frontend.user.carts.index') }}">
              <span uk-icon="icon: cart; ratio: .7"></span>
              Keranjang
              <span id="nav_total_cart" class="uk-text-bold">
                ({{ $getTotalCart->count() }})
              </span>
            </a>
          </li>
          <li>
            <a href="{{ route('frontend.user.transaction.index') }}"><span uk-icon="icon: bag; ratio: .7"></span> Transaksi</a>
          </li>
          <li>
            <a href="javascript:void(0);"><span uk-icon="icon: user; ratio: .7"></span> {{ $getUserDetail->nama }}</a>
            <div class="uk-navbar-dropdown">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                <li><a href="{{ route('frontend.user.profile.index') }}">Edit Profil</a></li>
                <li><a href="{{ route('frontend.user.change_password.index') }}">Ganti Password</a></li>
                <li><a href="{{ route('dologout') }}">Keluar</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</header>
