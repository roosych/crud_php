<?php
session_start();
include 'functions.php';

logout();
redirect_to('page_login.php');
exit();