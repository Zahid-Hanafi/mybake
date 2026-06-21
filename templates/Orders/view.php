<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order'), ['action' => 'edit', $order->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Orders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orders view content">
            <h3><?= h($order->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $order->has('user') ? $this->Html->link($order->user->full_name, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $order->has('product') ? $this->Html->link($order->product->name, ['controller' => 'Products', 'action' => 'view', $order->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Size') ?></th>
                    <td><?= h($order->size) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($order->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($order->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($order->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Price') ?></th>
                    <td><?= $this->Number->format($order->total_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($order->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified At') ?></th>
                    <td><?= h($order->modified_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Shipping Address') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($order->shipping_address)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
