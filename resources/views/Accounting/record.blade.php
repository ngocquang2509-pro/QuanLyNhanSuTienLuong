<!DOCTYPE html>
<html lang="en">

@include('Accounting.layouts.head')

<body class="bg-light">
    <!-- Header Bar -->
    @include('Accounting.layouts.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @if(Auth::user()->type == 'CTO')
            @include('CTO.layouts.navigation')
            @else
            @include('Accounting.layouts.navigation')
            @endif
            <!-- Main Content -->
            @include('Accounting.contents.record')
        </div>
    </div>

    @include('Accounting.layouts.script')
</body>

</html>