<?php

namespace App\Console;

use App\Console\Commands\UpdateStatusMaterialWhCook;
use Pusher\Pusher;
use App\WarehouseCook;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('status:update')
                 ->everyMinute();
        // $schedule->call(function () {
        //     $count = WarehouseCook::selectRaw('count(status) as qty')->where('status','0')->value('qty');
        //     if($count != 0){
        //         $data['cook'] = $count;
        //         $options = array(
        //             'cluster' => 'ap1',
        //             'useTLS' => true
        //         );
        //         $pusher = new Pusher(
        //             'cc6422348edc9fbaff00',
        //             '54d59c765665f5bc6194',
        //             '994181',
        //             $options
        //         );
        //         $pusher->trigger('NotifyOutOfStock', 'need-import-cook', $data);
        //     }
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
