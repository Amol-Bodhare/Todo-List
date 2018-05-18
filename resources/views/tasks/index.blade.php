<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css\index.blade.css" type="text/css"> 
    <title>Todo Application</title>
</head>
<body>
        <div id="app" style="background-color:midnightblue;">
                <nav class="navbar navbar-default navbar-static-top" style="background-color:midnightblue;">
                    <div class="container">
                        <div class="navbar-header">
        
                            <!-- Collapsed Hamburger -->
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                                <span class="sr-only">Toggle Navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
        
                            <!-- Branding Image -->
                            <a class="navbar-brand" href="{{ url('/') }}" style="color:white;">
                               Todo Application
                            </a>
                        </div>
        
                        <div class="collapse navbar-collapse" id="app-navbar-collapse">
                            <!-- Left Side Of Navbar -->
                            <ul class="nav navbar-nav">
                                &nbsp;
                            </ul>
        
                            <!-- Right Side Of Navbar -->
                            <ul class="nav navbar-nav navbar-right">
                                <!-- Authentication Links -->
                                @if (Auth::guest())
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                @else
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color:white;">
                                            {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>
        
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>
        
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>
        
                @yield('content')
            </div>
    <div class="container">
        <div class="col-md-offset-2 col-md-8">
            <div class="row">
                <h1>Todo App</h1>
            </div>

            

            {{-- display success message --}}
            @if (Session::has('success'))
                <div class="alert alert-success">
                   <strong>Success:</strong> {{ Session::get('success') }}
                </div>
            @endif
            
            {{-- display error message --}}
            @if (count($errors) > 0)
               <div class="alert alert-danger">
                    <strong>Error:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li> 
                        @endforeach       
                    </ul>   
                </div> 
            @endif

            <div class="row" style='margin-top: 10px; margin-bottom: 10px'>
                <form action="{{ route('tasks.store') }}" method='POST'>
                {{ csrf_field() }}
                    <div class="col-md-9">
                        <input type="text" name='taskName' class='form-control'>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class='btn btn-primary btn-block' value="Add Task">
                    </div>
                </form>
            </div>
            {{-- display stored tasks --}}
            @if (count($storedTasks) > 0)
                <table class="table">
                    <thead>
                        {{-- <th>Name </th>
                        <th>Edit </th>
                        <th>Select</th> --}}
                        
                    </thead>

                    <tbody>
                        @foreach ($storedTasks as $storedTask)
                        <tr class="row" >
                          <td class="col-md-8" @if ($storedTask->completed)
                                style="color: #A9A9A9;"
                            @endif   >{{ $storedTask->name }}</td>
                            <td class="col-md-2">
                                @if (!$storedTask->completed)
                                    <a href="{{ route('tasks.edit', ['tasks'=>$storedTask->id])}}" 
                                    class='btn btn-default'><i class="far fa-edit"></i></a>
                                @else
                                <form action="{{ route('tasks.destroy', [$storedTask->id]) }}" method='POST'>
                                        {{ csrf_field() }}
                                        
                                            <input type="hidden" name='_method' value='DELETE'>
                                            <button type="submit" class="btn btn-danger" value='Delete'><i class="fa fa-trash" aria-hidden="true"></i></button> 
                                        
                                           
                                </form> 
                                @endif
                            
                            </td>
                            
    
                            <td class="col-md-2">
                                <form action="{{ route('tasks.update', [$storedTask->id]) }}" method='POST'>
                                    {{ csrf_field() }}
                                <div class="btn-group" data-toggle="buttons">			
                                    <label class="btn 
                                    @if ($storedTask->completed)
                                        btn-success active
                                    @else
                                        btn-default
                                    @endif    
                                        ">
                                    
                                                <input type="hidden" name='_method' value='PUT'>
                                                                       
                                                       
                                                <input type="checkbox" name="checkBox" autocomplete="off" onchange="this.form.submit()" >
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </label>
                                </div>
                                </form>            
                            </td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div> 
    </div>
</body>
</html>