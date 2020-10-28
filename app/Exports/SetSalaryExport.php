<?php

namespace App\Exports;

use App\Allowance;
use App\Commission;
use App\Employee;
use App\Loan;
use App\OtherPayment;
use App\Overtime;
use App\SaturationDeduction;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;

class SetSalaryExport implements FromView,WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $employees = Employee::where(['created_by' => Auth::user()->creatorId()])->get();

        $data = array();
        foreach ($employees as $value) {
            $allowance = Allowance::where('employee_id', $value->id)->first();
            $commission = Commission::where('employee_id', $value->id)->first();
            $loan = Loan::where('employee_id', $value->id)->first();
            $saturation_deduction = SaturationDeduction::where('employee_id', $value->id)->first();
        
            $other_payment = OtherPayment::where('employee_id', $value->id)->first();
           
            $overtime = Overtime::where('employee_id', $value->id)->first();
       
            $arr['id'] = $value->id;
            $arr['name'] = $value->name;
            $arr['salary'] = [
                'payslip_type' => $value->salary_type,
                'salary' => $value->salary
            ];
         
            if(!empty($allowance['allowance_option']) || !empty($allowance['title']) || !empty($allowance['amount'])){
                $arr['allowance'] = [
                    'allowance_option' => $allowance['allowance_option'],
                    'title' => $allowance['title'],
                    'amount' => "Rp " . number_format($allowance['amount'],2,',','.'),
                ];
            }else{
                $arr['allowance'] = [
                    'allowance_option' => '-',
                    'title' => '-',
                    'amount' => '-'
                ];
            } 
            if(!empty($commission['title']) || !empty($commission['amount'])){
                $arr['commission'] = [
                    'title' => $commission['title'],
                    'amount' => "Rp " . number_format($commission['amount'],2,',','.'),
                ];   
            }else{
                $arr['commission'] = [
                    'title' =>'-',
                    'amount' => '-',
                ];
            }
            if(!empty($loan['loan_option']) || !empty($loan['title']) || !empty($loan['amount']) || !empty($loan['reason']) || !empty($loan['start_date']) || !empty($loan['end_date'])){
                $arr['loan'] = [
                    'loan_option' => $loan['loan_option'],
                    'title' => $loan['title'],
                    'amount' => "Rp " . number_format($loan['amount'],2,',','.'),
                    'reason' => $loan['reason'],
                    'start_date' => $loan['start_date'],
                    'end_date' => $loan['end_date'],
                ];
            }else{
                $arr['loan'] = [
                    'loan_option' => '-',
                    'title' => '-',
                    'amount' => '-',
                    'reason' => '-',
                    'start_date' => '-',
                    'end_date' => '-',
                ];
            }
            if(!empty($saturation_deduction['deducation_option']) || !empty($saturation_deduction['title']) || !empty($saturation_deduction['amount']) ){
                $arr['saturation_deduction'] = [
                    'deduction_option' => $saturation_deduction['deduction_option'],
                    'title' => $saturation_deduction['title'],
                    'amount' => "Rp " . number_format($saturation_deduction['amount'],2,',','.'),
                ];
            }else{
                $arr['saturation_deduction'] = [
                    'deduction_option' => '-',
                    'title' => '-',
                    'amount' => '-',
                ];
            }
            if(!empty($other_payment['title']) || !empty($other_payment['amount'])){
                $arr['other_payment'] = [
                    'title' => $other_payment['title'],
                    'amount' => "Rp " . number_format($saturation_deduction['other_payment'],2,',','.')
                ];
            }else{
                $arr['other_payment'] = [
                    'title' =>'-',
                    'amount' => '-',
                ];
            }
            if(!empty($overtime['title']) || !empty($overtime['number_of_days']) || !empty($overtime['hours'])|| !empty($overtime['rate'])){
                $arr['overtime'] = [
                    'title' => $overtime['title'],
                    'number_of_days' => $overtime['number_of_days'],
                    'hours' => $overtime['hours'],
                    'rate' => $overtime['rate'],
                ];
            }else{
                $arr['overtime'] = [
                    'title' => '-',
                    'number_of_days' => '-',
                    'hours' => '-',
                    'rate' => '-',
                ];
            }
            array_push($data, $arr);         
        }
        // dd($data);
        return view('setsalary.export', [
            'data' => $data
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $alignmentArray  =[
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],   
                ];
                $borderArray =[
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '0000000'],
                            'bold'=>true,
                        ],
                    ],
                ];
                $borderArrayBold =[
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '0000000'],
                            'bold'=>true,
                        ],
                    ],
                ];

                /* border */
                $event->sheet->getStyle('A1')->applyFromArray($borderArray);
                $event->sheet->getStyle('B1')->applyFromArray($borderArray);
                $event->sheet->getStyle('C1')->applyFromArray($borderArray);
                $event->sheet->getStyle('D1')->applyFromArray($borderArray);
                $event->sheet->getStyle('E1')->applyFromArray($borderArray);
                $event->sheet->getStyle('F1')->applyFromArray($borderArray);
                $event->sheet->getStyle('G1')->applyFromArray($borderArray);
                $event->sheet->getStyle('H1')->applyFromArray($borderArray);
                $event->sheet->getStyle('I1')->applyFromArray($borderArray);
                $event->sheet->getStyle('J1')->applyFromArray($borderArray);
                $event->sheet->getStyle('K1')->applyFromArray($borderArray);
                $event->sheet->getStyle('L1')->applyFromArray($borderArray);
                $event->sheet->getStyle('M1')->applyFromArray($borderArray);
                $event->sheet->getStyle('N1')->applyFromArray($borderArray);
                $event->sheet->getStyle('O1')->applyFromArray($borderArray);
                $event->sheet->getStyle('P1')->applyFromArray($borderArray);
                $event->sheet->getStyle('Q1')->applyFromArray($borderArray);
                $event->sheet->getStyle('R1')->applyFromArray($borderArray);
                $event->sheet->getStyle('S1')->applyFromArray($borderArray);
                $event->sheet->getStyle('T1')->applyFromArray($borderArray);
                $event->sheet->getStyle('U1')->applyFromArray($borderArray);
                $event->sheet->getStyle('V1')->applyFromArray($borderArray);
                $event->sheet->getStyle('W1')->applyFromArray($borderArray);
                $event->sheet->getStyle('X1')->applyFromArray($borderArray);

                /* color */
                $event->sheet->getStyle('B1:X1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DCDCDC');
                /* font */
                $event->sheet->getStyle('A1:X1')->getFont()->setBold(true);

                /*wrap text */
                $event->sheet->getStyle('A1:X1')->getAlignment()->setWrapText(true);

                /*alignment Array */
                $event->sheet->getStyle('A1:X1')->applyFromArray($alignmentArray);

                /* width & height */
                $event->sheet->getRowDimension('1')->setRowHeight(30);
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(40);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(20);
                $event->sheet->getColumnDimension('E')->setWidth(18);
                $event->sheet->getColumnDimension('F')->setWidth(15);
                $event->sheet->getColumnDimension('G')->setWidth(18);
                $event->sheet->getColumnDimension('H')->setWidth(15);
                $event->sheet->getColumnDimension('I')->setWidth(18);
                $event->sheet->getColumnDimension('J')->setWidth(25);
                $event->sheet->getColumnDimension('K')->setWidth(25);
                $event->sheet->getColumnDimension('L')->setWidth(18);
                $event->sheet->getColumnDimension('M')->setWidth(20);
                $event->sheet->getColumnDimension('N')->setWidth(20);
                $event->sheet->getColumnDimension('O')->setWidth(20);
                $event->sheet->getColumnDimension('P')->setWidth(0);
                $event->sheet->getColumnDimension('Q')->setWidth(15);
                $event->sheet->getColumnDimension('R')->setWidth(18);
                $event->sheet->getColumnDimension('S')->setWidth(25);
                $event->sheet->getColumnDimension('T')->setWidth(25);
                $event->sheet->getColumnDimension('U')->setWidth(25);
                $event->sheet->getColumnDimension('V')->setWidth(25);
                $event->sheet->getColumnDimension('W')->setWidth(25);
                $event->sheet->getColumnDimension('X')->setWidth(25);

                $n=2;
                $count = Employee::where(['created_by' => Auth::user()->creatorId()])->count();
                // dd($count);
                $total = $n + $count;
        
                for($n;$n<$total;$n++){
                    $event->sheet->getStyle('B'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('C'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('D'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('E'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('F'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('G'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('H'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('I'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('J'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('K'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('L'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('M'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('N'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('O'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('Q'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('R'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('S'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('T'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('T'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('U'.strval($n))->getAlignment()->setHorizontal('left');
                    $event->sheet->getStyle('V'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('W'.strval($n))->getAlignment()->setHorizontal('right');
                    $event->sheet->getStyle('X'.strval($n))->getAlignment()->setHorizontal('right');

                    if($n % 2 == 0){
                        $event->sheet->getStyle('A'.strval($n).':X'.strval($n))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
                    }else{
                        $event->sheet->getStyle('A'.strval($n).':X'.strval($n))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DCDCDC'); 
                    }
                    $event->sheet->getStyle('A'.strval(2).':A'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('B'.strval(2).':B'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('C'.strval(2).':C'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('D'.strval(2).':D'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('E'.strval(2).':E'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('F'.strval(2).':F'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('G'.strval(2).':G'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('H'.strval(2).':H'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('I'.strval(2).':I'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('J'.strval(2).':J'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('K'.strval(2).':K'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('L'.strval(2).':L'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('M'.strval(2).':M'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('N'.strval(2).':N'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('O'.strval(2).':O'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('P'.strval(2).':P'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('Q'.strval(2).':Q'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('S'.strval(2).':S'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('T'.strval(2).':T'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('U'.strval(2).':U'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('V'.strval(2).':V'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('W'.strval(2).':W'.strval($count+1))->applyFromArray($borderArray);
                    $event->sheet->getStyle('X'.strval(2).':X'.strval($count+1))->applyFromArray($borderArray);
             
                 
                }
            }
        ];
    }
}
