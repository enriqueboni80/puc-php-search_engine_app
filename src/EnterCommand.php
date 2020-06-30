<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Engine\Wikipedia\WikipediaEngine;
use App\Engine\Wikipedia\WikipediaParser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Helper\Table;


class EnterCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('search')
            ->addArgument('termo');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = $input->getArgument('termo');
        $wikipedia = new WikipediaEngine(new WikipediaParser(), HttpClient::create());
        $results = $wikipedia->search($text);
        $row = array();
        foreach ($results->getItems() as $key => $value) {
            array_push($row, [$value->getTitle(), $value->getPreview()."..."]);
        };

        $table = new Table($output);
        $table
            ->setHeaders(['Title', 'Preview'])
            ->setRows($row)
        ;
        $output->writeln($results->count() . " results was found form term ".$text." on wikipedia");
        $output->writeln("showing ".$results->countItemsOnPage()." first results");
        $table->render();
        return 0;
    }
}
