<?php
require_once '../core/initialize.php';

unset($_SESSION);
session_destroy();
Router::redirect('login');