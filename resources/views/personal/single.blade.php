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
    </style>

    <h1 style="text-align: center;">User Details</h1>

    @if ($user)
        <table class="user-details-table">
            <tbody>
            <tr><th>Attribute</th><th>Value</th></tr>
            <!-- All rows for user attributes as previously defined -->
            @foreach ([
                'Name' => $user->name,
                'First Name' => $user->firstname,
                'Last Name' => $user->lastname,
                'Role' => $user->role,
                'Birthdate' => $user->birthdate,
                'Email' => $user->email,
                'Phone' => $user->phone,
                'Region' => $user->region,
                'Start Work Date' => $user->start_work_date,
                'Monday Working Time' => $user->working_time_monday,
                'Tuesday Working Time' => $user->working_time_tuesday,
                'Wednesday Working Time' => $user->working_time_wednesday,
                'Thursday Working Time' => $user->working_time_thursday,
                'Friday Working Time' => $user->working_time_friday,
                'Saturday Working Time' => $user->working_time_saturday,
                'Sunday Working Time' => $user->working_time_sunday,
                'Current Year Overtime' => $user->current_year_overtime
            ] as $key => $value)
                <tr><td>{{ $key }}</td><td>{{ $value }}</td></tr>
            @endforeach
            @if ($current_user->role === 'manager')
                <tr><td colspan="2"><a href="{{route('edit-personal', $user->id)}}">Edit</a></td></tr>
            @endif
            </tbody>
        </table>
    @else
        <p>User not found.</p>
    @endif
@endsection
