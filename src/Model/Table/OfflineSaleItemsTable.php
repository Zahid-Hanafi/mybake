<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class OfflineSaleItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('offline_sale_items');
        $this->setPrimaryKey('id');

        $this->belongsTo('OfflineSales', ['foreignKey' => 'offline_sale_id']);
        $this->belongsTo('Products',     ['foreignKey' => 'product_id']);
    }
}
