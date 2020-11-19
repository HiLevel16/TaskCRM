@extends('layouts.app')

@section('content')
<div class="row mt-1">
    <div class="col-md-12 col-md-offset-1">
        <div class="card">
            <form method="POST" action="{{ route('role.addPost') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table style="margin-bottom: 0" class="table table-striped task-table">
                    <thead>
                        <th>Create a role</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle">
                              <div>Name</div>
                            </td>
                            <td>
                              <input name="name" type="text" class="form-control" placeholder="Role name" value="{{old('label') ?? ''}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Slug</div>
                            </td>
                            <td>
                              <input name="slug" type="text" class="form-control" placeholder="Slug (lower case without spaces)" value="{{old('slug') ?? ''}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Permissions</div>
                            </td>
                            <td>
                                <div class="overflow-auto" style="max-height: 180px">
                                    @foreach($allPermissions as $permission)
                                        <div class="custom-control custom-checkbox ml-2">
                                          <input name="permissions[]" {{old('permissions') != null ? (in_array($permission->id, old('permissions')) ? 'checked' : '') : ''}} type="checkbox" value="{{$permission->id}}" class="custom-control-input" id="{{$permission->id}}">
                                          <label class="custom-control-label" for="{{$permission->id}}">{{$permission->label}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" class="btn btn-primary" value="Create">
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