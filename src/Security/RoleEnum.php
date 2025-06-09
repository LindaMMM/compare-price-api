<?php

namespace App\Security;


enum RoleEnum: string
{
    case ADMIN = 'ROLE_ADMIN';
    case USER = 'ROLE_USER';
    case ROBOT = 'ROLE_ROBOT';
}
