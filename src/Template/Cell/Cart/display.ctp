Session ID: <?php echo $this->request->getSession()->id(); ?><br>
Cart ID: <?php echo $this->getRequest()->getSession()->read('Cart.id'); ?>
<br>Cart summary: <?php echo $this->Number->currency($summary); ?>