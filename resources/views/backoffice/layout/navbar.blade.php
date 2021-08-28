@php
  $getUserDetail = \App\Model\Users::getDetail();
@endphp

<header class="uk-box-shadow-small">
  <div class="uk-container">
    <nav uk-navbar>
      <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
          <li><a href="{{ route('backoffice.product.index') }}">Produk</a></li>
          <li><a href="{{ url('/') }}">Transaksi</a></li>
          <li><a href="{{ url('/') }}">Laporan Transaksi</a></li>
          <li>
            <a href="javascript:void(0);">Users</a>
            <div class="uk-navbar-dropdown">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                <li><a href="{{ route('backoffice.users.index', ['user_type' => 'user']) }}">User</a></li>
                <li><a href="{{ route('backoffice.users.index', ['user_type' => 'admin']) }}">Admin</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>

      <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
          <li>
            <a href="javascript:void(0);"><span uk-icon="icon: user; ratio: .7"></span> {{ $getUserDetail->nama }}</a>
            <div class="uk-navbar-dropdown">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                <li><a href="{{ route('backoffice.profile.index') }}">Edit Profil</a></li>
                <li><a href="{{ route('backoffice.change_password.index') }}">Ganti Password</a></li>
                <li><a href="{{ route('dologout') }}">Keluar</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</header>
