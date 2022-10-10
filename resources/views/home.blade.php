@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Welcome!') }}
                    <!-- Todo start-->
                    <h1>Todos</h1>
                    <hr>
                    
                    <h2>Add new task</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/todos')}}" method="post">
                        @csrf
                        <input type="text" name="task" id="task" class="form-control" placeholder="Add new task...">
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Add</button>
                    </form>
                    <hr>

                    <h2>Pending tasks</h2>
                    <ul class="list-group">
                    @foreach($todos as $todo)
                        @if (!$todo->status)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-8">{{ $todo->task }}</div>
                                    <div class="col-sm-4">
                                        <form action="{{ url('todos/'.$todo->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="task" value="{{ $todo->task }}">
                                            <input type="hidden" name="status" value="1">
                                            <button class="btn btn-success btn-sm" type="submit">Complete</button>
                                        </form>
                                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="false">
                                            Edit
                                        </button>

                                        <form action="{{ url('todos/'.$todo->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="collapse mt-2" id="collapse-{{ $loop->index }}">
                                    <div class="card card-body">
                                        <form action="{{ url('todos/'.$todo->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="task" value="{{ $todo->task }}">
                                            <input type="hidden" name="status" value="{{ $todo->status }}">
                                            <button class="btn btn-warning btn-sm" type="submit">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                    </ul>
                    <hr>

                    <h2>Completed Tasks</h2>
                    <ul class="list-group">
                    @foreach($todos as $todo)
                        @if ($todo->status)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-8">{{ $todo->task }}</div>
                                    <div class="col-sm-4">
                                        <form action="{{ url('todos/'.$todo->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="0">
                                            <input type="hidden" name="task" value="{{ $todo->task }}">
                                            <button class="btn btn-warning btn-sm" type="submit">Undo</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                    </ul>
                    <!-- /Todo end-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
