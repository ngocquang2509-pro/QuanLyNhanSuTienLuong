<!DOCTYPE html>
<html lang="en">

@include('Human.layouts.head')

<body class="bg-light">
    <!-- Header Bar -->
    @include('Human.layouts.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @if(Auth::user()->type == 'CTO')
            @include('CTO.layouts.navigation')
            @else
            @include('Human.layouts.navigation')
            @endif
            <!-- Main Content -->
            @include('Human.contents.timekeeping')
        </div>
    </div>

    @include('Human.layouts.script')
</body>

</html>