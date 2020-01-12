Command to run commission fee calculation: <br/>
composer calculate-commissions path/to/operations/file.csv

In order to demonstrate how the systems runs I provide test.csv file 
in tests folder of this project, so if you want to run the system, you type the following command in your terminal (1 - Linux, 2 - Windows):
1) composer calculate-commissions wherever/you/clone/the/project/Commission/tests/test.csv
2) composer calculate-commissions wherever\you\clone\the\project\Commission\tests\test.csv

In order to run the tests: <br/>
composer phpunit - all the phpunit tests <br/>
composer test-cs - for php-cs-fixer checks <br/>
composer test - for both phpunit and php-cs-fixer <br/>

Both phpunit and cs-fixer tests pass.

It was fun doing your task, hope you like the solution I came up with :)
