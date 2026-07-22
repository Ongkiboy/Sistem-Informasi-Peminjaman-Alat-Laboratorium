<?php

it('can render', function () {
    $contents = $this->view('auth.login', [
        'errors' => new \Illuminate\Support\ViewErrorBag,
    ]);

    $contents->assertSee('');
});
