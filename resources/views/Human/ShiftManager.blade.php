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
            @include('Human.contents.ShiftManager')
        </div>
    </div>

    @include('Human.layouts.script')
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</html>