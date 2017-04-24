FloPoker
========

A Symfony project created by [Nick Schirmer](n@ichol.as) as a tech demonstration for FloSports in April 2017.

# Setup

1. Install dependencies: `composer install`
2. Configure your database: `vi app/config/parameters.yml`
3. To run Homestead on Vagrant:
    ```
    php vendor/bin/homestead make
    vagrant up
    ```
4. Initialize database: `php bin/console doctrine:schema:update --force`

# Initial Requirements

* All players will be able to enter their names into a form
* Once the start button is pressed the game begins
* Each player should have N cards. N should be configurable but cannot exceed 5
* Support the concept of a “turn”, upon which each player can “bet” a certain amount
* Once all the players have had their turn to bet, render each player’s hand on the UI for everyone to see
* The highest hand of cards will win the game and receive the total amount, which is the sum of every player’s bet amount
* You may derive the rules for ranking hands here to determine the winner
* Maintain a leader-board showing the hands of each player, their respective bet amount and who won each game

# Unit Testing
The included PlayingCardBundle has 100% code coverage as a demonstration of unit testing.

`vendor/bin/phpunit src/PlayingCardBundle --coverage-html=code-coverage`

_The `code-coverage` directory is already included in `.gitignore`_

# Additional credit
Thanks to [subskybox](https://www.codeproject.com/articles/569271/a-poker-hand-analyzer-in-javascript-using-bit-math) 
for the wonderful 5-card Poker Scoring algorithm which was utilized in this project and adapted to work with 
3-card and 4-card Poker hands.