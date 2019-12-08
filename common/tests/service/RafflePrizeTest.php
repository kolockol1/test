<?php

namespace common\tests\service;

use common\models\User;
use common\repository\MoneyDatabaseRepository;
use common\service\RafflePrize;
use PHPUnit\Framework\TestCase;

class RafflePrizeTest extends TestCase
{
    /**
     * @var User|\PHPUnit\Framework\MockObject\MockObject
     */
    private $identity;

    protected function setUp()
    {
        parent::setUp();
        $this->identity = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
    }

    public function testGenerate()
    {
        $rafflePrize = new RafflePrize(new MoneyDatabaseRepository());
        $prize = $rafflePrize->generate($this->identity);
        $this->assertTrue($prize->getAmount() >= 1 && $prize->getAmount() <= 20);
    }


}
