<?php
    namespace App\Enums;
    enum UserRole: string{
        case student = 'student';
        case instructor = 'instructor';
        case admin = 'admin';
    }
?>