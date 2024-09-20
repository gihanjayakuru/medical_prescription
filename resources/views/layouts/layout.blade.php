<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Your Application')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Top Navbar -->
    <nav style="background-color: #f8f9fa; padding: 10px;">
        <ul style="list-style-type: none; margin: 0; padding: 0; display: flex;">
            <li style="margin-right: 15px;">
                <a href="{{ route('dashboard') }}" style="text-decoration: none; color: #000;">Dashboard</a>
            </li>
            <li style="margin-right: 15px;">
                <a href="{{ route('user.quotations') }}" style="text-decoration: none; color: #000;">My Quotations</a>
            </li>


            @auth
 
            <li style="margin-left: auto;">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"
                        style="background: none; border: none; cursor: pointer; color: #007bff; font-size: 16px;">
                        Logout
                    </button>
                </form>
            </li>
            @endauth
        </ul>
    </nav>

    <!-- Page Content -->
    <div class="container" style="padding: 20px;">
        @yield('content')

    </div>


    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>