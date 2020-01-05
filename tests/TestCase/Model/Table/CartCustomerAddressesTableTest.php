<?php
namespace Cart\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cart\Model\Table\CartCustomerAddressesTable;

/**
 * Cart\Model\Table\CartCustomerAddressesTable Test Case
 */
class CartCustomerAddressesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Cart\Model\Table\CartCustomerAddressesTable
     */
    public $CartCustomerAddresses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Cart.CartCustomerAddresses',
        'plugin.Cart.Customers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CartCustomerAddresses') ? [] : ['className' => CartCustomerAddressesTable::class];
        $this->CartCustomerAddresses = TableRegistry::getTableLocator()->get('CartCustomerAddresses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CartCustomerAddresses);

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
