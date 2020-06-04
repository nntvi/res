<?php

namespace App\Exports;

use App\Supplier;
use App\ImportCoupon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportSupplier implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct(string $dateStart, string $dateEnd, int $idSupplier)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->idSupplier = $idSupplier;
    }
    public function getNameSupplier($idSupplier)
    {
        $name = Supplier::where('id',$idSupplier)->value('name');
        return $name;
    }
    public function getAllSupplier()
    {
        $results = ImportCoupon::whereBetween('created_at',[$this->dateStart,$this->dateEnd])->with('supplier')->get();
        return $results;
    }

    public function getSupplierById($idSupplier)
    {
        $results = ImportCoupon::whereBetween('created_at',[$this->dateStart,$this->dateEnd])->where('id_supplier',$idSupplier)
                                    ->with('supplier')->get();
        return $results;
    }
    public function getStatusImportCoupon($status)
    {
        switch ($status) {
            case '0':
                return 'Chưa thanh toán';
                break;
            case '1':
                return 'Còn nợ';
                break;
            default:
                return 'Đã thanh toán';
                break;
        }
    }

    public function createResultByTimeAndIdSupplier()
    {
        if($this->idSupplier == '0'){
            $results = $this->getAllSupplier();
        }else{
            $results = $this->getSupplierById($this->idSupplier);
        }
        return $results;
    }

    public function collection()
    {
        $results = $this->createResultByTimeAndIdSupplier();
        foreach ($results as $key => $result) {
            $row[] = array(
                '0' => $key + 1,
                '1' => $result->code,
                '2' => $result->created_by,
                '3' => $result->supplier->name,
                '4' => $this->getStatusImportCoupon($result->status),
                '5' => $result->total,
                '6' => $result->paid == 0 ? '0' : $result->paid,
                '7' => ($result->total - $result->paid) == 0 ? '0' : ($result->total - $result->paid),
                '8' => $result->created_at
            );
        }
        return collect($row);
    }

    public function headings() : array
    {
        return [
            ['Báo cáo nợ/trả Nhà Cung cấp'],
            ['Từ',$this->dateStart],
            ['Đến',$this->dateEnd],
            ['NCC: ',$this->idSupplier == '0' ? 'Tất cả' : $this->getNameSupplier($this->idSupplier)],
            [],
            [
                'STT',
                'Mã phiếu nhập',
                'Người tạo',
                'Nhà cung cấp',
                'Trạng thái',
                'Tổng tiền',
                'Đã trả',
                'Còn nợ',
                'Ngày lập phiếu',
            ],
        ];
    }
}
