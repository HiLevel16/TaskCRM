<div class="mt-1 mb-3">
    <div class="btn-group">
        @if($filters['users']['show'])
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$current['user']->name ?? 'Users'}}
            </button>
            <div class="dropdown-menu">
                @foreach($filters['users']['items'] as $user)
                <a class="dropdown-item" href="{{route('task.list', $user['parameter'])}}">{{$user['label']}}</a>
                @endforeach
            </div>
        @endif
    </div>
    <div class="btn-group">
        @if($filters['projects']['show'])
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$current['project']->name ?? 'Projects'}}
            </button>
            <div class="dropdown-menu">
                @foreach($filters['projects']['items'] as $project)
                <a class="dropdown-item" href="{{route('task.list', $project['parameter'])}}">{{$project['label']}}</a>
                @endforeach
            </div>
        @endif
    </div>
    <div class="btn-group">
        @if($filters['statuses']['show'])
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$current['status']->name ?? 'Statuses'}}
            </button>
            <div class="dropdown-menu">
                @foreach($filters['statuses']['items'] as $status)
                <a class="dropdown-item" href="{{route('task.list', $status['parameter'])}}">{{$status['label']}}</a>
                @endforeach
            </div>
        @endif
    </div>
    <div class="btn-group">
        @if($filters['paymentSystems']['show'])
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$current['payment']->name ?? 'Payment systems'}}
            </button>
            <div class="dropdown-menu">
                @foreach($filters['paymentSystems']['items'] as $paymentSystem)
                <a class="dropdown-item" href="{{route('task.list', $paymentSystem['parameter'])}}">{{$paymentSystem['label']}}</a>
                @endforeach
            </div>
        @endif
    </div>
    <div class="btn-group">
        @if($filters['categories']['show'])
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$current['category']->name ?? 'Categories'}}
            </button>
            <div class="dropdown-menu">
                @foreach($filters['categories']['items'] as $category)
                <a class="dropdown-item" href="{{route('task.list', $category['parameter'])}}">{{$category['label']}}</a>
                @endforeach
            </div>
        @endif
    </div>
</div>