# webdav-fileselector

A Laravel package for showing and selecting files and folders of a WebDAV server.

## Features

- Retrieve a list of files and folders from a WebDAV server
- Use WebDAV API: *propfind*
- No mounting
- Fast
- Supports multi-user
- Supports external usage as API
- Provides a sophisticated client template using the [hummingbird-treeview](https://github.com/hummingbird-dev/hummingbird-treeview) package
- Display files and folders in a hierarchical tree structure
- Different options can be enabled / disabled, e.g. 
  - select only one file
  - select one or more files
  - select whole folders
  - select all
- Filter for file types (e.g. .jpg, .txt) and arbitrary patterns
- Convenient search function
- ... and many more


## Dependencies

- Laravel 5.5.*
- PHP 7.0
- cURL extension enabled

## Included libraries

- jQuery 3.3.1
- bootstrap 4.0.0
- font-awesome
- hummingbird-dev/hummingbird-treeview

This means that these libraries (or parts of them) are included in the
webdav-fileselector package. Thus no download / installation of these libraries is needed.

## Getting started
### Installation

Install via composer and run the command below in the root of your project:

```bash
composer require hummingbird-dev/webdav-fileselector

```

Add the following under *autoload* to your composer.json (that one in your projects root directory):

``` php
...
"autoload": {
   ...
   "psr-4": {
      "App\\": "app/",
      "HummingbirdDev\\WebdavFileselector\\":"vendor/hummingbird-dev/webdav-fileselector/src/"
   }
   ...
},

```

Update *composer* from the root of your project:

```bash
composer update

```

Publish resources from your root folder:

```bash
php artisan vendor:publish --provider="HummingbirdDev\\WebdavFileselector\\WebdavFileselectorServiceProvider"

```


## Usage

Start a local development server

``` php
php artisan serve

```

and navigate to http://localhost:8000/webdav-fileselector-get

You will see the client template, which can be edited at "/resources/views/hummingbird-dev/webdav-fileselector.blade.php".



Two possibilities exist to include the needed WebDAV credentials and
to submit optional settings.

First, the client at
"/resources/views/hummingbird-dev/webdav-fileselector.blade.php" can
be edited or an additional POST form on any other page can be used to call the client. This form may look like:

``` html
<form method="POST" action="http://localhost:8000/webdav-fileselector-get">
	<input type="hidden" name="b2drop_username" value="smieruch">
	<input type="hidden" name="b2drop_password" value="password">
	<input type="hidden" name="b2drop_url" value="http://localhost:8099/remote.php/webdav/">
	<input type="hidden" name="select_only_one_item" value="1">
	<input type="hidden" name="show_only_parent_folder" value="0">
	<input type="hidden" name="disable_folder_checking" value="1">
	<input type="hidden" name="disable_root_node" value="0">
	<input type="hidden" name="getChecked_onlyEndNodes" value="1">
	<input type="hidden" name="filter" value="">
	<input type="hidden" name="fileselector_height" value="300">
	<input type="hidden" name="minimal_view" value="0">
	<input type="hidden" name="jumbotron" value="1">
	<button type="submit">Start Fileselector</button>
</form>

```

## webdav-fileselector as a service

The interesting point here is that this HTML form can be implemented on any other web page. So it's possible
to provide this service on other web projects. One possibility for integration would be an iframe. That means, placing
an iframe onto the page:

``` html
<iframe name="my_iframe" width="100%" height="400px" src=""></iframe>

```
and pointing the form to the iframe with the "target" attribute, which means to open the response of the form POST in the iframe:

``` html
<form method="POST" action="http://localhost:8000/webdav-fileselector-get" target="my_iframe">
	<input type="hidden" name="b2drop_username" value="smieruch">
	<input type="hidden" name="b2drop_password" value="password">
	...
```

## Parameters

Following parameters are mendatory:

- **b2drop_username**<br>
  This is the username needed to login to the WebDAV server.

- **b2drop_password**<br>
  The corresponding password needed to login to the WebDAV server.

- **b2drop_url**<br> 
  The URL to the WebDAV server. If it is e.g. an
  *ownCloud* or *nextCloud* instance, the URL is *https://example.com/remote.php/webdav*.
  

Following settings are optional and have all default values. These settings influence mostly the
functionality of the *hummingbird-treeview*, which is used to show the files and folders.
All *values* of these settings are strings, although many behave like boolean *true* and *false*.

- **select_only_one_item**<br>
  This parameter can be enabled by *value="1"* or disabled by *value="0"*. Default is *value="1"*. If activated,
  only single items in the treeview can be checked. This provides the typical feature, where
  the user is only allowed to select a single file instead of multiple. It is important to note
  that the parameter **disable_folder_checking** should be enabled as well.
  
- **disable_folder_checking**<br>
  To disable the functionality to check whole folders this parameter has to be 
  set to *value="1"* otherwise *value="0"* has to be used. Default is *value="1"*. Activating this parameter is needed,
  if the above parameter **select_only_one_item** is also activated to restrict the 
  selection of items to single files.
  
- **show_only_parent_folder**<br>
  This is a special parameter and can be activated by setting *value="1"* or disabled by *value="0"*. Default is *value="0"*.
  If activated the returned *List* (details below) does not contain the selected files, but instead only
  the folder, which contains the selected files, i.e. the parent folder.

- **disable_root_node**<br>
  Again, this setting can be activated by *value="1"* and deactivated by *value="0"*. Default is *value="0"*. If activated
  the root node is disabled, which means it cannot be checked. 
  
- **getChecked_onlyEndNodes**<br>
  This is an important parameter and activated by *value="1"* and deactivated by *value="0"*. Default is *value="1"*. If
  activated the returned *List* (details below) contains only the checked files and NOT the checked folders.
  
- **filter**<br>
  Filtering is a powerful option to select only certain files. For instance if *value=".txt"* only files containing ".txt"
  in their names are shown. Default is an empty string *value=""*, which means no filtering. If *value="myfile"* only 
  files containing "myfile" in the name are shown. Additionally it is possible to filter
  for multiple strings in a "OR" sense. If *value=".jpg|.png|.bmp"* only files are shown containing ".jpg" or ".png" or ".bmp".
  
- **fileselector_height**
  This parameter defines the height in px of the "<div>", where the *hummingbird-treeview* is embedded. It is scollable, thus the height
  can be chosen small if needed. Default is *value="400"* pixel.
  
- **minimal_view** 
  If activated by *value="1"* (deactivate by *value="0"*) only a heading, the search field and the treeview are shown. 
  Otherwise a little more markup is included. Default is *value="0"*.

- **jumbotron**
  This option, if *value="1"* places the treeview on a Bootstrap Jumbotron, i.e. essentially a gray block.
  
  
## Events -- grabbing the selected files

On every file check or uncheck on the *hummingbird-treeview* an event is fired including the selected files.
As can be seen in the file *webdav-fileselector.blade.php* there is a small JavaScript snippet at the end of the file:

``` javascript
 window.addEventListener("message",function(e) {
     //console.log("message event",e);
     var key = e.message ? "message" : "data";
     data = e[key];
     console.log("file_path= " + data.dataid)
     console.log("file_id= " + data.id)
     console.log("file_text= " + data.text)
 },false);

```

This JavaScript code grabs the *List* of the selected files, which are
stored here in the object *data*. This object contains arrays, whereas
*data.dataid* contains the full paths to the selected files. The
*data.id* contains an id, which is essentially a string together with
a running number and not important here. The *data.text* contains the
text shown in the *treeview*, which is mostly similar to the real filename.
