<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Program> $programs
 */
?>
<div class="programs index content">
    <?= $this->Html->link(__('New Program'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Programs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('venue') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('google_event_id') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('modified_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programs as $program): ?>
                <tr>
                    <td><?= $this->Number->format($program->id) ?></td>
                    <td><?= h($program->name) ?></td>
                    <td><?= h($program->venue) ?></td>
                    <td><?= h($program->date) ?></td>
                    <td><?= h($program->google_event_id) ?></td>
                    <td><?= $this->Number->format($program->created_by) ?></td>
                    <td><?= h($program->status) ?></td>
                    <td><?= h($program->created_at) ?></td>
                    <td><?= h($program->modified_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $program->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $program->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $program->id], ['confirm' => __('Are you sure you want to delete # {0}?', $program->id)]) ?>
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
