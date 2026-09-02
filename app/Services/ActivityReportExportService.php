<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityReportExportService
{
    public function download(array $filters): StreamedResponse
    {
        $start = Carbon::parse($filters['start_date'])->startOfDay();
        $end = Carbon::parse($filters['end_date'])->endOfDay();
        $spreadsheet = $this->spreadsheet($start, $end);
        $filename = sprintf('relatorio-de-atividades-%s-a-%s.xlsx', $start->toDateString(), $end->toDateString());

        return response()->streamDownload(function () use ($spreadsheet): void {
            (new Xlsx($spreadsheet))->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function spreadsheet(Carbon $start, Carbon $end): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Relatorio');
        $sheet->setCellValue('A1', 'INSTITUTO CATARINENSE ANJOS DO PEITO - RELATORIO DE ATIVIDADES');
        $sheet->setCellValue('A2', 'Periodo: '.$start->format('d/m/Y').' a '.$end->format('d/m/Y'));
        $sheet->fromArray([['Descricao', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez', 'Total']], null, 'A4');

        return $spreadsheet;
    }
}
