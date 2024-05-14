@extends('page-template')
@section('page-content')
    <style>
        .vacation-table {
            width: 100%;
            border-collapse: collapse; /* Ensures that borders between cells are merged */
            margin-top: 20px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .vacation-table th,
        .vacation-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ccc;
        }

        .vacation-table th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            border-top: 1px solid #ccc;  /* Top border for header cells */
        }

        .vacation-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .vacation-table td {
            font-size: 16px;
        }

        /* Responsive table adjustments */
        @media (max-width: 600px) {
            .vacation-table th, .vacation-table td {
                display: block;
                text-align: right;
            }
            .vacation-table th::before, .vacation-table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
            }
        }

        form div {
            margin-bottom: 10px;
        }

        .filter-form {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .filter-form > div {
            flex: 1; /* Each child div takes equal width */
            padding: 0 10px; /* Adds some padding between form controls */
        }
        .filter-form label {
            margin-right: 10px; /* Space between label and input */
        }
        .filter-form input[type="date"],
        .filter-form select {
            width: 100%; /* Ensures inputs and selects take full width of their container */
        }
        button[type="submit"] {
            margin-left: 10px; /* Space between the last filter and the button */
        }
    </style>

    <div>
        <h1>Vacation Schedule</h1>
        <form class="filter-form" method="GET">
            <div>
                <label for="from_date">From Date:</label>
                <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}">
            </div>
            <div>
                <label for="to_date">To Date:</label>
                <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}">
            </div>
            @if($current_user->role == 'manager')
                <div>
                    <label for="employee_id">Employee:</label>
                    <select id="employee_id" name="employee_id">
                        <option value="">All</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('employee_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button type="submit" class="btn btn-success">Filter</button>
        </form>
    </div>
    <div>
        {{ $vacations->links('partials.pagination') }}
    </div>

    <table class="vacation-table">
        <thead>
        <tr>
            <th>Employee</th>
            <th>From Date</th>
            <th>To Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vacations as $vacation)
            <tr>
                <td data-label="Employee">{{ $vacation->user->name }}</td>
                <td data-label="From Date">{{ $vacation->from_date->format('Y-m-d') }}</td>
                <td data-label="To Date">{{ $vacation->to_date->format('Y-m-d') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
