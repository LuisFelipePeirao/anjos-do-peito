<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDistributionRequest;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\StoreDonorRequest;
use App\Http\Requests\StoreMaterialRequest;
use App\Models\Material;
use App\Services\DonationStockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationStockController extends Controller
{
    public function __construct(private readonly DonationStockService $stock) {}

    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $status = $request->string('status', 'all')->toString();
        $category = $request->string('category', 'all')->toString();

        return view('pages.donations.index', $this->stock->indexData($search, $status, $category));
    }

    public function show(Request $request, Material $material): View
    {
        $tab = $request->string('tab', 'overview')->toString();
        $tabs = ['overview', 'movements', 'distributions', 'history'];

        return view('pages.donations.show', [
            ...$this->stock->showData($material),
            'tab' => in_array($tab, $tabs, true) ? $tab : 'overview',
        ]);
    }

    public function createMaterial(): View
    {
        $this->authorizeManagement();

        return view('pages.donations.materials.create', $this->stock->formOptions());
    }

    public function storeMaterial(StoreMaterialRequest $request): RedirectResponse
    {
        $material = $this->stock->createMaterial($request->validated());

        return redirect()->route('donations.show', $material)->with('status', 'Item de estoque criado com sucesso.');
    }

    public function createDonor(): RedirectResponse
    {
        $this->authorizeManagement();

        return redirect()->route('movements.create', ['tipo' => 'entrada']);
    }

    public function storeDonor(StoreDonorRequest $request): RedirectResponse
    {
        $this->stock->createDonor($request->validated());

        return back(fallback: route('movements.create', ['tipo' => 'entrada']))->with('status', 'Doador criado com sucesso.');
    }

    public function createDonation(): View
    {
        $this->authorizeManagement();

        return view('pages.donations.distributions.create', [
            ...$this->stock->formOptions(),
            'movementType' => 'entrada',
            'selectedMaterial' => null,
        ]);
    }

    public function storeDonation(StoreDonationRequest $request): RedirectResponse
    {
        $donation = $this->stock->createDonation($request->validated(), $request->user()->id);

        return redirect()->route('donations.index')->with('status', 'Doação '.$donation->id.' registrada com sucesso.');
    }

    public function createDistribution(Request $request): View
    {
        $this->authorizeManagement();

        return view('pages.donations.distributions.create', [
            ...$this->stock->formOptions(),
            'movementType' => 'saida',
            'selectedMaterial' => $request->integer('material') ?: null,
        ]);
    }

    public function storeDistribution(StoreDistributionRequest $request): RedirectResponse
    {
        $distribution = $this->stock->createDistribution($request->validated(), $request->user()->id);

        return redirect()->route('donations.index')->with('status', 'Distribuição '.$distribution->id.' registrada com sucesso.');
    }

    private function authorizeManagement(): void
    {
        abort_unless(auth()->user()?->canManageAttendances(), 403);
    }
}
