<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function CreateCustomer(Request $request){
        $user_id = $request->header('id');

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'mobile' => 'required',
        ]);

        Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'user_id' => $user_id
        ]);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Customer created successfully'
        // ]);
        $data = ['message'=>'Customer created successfully','status'=>true,'error'=>''];
        return redirect('/CustomerPage')->with($data);
    }//end method

    public function CustomerPage(Request $request){
        $user_id = $request->header('id');
        $customers = Customer::where('user_id', $user_id)->get();
        return Inertia::render('CustomerPage', ['customers' => $customers]);
    }

    public function CustomerSavePage(Request $request){
        $user_id=$request->header('id');
        $id=$request->query('id');
        $customer=Customer::where('id',$id)->where('user_id',$user_id)->first();
        return Inertia::render('CustomerSavePage',['customer'=>$customer]);
    }

    public function CustomerList(Request $request){
        $user_id = $request->header('id');
        $customers = Customer::where('user_id', $user_id)->get();
        return $customers;
    }//end method

    public function CustomerById(Request $request){
        $user_id = $request->header('id');
        $customer =Customer::where('id', $request->id)->where('user_id', $user_id)->first();
        return $customer;
    }//end method

    public function CustomerUpdate(Request $request){
        $user_id = $request->header('id');
        $id = $request->input('id');
        Customer::where('id', $id)->where('user_id', $user_id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
        ]);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Customer Updaetd successfully'
        // ]);
        $data = ['message'=>'Customer updated successfully','status'=>true,'error'=>''];
        return redirect('/CustomerPage')->with($data);
    }//end method

    public function CustomerDelete(Request $request,$id){
        $user_id = $request->header('id');
        Customer::where('user_id', $user_id)->where('id', $id)->delete();
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Customer Deleted successfully'
        // ]);
        $data = ['message'=>'Customer Deleted successfully','status'=>true,'error'=>''];
        return redirect('/CustomerPage')->with($data);
    }//end method
}
