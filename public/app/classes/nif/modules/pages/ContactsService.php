<?php

declare(strict_types=1);

namespace nif\modules\pages;

use nif\exceptions\ValidationException;
use vakata\mail\driver\SenderInterface;
use vakata\mail\Mail;
use vakata\validation\Validator;

class ContactsService
{
    public function __construct(protected SenderInterface $sender)
    {
    }
    public function validator(array $data): array
    {
        $validator = new Validator();
        $validator
            ->required('name', 'contacts.name.required');
        $validator
            ->required('reason', 'contacts.reason.required');
        $validator
            ->required('email', 'contacts.email.required')
            ->mail('contacts.email.mail');
        return $validator->run($data);
    }
    public function sendMail(mixed $data, ?string $recipient, ?string $subject): void
    {
        if (isset($recipient) && isset($subject)) {
            $errors = $this->validator($data);
            if (count($errors)) {
                foreach ($errors as $k => $error) {
                    $errors[$error['message']] = $error['key'];
                    unset($errors[$k]);
                }
                throw (new ValidationException())
                    ->setErrors(
                        $errors
                    );
            }
            $mail = (new Mail($data['email'], $subject, $data['message']))
                ->setTo($recipient);
            $this->sender->send($mail);
        }
    }
}
