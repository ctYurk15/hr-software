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

        .tracker-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            display: block;
            width: 200px;
            margin: 0 auto 20px;
        }

        .header-title
        {
            margin: 0 auto 20px;
            width: fit-content
        }

        .tracker-button:hover {
            background-color: #0056b3;
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

        .tracker-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 20px; /* Space between button and form */
        }

        .tracker-button:hover {
            background-color: #0056b3;
        }

        .date-range-form input[type="date"] {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .date-range-form button {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .date-range-form button:hover {
            background-color: #218838;
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
            <button type="submit">Submit</button>
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
                        <tr>
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
                    <tr>
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
    </div>
    <script>
        $(".select2").select2()
    </script>
@endsection
