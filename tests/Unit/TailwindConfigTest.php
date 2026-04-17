<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TailwindConfigTest extends TestCase
{
    private $projectRoot;

    protected function setUp()
    {
        parent::setUp();
        $this->projectRoot = dirname(dirname(__DIR__));
    }

    /**
     * Test that tailwind.config.js exists and has proper content paths
     *
     * @return void
     */
    public function testTailwindConfigExists()
    {
        $configPath = $this->projectRoot . '/tailwind.config.js';
        $this->assertFileExists($configPath, 'tailwind.config.js should exist in project root');

        $content = file_get_contents($configPath);

        // Check for proper content paths
        $this->assertContains('./resources/**/*.blade.php', $content, 'Should include Blade template paths');
        $this->assertContains('./resources/**/*.vue', $content, 'Should include Vue component paths');
        $this->assertContains('./resources/**/*.js', $content, 'Should include JavaScript paths');
        $this->assertContains('./app/**/*.php', $content, 'Should include app PHP files');
    }

    /**
     * Test that resources/css/app.css exists and contains Tailwind directives
     *
     * @return void
     */
    public function testTailwindCssExists()
    {
        $cssPath = $this->projectRoot . '/resources/css/app.css';
        $this->assertFileExists($cssPath, 'resources/css/app.css should exist');

        $content = file_get_contents($cssPath);

        // Check for Tailwind directives
        $this->assertContains('@tailwind base;', $content, 'Should contain @tailwind base directive');
        $this->assertContains('@tailwind components;', $content, 'Should contain @tailwind components directive');
        $this->assertContains('@tailwind utilities;', $content, 'Should contain @tailwind utilities directive');
    }

    /**
     * Test that SCSS file properly imports the new CSS structure
     *
     * @return void
     */
    public function testScssImportsStructure()
    {
        $scssPath = $this->projectRoot . '/resources/assets/sass/app.scss';
        $this->assertFileExists($scssPath, 'resources/assets/sass/app.scss should exist');

        $content = file_get_contents($scssPath);

        // Check that it imports the new CSS structure
        $this->assertContains('@import "../css/app.css";', $content, 'Should import the new Tailwind CSS structure');

        // Ensure original imports are still present
        $this->assertContains('@import "variables";', $content, 'Should still import variables');
        $this->assertContains('~bootstrap-sass/assets/stylesheets/bootstrap', $content, 'Should still import Bootstrap');
    }

    /**
     * Test that resources/css directory exists
     *
     * @return void
     */
    public function testCssDirectoryExists()
    {
        $cssDir = $this->projectRoot . '/resources/css';
        $this->assertDirectoryExists($cssDir, 'resources/css directory should exist');
    }
}