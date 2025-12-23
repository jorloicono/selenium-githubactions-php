<?php
namespace SauceDemo\Pages;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;

class ProductsPage {
    private $driver;
    private $productTitles;
    private $addToCartButton;
    private $cartBadge;

    public function __construct(WebDriver $driver) {
        $this->driver = $driver;
        $this->productTitles = WebDriverBy::className("inventory_item_name");      
        $this->addToCartButton = WebDriverBy::xpath("(//button[contains(@id,'add-to-cart')])[1]");
        $this->cartBadge = WebDriverBy::className("shopping_cart_badge");
    }

    // Obtener lista de textos de todos los productos
    public function getAllProductTitles() {
        $elements = $this->driver->findElements($this->productTitles);
        // Transformamos (mapeamos) la lista de Elementos Web a una lista de Textos (Strings)
        return array_map(function($element) {
            return $element->getText();
        }, $elements);
    }

    public function addFirstProductToCart() {
        $this->driver->findElement($this->addToCartButton)->click();
    }

    public function getCartCount() {
        return $this->driver->findElement($this->cartBadge)->getText();
    }
}
