<?php

namespace App\Models\Back\Catalog\Option;

use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Catalog\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OptionProduct extends Model
{

    /**
     * @var string
     */
    protected $table = 'option_to_product';


    /**
     * @param int   $option_id
     * @param array $apartments
     *
     * @return bool
     */
    public static function populate(int $option_id, array $apartments): bool
    {
        self::query()->where('option_id', $option_id)->delete();

        foreach ($apartments as $apartment) {
            if ($apartment != 'all') {
                self::insert([
                    'option_id' => $option_id,
                    'product_id' => $apartment
                ]);

            } else {
                $ids = Product::query()->pluck('id');

                foreach ($ids as $id) {
                    self::insert([
                        'option_id' => $option_id,
                        'product_id' => $id
                    ]);
                }
            }
        }

        return true;
    }
}
