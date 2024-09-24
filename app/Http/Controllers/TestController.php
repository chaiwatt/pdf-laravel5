<?php

namespace App\Http\Controllers;

use App\TisiCb;
use App\TisiIb;
use App\TisiLab;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function pmt1()
    {
        return 'found';
    }

    public function api()
    {
        $url = 'http://127.0.0.1:8082/pmt1';
    $context = stream_context_create([
        'http' => [
            'timeout' => 120, // กำหนดเวลา timeout เป็น 120 วินาที
        ]
    ]);
    $response = file_get_contents($url, false, $context);
    dd($response);
    }

    public function lab()
    {
        $tisiLabs = TisiLab::find(7)->ssoUser;
        dd($tisiLabs);
    }

    public function splitText()
    {
        require_once (base_path('/vendor/notyes/thsplitlib/THSplitLib/segment.php'));
        $segment = new \Segment(); 
        $body = 'หาดทรายละเอียดสีขาว ตัดกับท้องฟ้าและน้ำทะเลสีครามใส คือบรรยากาศของท้องทะเลไทยในช่วงของการแพร่ระบาดไวรัสโควิด-19 ส่งผลให้ประเทศไทยมีการประกาศพ.ร.ก.ฉุกเฉินและปิดบริการสถานที่ท่องเที่ยวทางธรรมชาติทั่วประเทศเสมือนกำลังสร้างความสมดุลของ ระบบนิเวศให้กลับคืนสู่ธรรมชาติอีกครั้ง'; 
        $words = $segment->get_segment_array($body); 
        $text = implode("|",$words);
        dd($text);
    }

    public static function FixBreak($text){
        require_once (base_path('/vendor/notyes/thsplitlib/THSplitLib/segment.php'));
        $segment = new \Segment();
        return $segment->get_segment_array($text);
    } 
}
