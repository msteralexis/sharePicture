<?php


function deconnection(){
    session_start(); session_unset(); session_destroy();
}