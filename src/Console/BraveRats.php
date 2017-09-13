<?php

declare(strict_types = 1);

namespace BraveRats\Console;

use BraveRats\Card;
use BraveRats\Game;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class BraveRats extends Command
{
    private
        $game;

    public function __construct()
    {
        parent::__construct();

        $this->game = new Game();
    }

    protected function configure()
    {
        $this->setName('game:play')
            ->setDescription('Launch BraveRats');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        while(true)
        {
            $chosenCard = $this->askCurrentPlayerCard($input, $output);
        }
    }

    private function askCurrentPlayerCard(InputInterface $input, OutputInterface $output): Card
    {
        $currentPlayer = $this->game->getCurrentPlayer();

        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Which card do you want to play ?',
            $currentPlayer->getRemainingCards()->toLabelArray(),
            0
        );
        $question->setErrorMessage('Invalid card');

        $chosenCardLabel = $helper->ask($input, $output, $question);
        $output->writeln('You have just selected: ' . $chosenCardLabel);

        return Card::fromLabel($chosenCardLabel);
    }
}
