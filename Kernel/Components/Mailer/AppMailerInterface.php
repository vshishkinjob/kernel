<?php

namespace Kernel\Components\Mailer;

interface AppMailerInterface
{
    public function sendEmail(MailDTO $dto): void;
}
