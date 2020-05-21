<?php

namespace App\Console\Commands;

use App\Area;
use Pusher\Pusher;
use App\WarehouseCook;
use Illuminate\Console\Command;

class UpdateStatusMaterialWhCook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = WarehouseCook::selectRaw('count(status) as qty')->where('status','0')->value('qty');
            $data['cook'] = $count;
            $options = array(
                'cluster' => 'ap1',
                'useTLS' => true
            );
            $pusher = new Pusher(
                'cc6422348edc9fbaff00',
                '54d59c765665f5bc6194',
                '994181',
                $options
            );
            $pusher->trigger('NotifyOutOfStock', 'need-import-cook', $data);
    }
}
