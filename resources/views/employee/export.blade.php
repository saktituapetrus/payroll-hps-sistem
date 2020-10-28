<table>
    <thead>
        <tr>
            <th align="center">ID</th>
            <th align="center">USER ID</th>
            <td align="center">NAME</td>
            <td align="center">DOB</td>
            <td align="center">GENDER</td>
            <td align="center">PHONE</td>
            <td align="center">ADDRESS</td>
            <td align="center">EMAIL</td>
            <td align="center">PASSWORD</td>
            <td align="center">EMPLOYEE ID</td>
            <td align="center">BRANCH ID</td>
            <td align="center">DEPARTMENT ID</td>
            <td align="center">DESIGNATION ID</td>
            <td align="center">COMPANY DOJ</td>
            <td align="center">DOCUMENTS</td>
            <td align="center">ACCOUNT HOLDER NAME</td>
            <td align="center">ACCOUNT NUMBER</td>
            <td align="center">BANK NAME</td>
            <td align="center">BANK IDENTIFIER CODE</td>
            <td align="center">BRANCH LOCATION</td>
            <td align="center">TAX PAYER ID</td>
            <td align="center">SALARY TYPE</td>
            <td align="center">SALARY</td>
            {{-- <td align="center">IS ACTIVE</td> --}}
            {{-- <td align="center">CREATED BY</td> --}}
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $row)
        <tr>
            <td align="center">{{ $row['id'] }}</td>
            <td align="center">{{ $row['user_id'] }}</td>
            <td align="center">{{ $row['name'] }}</td>
            <td align="center">{{ $row['dob'] }}</td>
            <td align="center">{{ $row['gender'] }}</td>
            <td align="center">{{ $row['phone'] }}</td>
            <td align="center">{{ $row['address'] }}</td>
            <td align="center">{{ $row['email'] }}</td>
            <td align="center">{{ $row['password'] }}</td>
            <td align="center">{{ $row['employee_id'] }}</td>
            <td align="center">{{ $row['branch_id'] }}</td>
            <td align="center">{{ $row['department_id'] }}</td>
            <td align="center">{{ $row['designation_id'] }}</td>
            <td align="center">{{ $row['company_doj'] }}</td>
            <td align="center">{{ $row['documents'] }}</td>
            <td align="center">{{ $row['account_holder_name'] }}</td>
            <td align="center">{{ $row['account_number'] }}</td>
            <td align="center">{{ $row['bank_name'] }}</td>
            <td align="center">{{ $row['bank_identifier_code'] }}</td>
            <td align="center">{{ $row['branch_location'] }}</td>
            <td align="center">{{ $row['tax_payer_id'] }}</td>
            <td align="center">{{ $row['salary_type'] }}</td>
            <td align="center">{{ $row['salary'] }}</td>
            {{-- <td align="center">{{ $row['is_active'] }}</td> --}}
            {{-- <td align="center">{{ $row['created_by'] }}</td> --}}
        </tr>
        @endforeach
    </tbody>
</table>
