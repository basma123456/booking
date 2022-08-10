@extends('layouts.admin')

@section('style')

    <link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/fullcalendar/main.css')}}">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
    </script>

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="sticky-top mb-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Draggable Events</h4>
                                                </div>
                                                <div class="card-body">
                                                    <!-- the events -->
                                                    <div id="external-events">
                                                        <div onclick="fromHere(true)" class="external-event external-eventFrom bg-success">Lunch</div>
                                                        <div onclick="fromHere(false)" class="external-event external-eventTo bg-warning">Go home</div>
                                                        <div class="external-event bg-info">Do homework</div>
                                                        <div class="external-event bg-primary">Work on UI design</div>
                                                        <div class="external-event bg-danger">Sleep tight</div>
                                                        <div class="checkbox">
                                                            <label for="drop-remove">
                                                                <input type="checkbox" id="drop-remove">
                                                                remove after drop
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Create Event</h3>

                                                    <h1 class="jj"><input id="myDate" type="text" value=""></h1>
                                                    <h1><input type="text" id="myTime" value=""></h1>

                                                </div>
                                                <div class="card-body">
                                                    <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                                        <ul class="fc-color-picker" id="color-chooser">
                                                            <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                                                            <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                                            <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                                                            <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                                            <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    <div class="input-group">
                                                        <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                                                        <div class="input-group-append">
                                                            <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                                                        </div>
                                                        <!-- /btn-group -->
                                                    </div>
                                                    <!-- /input-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-9">
                                        <div class="card card-primary">
                                            <div class="card-body p-0">

                                                <!-- THE CALENDAR -->
                                                <div id="calendar"></div>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div><!-- /.container-fluid -->


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <!-- jQuery -->
    <script src="{{asset('bower_components/admin-lte/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('bower_components/admin-lte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('bower_components/admin-lte/dist/js/adminlte.min.js')}}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="{{asset('bower_components/admin-lte/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('bower_components/admin-lte/plugins/fullcalendar/main.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('bower_components/admin-lte/dist/js/demo.js')}}"></script>
    <!-- Page specific script -->
    <script>




        $(function () {

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function () {

                    // create an Event Object (https://fullcalendar.io/docs/event-object)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex        : 1070,
                        revert        : true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    })

                })
            }

            ini_events($('#external-events div.external-event'))

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            var containerEl = document.getElementById('external-events');
            var checkbox = document.getElementById('drop-remove');
            var calendarEl = document.getElementById('calendar');

            // initialize the external events
            // -----------------------------------------------------------------

            new Draggable(containerEl, {
                itemSelector: '.external-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText,
                        backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                        borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                        textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
                    };
                }
            });

            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                //Random default events
                events: [
                    {
                        title          : 'All Day Event',
                        start          : new Date(y, m, 1),
                        backgroundColor: '#f56954', //red
                        borderColor    : '#f56954', //red
                        allDay         : true
                    },
                    {
                        title          : 'Long Event',
                        start          : new Date(y, m, d - 5),
                        end            : new Date(y, m, d - 2),
                        backgroundColor: '#f39c12', //yellow
                        borderColor    : '#f39c12' //yellow
                    },
                    {
                        title          : 'Meeting',
                        start          : new Date(y, m, d, 10, 30),
                        allDay         : false,
                        backgroundColor: '#0073b7', //Blue
                        borderColor    : '#0073b7' //Blue
                    },
                    {
                        title          : 'Lunch',
                        start          : new Date(y, m, d, 12, 0),
                        end            : new Date(y, m, d, 14, 0),
                        allDay         : false,
                        backgroundColor: '#00c0ef', //Info (aqua)
                        borderColor    : '#00c0ef' //Info (aqua)
                    },
                    {
                        title          : 'Birthday Party',
                        start          : new Date(y, m, d + 1, 19, 0),
                        end            : new Date(y, m, d + 1, 22, 30),
                        allDay         : false,
                        backgroundColor: '#00a65a', //Success (green)
                        borderColor    : '#00a65a' //Success (green)
                    },
                    {
                        title          : 'Click for Google',
                        start          : new Date(y, m, 28),
                        end            : new Date(y, m, 29),
                        url            : 'https://www.google.com/',
                        backgroundColor: '#3c8dbc', //Primary (light-blue)
                        borderColor    : '#3c8dbc' //Primary (light-blue)
                    }
                ],
                editable  : true,
                droppable : true, // this allows things to be dropped onto the calendar !!!
                drop      : function(info) {
                    // is the "remove after drop" checkbox checked?
                    if (checkbox.checked) {
                        // if so, remove the element from the "Draggable Events" list
                        info.draggedEl.parentNode.removeChild(info.draggedEl);
                    }
                }
            });

            calendar.render();
            // $('#calendar').fullCalendar()

            /* ADDING EVENTS */
            var currColor = '#3c8dbc' //Red by default
            // Color chooser button
            $('#color-chooser > li > a').click(function (e) {
                e.preventDefault()
                // Save color
                currColor = $(this).css('color')
                // Add color effect to button
                $('#add-new-event').css({
                    'background-color': currColor,
                    'border-color'    : currColor
                })
            })
            $('#add-new-event').click(function (e) {
                e.preventDefault()
                // Get value and make sure it is not null
                var val = $('#new-event').val()
                if (val.length == 0) {
                    return
                }

                // Create events
                var event = $('<div />')
                event.css({
                    'background-color': currColor,
                    'border-color'    : currColor,
                    'color'           : '#fff'
                }).addClass('external-event')
                event.text(val)
                $('#external-events').prepend(event)

                // Add draggable funtionality
                ini_events(event)

                // Remove event from text input
                $('#new-event').val('')
            })
        })
    </script>

    <script>


        // items.forEach(function(item){
        //     copy.push(item);
        // });...
        // var tds = document.querySelector("div");
        //
        // tds.forEach(
        //     function(item){
        //         item. addEventListener('click' ,function () {
        //             alert(this.getAttribute('data-date'))
        //         })
        //
        // }
        // );

            var myDate = document.getElementById('#myDate');


        $(document).ready(function(){
            var myTime = document.getElementById('#myTime');

            // $("td").click(function(e){
            //     e.preventDefault();
            //     var myAttr = $(this).attr("data-date");
            //
            //
            //     var inp =  document.createElement ('input');
            //     inp.value = myAttr;
            //     if(inp) {
            //         inp.setAttribute('id', 'ourDate');
            //         inp.setAttribute('type', 'text');
            //         inp.style.backgroundColor === 'blue';
            //
            //         alert(inp);
            //
            //     }
            //
            //     });


            $("td").click(function(e){
                e.preventDefault();
                var myAttr = $(this).attr("data-date");

                var inp= document.createElement ('input');
                var myform = document.createElement('form');
                $(document.body).append(myform);

                if(inp) {
                    inp.value = myAttr;

                    inp.setAttribute('id', 'ourDate');
                    inp.setAttribute('name', 'my_date');

                    inp.setAttribute('style', 'color:green');

                    inp.style.backgroundColor === 'blue';
                    inp.show;
                    alert(inp);

                }

                if(myform){

                myform.prepend(inp);
myform.setAttribute('action' , '/hhhhhhhhhhh')
                myform.setAttribute('method' , 'post')

                $(document.body).append(myform);




                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formData = new FormData(myform);


                $.ajax({
                    type:'POST',
                    url:'/hhhhhhhhhhh',
                    data:formData,
                    processData : false,
                    contentType : false,
                    cache : false,

                    success:function(data) {

                       if( data.from !== null && data.from.length > 0 && data.from !== 'undefind'){

                           document.querySelector('h1').innerText = data.from;
                           document.querySelector('h2').innerText = data.to;

                       }
                        // if( data.to.length !== null  && data.to.length > 0 && data.to !== 'undefind'){
                        //
                        //     document.querySelector('h2').innerText = data.to;
                        //
                        // }

                        // $(document.body.querySelector('h1')).append = 'kkkkkkkkkkkkkk' ;
                      console.log(data.from);
                    }
                });





                }










            });











        });







        function fromHere(object) {

             status = object;
            return status;
        }
    </script>

    @endsection
