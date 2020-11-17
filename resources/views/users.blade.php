@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <table class="table table-striped task-table">

                    <thead>
                        <th>Users</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                            <!-- Имя задачи -->
                                <td class="table-text">
                                  <div>{{ $user->name }}</div>
                                </td>

                                <td>
                                  <!-- TODO: Кнопка Удалить, кнопка инфо (внутри будет "сменить статус") -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection