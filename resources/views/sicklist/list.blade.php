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

        .hidden
        {
            display: none;
        }
    </style>

    <div>
        <h1>
            Sicklists
            @if($current_user->role == 'manager')
                <button class="btn btn-success" id="createVacationBtn" data-bs-toggle="modal" data-bs-target="#saveVacationModal">
                    &nbsp;+&nbsp;
                </button>
            @endif
        </h1>
        <form class="filter-form" method="GET">
            <div>
                <label for="from_date">From Date:</label>
                <input type="date" id="from_date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div>
                <label for="to_date">To Date:</label>
                <input type="date" id="to_date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            @if($current_user->role == 'manager')
                <div>
                    <label for="employee_id">Employee:</label>
                    <select id="employee_id" name="employee_id" class="form-control">
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
        {{ $sicklists->links('partials.pagination') }}
    </div>

    <table class="vacation-table">
        <thead>
        <tr>
            <th></th>
            <th>Employee</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Description</th>
            <th>Days</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sicklists as $sicklist)
            <tr>
                <td data-vacation-id="{{$sicklist->id}}">
                    @if($current_user->role == 'manager')
                        <button class="btn btn-danger btn-sm deleteVacationBtn">
                            <span class="material-symbols-outlined">delete</span>
                        </button>&nbsp;
                        <button class="btn btn-warning btn-sm editVacationBtn">
                            <span class="material-symbols-outlined">edit</span>
                        </button>
                    @endif
                </td>
                <td data-label="Employee">{{ $sicklist->user->name }}</td>
                <td data-label="From Date">{{ $sicklist->from_date->format('Y-m-d') }}</td>
                <td data-label="To Date">{{ $sicklist->to_date->format('Y-m-d') }}</td>
                <td data-label="Description">{{ $sicklist->description }}</td>
                <td data-label="Days">{{ $sicklist->calculateWeekdays() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="saveVacationModal" tabindex="-1" aria-labelledby="saveVacationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="saveVacationModalLabel">New vacation entry</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="saveVacationForm">
                    <div class="modal-body">
                        <label>
                            From date:<br>
                            <input type="date" name="from_date" class="form-control" required>
                        </label><br>
                        <label>
                            To date:<br>
                            <input type="date" name="to_date" class="form-control" required>
                        </label><br>
                        @if($current_user->role == 'manager')
                            <label>
                                Employee:<br>
                                <select id="employee_id" name="employee_id" class="form-control">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </label><br>
                        @endif
                        <br>
                        <div class="alert alert-danger hidden" id="createVacationErrorDiv">
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

    <script>
        $(document).ready(function(){

            const error_div = $("#createVacationErrorDiv");
            const save_vacation_form = $('#saveVacationForm');

            let current_vacation_edit = null;

            $('#createVacationBtn').on('click', function(){ current_vacation_edit = null; });

            save_vacation_form.submit(function(event){
                event.preventDefault();

                const fields = $(this).serializeArray();
                if(current_vacation_edit != null)
                {
                    fields.push({name: 'id', value: current_vacation_edit});
                }
                error_div.addClass('hidden');

                $.post(`/save-vacation`, fields, function(data) {

                    if(data.success == true)
                    {
                        alert('Success!');
                        window.location.reload();
                    }
                    else
                    {
                        error_div.removeClass('hidden');
                        error_div.html(data.error);
                    }

                }).fail(function(response) {
                    console.error('Error:', response.responseText);
                });
            });

            $(".editVacationBtn").on('click', function(){

                const vacation_id = $(this).parent().attr('data-vacation-id');

                $.get(`/get-vacation/${vacation_id}`, {
                    vacation_id: vacation_id
                }, function(data) {
                    if(data.success)
                    {
                        current_vacation_edit = vacation_id;

                        save_vacation_form.find('input[name=from_date]').val(data.from_date);
                        save_vacation_form.find('input[name=to_date]').val(data.to_date);
                        save_vacation_form.find('select[name=employee_id]').val(data.employee_id);

                        $("#saveVacationModal").modal('show');
                    }
                }).fail(function(response) {
                    console.error('Error:', response.responseText);
                });

            });

            $(".deleteVacationBtn").on('click', function(){

                const vacation_id = $(this).parent().attr('data-vacation-id');
                if(confirm('Are you sure?'))
                {
                    $.post(`/delete-vacation/${vacation_id}`, {
                        vacation_id: vacation_id
                    }, function(data) {
                        if(data.success)
                        {
                            alert('Success!');
                            window.location.reload();
                        }
                    }).fail(function(response) {
                        console.error('Error:', response.responseText);
                    });
                }

            });

        });
    </script>
@endsection
