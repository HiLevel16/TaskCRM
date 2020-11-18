@extends('layouts.app')

@section('content')
<div class="row mt-1">
    <div class="col-md-12 col-md-offset-1">
        <div class="card">
            <form method="POST" action="{{ route('user.editPost') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $user->id }}">
                <table style="margin-bottom: 0" class="table table-striped task-table">
                    <thead>
                        <th>Edit a user</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle">
                              <div>Name</div>
                            </td>
                            <td>
                              <input name="name" type="text" class="form-control" placeholder="Username" value="{{$user->name}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>E-mail</div>
                            </td>
                            <td>
                              <input name="email" type="text" class="form-control" placeholder="Email" value="{{$user->email}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>New password</div>
                            </td>
                            <td>
                              <input name="password" type="password" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Role</div>
                            </td>
                            <td>
                                <div class="btn-group">
                                  <button id="role_dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$user->linkedRole->name}}
                                  </button>
                                  <div class="dropdown-menu">
                                      @foreach($roles as $role)
                                        <li><a data-id="{{$role->id}}" class="role_value dropdown-item" href="#">{{$role->name}}</a></li>
                                      @endforeach
                                  </div>
                                </div>
                                <input id="role" type="hidden" name="role" value="{{$user->linkedRole->id}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Projects</div>
                            </td>
                            <td>
                                <div class="overflow-auto" style="max-height: 80px">
                                    @foreach($projects as $project)
                                        <div class="custom-control custom-checkbox ml-2">
                                          <input name="projects[]" {{$user->hasProject($project->id) ? 'checked' : ''}} type="checkbox" value="{{$project->id}}" class="custom-control-input" id="{{$project->id}}">
                                          <label class="custom-control-label" for="{{$project->id}}">{{$project->name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" class="btn btn-primary" value="Update">
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection