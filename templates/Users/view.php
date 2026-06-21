<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->full_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Full Name') ?></th>
                    <td><?= h($user->full_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Matric No') ?></th>
                    <td><?= h($user->matric_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone No') ?></th>
                    <td><?= h($user->phone_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($user->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($user->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($user->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified At') ?></th>
                    <td><?= h($user->modified_at) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Applications') ?></h4>
                <?php if (!empty($user->applications)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Cgpa') ?></th>
                            <th><?= __('Achievement') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Modified At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->applications as $applications) : ?>
                        <tr>
                            <td><?= h($applications->id) ?></td>
                            <td><?= h($applications->user_id) ?></td>
                            <td><?= h($applications->cgpa) ?></td>
                            <td><?= h($applications->achievement) ?></td>
                            <td><?= h($applications->status) ?></td>
                            <td><?= h($applications->created_at) ?></td>
                            <td><?= h($applications->modified_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Applications', 'action' => 'view', $applications->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Applications', 'action' => 'edit', $applications->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Applications', 'action' => 'delete', $applications->id], ['confirm' => __('Are you sure you want to delete # {0}?', $applications->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Orders') ?></h4>
                <?php if (!empty($user->orders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Product Id') ?></th>
                            <th><?= __('Size') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Shipping Address') ?></th>
                            <th><?= __('Total Price') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Modified At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->orders as $orders) : ?>
                        <tr>
                            <td><?= h($orders->id) ?></td>
                            <td><?= h($orders->user_id) ?></td>
                            <td><?= h($orders->product_id) ?></td>
                            <td><?= h($orders->size) ?></td>
                            <td><?= h($orders->quantity) ?></td>
                            <td><?= h($orders->shipping_address) ?></td>
                            <td><?= h($orders->total_price) ?></td>
                            <td><?= h($orders->status) ?></td>
                            <td><?= h($orders->created_at) ?></td>
                            <td><?= h($orders->modified_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Reviews') ?></h4>
                <?php if (!empty($user->reviews)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Comment') ?></th>
                            <th><?= __('Rating') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Modified At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->reviews as $reviews) : ?>
                        <tr>
                            <td><?= h($reviews->id) ?></td>
                            <td><?= h($reviews->user_id) ?></td>
                            <td><?= h($reviews->comment) ?></td>
                            <td><?= h($reviews->rating) ?></td>
                            <td><?= h($reviews->status) ?></td>
                            <td><?= h($reviews->created_at) ?></td>
                            <td><?= h($reviews->modified_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Reviews', 'action' => 'view', $reviews->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Reviews', 'action' => 'edit', $reviews->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Reviews', 'action' => 'delete', $reviews->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reviews->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
