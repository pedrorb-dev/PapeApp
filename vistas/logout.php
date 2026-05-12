<?php
session_start();

session_destroy();

header("Location: ./mnt_login");
exit();