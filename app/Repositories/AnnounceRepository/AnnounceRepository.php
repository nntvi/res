<?php
namespace App\Repositories\AnnounceRepository;

use App\Http\Controllers\Controller;
use App\WarehouseCook;

class AnnounceRepository extends Controller implements IAnnouceRepository{

    public function countEmptyWarehouseCook()
    {
        $count = WarehouseCook::where('status','0')->count();
        return $count;
    }
}
