<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockMovementRequest;
use App\Models\EstoqueMovimentacao;
use App\Services\StockMovementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function __construct(private readonly StockMovementService $movements) {}

    public function index(Request $request): View
    {
        return view('pages.movements.index', $this->movements->indexData(
            $request->string('q')->trim()->toString(),
            $request->string('type', 'all')->toString(),
        ));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->canManageAttendances(), 403);

        return view('pages.donations.distributions.create', $this->movements->createData(
            $request->string('tipo')->toString(),
            $request->integer('material') ?: null,
        ));
    }

    public function store(StoreStockMovementRequest $request): RedirectResponse
    {
        $movement = $this->movements->create($request->validated(), $request->user()->id);

        return redirect()->route('movements.show', $movement)->with('status', 'Movimentação registrada com sucesso.');
    }

    public function show(EstoqueMovimentacao $movement): View
    {
        return view('pages.movements.show', $this->movements->showData($movement));
    }
}
