@extends('page-template')
@section('page-content')
    <style>
        .user-details-table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .user-details-table th, .user-details-table td {
            padding: 12px 20px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .user-details-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .user-details-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-details-table a {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .user-details-table a:hover {
            background-color: #0056b3;
        }

        .action-button-text
        {
            font-size: 1.5em;
        }

        .action-button-container a
        {
            color: white !important;
        }
    </style>

    <h1 style="text-align: center;">User Details</h1>

    @if ($user)
        <div class="d-flex justify-content-center action-button-container">
            <a href="{{route('edit-personal', $user->id)}}" class="btn btn-warning">
                <span class="material-symbols-outlined">edit</span>&nbsp;
                <span class="action-button-text">Edit entry</span>
            </a>&nbsp;
            <a href="#" class="btn btn-danger" id="deleteUserBtn" data-user-id="{{$user->id}}">
                <span class="material-symbols-outlined">delete</span>&nbsp;
                <span class="action-button-text">Delete entry</span>
            </a>
        </div>
        <table class="user-details-table">
            <tbody>
            <tr><th>Field</th><th>Value</th></tr>
            @foreach ($fields as $name => $data)
                <tr><td>{{ $data['title'] }}</td><td>{{ $user->$name }}</td></tr>
            @endforeach
            @if ($current_user->role === 'manager')
                <tr><td colspan="2"><a href="{{route('edit-personal', $user->id)}}">Edit</a></td></tr>
            @endif
            </tbody>
        </table>
    @else
        <p>User not found.</p>
    @endif

    <script>
        $(document).ready(function(){

            $('#deleteUserBtn').on('click', function(){

                const user_id = $(this).attr('data-user-id');
                if(confirm('Are you sure?'))
                {
                    console.log('user to be deleted', user_id)
                    $.post(`/delete-personal/${user_id}`, {
                        user_id: user_id
                    }, function(data) {
                        window.location = '/team-personal'
                    }).fail(function(response) {
                        console.error('Error:', response.responseText);
                    });
                }

            });

        });
    </script>
@endsection
