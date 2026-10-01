import test from 'node:test';
import assert from 'node:assert/strict';

import { shouldConfirmFormDismissal, shouldConfirmUnsavedNavigation } from '../../resources/js/unsaved-form-guard.js';

test('confirma abandono apenas para formulário alterado e link comum na mesma aba', () => {
    assert.equal(shouldConfirmUnsavedNavigation({
        isDirty: true,
        href: 'http://localhost/beneficiarias',
        currentHref: 'http://localhost/beneficiarias/nova',
    }), true);

    assert.equal(shouldConfirmUnsavedNavigation({
        isDirty: false,
        href: 'http://localhost/beneficiarias',
        currentHref: 'http://localhost/beneficiarias/nova',
    }), false);

    assert.equal(shouldConfirmUnsavedNavigation({
        isDirty: true,
        href: 'http://localhost/beneficiarias/nova#dados',
        currentHref: 'http://localhost/beneficiarias/nova',
    }), false);

    assert.equal(shouldConfirmUnsavedNavigation({
        isDirty: true,
        isInClosedDialog: true,
        href: 'http://localhost/beneficiarias',
        currentHref: 'http://localhost/beneficiarias/1',
    }), false);

    assert.equal(shouldConfirmUnsavedNavigation({
        isDirty: true,
        href: 'http://localhost/beneficiarias',
        currentHref: 'http://localhost/beneficiarias/nova',
        target: '_blank',
    }), false);
});

test('confirma fechamento somente quando formulário fechado possui alterações', () => {
    assert.equal(shouldConfirmFormDismissal({ isDirty: true }), true);
    assert.equal(shouldConfirmFormDismissal({ isDirty: false }), false);
    assert.equal(shouldConfirmFormDismissal({ isDirty: true, isAbandonmentDialogOpen: true }), false);
});
