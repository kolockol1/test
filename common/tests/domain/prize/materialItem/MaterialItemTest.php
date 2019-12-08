<?php

namespace common\test\domain\prize\materialItem;

use common\domain\prize\materialItem\MaterialItem;
use common\exception\ExceptionCodes;
use common\models\User;
use common\test\MockGenerator;
use DeepCopy\Reflection\ReflectionHelper;
use PHPUnit\Framework\TestCase;

class MaterialItemTest extends TestCase
{
    /**
     * @var User|\PHPUnit\Framework\MockObject\MockObject
     */
    private $identity;
    /**
     * @var MockGenerator
     */
    private $mockGenerator;

    protected function setUp()
    {
        parent::setUp();
        $this->identity = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $this->mockGenerator = new MockGenerator();
    }

    public function fromStorageDataProvider()
    {
        return [
            'model, saved previously' => [
                'id' => 11,
                'materialItemId' => 55,
                'name' => 'test',
                'status' => 0,
                'expectedId' => 11,
                'expectedDescription' => 'Material Item as prize with name #test',
                'expectedMaterialItemId' => 55,
            ],
        ];
    }

    /**
     * @dataProvider fromStorageDataProvider
     * @param int|null $id
     * @param int $materialItemId
     * @param string $name
     * @param int $status
     * @param int|null $expectedId
     * @param string $expectedDescription
     * @param int $expectedMaterialItemId
     * @throws \DeepCopy\Exception\PropertyException
     * @throws \ReflectionException
     */
    public function testFromStorage(
        int $id,
        int $materialItemId,
        string $name,
        int $status,
        int $expectedId,
        string $expectedDescription,
        int $expectedMaterialItemId
    ) {
        $userPrizeModel = $this->mockGenerator->userPrizesModel(1, $id, 3);
        $materialItemModel = $this->mockGenerator->materialItemsModel($materialItemId, $name, $status);

        $prize = MaterialItem::fromStorage($this->identity, $userPrizeModel, $materialItemModel);

        $this->assertEquals(1, $prize->getAmount());
        $this->assertEquals($expectedDescription, $prize->getDescription());

        $reflectionPropertyId = ReflectionHelper::getProperty($prize, 'id');
        $reflectionPropertyId->setAccessible(true);
        $this->assertEquals($expectedId, $reflectionPropertyId->getValue($prize));

        $reflectionPropertyMaterialItemId = ReflectionHelper::getProperty($prize, 'materialItemId');
        $reflectionPropertyMaterialItemId->setAccessible(true);
        $this->assertEquals($expectedMaterialItemId, $reflectionPropertyMaterialItemId->getValue($prize));

    }

    public function testFromStorageWithExceptionInvalidType()
    {
        $model = $this->mockGenerator->userPrizesModel(1, 1, 2); //wrong type  for MaterialItem

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(ExceptionCodes::INVALID_TYPE_FOR_PRIZE);
        MaterialItem::fromStorage($this->identity, $model);
    }

    public function testFromStorageWithExceptionUndefiedMaterialItemModel()
    {
        $model = $this->mockGenerator->userPrizesModel(1, 1, 3); //wrong type  for MaterialItem

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(ExceptionCodes::MATERIAL_ITEM_MODEL_MUST_BE_DEFINED);
        MaterialItem::fromStorage($this->identity, $model);
    }
}