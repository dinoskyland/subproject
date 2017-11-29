<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Your are in the user login view</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($users as $user)

                 <ul>
                         <p>  {{$user->id}} </p>
                         <p> {{$user->email}} </p>
                         <p> {{$user->password}} </p>
                  </ul>
                  @endforeach 

                </div>
            </div>
        </div>
    </div>
</div>