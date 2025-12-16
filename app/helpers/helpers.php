<?php

if (!function_exists('badgeRole')) {
    function badgeRole($role)
    {
        return match ($role) {
            'admin' => 'bg-blue-100 text-[#0059FF]',
            'coordinator' => 'bg-green-100 text-[#10AF13]',
            'trainer' => 'bg-purple-100 text-[#AE00FF]',
            'branch_pic' => 'bg-orange-100 text-[#FF4D00]',
            'participant' => 'bg-[#ebf8ff] text-[#5EABD6]',
        };
    }
}