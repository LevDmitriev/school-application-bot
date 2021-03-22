<?php

declare(strict_types = 1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Panther\Client;

class SchoolApplicationCommand extends Command
{
    protected static $defaultName = 'school-application:run';

    protected function configure()
    {
        $this->addArgument('url', InputArgument::REQUIRED, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ss = new SymfonyStyle($input, $output);
        $client = Client::createChromeClient(null, null, [], $input->getArgument('url'));
        $crawler = $client->request('GET', $input->getArgument('url'));
        $crawler->filter('[ng-options="item as item.name for item in municipalitiesList track by item.id"]')->click();
        $crawler->filter('option[label="г.о. Тольятти"]')->click();
        $crawler->filter('[ng-click="submitChoise(choisedMu)"]')->click();
        $client->waitForVisibility('form[name="applicant"]')
            ->filter('form[name="applicant"]')
            ->form(
                [
                    'LastName' => 'Малинский',
                    'FirstName' => 'Алексей',
                    'MiddleName' => 'Михайлович',
                    'ApplBirthdate' => '13.02.1984',
                    'relType' => 'object:10',
                    'Series' => '3604',
                    'Number' => '921818',
                    'Issued' => 'КОМСОМОЛЬСКИМ РУВД Г. ТОЛЬЯТТИ САМАРСКОЙ ОБЛ.',
                    'AppDocDate' => '25.05.2004',
                    'UnitCode' => '632-040',
                ]
            );
        $client->waitForVisibility('form[name="addrA"]')
            ->filter('form[name="addrA"]')
            ->form(
                [
                    'regARegion' => 'Самарская область',
                    'regACity' => 'Тольятти',
                    'regAStreet' => 'Матросова',
                    'regAHouse' => '15',
                    'regAFlat' => '170',
                    'resiARegion' => 'Самарская область',
                    'resiACity' => 'Тольятти',
                    'resiAStreet' => 'Матросова',
                    'resiAHouse' => '15',
                    'resiAFlat' => '170',
                ]
            )
        ;
        $client->waitForVisibility('form[name="child"]')
            ->filter('form[name="child"]')
            ->form(
                [
                    'childLastName' => 'Малинская',
                    'childFirstName' => 'Анастасия',
                    'childMiddleName' => 'Алексеевна',
                    'ChildBirthdate' => '05.12.2014',
                    'ChildDocSeries' => 'III-ЕР',
                    'ChildDocNumber' => '546381',
                    'ChildDocNumberIssued' => 'отдел ЗАГС Центрального района городского округа Тольятти управления ЗАГС Самарской области',
                    'ChildDocDate' => '17.12.2014',
                    'ChildActEntry ' => '12215',
                ]
            )
        ;
        $client->waitForVisibility('form[name="contactInfo"]')
            ->filter('form[name="contactInfo"]')
            ->form(
                [
                    'email' => 'malinsky@yandex.ru',
                    'phone' => '+79171336994',
                ]
            )
        ;

        while (true) {
        }
    }
}