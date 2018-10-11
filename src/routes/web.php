<?php

//to make the session available use web middleware
Route::group(['middleware' => ['web']], function () {
    Route::get('webdav-fileselector', 'hummingbirddev\webdavfileselector\WebdavFileselectorController@get');
});
//don't use web middleware here to avoid CSRF protection
Route::post('webdav-fileselector', 'hummingbirddev\webdavfileselector\WebdavFileselectorController@post');

?>