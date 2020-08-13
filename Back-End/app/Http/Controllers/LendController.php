<?php


namespace App\Http\Controllers;
use App\lend;
use App\sales;
use Illuminate\Http\Request;

class LendController extends Controller
{

    public function getLend(){
        return response()->json(lend::orderBy('id', 'DESC')->get());
    }

    public function addMoney($id,$amount){
        $lendUser = lend::find($id);
        $invoiceNo = $lendUser->invoiceId;

        $salesInvoice = sales::where('invoiceId','=',$invoiceNo)->first();
        $salesInvoice->paidAmount = $salesInvoice->paidAmount + $amount;
        $salesInvoice->save();

        $lendUser->paid = $lendUser->paid+$amount;
        $lendUser->remaining = $lendUser->remaining-$amount;
        $lendUser->save();
    }

    public function deleteLend($id){
        $lendUser = lend::find($id);
        $lendUser->delete();
    }

    public function newLend(Request $request){
        $lend = new lend();
        $lend->fullName = $request->input('FullName');
        $lend->NIC = $request->input('Nic');
        $lend->total = $request->input('Total');
        $lend->paid = $request->input('Payment');
        $lend->remaining = $lend->total - $lend->paid;
        $lend->invoiceId = $request->input('InvoiceNo');
        $lend->save();

    }

    public function newLendInvoice(Request $request,$file){

        $path = "H:\Laravel\POS-Backend\SalesInvoice\\";
        $url = "H:\Laravel\POS-Backend\SalesInvoice";
        $pdf = $request->input('pdfBase64');
        $decode = base64_decode($pdf);
        $filename = $file.'.pdf';
        $filepath = $path.$filename;

        file_put_contents($filepath,$decode);

        $dbPdf = $url."\\".$filename;

        $lend = lend::where('invoiceId','=',$file)->first();

        $lend->invoiceLink = $dbPdf;
        $lend->save();

    }

}
