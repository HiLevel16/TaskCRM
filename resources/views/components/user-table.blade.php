<div class="row">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <div class="d-flex float-right">
                            <form class="mr-1" id="delete_{{$user->id}}" action="{{route('user.delete')}}" method="POST">
                                {{ csrf_field() }}
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{$user->id}}" />
                                <a href="#" onclick="
                                document.getElementById('delete_{{$user->id}}').submit();
                                "><i class="fa fa-trash fa-lg"></i></a>
                            </form>
                            &nbsp;
                            <a href="{{route('user.edit', ['id' => $user->id])}}">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>