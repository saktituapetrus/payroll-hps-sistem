<table>
    <thead>
        <tr>
            <th align="center">ID</th>
            <th align="center">NAME</th>
            <td align="center">PAYSLIP TYPE</td>
            <td align="center">SALARY</td>
            <td align="center">ALLOWANCE OPTION</td>
            <td align="center">ALLOWANCE TITLE</td>
            <td align="center">ALLOWANCE AMOUNT</td>
            <td align="center">COMMISSION TITLE</td>
            <td align="center">COMMISSION AMOUNT</td>
            <td align="center">LOAN OPTION</td>
            <td align="center">LOAN TITLE</td>
            <td align="center">LOAN AMOUNT</td>
            <td align="center">LOAN REASON</td>
            <td align="center">LOAN START DATE</td>
            <td align="center">LOAN END DATE</td>
            <td align="center">SATURATION OPTION</td>
            <td align="center">SATURATION TITLE</td>
            <td align="center">SATURATION AMOUNT</td>
            <td align="center">PAYMENT TITLE</td>
            <td align="center">PAYMENT AMOUNT</td>
            <td align="center">OVERTIME TITLE</td>
            <td align="center">OVERTIME NUMBER OF DAYS</td>
            <td align="center">OVERTIME HOURS</td>
            <td align="center">OVERTIME RATE</td>
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $row)
        @php 
        $allowance_name;
        if($row['allowance']['allowance_option'] == 1){
            $allowance_name ="THR";
        }elseif($row['allowance']['allowance_option'] == 2){
            $allowance_name ="Kesehatan";
        }elseif($row['allowance']['allowance_option'] == 3){
            $allowance_name ="Transport";
        }elseif($row['allowance']['allowance_option'] == 4){
            $allowance_name ="Mentor";
        }else{
            $allowance_name ="-"; 
        }

        $salary_tipe;
        $salary_type = DB::table('payslip_types')->where('id','=',$row['salary']['payslip_type'])->first();
        if(!empty($salary_type->name)){
            $salary_tipe = $salary_type->name;
        }else{
            $salary_tipe = '-';
        }

        $option_loan;
        $loan_option = DB::table('loan_options')->where('id','=',$row['loan']['loan_option'])->first();
        if(!empty($loan_option->name)){
            $option_loan = $loan_option->name;
        }else{
            $option_loan = '-';
        }
        $startdate;
        if($row['loan']['start_date'] == '1970-01-01'){
            $startdate = '-';
            
        }else{
            $startdate =  date('d F Y',strtotime($row['loan']['start_date'])); 
        }
        $saturatiodeducation;
        $saturation = DB::table('saturation_deductions')->where('id','=',$row['saturation_deduction']['deduction_option'])->first();
        if(!empty($saturation->name)){
            $saturatiodeducation = $saturation->name;
        }else{
            $saturatiodeducation = '-';
        }

        @endphp
        <tr>
            <td align="center">{{ $row['id'] }}</td>
            <td align="center">{{ $row['name'] }}</td>
            <td align="center">{{ $salary_tipe }}</td>
            <td align="center">{{ "Rp " . number_format($row['salary']['salary'],2,',','.')  }}</td>
            <td align="center">{{ $allowance_name }}</td>
            <td align="center">{{ $row['allowance']['title'] }}</td>
            <td align="center">{{ $row['allowance']['amount']}}</td>
            <td align="center">{{ $row['commission']['title'] }}</td>
            <td align="center">{{ $row['commission']['amount'] }}</td>
            <td align="center">{{ $option_loan }}</td>
            <td align="center">{{ $row['loan']['title'] }}</td>
            <td align="center">{{ $row['loan']['amount'] }}</td>
            <td align="center">{{ $row['loan']['reason'] }}</td>
            <td align="center">{{ $startdate }}</td>
            <td align="center">{{ date('d F Y',strtotime($row['loan']['end_date'])) }}</td>
            <td align="center">{{ $saturatiodeducation}}</td>
            <td align="center">{{ $row['saturation_deduction']['title'] }}</td>
            <td align="center">{{ $row['saturation_deduction']['amount'] }}</td>
            <td align="center">{{ $row['other_payment']['title'] }}</td>
            <td align="center">{{ $row['other_payment']['amount'] }}</td>
            <td align="center">{{ $row['overtime']['title'] }}</td>
            <td align="center">{{ $row['overtime']['number_of_days'] }}</td>
            <td align="center">{{ $row['overtime']['hours'] }}</td>
            <td align="center">{{ $row['overtime']['rate'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>