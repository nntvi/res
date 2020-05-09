<?php
namespace App\Helper;

use Carbon\Carbon;
use App\Helper\IGetDateTime;

class GetDateTime implements IGetDateTime{

    public function getNow()
    {
        return Carbon::now('Asia/Ho_Chi_Minh');
    }
    public function getFirstOfYear()
    {
        return Carbon::now('Asia/Ho_Chi_Minh')->firstOfYear();
    }
    public function getLastOfYear()
    {
        return Carbon::now('Asia/Ho_Chi_Minh')->lastOfYear();
    }
    public function getFirstOfJan()
    {
        return $this->getFirstOfYear()->format('Y-m-d');
    }
    public function getEndOfJan()
    {
        return $this->getFirstOfYear()->endOfMonth()->format('Y-m-d');
    }
    public function getFirstOfFreb()
    {
        return $this->getFirstOfYear()->addMonth(1)->format('Y-m-d');
    }
    public function getEndOfFreb()
    {
        return $this->getfirstOfYear()->addMonth(1)->endOfMonth()->format('Y-m-d');
    }
    public function getFirstOfMar()
    {
        return $this->getfirstOfYear()->addMonth(2)->format('Y-m-d');
    }
    public function getEndOfMar()
    {
        return $this->getfirstOfYear()->addMonth(2)->endOfMonth()->format('Y-m-d');
    }
    public function getFirstOfApr()
    {
        return $this->getfirstOfYear()->addMonth(3)->format('Y-m-d');
    }
    public function getEndOfApr()
    {
        return $this->getfirstOfYear()->addMonth(3)->endOfMonth()->format('Y-m-d');
    }
    public function getFirstOfMay()
    {
        return $this->getfirstOfYear()->addMonth(4)->format('Y-m-d');
    }
    public function getEndOfMay()
    {
        return $this->getFirstOfYear()->addMonth(4)->endOfMonth()->format('Y-m-d');
    }
    public function getFirstOfJun()
    {
        return $this->getFirstOfYear()->addMonth(5)->format('Y-m-d');
    }
    public function getEndOfJun()
    {
        return $this->getFirstOfYear()->addMonth(5)->endOfMonth()->format('Y-m-d');
    }
    public function getFirstOfJul()
    {
        return $this->getFirstOfYear()->addMonth(6)->format('Y-m-d');
    }
    public function getEndOfJul()
    {
        return $this->getFirstOfYear()->addMonth(6)->endOfMonth()->format('Y-m');
    }
    public function getFirstOfAug()
    {
        return $this->getFirstOfYear()->addMonth(7)->format('Y-m-d');
    }
    public function getEndOfAug()
    {
        return $this->getFirstOfYear()->addMonth(7)->format('Y-m-d');
    }
    public function getFirstOfSep()
    {
        return $this->getFirstOfYear()->addMonth(8)->format('Y-m-d');
    }
    public function getEndOfSep()
    {
        return $this->getFirstOfYear()->addMonth(8)->endOfMonth()->format('Y-m-d');
    }
    public function getFirstOfOct()
    {
        return $this->getFirstOfYear()->addMonth(9)->format('Y-m-d');
    }
    public function getEndOfOct()
    {
        return $this->getFirstOfYear()->addMonth(9)->endOfMonth()->format('Y-m-d');
    }
    public function getFirstOfNov()
    {
        return $this->getFirstOfYear()->addMonth(10)->format('Y-m-d');
    }
    public function getEndOfNov()
    {
        return $this->getFirstOfYear()->addMonth(10)->endOfMonth()->format('Y-m-d');
    }
    public function getFirstOfDec()
    {
        return $this->getLastOfYear()->format('Y-m-d');
    }
    public function getEndOfDec()
    {
        return $this->getLastOfYear()->endOfMonth()->format('Y-m-d');
    }

}
