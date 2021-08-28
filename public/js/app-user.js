let divAlertMessage = function(message, alert)
{
  return `<div class="uk-margin-small-top uk-text-small uk-text-${alert == 'error' ? 'danger' : 'success'}">
    <span class="uk-margin-small-right" uk-icon="icon: ${alert === 'error' ? 'warning' : 'check'}; ratio: .7"></span>
    ${message}
  </div>`;
}

class Users {
  static onValidateUserRegiter()
  {
    var iserror       = false;
    var errorMessage  = `Harap diisi`;

    var fullname  = document.querySelector('#fullname');
    var email     = document.querySelector('#email');
    var password  = document.querySelector('#password');

    var error_fullname  = document.querySelector('#error-fullname');
    var error_email     = document.querySelector('#error-email');
    var error_password  = document.querySelector('#error-password');

    error_fullname.innerHTML  = '';
    error_email.innerHTML     = '';
    error_password.innerHTML  = '';

    if( fullname.value == '' )
    {
      document.querySelector('#error-fullname').innerHTML = divAlertMessage( errorMessage, 'error' );
      iserror = true;
    }
    if( email.value == '' )
    {
      document.querySelector('#error-email').innerHTML = divAlertMessage( errorMessage, 'error' );
      iserror = true;
    }
    if( password.value == '' )
    {
      document.querySelector('#error-password').innerHTML = divAlertMessage( errorMessage, 'error' );
      iserror = true;
    }

    return ! iserror;
  }

  static onValidateLogin()
  {
    var iserror       = false;
    var errorMessage  = `Harap diisi`;

    var email     = document.querySelector('#email');
    var password  = document.querySelector('#password');

    var error_email     = document.querySelector('#error-email');
    var error_password  = document.querySelector('#error-password');

    error_email.innerHTML     = '';
    error_password.innerHTML  = '';
    
    if( email.value == '' )
    {
      document.querySelector('#error-email').innerHTML = divAlertMessage( errorMessage, 'error' );
      iserror = true;
    }
    if( password.value == '' )
    {
      document.querySelector('#error-password').innerHTML = divAlertMessage( errorMessage, 'error' );
      iserror = true;
    }

    return ! iserror;
  }
}
