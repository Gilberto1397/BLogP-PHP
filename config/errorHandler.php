<?php

set_exception_handler(function ($error) {
    error_log($error);
    $_SESSION['mensagem'] = 'IH CRASHOU, VAMOS ARRUMAR ESSA MERDA';
    header('Location: /login');
    return;
});
