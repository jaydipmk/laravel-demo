<!-- footer.blade.php -->
<footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="{{ url('/') }}">Your Company</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0
    </div>
</footer>

<script>
    function successMessage(message){
        Swal.fire({
            title: "Success",
            text:  message,
            icon: "success",
            timer: 1500,
            showCancelButton: false,
            showConfirmButton: false
        })
    }

    function errorMessage(message){
        Swal.fire({
            title: "Error",
            text: message,
            icon: "warning",
            timer: 1500,
            showConfirmButton: false,
            allowOutsideClick: false
        });
    }
</script>