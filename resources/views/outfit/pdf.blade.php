<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$outfit->type}}</title>
    <style>
        @font-face {
           font-family: 'Roboto';
           font-style: normal;
           font-weight: 400;
           src: url({{asset('fonts/Roboto-Regular.ttf')}});
        }
        @font-face {
           font-family: 'Roboto';
           font-style: normal;
           font-weight: bold;
           src: url({{asset('fonts/Roboto-Bold.ttf')}});
        }
        body{
             font-family: 'Roboto';
        }

    </style>
</head>
<body>
    <h1>{{$outfit->type}}</h1>
    {!!$outfit->about!!}
</body>
</html>
