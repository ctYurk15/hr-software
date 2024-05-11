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

        .action-button-container a, .action-button-container button
        {
            color: white !important;
        }

        .hidden
        {
            display: none;
        }
    </style>

    <h1 style="text-align: center;">User Details</h1>

    @if ($user)
        @if ($current_user->role === 'manager')
            <div class="d-flex justify-content-center action-button-container">
                <a href="{{route('edit-personal', $user->id)}}" class="btn btn-warning">
                    <span class="material-symbols-outlined">edit</span>&nbsp;
                    <span class="action-button-text">Edit entry</span>
                </a>&nbsp;
                @if($current_user->id != $user->id)
                <button class="btn btn-danger" id="deleteUserBtn" data-user-id="{{$user->id}}">
                    <span class="material-symbols-outlined">delete</span>&nbsp;
                    <span class="action-button-text">Delete entry</span>
                </button>&nbsp;
                @endif
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <span class="material-symbols-outlined">key</span>&nbsp;
                    <span class="action-button-text">Change password</span>
                </button>
            </div>
        @endif
        <table class="user-details-table">
            <tbody>
            <tr><th>Field</th><th>Value</th></tr>
            @foreach ($fields as $name => $data)
                <tr><td>{{ $data['title'] }}</td><td>{{ $user->$name }}</td></tr>
            @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="changePasswordModalLabel">Change password of {{$user->name}}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="changePasswordForm" data-user-id="{{$user->id}}">
                        <div class="modal-body">
                            <label>
                                New password:<br>
                                <input class="form-control" type="password" name="password" required>
                            </label><br>
                            <label>
                                Repeat new password:<br>
                                <input class="form-control" type="password" name="password_confirmation" required>
                            </label><br><br>
                            <div class="alert alert-danger hidden" id="passwordErrorDiv">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <p>User not found.</p>
    @endif


    <script>
        $(document).ready(function(){

            $('#deleteUserBtn').on('click', function(){

                const user_id = $(this).attr('data-user-id');
                if(confirm('Are you sure?'))
                {
                    $.post(`/delete-personal/${user_id}`, {
                        user_id: user_id
                    }, function(data) {
                        window.location = '/team-personal';
                    }).fail(function(response) {
                        console.error('Error:', response.responseText);
                    });
                }

            });

            const password_error_div = $("#passwordErrorDiv");
            $('#changePasswordForm').submit(function(event){
                event.preventDefault();

                const fields = $(this).serializeArray();
                const user_id = $(this).attr('data-user-id');
                password_error_div.addClass('hidden');

                $.post(`/change-personal-password/${user_id}`, fields, function(data) {

                    if(data.success == true)
                    {
                        alert('Success!')
                    }
                    else
                    {
                        password_error_div.removeClass('hidden');
                        password_error_div.html(data.error);
                    }

                }).fail(function(response) {
                    console.error('Error:', response.responseText);
                });
            });

        });
    </script>
@endsection
