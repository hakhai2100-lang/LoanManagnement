@extends('layouts.app')

@section('main')

<h1>Create Customer</h1>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('customers.store') }}" method="POST">

    @csrf

    <p>
        Customer Code <br>
        <input type="text" name="customer_code" value="{{ old('customer_code') }}">
    </p>

    <p>
        First Name <br>
        <input type="text" name="first_name" value="{{ old('first_name') }}">
    </p>

    <p>
        Last Name <br>
        <input type="text" name="last_name" value="{{ old('last_name') }}">
    </p>

    <p>
        Gender <br>
        <select name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </p>

    <p>
        Date of Birth <br>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
    </p>

    <p>
        Phone <br>
        <input type="text" name="phone" value="{{ old('phone') }}">
    </p>

    <p>
        Email <br>
        <input type="email" name="email" value="{{ old('email') }}">
    </p>

    <p>
        Address <br>
        <textarea name="address">{{ old('address') }}</textarea>
    </p>

    <p>
        City <br>
        <input type="text" name="city" value="{{ old('city') }}">
    </p>

    <p>
        Status <br>
        <select name="status">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
    </p>

    <button type="submit">Save Customer</button>

</form>

<br>

<a href="{{ route('customers.index') }}">Back to Customer List</a>

@endsection