<?php

it('repositions required select markers after a dialog opens', function () {
    $script = file_get_contents(resource_path('js/app.js'));

    expect($script)
        ->toContain("dialog.querySelectorAll('[data-select-required] md-outlined-select')")
        ->toContain('scheduleSelectRequiredAsterisk(select)');
});
