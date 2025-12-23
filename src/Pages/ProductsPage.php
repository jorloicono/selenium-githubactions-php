<? php
namespace SauceDemo\Pages;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ProductsPage {
    private $driver;
    private $productTitles;
    private $addToCartButton;
    private $cartBadge;

    public function __construct(WebDriver $driver) {
        $this->driver = $driver;
        $this->productTitles = WebDriverBy::className("inventory_item_name");      
        $this->addToCartButton = WebDriverBy::xpath("(//button[contains(@id,'add-to-cart')])[1]");
        $this->cartBadge = WebDriverBy:: className("shopping_cart_badge");
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
        // Esperar hasta que el badge del carrito sea visible (máximo 10 segundos)
        $wait = new WebDriverWait($this->driver, 10);
        $cartBadgeElement = $wait->until(
            WebDriverExpectedCondition::visibilityOfElementLocated($this->cartBadge)
        );
        
        return $cartBadgeElement->getText();
    }
}
