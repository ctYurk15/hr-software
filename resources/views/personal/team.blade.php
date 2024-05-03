@extends('page-template')
@section('page-content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 4px;
            box-sizing: border-box; /* Makes sure the input fits inside the cell */
        }

        .personal-row:hover
        {
            cursor: pointer;
            background-color: #e4e4e4;
        }
    </style>


    <h1>Users List</h1>

    <form method="GET" action="{{ url('team-personal') }}">
        <table border="1">
            <thead>
            <tr>
                @php
                    $fields = [
                        'name' => 'text',
                        'firstname' => 'text',
                        'lastname' => 'text',
                        'role' => 'text',
                        'birthdate' => 'date',
                        'email' => 'text',
                        'phone' => 'text',
                        'region' => 'text',
                        'start_work_date' => 'date'
                    ];
                @endphp
                @foreach ($list_fields as $field => $data)
                    <th>
                        <input type="{{ $data['type'] }}"
                               name="{{ $field }}"
                               placeholder="Filter by {{ ucfirst(str_replace('_', ' ', $field)) }}"
                               value="{{ request($field) }}">
                    </th>
                @endforeach
                <th><button type="submit">Filter</button></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="personal-row" data-link="{{route('details-personal', $user->id)}}">
                    @foreach ($list_fields as $field => $data)
                        <td>{{ $user->$field }}</td>
                    @endforeach
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>

    <script>
        $(document).ready(function() {

            $(".personal-row").on('click', function(){

                const url = $(this).attr('data-link');
                window.open(url, '_blank');
            });
        });
    </script>
@endsection
