let onValidateCreateOrUpdate = function( action_name )
{
  var iserror       = false;
  var errorMessage  = `Harap diisi`;

  var kode_produk   = document.querySelector('#kode_produk');
  var nama_produk   = document.querySelector('#nama_produk');
  var foto_produk   = document.querySelector('#foto_produk');
  var harga_produk  = document.querySelector('#harga_produk');

  var error_kode_produk   = document.querySelector('#error-kode-produk');
  var error_nama_produk   = document.querySelector('#error-nama-produk');
  var error_foto_produk   = document.querySelector('#error-foto-produk');
  var error_harga_produk  = document.querySelector('#error-harga-produk');

  error_kode_produk.innerHTML   = '';
  error_nama_produk.innerHTML   = '';
  error_foto_produk.innerHTML   = '';
  error_harga_produk.innerHTML  = '';

  if( kode_produk.value == '' )
  {
    error_kode_produk.innerHTML = divAlertMessage( errorMessage, 'error' );
    iserror = true;
  }
  if( nama_produk.value == '' )
  {
    error_nama_produk.innerHTML = divAlertMessage( errorMessage, 'error' );
    iserror = true;
  }
  if( harga_produk.value == '' )
  {
    error_harga_produk.innerHTML = divAlertMessage( errorMessage, 'error' );
    iserror = true;
  }
  if( action_name == 'store' && foto_produk.value == '' )
  {
    error_foto_produk.innerHTML = divAlertMessage( errorMessage, 'error' );
    iserror = true;
  }

  return !iserror;
};
