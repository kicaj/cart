<?php
namespace Cart\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cart\Model\Table\CustomerAddressesTable;

/**
 * Cart\Model\Table\CustomerAddressesTable Test Case
 */
class CustomerAddressesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Cart\Model\Table\CustomerAddressesTable
     */
    public $CustomerAddresses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Cart.CustomerAddresses',
        'plugin.Cart.Carts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CustomerAddresses') ? [] : ['className' => CustomerAddressesTable::class];
        $this->CustomerAddresses = TableRegistry::getTableLocator()->get('CustomerAddresses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerAddresses);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
