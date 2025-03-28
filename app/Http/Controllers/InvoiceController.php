<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function InvoiceCreate(Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');

            $data = [
                'user_id' => $user_id,
                'customer_id' => $request->customer_id,
                'total' => $request->total,
                'vat' => $request->vat,
                'payable' => $request->payable,
                'discount' => $request->discount
            ];

            $invoice = Invoice::create($data);

            $products = $request->input('products');

            foreach($products as $product){
                $existUnit = Product::where('id', $product['id'])->first();

                if(!$existUnit){
                    return response()->json([
                        'status' => 'failed',
                        'message' => "Product with ID {$product['id']} not found"
                    ]);
                }

                if($existUnit->unit < $product['unit']){
                    return response()->json([
                        'status' => 'failed',
                        'message' => "Only {$existUnit->unit} units available in stock for product id {$product['unit']}"
                    ]);
                }
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product['id'],
                    'user_id' => $user_id,
                    'qty' => $product['unit'],
                    'sale_price' => $product['price']
                ]);
                Product::where('id', $product['id'])->update([
                    'unit' => $existUnit->unit - $product['unit']
                ]);
            }//end foreach

            DB::commit();
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Invoice created successfully'
            // ]);

            $data = ['message'=>'Invoice created successfully','status'=>true,'error'=>''];
            return redirect('/InvoiceListPage')->with($data);
        }catch(Exception $e){
            DB::rollBack();
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => "Something went wrong"
            // ]);

            $data = ['message'=>'Something went wrong','status'=>false,'error'=>$e->getMessage()];
            return redirect()->back()->with($data);
        }
    }//end method

    public function InvoiceListPage(Request $request){
        $user_id = request()->header('id');
        $list = Invoice::where('user_id', $user_id)
            ->with('customer','invoiceProduct.product')->get();
        return Inertia::render('InvoiceListPage', ['list' => $list]);
    }

    public function InvoiceList(){
        $user_id = request()->header('id');
        $invoices = Invoice::with('customer')->where('user_id', $user_id)->get();
        return $invoices;
    }//end method

    public function InvoiceDetails(Request $request){
        $user_id = request()->header('id');

        $customerDetails = Customer::where('user_id', $user_id)->where('id', $request->customer_id)->first();

        $invoiceDetails = Invoice::where('user_id', $user_id)->where('id', $request->invoice_id)->first();
        $invoiceProduct = InvoiceProduct::where('invoice_id', $request->invoice_id)
            ->where('user_id',$user_id)->with('product')
            ->get();

        return [
            'customer' => $customerDetails,
            'invoice' => $invoiceDetails,
            'product' => $invoiceProduct
        ];
    }//end method

    public function InvoiceDelete(Request $request, $id){
        DB::beginTransaction();
        try {
            $user_id = request()->header('id');
            InvoiceProduct::where('invoice_id', $id)
                ->where('user_id', $user_id)
                ->delete();

            Invoice::where('id', $id)
                ->where('user_id', $user_id)
                ->delete();

            DB::commit();
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Invoice deleted successfully'
            // ]);
            $data = ['message'=>'Invoice deleted successfully','status'=>true,'error'=>''];
            return redirect()->back()->with($data);
        }catch(Exception $e){
            DB::rollBack();
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => "Something went wrong"
            // ]);
            $data = ['message'=>'Something went wrong','status'=>false,'error'=>$e->getMessage()];
            return redirect()->back()->with($data);
        }
    }
}
