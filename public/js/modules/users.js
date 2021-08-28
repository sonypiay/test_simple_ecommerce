let onValidateCreateOrUpdate = function( action_name )
{
  var iserror       = false;
  var errorMessage  = `Harap diisi`;

  var nama      = document.querySelector('#nama');
  var email     = document.querySelector('#nama_produk');
  var password  = document.querySelector('#password');

  var error_nama   = document.querySelector('#error-kode-produk');
  var error_email   = document.querySelector('#error-nama-produk');
  var error_password   = document.querySelector('#error-foto-produk');

  error_nama.innerHTML      = '';
  error_email.innerHTML     = '';
  error_password.innerHTML  = '';

  if( nama.value == '' )
  {
    error_nama.innerHTML = divAlertMessage( errorMessage, 'error' );
    iserror = true;
  }
  if( email.value == '' )
  {
    error_email.innerHTML = divAlertMessage( errorMessage, 'error' );
    iserror = true;
  }
  if( action_name == 'store' && password.value == '' )
  {
    error_password.innerHTML = divAlertMessage( errorMessage, 'error' );
    iserror = true;
  }

  return !iserror;
};
