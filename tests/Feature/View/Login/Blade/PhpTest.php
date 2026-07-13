<?php

it('can render', function () {
    $contents = $this->view('auth.login', [
        //
    ]);

    $contents->assertSee('');
});
