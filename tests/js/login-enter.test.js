import test from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { runInNewContext } from 'node:vm';

const source = readFileSync(new URL('../../resources/js/app.js', import.meta.url), 'utf8')
    .replace(/^import .*;\r?\n/gm, '');

function loginKeyboard() {
    let listener;
    let submissions = 0;
    const form = {
        addEventListener: (type, callback) => {
            if (type === 'keydown') listener = callback;
        },
        requestSubmit: () => submissions++,
    };

    runInNewContext(source, {
        document: {
            getElementById: (id) => id === 'login-enhanced-form' ? form : null,
            querySelector: () => null,
            querySelectorAll: () => [],
            addEventListener: () => {},
        },
        window: { addEventListener: () => {} },
    });

    return {
        press(overrides = {}) {
            const event = {
                key: 'Enter',
                defaultPrevented: false,
                isComposing: false,
                composedPath: () => [{ tagName: 'INPUT' }],
                preventDefault() { this.defaultPrevented = true; },
                ...overrides,
            };
            listener?.(event);
            return { submissions, prevented: event.defaultPrevented };
        },
    };
}

test('Enter nos campos do login solicita envio uma vez e cancela envio implícito', () => {
    assert.deepEqual(loginKeyboard().press(), { submissions: 1, prevented: true });
});

test('preserva outras teclas, composição, eventos cancelados e botões do login', () => {
    for (const overrides of [
        { key: 'Tab' },
        { isComposing: true },
        { defaultPrevented: true },
        { composedPath: () => [{ tagName: 'BUTTON' }] },
        { composedPath: () => [{ tagName: 'A' }] },
    ]) {
        assert.equal(loginKeyboard().press(overrides).submissions, 0);
    }
});
