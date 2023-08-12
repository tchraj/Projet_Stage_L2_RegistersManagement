<?php

namespace App\Command;

use App\Services\AppSendEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendNotificationCommand extends Command
{

    protected static $defaultName = 'app:sendnotification';

    protected static $defaultDescription = 'Envoyer les notifications par aux utilisateurs';

    private $entityManager;

    private $sendEmailService;

    public function __construct(
        EntityManagerInterface $entityManager,
        AppSendEmail $sendEmailService
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->sendEmailService = $sendEmailService;
    }

    protected function configure(): void
    {
        $this->setHelp('Envoyer les notifications par aux utilisateurs');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sendEmail = $this->sendEmailService->sendUnique(
            'amanarodia@gmail.com',
            'me.elomapezoumon@gmail.com,t.apezoumonafanou@orabank.net',
            'MESSAGE OBJET TEST RAJAA',
            'MESSAGE CONTENU TEST RAJAA',
            'alert.html.twig'
        );
        return 0;
    }
}
