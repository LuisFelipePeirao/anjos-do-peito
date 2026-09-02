<?php

namespace App\Http\Controllers;

use App\Http\Requests\Beneficiaries\BeneficiaryFilterRequest;
use App\Http\Requests\Beneficiaries\StoreBeneficiaryRequest;
use App\Http\Requests\Beneficiaries\StoreChildRequest;
use App\Http\Requests\Beneficiaries\UpdateBeneficiaryRequest;
use App\Http\Requests\Beneficiaries\UpdateChildRequest;
use App\Models\Beneficiaria;
use App\Models\Crianca;
use App\Services\BeneficiaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeneficiaryController extends Controller
{
    public function __construct(private readonly BeneficiaryService $beneficiaries)
    {
    }

    public function index(BeneficiaryFilterRequest $request): View
    {
        return view('pages.beneficiaries.index', $this->beneficiaries->indexData($request->filters()));
    }

    public function create(): View
    {
        return view('pages.beneficiaries.create', $this->beneficiaries->formOptions());
    }

    public function store(StoreBeneficiaryRequest $request): RedirectResponse
    {
        $this->beneficiaries->create($request->validated());

        return redirect()->route('beneficiaries.index')->with('status', 'Beneficiária criada com sucesso.');
    }

    public function show(Request $request, Beneficiaria $beneficiaria): View
    {
        return view('pages.beneficiaries.show', $this->beneficiaries->showData(
            $beneficiaria,
            $request->filled('editar_crianca') ? (int) $request->input('editar_crianca') : null,
            $request->string('tab', 'overview')->toString()
        ));
    }

    public function edit(Beneficiaria $beneficiaria): View
    {
        return view('pages.beneficiaries.edit', $this->beneficiaries->editData($beneficiaria));
    }

    public function update(UpdateBeneficiaryRequest $request, Beneficiaria $beneficiaria): RedirectResponse
    {
        $this->beneficiaries->update($beneficiaria, $request->validated());

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Beneficiária atualizada com sucesso.');
    }

    public function deactivate(Beneficiaria $beneficiaria): RedirectResponse
    {
        $this->beneficiaries->deactivate($beneficiaria);

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Beneficiária inativada com sucesso.');
    }

    public function storeChild(StoreChildRequest $request, Beneficiaria $beneficiaria): RedirectResponse
    {
        $this->beneficiaries->storeChild($beneficiaria, $request->validated());

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Bebê cadastrado com sucesso.');
    }

    public function updateChild(UpdateChildRequest $request, Beneficiaria $beneficiaria, Crianca $crianca): RedirectResponse
    {
        $this->beneficiaries->updateChild($beneficiaria, $crianca, $request->validated());

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Dados do bebê atualizados com sucesso.');
    }

    public function destroyChild(Beneficiaria $beneficiaria, Crianca $crianca): RedirectResponse
    {
        $this->beneficiaries->destroyChild($beneficiaria, $crianca);

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Bebê removido com sucesso.');
    }
}
