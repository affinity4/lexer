<?php
/**
 * This file is part of lexer.
 *
 * (c) 2017 Luke Watts <luke@affinity4.ie>
 *
 * This software is licensed under the MIT license. For the
 * full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Affinity4\Lexer\Test;

use Affinity4\Lexer\Lexer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class LexerTest extends TestCase
{
    private $lexer;
    
    public function setUp()
    {
        $rules = Yaml::parse(file_get_contents(__DIR__ . '/rules.yml'));
        $this->lexer = new Lexer($rules, "t");
    }
    
    public function testPrefix()
    {
        $prefix = $this->lexer->getPrefix();
        
        self::assertEquals("T_", $prefix);
    }
    
    /**
     * @depends testPrefix
     */
    public function testRules()
    {
        $rules = $this->lexer->getRules();
        
        self::assertInternalType('array', $rules);
        self::assertEquals(['token' => "T_SPACE", "pattern" => "~( )~"], $rules[0]);
    }
    
    public function testSetSourceGetSource()
    {
        $file = __DIR__ . '/source.sacss';
        
        self::assertInstanceOf("Affinity4\\Lexer\\Lexer", $this->lexer->setSource($file));
        
        if ($this->lexer->setSource($file) instanceof Lexer)
            self::assertEquals(file_get_contents($file), $this->lexer->setSource($file)->getSource());
    }
}
