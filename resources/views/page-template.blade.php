<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{asset('libs/select2/select2.css')}}" rel="stylesheet">
    <link href="{{asset('libs/bootstrap/bootstrap.css')}}" rel="stylesheet">

    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('libs/select2/select2.js')}}"></script>
    <script src="{{asset('libs/bootstrap/bootstrap.js')}}"></script>

    <title>Vertical Menu</title>

    <style>

        /* Google icons */
        @font-face
        {
            font-family: 'Material Symbols Outlined';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.gstatic.com/s/materialsymbolsoutlined/v175/kJF1BvYX7BgnkSrUwT8OhrdQw4oELdPIeeII9v6oDMzByHX9rA6RzaxHMPdY43zj-jCxv3fzvRNU22ZXGJpEpjC_1v-p_4MrImHCIJIZrDCvHOej.woff2) format('woff2');
        }

        .material-symbols-outlined
        {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .menu {
            width: 200px;
            background-color: #f4f4f4;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: scroll;
        }
        .menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .menu li {
            border-bottom: 1px solid #ccc;
        }
        .menu li:last-child {
            border-bottom: none;
        }
        .menu a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px;
        }
        .menu a:hover {
            background-color: #ddd !important;
        }
        .menu li img {
            display: block;
            width: 100px; /* Reduced image size */
            margin: 0 auto 5px; /* Adjusted margin */
        }
        .menu li span {
            display: block;
            text-align: center;
        }
        .content {
            margin-left: 200px;
            padding: 20px;
        }
        .menu .selected a {
            background-color: #ccc; /* Selected item background color */
        }

        .top-right-sidebar
        {
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .logout-button
        {
            color: black;
        }

        .logout-button span
        {
            font-size: 50px;
        }

        .logout-button span:hover
        {
            color: gray;
            transition: 0.3s ease;
        }
    </style>
</head>
<body>

<div class="menu">
    <ul>
        @foreach ($menu as $item)
            @if(!$item['manager_page'] || ($item['manager_page'] && $user_role == 'manager'))
                <li @if($item['route_name'] == $route_name) class="selected" @endif>
                    <a href="{{ $item['link'] }}">
                        <img src="{{ $item['image'] }}" alt="Image 1">
                        <span>{{ $item['title'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>

<div class="content">
    @yield('page-content')
</div>

<div class='top-right-sidebar'>
    <a href="{{ route('logout') }}" class='logout-button'>
        <span class="material-symbols-outlined">logout</span>
    </a>
</div>

</body>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

</html>


