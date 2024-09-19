<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Illuminate\Http\Request;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Bis50Controller extends Controller
{
    public function createBis50_()
    {
        $type = 'I';
        $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
        $fontData = [
            'thsarabunnew' => [
                'R' => "thsarabunnew.ttf",
                'B' => "thsarabunnew-Bold.ttf",
                'I' => "thsarabunnew-Italic.ttf",
                'BI' => "thsarabunnew-BoldItalic.ttf",
            ],
        ];

        $mpdf = new Mpdf([
            'PDFA' 	=>  $type == 'F' ? true : false,
            'PDFAauto'	 =>  $type == 'F' ? true : false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => '15',
            'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
        ]);         

        if($type == 'I'){
            $mpdf->SetWatermarkText("DRAFT");
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->showWatermarkText = true;
            $mpdf->watermarkTextAlpha = 0.15;
        }

        $url = 'https://www.npcsolutionandservice.com';

        $image_qr = QrCode::format('png')
                   ->merge('images/tisi.png', 0.2, true)
                   ->size(500)
                   ->errorCorrection('H')
                   ->generate($url);

        // dd($image_qr);

        $data_export = [
            'certificate' => '67L:LAB0937',
            'app_no' => 'CAL-67-230',
            'names' => [
                [
                    'font' => 'font-16',
                    'title' => 'แลปไก่ต้ม',
                ],
            ],
            'names_en' => [
                [
                    'font' => 'font-10',
                    'title' => '(Kaitom Lab)',
                ],
            ],
            'address_ths' => [
                [
                    'font' => 'font-16',
                    'title' => '105 หมู่ที่ 8 ตำบลเหมืองง่า อำเภอเมืองลำพูน จังหวัดลำพูน',
                ],
            ],
            'address_ens' => '(11 Moo, Samphaniang, Ban Phraek, Phra Nakhon Si Ayutthaya)',
            'formula' => 'มอก. 17025 - 2561',
            'formula_en' => 'TIS 17025-2561 (2018) (IS0/IEC 17025: 2017)',
            'condition_th' => [
                [
                    'font' => 'font-16',
                    'title' => 'ข้อกำหนดทั่วไปว่าด้วยความสามารถของ ห้องปฏิบัติการทดสอบและห้องปฏิบัติการสอบเทียบ',
                ],
            ],
            'condition_en' => '(General requirements for the competence of testing and calibration laboratories)',
            'accereditatio_no' => 'LAB-230-046-2567',
            'accereditatio_no_en' => 'fsdf',
            'date_start' => '2024-09-11',
            'date_start_en' => '11 September B.E. 2567 (2024)',
        ];

        $data_export = collect($data_export);
        $mpdf->SetDefaultBodyCSS('background', "url('images/certificate01.png')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
        $mpdf->AddPage('P');
        $html  = view('pdf/rd2', $data_export);
        $mpdf->WriteHTML($html);
        $height = 50;
        $width = 65;
        $image =    public_path('images/sign.jpg');
        $sign_path = '<img    src="'.$image.'"  height="'.$height.'px" width="'.$width.'px">';


        $signer = collect([
            'sign_name' => 'นายวีระศักดิ์ เพ้งหล้ง',
            'sign_position' => 'ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ',
            'sign_id' => '167',
            'sign_path' => '<img    src="'.$image.'"  height="'.$height.'px" width="'.$width.'px">',
            'certificate_type' => 3,
            'state' => 3,
        ]);

        $sign_name = $signer['sign_name'];
        $sign_path = $signer['sign_path'];
        $sign_position = $signer['sign_position'];
        $footer  = view('pdf/certificate-footer-mpdf',[ 
                            'image_qr' => $image_qr ,
                            'url' => $url,
                            'sign_path' =>  $sign_path,
                            'sign_name' =>  $sign_name,
                            'sign_position' =>  $sign_position,
                            'sign_instead' =>  0
                        ]);
        $mpdf->SetHTMLFooter($footer);    
        $title = "ใบรับรองห้องปฏิบัติการ".date('Ymd_hms').".pdf";  
        $mpdf->SetTitle($title);  
        
        $mpdf->Output($title, "F"); 
    }

    public function createBis50()
    {

        $type = 'I';
        $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
        $fontData = [
            'thsarabunnew' => [
                'R' => "thsarabunnew.ttf",
                'B' => "thsarabunnew-Bold.ttf",
                'I' => "thsarabunnew-Italic.ttf",
                'BI' => "thsarabunnew-BoldItalic.ttf",
            ],
        ];

        $mpdf = new Mpdf([
            'PDFA' 	=>  $type == 'F' ? true : false,
            'PDFAauto'	 =>  $type == 'F' ? true : false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => '15',
            'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
            'margin_left'      => 5, // ระบุขอบด้านซ้าย
            'margin_right'     => 3, // ระบุขอบด้านขวา
            'margin_top'       => 0, // ระบุขอบด้านบน
            'margin_bottom'    => 5, // ระบุขอบด้านล่าง
        ]);         

        // if($type == 'I'){
        //     $mpdf->SetWatermarkText("DRAFT");
        //     $mpdf->watermark_font = 'DejaVuSansCondensed';
        //     $mpdf->showWatermarkText = true;
        //     $mpdf->watermarkTextAlpha = 0.15;
        // }

        $data_export = [];

        $mpdf->AddPage('P');
        
        $html  = view('pdf/rd2', $data_export)->render();
        // $stylesheet = file_get_contents(public_path('css/report/report-4.css'));
        // $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($html,2);
   
        $title = "rd2.pdf";  
        // $mpdf->SetTitle($title);  
      
        $mpdf->Output($title, $type);  
        
                                                        
    }

    public function notificationNote()
    {
        $type = 'I';
        $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
        $fontData = [
            'thsarabunnew' => [
                'R' => "THSarabunNew.ttf",
                'B' => "THSarabunNew-Bold.ttf",
                'I' => "THSarabunNew-Italic.ttf",
                'BI' => "THSarabunNew-BoldItalic.ttf",
            ],
        ];

        $mpdf = new Mpdf([
            'PDFA' 	=>  $type == 'F' ? true : false,
            'PDFAauto'	 =>  $type == 'F' ? true : false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => '15',
            'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
            'margin_left'      => 10, // ระบุขอบด้านซ้าย
            'margin_right'     => 3, // ระบุขอบด้านขวา
            'margin_top'       => 15, // ระบุขอบด้านบน
            'margin_bottom'    => 10, // ระบุขอบด้านล่าง
        ]);         


        $mpdf->AddPage('P');
        $html  = view('pdf/notification-note', []);
        $mpdf->WriteHTML($html);

        $title = "scope";
      
        $mpdf->Output($title, $type);  
                                                  
    }

    public function scope()
    {
        $type = 'I';
        $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
        $fontData = [
            'thsarabunnew' => [
                'R' => "THSarabunNew.ttf",
                'B' => "THSarabunNew-Bold.ttf",
                'I' => "THSarabunNew-Italic.ttf",
                'BI' => "THSarabunNew-BoldItalic.ttf",
            ],
        ];

        $mpdf = new Mpdf([
            'PDFA' 	=>  $type == 'F' ? true : false,
            'PDFAauto'	 =>  $type == 'F' ? true : false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => '15',
            'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
            'margin_left'      => 8, // ระบุขอบด้านซ้าย
            'margin_right'     => 8, // ระบุขอบด้านขวา
            'margin_top'       => 97, // ระบุขอบด้านบน
            'margin_bottom'    => 30, // ระบุขอบด้านล่าง
        ]);         


        $header = view('pdf.scope-header', []);
        $body = view('pdf.scope', []);
        $footer = view('pdf.scope-footer', []);


        $stylesheet = file_get_contents(public_path('css/report/lab-scope.css'));
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->SetHTMLHeader($header,2);
        $mpdf->SetHTMLFooter($footer,2);
        $mpdf->WriteHTML($body,2);

        $currentY = $mpdf->y;

        $pages = $mpdf->page;

        $title = "scope.pdf";
        $mpdf->Output($title, $type);  
                                                  
    }

    function createCalLabScope()
    {
        $type = 'I';
        $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
        $fontData = [
            'thsarabunnew' => [
                'R' => "THSarabunNew.ttf",
                'B' => "THSarabunNew-Bold.ttf",
                'I' => "THSarabunNew-Italic.ttf",
                'BI' => "THSarabunNew-BoldItalic.ttf",
            ],
        ];

        $mpdf = new Mpdf([
            'PDFA' 	=>  $type == 'F' ? true : false,
            'PDFAauto'	 =>  $type == 'F' ? true : false,
            'format'            => 'A4',
            'mode'              => 'utf-8',
            'default_font_size' => '15',
            'fontDir'          => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], $fontDirs),
            'fontdata'         => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], $fontData),
            'default_font'     => 'thsarabunnew', // ใช้ฟอนต์ที่กำหนดเป็นค่าเริ่มต้น
            'margin_left'      => 7, // ระบุขอบด้านซ้าย
            'margin_right'     => 5, // ระบุขอบด้านขวา
            'margin_top'       => 45, // ระบุขอบด้านบน
            'margin_bottom'    => 30, // ระบุขอบด้านล่าง
        ]);  


    
        // Load header
        $header = view('pdf.scope.header')->render();
        $mpdf->SetHTMLHeader($header);

        // Load footer
        $footer = view('pdf.scope.footer')->render();
        $mpdf->SetHTMLFooter($footer);

        // Load body and write content
        $body = view('pdf.scope.body')->render();
        $mpdf->WriteHTML($body);


        $currentY = $mpdf->y;
        // dd($currentY);

        
        
      
        $mpdf->Output();
    }
}
