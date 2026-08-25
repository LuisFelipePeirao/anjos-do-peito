const shell = document.getElementById('app-shell');

if (shell) {
    const collapseButton = document.querySelector('[data-sidebar-collapse]');
    const mobileToggle = document.querySelector('[data-sidebar-mobile-toggle]');
    const overlay = document.querySelector('[data-sidebar-overlay]');
    const storedState = localStorage.getItem('app-sidebar-collapsed');

    if (storedState) {
        shell.dataset.sidebarCollapsed = storedState;
        collapseButton?.setAttribute('aria-expanded', storedState === 'true' ? 'false' : 'true');
    }

    const setMobileSidebar = (isOpen) => {
        shell.dataset.mobileSidebarOpen = String(isOpen);
        mobileToggle?.setAttribute('aria-expanded', String(isOpen));
    };

    collapseButton?.addEventListener('click', () => {
        const isCollapsed = shell.dataset.sidebarCollapsed === 'true';
        const nextState = String(!isCollapsed);

        shell.dataset.sidebarCollapsed = nextState;
        collapseButton.setAttribute('aria-expanded', isCollapsed ? 'true' : 'false');
        localStorage.setItem('app-sidebar-collapsed', nextState);
    });

    mobileToggle?.addEventListener('click', () => {
        setMobileSidebar(shell.dataset.mobileSidebarOpen !== 'true');
    });

    overlay?.addEventListener('click', () => setMobileSidebar(false));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMobileSidebar(false);
        }
    });

    document.querySelectorAll('.sidebar-link').forEach((link) => {
        link.addEventListener('click', () => setMobileSidebar(false));
    });
}

const pumpContractTypes = document.querySelectorAll('[data-pump-contract-type]');
const pumpBillingSection = document.querySelector('[data-pump-billing-section]');

if (pumpContractTypes.length && pumpBillingSection) {
    const pumpBillingFields = pumpBillingSection.querySelectorAll('[data-pump-billing-field]');

    const syncPumpBillingSection = () => {
        const selectedType = document.querySelector('[data-pump-contract-type]:checked')?.value;
        const isRental = selectedType === 'aluguel';

        pumpBillingSection.classList.toggle('hidden', !isRental);
        pumpBillingFields.forEach((field) => {
            field.disabled = !isRental;
        });
    };

    pumpContractTypes.forEach((input) => {
        input.addEventListener('change', syncPumpBillingSection);
    });

    syncPumpBillingSection();
}

const confirmDialogOpeners = new WeakMap();

document.addEventListener('click', (event) => {
    const openButton = event.target.closest('[data-confirm-dialog-open]');

    if (openButton) {
        event.preventDefault();
        const dialog = document.getElementById(openButton.dataset.confirmDialogOpen);

        if (dialog instanceof HTMLDialogElement) {
            confirmDialogOpeners.set(dialog, openButton);
            dialog.showModal();
        }

        return;
    }

    const closeButton = event.target.closest('[data-confirm-dialog-close]');

    if (closeButton) {
        closeButton.closest('dialog')?.close();
        return;
    }

    const confirmButton = event.target.closest('[data-confirm-dialog-confirm]');

    if (confirmButton) {
        const dialog = confirmButton.closest('dialog');

        dialog?.dispatchEvent(new CustomEvent('confirm-dialog:confirmed', {
            bubbles: true,
            detail: { id: dialog.id },
        }));
        dialog?.close('confirmed');
    }
});

document.querySelectorAll('[data-confirm-dialog-modal]').forEach((dialog) => {
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    dialog.addEventListener('close', () => {
        confirmDialogOpeners.get(dialog)?.focus();
        confirmDialogOpeners.delete(dialog);
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
        return;
    }

    document.querySelector('[data-confirm-dialog-modal][open]')?.close();
});

document.addEventListener('click', (event) => {
    const openButton = event.target.closest('[data-dialog-open]');

    if (openButton) {
        document.getElementById(openButton.dataset.dialogOpen)?.showModal();
        return;
    }

    const closeButton = event.target.closest('[data-dialog-close]');

    if (closeButton) {
        closeButton.closest('dialog')?.close();
    }
});

document.querySelectorAll('[data-dialog-modal]').forEach((dialog) => {
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });
});

const digitsOnly = (value, length) => value.replace(/\D/g, '').slice(0, length);
const formatCpf = (value) => digitsOnly(value, 11)
    .replace(/(\d{3})(\d)/, '$1.$2')
    .replace(/(\d{3})(\d)/, '$1.$2')
    .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
const formatPhone = (value) => digitsOnly(value, 11)
    .replace(/^(\d{2})(\d)/, '($1) $2')
    .replace(/(\d{5})(\d{1,4})$/, '$1-$2');
const formatCep = (value) => digitsOnly(value, 8).replace(/(\d{5})(\d)/, '$1-$2');

const maskFormatters = { cpf: formatCpf, phone: formatPhone, cep: formatCep };

document.querySelectorAll('[data-mask]').forEach((input) => {
    const formatter = maskFormatters[input.dataset.mask];

    if (!formatter) {
        return;
    }

    input.value = formatter(input.value);
    input.addEventListener('input', () => {
        input.value = formatter(input.value);
    });
});

document.querySelectorAll('[data-cep-input]').forEach((input) => {
    const form = input.closest('form');
    const feedback = input.parentElement?.querySelector('[data-cep-feedback]');
    let requestedCep = '';

    input.addEventListener('blur', async () => {
        const cep = digitsOnly(input.value, 8);

        if (cep.length !== 8 || cep === requestedCep) {
            return;
        }

        requestedCep = cep;
        feedback.textContent = 'Consultando CEP...';

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const address = await response.json();

            if (!response.ok || address.erro) {
                feedback.textContent = 'CEP não encontrado. Preencha o endereço manualmente.';
                return;
            }

            const setValue = (name, value) => {
                const field = form?.querySelector(`[name="${name}"]`);

                if (field && value) {
                    field.value = value;
                    field.dispatchEvent(new Event('change', { bubbles: true }));
                }
            };

            setValue('logradouro', address.logradouro);
            setValue('bairro', address.bairro);
            setValue('cidade', address.localidade);
            setValue('uf', address.uf);
            feedback.textContent = 'Endereço preenchido pelo CEP.';
        } catch {
            feedback.textContent = 'Não foi possível consultar o CEP. Preencha o endereço manualmente.';
        }
    });
});

const attendanceStatusSelect = document.querySelector('[name="status"]');
const attendanceClinicalFields = document.querySelector('[data-attendance-clinical-fields]');

if (attendanceStatusSelect && attendanceClinicalFields) {
    const syncAttendanceClinicalFields = () => {
        attendanceClinicalFields.classList.toggle('hidden', attendanceStatusSelect.value === 'agendado');
    };

    attendanceStatusSelect.addEventListener('change', syncAttendanceClinicalFields);
    syncAttendanceClinicalFields();
}
