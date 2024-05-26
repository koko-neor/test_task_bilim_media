<?php

namespace App\DTO;

/**
 * Class LessonDTO
 * @package App\DTO
 */
class LessonDTO
{
    /**
     * @param string $title
     * @param string $content
     * @param int $order
     * @param string|null $video_url
     */
    public function __construct(
        public string $title,
        public string $content,
        public int $order,
        public ?string $video_url = null
    ) {}
}
