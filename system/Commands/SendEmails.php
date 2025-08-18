<?php
// namespace App\Commands;

// use CodeIgniter\CLI\BaseCommand;
// use CodeIgniter\CLI\CLI;
// use App\Models\EmailQueueModel;

// class SendEmails extends BaseCommand
// {
//     protected $group       = 'Custom';
//     protected $name        = 'emails:send';
//     protected $description = 'Send pending emails from the email_queue table.';

//     public function run(array $params)
//     {
//         $emailQueue = new EmailQueueModel();
//         $pending = $emailQueue->where('status', 'pending')->findAll(10); // batch of 10

//         if (empty($pending)) {
//             CLI::write("No pending emails.", 'yellow');
//             return;
//         }

//         $email = \Config\Services::email();

//         foreach ($pending as $mail) {
//             $email->setTo($mail['to_email']);
//             $email->setSubject($mail['subject']);
//             $email->setMessage($mail['message']);

//             if ($email->send()) {
//                 $emailQueue->update($mail['id'], [
//                     'status'  => 'sent',
//                     'sent_at' => date('Y-m-d H:i:s')
//                 ]);
//                 CLI::write("Sent to {$mail['to_email']}", 'green');
//             } else {
//                 $emailQueue->update($mail['id'], ['status' => 'failed']);
//                 CLI::write("Failed: {$mail['to_email']}", 'red');
//             }

//             $email->clear();
//         }
//     }
// }
