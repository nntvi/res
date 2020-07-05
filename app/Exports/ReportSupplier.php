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

    public function getResultImports($dateStart,$dateEnd, $idSupplier)
    {
        if($idSupplier == 0){
            $resultImports = ImportCoupon::whereBetween('created_at',[$dateStart,$dateEnd])->orderBy('id_supplier','asc')->with('supplier')->get();
        }else{
            $resultImports = ImportCoupon::whereBetween('created_at',[$dateStart,$dateEnd])->where('id_supplier',$idSupplier)
                                            ->orderBy('id_supplier','asc')->with('supplier')->get();
        }
        return $resultImports;
    }

    public function getPaidByIdCoupon($dateStart,$dateEnd,$idImportCoupon)
    {
        $paid = ImportCoupon::whereBetween('updated_at',[$dateStart,$dateEnd])->where('id',$idImportCoupon)->value('paid');
        if($paid == null){
            return 0;
        }else{
            return $paid;
        }
    }

    public function createArrayReportSupplier($dateStart,$dateEnd,$imports)
    {
        $data = array();
        if(empty($imports)){
            return $data;
        }else{
            foreach ($imports as $key => $import) {
                $temp = [
                    'STT' => $key + 1,
                    'code' => $import->code,
                    'name' => $import->supplier->name,
                    'total' => $import->total,
                    'paid' => $this->getPaidByIdCoupon($dateStart,$dateEnd,$import->id),
                    'unpaid' => $import->total - $this->getPaidByIdCoupon($dateStart,$dateEnd,$import->id),
                    'status' => $import->status,
                    'created_at' => $import->created_at,
                    'created_by' => $import->created_by,
                ];
                array_push($data,$temp);
                unset($temp);
            }
            return $data;
        }

    }

    public function getTotal()
    {
        $imports = $this->getResultImports($this->dateStart,$this->dateEnd,$this->idSupplier);
        $results = $this->createArrayReportSupplier($this->dateStart,$this->dateEnd,$imports);
        $total = 0; $paid = 0; $unPaid = 0;
        foreach ($results as $key => $result) {
            $total += $result['total'];
            $paid += $result['paid'];
        }
        $unPaid = $total - $paid;
        $temp = [
            'total' => $total,
            'paid' => $paid,
            'unPaid' => $unPaid
        ];
        $footerTotalSupplier = array();
        array_push($footerTotalSupplier,$temp);
        return $footerTotalSupplier;
    }
    public function collection()
    {
        $imports = $this->getResultImports($this->dateStart,$this->dateEnd,$this->idSupplier);
        $results = $this->createArrayReportSupplier($this->dateStart,$this->dateEnd,$imports);
        foreach ($results as $key => $result) {
            $row[] = array(
                '0' => $result['STT'],
                '1' =>$result['code'],
                '2' => $result['created_by'],
                '3' => $result['name'],
                '5' => $result['total'],
                '6' => $result['paid'] == 0 ? '0' : $result['paid'],
                '7' => $result['unpaid'] == 0 ? '0' : $result['unpaid'],
                '8' => $result['created_at']
            );
        }
        return collect($row);
    }

    public function headings() : array
    {
        $footer = $this->getTotal();
        return [
            ['Báo cáo nợ/trả Nhà Cung cấp'],
            ['Từ',$this->dateStart],
            ['Đến',$this->dateEnd],
            ['NCC: ',$this->idSupplier == '0' ? 'Tất cả' : $this->getNameSupplier($this->idSupplier)],
            ['Tổng tiền',$footer[0]['total']],
            ['Đã trả',$footer[0]['paid']],
            ['Còn nợ',$footer[0]['unPaid']],
            [],
            [
                'STT',
                'Mã phiếu nhập',
                'Người tạo',
                'Nhà cung cấp',
                'Tổng tiền',
                'Đã trả',
                'Còn nợ',
                'Ngày lập phiếu',
            ],
        ];
    }
}
