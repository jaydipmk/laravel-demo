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
<body>


<div class="container mt-5">
    <h1 class="mb-3">register</h1>
    <form id="registerForm" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label for="inputFirstName" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" id="inputFirstName">
        </div>
        <div class="col-md-6">
            <label for="inputLastName" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" id="inputLastName">
        </div>
        <div class="col-md-12">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="inputEmail4">
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="inputPassword4">
        </div>
        <div class="col-md-6">
            <label for="inputPassword5" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="inputPassword5">
        </div>
        <div class="col-12">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="inputAddress" placeholder="1234 Main St">
        </div>
        <div class="col-md-6">
            <label for="inputGender" class="form-label">Gender</label>
            <select id="inputGender" name="gender" class="form-select">
                <option value="" selected>select Gender</option>
                <option value="female">Female</option>
                <option value="male">Male</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputZip" class="form-label">birth date</label>
            <input type="date" name="birth_date" class="form-control" id="inputZip">
        </div>
        <div class="col-12">
            <label for="formFile" class="form-label">profile pic</label>
            <input class="form-control" name="image" type="file" id="formFile">
        </div>
        <div class="col-12">
            <button type="submit" id="registerFormBtn" class="btn btn-primary">Register</button>
            <a href="{{route('login')}}" class="btn btn-primary">Login</a>
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

    $("#registerForm").submit(function (e) {
        e.preventDefault();
    }).validate({
        debug: false,
        errorClass: "error",
        errorElement: "span",
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true
            },
            password: "required",
            password_confirmation: "required",
            birth_date: "required",
            gender: "required",
            address: "required",
            image: "required",
        },
        messages: {
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            $.ajax({
                url:"{{route('register-post')}}",
                type: "POST",
                data: new FormData(form),
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    $("span.error").remove();
                    if (dataResult.status) {
                       alert(dataResult.message)
                        window.location = "{{route('login')}}";
                    } else {
                        if(dataResult.error.email)
                            $('#registerForm input[name="email"]').parent().append('<span class="error">'+dataResult.error.email+'</span>');
                        if(dataResult.error.first_name)
                            $('#registerForm input[name="first_name"]').parent().append('<span class="error">'+dataResult.error.first_name+'</span>');
                        if(dataResult.error.last_name)
                            $('#registerForm input[name="last_name"]').parent().append('<span class="error">'+dataResult.error.last_name+'</span>');
                        if(dataResult.error.password)
                            $('#registerForm input[name="password"]').parent().append('<span class="error">'+dataResult.error.password+'</span>');
                        if(dataResult.error.birth_date)
                            $('#registerForm input[name="birth_date"]').parent().append('<span class="error">'+dataResult.error.birth_date+'</span>');
                        if(dataResult.error.gender)
                            $('#registerForm select[name="gender"]').parent().append('<span class="error">'+dataResult.error.gender+'</span>');
                        if(dataResult.error.address)
                            $('#registerForm input[name="address"]').parent().append('<span class="error">'+dataResult.error.address+'</span>');
                        if(dataResult.error.image)
                            $('#registerForm input[name="image"]').parent().append('<span class="error">'+dataResult.error.image+'</span>');

                    }
                }
            });
        }
    });
</script>
</body>
</html>
