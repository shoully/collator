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
                    Mentor
                </div>
                <div class="col-md-auto">
                    =
                </div>
                <div class="col-md-auto">
                    Mentee
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
                                <button
                                id="BtnAreatoDevelop"
                                class="btn btn-primary float-end"
                                onclick="show_my_receipt()"
                                type="button">+</button>
                        </div>
<ul class="list-group list-group-flush">
                        @if (isset($mentorings)) 
                        @foreach ($mentorings as $mentoring)
                        <li class="list-group-item">
                            {{ ($mentoring->title) }}
                         
                        <form class="" action="{{ url('/newmentoring', $mentoring->id) }}" method="post">
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
                    Activities

                        <button id="BtnAddActivity" class="btn btn-primary float-end" type="button">+</button>

                </div>
                <ul class="list-group list-group-flush">
                    @if (isset($activities)) @foreach ($activities as $activitie)

                    <li class="list-group-item">{{ ($activitie->Title) }}

                        {{ Prioritiespill($activitie->Priorities) }}
                        
                        @if($activitie->Status != "Done")
                        <form class="" action="{{ url('/newactivity', $activitie->id) }}" method="post">
                        <input type="submit" value="Done" name="Done" class="btn btn-warning float-end">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                    </form>
                    @endif
                        <form class="" action="{{ url('/newactivity', $activitie->id) }}" method="post">
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
                    Projects

                        <button id="BtnAddProject" class="btn btn-primary float-end" type="button">+</button>

                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Marketing Plan</li>
                    <li class="list-group-item">Business Model Canvas</li>
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
                        <div class="alert alert-primary" role="alert">
                            First person
                        </div>

                        <div class="alert alert-success" role="alert">
                            Second person
                        </div>
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

            <h2>Add Activity</h2>
        </div>
        <div class="modal-body">
            <form
            class="form-horizontal"
            action="{{ url('/newactivity') }}"
            method="post"
            role="form">
            <input type='text' class='form-control' placeholder='Title' name='Title'>
            <textarea class="form-control" id="Description" name="Description" rows="3"></textarea>

            @if (isset($mentorings))
            <select name='mentoring_id' class="form-control">
                @foreach ($mentorings as $mentoring)
                <option value="{{$mentoring->id}}">{{ ucfirst($mentoring->Title) }}</option>
                @endforeach
            </select>
            @endif
            <select class="form-control" name='Priorities'>
                <option>High</option>
                <option>Medium</option>
                <option>Low</option>
            </select>
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

            <h2>Adding Project</h2>
        </div>
        <div class="modal-body">
            <form action="test.html">
                <input type='submit'></form>
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
                <form action="test.html">
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
                    <input type='text' class='form-control' placeholder='title' name='Text'>
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