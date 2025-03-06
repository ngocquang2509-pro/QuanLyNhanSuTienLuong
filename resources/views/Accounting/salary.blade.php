<!DOCTYPE html>
<html lang="en">

@include('Accounting.layouts.head')

<body class="bg-light">
    <!-- Header Bar -->
    @include('Accounting.layouts.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('Accounting.layouts.navigation')

            <!-- Main Content -->
            @include('Accounting.contents.salary')
        </div>
    </div>

    @include('Accounting.layouts.script')
</body>

</html>