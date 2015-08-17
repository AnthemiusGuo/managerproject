<?php echo link_tag(static_url('css/fullcalendar.css')); ?>
<?php echo link_script(static_url('js/fullcalendar.js')); ?>
<div class="col-lg-12">
    <div class="panel panel-default calendar">
          <div class="panel-heading">
            <h3 class="panel-title">日程</h3>
          </div>
          <div class="panel-body">
            <div id="calendar" >
            </div>
          </div>
    </div>

</div>
<script>
var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
var h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek'
                    };
$("#calendar").fullCalendar({ //re-initialize the calendar
                header: h,
                firstDay: 1,
                weekMode:'liquid',
                allDayText:'全天事件',
                axisFormat:'HH(:mm)',
                slotMinutes: 60,
                editable: false,
                droppable: false,
                events:req_url_template.str_supplant({ctrller:'calendar',action:'calList/'}),
                //  [{
                //         title: 'All Day Event',
                //         start: new Date(y, m, 1),
                //         backgroundColor: layoutColorCodes['yellow']
                //     }, {
                //         title: 'Long Event',
                //         start: new Date(y, m, d - 5),
                //         end: new Date(y, m, d - 2),
                //         backgroundColor: layoutColorCodes['green']
                //     }, {
                //         title: 'Repeating Event',
                //         start: new Date(y, m, d - 3, 16, 0),
                //         allDay: false,
                //         backgroundColor: layoutColorCodes['red']
                //     }, {
                //         title: 'Repeating Event',
                //         start: new Date(y, m, d + 4, 16, 0),
                //         allDay: false,
                //         backgroundColor: layoutColorCodes['green']
                //     }, {
                //         title: 'Meeting',
                //         start: new Date(y, m, d, 10, 30),
                //         allDay: false,
                //     }, {
                //         title: 'Lunch',
                //         start: new Date(y, m, d, 12, 0),
                //         end: new Date(y, m, d, 14, 0),
                //         backgroundColor: layoutColorCodes['grey'],
                //         allDay: false,
                //     }, {
                //         title: 'Birthday Party',
                //         start: new Date(y, m, d + 1, 19, 0),
                //         end: new Date(y, m, d + 1, 22, 30),
                //         backgroundColor: layoutColorCodes['purple'],
                //         allDay: false,
                //     }, {
                //         title: 'Click for Google',
                //         start: new Date(y, m, 28),
                //         end: new Date(y, m, 29),
                //         backgroundColor: layoutColorCodes['yellow'],
                //         url: 'http://google.com/',
                //     }
                // ],
                eventMouseover:function( event, jsEvent, view ) { },
                eventClick: function(calEvent, jsEvent, view) {
                    console.log(calEvent);
                    lightbox({size:'m',url:'<?=site_url('calendar/edit').'/'?>'+ calEvent.typ+'/'+calEvent.id})


                    // change the border color just for fun
                    $(this).css('border-color', 'red');

                }
            });
</script>
