@extends('sablon.yonetim')

@section('content')
    <nav aria-label="breadcrumb">
        <ol id="breadcrumb" class="breadcrumb p-2">
            <li class="breadcrumb-item"><a href="/yonetim">Yönetim İşlemleri</a></li>
            <li class="breadcrumb-item"><a href="/yonetim/vize">Vize İşlemleri</a></li>
            <li class="breadcrumb-item active" aria-current="page">Randevu Takvimi</li>
        </ol>
    </nav>

    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Randevu Takvimi</div>
        <div class="card-body scroll">
            <div id='calendar'></div>
        </div>
    </div>

    <!-- Modal -->
    @include('include.management.content-load')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('js/fullcalendar/main.css') }}" />
@endsection

@section('js')
    <script src="{{ asset('js/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('js/fullcalendar/locales/tr.js') }}"></script>
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
