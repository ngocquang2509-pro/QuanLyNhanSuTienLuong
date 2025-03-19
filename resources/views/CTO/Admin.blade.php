<!DOCTYPE html>
<html lang="en">

@include('CTO.layouts.head')

<body class="bg-light">
    <!-- Header Bar -->
    @include('CTO.layouts.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('CTO.layouts.navigation')

            <!-- Main Content -->
            @include('admin.contents.dashboard')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>