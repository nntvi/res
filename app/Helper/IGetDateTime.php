<?php
namespace App\Helper;

interface IGetDateTime{
    function getYesterday();
    function getNow();
    function getFirstOfYear();
    function getLastOfYear();
    function getFirstOfJan();
    function getEndOfJan();
    function getFirstOfFreb();
    function getEndOfFreb();
    function getFirstOfMar();
    function getEndOfMar();
    function getFirstOfApr();
    function getEndOfApr();
    function getFirstOfMay();
    function getEndOfMay();
    function getFirstOfJun();
    function getEndOfJun();
    function getFirstOfJul();
    function getEndOfJul();
    function getFirstOfAug();
    function getEndOfAug();
    function getFirstOfSep();
    function getEndOfSep();
    function getFirstOfOct();
    function getEndOfOct();
    function getFirstOfNov();
    function getEndOfNov();
    function getFirstOfDec();
    function getEndOfDec();
    function getStartOfWeek();
    function getEndOfWeek();
    function getStartOfPreWeek();
    function getEndOfPreWeek();
    function getStartOfMonth();
    function getEndOfMonth();
    function getStartOfPreMonth();
    function getEndOfPreMonth();
    function getStartOfQuarter();
    function getEndOfQuarter();
    function getStartOfPreQuarter();
    function getEndOfPreQuarter();
}
