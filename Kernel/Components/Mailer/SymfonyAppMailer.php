<?php

namespace Kernel\Components\Mailer;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

final readonly class SymfonyAppMailer implements AppMailerInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

	/**
	 * @throws TransportExceptionInterface
	 */
    public function sendEmail(MailDTO $dto): void
    {
        $email = (new Email())
            ->from(new Address($dto->sendFromEmail, $dto->sendFromName))
            ->to($dto->sendTo)
            ->subject($dto->subject)
            ->html($dto->body);

        if ($dto->pathToFile !== null) {
            $email->addPart(new DataPart(new File($dto->pathToFile)));
        }

        $this->mailer->send($email);
    }
}
