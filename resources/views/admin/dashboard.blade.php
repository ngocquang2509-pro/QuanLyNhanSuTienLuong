<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.head')

<body class="bg-light">
    <!-- Header Bar -->
    @include('admin.layouts.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @if(Auth::user()->type == 'CTO')
            @include('CTO.layouts.navigation')
            @else
            @include('Human.layouts.navigation')
            @endif
            <!-- Main Content -->
            @include('admin.contents.dashboard')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>