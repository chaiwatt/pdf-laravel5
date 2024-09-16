<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-email', 'EmailController@sendEmail');
Route::get('/pmt1', 'TestController@pmt1');
Route::get('/api', 'TestController@api');

Route::get('/lab', 'TestController@lab');

// Route::get('/pdf/certificate', 'PdfController@pdfCertificate');
Route::get('/pdf/certificate-mpdf', 'PdfController@pdfCertificateMpdf');



