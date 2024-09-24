<?php

namespace App\Helpers;

use Segment;

class TextHelper
{
    // public static function splitText($text)
    // {
    //     require_once (base_path('/vendor/notyes/thsplitlib/THSplitLib/segment.php'));
    //     $segment = new \Segment();   
    //     $text = str_replace(' ', '<>', $text);
    //     $text = str_replace('/', '+=', $text);
    //     $words = $segment->get_segment_array($text); 
        
    //     $out = implode("|",$words);
    //     $out = str_replace('<>', ' ', $out);
    //     $out = str_replace('+=', '/', $out);
    //     return $out;
    // }

    public static function splitText($text)
    {
        require_once(base_path('/vendor/notyes/thsplitlib/THSplitLib/segment.php'));
        $segment = new \Segment();   
        $text = str_replace(' ', '<>', $text);
        $text = str_replace('/', '+=', $text);
        $words = $segment->get_segment_array($text);
    
        // ห่อแต่ละคำด้วย <nobr> เพื่อป้องกันการตัดคำ
        $wrappedWords = array_map(function($word) {
            return "<nobr>{$word}</nobr>";
        }, $words);
    
        // รวมคำคั่นด้วยเครื่องหมายที่ต้องการ เช่น |
        $out = implode("|", $wrappedWords);
        $out = str_replace('<>', ' ', $out);
        $out = str_replace('+=', '/', $out);
        return $out;
    }
    

}
