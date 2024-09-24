<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Illuminate\Http\Request;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfController extends Controller
{
    protected $configResponse;

    public function __construct()
    {
        // สร้างคอนฟิกขึ้นมาเมื่อโหลด Controller
        $this->configResponse = $this->createConfigCollection();
    }

    public function signCertificate()
    {
        $attach_path = 'uploads';
        $data_pdf = $this->pdfCertificate('F');
        $type = 3;

        $datas  =  $this->getRegister($data_pdf->file_path,$type,$data_pdf->certificate_no,$attach_path);
        
        if(!empty($datas->SignatureID)){
    
            $file_path = $data_pdf->path . '/' . $datas->Certificate_newfile;
            // $file = file_get_contents($file_path);
            
            // เปลี่ยนจาก Storage::put เป็น Storage::disk('public')->put
            // $file_ftp = Storage::disk('public')->put('si', $file);
            
            $object = (object)[];
            $object->documentId = $datas->DocumentID;
            $object->signtureid = $datas->SignatureID;
        
            dd($data_pdf, $datas, $object);
        }
    }

    public function getRegister($file ='' ,$type ='' ,$certificate_no = '',$attach_path='uploads')
    {
        $configResponse = $this->configResponse;
        $config = $configResponse->getData(true);
        $byteArray = file_get_contents($file);
       
        if($type == 3){ // ห้องปฏิบัติการ
            $TemplateID =   $config['digital_signing_lab'];
        }else if($type == 2){ // หน่วยตรวจสอบ
            $TemplateID =   $config['digital_signing_ib'];
        }else if($type == 1){ // ห้องหน่วยรับรอง
            $TemplateID =   $config['digital_signing_cb'];
        }
            $url            =  $config['digital_signing_api_document_id'];
        
            $apiurl 	= $url."PdfA=true&Timestamp=true&TemplateID=".$TemplateID;
          

          $token 	=  $this->getToken($config['digital_signing_consumer_key'], $config['digital_signing_consumer_secret'], $config['digital_signing_agent_id'] ,$config['digital_signing_api_token']);
          
          $postArray = array(
            'Content'   	=> $byteArray,
            'Page' 	        => '1',
            'Left' 	        => '50',
            'Bottom' 	    => '75'
            );



          $json 	                        = $this->callServicePUT($apiurl, $config['digital_signing_consumer_key'], $token, $postArray);
          $data 	                        = json_decode($json);
          $object 					    = (object)[]; 
          $object->DocumentID 			= $data->DocumentID;
          $organization 					= $this->getOrganization($data->DocumentID, $config['digital_signing_consumer_key'] ,$token);

          if(!empty($organization->SignatureID)){
            $object->SignatureID 			=  $organization->SignatureID   ;

            $file_name 					    =   $this->getDownlaodPDFigned($data->DocumentID , $config['digital_signing_consumer_key'], $token,$certificate_no,$attach_path);

        
            $object->Certificate_newfile 	= !empty($file_name) ? $file_name : null  ;

        }

		return  $object;
          
    }

    public function pdfCertificate($type ='I')
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
        $html  = view('pdf/certificate-mpdf', $data_export);
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
        if($type == 'I'){
            $mpdf->Output($title, $type);  
        }else if($type == 'F'){
            $object = (object)[]; 
            $path = public_path('uploads/');
            $file_path = $path.'/'.$title;
           
            $mpdf->Output($file_path, "F");
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            } 
            
            if(is_file($file_path)){
                 $file_ftp     = Storage::put($title, $file_path);
                 if($file_ftp == true){
                 
                $object = (object) [
                    'file_path' => $file_path,
                    'certificate_no' => "67L:LAB0937",
                    'attach_path' => "",
                    'path' => $path,
                    'app_no' => "CAL-67-230",
                    'name' => "นายชัยวัฒน์ ทวีจันทร์",
                    'tax_id' => "3560200325574",
                    'sign_id' => $signer['sign_id'],
                    'list_id' => 534,
                ];

                 }
               }  
               return $object;
        } 
                                                        
    }

    public function createConfigCollection()
    {
        $config = collect([
            'industry_auth_url' => env('INDUSTRY_AUTH_URL'),
            'industry_client_id' => env('INDUSTRY_CLIENT_ID'),
            'industry_client_secret' => env('INDUSTRY_CLIENT_SECRET'),
            'industry_juristic_url' => env('INDUSTRY_JURISTIC_URL'),
            'industry_personal_url' => env('INDUSTRY_PERSONAL_URL'),
            'industry_ijuristicid_url' => env('INDUSTRY_IJURISTICID_URL'),
            'active_check_iindustry' => env('ACTIVE_CHECK_IINDUSTRY', 0),
            'url_register' => env('URL_REGISTER'),
            'refresh_dashboard_value' => env('REFRESH_DASHBOARD_VALUE', 10),
            'refresh_dashboard_unit' => env('REFRESH_DASHBOARD_UNIT', 'M'),
            'url_elicense_trader' => env('URL_ELICENSE_TRADER'),
            'url_elicense_staff' => env('URL_ELICENSE_STAFF'),
            'recaptcha_site_key' => env('RECAPTCHA_SITE_KEY'),
            'recaptcha_secret_key' => env('RECAPTCHA_SECRET_KEY'),
            'url_sso' => env('URL_SSO'),
            'sso_esurveillance_app_name' => env('SSO_ESURVEILLANCE_APP_NAME'),
            'sso_esurveillance_app_secret' => env('SSO_ESURVEILLANCE_APP_SECRET'),
            'sso_eaccreditation_app_name' => env('SSO_EACCREDITATION_APP_NAME'),
            'sso_eaccreditation_app_secret' => env('SSO_EACCREDITATION_APP_SECRET'),
            'sso_google2fa_status' => env('SSO_GOOGLE2FA_STATUS', 1),
            'sso_domain_cookie_login' => env('SSO_DOMAIN_COOKIE_LOGIN'),
            'sso_name_cookie_login' => env('SSO_NAME_COOKIE_LOGIN'),
            'tisi_api_corporation_url' => env('TISI_API_CORPORATION_URL'),
            'tisi_api_person_url' => env('TISI_API_PERSON_URL'),
            'tisi_api_house_url' => env('TISI_API_HOUSE_URL'),
            'tisi_api_factory_url' => env('TISI_API_FACTORY_URL'),
            'tisi_api_faculty_url' => env('TISI_API_FACULTY_URL'),
            'officer_name_cookie_login' => env('OFFICER_NAME_COOKIE_LOGIN'),
            'officer_domain_cookie_login' => env('OFFICER_DOMAIN_COOKIE_LOGIN'),
            'sso_login_fail_amount' => env('SSO_LOGIN_FAIL_AMOUNT', 5),
            'sso_login_fail_lock_time' => env('SSO_LOGIN_FAIL_LOCK_TIME', 15),
            'digital_signing_api_token' => env('DIGITAL_SIGNING_API_TOKEN'),
            'digital_signing_api_document_id' => env('DIGITAL_SIGNING_API_DOCUMENT_ID'),
            'digital_signing_api_esignatures' => env('DIGITAL_SIGNING_API_ESIGNATURES'),
            'digital_signing_api_download_signed' => env('DIGITAL_SIGNING_API_DOWNLOAD_SIGNED'),
            'digital_signing_api_esgnatures' => env('DIGITAL_SIGNING_API_ESGNATURES'),
            'digital_signing_api_revoked' => env('DIGITAL_SIGNING_API_REVOKED'),
            'digital_signing_consumer_secret' => env('DIGITAL_SIGNING_CONSUMER_SECRET'),
            'digital_signing_agent_id' => env('DIGITAL_SIGNING_AGENT_ID'),
            'digital_signing_consumer_key' => env('DIGITAL_SIGNING_CONSUMER_KEY'),
            'digital_signing_cb' => env('DIGITAL_SIGNING_CB'),
            'digital_signing_ib' => env('DIGITAL_SIGNING_IB'),
            'digital_signing_lab' => env('DIGITAL_SIGNING_LAB'),
            'url_center' => env('URL_CENTER'),
            'mail_center' => env('MAIL_CENTER'),
            'url_acc' => env('URL_ACC'),
            'reference_number_lab' => env('REFERENCE_NUMBER_LAB'),
            'reference_refno_lab' => env('REFERENCE_REFNO_LAB'),
            'reference_number_ib' => env('REFERENCE_NUMBER_IB'),
            'reference_refno_ib' => env('REFERENCE_REFNO_IB'),
            'reference_number_cb' => env('REFERENCE_NUMBER_CB'),
            'reference_refno_cb' => env('REFERENCE_REFNO_CB'),
            'info_contact' => '<h2>ติดต่อสอบถาม</h2>
                <p>ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</p>
                <p>โทร. 0 2430 6834 ต่อ 2450, 2451</p>
                <p>e-Mail : nsw@tisi.mail.go.th</p>
                <br>
                <p>กองควบคุมมาตรฐาน (ระบบลงทะเบียน และ Login)<br>โทร. 0 2430 6821 ต่อ 1002, 1003</p><p><b>QR CODE LINE<br></b><img src="https://sso.tisi.go.th/images/QR-Code.png" style="width: 205.242px; height: 205.242px;"></p><p></p>',
            'digital_signing_api_attachment' => env('DIGITAL_SIGNING_API_ATTACHMENT'),
            'refresh_notification' => env('REFRESH_NOTIFICATION', 600),
            'check_api_asurv_accept_export' => env('CHECK_API_ASURV_ACCEPT_EXPORT', 1),
            'check_api_asurv_accept_import' => env('CHECK_API_ASURV_ACCEPT_IMPORT', 1),
            'check_api_asurv_accept21_export' => env('CHECK_API_ASURV_ACCEPT21_EXPORT', 1),
            'check_api_asurv_accept21_import' => env('CHECK_API_ASURV_ACCEPT21_IMPORT', 1),
            'check_api_asurv_accept21own_import' => env('CHECK_API_ASURV_ACCEPT21OWN_IMPORT', 1),
            'check_api_certify_check_certificate' => env('CHECK_API_CERTIFY_CHECK_CERTIFICATE', 0),
            'check_api_certify_check_certificate_ib' => env('CHECK_API_CERTIFY_CHECK_CERTIFICATE_IB', 0),
            'check_api_certify_check_certificate_cb' => env('CHECK_API_CERTIFY_CHECK_CERTIFICATE_CB', 0),
            'tisi_api_factory_url2' => env('TISI_API_FACTORY_URL2'),
            'check_electronic_certificate' => env('CHECK_ELECTRONIC_CERTIFICATE', 1),
            'contact_mail_footer' => env('CONTACT_MAIL_FOOTER'),
            'check_contact_mail_footer' => env('CHECK_CONTACT_MAIL_FOOTER', 1),
            'sso_law_app_name' => env('SSO_LAW_APP_NAME'),
            'sso_law_app_secret' => env('SSO_LAW_APP_SECRET'),
            'check_deduct_money' => env('CHECK_DEDUCT_MONEY', 1),
            'number_deduct_money' => env('NUMBER_DEDUCT_MONEY', 2),
            'agency_deduct_money' => json_decode(env('AGENCY_DEDUCT_MONEY', '["1"]')),
            'check_deduct_vat' => env('CHECK_DEDUCT_VAT', 0),
            'number_deduct_vat' => env('NUMBER_DEDUCT_VAT', 7),
            'agency_deduct_vat' => json_decode(env('AGENCY_DEDUCT_VAT', 'null')),
            'sso_section5_app_name' => env('SSO_SECTION5_APP_NAME'),
            'tisi_api_factory_url3' => env('TISI_API_FACTORY_URL3'),
            // เพิ่มรายการอื่น ๆ ตามที่จำเป็น
        ]);

        return response()->json($config);
    }



    public static  function getToken($ConsumerKey, $ConsumerSecret, $AgentID ,$api_token)
    {
        try {
            $ch = curl_init();
            $headers = array();
            $headers[] = 'Content-Type:application/json'; // set content type
            $headers[] = 'Consumer-Key:' . $ConsumerKey; // set consumer key replace %s
            // set request url
            curl_setopt($ch, CURLOPT_URL, $api_token."ConsumerSecret=" . $ConsumerSecret . "&AgentID=" . $AgentID); // set ConsumerSecret and AgentID
            // set header
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            // return header when response
            curl_setopt($ch, CURLOPT_HEADER, true);

            // return the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // send the request and store the response to $data
            $data = curl_exec($ch);
            // get httpcode 
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpcode == 200) { // if response ok
                // separate header and body
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($data, 0, $header_size);
                $body = substr($data, $header_size);

                // convert json to array or object
                $result = json_decode($body);

                // access to token value
                $token = $result->Result;
            } else {
                $token = "No Found Token";
            }
            // end session

            return $token;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        curl_close($ch);
    }

    public static function callServicePUT($URL, $ConsumerKey, $Token, $postArr)
    {
        $ch = curl_init();
        try {
            $headers = array();
            $headers[] = 'Content-Type:multipart/form-data;'; // set content type
            $headers[] = 'Consumer-Key:' . $ConsumerKey; // set consumer key replace %s
            $headers[] = 'Token:' . $Token; // set access token replace %s
            // set request url
            curl_setopt($ch, CURLOPT_URL, $URL); // set CitizenID replace %s
            // set header
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            // return header when response
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // return the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $postArr);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            
            
            // send the request and store the response to $data
            $data = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpcode == 200) { // if response ok
                // separate header and body
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($data, 0, $header_size);
                $body = substr($data, $header_size);
            } else {
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($data, 0, $header_size);
                $body = substr($data, $header_size);
            }
            // end session
            return $body;
            curl_close($ch);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    public static  function callServicePOST($URL, $ConsumerKey, $Token, $postdata, $file)
    {
        $ch = curl_init();
        try {
            $headers = array();
            $headers[] = 'Content-Type:application/json'; // set content type
            $headers[] = 'Consumer-Key:' . $ConsumerKey; // set consumer key replace %s
            $headers[] = 'Token:' . $Token; // set access token replace %s
            // set request url
            curl_setopt($ch, CURLOPT_URL, $URL); // set CitizenID replace %s
            // set header
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            // return header when response
            curl_setopt($ch, CURLOPT_HEADER, true);
            //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // return the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //POST Method
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            // send the request and store the response to $data
            $data = curl_exec($ch);
            //echo $data;
            // get httpcode 
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            //echo $httpcode;exit();
            if ($httpcode == 200) { // if response ok
                // separate header and body
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($data, 0, $header_size);
                $body = substr($data, $header_size);
            } else {
                $body = "";
            }
            // end session
            return $body;
            curl_close($ch);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function getOrganization($DocumentID,$ConsumerKey,$token)
    {

        // header("Access-Control-Allow-Origin: *");
        // header("Content-Type: application/json; charset=UTF-8");
        // header("Access-Control-Allow-Methods: POST");
        // header("Access-Control-Max-Age: 3600");
        // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        $configResponse = $this->configResponse;
        $config = $configResponse->getData(true);

        $apiurl 		 =  $config['digital_signing_api_esgnatures']; 
    
        try {
            
                $postdata = array(
                                    'DocumentID'		=> $DocumentID,
                                    'Signature'		=>  array('Page'=>'1','Left'=>'100','Bottom'=>'80','Width'=>'140','Height'=>'60','Image'=>null)
                                    );   
    
            $postdata=json_encode($postdata,true);
            if (!isset($postdata) || empty($postdata)) {
                throw new Exception("File Size Zero.");
            } else {  

                $json 			=  self::callServicePOST($apiurl, $ConsumerKey, $token,$postdata,null);
        
                $data 			= json_decode($json);
            
                $object 			= (object)[]; 
                $object->SignatureID 	=  $data->SignatureID;
                return  $object;
    
            }
        } catch (Exception $ex) {
            $object 					= (object)[]; 
            $object->Message 			=  $ex->getMessage();
            return  $object;
        }
    }

    public function getDownlaodPDFigned($DocumentID,$ConsumerKey,$token,$certificate_no,$attach_path)
    {
        try {

            $configResponse = $this->configResponse;
            $config = $configResponse->getData(true);
            
            $api_downlaod_signed 	=  $config['digital_signing_api_download_signed'];
            // dd($api_downlaod_signed);
            $apiurl 	            = $api_downlaod_signed."DocumentID=".$DocumentID;
    
            // Create a stream
            $opts  = array( 
                'http'=>array(
                'method'=>'GET',
                'header'=> "Consumer-Key: ".$ConsumerKey."\r\n"
                    . "Token: ".$token."\r\n"
                ),
            );
            $context 	= stream_context_create($opts);
            $file 	= file_get_contents($apiurl, false, $context);
    
    

            $certificate_no = str_replace("	", "", $certificate_no);
            $certificate_no = str_replace(" ", "", $certificate_no);
            $certificate_no = str_replace(":", "_", $certificate_no);
            $certificate_no = str_replace(')', '_', $certificate_no);
            $certificate_no = str_replace('/', '_', $certificate_no);
            $certificate_no = str_replace('-', '_', $certificate_no);
            $file_name 	=   $certificate_no.'_'.date('Ymd_hms').'.pdf';
            // dd($attach_path);
            // put file pdf
            (file_put_contents($attach_path.'/'.$file_name,$file, FILE_APPEND));
            //   Storage::put($search_path.'/'.$file_name, $file);
            return 	$file_name;
    
        
        } catch (Exception $ex) {
            $object 					= (object)[]; 
            $object->Message 			=  $ex->getMessage();
            return  $object;
        }
    }
  
}
