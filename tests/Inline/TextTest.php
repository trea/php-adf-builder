<?php

use Jmsfwk\Adf\Inline\Text;
use Jmsfwk\Adf\Marks\Em;
use Jmsfwk\Adf\Marks\Strike;
use Jmsfwk\Adf\Marks\Strong;
use Jmsfwk\Adf\Marks\Underline;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    /** @test */
    public function supports_a_single_mark()
    {
        $text = new Text('some text', new Em());
        $doc = $text->toJson();

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'type' => 'text',
            'text' => 'some text',
            'marks' => [
                [
                    'type' => 'em',
                ]
            ],
        ]));
    }

    /** @test */
    public function supports_multiple_marks()
    {
        $text = new Text('some text', new Em(), new Strike());
        $doc = $text->toJson();

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'type' => 'text',
            'text' => 'some text',
            'marks' => [
                [
                    'type' => 'em',
                ],
                [
                    'type' => 'strike',
                ]
            ],
        ]));
    }

    /**
    * @test
    */
    public function supports_strong_mark()
    {
        $text = new Text('this text is bold', new Strong());
        $doc = $text->toJson();

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'type' => 'text',
            'text' => 'this text is bold',
            'marks' => [
                [
                    'type' => 'strong',
                ],
            ],
        ]));
    }

    /**
    * @test
    */
    public function supports_underline_mark()
    {
        $text = new Text('this text is underlined', new Underline());
        $doc = $text->toJson();

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'type' => 'text',
            'text' => 'this text is underlined',
            'marks' => [
                [
                    'type' => 'underline'
                ]
            ]
        ]));
    }

    /**
    * @test
    */
    public function supports_code_mark()
    {
        $text = new Text('<div class="panel panel-default">', new \Jmsfwk\Adf\Marks\Code());
        $doc = $text->toJson();

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'type' => 'text',
            'text' => '<div class="panel panel-default">',
            'marks' => [
                [
                    'type' => 'code',
                ]
            ]
        ]));
    }
}
