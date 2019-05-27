

# LADI

LADI is a PHP library used local web applications. 

*May 2019 - 

The original web applications themselves are not present in this repository, but the "framework" itself can be found here.

This document has been adjusted to be publicly presentable, though I am keeping many of my self-incriminating comments intentionally.*

## Brief History

In early Spring of 2013, the CDE Databases began as a class project. The first database attempted was the marketing request database. Soon, a budget request system was needed and placed at a higher priority than marketing. Budget replaced marketing for the class project and was completed, leaving marketing nearly completed. As summer came and the project was turned in, the creator left for an internship and did not return. I completely rewrote marketing using the crud classes described below. As the project became more and more involved, I forced myself to learn simple, yet important paradims such as OOP and DRY. I also half-assed attempted to work in the MVC paradigm, but that obviously didn't work out too well.

By late 2013, a new database was needed, Coskrey. To this day, it has never been used, but it has been rumored that its deployment will soon be upon us.

In mid-winter of 2014, I became aggrivated with budget, so I rebuilt it from the ground up. I also moved it to devel from its old server, budget.distance.

# CRUD Classes

The core of these databases are driven by a set of classes responsible for Creation, Retrieval, Updating, and <span style="text-decoration:line-through;">Deletion</span> of database entries (aka CRUD). These classes are abstract classes, which are extended by a set of class definitions per object type.

## DatabaseObject

*   Responsible for CRUD operations on single objects
*   Provides a way to print an objects values in a human readable form
*   Includes functions to retrieve OTM and MTM tables (e.g. comments, assignments, ect.)

    **These functions should rarely be used directly. They should be used in an override of the create or retreive CRUD functions.**

## DatabaseObjectManager

*   Provides static functions to manage multiple DatabaseObjects
*   Includes a function to get all instances or to get certain ones defined by a search parameter
*   Includes a function to print a table using fancyValues

## SearchParameter

*   Gives a structure to generate sql WHERE search terms.
*   Always joined together with 'AND'
*   Manager classes implement generateSearchParameters. This will take GET or POST values from a form and generate search parameters from the names of each field. Note that keys ending in _comp are used to replace an equivilancy test with a comparison test. 
*   The ordering is screwed up ('y = x' takes the form of 'y x ='). It may be worth it to refactor this class, but it would need to be done in all databases at once.

# Common Directory

The common directory contains all resources that are the same between all databases. This includes php libraries, common classes,

## PHP Classes

### databaseObject.php

DatabaseObject base class.

### databaseObjectManager.php

DatabaseObjectManager base class.

### searchParameter.php

SearchParameter definition

## Javascript Libraries

### External

### JQuery

Yup. It's JQuery.

### JQuery UI

Jquery Extension that adds a few UI elements.

### ajaxForm

Support for autoSubmit script

### autocomplete

A flexible jquery autocomplete form element. Used for vendors in Budget Requests.

### clockpick

Jquery form element that allows users to select a time of day.

### sortable

Allows tables to be sorted by clicking on the table header

### table2CSV

Converts an html table to a CSV table.

### Internal

### autoSubmit

Handles ajax submittion of many forms in the database.  
Handles things like pop-up messages for success and error and redirects.

## PHP Libraries

### Medoo

Lightweight PHP framework. Interfaces with the database most projects.

### Rollbar

