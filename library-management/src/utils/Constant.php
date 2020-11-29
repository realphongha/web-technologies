<?php

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