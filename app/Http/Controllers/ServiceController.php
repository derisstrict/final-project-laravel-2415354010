<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ServiceController extends Controller
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

        $response = $this->internalApiRequest('GET', "/api/services", $params);
        $services = $response->successful() ? $response->json('data', []) : [];

        return view('services.index', compact('services', 'status'));
    }

    public function create(): View
    {
        return view('services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $response = $this->internalApiRequest('POST', "/api/services", $request->all());

        if ($response->successful()) {
            return redirect()->route('services.index')
                ->with('success', 'Service berhasil ditambahkan.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Gagal menambahkan service.');

        return back()->withInput()->withErrors($errors)->with('error', $message);
    }

    public function show(int $id): View|RedirectResponse
    {
        $response = $this->internalApiRequest('GET', "/api/services/{$id}");

        if (!$response->successful()) {
            return redirect()->route('services.index')
                ->with('error', 'Service tidak ditemukan.');
        }

        $service = $response->json('data');

        return view('services.show', compact('service'));
    }

    public function edit(int $id): View|RedirectResponse
    {
        $response = $this->internalApiRequest('GET', "/api/services/{$id}");

        if (!$response->successful()) {
            return redirect()->route('services.index')
                ->with('error', 'Service tidak ditemukan.');
        }

        $service = $response->json('data');

        return view('services.edit', compact('service'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('PUT', "/api/services/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('services.show', $id)
                ->with('success', 'Service berhasil diperbarui.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Gagal memperbarui service.');

        return back()->withInput()->withErrors($errors)->with('error', $message);
    }

    public function destroy(int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('DELETE', "/api/services/{$id}");

        if ($response->successful()) {
            return redirect()->route('services.index')
                ->with('success', 'Service berhasil dihapus.');
        }

        $message = $response->json('message', 'Gagal menghapus service.');

        return redirect()->route('services.index')->with('error', $message);
    }

    public function activate(int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('PATCH', "/api/services/{$id}/activate");

        if ($response->successful()) {
            return back()->with('success', 'Service berhasil diaktifkan.');
        }

        return back()->with('error', 'Gagal mengaktifkan service.');
    }

    public function deactivate(int $id): RedirectResponse
    {
        $response = $this->internalApiRequest('PATCH', "/api/services/{$id}/deactivate");

        if ($response->successful()) {
            return back()->with('success', 'Service berhasil dinonaktifkan.');
        }

        return back()->with('error', 'Gagal menonaktifkan service.');
    }
}
