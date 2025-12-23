<?php
namespace SauceDemo\Tests;

use SauceDemo\Pages\LoginPage;
use SauceDemo\Pages\ProductsPage;

class LoginWithPOMTest extends BaseTest
{
    private string $username = 'standard_user';
    private string $password = 'secret_sauce';

    public function validLogin(): void
    {
        $this->setUp();
        try {
            $this->loginPage->openLoginPage();
            $this->loginPage->enterUserName($this->username);
            $this->loginPage->enterPassWord($this->password);
            $this->loginPage->clickOnLogin();

            $this->productsPage->checkProductsPageOpened();
            echo "✓ validLogin PASADO\n";
        } catch (\Throwable $e) {
            echo "✗ validLogin FALLÓ: " . $e->getMessage() . "\n";
        } finally {
            $this->tearDown();
        }
    }
}

// Ejecutar “test” a mano:
$test = new LoginWithPOMTest();
$test->validLogin();
