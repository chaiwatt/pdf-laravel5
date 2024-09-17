<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-email', 'EmailController@sendEmail');
Route::get('/pmt1', 'TestController@pmt1');
Route::get('/api', 'TestController@api');

Route::get('/lab', 'TestController@lab');


Route::get('/pdf/certificate/{type}', 'PdfController@pdfCertificate')->name('pdf.certificate');
Route::get('/pdf/sign-certificate', 'PdfController@signCertificate')->name('pdf.sign-certificate');
