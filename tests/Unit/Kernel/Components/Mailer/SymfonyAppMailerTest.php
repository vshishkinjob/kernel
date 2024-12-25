<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Mailer;

use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Kernel\Components\Mailer\MailDTO;
use Kernel\Components\Mailer\SymfonyAppMailer;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;

class SymfonyAppMailerTest extends Unit
{
    public function testSendMail()
    {
        $mailer = $this->make(Mailer::class, [
            'transport' => $this->makeEmpty(TransportInterface::class, [
                'send' => Expected::once(function (Email $email) {
                    $this->assertNotEmpty($email->getAttachments());
                })
            ]),
            'bus' => null
        ]);

        $dto = new MailDTO(
            sendTo: 'some@email.com',
            subject: 'subject',
            body: 'body',
            sendFromEmail: 'from@wemail.com',
            pathToFile: __DIR__ . '/../File/image.txt'
        );

        $symfonyMailer = new SymfonyAppMailer($mailer);
        $symfonyMailer->sendEmail($dto);
    }
}