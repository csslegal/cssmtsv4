
//required
require('./bootstrap');

window.bootstrap = require('bootstrap/dist/js/bootstrap.bundle.js')

require('jquery-confirm')
require('datatables.net-bs5')

import AirDatepicker from 'air-datepicker';

new AirDatepicker('.datepicker', {
    buttons: ['today', 'clear'],
    isMobile: true,
    autoClose: true,
})
new AirDatepicker('.datepicker1', {
    buttons: ['today', 'clear'],
    isMobile: true,
    autoClose: true,

})
new AirDatepicker('.datepicker2', {
    buttons: ['today', 'clear'],
    isMobile: true,
    autoClose: true,
})
new AirDatepicker('.datepicker3', {
    buttons: ['today', 'clear'],
    isMobile: true,
    autoClose: true,
})
new AirDatepicker('.datepicker4', {
    buttons: ['today', 'clear'],
    isMobile: true,
    autoClose: true,
})

// Core - these two are required :-)
require('tinymce');

require('tinymce/themes/silver');
require('tinymce/icons/default');

require('tinymce/plugins/anchor');
require('tinymce/plugins/advlist');
require('tinymce/plugins/autolink');
require('tinymce/plugins/code');
require('tinymce/plugins/codesample');
require('tinymce/plugins/charmap');
require('tinymce/plugins/fullscreen');
require('tinymce/plugins/help');
require('tinymce/plugins/image');
require('tinymce/plugins/imagetools');
require('tinymce/plugins/insertdatetime');
require('tinymce/plugins/media');
require('tinymce/plugins/lists');
require('tinymce/plugins/link');
require('tinymce/plugins/paste');
require('tinymce/plugins/print');
require('tinymce/plugins/preview');
require('tinymce/plugins/table');
require('tinymce/plugins/textcolor');
require('tinymce/plugins/visualblocks');
require('tinymce/plugins/wordcount');

tinymce.init({
    selector: '#editor400',
    menubar: true,
    height: 400,
    plugins: [
        'code advlist anchor autolink fullscreen help image imagetools lists link media preview table visualblocks wordcount'
    ],
    toolbar: 'undo redo | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image media code',
});
tinymce.init({
    selector: '#editor200',
    height: 200,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor visualblocks fullscreen insertdatetime media table paste wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
});
require('./main');
