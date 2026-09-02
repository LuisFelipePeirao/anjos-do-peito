<?php

namespace App\Services;

use App\Models\Atendimento;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityReportExportService
{
    public function download(array $filters): StreamedResponse
    {
        $start = Carbon::parse($filters['start_date'])->startOfDay();
        $end = Carbon::parse($filters['end_date'])->endOfDay();
        $spreadsheet = $this->spreadsheet($start, $end, $filters);
        $filename = sprintf('relatorio-de-atividades-%s-a-%s.xlsx', $start->toDateString(), $end->toDateString());

        return response()->streamDownload(function () use ($spreadsheet): void {
            (new Xlsx($spreadsheet))->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function spreadsheet(Carbon $start, Carbon $end, array $filters): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Relatorio');

        $this->writeHeader($sheet, $start, $end);

        $attendances = $this->attendances($start, $end, $filters);
        $row = 6;
        $row = $this->writeBlock($sheet, $row, 'POPULACAO ATENDIDA', $this->groupedRows($attendances, fn (Atendimento $attendance) => $attendance->categoriaAtendimento?->nome ?? 'Sem populacao informada'), 'TOTAL DE ATENDIMENTOS');
        $row = $this->writeBlock($sheet, $row, 'PROCEDIMENTOS', $this->groupedRows($attendances, fn (Atendimento $attendance) => $attendance->procedimento?->nome ?? 'Sem procedimento informado'), 'TOTAL DE PROCEDIMENTOS');
        $row = $this->writeBlock($sheet, $row, 'LOCAL DE ATENDIMENTO', $this->groupedRows($attendances, fn (Atendimento $attendance) => $attendance->local?->nome ?? 'Sem local informado'), 'TOTAL DE ATENDIMENTOS');
        $row = $this->writeBlock($sheet, $row, '', $this->specialScheduleRows($attendances), '');
        $this->writeBlock($sheet, $row, 'MUNICIPIOS', $this->groupedRows($attendances, fn (Atendimento $attendance) => $attendance->beneficiaria?->endereco?->cep?->cidade ?? 'Sem municipio informado'), 'TOTAL GERAL');

        $this->formatSheet($sheet);

        return $spreadsheet;
    }

    private function attendances(Carbon $start, Carbon $end, array $filters): Collection
    {
        return Atendimento::query()
            ->with(['categoriaAtendimento', 'procedimento', 'local', 'beneficiaria.endereco.cep'])
            ->where('situacao', 'realizado')
            ->where('rascunho', false)
            ->whereBetween('data_hora', [$start, $end])
            ->when(($filters['location'] ?? 'all') === 'remote', fn ($query) => $query->where('modalidade', 'remota'))
            ->when(is_numeric($filters['location'] ?? null), fn ($query) => $query->where('id_local', (int) $filters['location']))
            ->get();
    }

    private function writeHeader(Worksheet $sheet, Carbon $start, Carbon $end): void
    {
        $sheet->mergeCells('A1:O1');
        $sheet->setCellValue('A1', 'INSTITUTO CATARINENSE ANJOS DO PEITO - RELATORIO DE ATIVIDADES');
        $sheet->mergeCells('A2:O2');
        $sheet->setCellValue('A2', 'Periodo: '.$start->format('d/m/Y').' a '.$end->format('d/m/Y'));
        $sheet->fromArray([['', 'ATENDIMENTO GERAL', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez', 'Total']], null, 'A4');
    }

    private function groupedRows(Collection $attendances, callable $labelResolver): array
    {
        $rows = $attendances
            ->groupBy(fn (Atendimento $attendance) => $labelResolver($attendance))
            ->sortKeys()
            ->map(function (Collection $items, string $label): array {
                $months = $this->emptyMonths();

                foreach ($items as $attendance) {
                    $months[(int) $attendance->data_hora->month]++;
                }

                return [
                    'label' => mb_strtoupper($label),
                    'months' => $months,
                    'total' => array_sum($months),
                ];
            })
            ->values()
            ->all();

        return $rows ?: [[
            'label' => 'SEM REGISTROS',
            'months' => $this->emptyMonths(),
            'total' => 0,
        ]];
    }

    private function specialScheduleRows(Collection $attendances): array
    {
        $months = $this->emptyMonths();

        foreach ($attendances as $attendance) {
            if ($this->isSpecialSchedule($attendance->data_hora)) {
                $months[(int) $attendance->data_hora->month]++;
            }
        }

        return [[
            'label' => 'ATENDIMENTOS APOS AS 18 HORAS, SABADOS, DOMINGOS E FERIADOS',
            'months' => $months,
            'total' => array_sum($months),
        ]];
    }

    private function isSpecialSchedule(Carbon $date): bool
    {
        return (int) $date->format('H') >= 18
            || $date->isWeekend()
            || in_array($date->format('m-d'), $this->fixedHolidays(), true);
    }

    private function fixedHolidays(): array
    {
        return [
            '01-01',
            '04-21',
            '05-01',
            '09-07',
            '10-12',
            '11-02',
            '11-15',
            '12-25',
        ];
    }

    private function writeBlock(Worksheet $sheet, int $row, string $title, array $rows, string $totalLabel): int
    {
        $startRow = $row;

        foreach ($rows as $index => $data) {
            $sheet->setCellValue('A'.$row, $index === 0 ? $title : '');
            $sheet->setCellValue('B'.$row, $data['label']);
            $sheet->fromArray([array_values($data['months'])], null, 'C'.$row);
            $sheet->setCellValue('O'.$row, $data['total']);
            $row++;
        }

        if ($title !== '' && $row > $startRow) {
            $sheet->mergeCells("A{$startRow}:A".($row - 1));
        }

        if ($totalLabel === '') {
            return $row + 1;
        }

        $months = $this->emptyMonths();
        foreach ($rows as $data) {
            foreach ($data['months'] as $month => $value) {
                $months[$month] += $value;
            }
        }

        $sheet->setCellValue('B'.$row, $totalLabel);
        $sheet->fromArray([array_values($months)], null, 'C'.$row);
        $sheet->setCellValue('O'.$row, array_sum($months));

        return $row + 2;
    }

    private function emptyMonths(): array
    {
        return array_fill(1, 12, 0);
    }

    private function formatSheet(Worksheet $sheet): void
    {
        $dimension = $sheet->calculateWorksheetDimension();

        $sheet->getStyle('A1:O1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BF2F63']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A2:O2')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '374151']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A4:O4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '111827']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle($dimension)->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'EADFE0']],
            ],
        ]);
        $sheet->getStyle('C:O')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A:O')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A:O')->getAlignment()->setWrapText(true);

        foreach (range(1, $sheet->getHighestRow()) as $row) {
            $blockTitle = trim((string) $sheet->getCell('A'.$row)->getValue());
            $label = trim((string) $sheet->getCell('B'.$row)->getValue());

            if ($blockTitle !== '') {
                $sheet->getStyle('A'.$row)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'BF2F63']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FDECEF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }

            if (str_starts_with($label, 'TOTAL')) {
                $sheet->getStyle('B'.$row.':O'.$row)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FBFAF9']],
                ]);
            }
        }

        $sheet->freezePane('C5');
        $sheet->getColumnDimension('A')->setWidth(24);
        $sheet->getColumnDimension('B')->setWidth(56);
        foreach (range('C', 'O') as $column) {
            $sheet->getColumnDimension($column)->setWidth(10);
        }
    }
}
