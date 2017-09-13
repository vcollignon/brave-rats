<?php

declare(strict_types = 1);

namespace BraveRats\Console;

use BraveRats\Card;
use BraveRats\Game;
use BraveRats\Player;
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
            $player1 = $this->game->getPlayer1();
            $chosenCardPlayer1 = $this->askCurrentPlayerCard($player1, $input, $output);

            $player2 = $this->game->getPlayer2();
            $chosenCardPlayer2 = $this->askCurrentPlayerCard($player2, $input, $output);

            $this->game->playRound($chosenCardPlayer1, $chosenCardPlayer2);
        }
    }

    private function askCurrentPlayerCard(Player $player, InputInterface $input, OutputInterface $output): Card
    {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            $player->getName().' : Which card do you want to play ?',
            $player->getRemainingCards()->toLabelArray(),
            0
        );
        $question->setErrorMessage('Invalid card');

        $chosenCardLabel = $helper->ask($input, $output, $question);
        $output->writeln('You have just selected: ' . $chosenCardLabel);

        return Card::fromLabel($chosenCardLabel);
    }
}
