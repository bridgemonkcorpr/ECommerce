<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class MenuItem extends Model
{
    use HasFactory;
    use HasRecursiveRelationships;

    protected $attributes = [
        'order' => 0,
    ];

    protected $fillable = [
        'menu_id',
        'parent_id',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    
public function scopeTreeOf(Builder $query, callable $callback)
    {
        // Start the recursive CTE
        $cteQuery = MenuItem::from('menu_items')
            ->selectRaw('menu_items.*, 0 as depth, CAST(menu_items.id AS CHAR(65535)) as path')
            ->whereNull('parent_id')
            ->where($callback);

        // Recursive part of the query
        $recursiveQuery = MenuItem::selectRaw('menu_items.*, laravel_cte.depth + 1 as depth, CONCAT(laravel_cte.path, ".", menu_items.id) as path')
            ->join('laravel_cte', 'laravel_cte.id', '=', 'menu_items.parent_id');

        // Combining both queries using a recursive CTE
        $finalQuery = MenuItem::query()
            ->withRecursiveExpression('laravel_cte', $cteQuery->unionAll($recursiveQuery))
            ->from('laravel_cte');

        return $finalQuery;
    }
    
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public static function toTree(Collection $menuItems)
    {
        $items = $menuItems->keyBy('id');

        foreach ($items as $item) {
            if ($item->parent_id && isset($items[$item->parent_id])) {
                $parent = $items[$item->parent_id];
                $parent->setRelation('children', $parent->children ?? collect());
                $parent->children->push($item);
            }
        }

        return $items->whereNull('parent_id')->values();
    }
}
