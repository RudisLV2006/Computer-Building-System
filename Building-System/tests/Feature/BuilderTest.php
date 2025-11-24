<?php

class BuilderTest extends TestCase{
    use RefreshDatabase;

    /** @test */
    public function it_can_add_gpu_to_builder_session()
    {
        $gpu = Gpu::factory()->create();

        $response = $this->post(route('builder.addItem', [
            'type' => 'gpu',
            'item' => $gpu->id,
        ]));

        $response->assertSessionHas('builder.cart', function ($cart) use ($gpu) {
            return collect($cart)->contains('id', $gpu->id);
        });

        $response->assertRedirect();
    }
}