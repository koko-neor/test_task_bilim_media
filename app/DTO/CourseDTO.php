<?php

namespace App\DTO;

/**
 * Class CourseDTO
 * @package App\DTO
 */
class CourseDTO
{
    /**
     * @param string $title
     * @param string $description
     * @param string|null $category
     */
    public function __construct(
        public string $title,
        public string $description,
        public ?string $category = null
    ) {}
}
