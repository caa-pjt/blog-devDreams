<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dev Dreams')</title>

    @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])

</head>
<body>


<div>

    @include('admin.partials.aside')

    <div id="right-panel" class="right-panel pb-5">

        @include('admin.partials.header')

        <div class="container-fluid">

            <livewire:flash-messages/>

            {{--<div class="content">

                @include("partiales.notification")

            </div>--}}

            <!-- Dashboard content -->
            <div class="content mt-2">
                @yield('content')
            </div>

        </div>

    </div>

</div>

@livewireScripts

</body>

</html>
