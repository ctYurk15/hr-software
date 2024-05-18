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

        .red
        {
            color: red;
        }
    </style>

    @if($user != null)
        <h1 style="text-align: center">Edit {{$user->name}}</h1>
    @else
        <h1 style="text-align: center">New user</h1>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" style="width: 60%">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="d-flex justify-content-center">
            <div class="alert alert-danger" style="width: 60%">
                @foreach ($errors->getMessages() as $field => $messages)
                    <strong>{{ $fields[str_replace('fields.', '', $field)]['title'] }}:</strong>
                    <ul>
                        @foreach ($messages as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    @endif

    <form method="POST" action="{{route('save-personal')}}">
        @csrf
        @if($user != null) <input type="hidden" name="id" value="{{$user->id}}"> @endif
        <table class="user-details-table">
            <tbody>
            <tr><th>Field</th><th>Value</th></tr>
            @foreach ($fields as $name => $data)
                @if(($name == 'password' || $name == 'password_confirmation') && $user != null) @continue @endif
                <tr>
                    <td>{{ $data['title'] }} @if(isset($data['required']) && $data['required']) <span class="red">*</span> @endif</td>
                    <td>
                        @if(isset($data['options']))
                            <select name="fields[{{$name}}]" @if(isset($data['required']) && $data['required']) required @endif>
                                @foreach($data['options'] as $option)
                                    <option value="{{$option}}"
                                            @if($user != null && $user->$name == $option) selected @endif
                                    >{{$option}}</option>
                                @endforeach
                            </select>
                        @elseif($data['type'] == 'relation')
                            @php
                                $model = $data['relation_model'];
                                $options = $model::all();
                            @endphp
                            <select name="fields[{{$name}}]" @if(isset($data['required']) && $data['required']) required @endif>
                                @foreach($options as $option)
                                    <option value="{{$option->id}}"
                                            @if($user != null && $user->$name == $option->id) selected @endif
                                    >{{$option->name}}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="{{$data['type']}}"
                                   name="fields[{{$name}}]"
                                   @if($user != null) value="{{$user->$name}}" @endif
                                   @if(isset($data['required']) && $data['required']) required @endif
                            >
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <button class="btn btn-success">Save</button>
        </div>
    </form>
@endsection
