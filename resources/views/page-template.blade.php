<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertical Menu</title>
    <style>
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

</body>
</html>


