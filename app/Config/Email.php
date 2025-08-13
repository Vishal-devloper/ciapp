<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    
    public string $fromEmail  = 'noreplyzem63@gmail.com';
    public string $fromName   = 'Zem e-commerce';
    public string $recipients = '';

    public string $userAgent  = 'CodeIgniter';

    // ✅ Use SMTP instead of PHP mail()
    public string $protocol   = 'smtp';

    public string $mailPath   = '/usr/sbin/sendmail';

    public string $SMTPHost   = 'smtp.gmail.com';
    public string $SMTPUser   = 'noreplyzem63@gmail.com';
    public string $SMTPPass   = 'owogixrgcziaebve'; // no spaces
    public int    $SMTPPort   = 587; // 465 if using ssl
    public int    $SMTPTimeout = 10;

    public bool   $SMTPKeepAlive = false;
    public string $SMTPCrypto    = 'tls'; // ssl if using port 465

    public bool   $wordWrap  = true;
    public int    $wrapChars = 76;

    // ✅ Use HTML so you can style verification emails
    public string $mailType  = 'html';

    public string $charset   = 'utf-8';
    public bool   $validate  = true;

    public int    $priority  = 3;
    public string $CRLF      = "\r\n";
    public string $newline   = "\r\n";

    public bool   $BCCBatchMode = false;
    public int    $BCCBatchSize = 200;
    public bool   $DSN          = false;
}
