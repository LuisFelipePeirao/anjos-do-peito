<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenewPumpLoanRequest;
use App\Http\Requests\StorePumpRequest;
use App\Http\Requests\UpdatePumpRequest;
use App\Models\BombaLeite;
use App\Services\PumpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PumpController extends Controller
{
    public function __construct(private readonly PumpService $pumps) {}

    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $status = $request->string('status', 'all')->toString();
        $model = $request->string('model', 'all')->toString();

        return view('pages.pumps.index', [
            'pumps' => $this->pumps->search($search, $status, $model),
            'kpis' => $this->pumps->kpis(),
            'search' => $search,
            'status' => $status,
            'model' => $model,
            'models' => $this->pumps->modelFilters(),
        ]);
    }

    public function create(): View
    {
        $this->authorizeManagement();

        return view('pages.pumps.create', [
            'mode' => 'create',
            ...$this->pumps->emptyData(),
        ]);
    }

    public function store(StorePumpRequest $request): RedirectResponse
    {
        $pump = $this->pumps->create($request->validated());

        return redirect()->route('pumps.show', $pump)->with('status', 'Bomba de leite criada com sucesso.');
    }

    public function show(Request $request, BombaLeite $pump): View
    {
        $tab = $request->string('tab', 'overview')->toString();
        $tabs = ['overview', 'loans', 'payments', 'maintenance', 'history'];

        return view('pages.pumps.show', [
            ...$this->pumps->showData($pump),
            'tab' => in_array($tab, $tabs, true) ? $tab : 'overview',
        ]);
    }

    public function edit(BombaLeite $pump): View
    {
        $this->authorizeManagement();

        return view('pages.pumps.edit', [
            'mode' => 'edit',
            ...$this->pumps->editData($pump),
        ]);
    }

    public function update(UpdatePumpRequest $request, BombaLeite $pump): RedirectResponse
    {
        $pump = $this->pumps->update($pump, $request->validated());

        return redirect()->route('pumps.show', $pump)->with('status', 'Bomba de leite atualizada com sucesso.');
    }

    public function renewLoan(RenewPumpLoanRequest $request, BombaLeite $pump): RedirectResponse
    {
        $this->pumps->renewLoan($pump, $request->validated()['expires_at']);

        return redirect()->route('pumps.show', $pump)->with('status', 'Empréstimo renovado com sucesso.');
    }

    public function destroy(BombaLeite $pump): RedirectResponse
    {
        $this->authorizeManagement();

        $deleted = $this->pumps->destroy($pump);

        return redirect()->route('pumps.index')->with('status', $deleted ? 'Bomba de leite excluída com sucesso.' : 'Bomba de leite inativada por possuir vínculos.');
    }

    private function authorizeManagement(): void
    {
        abort_unless(auth()->user()?->canManageAttendances(), 403);
    }
}
