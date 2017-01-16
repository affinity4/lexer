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
require_once __DIR__ . '/vendor/autoload.php';

$lexer = new Affinity4\Lexer\Lexer(Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__ . '/tests/rules.yml')));

$rules = $lexer->getRules();

var_dump($rules);