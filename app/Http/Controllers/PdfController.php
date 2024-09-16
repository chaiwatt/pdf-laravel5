<?php

namespace App\Http\Controllers;

use PDF;
use Mpdf\Mpdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfController extends Controller
{

    public function pdfCertificateMpdf()
    {
        $fontDirs = [public_path('fonts/')]; // เพิ่มไดเรกทอรีฟอนต์ที่คุณต้องการ
        $fontData = [
            'thsarabunnew' => [
                'R' => "THSarabunNew.ttf",
                'B' => "THSarabunNew-Bold.ttf",
                'I' => "THSarabunNew-Italic.ttf",
                'BI' => "THSarabunNew-BoldItalic.ttf",
            ],
        ];
// dd($fontDirs, $fontData);
        $type ='I';
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

        $url = 'https://www.google.com';

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

        // $data_export = json_decode(json_encode($data_export));
        $data_export = collect($data_export);
        $mpdf->SetDefaultBodyCSS('background', "url('images/certificate01.png')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
        $mpdf->AddPage('P');
        $html  = view('pdf/certificate', $data_export);
        $mpdf->WriteHTML($html);
        $height = 50;
        $width = 65;
        $image =    public_path('images/sign.jpg');
        $sign_path = $sign_path = '<img    src="'.$image.'"  height="'.$height.'px" width="'.$width.'px">';;
        $sign_name = "(นายวีระศักดิ์ เพ้งหล้ง)";
        $sign_position = "ผู้อำนวยการสำนักงานคณะกรรมการการมาตรฐานแห่งชาติ";
        $footer  = view('pdf/certificate-footer',[ 'image_qr'          => isset($image_qr) ? $image_qr : null,
                                                                     'url'               => isset($url) ? $url : null,
                                                                     'sign_path'         =>  $sign_path,
                                                                     'sign_name'         =>  $sign_name,
                                                                     'sign_position'     =>  $sign_position,
                                                                     'sign_instead'      =>  0
                                                                  ]);
        $mpdf->SetHTMLFooter($footer);    
        $title = "ใบรับรองห้องปฏิบัติการ".date('Ymd_hms').".pdf";  
        $mpdf->SetTitle($title);   
        $mpdf->Output($title, $type);                                                   
        dd($footer);
    }

    public function pdfCertificate()
    {
        $data_export = [
            'app_no'             => "This is app no",

             'name'              => 'แลปไก่ต้ม',
            'name_en'            =>  'Kaitom Lab',
            // 'lab_name_font_size' => $this->CalFontSize($request->lab_name),
            // 'certificate'        => $request->certificate,
            // 'lab_name'           =>  $request->lab_name ?? null,
            // 'address'            => $this->FormatAddress($request),
            // 'address_en'         => $this->FormatAddressEn($request),
            // 'lab_name_font_size_address' => $this->CalFontSize($this->FormatAddress($request)),
            // 'formula'            =>  isset($request->formula) ?   $request->formula : '&emsp;',
            // 'formula_en'         =>  isset($request->formula_en) ?   $request->formula_en : '',
            // 'accereditatio_no'   => $request->accereditatio_no,
            // 'accereditatio_no_en'=>  isset($request->accereditatio_no_en) ?   $request->accereditatio_no_en : '',
            // 'date_start'         => $req_date_start,
            // 'date_end'           => $req_date_end,
            // 'date_start_en'      => !empty($req_date_start) ? HP::formatDateENertify($req_date_start) : '' ,
            // 'date_end_en'        => !empty($request->certificate_date_end) ? HP::formatDateENFull($request->certificate_date_end) : null ,
            // 'image_qr'           => isset($image_qr) ? $image_qr : null,
            // 'url'                => isset($url) ? $url : null,
            // 'attach_pdf'         => isset($certi_lab->attach_pdf) ? $certi_lab->attach_pdf : null,
            // 'laboratory'         => $certi_lab->LabTypeTitle ?? null,
            // 'condition_th'       => !empty($formula->condition_th ) ? $formula->condition_th  : null ,
            // 'condition_en'       => !empty($formula->condition_en ) ? $formula->condition_en  : null,
            // 'lab_name_font_size_condition' => !empty($formula->condition_th) ? $this->CalFontSizeCondition($formula->condition_th)  : '11'
           ];

        $pdf = PDF::loadView('pdf.certificate', $data_export);
        return $pdf->stream("scope-thai.pdf");
    }

    //คำนวนขนาดฟอนต์ของชื่อหน่วยงานผู้ได้รับรอง
    public function CalFontSize($certificate_for){

            $alphas = array_combine(range('A', 'Z'), range('a', 'z'));
            $thais = array('ก','ข', 'ฃ', 'ค', 'ฅ', 'ฆ','ง','จ','ฉ','ช','ซ','ฌ','ญ', 'ฎ', 'ฏ', 'ฐ','ฑ','ฒ'
    ,'ณ','ด','ต','ถ','ท','ธ','น','บ','ป','ผ','ฝ','พ','ฟ','ภ','ม','ย','ร','ล'
    ,'ว','ศ','ษ','ส','ห','ฬ','อ','ฮ', 'ำ', 'า', 'แ');
    
            if(function_exists('mb_str_split')){
              $chars = mb_str_split($certificate_for);
            }else if(function_exists('preg_split')){
              $chars = preg_split('/(?<!^)(?!$)/u', $certificate_for);
            }
    
            $i = 0;
            foreach ($chars as $char) {
                if(in_array($char, $alphas) || in_array($char, $thais)){
                    $i++;
                }
            }
    
            if($i>40){
                $font = 15;
            }else{
                $font = 18;
            }
    
            return $font;
    
        }
}
