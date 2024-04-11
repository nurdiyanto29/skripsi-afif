@php
    $no_search = $no_search ?? false;
    $search = $search ?? null;
    $kalender = $kalender ?? null;
@endphp
<div class="widget-wrap">
    @if ($kalender)
        <div class="single-sidebar-widget popular-post-widget" style="margin-top:0">
            <h4 class="popular-title">Kalender Agenda</h4>
            <div class="popular-post-list">
                <div id='calendar'></div>
            </div>
        </div>
    @endif

    @if (!$no_search)
        <div class="single-sidebar-widget search-widget">
            <form class="search-form" action="{{ $base_url }}">
                <input value="{{ $search }}" placeholder="Cari {{ $header }}" name="search" type="text"
                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Cari {{ $header }}'">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    @endif


    <div class="single-sidebar-widget popular-post-widget">
        <h4 class="popular-title">{{ $header }} Lain</h4>
        <div class="popular-post-list">


            @foreach ($sidebar_data as $item)
                @php
                    $judul = $item->nama ?? $item->judul;
                    $foto = $item->foto ?? null;
                    $detail_link = $base_url . "/detail/{$item->id}?item=$judul";
                @endphp

                <div class="single-post-list d-flex flex-row align-items-center">
                    @if ($foto)
                        <a href="{{ $detail_link }}" class="my-loading">
                            <div class=" el_box_image_custom_wh"
                                style="background-image:url({{ thumbnail($foto, 'thumb_', true) }});min-height:75px;min-width:100px;">
                            </div>
                        </a>
                    @endif

                    <div class="details">
                        <a href="{{ $detail_link }}" class="my-loading">
                            <h6>{{ $judul }}</h6>
                        </a>
                        @if ($show_date)
                            @php
                                $date = is_bool($show_date) ? 'created_at' : $show_date;
                            @endphp
                            <p>{{ date('d F Y', strtotime($item->{$date})) }}</p>
                        @endif

                    </div>
                </div>
            @endforeach


        </div>
    </div>

</div>

@if ($kalender)
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.min.css') }}">
    <style>
        .fc { font-size: 0.8em }
        .fc .fc-toolbar-title { font-size: 1.2em }
        .fc-h-event { cursor: pointer;}
        .fc table { line-height: 0.8 }
        .fc-col-header-cell.fc-day-sun, { background-color: #f48c8c ;}
        .fc .fc-day-sun { color: #e63636}
        .fc .fc-day-today { font-weight: 600;}
        .fc .fc-daygrid-day.fc-day-today { background-color : rgba(40, 184, 255, 0.15)}
    </style>
    <script src="{{ asset('plugins/fullcalendar/main.min.js') }}"></script>

    <script>
        $(function() {
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next',
                },
                // height: 'auto',

                locale: 'id',
                timeZone: 'local',
                // showNonCurrentDates: false,
                
                eventClick: function(info){
                    let waktu = info.event.end ? `${moment(info.event.start).format('dddd, DD MMMM')} - ${moment(info.event.end).format('dddd, DD MMMM')}` : moment(info.event.start).format('dddd, DD MMMM');
                    $.confirm({
                        type: 'blue',
                        columnClass: 'medium',
                        title: info.event.title,
                        content: `${waktu}<br>Tempat : ${info.event.extendedProps.tempat || '-'}`,
                        buttons: {
                            tutup : {
                                btnClass: 'btn-blue',
                            }
                        }
                    })
                },
               
                datesSet: function(info) {
                    let events = calendar.getEvents();
                    if (events.length) events.forEach(event => event.remove());

                    $('#calendar').loading();

                    $.post(`/agenda/ajax`, {
                        month: moment(info.start).add(1, 'M').format('YYYY-MM')
                    }, function(e, textStatus, xhr) {
                        $('#calendar').loading('stop');
                        if (!e.status) return toastr.error(e.message || 'Tidak dapat mengambil data!');

                        e.data.event.forEach(ev => calendar.addEvent(ev))
                       
                    }, 'json').fail(e => {
                        $('#calendar').loading('stop');
                        toastr.error('Server tidak merespon!')
                    })
                },
            });


            calendar.render();
        });
    </script>
@endif
