@php
function Prioritiespill($whichone) {
    if ($whichone == 'Low') //1
    echo "<span class='badge rounded-pill bg-success'>Low</span>";
    if ($whichone == 'Medium') //3
    echo "<span class='badge rounded-pill bg-warning text-dark'>Medium</span>";
    if ($whichone == 'High') //5
    echo "<span class='badge rounded-pill bg-danger'>High</span>";
}
@endphp
<!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/model.css')}}">
        <title>Collator</title>
    </head>
    <body>

        <br>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-auto">
                    Mentor()
                </div>
                <div class="col-md-auto">
                    =
                </div>
                <div class="col-md-auto">
                    Mentee({{ $mentee->name }})
                </div>
                
            </div>
            <div class="row justify-content-md-center">
                <div class="col-md-auto">
                    Mentoring Cycle: 90 days
                </div>
                <div class="col-md-auto">
                    Time Remaining
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 25%"
                        aria-valuenow="25"
                        aria-valuemin="0"
                        aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <br>

            <div class="row justify-content-md-center">
                <div class="col-md-auto">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            Areas to Develop
                            @if ($currentuser->type == "Mentor")
                                <button
                                id="BtnAreatoDevelop"
                                class="btn btn-primary float-end"
                                onclick="show_my_receipt()"
                                type="button">+</button>
                                @else
                                <button
                                id="BtnAreatoDevelop"
                                class="btn btn-primary float-end"
                                onclick="show_my_receipt()"
                                disabled
                                type="button">+</button>
                                @endif

                        </div>
<ul class="list-group list-group-flush">
                        @if (isset($mentorings)) 
                        @foreach ($mentorings as $mentoring)
                        <li class="list-group-item">
                            {{ ($mentoring->title) }}
                         
                        <form class="" action="{{ url('/newmentoring', $mentoring->id) }}" method="post">
                        <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
            <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
                            <input type="submit" value="x" name="x" class="btn btn-danger float-end">
                            
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                        </form>
                    
                        
                        <div class="progress">
                            <div
                            class="progress-bar"
                            role="progressbar"
                            style="width:0%"
                            aria-valuenow="25"
                            aria-valuemin="0"
                            aria-valuemax="100"></div>
                        </div>

                    </li>
                    @endforeach
                  
                     @endif
                 
                   
                     
                </ul>

            </div>
            <br>
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Tasks
                    @if ($currentuser->type == "Mentor")
                        <button id="BtnAddActivity" class="btn btn-primary float-end" type="button">+</button>
                        @else
                        <button id="BtnAddActivity" disabled class="btn btn-primary float-end" type="button">+</button>
                    @endif

                </div>
                <ul class="list-group list-group-flush">
                    @if (isset($tasks)) @foreach ($tasks as $task)

                    <li class="list-group-item">{{ ($task->title) }}

                        {{ Prioritiespill($task->priority) }}
                        
                        @if($task->status != "Done")
                        <form class="" action="{{ url('/newtask', $task->id) }}" method="post">
                        <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
                         <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
                        <input type="submit" value="Done" name="Done" class="btn btn-warning float-end">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                    </form>
                    @endif
                        <form class="" action="{{ url('/newtask', $task->id) }}" method="post">
                        <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
                    <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
                        <input type="submit" value="x" name="x" class="btn btn-danger float-end">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                    </form>
                    </li>

                    @endforeach
                    
                    @endif

                  
                </ul>
            </div>
            <br>
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Documents

                        <button id="BtnAddProject" class="btn btn-primary float-end" type="button">+</button>

                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Marketing Plan</li>
                    <li class="list-group-item">Business Model Canvas</li>
                    @if (isset($documents))
                    @foreach ($documents as $document )
                    <?php
                    $doc= $document->document;
                    echo $ppath =base_path();
                    $filepath = public_path('storage\\');
                    $total = $filepath.$doc;
                    $testhere = "storage/images/".$document->document;
                 
                   //http://127.0.0.1:8000/storage/images/1656033024FOs09b6XwAAG7IN.jpg
                   
                   //{{ asset('/storage/images//storage/images/1656000112FOs09b6XwAAG7IN.jpg')}}
                   ?>
                   
                   <img src="{{ asset('/storage/images/1656033024FOs09b6XwAAG7IN.jpg')}}" alt = 'no image' width= '50' height='50' class="img img-responsive" />
                    <img src="<?php echo asset(''.$testhere.'')?>" alt = 'no image' width= '50' height='50' class="img img-responsive" />
                    @endforeach
                @endif
                </ul>
            </div>
        </div>
        <div class="col-md-auto">
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Live Chat
                        <button id="BtnLiveChat" class="btn btn-primary float-end" type="button">+</button>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Chat Box
                    @if (isset($chats))
                    @foreach ($chats as $chat )
                 
                   @if ($chat->mentee != $chat->mentor)
                    <div class="alert alert-primary" role="alert">
                    @else
                    <div class="alert alert-success" role="alert">
                    @endif
                    {{ $chat->message }}
                    ({{ $chat->created_at }})
                    
                          </div>
                          
                @endforeach
                @endif
                
                      
                    </li>
                </ul>
            </div>
            <br>
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Meetings
                        <button id="BtnMeetings" class="btn btn-primary float-end" type="button">+</button>
                </div>
                <ul class="list-group list-group-flush">
                    @if (isset($meetingrequests)) @foreach ($meetingrequests as $meetingrequest)
                    <li class="list-group-item">{{ ucfirst($meetingrequest->Text) }}
                        <form

                    action="{{ url('/newmeeting', $meetingrequest->id) }}"
                    method="post">
                    <input type="submit" value="x" name="x" class="btn btn-danger float-end">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                </form>
                    </li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Add Area to Develop</h2>
        </div>
        <div class="modal-body">
            <form
            class="form-horizontal"
            action="{{ url('/newmentoring') }}"
            method="post"
            role="form">
            <input type='text' class='form-control' placeholder='title' name='title'>
            <input value="Add" type='submit' class="btn btn-primary">
            <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
            <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
            {{ csrf_field() }}
        </form>
    </div>
    <div class="modal-footer">

    </div>
