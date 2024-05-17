@extends('page-template')
@section('page-content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
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

        table {
            width: 100%;
            border-collapse: collapse;
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

    <h1>Holidays for {{$current_user->region}}</h1>
    <form action="{{ url('holidays') }}" method="GET">
        <label for="country_code">Select Country:</label>
        <select id="country_code" name="country_code" onchange="this.form.submit()">
            @foreach ($countries as $code => $name)
                <option value="{{ $code }}" {{ $countryCode == $code ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </form>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($holidays as $holiday)
            <tr>
                <td>{{ $holiday->name }}</td>
                <td>{{ $holiday->date }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">No holidays found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
