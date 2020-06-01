<?php
namespace App\Repositories\VoucherRepository;

use App\Http\Controllers\Controller;

class VoucherRepository extends Controller implements IVoucherRepository{

    public function showIndex()
    {
        return view('voucher.index');
    }


}
