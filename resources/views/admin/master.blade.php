<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    

    <title>وب سایت فروشگاه  اینترنتی</title>

    <!-- Bootstrap core CSS -->
    

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    

  <link rel="stylesheet"  href=" {{ asset('css/admin.css') }}" >
  </head>

  <body>
     
     @include('admin.section.header');
     
     @yield('content');
     
     @include('admin.section.footer');
  
    </body>
</html>
