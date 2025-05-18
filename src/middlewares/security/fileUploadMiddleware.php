<?php

declare(strict_types=1);

namespace API\src\middlewares\security;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use API\src\config\security\Security;
use Slim\Psr7\Response as SlimResponse;

use function API\src\utilities\functions\errorResponse;

class FileUploadMiddleware
{
    private array $allowedTypes;
    private int $maxFileSize; // Maximum file size in bytes
    private int $maxFileCount; // Maximum number of files

    public function __construct(array $allowedTypes, int $maxFileSize, int $maxFileCount)
    {
        $this->allowedTypes = $allowedTypes;
        $this->maxFileSize = $maxFileSize;
        $this->maxFileCount = $maxFileCount;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $parsedBody = $request->getParsedBody();

        if (isset($parsedBody['files']) && is_array($parsedBody['files'])) {
            // Check the number of files
            if (count($parsedBody['files']) > $this->maxFileCount) {
                // Too many files
                $response = new SlimResponse();
                return errorResponse('Too many files. Maximum allowed is ' . $this->maxFileCount . '.', 400);
            }

            foreach ($parsedBody['files'] as $file) {
                if (isset($file['tmp_name'])) {
                    // Validate file type
                    if (!Security::validateUploadedFile($file, $this->allowedTypes)) {
                        // Invalid file type
                        $response = new SlimResponse();
                        return errorResponse('File type not allowed.', 400);
                    }

                    // Validate file size
                    if (filesize($file['tmp_name']) > $this->maxFileSize) {
                        // File size exceeds the maximum limit
                        $response = new SlimResponse();
                        return errorResponse('File size exceeds the maximum limit of ' . ($this->maxFileSize / 1024 / 1024) . ' MB.', 400);
                    }
                }
            }
        }

        return $handler->handle($request);
    }
}
