<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-email', 'EmailController@sendEmail');
Route::get('/pmt1', 'TestController@pmt1');
Route::get('/api', 'TestController@api');

Route::get('/lab', 'TestController@lab');

Route::get('/split-text', 'TestController@splitText');


Route::get('/pdf/certificate/{type}', 'PdfController@pdfCertificate')->name('pdf.certificate');
Route::get('/pdf/sign-certificate', 'PdfController@signCertificate')->name('pdf.sign-certificate');
Route::get('/pdf/create-bis50', 'Bis50Controller@createBis50')->name('pdf.create-bis50');
Route::get('/pdf/notification-note', 'Bis50Controller@notificationNote')->name('pdf.notification-note');
Route::get('/pdf/scope', 'Bis50Controller@scope')->name('pdf.scope');

Route::get('/pdf/create-callab-scope', 'Bis50Controller@createCalLabScope')->name('pdf.create-callab-scope');
Route::get('/pdf/add-sign', 'Bis50Controller@addSign')->name('pdf.add-sign');
Route::get('/pdf/add-sign-verify', 'Bis50Controller@addSignVerify')->name('pdf.add-sign-verify');

Route::get('/pdf/labreport', 'LabReportController@labreport')->name('pdf.labreport');
Route::get('/pdf/raw-labreport', 'LabReportController@rawLabreport')->name('pdf.raw-labreport');

Route::get('/gen-word', 'LabReportController@genWord')->name('gen-word');









