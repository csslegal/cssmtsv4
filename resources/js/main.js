var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
/*** Geri sayfaya gecişini kullanıcının engelleme*/
window.history.pushState(null, "", window.location.href);
window.onpopstate = function () { window.history.pushState(null, "", window.location.href); };

//datatable olusturma
$('#dataTableVize,#dataTableDilOkulu,#dataTableHarici,#dataTableWeb').DataTable({
    "order": [[0, 'asc'],],
    "columnDefs": [{ "type": "num", "targets": 0 }],
    language: { url: '/dataTables.tr.json' },

});
$('#dataTable').DataTable({
    "order": [[0, 'asc'],],
    "columnDefs": [{ "type": "num", "targets": 0 }],
    language: { url: '/dataTables.tr.json' },
});

$('#dtCustomersTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "/yonetim/ajax/customers",
    language: { url: '/dataTables.tr.json' },
    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'phone' },
        { data: 'email' },
        { data: 'address' },
    ],
    "columnDefs": [{
        "targets": 0,
        "render": function ( data, type, row, meta ) {
            return '<a href="/musteri/' + data + '">Git</a>';
        }
    }],
});
$('#dtVisaLogsTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "/yonetim/ajax/visa-logs",
    language: { url: '/dataTables.tr.json' },
    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'subject' },
        { data: 'u_name' },
        { data: 'created_at' },
    ],
    "order": [[4, 'desc'],],
    "columnDefs": [{
        "targets": 0,
        "render": function ( data, type, row, meta ) {
            return '<a href="/musteri/' + data + '/vize">Git</a>';
        }
    }],
});

$('a.confirm').confirm({
    title: 'Dikkat!',
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
                $.alert('İşlem devam ediyor.');
                location.href = this.$target.attr('href');
            }
        },
    }
});
$('form>button.confirm').confirm({
    title: 'Dikkat!',
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
                $.alert('İşlem devam ediyor.');
                $('form')[0].submit();
            }
        }
    }
});
