<?php
namespace SauceDemo\Tests;

use SauceDemo\Pages\LoginPage;
use SauceDemo\Pages\ProductsPage;

class SauceDemoTest extends BaseTest {

    public function testLoginAndAddToCart() {
        $loginPage = new LoginPage($this->driver);
        $productsPage = new ProductsPage($this->driver);

        $loginPage->open();
        $loginPage->login("standard_user", "secret_sauce");

        $titles = $productsPage->getAllProductTitles();
        // PHPUnit Assertion: Validamos que el array de títulos sea mayor a 0
        $this->assertGreaterThan(0, count($titles), "FALLO: No se encontraron productos en la lista.");

        $productsPage->addFirstProductToCart();

        $currentCount = $productsPage->getCartCount();
        $this->assertEquals("1", $currentCount, "FALLO: El contador del carrito no muestra 1.");
    }
}
