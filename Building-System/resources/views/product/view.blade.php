<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
</head>
<body>
    <a href="{{route('product.type', ['type'=>$type])}}">Back</a>

    <h1>Product: {{ $product->name }}</h1>

<h2>Motherboard Specs</h2>
<ul>
    <li>Manufacturer: {{ $spec->manufacturer }}</li>
    <li>Series: {{ $spec->series }}</li>
    <li>Socket: {{ $spec->socket }}</li>
    <li>Chipset: {{ $spec->chipset }}</li>
    <li>Memory Technology: {{ $spec->memory_technology }}</li>
    <li>Form Factor: {{ $spec->form_factor }}</li>
</ul>

</body>
</html>