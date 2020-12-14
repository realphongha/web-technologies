<?php

// number of books to be displayed in homepage:
define("TOP_BOOK_HOME", 5);

// images:
define("ALLOW_IMG_TYPES", array("jpg","jpeg","png"));
define("MAX_FILE_SIZE", 2097152);
define("UPLOAD_DIRECTORY", "/upload");
define("STATIC_UPLOAD_DIRECTORY", "C:\\xampp\\htdocs\\library-management\\public\\upload");
define("IMG_DIRECTORY_USER", UPLOAD_DIRECTORY . "/img/user/");
define("IMG_DIRECTORY_BOOK", UPLOAD_DIRECTORY . "/img/book/");
define("STATIC_IMG_DIRECTORY_USER", STATIC_UPLOAD_DIRECTORY . "\\img\\user\\");
define("STATIC_IMG_DIRECTORY_BOOK", STATIC_UPLOAD_DIRECTORY . "\\img\\book\\");

// database constant:
 
// book status:
define("BOOK_DELETED", 0);
define("BOOK_ACTIVE", 1);

// user status:
define("USER_DELETED", 0);
define("USER_ACTIVE", 1);

// borrowed book status:
define("BBOOK_CANCELED", 0);
define("BBOOK_PENDING", 1);
define("BBOOK_BORROWED", 2);
define("BBOOK_RETURNED", 3);
define("BBOOK_LOST", 4);

// user role:
define("ADMIN_ROLE", 0);
define("EMPLOYEE_ROLE", 1);
define("USER_ROLE", 2);
define("GUEST_ROLE", 3);