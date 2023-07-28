<?php

namespace App\Entity;


enum TypeVisiteur: string
{
    case VIS = 'visiteurExterne';
    case EMP = 'EmployeVisiteur';
}
