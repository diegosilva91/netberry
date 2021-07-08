<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Netberry Solutions</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{mix('/css/app.css')}}" rel="stylesheet">
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<div class="content flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="mt-4 container">
        <h1>Gestor de tareas</h1>
        <hr class="my-12">
        <form class="row gy-2 gx-3 align-items-center" id="form">
            <div class="col-auto">
                <label class="visually-hidden" for="autoSizingInput">Tarea</label>
                <input type="text" class="form-control" id="task" name="task" placeholder="Nueva Tarea" required>
            </div>
            <div class="col-auto">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="categories[]" id="categories1"
                           value="0">
                    <label class="form-check-label" for="inlineRadio1">PHP</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="categories[]" id="categories2"
                           value="1">
                    <label class="form-check-label" for="inlineRadio2">Javascript</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="categories[]" id="categories3"
                           value="2">
                    <label class="form-check-label" for="inlineRadio3">CSS</label>
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Añadir</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $.ajax({
            type: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Access-Control-Allow-Origin': '*'
            },
            url: '',
            dataType: "json",
            success: function(data) {
            }
        });
        $("#form").submit(function (e) {
            e.preventDefault();
        }).validate({
            rules: {
                'categories[]': {
                    required: true,
                }
            },
            errorClass: "alert alert-danger",
            submitHandler: function (form, e) {
                let categories = [];
                $('input[type=checkbox]:checked').each(function () {
                    categories .push($(this).val());
                });
                e.preventDefault();
                alert(categories);
                $.ajax({
                    url: '{{route('task')}}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'task' : $('#task').val(),
                        'categories':categories
                    },
                    success: function (resp) {
                    }
                });

            }
        });
    });
</script>
</body>
</html>
