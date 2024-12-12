<?php

namespace App\Actions;

class GenerateProductVariant
{
    /**
     * Generate product variation based on inputs
     * @param  array  $input
     * @return array
     */
    public static function handle(array $input): array
    {
        if (! count($input)) return []; // Agar input array khali hai to empty array return karega.

        $result = [[]]; // Ek empty array se shuru karta hai as the initial Cartesian product.

        foreach ($input as $key => $values) { // Har array ko input se loop karega.
            $append = []; // Temporary array banata hai nayi combinations ko store karne ke liye.

            foreach ($values as $value) { // Current array ke har value ko loop karega.
                foreach ($result as $data) { // Pehle se bani combinations ke saath naye values ko add karega.
                    $append[] = $data + [$key => $value]; // Nayi value ko combination ke saath jodta hai.
                }
            }

            $result = $append; // Final result ko update karega naye combinations ke saath.
        }

        return $result; // Sab combinations return karega.
    }

}
