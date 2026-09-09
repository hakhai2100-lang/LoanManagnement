<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
</head>
<body>

<h1>Edit Customer</h1>

<form action="{{ route('customers.update', $customer->id) }}" method="POST">

    @csrf
    @method('PUT')

    <p>
        Customer Code <br>
        <input type="text" name="customer_code" value="{{ $customer->customer_code }}">
    </p>

    <p>
        First Name <br>
        <input type="text" name="first_name" value="{{ $customer->first_name }}">
    </p>

    <p>
        Last Name <br>
        <input type="text" name="last_name" value="{{ $customer->last_name }}">
    </p>

    <p>
        Gender <br>
        <select name="gender">
            <option value="Male" {{ $customer->gender == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ $customer->gender == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
    </p>

    <p>
        Date of Birth <br>
        <input type="date" name="date_of_birth" value="{{ $customer->date_of_birth }}">
    </p>

    <p>
        Phone <br>
        <input type="text" name="phone" value="{{ $customer->phone }}">
    </p>

    <p>
        Email <br>
        <input type="email" name="email" value="{{ $customer->email }}">
    </p>

    <p>
        Address <br>
        <textarea name="address">{{ $customer->address }}</textarea>
    </p>

    <p>
        City <br>
        <input type="text" name="city" value="{{ $customer->city }}">
    </p>

    <p>
        Status <br>
        <select name="status">
            <option value="Active" {{ $customer->status == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ $customer->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </p>

    <button type="submit">Update Customer</button>

</form>

<br>

<a href="{{ route('customers.index') }}">Back</a>

</body>
</html>