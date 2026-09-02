<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendances\AttendanceFilterRequest;
use App\Http\Requests\Attendances\SaveAttendanceContinuationRequest;
use App\Http\Requests\Attendances\StoreAttendanceRequest;
use App\Http\Requests\Attendances\StoreLocationRequest;
use App\Http\Requests\Attendances\UpdateAttendanceRequest;
use App\Models\Atendimento;
use App\Models\Beneficiaria;
use App\Services\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(private readonly AttendanceService $attendances)
    {
    }

    public function index(AttendanceFilterRequest $request): View
    {
        return view('pages.attendances.index', $this->attendances->indexData($request->filters()));
    }

    public function create(): View
    {
        return view('pages.attendances.form', $this->attendances->createData());
    }

    public function store(StoreAttendanceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $attendance = $this->attendances->store($data);

        return redirect()
            ->route('attendances.show', $attendance)
            ->with('status', $data['save_as'] === 'draft' ? 'Rascunho salvo com sucesso.' : 'Atendimento criado com sucesso.');
    }

    public function show(Request $request, Atendimento $attendance): View
    {
        return view('pages.attendances.show', $this->attendances->showData(
            $attendance,
            $request->string('tab', 'overview')->toString()
        ));
    }

    public function edit(Atendimento $attendance): View
    {
        return view('pages.attendances.form', $this->attendances->editData($attendance));
    }

    public function update(UpdateAttendanceRequest $request, Atendimento $attendance): RedirectResponse
    {
        $data = $request->validated();
        $this->attendances->update($attendance, $data);

        return redirect()
            ->route('attendances.show', $attendance)
            ->with('status', $data['save_as'] === 'draft' ? 'Rascunho atualizado com sucesso.' : 'Atendimento atualizado com sucesso.');
    }

    public function start(Atendimento $attendance): RedirectResponse
    {
        $this->attendances->start($attendance);

        return redirect()
            ->route('attendances.continue', $attendance)
            ->with('status', 'Atendimento iniciado. Preencha o registro clínico.');
    }

    public function continue(Atendimento $attendance): View
    {
        return view('pages.attendances.continue', $this->attendances->continuationData($attendance));
    }

    public function saveContinuation(SaveAttendanceContinuationRequest $request, Atendimento $attendance): RedirectResponse
    {
        $data = $request->validated();
        $this->attendances->saveContinuation($attendance, $data);

        return redirect()
            ->route('attendances.show', $attendance)
            ->with('status', $data['save_as'] === 'draft' ? 'Rascunho clínico salvo com sucesso.' : 'Atendimento finalizado com sucesso.');
    }

    public function children(Beneficiaria $beneficiaria): JsonResponse
    {
        return response()->json($this->attendances->childrenOptions($beneficiaria));
    }

    public function destroy(Atendimento $attendance): RedirectResponse
    {
        $this->attendances->destroy($attendance);

        return redirect()->route('attendances.index')->with('status', 'Atendimento excluído com sucesso.');
    }

    public function storeLocation(StoreLocationRequest $request): RedirectResponse
    {
        $this->attendances->storeLocation($request->validated());

        return back()->with('status', 'Local de atendimento criado com sucesso.');
    }
}
