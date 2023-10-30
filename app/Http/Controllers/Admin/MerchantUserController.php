<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MerchantUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display All Merchant List in Admin
    */
    public function index(): View
    {
        return \view('webend.ecommerce.users.merchant.index');
    }
    /**
     * Datatable of Merchants List
    */
    public function datatable()
    {
        $merchants = DB::table('merchants')->latest()->get();

        return DataTables::of($merchants)->addIndexColumn()
            ->addColumn('avatar', function ($merchant){
                return (!is_null($merchant->avatar)) ?  '<img src="'.asset('uploads/merchant/resize/').'/'.$merchant->avatar.'" alt="'.$merchant->name.'" />'
                    :
                    '<img src="'.asset(default_image()).'" alt="'.$merchant->name.'" />'
                    ;
            })
            ->addColumn('status', function ($merchant) {
                $statusOptions = [
                    1 => 'Active',
                    0 => 'Inactive',
                ];

                $statusSelect = '<select class="merchant-status form-control" style="background: #FFE5E5;
                                    padding: 7px;
                                    border: 1px solid transparent;
                                    border-radius: 10px;
                                    color: black;" data-id="' . $merchant->id . '">';

                foreach ($statusOptions as $value => $label) { // $value = array_key && $label = published or unpublished
                    $selected = $merchant->status == $value ? 'selected' : '';
                    $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                }
                $statusSelect .= '</select>';
                return $statusSelect;
            })
            ->addColumn('total_product', function ($merchant){
                return DB::table('products')->where('merchant_id', $merchant->id)->count();
            })
            ->rawColumns(['status', 'avatar', 'total_product'])->make(true);
    }
}
