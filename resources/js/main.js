var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
/*** Geri sayfaya gecişini kullanıcının engelleme*/
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
    title:'Dikkat!',
    content: '',
    buttons: {
        hayır: {
            btnClass: 'btn-info btn-sm text-white',
            action: function () {
            }
        },
        evet: {
            btnClass: 'btn-danger btn-sm text-white', // multiple classes.
            action: function () {
                location.href = this.$target.attr('href');
            }
        },
    }
});
$('form>button.confirm').confirm({
    title:'Dikkat!',
    content: '',
    buttons: {
        hayır: {
            btnClass: 'btn-info btn-sm text-white',
            action: function () {
            }
        },
        evet: {
            btnClass: 'btn-danger btn-sm text-white', // multiple classes.
            action: function () {
                $('form')[0].submit();
            }
        }
    }
});
