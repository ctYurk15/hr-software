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
    <div>
        {{ $users->links('partials.pagination') }}
    </div>
    <form method="GET" action="{{ url('team-personal') }}">
        <table border="1">
            <thead>
            <tr>
                @foreach ($list_fields as $field => $data)
                    <th>
                        {{$data['title']}}<br>
                        <input type="{{ $data['type'] }}"
                               name="{{ $field }}"
                               placeholder="Filter by {{ $data['title'] }}"
                               value="{{ request($field) }}">
                    </th>
                @endforeach
                <th><button type="submit" class="btn btn-success">Filter</button></th>
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
