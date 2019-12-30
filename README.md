Command to run commission fee calculation:
composer calculate-commissions path/to/operations/file.csv

In order to demonstrate how the systems runs I provide a test.csv file 
in tests folder of this project, so if you want to run the system, you type the following command in your terminal (1 - Linux, 2 - Windows):
1) composer calculate-commissions wherever/you/clone/the/project/Commission/tests/test.csv
2) composer calculate-commissions wherever\you\clone\the\project\Commission\tests\test.csv

In order to run the tests:
composer phpunit - all the phpunit tests
composer test-cs - for php-cs-fixer checks
composer test - for both phpunit and php-cs-fixer

At the moment only phpunit tests pass. If you give me some more time, I will check the code syntax in order to fix the php-cs-fixer checks.

It was fun doing your task, hope you like the solution I came up with :)
