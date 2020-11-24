<div class="row">
    @foreach($tasks as $task)
        <div class="col-sm-3">
            <div class="card border-secondary mb-3" style="max-width: 18rem;">
                <div class="card-header d-inline">
                    <div class="float-left">{{$task->status}}</div>
                    <div class="float-right d-flex">
                        @if(($task->fromId == \Illuminate\Support\Facades\Auth::id()
                        && \Illuminate\Support\Facades\Auth::user()->hasPermission('edit_own_task'))
                        || (\Illuminate\Support\Facades\Auth::user()->hasPermission('edit_all_task')))
                        <a class="mr-2" href="{{route('task.edit', ['id' => $task->id])}}">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endif
                        @if(($task->fromId == \Illuminate\Support\Facades\Auth::id()
                        && \Illuminate\Support\Facades\Auth::user()->hasPermission('delete_own_task'))
                        || (\Illuminate\Support\Facades\Auth::user()->hasPermission('delete_all_task')))
                        <form id="delete_{{$task->id}}" action="{{route('task.delete')}}" method="POST">
                            {{ csrf_field() }}
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{$task->id}}" />
                            <a href="#" onclick="
                            document.getElementById('delete_{{$task->id}}').submit();
                            "><i class="fa fa-trash"></i></a>
                        </form>
                        @endif

                    </div>
                </div>
              <div class="card-body text-secondary">
                <h5 class="card-title">{{$task->title}}</h5>
                <p class="card-text">{{$task->description}}</p>
              </div>
              <div class="card-footer bg-transparent border-success">Footer</div>
            </div>
        </div>
    @endforeach
</div>