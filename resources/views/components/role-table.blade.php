<div class="row">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <th scope="row">{{$role->id}}</th>
                    <td>{{$role->name}}</td>
                    <td>{{$role->slug}}</td>
                    <td>
                        <div class="d-flex float-right">
                            <form class="mr-1" id="delete_{{$role->id}}" action="{{route('role.delete')}}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete" />
                                <input type="hidden" name="id" value="{{$role->id}}" />
                                <a href="#" onclick="
                                document.getElementById('delete_{{$role->id}}').submit();
                                "><i class="fa fa-trash fa-lg"></i></a>
                            </form>
                            &nbsp;
                            <a href="{{route('role.edit', ['id' => $role->id])}}">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>