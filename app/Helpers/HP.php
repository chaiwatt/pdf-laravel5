<?php

namespace App\Helpers;

class HP
{
    public static function toThaiNumber($number)
    {
        $numthai = array("๑", "๒", "๓", "๔", "๕", "๖", "๗", "๘", "๙", "๐");
        $numarabic = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $str = str_replace($numarabic, $numthai, $number);
        return $str;
    }

    public static function formatDateThaiFullPoint($strDate)
    {
        if(is_null($strDate) || $strDate == '' || $strDate == '-' ){
            return '-';
        }
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("m", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $month = ['01'=>'มกราคม', '02'=>'กุมภาพันธ์', '03'=>'มีนาคม', '04'=>'เมษายน', '05'=>'พฤษภาคม', '06'=>'มิถุนายน', '07'=>'กรกฎาคม', '08'=>'สิงหาคม', '09'=>'กันยายน', '10'=>'ตุลาคม', '11'=>'พฤศจิกายน', '12'=>'ธันวาคม'];
        $strMonthThai = $month[$strMonth];
        return "$strDay $strMonthThai พ.ศ.  $strYear";
    }
}
