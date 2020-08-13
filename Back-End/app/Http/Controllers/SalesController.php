<?php

namespace App\Http\Controllers;

use App\sales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function GuzzleHttp\Psr7\copy_to_string;

class SalesController extends Controller
{
    public function getData(){
        return response()->json(sales::orderBy('id', 'DESC')->get());
    }

    public function insertSale(Request $request,$seller,$invoiceID){
        $sale = new sales();
        $sale->customerName = $request->input('customerName');
        $sale->paidAmount = $request->input('payValue');
        $sale->soldBy = $seller;
        $sale->invoiceId = $invoiceID;
        $sale->save();
        return response()->json(["status"=>"ok"],201);
    }

    public function newsaleInvoice(Request $request,$file){

        $path = "H:\Laravel\POS-Backend\SalesInvoice\\";
        $url = "H:\Laravel\POS-Backend\SalesInvoice";
        $pdf = $request->input('pdfBase64');
        $decode = base64_decode($pdf);
        $filename = $file.'.pdf';
        $filepath = $path.$filename;

        file_put_contents($filepath,$decode);

        $dbPdf = $url."\\".$filename;

        $sale = sales::where('invoiceId','=',$file)->first();

        $sale->invoiceLink = $dbPdf;
        $sale->save();

    }

    public function incomeByDate(){
        $sales = DB::table('sales')
            ->select(DB::raw('created_at as date'),DB::raw('count(id) as total'), DB::raw('sum(paidAmount) as income'))
            ->groupBy('date')
            ->get();
        return response()->json($sales,201);
    }

    public function incomeByMonth(){

        $today = substr(strval(Carbon::today()),0,7);

        $sales = DB::table('sales')
            ->where('created_at','like',$today.'%')
            ->select(DB::raw('count(id) as total'), DB::raw('sum(paidAmount) as income'))
            ->get();

        return response()->json(["income"=>$sales],201);
    }

    public function incomeLastMonth(){
        $date = Carbon::today();
        $lastMonth =  $date->subMonth()->format('y-m');
        $month = "20".$lastMonth;

        $sales = DB::table('sales')
            ->where('created_at','like',$month.'%')
            ->select(DB::raw('count(id) as total'), DB::raw('sum(paidAmount) as income'))
            ->get();

        return response()->json(["income"=>$sales],201);
    }
}
