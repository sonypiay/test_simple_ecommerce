let divAlertMessage = function(message, alert)
{
  return `<div class="uk-margin-small-top uk-text-small uk-text-${alert == 'error' ? 'danger' : 'success'}">
    <span class="uk-margin-small-right" uk-icon="icon: ${alert === 'error' ? 'warning' : 'check'}; ratio: .7"></span>
    ${message}
  </div>`;
}

let formatDate = function(date, format) {
  if( format === undefined ) format = 'YYYY-MM-DD';

  return dayjs(date).format(format);
};

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

class Carts {
  static async onCreateOrUpdate( url, product_id, price, qty, type )
  {
    let request = {
      product_id: product_id,
      qty: qty,
      price: price,
      type: type
    };

    let fetchData = await fetch(url, {
      method: 'post',
      mode: 'cors',
      cache: 'no-cache',
      body: JSON.stringify(request),
      headers: {
        'content-type': 'application/json',
        'x-requested-with': 'XMLHttpRequest',
        'x-csrf-token': APP_TOKEN,
      }
    });

    let result = fetchData.json();
    return result;
  }

  static async onUpdateQty( url, item_cart_id, price, qty )
  {
    let request = {
      item_cart_id: item_cart_id,
      qty: qty,
      price: price,
    };

    let fetchData = await fetch(url, {
      method: 'put',
      mode: 'cors',
      cache: 'no-cache',
      body: JSON.stringify(request),
      headers: {
        'content-type': 'application/json',
        'x-requested-with': 'XMLHttpRequest',
        'x-csrf-token': APP_TOKEN,
      }
    });

    let result = fetchData.json();
    return result;
  }

  static onDeleteCart( user_id )
  {

  }

  static async onDeleteItem( url, item_id )
  {
    let fetchData = await fetch(`${url}/${item_id}`, {
      method: 'delete',
      mode: 'cors',
      cache: 'no-cache',
      headers: {
        'x-requested-with': 'XMLHttpRequest',
        'x-csrf-token': APP_TOKEN,
      }
    });

    let result = fetchData.json();
    return result;
  }
}
