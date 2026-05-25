<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class CustomerController extends Controller
{
    private string $apiBase;

    public function __construct()
    {
        $this->apiBase = config('app.url') . '/api';
    }

    public function index(Request $request): View
    {
        $status = $request->query('status');
        $params = $status ? ['status' => $status] : [];

        $response = $this->internalApiRequest('GET', "/api/customers", $params);
        $customers = $response->successful() ? $response->json('data', []) : [];

        return view('customers.index', compact('customers', 'status'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $response = $this->internalApiRequest('POST', "/api/customers", $request->all());

        if ($response->successful()) {
            return redirect()->route('customers.index')
                ->with('success', 'Customer berhasil ditambahkan.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Gagal menambahkan customer.');

        return back()->withInput()->withErrors($errors)->with('error', $message);
    }

    public function show(int $id): View|RedirectResponse
    {
        $response = $this->internalApiRequest('GET', "/api/customers/{$id}");

        if (!$response->successful()) {
            return redirect()->route('customers.index')
                ->with('error', 'Customer tidak ditemukan.');
        }

        $customer = $response->json('data');

        // Ambil subscriptions milik customer ini
        $subResponse = $this->internalApiRequest('GET', "/api/subscriptions", ['customer_id' => $id]);
        $subscriptions = $subResponse->successful() ? $subResponse->json('data', []) : [];

        return view('customers.show', compact('customer', 'subscriptions'));
    }

    public function edit(int $id): View|RedirectResponse
    {
        $response = $this->internalApiRequest('GET', "/api/customers/{$id}");

        if (!$response->successful()) {
            return redirect()->route('customers.index')
                ->with('error', 'Customer tidak ditemukan.');
        }

        $customer = $response->json('data');

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('PUT', "/api/customers/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('customers.show', $id)
                ->with('success', 'Customer berhasil diperbarui.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Gagal memperbarui customer.');

        return back()->withInput()->withErrors($errors)->with('error', $message);
    }

    public function destroy(int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('DELETE', "/api/customers/{$id}");

        if ($response->successful()) {
            return redirect()->route('customers.index')
                ->with('success', 'Customer berhasil dihapus.');
        }

        $message = $response->json('message', 'Gagal menghapus customer.');

        return redirect()->route('customers.index')->with('error', $message);
    }

    public function activate(int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('PATCH', "/api/customers/{$id}/activate");

        if ($response->successful()) {
            return back()->with('success', 'Customer berhasil diaktifkan.');
        }

        return back()->with('error', 'Gagal mengaktifkan customer.');
    }

    public function deactivate(int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('PATCH', "/api/customers/{$id}/deactivate");

        if ($response->successful()) {
            return back()->with('success', 'Customer berhasil dinonaktifkan.');
        }

        return back()->with('error', 'Gagal menonaktifkan customer.');
    }
}
