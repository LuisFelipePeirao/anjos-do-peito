<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pumps\StorePumpLoanRequest;
use App\Models\CessaoBomba;
use App\Services\PumpLoanService;
use Dompdf\Dompdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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

        $response = redirect()->route('pumps.show', $loan->id_bomba)->with('status', 'Empréstimo registrado com sucesso.');

        if ($loan->termo_dados !== null) {
            $response->with('loan_term_id', $loan->id);
        }

        return $response;
    }

    public function term(CessaoBomba $loan): Response
    {
        $this->authorizeManagement();
        abort_if($loan->termo_dados === null, 404);

        $pdf = new Dompdf;
        $pdf->setPaper('A4');
        $pdf->loadHtml(view('pages.pumps.loans.term', ['term' => $loan->termo_dados])->render());
        $pdf->render();

        $disposition = request()->boolean('download') ? 'attachment' : 'inline';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => $disposition.'; filename="termo-emprestimo-'.$loan->id.'.pdf"',
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    private function authorizeManagement(): void
    {
        abort_unless(auth()->user()?->canManageAttendances(), 403);
    }
}
