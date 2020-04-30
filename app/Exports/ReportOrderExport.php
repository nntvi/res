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

    public function collection()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $orders = Order::whereBetween('updated_at',[$this->dateStart . $s ,$this->dateEnd . $e])
                        ->with('table.getArea','user','shift')->get();
        foreach ($orders as $key => $order) {
            $row[] = array(
                '0' => $key + 1,
                '1' => $order->table->getArea->name,
                '2' => $order->table->name,
                '3' => $order->total_price,
                '4' => $order->receive_cash,
                '5' => $order->excess_cash,
                '6' => $order->user->name,
                '7' => $order->shift->name,
                '8' => $order->updated_at,
                '9' => $order->status == "0" ? "Đã thanh toán" : "Chưa thanh toán",
            );
        }
        return collect($row);
    }

    public function headings() : array
    {
        return [
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
        ];
    }

}
