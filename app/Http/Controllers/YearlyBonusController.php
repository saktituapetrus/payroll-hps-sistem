<?php

namespace App\Http\Controllers;

use App\Employee;
use App\YearlyBonus;

use Illuminate\Http\Request;

class YearlyBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $yearlyBonuses = YearlyBonus::all();

        return view('yearlybonus.index', compact('yearlyBonuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::get()->pluck('name', 'id');

        return view('yearlybonus.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        YearlyBonus::create([
            'employee_id' => $request->input('employee_id'),
            'bonus_type' => $request->input('bonus_type'),
            'bonus_amount' => $request->input('bonus_amount'),
            'date_disbursement' => $request->input('date_disbursement')
        ]);

        return redirect()->route('yearlybonus.index')->with('success', 'Early Bonus successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $yearlyBonus = YearlyBonus::find($id);

        return view('yearlybonus.edit', compact('yearlyBonus', 'employees'));
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
        YearlyBonus::find($id)->update($post_data);

        return redirect()->route('yearlybonus.index')->with('success', 'Early Bonus successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        YearlyBonus::destroy($id);

        return redirect()->route('yearlybonus.index')->with('success', 'Early Bonus successfully deleted.');
    }
}
