<!DOCTYPE html>
<html>
<head>
    <style>
        #customers {
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        #customers td, #customers th {
          border: 1px solid #ddd;
          padding: 8px;
        }

        #customers tr:nth-child(even){background-color: orange;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #04AA6D;
          color: white;
        }
        </style>
</head>
<body>
    <h2>Order info</h2>
    <h3>Name: {{ $data['name'] }}</h3>
    <h3>Email: {{ $data['email'] }}</h3>
    <h3>Address: {{ $data['address'] }}</h3>
    <h3>Phone: {{ $data['phone'] }}</h3>
    <table id="customers">
        <thead>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </thead>
        <tbody>
            @foreach ($data['cart'] as $item)
            <tr>
                <td><img src="{{ $item['image'] }}" width="100" height="100" alt=""></td>
                <td>{{ $item['name'] }}</td>
                <td>${{ $item['price'] }}</td>
                <td>{{ $item['qty'] }}</td>
                <td>${{ $item['price'] * $item['qty'] }}</td>
            </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                GrandTotal : ${{ $data['grandTotal'] }}
            </tr>
        </tfoot>
    </table>
</body>
</html>
