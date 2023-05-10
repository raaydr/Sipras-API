<!doctype html>
<html lang="en">
   <head>
      <title>Stikes Medistra Indonesia</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="{{asset('login-form')}}/css/style.css">
   </head>
   <body>
      <section class="ftco-section">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-6 text-center mb-5">
                  <h2 class="heading-section">Stikes Medistra Indonesia</h2>
               </div>
            </div>
            <div class="row justify-content-center">
               <div class="col-md-7 col-lg-5">
                  <div class="wrap">
                     <div class="img" style="background-image: url({{asset('login-form')}}/images/bg-1.jpg);"></div>
                     <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                           <div class="w-100">
                              <h3 class="mb-4">Sign In</h3>
                           </div>
                           <div class="w-100">
                           </div>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                           @csrf
                           <div class="form-group mt-3">
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                              <label class="form-control-placeholder" for="username">Username</label>
                              @error('email')
                              <span class="label-input100 text-danger">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group">
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                              <label class="form-control-placeholder" for="password">Password</label>
                              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                              @error('password')
                              <span class="label-input100 text-danger">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="form-group">
                              <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                           </div>
                           <div class="form-group d-md-flex">
                              <div class="w-50 text-left form-check">
                              </div>
                              <div class="w-50 text-md-right">
                                 <a href="{{ route('password.request') }}">Forgot Password</a>
                              </div>
                           </div>
                           @if ($displayCaptcha)      
						         <div class="form-group d-md-flex">
						         
                              {!! NoCaptcha::renderJs() !!}
                              {!! NoCaptcha::display() !!}
                              
                        	
                             
                           
                           </div>
                           @error('g-recaptcha-response')
                              <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           @endif
                        </form>
                        
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <script src="{{asset('login-form')}}/js/jquery.min.js"></script>
      <script src="{{asset('login-form')}}/js/popper.js"></script>
      <script src="{{asset('login-form')}}/js/bootstrap.min.js"></script>
      <script src="{{asset('login-form')}}/js/main.js"></script>
   </body>
</html>
