@extends('layouts.app')

@section('content')
<div class="row mt-1">
    <div class="col-md-12 col-md-offset-1">
        <div class="card">
            <form method="POST" action="{{ route('task.editPost') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{$task->id}}">
                <table style="margin-bottom: 0" class="table table-striped task-table">
                    <thead>
                        <th>Edit the task</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle">
                              <div>Name</div>
                            </td>
                            <td>
                              <input name="title" type="text" class="form-control" placeholder="Task title" value="{{$task->title}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Description</div>
                            </td>
                            <td>
                              <textarea name="description" class="form-control" aria-label="description">{{$task->description}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Amount</div>
                            </td>
                            <td>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <button id="currency_dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USD</button>
                                    <div class="dropdown-menu">
                                      <a class="currency_value dropdown-item" href="#">USD</a>
                                      <a class="currency_value dropdown-item" href="#">EUR</a>
                                      <a class="currency_value dropdown-item" href="#">RUB</a>
                                      <a class="currency_value dropdown-item" href="#">UAH</a>
                                      <a class="currency_value dropdown-item" href="#">BTC</a>
                                    </div>
                                    <input id="currency" name="currency" type="hidden" value="usd">
                                  </div><!-- /btn-group -->
                                  <input name="amount" type="text" class="form-control" aria-label="..." value="{{$task->amount['usd']}}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Status</div>
                            </td>
                            <td>
                                <div class="btn-group">
                                  <button id="status_dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$taskStatus->value}}
                                  </button>
                                  <div class="dropdown-menu">
                                      @foreach($taskStatus::getValues() as $st)
                                        <li><a class="status_value dropdown-item" href="#">{{$taskStatus::fromValue($st)}}</a></li>
                                      @endforeach
                                  </div>
                                </div>
                                <input id="status" type="hidden" name="status" value="{{$taskStatus::getValues()[0]}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Payment system</div>
                            </td>
                            <td>
                                <div class="btn-group">
                                  <button id="payment_dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      {{$task->paymentSystem->name}}
                                  </button>
                                  <div class="dropdown-menu">
                                      @foreach($paymentSystems as $paymentSystem)
                                        <li>
                                            <a data-id="{{$paymentSystem->id}}" class="payment_value dropdown-item" href="#">
                                                {{$paymentSystem->name}}
                                            </a>
                                        </li>
                                      @endforeach
                                  </div>
                                </div>
                                <input id="payment" type="hidden" name="payment_type" value="{{$task->paymentSystem->id}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Project</div>
                            </td>
                            <td>
                                <div class="btn-group">
                                  <button id="project_dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$userProjects[0]->name}}
                                  </button>
                                  <div class="dropdown-menu">
                                      @foreach($userProjects as $project)
                                        <li><a data-id="{{$project->id}}" class="project_value dropdown-item" href="#">{{$project->name}}</a></li>
                                      @endforeach
                                  </div>
                                </div>
                                <input id="project" type="hidden" name="project" value="{{$userProjects[0]->id}}">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">
                              <div>Category</div>
                            </td>
                            <td>
                                <div class="btn-group">
                                  <button id="category_dropdown" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$task->linkedCategory->name}}
                                  </button>
                                  <div class="dropdown-menu">
                                      @foreach($categories as $category)
                                        <li><a data-id="{{$category->id}}" class="category_value dropdown-item" href="#">{{$category->name}}</a></li>
                                      @endforeach
                                  </div>
                                </div>
                                <input id="category" type="hidden" name="category" value="{{$task->linkedCategory->id}}">
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