</div>
</div>

<div id="myModal2" class="modal">
    <!-- Modal content -->
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">

            <h2>Add Task</h2>
        </div>
        <div class="modal-body">
            <form
            class="form-horizontal"
            action="{{ url('/newtask') }}"
            method="post"
            role="form">
            <input type='text' class='form-control' placeholder='Title' name='title'>
            <textarea class="form-control" id="Description" name="Description" rows="3"></textarea>

            @if (isset($mentorings))
            <select name='mentoring_id' class="form-control">
                @foreach ($mentorings as $mentoring)
                <option value="{{$mentoring->id}}">{{ ucfirst($mentoring->title) }}</option>
                @endforeach
            </select>
            @endif
            <select class="form-control" name='priority'>
                <option>High</option>
                <option>Medium</option>
                <option>Low</option>
            </select>
            <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
            <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
            <input type='submit'>
            {{ csrf_field() }}
        </form>
    </div>
    <div class="modal-footer">

    </div>
</div>
</div>

<div id="myModal3" class="modal">
    <!-- Modal content -->
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">

            <h2>Adding Document</h2>
        </div>
        <div class="modal-body">

        <form  id="upload-file" action="{{ url('/documentsadd') }}" method="post" enctype="multipart/form-data">
            
        <input type='text' class='form-control' placeholder='title' name='title'>
        <input class="form-control" name="document" type="file" id="document">
        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe the doc"></textarea>
        
        <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
        <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
        {!! csrf_field() !!}
        <input type="submit" value="Save" class="btn btn-success">
        

        </form>


            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>

    <div id="myModal4" class="modal">
        <!-- Modal content -->
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">

                <h2>Live Chat</h2>
            </div>
            <div class="modal-body">
            <form
            class="form-horizontal"
            action="{{ url('/newchat') }}"
            method="post"
            role="form">
                
                <textarea class="form-control" id="message" name="message" rows="3" placeholder="Type Your Message "></textarea>
            <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
            <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
            {{ csrf_field() }}
                    <input type='submit'></form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>

        <div id="myModal5" class="modal">
            <!-- Modal content -->
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">

                    <h2>Meetings</h2>
                </div>
                <div class="modal-body">
                    <form
                    class="form-horizontal"
                    action="{{ url('/newmeeting') }}"
                    method="post"
                    role="form">
                   
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe why needed this meeting"></textarea>
                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="notes"></textarea>
                    <input type='text' class='form-control' placeholder='URL for Meeting' name='URL'>
                    <input type='date' class='form-control' placeholder='Date' name='date'>
                   
    


                    <input value="Add" type='submit' class="btn btn-primary">
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset('js/model.js') }}"></script>
</body>
</html>