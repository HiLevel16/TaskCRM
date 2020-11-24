<div id="filter">
    <div class="mt-1 mb-3">
        @if($filters['users']['show'])
            <div class="btn-group">
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Users
                    </button>
                    <div class="dropdown-menu">
                        <form class="px-2 overflow-auto" style="max-height: 250px">
                            @foreach($filters['users']['items'] as $user)
                                <div class="form-check dropdown-item">
                                    <input name="users" value="{{$user['id']}}" {{in_array($user['id'], $current['users']) ? 'checked' : ''}} type="checkbox" class="form-check-input" id="user_{{$user['id']}}">
                                    <label class="form-check-label" for="user_{{$user['id']}}">
                                        {{$user['label']}}
                                    </label>
                                </div>
                            @endforeach
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item js-clear-dropdown" href="#">Clear</a>
                    </div>
                </div>
            </div>
        @endif
        @if($filters['projects']['show'])
            <div class="btn-group">
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Projects
                    </button>
                    <div class="dropdown-menu">
                        <form class="px-2 overflow-auto" style="max-height: 250px;">
                            @foreach($filters['projects']['items'] as $project)
                                <div class="form-check dropdown-item bg-info">
                                    <input name="projects" value="{{$project['id']}}" {{in_array($project['id'], $current['projects']) ? 'checked' : ''}} type="checkbox" class="form-check-input" id="project_{{$project['id']}}">
                                    <label class="form-check-label" for="project_{{$project['id']}}">
                                        {{$project['label']}}
                                    </label>
                                </div>
                                @if(isset($project['child']))
                                    @foreach($project['child'] as $subProject)
                                        <div class="form-check dropdown-item ml-1">
                                            <input name="projects" value="{{$subProject['id']}}" {{in_array($subProject['id'], $current['projects']) ? 'checked' : ''}} type="checkbox" class="form-check-input" id="project_{{$subProject['id']}}">
                                            <label class="form-check-label" for="project_{{$subProject['id']}}">
                                                {{$subProject['label']}}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item js-clear-dropdown" href="#">Clear</a>
                    </div>
                </div>
            </div>
        @endif
        @if($filters['statuses']['show'])
            <div class="btn-group">
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Statuses
                    </button>
                    <div class="dropdown-menu">
                        <form class="px-2 overflow-auto" style="max-height: 250px;">
                            @foreach($filters['statuses']['items'] as $status)
                            <div class="form-check dropdown-item">
                                <input name="statuses" value="{{$status['label']}}" {{in_array($status['label'], $current['statuses']) ? 'checked' : ''}} type="checkbox" class="form-check-input" id="status_{{$status['label']}}">
                                <label class="form-check-label" for="status_{{$status['label']}}">
                                    {{$status['label']}}
                                </label>
                            </div>
                            @endforeach
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item js-clear-dropdown" href="#">Clear</a>
                    </div>
                </div>
            </div>
        @endif
        @if($filters['paymentSystems']['show'])
            <div class="btn-group">
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Payment systems
                    </button>
                    <div class="dropdown-menu">
                        <form class="px-2 overflow-auto" style="max-height: 250px;">
                            @foreach($filters['paymentSystems']['items'] as $paymentSystem)
                            <div class="form-check dropdown-item">
                                <input name="payments" value="{{$paymentSystem['id']}}" {{in_array($paymentSystem['id'], $current['payments']) ? 'checked' : ''}} type="checkbox" class="form-check-input" id="payment_{{$paymentSystem['id']}}">
                                <label class="form-check-label" for="payment_{{$paymentSystem['id']}}">
                                    {{$paymentSystem['label']}}
                                </label>
                            </div>
                            @endforeach
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item js-clear-dropdown" href="#">Clear</a>
                    </div>
                </div>
            </div>
        @endif
        @if($filters['categories']['show'])
            <div class="btn-group">
                <div class="dropdown">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categories
                    </button>
                    <div class="dropdown-menu">
                        <form class="px-2 overflow-auto" style="max-height: 250px;">
                            @foreach($filters['categories']['items'] as $category)
                            <div class="form-check dropdown-item">
                                <input name="categories" value="{{$category['id']}}" {{in_array($category['id'], $current['categories']) ? 'checked' : ''}} type="checkbox" class="form-check-input" id="category_{{$category['id']}}">
                                <label class="form-check-label" for="category_{{$category['id']}}">
                                    {{$category['label']}}
                                </label>
                            </div>
                            @endforeach
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item js-clear-dropdown" href="#">Clear</a>
                    </div>
                </div>
            </div>
        @endif
        @if($filters['date']['show'])
            <form class="btn-group">
                <div class="btn-group date datepicker mr-1" data-provide="datepicker" data-state="from">
                    <input name="date-from" type="text" class="form-control" placeholder="Date from (yyyy-mm-dd)" value="{{$current['date-from'] ?? ''}}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
                <div class="btn-group date datepicker" data-provide="datepicker" data-state="to">
                    <input name="date-to" type="text" class="form-control" placeholder="Date to (yyyy-mm-dd)" value="{{$current['date-to'] ?? ''}}">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </form>
        @endif
        <div class="btn-group">
            <input id="submit-filter" type="button" class="btn btn-success" value="Apply">
        </div>
    </div>
</div>