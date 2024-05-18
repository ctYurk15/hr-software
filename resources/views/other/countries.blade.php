@extends('page-template')
@section('page-content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>

    <h1>Countries List</h1>

    <!-- Form for Adding/Updating -->
    <form id="countryForm">
        @csrf
        <input type="hidden" id="countryId">
        <input type="text" id="name" placeholder="Country Name">
        <input type="text" id="country_code" placeholder="Country Code">
        <button type="submit">Save</button>
    </form>

    <table>
        <thead>
        <tr>
            <th>Country Name</th>
            <th>Country Code</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($countries as $country)
            <tr id="country_{{ $country->id }}">
                <td>{{ $country->name }}</td>
                <td>{{ $country->country_code }}</td>
                <td>
                    <button onclick="editCountry({{ $country->id }})">Edit</button>
                    <button onclick="deleteCountry({{ $country->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // AJAX setup to include CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //clean inputs
        $('#countryId').val('');
        $('#name').val('');
        $('#country_code').val('');

        // Function to handle adding or updating a country
        $('#countryForm').submit(function(e) {
            e.preventDefault();
            var id = $('#countryId').val();
            var postData = {
                name: $('#name').val(),
                country_code: $('#country_code').val()
            };
            var method = id ? 'PUT' : 'POST';
            var url = id ? '/countries/' + id : '/countries';

            $.ajax({
                type: method,
                url: url,
                data: postData,
                success: function(data) {
                    console.log('Success:', data);
                    location.reload();
                },
                error: function(response) {
                    console.log('Error:', response);
                    if (response.status === 422) { // Validation error
                        var errors = response.responseJSON.errors;
                        var errorMessages = [];
                        $.each(errors, function (key, value) {
                            errorMessages.push(value);
                        });
                        alert('Error: ' + errorMessages.join(', ')); // Displaying error messages
                    }
                }
            });
        });

        // Function to populate form for editing
        function editCountry(id) {
            var row = $('#country_' + id);
            $('#countryId').val(id);
            $('#name').val(row.find('td:eq(0)').text());
            $('#country_code').val(row.find('td:eq(1)').text());
        }

        // Function to delete a country
        function deleteCountry(id) {
            $.ajax({
                type: 'DELETE',
                url: '/countries/' + id,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    location.reload(); // Reload the page to see changes
                }
            });
        }
    </script>
@endsection
