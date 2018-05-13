<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css\index.blade.css" type="text/css"> 
    <title>Todo Application</title>
</head>
<body>
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
                        <th>Name </th>
                        <th>Edit </th>
                        <th>Status </th>
                        
                        
                    </thead>

                    <tbody>
                        @foreach ($storedTasks as $storedTask)
                        <tr @if ($storedTask->completed)
                                class="strikeout"
                                @endif>
                          
                            <td>{{ $storedTask->name }}</td>
                        <td><a href="{{ route('tasks.edit', ['tasks'=>$storedTask->id])}}" class='btn btn-default'>Edit</a></td>
                            
                            <td>
                                @if ($storedTask->completed)
                                    Completed
                                
                                @else
                                    Pending
                                @endif  
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