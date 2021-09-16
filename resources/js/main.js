var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
/**
 * Geri sayfaya gecişini kullanıcının engelleme
 */
window.history.pushState(null, "", window.location.href);
window.onpopstate = function () { window.history.pushState(null, "", window.location.href); };

//datatable olusturma
$('#dataTableVize,#dataTableDilOkulu,#dataTableHarici').DataTable({
    "order": [[0, "desc"]],
    "columnDefs": [{ "type": "num", "targets": 0 }],
    language: { url: '/dataTables.tr.json' },

});
$('#dataTable').DataTable({
    language: { url: '/dataTables.tr.json' },
});


$('a.confirm').confirm({
    content: '',
    buttons: {
        hayır: {
            btnClass: 'btn-info text-white',
            action: function () {
            }
        },
        evet: {
            btnClass: 'btn-danger text-white', // multiple classes.
            action: function () {
                location.href = this.$target.attr('href');
            }
        },
    }
});
$('form>button.confirm').confirm({
    content: '',
    buttons: {
        hayır: {
            btnClass: 'btn-info text-white',
            action: function () {
            }
        },
        evet: {
            btnClass: 'btn-danger text-white', // multiple classes.
            action: function () {
                $('form')[0].submit();
            }
        }
    }
});

$('body').append('<div id="loadingDiv"><div class="loader text-center fw-bold"><img class="w-100  mt-5 p-3" src="/storage/logo.png" alt="logo">Sayfa Yükleniyor..</div></div>');
$(window).on('load', function(){
 setTimeout(removeLoader, 1000); //wait for page load PLUS two seconds.
});
function removeLoader(){
    $( "#loadingDiv" ).fadeOut(200, function() {
      // fadeOut complete. Remove the loading div
      $( "#loadingDiv" ).remove(); //makes page more lightweight
  });
}
