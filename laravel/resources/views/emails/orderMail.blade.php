<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<h1>Order Details</h1>

<table>
    <thead>
        <tr>
            <th>Product Title</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item['title'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['price'] }}</td>
                <td>{{ $item['total'] }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Total Price:</td>
            <td>{{ $totalPrice }}</td>
        </tr>
    </tfoot>
</table>
</body>
</html>