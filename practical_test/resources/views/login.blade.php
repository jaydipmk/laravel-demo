<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>


<div class="container mt-5">
    <h1 class="mb-3">login</h1>
    <form id="loginForm" class="row g-3">
        @csrf
        <div class="col-md-12">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="inputEmail4">
        </div>
        <div class="col-md-12">
            <label for="inputPassword4" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="inputPassword4">
        </div>
        <div class="col-12">
            <button type="submit" id="registerFormBtn" class="btn btn-primary">Login</button>
            <a href="{{route('register')}}" class="btn btn-primary">Register</a>
        </div>
    </form>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->


<script>

    $("#loginForm").submit(function (e) {
        e.preventDefault();
    }).validate({
        debug: false,
        errorClass: "error",
        errorElement: "span",
        rules: {
            email: {
                required: true,
                email: true
            },
            password: "required",
        },
        messages: {
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            $.ajax({
                url:"{{route('login-post')}}",
                type: "POST",
                data: new FormData(form),
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    $("span.error").remove();
                    if (dataResult.status) {
                        alert(dataResult.message)
                        window.location = "{{route('dashboard')}}";
                    } else {
                        if(dataResult.hasOwnProperty('error')) {
                            if (dataResult.error.hasOwnProperty('email')) {
                                $('#loginForm input[name="email"]').parent().append('<span class="error">' + dataResult.error.email + '</span>');
                            }
                            if (dataResult.error.hasOwnProperty('password')) {
                                $('#loginForm input[name="password"]').parent().append('<span class="error">' + dataResult.error.password + '</span>');
                            }
                        }
                        alert(dataResult.message)
                    }
                }
            });
        }
    });
</script>
</body>
</html>
