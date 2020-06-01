<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportTableExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct(string $dateStart, $dateEnd,$status)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->status = $status;
    }

    public function getDish($item)
    {
        $s = "";
        $data = array();
        foreach ($item->orderDetail as $key => $detail) {
            array_push($data,$detail->dish->name);
        }
        $s = implode(", ",$data);
        return $s;
    }
    public function collection()
    {
        $s = " 00:00:00";
        $e = " 23:59:59";
        $results = Order::whereBetween('updated_at',[$this->dateStart . $s ,$this->dateEnd . $e])
                        ->where('status',  $this->status)
                        ->with('table.getArea','orderDetail.dish')->get();
        foreach ($results as $key => $item) {
            $this->getDish($item);
            $row[] = array(
                '0' => $key + 1,
                '1' => $item->table->getArea->name,
                '2' => $item->table->name,
                '3' => $this->getDish($item),
                '4' => $item->created_at,
                '5' => $item->updated_at,
                '6' => $item->status == '0' ? 'Đã thanh toán' : 'Chưa thanh toán'
            );
        }
        return collect($row);
    }

    public function headings() : array
    {
        return [
            ['Báo cáo theo bàn'],
            ['Từ', $this->dateStart],
            ['Đến', $this->dateEnd],
            [],
            [
                'STT',
                'Khu vực',
                'Bàn',
                'Những món đã gọi',
                'Thời gian vào',
                'Thời gian ra',
                'Trạng thái',
            ],
        ];
    }
}
