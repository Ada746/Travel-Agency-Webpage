<?php

//manages the cart through $_SESSION

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

function addToCart($travel, $date_start, $date_end) {
    $d1 = new DateTime($date_start);
    $d2 = new DateTime($date_end);
    $diff = $d1->diff($d2);
    $days = max(1, $diff->days);

    $total_item_price = $days * $travel['daily_price'];

    $_SESSION['cart'][] = [
        'id'          => $travel['id'],
        'title'       => $travel['title'],
        'destination' => $travel['destination'],
        'daily_price' => $travel['daily_price'],
        'date_start'  => $date_start,
        'date_end'    => $date_end,
        'days'        => $days,
        'total_price' => $total_item_price
    ];
}

function allTravelsInCart() {
    return $_SESSION['cart'] ?? [];
}

function getCartTotal() {
    $total = 0;
    foreach (allTravelsInCart() as $item) {
        $total += $item['total_price'];
    }
    return $total;
}

function clearCart(){
    $_SESSION['cart'] = [];
}