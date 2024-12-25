<?php

declare(strict_types=1);

namespace Kernel\Components\Mailer;

final readonly class MailDTO
{
    public function __construct(
        public string $sendTo,
        public string $subject,
        public string $body,
        public string $sendFromEmail,
        public string $sendFromName = '',
        public ?string $pathToFile = null
    ) {
    }
}
