<!DOCTYPE html>
<html>
 <head>
  <meta charset=utf-8>
  <title>{{__('Create newsletter in laravel 5.7')}}</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
 </head>
 <body>
  <div >
  @if (\Session::has('success'))
   <div >
    <p>{{ \Session::get('success') }}</p>
   </div><br />
   @endif
   @if (\Session::has('failure'))
   <div >
    <p>{{ \Session::get('failure') }}</p>
   </div><br />
   @endif
   <h2>{{__('Laravel Newsletter Tutorial With Example')}}</h2><br/>
   <form method="post" action="{{url('store-newsletter')}}">
    @csrf
    </div>
    <div >
     <div ></div>
      <div >
       <label for="Email">{{__('Email')}}:</label>
       <input type=text name=subscribed_email>
      </div>
     </div>
    <div >
     <div ></div>
     <div >
      <button type=submit >{{__('Subscribe')}}</button>
     </div>
    </div>
   </form>
  </div>
 </body>
</html>
