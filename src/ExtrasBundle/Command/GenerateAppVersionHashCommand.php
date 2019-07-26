<?php

namespace ExtrasBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateAppVersionHashCommand extends Command
{
    private $destination;

    /**
     * @param mixed $destination
     */
    public function setDestination($destination): void
    {
        $this->destination = $destination;
    }




    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('development:generate_app_version_hash');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {


        if (is_writable($this->destination)) {
            $key = md5(mt_rand(0, 100) . microtime());
            file_put_contents($this->destination . 'hash', $key);
            $output->write(sprintf('Generated key %s', $key));
        }

    }
}
