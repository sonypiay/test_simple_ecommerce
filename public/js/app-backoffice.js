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
