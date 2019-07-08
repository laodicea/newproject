<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

/*
/ Zaznam STN
*/
Route::resource('zoznam-stn', 'ZoznamStn\ZoznamStnController'); 
Route::get('zoznam-stn/ajax/{cisk}','ZoznamStn\ZoznamStnController@ajax');
Route::get('zoznam-ics','ZoznamStn\ZoznamStnController@ics')->name('zoznam.ics');
/*
/ Navrhy na zrusenie STN
/
 */
Route::resource('otn/navrh-zrusenia-stn', 'Otn\NavrhZrusStnController');  
Route::any('otn/navrh-zrusenia-stn-search', 'Otn\NavrhZrusStnController@search')->name('navrh-zrusenia-stn.search'); 

/*
/ Terminologia TaD
*/
Route::resource('terminologia/tad', 'Terminologia\TermsController');
Route::any('terminologia/tad-search', 'Terminologia\TermsController@search')->name('tad.search'); 

Route::get('terminologia/statistic', 'Terminologia\StatisticController@index')->name('tad.statistic');
/*
/ Terminologia Obsahy
*/
Route::resource('terminologia/obsahy', 'Terminologia\ObsahController');
Route::any('terminologia/obsahy-search','Terminologia\ObsahController@search')->name('obsahy.search');
/*
/ Modul Organizačná štruktúra
/
*/
Route::resource('service/department', 'DepartmentController'); 
Route::post('service/department/{id}','DepartmentController@update')->name('department.update');

/*
/ Modul Zamestnanci
/
*/
Route::resource('user', 'UserController');
Route::get('user/usersByDepartment', 'UserController@usersByDepartment')->name('user.bydepartment');
Route::get('user/excel','UserController@getExcel')->name('user.excel');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/*
/ Modul informačná bezpečnosť
/
*/
Route::resource('security-inform','SecurityInform\SecurityInformController');
Route::get('security-inform/download/{slug}/{filename}', 'SecurityInform\SecurityInformController@download')->name('security-inform.download');

Route::any('security-information-search', 'SecurityInform\SecurityInformController@filterByCategory')->name('security-inform.filter');
Route::get('security-inform-notify/{slug}','SecurityInform\SecurityInformController@notify')->name('security-inform.notify');

Route::resource('security-category', 'SecurityInform\SecurityCategoryController')->except(['create']);
Route::any('security-category-search','SecurityInform\SecurityCategoryController@search')->name('security-category.search');
/*
/ Messages
/
*/
Route::resource('messages','MessagesController');


/*
/ Rezervácia miestnosti
/
*/
Route::get('rezervacie', 'Rezervacie\RezervacieController@index')->name('rezervacie.index');
Route::resource('rezervacie/room', 'Rezervacie\RoomController');  
Route::get('rezervacie/{id}/','Rezervacie\RezervacieController@showCalendar')->name('rezervacie.show');
Route::get('rezervacie/my-events/all/','Rezervacie\CalendarEventController@allMyEvent')->name('rezervacie.udalost.all');
Route::post('rezervacie/event/store/{id}','Rezervacie\CalendarEventController@store')->name('rezervacie.udalost.store');
Route::get('rezervacie/event/{id}/edit','Rezervacie\CalendarEventController@edit')->name('rezervacie.udalost.edit'); 
Route::post('rezervacie/event/{id}','Rezervacie\CalendarEventController@update')->name('rezervacie.udalost.update');
Route::DELETE('rezervacie/event/{id}', 'Rezervacie\CalendarEventController@destroy')->name('rezervacie.event.destroy');

/*
/ Objednávky a faktury
*/

//Route::get('objednavky','Datasety\DatasetyController@index')->name('datasety.index');
Route::get('objednavky','Datasety\DatasetyController@createObjednavky')->name('objednavky.show');
Route::post('objednavky','Datasety\DatasetyController@uploadObjednavky')->name('objednavky.upload');
Route::get('faktury','Datasety\DatasetyController@createFaktury')->name('faktury.show');
Route::post('faktury','Datasety\DatasetyController@uploadFaktury')->name('faktury.upload');