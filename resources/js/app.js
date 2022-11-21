
//required
require('./bootstrap');

window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js')

require('jquery-confirm')
require('datatables.net-bs5')

import AirDatepicker from 'air-datepicker';
import localeTr from 'air-datepicker/locale/tr';

new AirDatepicker('#date1', {
    locale: localeTr,
    isMobile: true,
    autoClose: true,
    position: 'right center',
    range: true,
    buttons: ['today', 'clear'],
});
new AirDatepicker('#date2', {
    locale: localeTr,
    isMobile: true,
    autoClose: true,
    range: true,
    position: 'right center',
    buttons: ['today', 'clear'],
});
new AirDatepicker('#date3', {
    locale: localeTr,
    isMobile: true,
    autoClose: true,
    range: true,
    position: 'right center',
    buttons: ['today', 'clear'],
});
new AirDatepicker('#date4', {
    locale: localeTr,
    isMobile: true,
    autoClose: true,
    range: true,
    position: 'right center',
    buttons: ['today', 'clear'],
});
new AirDatepicker('#date5', {
    locale: localeTr,
    isMobile: true,
    autoClose: true,
    range: true,
    position: 'right center',
    buttons: ['today', 'clear'],
});
new AirDatepicker('#dates1', {
    locale: localeTr,
    isMobile: true,
    autoClose: true,
    position: 'right center',
    range: true,
    buttons: ['today', 'clear'],
    multipleDatesSeparator: '--',
});
new AirDatepicker('#dates2', {
    locale: localeTr,
    isMobile: true,
    autoClose: true,
    position: 'right center',
    range: true,
    buttons: ['today', 'clear'],
    multipleDatesSeparator: '--',
});
require('./main');
