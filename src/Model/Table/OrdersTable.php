<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('orders');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users',      ['foreignKey' => 'user_id']);
        $this->hasMany('OrderItems',   ['foreignKey' => 'order_id', 'dependent' => true]);
        $this->hasMany('OrderStatusLogs', ['foreignKey' => 'order_id', 'dependent' => true, 'sort' => ['OrderStatusLogs.created_at' => 'ASC']]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('delivery_address');
        $validator->notEmptyString('phone_no');
        $validator->decimal('total_amount');
        return $validator;
    }

    /**
     * Auto-complete orders that have been in 'shipping' status for 7+ days.
     * Called when admin loads the orders page.
     */
    public function autoCompleteShippedOrders(): int
    {
        $cutoff = new \Cake\I18n\FrozenTime('-7 days');
        $shippedOrders = $this->find()
            ->where([
                'status' => 'shipping',
                'shipped_at IS NOT' => null,
                'shipped_at <=' => $cutoff,
            ])
            ->all();

        $count = 0;
        $StatusLogs = \Cake\ORM\TableRegistry::getTableLocator()->get('OrderStatusLogs');
        foreach ($shippedOrders as $order) {
            $order->status = 'complete';
            $order->completed_at = new \Cake\I18n\FrozenTime();
            if ($this->save($order)) {
                $StatusLogs->save($StatusLogs->newEntity([
                    'order_id' => $order->id,
                    'status' => 'complete',
                    'note' => 'Auto-completed after 7 days of shipping',
                ]));
                $count++;
            }
        }
        return $count;
    }
}
