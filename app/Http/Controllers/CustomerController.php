<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search Customer Code
        if ($request->filled('customer_code')) {
            $query->where('customer_code', 'like', '%' . $request->customer_code . '%');
        }

        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('gender')) {
        $query->where('gender', $request->gender);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();

        $totalCustomers = Customer::count();

        $activeCustomers = Customer::where('status', 'Active')->count();

        $inactiveCustomers = Customer::where('status', 'Inactive')->count();

        $customersByCity = Customer::selectRaw('city, COUNT(*) as total')
            ->groupBy('city')
            ->get();

        $cities = Customer::select('city')
            ->distinct()
            ->orderBy('city')
            ->get();

        return view('customers.index', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'inactiveCustomers',
            'customersByCity',
            'cities'
        ));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_code' => 'required|unique:customers',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:customers',
            'city' => 'required',
            'status' => 'required',
        ]);

        Customer::create([
            'customer_code' => $request->customer_code,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'status' => $request->status,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers.show', compact('customer'));
    }

    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'customer_code' => 'required|unique:customers,customer_code,' . $id,
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:customers,email,' . $id,
            'city' => 'required',
            'status' => 'required',
        ]);

        $customer = Customer::findOrFail($id);

        $customer->update([
            'customer_code' => $request->customer_code,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'status' => $request->status,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}