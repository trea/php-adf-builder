<?php

use Jmsfwk\Adf\Document;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    /** @test */
    public function empty_document()
    {
        $document = new Document();

        $doc = json_encode($document);

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'version' => 1,
            'type' => 'doc',
            'content' => [],
        ]));
    }

    /** @test */
    public function document_with_empty_paragraph()
    {
        $document = new Document();
        $document->paragraph();

        $doc = json_encode($document);

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'version' => 1,
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'paragraph',
                    'content' => [],
                ],
            ],
        ]));
    }

    /** @test */
    public function document_with_text_in_paragraph()
    {
        $document = new Document();
        $document->paragraph()
            ->text('Hello world');

        $doc = json_encode($document);

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'version' => 1,
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'paragraph',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'Hello world',
                        ],
                    ],
                ],
            ],
        ]));
    }

    /** @test */
    public function test_document_with_text_in_paragraph_fluent_api()
    {
        $document = (new Document())
            ->paragraph()
            ->text('Hello world')
            ->end();

        $doc = $document->toJSON();

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'version' => 1,
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'paragraph',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'Hello world',
                        ],
                    ],
                ],
            ],
        ]));
    }

    /** @test */
    public function document_with_multiple_text_nodes()
    {
        $doc = (new Document())
            ->paragraph()
            ->text('Hello world')
            ->text('How are you')
            ->end()
            ->toJSON();

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'version' => 1,
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'paragraph',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'Hello world',
                        ],
                        [
                            'type' => 'text',
                            'text' => 'How are you',
                        ],
                    ],
                ],
            ],
        ]));
    }

    /** @test */
    public function document_with_blockquote()
    {
        $doc = (new Document())
            ->blockquote()
            ->paragraph()
            ->text('quoted text')
            ->end()
            ->end()
            ->toJSON();

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'version' => 1,
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'blockquote',
                    'content' => [
                        [
                            'type' => 'paragraph',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => 'quoted text',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]));
    }

    /** @test */
    public function document_with_heading()
    {
        $doc = (new Document())
            ->heading(3)
            ->text('heading text')
            ->end()
            ->toJSON();

        $this->assertJsonStringEqualsJsonString($doc, json_encode([
            'version' => 1,
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'heading',
                    'attrs' => [
                        'level' => 3,
                    ],
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'heading text',
                        ],
                    ],
                ],
            ],
        ]));
    }

    /**
    * @test
    */
    public function document_with_bullet_list()
    {
        $list = (new Document())
            ->bulletList();

        $list->listItem()->paragraph()->text('An item that is text');
        $list->listItem()->paragraph()->link('A link', 'https://example.com');

        $list = $list->end()->toJson();

        $this->assertJsonStringEqualsJsonString($list, json_encode([
            'version' => 1,
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'bulletList',
                    'content' => [
                        [
                            'type' => 'listItem',
                            'content' => [
                                [
                                    'type' => 'paragraph',
                                    'content' => [
                                        [
                                            'type' => 'text',
                                            'text' => 'An item that is text'
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            'type' => 'listItem',
                            'content' => [
                                [
                                    'type' => 'paragraph',
                                    'content' => [
                                        [
                                            'type' => 'text',
                                            'text' => 'A link',
                                            'marks' => [
                                                [
                                                    'type' => 'link',
                                                    'attrs' => [
                                                        'href' => 'https://example.com'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                ],
            ],
        ]));
    }

    /**
    * @test
    */
    public function text_with_multiple_marks()
    {
        $doc = (new Document())->paragraph()->text("This text is bold and italicized", new \Jmsfwk\Adf\Marks\Strong(), new \Jmsfwk\Adf\Marks\Em());

        $result = $doc->end()->toJson();

        $this->assertJsonStringEqualsJsonString($result, json_encode([
            'version' => 1,
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'paragraph',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'This text is bold and italicized',
                            'marks' => [
                                [
                                    'type' => 'strong',
                                ],
                                [
                                    'type' => 'em',
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]));
    }
}

