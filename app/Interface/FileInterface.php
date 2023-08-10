<?php

namespace App\Interface;

interface FileInterface
{

    /**
     * Image types
     *
     * @var array
     */
    public const IMAGE_TYPES = [
        'avatar' => 'avatar',
        'cover' => 'cover',
        'photo' => 'photo',
    ];
}
