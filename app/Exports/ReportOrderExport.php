<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportOrderExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;


    public function __construct(string $dateStart, string $dateEnd)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function getArea($areas)
    {
        $string = "";
        foreach ($areas as $key => $area) {
            $string = $area->status == '1' ? $area->table->getArea->name : $area->table->getArea->name . ' (đã xóa)';
            break;
        }
        return $string;
    }
    public function getTable($tables)
    {
        $string = "";
        $temp = 0;
        foreach ($tables as $key => $table) {
            $table->getArea->status != 0 ? $temp++ : $temp = 0 ;
            if(count($tables) == 1){
                $string = $table->table->name;
            }else{
                $string = $string .  $table->table->name . ', ';
            }
        }
        if($temp != 0){
            $string = $string . ' (đã xóa)';
        }
        return $string;
    }

    public function getOrderByTime()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $orders = Order::whereBetween('updated_at',[$this->dateStart . $s ,$this->dateEnd . $e])->with('tableOrdered.table.getArea','user','shift')->get();
        return $orders;
    }
    public function getTotal()
    {
        $orders = $this->getOrderByTime();
        $total = 0; $totalReceive = 0; $totalExcess = 0; $footerOrderReport = array();
        foreach ($orders as $key => $order) {
            $total += $order->total_price;
            $totalReceive += $order->receive_cash;
            $totalExcess += $order->excess_cash;
        }
        $temp = [
            'total' => $total,
            'totalReceive' => $totalReceive,
            'totalExcess' => $totalExcess
        ];
        array_push($footerOrderReport,$temp);
        return $footerOrderReport;
    }
    public function collection()
    {
        $orders = $this->getOrderByTime();
        foreach ($orders as $key => $order) {
            $row[] = array(
                '0' => $key + 1,
                '1' => $this->getArea($order->tableOrdered),
                '2' => $this->getTable($order->tableOrdered),
                '3' => $order->total_price,
                '4' => $order->receive_cash,
                '5' => $order->excess_cash,
                '6' => $order->payer,
                '7' => $order->shift->name,
                '8' => $order->updated_at,
                '9' => $order->status == "0" ? "Đã thanh toán" : "Chưa thanh toán",
            );
        }
        return collect($row);
    }

    public function headings() : array
    {
        $footer = $this->getTotal();
        return [
            ['Báo cáo hóa đơn'],
            ['Từ', $this->dateStart],
            ['Đến',$this->dateEnd],
            ['Tổng tiền',$footer[0]['total']],
            ['Tiền khách đưa',$footer[0]['totalReceive']],
            ['Tiền hoàn lại',$footer[0]['totalExcess']],
            [],
            [
                'STT',
                'Khu vực',
                'Bàn',
                'Tổng tiền',
                'Tiền khách đưa',
                'Tiền thừa',
                'Nhân viên',
                'Ca',
                'Thời gian thanh toán',
                'Trạng thái',
            ],

        ];
    }

}
