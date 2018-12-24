<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="/css/sweetalert.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>

    <form action="/getDate" method="POST">
      {{ csrf_field() }}
      <textarea name="message" id="message" cols="30" rows="10"> </textarea>
      <div class="g-recaptcha" data-sitekey="6LfrfoAUAAAAAOeosb-NEZA148UKShQZEHUDDdBb"></div>
      <button type="submit">send</button>
    </form>
    <script src="/js/sweetalert.min.js"></script>

    <!-- Include this after the sweet alert js file -->
    @include('sweet::alert')

</body>
</html>