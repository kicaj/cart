# Cart plugin for CakePHP

**NOTE:** It's still in development mode, do not use in production yet!

## Requirements

It is developed for CakePHP min. 3.7.

## Installation

You can install plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:
```
composer require kicaj/cart dev-master
```

### Load the Plugin

Ensure the Cart plugin is loaded in your src/Application.php file
```
$this->addPlugin('Cart');
```

or add manually by `cake` command
```
cake plugin load Cart
```

### Configuration

Firstly, use Migrations plugin to create tables in your database.

```
cake migrations migrate -p Cart
```

Now, if everything is correct, You can open URL with fragment `/cart/carts` and You should see "Cart is empty".

Next, You should set global association to work with your products with Cart plugin.
```
// AppController::initialize()
public function initialize()
{
    parent::initialize();
        
    // ...
        
    // Cart relations.
    $this->loadModel('Cart.Carts');
        
    $this->Carts->CartItems->addAssociations([
        'belongsTo' => [
            'CartItemProducts' => [
                'className' => 'Products', // Class name of existing table of your products
                'type' => 'INNER',
                'foreignKey' => 'identifier',
                'bindingKey' => 'sku', // Unique key for your product (eg. SKU number)
            ],
        ],
    ]);
}   
```

That's all!
