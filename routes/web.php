<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login/{lang?}', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/password/reset/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('change.langPass');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('/home', 'HomeController@index')->name('home')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('/home/getlanguvage', 'HomeController@getlanguvage')->name('home.getlanguvage');


Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ],
    function () {

        Route::resource('settings', 'SettingsController');
        Route::post('email-settings', 'SettingsController@saveEmailSettings')->name('email.settings');
        Route::post('company-settings', 'SettingsController@saveCompanySettings')->name('company.settings');
        Route::post('system-settings', 'SettingsController@saveSystemSettings')->name('system.settings');
        Route::get('company-setting', 'SettingsController@companyIndex')->name('company.setting');
    }
);

Route::post(
    '/test/send',
    [
        'as' => 'test.email.send',
        'uses' => 'SettingsController@testEmailSend',
    ]
)->middleware(
    [
        'auth',
        'xss',
    ]
);
// End

Route::resource('user', 'UserController')->middleware(
    [
        'auth',
        'xss',
    ]
);

/** BEGIN import & export employees
 * Author: FAAPTECH
 * Date: 28/04/2020
 * Description: Make route post for import & export data employees
 */
Route::post('employee/import', 'EmployeeController@import')->name('employee.import')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('employee/export', 'EmployeeController@export')->name('employee.export')->middleware(
    [
        'auth',
        'xss',
    ]
);
/**END import & export employees */

Route::post('employee/json', 'EmployeeController@json')->name('employee.json')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('employee', 'EmployeeController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('department', 'DepartmentController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('designation', 'DesignationController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('document', 'DocumentController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('branch', 'BranchController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('awardtype', 'AwardTypeController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('award', 'AwardController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('termination', 'TerminationController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('terminationtype', 'TerminationTypeController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('announcement/getdepartment', 'AnnouncementController@getdepartment')->name('announcement.getdepartment')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('announcement/getemployee', 'AnnouncementController@getemployee')->name('announcement.getemployee')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('announcement', 'AnnouncementController')->middleware(
    [
        'auth',
        'xss',
    ]
);
//payslip

Route::resource('paysliptype', 'PayslipTypeController')->middleware(['auth','xss',]);

Route::resource('yearlybonus', 'YearlyBonusController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('loancustom', 'LoanCustomController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('allowance', 'AllowanceController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('commission', 'CommissionController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('allowanceoption', 'AllowanceOptionController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('loanoption', 'LoanOptionController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('deductionoption', 'DeductionOptionController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('loan', 'LoanController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('saturationdeduction', 'SaturationDeductionController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('otherpayment', 'OtherPaymentController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('overtime', 'OvertimeController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::post('event/getdepartment', 'EventController@getdepartment')->name('event.getdepartment')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('event/getemployee', 'EventController@getemployee')->name('event.getemployee')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('event', 'EventController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('meeting/getdepartment', 'MeetingController@getdepartment')->name('meeting.getdepartment')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('meeting/getemployee', 'MeetingController@getemployee')->name('meeting.getemployee')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('meeting', 'MeetingController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::put('employee/update/sallary/{id}', 'SetSalaryController@employeeUpdateSalary')->name('employee.salary.update')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('salary/employeeSalary', 'SetSalaryController@employeeSalary')->name('employeesalary')->middleware(
    [
        'auth',
        'xss',
    ]
);

/** BEGIN import & export set salary
 * Author: FAAPTECH
 * Date: 28/04/2020
 * Description: Make route post for import & export data set salary
 */
Route::post('setsalary/import', 'SetSalaryController@import')->name('setsalary.import')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('setsalary/export', 'SetSalaryController@export')->name('setsalary.export')->middleware(
    [
        'auth',
        'xss',
    ]
);
/**END import & export set salary */

Route::resource('setsalary', 'SetSalaryController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('payslip/paysalary/{id}/{date}', 'PaySlipController@paysalary')->name('payslip.paysalary')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('payslip/bulk_pay_create/{date}', 'PaySlipController@bulk_pay_create')->name('payslip.bulk_pay_create')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('payslip/bulkpayment/{date}', 'PaySlipController@bulkpayment')->name('payslip.bulkpayment')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('payslip/search_json', 'PaySlipController@search_json')->name('payslip.search_json')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('payslip/employeepayslip', 'PaySlipController@employeepayslip')->name('payslip.employeepayslip')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('payslip/showemployee/{id}', 'PaySlipController@showemployee')->name('payslip.showemployee')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('payslip/pdf/{id}', 'PaySlipController@pdf')->name('payslip.pdf')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('payslip', 'PaySlipController')->middleware(
    [
        'auth',
        'xss',
    ]
);


Route::resource('resignation', 'ResignationController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('travel', 'TravelController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('promotion', 'PromotionController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('transfer', 'TransferController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('complaint', 'ComplaintController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('warning', 'WarningController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::get('profile', 'UserController@profile')->name('profile')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::put('edit-profile', 'UserController@editprofile')->name('update.account')->middleware(
    [
        'auth',
        'xss',
    ]
);


Route::resource('accountlist', 'AccountListController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('accountbalance', 'AccountListController@account_balance')->name('accountbalance')->middleware(
    [
        'auth',
        'xss',
    ]
);


Route::get('leave/{id}/action', 'LeaveController@action')->name('leave.action')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('leave/changeaction', 'LeaveController@changeaction')->name('leave.changeaction')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('leave/jsoncount', 'LeaveController@jsoncount')->name('leave.jsoncount')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('leave', 'LeaveController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('ticket/{id}/reply', 'TicketController@reply')->name('ticket.reply')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('ticket/changereply', 'TicketController@changereply')->name('ticket.changereply')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('ticket', 'TicketController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::post('attendanceemployee/attendance', 'AttendanceEmployeeController@attendance')->name('attendanceemployee.attendance')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('attendanceemployee', 'AttendanceEmployeeController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('timesheet', 'TimeSheetController')->middleware(
    [
        'auth',
        'xss',
    ]
);


Route::resource('expensetype', 'ExpenseTypeController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('incometype', 'IncomeTypeController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('paymenttype', 'PaymentTypeController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('leavetype', 'LeaveTypeController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('payees', 'PayeesController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('payer', 'PayerController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('deposit', 'DepositController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('expense', 'ExpenseController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('transferbalance', 'TransferBalanceController')->middleware(
    [
        'auth',
        'xss',
    ]
);


Route::group(
    [
        'middleware' => [
            'auth',
            'xss',
        ],
    ],
    function () {
        Route::get('change-language/{lang}', 'LanguageController@changeLanquage')->name('change.language')->middleware(
            [
                'auth',
                'xss',
            ]
        );
        Route::get('manage-language/{lang}', 'LanguageController@manageLanguage')->name('manage.language')->middleware(
            [
                'auth',
                'xss',
            ]
        );
        Route::post('store-language-data/{lang}', 'LanguageController@storeLanguageData')->name('store.language.data')->middleware(
            [
                'auth',
                'xss',
            ]
        );
        Route::get('create-language', 'LanguageController@createLanguage')->name('create.language')->middleware(
            [
                'auth',
                'xss',
            ]
        );
        Route::post('store-language', 'LanguageController@storeLanguage')->name('store.language')->middleware(
            [
                'auth',
                'xss',
            ]
        );
    }
);

Route::resource('roles', 'RoleController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('permissions', 'PermissionController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::put('change-password', 'UserController@updatePassword')->name('update.password');
