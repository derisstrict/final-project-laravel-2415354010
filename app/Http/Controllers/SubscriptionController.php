<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    private string $apiBase;

    private array $allowedStatuses = ['active', 'inactive', 'trial', 'isolir', 'dismantle'];

    public function __construct()
    {
        $this->apiBase = config('app.url') . '/api';
    }

    public function index(Request $request): View
    {
        $status = $request->query('status');
        $customerId = $request->query('customer_id');

        $params = array_filter([
            'status'      => $status,
            'customer_id' => $customerId,
        ]);

        $response = $this->internalApiRequest('GET', "/api/subscriptions", $params);
        $subscriptions = $response->successful() ? $response->json('data', []) : [];

        // Ambil daftar customer untuk filter dropdown
        $customerRes = $this->internalApiRequest('GET', "/api/customers");
        $customers = $customerRes->successful() ? $customerRes->json('data', []) : [];

        return view('subscriptions.index', compact('subscriptions', 'customers', 'status', 'customerId'));
    }

    public function create(): View
    {
        // Ambil data customer & service aktif untuk form
        $customerRes = $this->internalApiRequest('GET', "/api/customers", ['status' => 'active']);
        $customers = $customerRes->successful() ? $customerRes->json('data', []) : [];

        $serviceRes = $this->internalApiRequest('GET', "/api/services", ['status' => 'active']);
        $services = $serviceRes->successful() ? $serviceRes->json('data', []) : [];

        $statuses = $this->allowedStatuses;

        return view('subscriptions.create', compact('customers', 'services', 'statuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $response = $this->internalApiRequest('POST', "/api/subscriptions", $request->all());

        if ($response->successful()) {
            return redirect()->route('subscriptions.index')
                ->with('success', 'Subscription berhasil ditambahkan.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Gagal menambahkan subscription.');

        return back()->withInput()->withErrors($errors)->with('error', $message);
    }

    public function show(int $id): View|RedirectResponse
    {
        $response = $this->internalApiRequest('GET', "/api/subscriptions/{$id}");

        if (!$response->successful()) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Subscription tidak ditemukan.');
        }

        $subscription = $response->json('data');

        return view('subscriptions.show', compact('subscription'));
    }

    public function edit(int $id): View|RedirectResponse
    {
        $response = $this->internalApiRequest('GET', "/api/subscriptions/{$id}");

        if (!$response->successful()) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'Subscription tidak ditemukan.');
        }

        $subscription = $response->json('data');

        // Ambil data customer & service untuk form
        $customerRes = $this->internalApiRequest('GET', "/api/customers");
        $customers = $customerRes->successful() ? $customerRes->json('data', []) : [];

        $serviceRes = $this->internalApiRequest('GET', "/api/services");
        $services = $serviceRes->successful() ? $serviceRes->json('data', []) : [];

        $statuses = $this->allowedStatuses;

        return view('subscriptions.edit', compact('subscription', 'customers', 'services', 'statuses'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('PUT', "/api/subscriptions/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('subscriptions.show', $id)
                ->with('success', 'Subscription berhasil diperbarui.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Gagal memperbarui subscription.');

        return back()->withInput()->withErrors($errors)->with('error', $message);
    }

    public function destroy(int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('DELETE', "/api/subscriptions/{$id}");

        if ($response->successful()) {
            return redirect()->route('subscriptions.index')
                ->with('success', 'Subscription berhasil dihapus.');
        }

        $message = $response->json('message', 'Gagal menghapus subscription.');

        return redirect()->route('subscriptions.index')->with('error', $message);
    }
}
