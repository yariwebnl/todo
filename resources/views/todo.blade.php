<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <script src="js/app.js"></script>
        <script>window.onload = function(){
             var app1 = new Vue ({
                    el: '#app1',
                    data: {
                     message: 'To-do list',
                    }
                })

             var app2 = new Vue ({
                    el: '#app2',
                    data: {
                     message: 'Vue & Laravel',
                    }
                }) 

             var app3 = new Vue ({
                    el: '#app3',
                    data: {
                     todos: [

                     ]
                    },
                    methods: {
                        add: function(){
                            var task = document.getElementById('addtask').value;
                            if (task.length > 0){
                           app3.todos.push({ text: task, done: false }); 
                             }
                        },
                        del: function(index){
                            this.todos.splice(index, 1);
                        }
                    }
                })
            }
        </script>

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <?php
                        if (session()->has('data')){
                            echo "<a>Welkom, " . session('data')[0] . "</a>";
                        }
                        ?>
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div id="app2" class="title m-b-md">
                    @{{ message }}
                </div>
                <h1 id="app1">@{{ message }}</h1>

                @include('common.errors')

                <form action="{{ url('todo') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="centerform form-group">
                        <div class="col-sm-6">
                            <input type="text" name="name" id="todo-name" class="form-control">
                        </div>
                    </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="top btn btn-default">
                        <i class="fa fa-plus"></i> Add Task
                    </button>
                </form>
                </div>
            </div>
            <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Todo</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($todos as $todo)
                            <tr>
                                <!-- Task Name -->
                                <td class="table-next">
                                    <div>{{ $todo->name }}</div>
                                </td>

                                <td>
                                    <!-- Delete Button -->
                                    <form action="{{ url('todo/'.$todo->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-danger">Delete
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div  id="app3" class="links">
                    <div class="todolist" v-for="(todo, index) in todos">
                        <span v-bind:class="{ 'strikethrough': todo.done}">@{{ todo.text }}
                        </span>
                        <i class="d-none fas fa-check-circle" v-bind:class="{ 'd-inline': todo.done }"></i>
                        <button class='btn btn-success' v-on:click="todo.done = true">Finish
                            <i class="fas fa-check-square"></i>
                        </button>
                        <button class='btn btn-danger' v-on:click="del(index)">Delete
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <br>
                    <input class="form-control" id='addtask' type="text">
                    <br>
                    <button class="btn btn-secondary floor" v-on:click="add()">Add task</button>
                </div>
            </div>
        </div>
    </body>
</html>
