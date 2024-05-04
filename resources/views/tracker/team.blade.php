@extends('page-template')
@section('page-content')
    <style>

        .tracker {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header-title
        {
            margin: 0 auto 20px;
            width: fit-content
        }

        .tracker-table {
            width: 100%;
            border-collapse: collapse;
        }

        .tracker-table th, .tracker-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .tracker-table th {
            background-color: #f0f0f0;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .date-range-form input[type="date"] {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .date-range-form button {
            padding: 8px 16px;
        }

        .date-range-form button:hover {
            background-color: #218838;
        }

        .entry-row, .date-row
        {
            cursor: pointer;
        }
    </style>
    <div class="tracker">
        <h1 class="header-title">Team tracker data</h1>

        <form class="date-range-form" action="" method="GET">
            <input type="date" name="from_date" required value="{{$from_date}}">
            <input type="date" name="to_date" required value="{{$to_date}}">
            <select name="users_ids[]" id="user_id" style="width: 250px" class="select2" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if(in_array($user->id, $users_ids_selected)) selected="selected" @endif>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
        <br>

        <table class="tracker-table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Employee</th>
                <th>Start Time</th>
                <th>Stop Time</th>
                <th>Total time</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rows as $row)
                @php
                    $entries = $row['entries'];
                @endphp
                @if($entries != null)
                    @foreach($entries as $entry)
                        <tr class="entry-row" data-entry-id="{{$entry->id}}">
                            @if($loop->first) <td rowspan="{{count($entries)}}">{{ $row['date'] }} </td> @endif
                            <td>{{$entry->employee->name}}</td>
                            <td>
                                @if($entry->start_worktime != null)
                                    {{ date('H:i', strtotime($entry->start_worktime)) }}
                                @endif
                            </td>
                            <td>
                                @if($entry->end_worktime != null)
                                    {{ date('H:i', strtotime($entry->end_worktime)) }}
                                @endif
                            </td>
                            <td>
                                @if($entry->worked_time > 0)
                                    {{ $entry->getWorktimeStr() }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="date-row" data-date="{{ $row['date'] }}">
                        <td>{{ $row['date'] }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade modal-lg" id="trackerEventsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        </div>

    </div>
    <script>

        function createEvent(data, entry_id, date)
        {
            $.post(`/tracker-action/add-manual`, data, function(response) {
                if(entry_id == null) entry_id = response.entry_id;
                loadEntry(entry_id, date);
            }).fail(function(response) {
                console.error('Error:', response.responseText);
            });
            //console.log('event will be created with this data', data);
        }

        function deleteEvent(event_id, entry_id, date)
        {
            $.post(`/tracker-action/delete`, {
                event_id: event_id
            }, function(data) {
                if(entry_id == null) entry_id = response.entry_id;
                loadEntry(entry_id, date);
            }).fail(function(response) {
                console.error('Error:', response.responseText);
            });
        }

        function loadEntry(entry_id = null, date = null)
        {
            //get modal contents
            $.get('/tracker-entry-modal', {
                tracker_entry_id: entry_id,
                date: date,
            }, function(data) {

                const events_data = data.events;

                //show & fill modal
                tracker_events_modal.html(data.html);
                tracker_events_modal.modal('show');

                //trigger modal events

                $('#newEventForm').submit(function(event){
                    event.preventDefault();

                    const data = $(this).serializeArray();
                    createEvent(data, entry_id, date)
                });

                $('.editEventBtn').on('click', function(){
                    const event_id = $(this).closest('tr').attr('data-event-id');
                    const event_data = events_data[event_id];

                    const form = $("#newEventForm");
                    form.find('input[name=event_id]').val(event_id);
                    form.find('select[name=user_id]').val(event_data.user_id);
                    form.find('input[name=date]').val(event_data.date);
                    form.find('input[name=time]').val(event_data.time);
                    form.find('select[name=type]').val(event_data.type);
                    console.log(event_data)
                });

                $('.deleteEventBtn').on('click', function(){
                    const event_id = $(this).closest('tr').attr('data-event-id');
                    deleteEvent(event_id, entry_id, date)
                });


            }).fail(function(response) {
                console.error('Error:', response);
            });
        }

        $(".select2").select2();

        const tracker_events_modal = $("#trackerEventsModal");

        $('.entry-row').click(function(){
            const entry_id = $(this).attr('data-entry-id');
            loadEntry(entry_id);
        });

        $('.date-row').click(function(){
            const date = $(this).attr('data-date');
            loadEntry(null, date);
        });

    </script>
@endsection
