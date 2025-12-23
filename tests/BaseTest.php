<?php
namespace SauceDemo\Tests;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;

class BaseTest extends TestCase {
    protected $driver;

    // Se ejecuta ANTES de cada prueba (@BeforeEach en Java)
    protected function setUp(): void {
        // Configuramos Chrome para entornos de servidor (CI/CD)
        $options = new ChromeOptions();
        
        $options->addArguments(['--headless=new', '--no-sandbox', '--disable-dev-shm-usage', '--window-size=1920,1080']);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        // Conectamos al puerto 4444. En Java, WebDriverManager lo hace solo. 
        // En PHP/CI, levantaremos el servidor manualmente en el workflow (veremos esto al final).
        $this->driver = RemoteWebDriver::create('http://localhost:4444/', $capabilities);
    
        $this->driver->manage()->timeouts()->implicitlyWait(10);
    }

    // Se ejecuta DESPUÉS de cada prueba (@AfterEach en Java)
    protected function tearDown(): void {
        if ($this->driver) {
            // Si el test falla, queremos ver qué pasó.
            $testName = $this->name();
            $timestamp = date('Ymd_His');
            $screenshotDir = 'target/screenshots';

            // Crear carpeta si no existe
            if (!is_dir($screenshotDir)) {
                mkdir($screenshotDir, 0777, true);
            }

            try {
                // Guardar la imagen con el nombre del test y la hora
                $this->driver->takeScreenshot("$screenshotDir/{$testName}_{$timestamp}.png");
            } catch (\Exception $e) {
                // Si falla la captura, no rompemos el test, solo lo ignoramos
            }
          
            $this->driver->quit();
        }
    }
}
