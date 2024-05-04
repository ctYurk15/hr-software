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
@endsection
