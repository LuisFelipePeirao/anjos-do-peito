<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pumps\StorePumpLoanRequest;
use App\Services\PumpLoanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PumpLoanController extends Controller
{
    public function __construct(private readonly PumpLoanService $loans) {}

    public function create(): View
    {
        $this->authorizeManagement();

        return view('pages.pumps.loans.create', $this->loans->createOptions());
    }

    public function store(StorePumpLoanRequest $request): RedirectResponse
    {
        $loan = $this->loans->create($request->validated(), $request->user()->id);

        return redirect()->route('pumps.show', $loan->id_bomba)->with('status', 'Empréstimo registrado com sucesso.');
    }

    private function authorizeManagement(): void
    {
        abort_unless(auth()->user()?->canManageAttendances(), 403);
    }
}
