<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Helpers\HP;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Style\Paragraph;

class LabReportController extends Controller
{
    public function labreport()
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
            'margin_left'      => 12, // ระบุขอบด้านซ้าย
            'margin_right'     => 15, // ระบุขอบด้านขวา
            'margin_top'       => 15, // ระบุขอบด้านบน
            'margin_bottom'    => 30, // ระบุขอบด้านล่าง
        ]);         

        $mpdf->useDictionaryLBR = false;
        $body = view('pdf.labreport.report', []);
        $footer = view('pdf.labreport.report-footer', []);

        $stylesheet = file_get_contents(public_path('css/report/lab-report.css'));
        $mpdf->WriteHTML($stylesheet, 1);
        
        $mpdf->WriteHTML($body,2);

        $mpdf->SetHTMLFooter($footer,2);

        $title = "labreport.pdf";
        
        $mpdf->Output($title, $type);  
                                                    
    }

    public function rawLabreport()
    {
        return view('pdf.labreport.raw-report');
    }

    public function genWord()
    {
        $wordtemplate = new TemplateProcessor(public_path('assets/template.docx'));
        $wordtemplate->setValue('headercode',HP::toThaiNumber("12345"));
        $wordtemplate->setValue('_day',HP::toThaiNumber("15"));
        $wordtemplate->setValue('_month',"ตุลาคม");
        $wordtemplate->setValue('_year',HP::toThaiNumber("2567"));
        $wordtemplate->setValue('respname',"กาญจนา");
        $wordtemplate->setValue('resplastname',"ทวีจันทร์");
        $wordtemplate->setValue('company',"บริษัท เอ็นพีซีโซลูชั่นแอนด์เซอร์วิส จำกัด");
        $wordtemplate->setValue('projectno',HP::toThaiNumber("254"));
        $wordtemplate->setValue('projectname',"การรับรองห้องปฏิบัติการไก่ต้ม");
        $wordtemplate->setValue('score',HP::toThaiNumber(number_format(80, 2, '.', '')));
        $wordtemplate->setValue('grade',"A");
        $wordtemplate->setValue('management',strip_tags(str_replace('&nbsp;', "", "ร้องไห้ราวกับกำลังแตกสลายไปเลยก็ได้ แต่ทุกครั้งที่ระบายอารมณ์และพักจนพอใจแล้ว อย่าลืมว่าเราสามารถหยิบชิ้นส่วนที่กระจัดกระจายอยู่ มาประกอบร่างสร้างเป็นตัวเรา และใช้ชีวิตต่อไปได้อีกครั้ง")));
        $wordtemplate->setValue('technology',strip_tags(str_replace('&nbsp;', "", "เพราะเราไม่ชอบความเจ็บปวด เราเลยหลีกเลี่ยงที่จะรู้สึกถึงมันหากทำได้ แต่ในการบำบัดนั้น เราต้องวางเกราะป้องกันเหล่านี้ลงและทำความเข้าใจกับสาเหตุที่แท้จริง แม้จะเจ็บปวดแค่ไหนก็ตาม")));
        $wordtemplate->setValue('marketability',strip_tags(str_replace('&nbsp;', "", "สำรวจจิตใจอันซับซ้อนของมนุษย์ เข้าใจความเจ็บปวด เรียนรู้การระบายอารมณ์ เยียวยาตัวเอง และออกเดินทางตามหาความสุขกันใหม่ ไปพร้อมๆ กับ 10 ข้อคิดจากหนังสือ “Maybe You Should Talk to Someone")));
        $wordtemplate->setValue('prospect',strip_tags(str_replace('&nbsp;', "", "แทนที่จะโยนทิ้งและปล่อยให้เป็นเรื่องราวในอดีตเฉยๆ อย่าลืมว่าจริงๆ แล้วการเดินทางอันยาวนานตลอด 1 ปีที่ผ่านมาให้อะไรเรามากมาย  มาร่วมส่งท้ายปีเก่าด้วยการรู้จักตัวเอง ย้อนมองบทเรียน และรับกำลังใจดีๆ ผ่าน 12 บทความให้กำลังใจจาก Mission To The Moon")));
        $wordtemplate->setValue('leadername',"ชัยวัฒน์");
        $wordtemplate->setValue('leaderlastname',"ทวีจันทร์");
        $wordtemplate->setValue('leaderposition',"เจ้าหน้าที่ตรวจสอบ");
        $wordtemplate->setValue('phone',HP::toThaiNumber("0654852145"));
        $wordtemplate->setValue('phoneext', HP::toThaiNumber("0654852145"));
        $wordtemplate->setValue('leaderemail',"chaiwat@mail.com");
        $wordtemplate->setValue('fax',HP::toThaiNumber("0654852145"));
        $wordtemplate->saveAs('report_doc_001.docx');
        return response()->download('report_doc_001.docx')->deleteFileAfterSend(true);
    
    }


}
