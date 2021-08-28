let onValidateCreateOrUpdate = function( action_name )
{
  var iserror       = false;
  var errorMessage  = `Harap diisi`;

  var nama      = document.querySelector('#nama');
  var email     = document.querySelector('#email');
  var password  = document.querySelector('#password');

  var error_nama   = document.querySelector('#error-nama');
  var error_email   = document.querySelector('#error-email');
  var error_password   = document.querySelector('#error-password');

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

let onValidateEditProfile = function()
{
  var iserror       = false;
  var errorMessage  = `Harap diisi`;

  var nama      = document.querySelector('#nama');
  var email     = document.querySelector('#email');

  var error_nama   = document.querySelector('#error-nama');
  var error_email   = document.querySelector('#error-email');

  error_nama.innerHTML      = '';
  error_email.innerHTML     = '';

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

  return !iserror;
};

let onChangePassword = function()
{
  var iserror       = false;
  var errorMessage  = `Harap diisi`;

  var new_password      = document.querySelector('#new_password');
  var confirm_password  = document.querySelector('#confirm_password');

  var error_password   = document.querySelector('#error-password');
  var error_confirm_password   = document.querySelector('#error-confirm-password');

  error_password.innerHTML      = '';
  error_confirm_password.innerHTML     = '';

  if( new_password.value == '' )
  {
    error_password.innerHTML = divAlertMessage( errorMessage, 'error' );
    iserror = true;
  }
  if( confirm_password.value == '' )
  {
    error_confirm_password.innerHTML = divAlertMessage( errorMessage, 'error' );
    iserror = true;
  }
  if( new_password.value != confirm_password.value && confirm_password.value != '' )
  {
    error_confirm_password.innerHTML = divAlertMessage( 'Password tidak sama.', 'error' );
    iserror = true;
  }

  return !iserror;
};
