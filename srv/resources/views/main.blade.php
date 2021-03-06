<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Netberry Solutions</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="{{mix('/css/app.css')}}" rel="stylesheet">
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<div class="content flex-center position-ref full-height m-5">
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
        <div class="alert" id="success">
        </div>
        <form class="row gy-2 gx-3 align-items-center" id="form">
            <div class="col-6">
                <label class="visually-hidden" for="autoSizingInput">Tarea</label>
                <input type="text" class="form-control" id="task" name="task" placeholder="Nueva Tarea" required>
            </div>
            <div class="col-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="categories[]" id="categories1"
                           value="1">
                    <label class="form-check-label" for="categories1">PHP</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="categories[]" id="categories2"
                           value="2">
                    <label class="form-check-label" for="categories2">Javascript</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="categories[]" id="categories3"
                           value="3">
                    <label class="form-check-label" for="categories3">CSS</label>
                </div>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">A??adir</button>
            </div>
        </form>
        <div class="errors-container alert" id="errors">
        </div>
        @yield('content')
    </div>
</div>

<script>
    $(document).ready(function () {
        @stack('scripts')
        /****Create Task***/
        $("#form").submit(function (e) {
            e.preventDefault();
        }).validate({
            rules: {
                'categories[]': {
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                "categories[]": "Please select at least one category",
                "task": "Please input the task",
            },
            errorClass: "alert alert-danger",
            errorElement: "div",
            errorLabelContainer: $('#errors'),
            submitHandler: function (form, e) {
                let categories = [];
                $('input[type=checkbox]:checked').each(function () {
                    categories.push($(this).val());
                });
                e.preventDefault();
                $.ajax({
                    url: '{{route('tasks.store')}}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'task': $('#task').val(),
                        'categories': categories
                    },
                    success: function (resp) {
                        populateData(resp)
                        MessageUser('success','<p class="alert alert-success">Task created successfully</p>')
                    }
                }).fail(function (xhr, status, error) {
                    MessageUser('errors','<p class="alert alert-danger">Task cannot created</p>')
                    alert(`Oh noes! The AJAX request failed! ${error}`);
                });

            }
        });
    });
    const MessageUser = function (id,msgHtml) {
        let $Msg = $(`#${id}`);
        $Msg.attr("style","");
        $Msg.html(msgHtml)
        setTimeout(function () {
            $Msg.html('')
        }, 5000);
    }
    const deleteItem=function (e) {
        $(e).parents('tr').addClass('table-success');
        let id = $(e).attr("id");
        console.log(e, id);
        $.ajax({
            url: `api/tasks/${id}`,
            type: 'DELETE',
            data: {
                '_token': '{{ csrf_token() }}',
            },
            success: function (resp) {
                if (resp.message) {
                    MessageUser('success','<p class="alert alert-success">Task delete successfully</p>')
                    $(e).parents('tr').remove();
                } else if (resp.error) {
                    $(e).parents('tr').removeClass('table-success');
                    $(e).parents('tr').addClass('table-danger');
                    alert(`Oh noes! ${resp.error}`);
                } else {
                    $(e).parents('tr').removeClass('table-success');
                    $(e).parents('tr').addClass('table-danger');
                    alert(`Oh noes! error`);
                }
            }
        }).fail(function (xhr, status, error) {
            $(e).parents('tr').removeClass('table-success');
            $(e).parents('tr').addClass('table-danger');
            MessageUser('errors','<p class="alert alert-danger">Task cannot deleted</p>')
            alert(`Oh noes! The AJAX request failed! ${error}`);
        });
    }
</script>
</body>
</html>
