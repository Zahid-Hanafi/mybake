<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Orders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orders form content">
            <?= $this->Form->create($order) ?>
            <fieldset>
                <legend><?= __('Add Order') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('product_id', ['options' => $products]);
                    echo $this->Form->control('size');
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('shipping_address');
                    echo $this->Form->control('total_price');
                    echo $this->Form->control('status');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('modified_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
