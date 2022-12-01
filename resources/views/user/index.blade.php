@extends('sablon.genel')

@section('title')
    Anasayfa - Kullanıcı Oturum
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item active" aria-current="page">Kullanıcı İşlemleri</li>
        </ol>
    </nav>

    @include('include.user.visa.customer-files-table')
    @include('include.user.web.web-panels-table')
    @include('include.management.content-load')

@endsection


@section('css')
    <link href='/js/fullcalendar/main.css' rel='stylesheet' />
@endsection

@section('js')
    <script src='{{ url('/') }}/js/fullcalendar/main.js'></script>
    <script src='{{ url('/') }}/js/fullcalendar/locales/tr.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'tr',
                themeSystem: 'bootstrap5',
                height: '450px',
                buttonIcons: true,
                hiddenDays: [0, 6],
                fixedWeekCount: false,
                headerToolbar: {
                    left: 'title',
                    right: 'today prev,next'
                },
                eventSources: [{
                    url: '/kullanici/ajax/calendar-event',
                    method: 'POST',
                    extraParams: {
                        _token: '{{ csrf_token() }}',
                        user_id: '{{ session('userId') }}',
                        user_type_id: '{{ session('userTypeId') }}',
                    }
                }],
                eventClick: function(event, jsEvent, view) {
                    jQuery('#contentHead').html(event.event.title);
                    jQuery('#contentLoad').html(event.event.extendedProps.description);
                    var exampleModal = document.getElementById('exampleModal');
                    var modal = bootstrap.Modal.getInstance(exampleModal);
                    jQuery('#exampleModal').modal('show')
                }
            });
            calendar.render();
        });
    </script>
@endsection
