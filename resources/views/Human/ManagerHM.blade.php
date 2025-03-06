<!DOCTYPE html>
<html lang="en">

@include('Human.layouts.head')

<body class="bg-light">
    <!-- Header Bar -->
    @include('Human.layouts.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('Human.layouts.navigation')

            <!-- Main Content -->
            @include('Human.contents.ManagerHM')
        </div>
    </div>

    @include('Human.layouts.script')
</body>

</html>