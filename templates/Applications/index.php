<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Application> $applications
 */
?>
<div class="applications index content">
    <?= $this->Html->link(__('New Application'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Applications') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('cgpa') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('modified_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                <tr>
                    <td><?= $this->Number->format($application->id) ?></td>
                    <td><?= $application->has('user') ? $this->Html->link($application->user->full_name, ['controller' => 'Users', 'action' => 'view', $application->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($application->cgpa) ?></td>
                    <td><?= h($application->status) ?></td>
                    <td><?= h($application->created_at) ?></td>
                    <td><?= h($application->modified_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $application->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $application->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $application->id], ['confirm' => __('Are you sure you want to delete # {0}?', $application->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
