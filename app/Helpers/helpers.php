<?php

if (!function_exists('calculateSaleTotal')) {
    function calculateSaleTotal(array $itemsData): float
    {
        $total = 0;

        foreach ($itemsData as $item) {
            $subtotal = ($item['quantity'] * $item['price']) - $item['discount'];
            $total += $subtotal;
        }

        return $total;
    }
}
