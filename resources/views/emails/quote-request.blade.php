<h2>New Quote Request</h2>

<p><strong>Name:</strong> {{ $quote->customer_name }}</p>
<p><strong>Email:</strong> {{ $quote->email }}</p>
<p><strong>Phone:</strong> {{ $quote->phone }}</p>
<p><strong>Company:</strong> {{ $quote->company_name }}</p>

<p><strong>Products Requested:</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Current Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quote->products as $product)
            <tr>
                <td>{{ $product['id'] }}</td>
                <td>{{ $product['code'] }}</td>
                <td>{{ $product['description'] }}</td>
                <td>{{ $product['quantity'] }}</td>
                <td>{{ number_format($product['current_price'], 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<p><strong>Urgency:</strong> {{ $quote->urgency }}</p>
<p><strong>Additional Requirements:</strong> {{ $quote->additional_requirements }}</p>
