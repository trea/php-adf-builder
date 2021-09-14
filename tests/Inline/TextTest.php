<?php

use Jmsfwk\Adf\Inline\Text;
use Jmsfwk\Adf\Marks\Em;
use Jmsfwk\Adf\Marks\Strike;
use Jmsfwk\Adf\Marks\Strong;
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
}
