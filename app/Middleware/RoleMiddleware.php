<?php

class RoleMiddleware
{
    public static function isTeacher(array $user): bool
    {
        if (!$user) {
            return false; 
        }
        $userRole = $user['role'];
        return $userRole === 'teacher';
    }
}
