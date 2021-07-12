@extends('main')
@section('content')
    <table class="table table-striped display" id="table-task" style="width:100%">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tarea</th>
            <th scope="col">Categoría</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
@push('scripts')

    $.ajax({
        type: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Access-Control-Allow-Origin': '*'
        },
        url: '{{route('tasks.index')}}',
        dataType: "json",
        success: function (data){
            populateData(data)
        }
    });
    function populateData(data) {
        console.log(data)
        let taskTable = $('#table-task tbody');
        taskTable.empty();
        $('#table-task').show();
        let len = data.length;
        for (var i = 0; i < len; i++) {
            let id = data[i].id;
            let taskName = data[i].name_task;
            let categoriesNames = data[i].categories_names.map(category=>category.category_name).join(",");
            taskTable.append(`<tr><td> ${id}</td><td>${taskName}</td>
                <td>${ categoriesNames}</td><td><button id="${data[i].id}" onclick="deleteItem(this)"><i class="delete bi bi-x-circle" ></i></button></td>`);
        }
    }
@endpush

