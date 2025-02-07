<?php

namespace Tests\Feature;

use App\Models\DocumentChunk;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_config_helper(): void
    {

        $this->assertEquals('mock', driverHelper('mock', 'models.embedding_model'));

    }

    public function test_chunks_a_string()
    {
        $maxLength = 100;

        $string = <<<'STRING'
        Cupidatat nostrud anim consectetur veniam enim excepteur ut aliqua Lorem nulla non. Pariatur eu sunt quis. Consectetur fugiat Lorem reprehenderit reprehenderit id sunt labore duis irure laboris officia. In labore culpa nulla. Reprehenderit non eu reprehenderit. Culpa irure voluptate consequat consequat. Esse aliquip ipsum culpa tempor nostrud esse laborum eiusmod est laborum.

        Mollit do minim ullamco exercitation sint in laboris pariatur ea Lorem Lorem. Est sunt sit pariatur in elit nisi id incididunt eiusmod ipsum Lorem commodo ut incididunt. Enim et dolor consequat adipisicing mollit dolor officia dolore. Quis aute dolor enim ullamco exercitation dolor minim laboris mollit fugiat velit. Sit deserunt dolor ea. In ipsum ipsum reprehenderit pariatur sit reprehenderit velit anim nostrud nostrud sit velit. Adipisicing ad laboris excepteur in veniam magna dolore aute excepteur dolore nostrud adipisicing excepteur laborum ut. Minim ea officia duis aliquip eiusmod qui ex incididunt eiusmod.
        
        Veniam officia labore enim eu laboris et voluptate velit. Id do velit adipisicing ex. Consectetur do amet et exercitation duis laboris. Irure labore ipsum et sint labore ex sunt aute magna aute.
        
        Qui ipsum aute laborum quis ea officia in sit ut. Minim occaecat aliquip enim officia ut pariatur. Tempor officia pariatur officia adipisicing excepteur velit irure irure ex adipisicing aliquip ea culpa aute nulla. Ut ad veniam est nostrud consectetur. Elit commodo ea non aliqua aliquip id consectetur tempor sit aliqua minim eiusmod consequat sit do.
STRING;

        $chunks = chunk_string($string, $maxLength);

        $this->assertCount(10, $chunks);

    }

    public function test_get_embedding_size(): void
    {

        $model = DocumentChunk::factory()->create();

        $embedding_column = get_embedding_size($model->getEmbeddingDriver());

        $this->assertEquals('embedding_4096', $embedding_column);

        $model = DocumentChunk::factory()
            ->openAi()
            ->create();

        $embedding_column = get_embedding_size($model->getEmbeddingDriver());

        $this->assertEquals('embedding_3072', $embedding_column);

    }

    public function test_calculate_dynamic_threshold()
    {
        $distances = [0.5, 0.75, 2, 3, 10];

        $threshold = calculate_dynamic_threshold($distances);

        $this->assertEquals(3.25, $threshold);
    }
}
