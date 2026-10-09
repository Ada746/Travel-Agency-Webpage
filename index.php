<?php
require_once 'config.php';
require_once 'models/travel.php';
require_once 'models/cart.php';

$action = $_GET['action'] ?? 'list';
$error = '';
$success = '';

switch ($action) {
    case 'list':
        $category = $_GET['category'] ?? null;
        $travels = getTravels($conn, $category);
        $categories = getCategories($conn);
        require 'views/list.php';
        break;
    case 'detail':
        $id = intval($_GET['id'] ?? 0);
        $travel = getTravelById($conn, $id);
        if (!$travel) {
            header("Location: index.php");
            exit;
        }
        $images = explode(",", $travel['images']);
        require 'views/detail.php';
        break;
    case 'add_to_cart':
        $id = intval($_POST['id'] ?? 0);
        $date_start = trim($_POST['date_start'] ?? '');
        $date_end = trim($_POST['date_end'] ?? '');

        if (empty($date_start) || empty($date_end)) {
            $error = "All date fields are mandatory!";
            $travel = getTravelById($conn, $id);
            $images = explode(",", $travel['images']);
            require 'views/detail.php';
            exit;
        }

        if (strtotime($date_start) < strtotime(date('Y-m-d'))) {
            $error = "The departure date cannot be in the past!";
            $travel = getTravelById($conn, $id);
            $images = explode(",", $travel['images']);
            require 'views/detail.php';
            exit;
        }

        if (strtotime($date_end) < strtotime($date_start)) {
            $error = "The return date cannot be before the departure date!";
            $travel = getTravelById($conn, $id);
            $images = explode(",", $travel['images']);
            require 'views/detail.php';
            exit;
        }

        $travel = getTravelById($conn, $id);
        addToCart($travel, $date_start, $date_end);
        header("Location: index.php?action=cart");
        exit;
    case 'cart':
        $cartItems = allTravelsInCart();
        $total = getCartTotal();
        require 'views/cart.php';
        break;

    case 'pay':
        if (!empty(allTravelsInCart())) {
            clearCart();
            $success = "The payment was made successfully. Your reservation is confirmed. Thank you for your purchase.";
        }
        $cartItems = [];
        $total = 0;
        require 'views/cart.php';
        break;

    default:
        header("Location: index.php");
        break;
}
