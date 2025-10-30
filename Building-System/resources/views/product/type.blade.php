<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
</head>
<body>
    <div>
        @foreach ($products as $spec)

        <div>
            <p>{{$spec->product->name}}</p>
            <a href="{{route('product.view', ['type'=>$type, 'spec'=>$spec->id])}}">Check</a>
        </div>

        @endforeach
    </div>

</body>
</html>