<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class Subtotal implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $sql = 'select p.id as id
        ,i.id as item_id
        ,ip.id as pivot_id
        ,i.price * ip.quantity as subtotal
        ,concat(c.first_name," ",c.last_name) as customer_name
        ,c.id as customer_id
        ,i.name as item_name
        ,i.price as item_price
        ,ip.quantity
        ,p.status
        ,p.created_at
        ,p.updated_at
        ,p.user_id as adviser_id
        ,u.name as adviser_name
        from purchases p
        left join item_purchase ip on p.id = ip.purchase_id
        left join items i on ip.item_id = i.id
        left join customers c on p.customer_id = c.id
        left join users u on p.user_id = u.id
        order by p.created_at desc
        ';
        $builder->fromSub($sql, 'order_subtotals');
    }
}
