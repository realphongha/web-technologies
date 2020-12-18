<?php

function encryptPassword($password){
    return \hash("sha256", $password);
}

