@extends('layouts.app')

@section('content')

  <!-- Main content -->
  <div class="main-content" id="panel">
  
    <div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-image: url({{url('')}}/public/assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-7 col-md-3">
            <h1 class="display-2 text-white">Hello {{ Auth::user()->first_name  }}</h1>
            <p class="text-white mt-0 mb-7">International Transfer.  Send Money to Family and Friends, Enjoy Swift and Safe transfer service.</p>
          </div>

        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2">
          <div class="card card-profile">
            <img src="{{url('')}}/public/assets/img/theme/CYBG-logo.png" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  
                </div>
              </div>
            </div>
            
            <div class="card-body pt-0">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center">
                    
                    
                    
                  </div>
                </div>
              </div>
              <div class="text-center">
                <h3 class="h3">
                  Account Information
                </h3>
                <div class="h5 font-weight-300">
                  <i class="ni location_pin mr-2"></i>Checkings Account
                </div>
                <div class="h5 mt-2">
                </div>
                <h4>{{Auth::user()->account_no}}</h4>
                <div>
                </div>
              </div>
            </div>
          </div>
          <!-- Progress track -->
          <div class="card">
            <!-- Card header -->
           
            <!-- Card body -->
           
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="row">
            <div class="col-lg-6">
              <div class="card bg-gradient-info border-0">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0 text-white">Available Balance</h5>
                      <span class="h2 font-weight-bold mb-0 text-white"> £ {{number_format($user_balance), 2}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                        <i class="ni ni-money-coins"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card bg-gradient-danger border-0">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Money Out</h5>
                      <span class="h2 font-weight-bold mb-0 text-white">£ {{number_format($current_week), 2}}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                        <i class="ni ni-bold-up"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Transfer</h3>
                </div>

                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session()->get('error') }}
                                    </div>
                                @endif
            
      
            <div class="card-body">
                <h6 class="heading-small text-muted mb-4">Transaction Information</h6>
                <form method="POST" action="/int-transfer-now" class="pt-3">
                @csrf
                              <div class="pl-lg-6">
                                <div class="row">
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                      <label class="form-control-label" for="input-username">Enter Bank</label>
                                      <input type="text" name="bank_name" id=" " class="form-control" placeholder="Enter Bank Name">
                                    </div>
                                  </div>

                                  <div class="col-lg-6">
                                    <div class="form-group">
                                      <label class="form-control-label" for="input-email">Account Number</label>
                                      <input type="number" name="r_account_no" id=" " class="form-control" placeholder="Enter Account Number">
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                      <label class="form-control-label" for="input-username">Account Name</label>
                                      <input type="text" name="account_name" id=" " class="form-control" placeholder="Enter Beneficary Name">
                                    </div>
                                  </div>

                                  <div class="col-lg-6">
                                  <div class="form-group">
                                      <label class="form-control-label" for="input-email">Amount</label>
                                      <input type="number" name="amount" id="amount" class="form-control" placeholder="Ex 100">
                                      <span class="heading-small text-muted ">MIN 100 | MAX 1,000,000.00</span>
                                    </div>
                                  </div>
                                </div>


                                <div class="row">
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="form-control-label" for="input-email">Bank Address</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter your bank address">
                                    </div>
                                  </div>

                                  <div class="col-lg-6">
                                  <div class="form-group">
                                  <label class="form-control-label" for="input-email">Swift Code</label>
                                      <input type="text" name="text" id="text" class="form-control" placeholder="Enter swift code">
                                    </div>
                                  </div>
                                </div>


                                  
                                


                                  <div class="row">
                                  <div class="col-lg-6">
                                    <div class="form-group">
                                      <label class="form-control-label" for="input-username">Transfer Pin</label>
                                      <input type="password" name="user_pin" id=" " class="form-control" placeholder="Enter your Transfer Pin">
                                    </div>
                                  </div>

                                  <div class="col-lg-6 mt-4">
                                    <div class="form-group mb-5">
                                      <button class="btn btn-icon btn-primary mt-1" type="submit" id="submit" name="submit">
                                        <span class="btn-inner--icon"><i class="ni ni-send"></i></span>
                                        <span class="btn-inner--text">Continue</span>
                                      </button>
                                    </div>
                                  </div>
                          
                                  
                                  
                          
                              </div>
                            </form>
        </div>
                              

                



                
               
              </div>
            </div>





                  <div class="row">
                    
                    
                    
                  </div>
                </div>
              </div>
             
            </div>
          </div>
        </div>
   

<script>
$(function() {
  $('.selectpicker').selectpicker();
});
</script>

@endsection
