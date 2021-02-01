<?php

declare(strict_types=1);

namespace App\Helpers;

final class ApiResponse
{
    public function getDefaultResponse(): array
    {
        return [
            'requestStatus' => 'done',
            'data'          => []
        ];
    }

    public function getErrorResponse(string $message): array
    {
        return [
            'requestStatus' => 'error',
            'data'          => [],
            'error'         => $message
        ];
    }
}