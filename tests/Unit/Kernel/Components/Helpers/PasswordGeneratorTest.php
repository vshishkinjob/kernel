<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Helpers;

use Codeception\Test\Unit;
use Kernel\Components\Helpers\PasswordGenerator;

class PasswordGeneratorTest extends Unit
{
    public function testExactlyTest()
    {
        $generator = new PasswordGenerator();
        $this->assertTrue(strlen($generator->generate(exactly: 10)->password) === 10);
    }

    public function testDefaultGeneratedPasswordShouldHaveUppercaseNumberSpecialCharAndLimitedWithLengthTest()
    {
        $generator = new PasswordGenerator();
        for ($i=0; $i<1000; $i++) {
            $password = $generator->generate(minLength: 7, maxLength: 8);
            if (strlen($password->password) < 7 || strlen($password->password) > 8) {
                $this->fail('Min and max in password generator do not work');
            }

            $digits = [0,1,2,3,4,5,6,7,8,9];
            $upperCase = str_split(strtoupper('abcdefghijklmnopqrstuvwxyz'));
            $specials = str_split('()@#.,:;?!*+%@[]_{}$#');

            $passwordSplit = str_split($password->password);
            if (
                empty(array_intersect($passwordSplit, $digits))
                || empty(array_intersect($passwordSplit, $upperCase))
                || empty(array_intersect($passwordSplit, $specials))
            ) {
                $this->fail('At least on upper case, one digit and one special');
            }
        }
    }
}