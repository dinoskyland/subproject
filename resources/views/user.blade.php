<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">You are in the payment feature view</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    @foreach($pays as $pay)

                 <ul>
                         <p>  {{$pay->payment_id}} </p>
                         <p> {{$pay->p_kind}} </p>
                  </ul>

                  @endforeach                     

                <div>
                  @foreach($timeunits as $timeunit)

                 <ul>
                         <p>  {{$timeunit->time_unit_id}} </p>
                         <p> {{$timeunit->kind}} </p>
                  </ul>
                </div> 
                  @endforeach 
                   
                  
                </div>
            </div>
        </div>
    </div>
</div>
