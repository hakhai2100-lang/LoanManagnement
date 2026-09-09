<!DOCTYPE html>
<html>
<head>
    <title>Customer Details</title>
</head>
<body>

<h1>Customer Details</h1>

<p><strong>Customer Code:</strong> {{ $customer->customer_code }}</p>
<p><strong>First Name:</strong> {{ $customer->first_name }}</p>
<p><strong>Last Name:</strong> {{ $customer->last_name }}</p>
<p><strong>Gender:</strong> {{ $customer->gender }}</p>
<p><strong>Date of Birth:</strong> {{ $customer->date_of_birth }}</p>
<p><strong>Phone:</strong> {{ $customer->phone }}</p>
<p><strong>Email:</strong> {{ $customer->email }}</p>
<p><strong>Address:</strong> {{ $customer->address }}</p>
<p><strong>City:</strong> {{ $customer->city }}</p>
<p><strong>Status:</strong> {{ $customer->status }}</p>

<br>

<a href="{{ route('customers.index') }}">Back to Customer List</a>

</body>
</html>