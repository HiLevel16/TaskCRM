<div class="row">
    @foreach($tasks as $task)
        <div class="col-sm-4">
            <div class="card border-secondary mb-3" style="max-width: 18rem;">
                <div class="card-header d-inline">
                    <div class="float-left">{{$task->status}}</div>
                    <div class="float-right">
                        @if(($task->id == \Illuminate\Support\Facades\Auth::id()
                        && \Illuminate\Support\Facades\Auth::user()->hasPermission('edit_own_task'))
                        || (\Illuminate\Support\Facades\Auth::user()->hasPermission('edit_all_task')))
                        <a href="{{route('task.edit', ['id' => $task->id])}}">
                            <i class="fa fa-edit"></i>
                        </a>
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