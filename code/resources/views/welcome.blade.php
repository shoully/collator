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
