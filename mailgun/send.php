<?php
# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-dfcaa7f400dc58f1820de9b2a7fbf3a6');
$domain = "sandboxff303db28e2e47a2b7d15c9a230517e6.mailgun.org";

# Make the call to the client.
$result = $mgClient->sendMessage("$domain",
                  array('from'    => 'Mailgun Sandbox <postmaster@sandboxff303db28e2e47a2b7d15c9a230517e6.mailgun.org>',
                        'to'      => 'malangsoftware <mailgun@malangsoftware.com>',
                        'subject' => 'Hello malangsoftware',
                        'text'    => 'Congratulations malangsoftware, you just sent an email with Mailgun!  You are truly awesome!  You can see a record of this email in your logs: https://mailgun.com/cp/log .  You can send up to 300 emails/day from this sandbox server.  Next, you should add your own domain so you can send 10,000 emails/month for free.'));