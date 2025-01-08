<?php

namespace App\Jobs;

use CodeIgniter\Queue\BaseJob;
use CodeIgniter\Queue\Interfaces\JobInterface;

class Email extends BaseJob implements JobInterface
{
    public function process(): bool
    {
        log_message('info', 'Email job data: ' . json_encode($this->data));

        $emailService = service('email', null, false);

        $result = $emailService
            ->setTo($this->data['email'])
            ->setSubject($this->data['subject'])
            ->setMessage($this->data['message'])
            ->send(false);

        if (! $result) {
            log_message('error', 'Email failed: ' . $emailService->printDebugger('headers'));
            throw new \Exception($emailService->printDebugger('headers'));
        }

        log_message('info', 'Email sent successfully to: ' . $this->data['email']);

        return true;
    }
}
