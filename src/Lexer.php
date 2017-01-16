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
namespace Affinity4\Lexer;

/**
 * Lexer Class
 *
 * @author Luke Watts
 * @since 1.0.0
 *
 * @package Affinity4\Lexer
 */
class Lexer
{
    /**
     * @author Luke Watts
     * @since  1.0.0
     *
     * @var
     */
    private $rules;
    
    /**
     * @author Luke Watts
     * @since  1.0.0
     *
     * @var string
     */
    private $prefix;
    
    /**
     * @author Luke Watts
     * @since  1.0.0
     *
     * @var
     */
    private $source;
    
    /**
     * Lexer Constructor
     *
     * @author Luke Watts
     * @since  1.0.0
     *
     * @param array $rules
     * @param string $prefix
     */
    public function __construct(array $rules, $prefix = "token")
    {
        $this->setPrefix($prefix);
        $this->setRules($rules);
    }
    
    /**
     * Set the current source file to run lexer against.
     *
     * @author Luke Watts
     * @since  1.0.0
     *
     * @param $file
     *
     * @throws \RuntimeException
     *
     * @return self
     */
    public function setSource($file)
    {
        if (!file_exists($file)) {
            throw new \RuntimeException(sprintf("File `%s` could not be found", $file));
        } else {
            $this->source = file_get_contents($file);
        }
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }
    
    /**
     * Sets the rules for the lexer from an array.
     *
     * The array should be the token name and patttern.
     *
     * NOTE: Tokens are prefixed automatically.
     * NOTE: Lowercase token names will be converted to uppercase
     *
     * Example:
     *  [
     *      "SPACE" => "~ ~",
     *      "OPEN_SQUARE_BRACKET" => "~\[~",
     *      "CLOSE_SQUARE_BRACKET" => "~\]~"
     *  }
     *
     * Becomes:
     *  [
     *      0 => [
     *          'token' => "T_SPACE",
     *          'pattern' => "~ ~"
     *      ],
     *      1 => [
     *          "token" => "T_OPEN_SQUARE_BRACKET",
     *          "pattern" => "~\[~",
     *      ],
     *      2 => [
     *          "token" => "CLOSE_SQUARE_BRACKET",
     *          "pattern" => "~\]~"
     *      ]
     *  ]
     *
     * @author Luke Watts
     * @since  1.0.0
     *
     * @param array $input
     */
    public function setRules(array $input)
    {
        $rules = [];
        foreach ($input as $token => $pattern) {
            $rules[] = ['token' => sprintf("%s%s", $this->getPrefix(), ucwords($token)), 'pattern' => $pattern];
        }
        
        $this->rules = $rules;
    }
    
    /**
     * Get the rules array.
     *
     * @author Luke Watts
     * @since  1.0.0
     *
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }
    
    /**
     * @author Luke Watts
     * @since  1.0.0
     *
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $prefix = rtrim($prefix, "_");
        $this->prefix = sprintf("%s_", ucwords($prefix));
    }
    
    /**
     * @author Luke Watts
     * @since  1.0.0
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}