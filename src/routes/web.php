<?php

//to make the session available use web middleware
Route::group(['middleware' => ['web']], function () {
    Route::match(array('GET', 'POST'),'webdav-fileselector-get', 'hummingbirddev\webdavfileselector\WebdavFileselectorController@get');
    Route::post('webdav-fileselector-post', 'hummingbirddev\webdavfileselector\WebdavFileselectorController@post');
});


?>