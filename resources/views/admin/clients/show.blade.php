<div class="row">
  <div class="col-md-5">

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile" style="border: 1px solid #c1c1c1;">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle"
               src="{{ url('public/company/employee/default.png')}}"
               alt="User profile picture">
        </div>

        <h3 class="profile-username text-center">{{$clients->name_salutation." ".$clients->first_name ." ".$clients->middle_name." ".$clients->last_name }}</h3>

        <p class="text-muted text-center">{{ $clients->group->name }}</p>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Group Head</b> <a class="float-right">{{ ucwords($clients->group_head) }} </a>
          </li>
          <li class="list-group-item">
            <b>Date Of Birth</b> <a class="float-right">{{ date('d M Y',strtotime($clients->date_of_birth)) }}</a>
          </li>
          <li class="list-group-item">
            <b>Date of Anniversary</b> <a class="float-right">{{ date('d M Y',strtotime($clients->date_of_anniversary)) }}</a>
          </li>
          <li class="list-group-item">
            <b>Category</b> <a class="float-right">{{ $clients->client_category }}</a>
          </li>
          <li class="list-group-item">
            <b>Relation</b> <a class="float-right">{{ $clients->relation }}</a>
          </li>
        </ul>

      </div>
      <!-- /.card-body -->
    </div>

    <!-- /.card -->

    <!-- About Me Box -->
   
    <!-- /.card -->
  </div>
  <!-- /.col -->
  <div class="col-md-7">
     <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">About Client</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body" style="border: 1px solid #c1c1c1;">
        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

        <p class="text-muted">{{ $clients->address_1 }},{{ $clients->address_2 }},{{ $clients->address_2 }}, {{ $clients->area }}, {{ $clients->city }}, {{ $clients->pin_code }}</p>

        <hr>

        <strong><i class="fa fa-envelope mr-1"></i> Email</strong>

        <p class="text-muted">
          {{ $clients->email }}
        </p>

        <hr>

        

        <strong><i class="fa fa-building-o mr-1"></i> Business</strong>
        @php
        $businesses = array();
        if(!empty($clients)){
          $businesses = $clients->business->pluck('name')->toArray();
        }
        @endphp
        <p class="text-muted">
          @if(!empty($businesses))
            @foreach($businesses as $business)
            <span class="badge badge-info">{{ $business }}</span>  
            @endforeach
          @endif
  
        </p>

        <hr>

        <strong><i class="fa fa-mobile"></i> Mobile Number</strong>

         <p class="text-muted">
          {{ $clients->mobile_number }}
        </p>
        <hr>

        <strong><i class="fa fa-whatsapp"></i> Whatsapp Number</strong>

         <p class="text-muted">
          {{ $clients->whatsapp_number }}
        </p>
      </div>
      <!-- /.card-body -->

    </div>
    <!-- /.nav-tabs-custom -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
    
    
  