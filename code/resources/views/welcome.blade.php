  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})
</script>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>

  <!doctype html>
    <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">


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
  <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
          </div>
        </div>
        <br>
        <div class="row justify-content-md-center">
          <div class="col-md-auto">
            <div class="card" style="width: 18rem;">
  <div class="card-header">
    Areas to Develop
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" onclick="show_my_receipt()" type="button">Add Area to Develop</button>
</div>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Communication <div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div></li>
    <li class="list-group-item">Digital Marketing <div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div></li>
    <li class="list-group-item">Business Model <div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div></li>
  </ul>
</div>
<br>
<div class="card" style="width: 18rem;">
  <div class="card-header">
    Activities
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" type="button">Add Activity</button>
</div>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Interview Practice</li>
    <li class="list-group-item">Networking Event</li>
    <li class="list-group-item">Presentation</li>
  </ul>
</div>
<br>
<div class="card" style="width: 18rem;">
  <div class="card-header">
    Projects
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" type="button">Add Project</button>
</div>
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
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" type="button">+</button>
</div>
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
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" type="button">+</button>
</div>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">First Meeting</li>
    <li class="list-group-item">Second Meeting</li>
  </ul>
</div>
          </div>
        </div>
      </div>
      <script src="js/bootstrap.bundle.min.js" ></script>
    </body>
    </html>
