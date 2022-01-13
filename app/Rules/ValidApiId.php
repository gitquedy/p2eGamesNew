<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;

class ValidApiId implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $client = new CoinGeckoClient();
        $data = $client->coins()->getList();
        $ids = array_column($data, 'id');
        return in_array($value, $ids);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid CoinGecko API id.';
    }
}
