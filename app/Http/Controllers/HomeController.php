<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Help;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Invoice;
use App\Models\Expense;
use App\Models\Report;

use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = User::where('type',2)->get();
        return view('home',['providers'=> $providers]);
    }


    public function help()
    {
        $items = Help::where('status', 'active')->get();
        return view('website.home.help', ['items' => $items]);
    }
    
    
    public function searchResults($text){

        $clientResults = Client::where('office_id', Auth::user()->office_id)->where('name', 'LIKE', '%'.$text.'%')->get();
        $clientResults = view('website.extraBlade.search.clientResults')->with(['clientResults' => $clientResults])->render();
        
        $projectResults = Project::where('office_id', Auth::user()->office_id)->where('name', 'LIKE', '%'.$text.'%')->get();
        $projectResults = view('website.extraBlade.search.projectResults')->with(['projectResults' => $projectResults])->render();
        
        $taskResults = Task::where('office_id', Auth::user()->office_id)->where('name', 'LIKE', '%'.$text.'%')->get();
        $taskResults = view('website.extraBlade.search.taskResults')->with(['taskResults' => $taskResults])->render();
        
        $invoiceResults = Invoice::where('office_id', Auth::user()->office_id)->where('office_address', 'LIKE', '%'.$text.'%')->get();
        $invoiceResults = view('website.extraBlade.search.invoiceResults')->with(['invoiceResults' => $invoiceResults])->render();
        
        $expenseResults = Expense::where('office_id', Auth::user()->office_id)->where('expense_details', 'LIKE', '%'.$text.'%')->get();
        $expenseResults = view('website.extraBlade.search.expenseResults')->with(['expenseResults' => $expenseResults])->render();
        
        $reportResults = Report::where('office_id', Auth::user()->office_id)->where('report_content', 'LIKE', '%'.$text.'%')->get();
        $reportResults = view('website.extraBlade.search.reportResults')->with(['reportResults' => $reportResults])->render();


        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'clientResults' => $clientResults, 
        'projectResults' => $projectResults, 'taskResults' => $taskResults,
        'invoiceResults' => $invoiceResults, 'expenseResults' => $expenseResults, 'reportResults' => $reportResults];
        
    }



}
