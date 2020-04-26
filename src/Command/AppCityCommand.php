<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppCityCommand extends Command
{
    protected static $defaultName = 'app:city';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->note($this->createCityWeb());

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }

    public function createCityWeb()
    {
        $cityData = json_decode(file_get_contents(__DIR__.'/../Resources/data/city/citylist.json'),true);//加参数得到数组

        $cities = 0 ;
        foreach ($cityData as $code => $name){

            //省、直辖市级别的处理方式
            if(substr($code,4) == 00)
            {

                $cities++;

                file_put_contents(__DIR__.'/../../public/keywords.txt',$name."网站制作公司,\n".$name."小程序制作公司,\n",FILE_APPEND);
            }

        }

        return $cities;
    }
}
