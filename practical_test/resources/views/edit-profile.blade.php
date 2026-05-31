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
    <div class="d-flex justify-content-between">
        <a href="{{route('logout')}}">logout</a>
        <a href="{{route('dashboard')}}">dashboard</a>
    </div>

    <h1 class="mb-3">Profile</h1>
    <form id="profileForm" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label for="inputFirstName" class="form-label">First Name</label>
            <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" id="inputFirstName">
        </div>
        <div class="col-md-6">
            <label for="inputLastName" class="form-label">Last Name</label>
            <input type="text" name="last_name"  value="{{$user->last_name}}" class="form-control" id="inputLastName">
        </div>
        <div class="col-md-12">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" name="email"  value="{{$user->email}}" class="form-control" id="inputEmail4">
        </div>
        <div class="col-12">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" name="address"  value="{{$user->address}}" class="form-control" id="inputAddress" placeholder="1234 Main St">
        </div>
        <div class="col-md-6">
            <label for="inputGender" class="form-label">Gender</label>
            <select id="inputGender" name="gender" class="form-select">
                <option <?php if($user->gender == 'female'){ echo "selected";} ?> value="female">Female</option>
                <option <?php if($user->gender == 'male'){ echo "selected";} ?> value="male">Male</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputZip" class="form-label">birth date</label>
            <input type="date" name="birth_date"  value="{{$user->birth_date}}" class="form-control" id="inputZip">
        </div>
        <div class="col-12">
            <label for="formFile" class="form-label">profile pic</label>
            <input class="form-control" name="image" type="file" id="formFile">
            <img src="{{asset('images').'/'.$user->image}}" class="figure-img img-fluid rounded" alt="...">
        </div>
        <div class="col-12">
            <button type="submit" id="registerFormBtn" class="btn btn-primary">Update</button>
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

    $("#profileForm").submit(function (e) {
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
            birth_date: "required",
            gender: "required",
            address: "required",
        },
        messages: {
        },
        submitHandler: function (form, event) {
            event.preventDefault();
            $.ajax({
                url:"{{route('profile-update')}}",
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
                        if(dataResult.error.email)
                            $('#profileForm input[name="email"]').parent().append('<span class="error">'+dataResult.error.email+'</span>');
                        if(dataResult.error.first_name)
                            $('#profileForm input[name="first_name"]').parent().append('<span class="error">'+dataResult.error.first_name+'</span>');
                        if(dataResult.error.last_name)
                            $('#profileForm input[name="last_name"]').parent().append('<span class="error">'+dataResult.error.last_name+'</span>');
                        if(dataResult.error.password)
                            $('#profileForm input[name="password"]').parent().append('<span class="error">'+dataResult.error.password+'</span>');
                        if(dataResult.error.birth_date)
                            $('#profileForm input[name="birth_date"]').parent().append('<span class="error">'+dataResult.error.birth_date+'</span>');
                        if(dataResult.error.gender)
                            $('#profileForm select[name="gender"]').parent().append('<span class="error">'+dataResult.error.gender+'</span>');
                        if(dataResult.error.address)
                            $('#profileForm input[name="address"]').parent().append('<span class="error">'+dataResult.error.address+'</span>');
                        if(dataResult.error.image)
                            $('#profileForm input[name="image"]').parent().append('<span class="error">'+dataResult.error.image+'</span>');

                    }
                }
            });
        }
    });
</script>
</body>
</html>
