<?php
namespace SauceDemo\Pages;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;

class LoginPage {
    private $driver;
    private $usernameField;
    private $passwordField;
    private $loginButton;

    public function __construct(WebDriver $driver) {
        $this->driver = $driver;
        // Localizadores por ID
        $this->usernameField = WebDriverBy::id("user-name");
        $this->passwordField = WebDriverBy::id("password");
        $this->loginButton = WebDriverBy::id("login-button");
    }

    public function open() {
        $this->driver->get("https://www.saucedemo.com/");
    }

    public function login($username, $password) {
        $this->driver->findElement($this->usernameField)->clear(); // Limpieza por seguridad
        $this->driver->findElement($this->usernameField)->sendKeys($username);
        $this->driver->findElement($this->passwordField)->sendKeys($password);
        $this->driver->findElement($this->loginButton)->click();
    }
}
