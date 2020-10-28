<?php

namespace App\Http\Controllers;

use App\Employee;
use App\LoanCustom;
use App\YearlyBonus;
use Illuminate\Http\Request;

class LoanCustomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loanCustoms = LoanCustom::all();

        return view('loancustom.index', compact('loanCustoms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::get()->pluck('name', 'id');

        return view('loancustom.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post_data = $request->all();

        LoanCustom::create($post_data);

        return redirect()->route('loancustom.index')->with('success', 'Loan Custom successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanCustom = LoanCustom::find($id);
        $loanCustomsss = LoanCustom::where('employee_id', $loanCustom->employee_id)->get();
        $yearlyBonuses = YearlyBonus::where('employee_id', $loanCustom->employee_id)->get();

        return view('loancustom.show', compact('loanCustom', 'loanCustomsss', 'yearlyBonuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees = Employee::get()->pluck('name', 'id');
        $loanCustom = LoanCustom::find($id);

        return view('loancustom.edit', compact('loanCustom', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post_data = $request->all();
        LoanCustom::find($id)->update($post_data);

        return redirect()->route('loancustom.index')->with('success', 'Loan Custom successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoanCustom::destroy($id);

        return redirect()->route('loancustom.index')->with('success', 'Loan Custom successfully deleted.');
    }
}
