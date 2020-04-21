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



Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function () {

Route::get('/', 'WEB\UserController')->name('HomePage');

    Route::post('/loginuser', 'WEB\UserController@loginuser')->name('loginuser');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('/login', 'Auth\LoginController@login')->name('login');


    Route::group(['middleware' => ['auth']], function () {
        Route::get('/userlogout', 'WEB\UserController@userlogout')->name('userlogout');

        Route::get('/getCountries/','WEB\CityController@getCountries');
        Route::get('/getCities/{id}','WEB\CityController@getCities');
        Route::get('/getTasksSame/{date}','WEB\TaskController@getTasksSame');
        Route::get('/getClientProjects/{id}','WEB\ClientController@getClientProjects');
        Route::get('/getProjectHours/{id}','WEB\ClientController@getProjectHours');
        Route::get('/getProjectHoExTa/{id}','WEB\ClientController@getProjectHoExTa');
        Route::get('/getClientInvoices/{id}','WEB\ClientController@getClientInvoices');
        Route::get('/getProjectsTasks/{id}','WEB\ClientController@getProjectsTasks');


        Route::get('/getProjects/','WEB\TaskController@getProjects');
        Route::get('/getTasks/{id}','WEB\TaskController@getTasks');

        Route::get('/getNote/{id}', 'WEB\NoteController@getNote');
        Route::post('/notes/create_note', 'WEB\NoteController@create_note');
        Route::post('/updateNote/{id}', 'WEB\NoteController@updateNote');
        Route::get('/delete_note/{id}','WEB\NoteController@delete_note');

        Route::get('/help', 'HomeController@help');

        Route::get('/searchResults/{text}', 'HomeController@searchResults');

        Route::get('/clientFilterStatus/{status}', 'WEB\ClientController@clientFilterStatus');
        Route::get('/clientFilterText/{text}', 'WEB\ClientController@clientFilterText');
        Route::get('/clientFilterForm/', 'WEB\ClientController@clientFilterForm');


        Route::get('/projectFilterStatus/{status}', 'WEB\ProjectController@projectFilterStatus');
        Route::get('/projectFilterText/{text}', 'WEB\ProjectController@projectFilterText');
        Route::get('/projectFilterForm/', 'WEB\ProjectController@projectFilterForm');
        Route::get('exportAllProjectsPDF', 'WEB\ProjectController@exportAllProjectsPDF');
        Route::get('exportProjectDetPDF/{id}', 'WEB\ProjectController@exportProjectDetPDF');

        Route::get('exportAllTasksPDF', 'WEB\TaskController@exportAllTasksPDF');


        Route::get('/taskFilterStatus/{status}', 'WEB\TaskController@taskFilterStatus');
        Route::get('/taskFilterText/{text}', 'WEB\TaskController@taskFilterText');
        Route::get('/taskFilterForm/', 'WEB\TaskController@taskFilterForm');



        Route::resource('/clients', 'WEB\ClientController');
        Route::post('/clients/createModel', 'WEB\ClientController@createModel');
        Route::post('/attachments/createAttach', 'WEB\AttachmentController@createAttach');

        Route::resource('/projects', 'WEB\ProjectController');
        Route::post('/changeStatus/{model}', 'WEB\HomeController@changeStatus');


        Route::get('/sendInvoiceToClient/{invoice_id}/','WEB\UserController@sendInvoiceToClient');
        Route::get('/sendReportToClient/{report_id}/','WEB\UserController@sendReportToClient');
        Route::get('/projects/changeStatus/{project_id}/{newStatus}','WEB\ProjectController@changeStatus');


        Route::post('/tasks/ReportTasks', 'WEB\TaskController@ReportTasks');


        Route::get('/tasks/delete/{id}', 'WEB\TaskController@destroy');



        Route::resource('/tasks', 'WEB\TaskController');


        Route::get('/tasks/completeTask/{task_id}','WEB\TaskController@completeTask');
        Route::get('/tasks/changeTaskStatus/{expense_id}/{newStatus}','WEB\TaskController@changeTaskStatus');


        Route::get('/hourFilterStatus/{status}', 'WEB\ProjectHourController@hourFilterStatus');
        Route::get('/hourFilterText/{text}', 'WEB\ProjectHourController@hourFilterText');
        Route::get('/hourFilterForm/', 'WEB\ProjectHourController@hourFilterForm');

        Route::get('exportAllHoursPDF', 'WEB\ProjectHourController@exportAllHoursPDF');



        Route::get('/documentFilterStatus/{status}', 'WEB\DocumentController@documentFilterStatus');
        Route::get('/documentFilterText/{text}', 'WEB\DocumentController@documentFilterText');
        Route::get('/documentFilterForm/', 'WEB\DocumentController@documentFilterForm');

        Route::get('exportAllDocumentsPDF', 'WEB\DocumentController@exportAllDocumentsPDF');


        Route::get('reportExportPDF/{id}', 'WEB\ReportController@reportExportPDF');
        Route::get('/reportFilterStatus/{status}', 'WEB\ReportController@reportFilterStatus');
        Route::get('/reportFilterText/{text}', 'WEB\ReportController@reportFilterText');
        Route::get('/reportFilterForm/', 'WEB\ReportController@reportFilterForm');


        Route::get('/expenseFilterStatus/{status}', 'WEB\ExpenseController@expenseFilterStatus');
        Route::get('/expenseFilterText/{text}', 'WEB\ExpenseController@expenseFilterText');
        Route::get('/expenseFilterForm/', 'WEB\ExpenseController@expenseFilterForm');


        Route::get('/invoiceFilterStatus/{status}', 'WEB\InvoiceController@invoiceFilterStatus');
        Route::get('/invoiceFilterText/{text}', 'WEB\InvoiceController@invoiceFilterText');
        Route::get('/invoiceFilterForm/', 'WEB\InvoiceController@invoiceFilterForm');


        Route::get('/billFilterStatus/{status}', 'WEB\BillController@billFilterStatus');
        Route::get('/billFilterText/{text}', 'WEB\BillController@billFilterText');
        Route::get('/billFilterForm/', 'WEB\BillController@billFilterForm');


        Route::post('/hours/InvoiceHour', 'WEB\ProjectHourController@InvoiceHour');
        Route::post('/hours/ReportHours', 'WEB\ProjectHourController@ReportHours');



        Route::resource('/hours', 'WEB\ProjectHourController');

        Route::resource('/reports', 'WEB\ReportController');



        // Settings //
        Route::get('settings', 'WEB\SettingController@settings');


        Route::get('/office_profile', 'WEB\SettingController@office_profile');
        Route::put('/office_profile', 'WEB\SettingController@update_office_profile');

        Route::get('/profile', 'WEB\SettingController@profile');
        Route::put('/profile', 'WEB\SettingController@update_profile');

        Route::get('/clients_settings', 'WEB\SettingController@clients_settings');
        Route::put('/clients_settings', 'WEB\SettingController@update_clients_settings');

        Route::get('/projects_settings', 'WEB\SettingController@projects_settings');
        Route::put('/projects_settings', 'WEB\SettingController@update_projects_settings');

        Route::get('/tasks_settings', 'WEB\SettingController@tasks_settings');
        Route::put('/tasks_settings', 'WEB\SettingController@update_tasks_settings');

        Route::get('/hours_settings', 'WEB\SettingController@hours_settings');
        Route::put('/hours_settings', 'WEB\SettingController@update_hours_settings');

        Route::get('/invoices_settings', 'WEB\SettingController@invoices_settings');
        Route::put('/invoices_settings', 'WEB\SettingController@update_invoices_settings');

        Route::get('/expenses_settings', 'WEB\SettingController@expenses_settings');
        Route::put('/expenses_settings', 'WEB\SettingController@update_expenses_settings');


        // End Settings //


        Route::resource('/roles_settings', 'WEB\RoleGroupController');
        Route::resource('/fields', 'WEB\FieldController');
        Route::resource('/staff', 'WEB\StaffController');


        Route::get('pdf_form', 'WEB\PdfController@pdfForm');
        Route::post('pdf_download', 'WEB\PdfController@pdfDownload');


        Route::get('invoiceExportPDF/{id}', 'WEB\InvoiceController@invoiceExportPDF');
        Route::get('exportAllInvoicesPDF', 'WEB\InvoiceController@exportAllInvoicesPDF');


        Route::get('/invoicePreview/{id}','WEB\InvoiceController@invoicePreview');

        Route::get('/getInvoiceData/{id}','WEB\InvoiceController@getInvoiceData');

        Route::get('/invoices/completeInvoice/{invoice_id}','WEB\InvoiceController@completeInvoice');
        Route::get('/hourInvoice/{hour_id}','WEB\InvoiceController@hourInvoice');
        Route::get('/expenseInvoice/{expense_id}','WEB\InvoiceController@expenseInvoice');
        Route::resource('/invoices', 'WEB\InvoiceController');
        Route::resource('/bills', 'WEB\BillController');
        Route::get('exportAllBillsPDF', 'WEB\BillController@exportAllBillsPDF');


        Route::post('/flats_fees/InvoiceFlatsFees', 'WEB\FlatFeeController@InvoiceFlatsFees');
        Route::resource('/flats_fees', 'WEB\FlatFeeController');

        Route::post('/expenses/InvoiceExpense', 'WEB\ExpenseController@InvoiceExpense');
        Route::post('/expenses/ReportExpense', 'WEB\ExpenseController@ReportExpense');


        Route::resource('/expenses', 'WEB\ExpenseController');
        Route::get('/expenses/canceledExpense/{task_id}','WEB\ExpenseController@canceledExpense');

        Route::get('exportAllExpensesPDF', 'WEB\ExpenseController@exportAllExpensesPDF');


        Route::get('/getFolder/{id}', 'WEB\DocumentController@getFolder');
        Route::get('/getDocument/{id}', 'WEB\DocumentController@getFolder');
        Route::post('/updateFolder/{id}', 'WEB\DocumentController@updateFolder');
        Route::post('/updateDoucment/{id}', 'WEB\DocumentController@updateDoucment');
        Route::post('/updateNote/{id}', 'WEB\NoteController@updateNote');
        Route::resource('/documents', 'WEB\DocumentController');




        // Events & Calender //

        Route::get('/events', 'WEB\EventController@index');
        Route::get('/events/create', 'WEB\EventController@create');
        Route::post('/events/store', 'WEB\EventController@store');
        Route::get('/events/edit/{id}', 'WEB\EventController@edit');
        Route::post('/events/update', 'WEB\EventController@update');
        Route::get('/events/delete/{id}', 'WEB\EventController@delete');


    });


    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', function () {
            return route('/login');
        });


        Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login.form');
        Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.login');




        Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
    });






    Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
        Route::get('/', function () {
            return redirect('/admin/home');
        });
        Route::post('/changeStatus/{model}', 'HomeController@changeStatus');

        Route::get('home', 'HomeController@index')->name('admin.home');

        Route::get('/getCities/{id}','HomeController@getCities');
        Route::get('/getCountries/','HomeController@getCountries');

        Route::get('/admins/{id}/edit', 'AdminController@edit')->name('admins.edit');
        Route::patch('/admins/{id}', 'AdminController@update')->name('users.update');
        Route::get('/admins/{id}/edit_password', 'AdminController@edit_password')->name('admins.edit_password');
        Route::post('/admins/{id}/edit_password', 'AdminController@update_password')->name('admins.edit_password');



        if (can('admins')){
            Route::get('/admins', 'AdminController@index')->name('admins.all');
            Route::post('/admins/changeStatus', 'AdminController@changeStatus')->name('admin_changeStatus');

            Route::delete('admins/{id}', 'AdminController@destroy')->name('admins.destroy');

            Route::post('/admins', 'AdminController@store')->name('admins.store');
            Route::get('/admins/create', 'AdminController@create')->name('admins.create');
        }


        if (can('slider')){
            Route::post('/slider/changeStatus', 'SliderController@changeStatus');
            Route::delete('slider/image/{image_id}', 'SliderController@deleteImage');
            Route::resource('/slider', 'SliderController');
        }


        if (can('settings')){
            Route::get('settings', 'SettingController@index')->name('settings.all');
            Route::post('settings', 'SettingController@update')->name('settings.update');
        }


        if(can('pages')){
            Route::post('/pages/changeStatus', 'PagesController@changeStatus');
            Route::resource('/pages', 'PagesController');
        }




        if (can('users')){

            Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy');
            Route::get('/users/{id}/edit_password', 'UserController@edit_password')->name('users.edit_password');
            Route::post('/users/{id}/edit_password', 'UserController@update_password')->name('users.edit_password');
            Route::post('users_changeStatus2', 'UserController@changeStatus2');
            Route::resource('/users', 'UserController');
        }



        if (can('employees')){
            Route::get('/employees/{id}/edit_password', 'EmployeesController@edit_password')->name('users.edit_password');
            Route::post('/employees/{id}/edit_password', 'EmployeesController@update_password')->name('users.edit_password');
            Route::get('/employees/{id}/locations', 'EmployeesController@locations');
            Route::resource('/employees', 'EmployeesController');
        }



        if(can('permissions')){
            Route::resource('/role', 'RoleController');
        }



        if(can('countries')){
            Route::resource('/countries', 'CountryController');
        }



        if(can('cities')){
            Route::resource('/cities', 'CityController');
        }


        if(can('personalcards')){
            Route::resource('/personalcards', 'PersonalCardsController');
        }




        if(can('projectstatus')){
            Route::resource('/projectstatus', 'ProjectStatusController');
        }


        if(can('lawsuits')){
            Route::resource('/lawsuits', 'LawsuitsController');
        }


        if(can('consultations')){
            Route::resource('/consultations', 'ConsultationController');
        }


        if(can('tasks_types')){
            Route::resource('/tasks_types', 'TaskTypeController');
        }


        if(can('tasks_status')){
            Route::resource('/tasks_status', 'TaskStatusController');
        }


        if(can('aspect_expenses')){
            Route::resource('/aspect_expenses', 'AspectExpenseController');
        }


        if(can('clients_descriptions')){
            Route::resource('/clients_descriptions', 'ClientDescriptionController');
        }


        if(can('contenders')){
            Route::resource('/contenders', 'ContenderController');
        }


        if(can('zones')){
            Route::resource('/zones', 'ZoneController');
        }




    });



});


Route::fallback('WEB\UserController');



