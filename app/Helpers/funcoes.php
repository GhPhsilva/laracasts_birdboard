<?php

function gravatar_url($email)
{
    $email = md5($email);
    return "https://gravatar.com/avatar/{$member->email}?s=60";
}