Tracks PHP errors. Errors can be viewed at [https://rollbar.com/](https://rollbar.com/)

# Utility Directory

This section contains a description of the file structure used in the databases. Note that older databases will not include all of these. @todo: include list

## img/

Contains images.

## source/

### classes/

This folder contains all classes that are used per database. All files in this directory will be automatically included by shared.php (though not recursively). In some cases, filenames begin with underscores. This is so it will load before the other classes, though that probably should be done through include_once instead of having the include order be dependent on the filename.

* (classname).php - A derived class of database object</td>
* (classname)Manager.php - A derived class of database object Manager</td>



### access.php

This file contains functions that test whether or not a user can perform a certain action or view certain content. These functions will typically use two database objects as a parameter, one of them being the user in question (don't try to grab the current user from inside the function, please).

### email.php

This file contains functions that are responsible for sending any emails to users.

### sessionVars.php

This file contains variables that are commonly used throughout the database. Many of the variables are the indexes of sessions variables. These MUST be unique across ALL databases.

### functions.php

This file contains functions that do not fit into any other category. The most important one is a function that returns a database connection. I'm sure the existance of this file is extremely poor practice, so feel free to set it up a different way if you prefer.

## style/

Contains css.

## templates/

Contains php segments that are common among all pages. This doesn't include data from headers because the exact things that are included changes from page to page.

## shared.php

Contains error handling code for all pages, as well as a series of includes to include many other php files. It automatically includes anything source/, though not recursively.

# Common Examples

The following are a few expressions found across the application. There are obviously many more than this, but this should be enought to get started.

### Creating an databaseObject instance

$myRequest = new Request();

<aside>This does not create an instance of the object in the database.</aside>

### Getting an object by its id

$myRequest = new Request();  
$myRequest->getByID('13');

### Getting multible database objects

$myRequestArray = RequestManager::getAll();

### Printing a table of database objects

$myRequestArray = RequestManager::getAll();  
$printArray = array('id1', 'id2', 'id3', ...)  
RequestManager::printAll($myRequestArray, $printArray);

### Creating an object in the database.

$inData = $_GET;  
$addObject = new Request($inData);  
$addObject->create();

# File Naming Convention

The file naming schema for general (top level) pages is pretty simple. The beginning segment should be a verb that describes the action the page executes (view, edit, add, ect.). Next is an optional 'All' that indicates that we're dealing with multiple objects. The third segment is the name of the class that the page deals with. The last segment is usually an action or a form. As a rule of thumb, if the page directly outputs html, it is called a form. Otherwise, it is an action page.

(verb) [all] (noun) (form/action) .php

The casings of the filenames should always use camelcase.

# Jquery AutoSubmit Format

autoSubmit.js utilizes the jquery autosubmit plugin to execute simple form submission. It's pretty cool since all you do is call this function and it will handle both the submission and the response from the php action.

The return format is a json encoded array:

| success_bool | Was the desired action successful? |
|success_message | Message that is displayed if successful. |
| error_message | Message displayed if not successful. |
| debug_message | Message displayed regardless of the success. Used to debug. |
| redirect_url | URL the calling page should redirect to on success. |


autoSubmit.js handles the messaging and redirects, so the only thing you should worry about is making sure that the return array gets properly encoded on the action page.

If there is a php error on the action page, then an attempt to submit the form will end up doing nothing. To debug this, I typically just comment out the javascript the autoSubmit initializer and refresh the page. Attempting to submit under those conditions should show the php error. Perhapse the common setup could provide a way to return php errors too, but I've found debugging in web browser dialogue boxes to be more annoying than disabling the autosubmit.

# Starting a New Project

To start a new project, I typically:

*   Copy and paste the youngest project.
*   Removed all files except for the Index, Login/Logout, Utility, User, and one file like Request.
*   Remove all unneeded classes as well.
*   Change db_name in all remaining classes.
*   Change the session variable names in sessionVars.php to reflect the new project.
*   Create tables for the new project.

# PHPDocumentor

phpDocumentor is used to automatically document php classes with docblocks. To generate documents, execute the .phar file in /Docs using php. -d is the source directory, -t is the target.

### Example

php phpDocumentor.phar -d ../Budget/Utility/source -t ./Budget

If there are errors in compiling the documents, you can view them by clicking "Reports->Errors" on the top navbar. These include methods, classes, and functions that have no docblocks.


# Future Project Suggestions

## Testing Server

budget.distance.msstate.edu is now unused, and the current workflow does not use a testing server. Though the option is there, Dreamweaver's native testing server workflow is horrible. The best way seems to be creating a seperate site that points to the remote testing server but uses the same local files.

## Framework Implementation

DatabaseObject and DatabaseObjectManager were created before I knew about frameworks. Unfortunately, when I found out about them, I really didn't have time to research, learn, and implement a particular framework for all sites, so I focused on makeing what is here as clear as I can. The next guy in line should strongly consider creating new databases using a framework and converting existing databases to use them. Just a suggestion, though.

## Central Authentication

As of May 21, 2014, there are 4 sets of usernames and passwords, and more seem to be on the way. When these projects started out, no one really thought there would be more than 2, maybe 3\. Since users will NOT remember their passwords (or take the time to change them 50% of the time), there really needs to be a central place to authenticate a user. Each user table should remain, but the username/password combos should be moved to its own place.

## One Copy of Common Files

It would be nice to only have one copy of some common files used. For example...

*   databaseObject.php
*   databaseObjectManager.php
*   jquery
*   autoSubmit.js
*   clockpick.js
*   ect.

## Marketing Upgrade

As of May 21, 2014, the marketing DB is lacking in organization and consistancy with the other databases. For instance, it does not use the DatabaseObjectManager class, the AJAX autoSubmit, or the minified jquery script.
