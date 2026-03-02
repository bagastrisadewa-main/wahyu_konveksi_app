<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;
        $keyword = $request->keyword;

        $customers = Customer::when($keyword, function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('email', 'like', "%$keyword%")
                  ->orWhere('phone', 'like', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.customers.partials.table', compact('customers'))->render()
            ]);
        }

        return view('pages.customers.index', compact('customers'));
    }

    public function edit(Customer $customer)
    {
        return view('pages.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone'     => 'required|string|max:20',
            'address'   => 'nullable|string',
            'password'  => 'nullable|min:6',
            'is_active' => 'required|boolean',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $customer->update($data);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Data customer berhasil diperbarui');
    }
}
