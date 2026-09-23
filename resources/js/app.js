const shell = document.getElementById('app-shell');

const passwordToggleTarget = (button) => {
    const field = button.closest('md-filled-text-field');

    if (field) {
        return field;
    }

    return button.closest('label')?.querySelector('input[type="password"], input[type="text"]');
};

document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-password-toggle]');

    if (!button) {
        return;
    }

    const field = passwordToggleTarget(button);

    if (!field) {
        return;
    }

    const isVisible = field.type === 'text';
    field.type = isVisible ? 'password' : 'text';
    button.setAttribute('aria-label', isVisible ? 'Mostrar senha' : 'Ocultar senha');
    button.setAttribute('aria-pressed', String(!isVisible));
    button.querySelector('[data-password-visible-icon]')?.classList.toggle('hidden', !isVisible);
    button.querySelector('[data-password-hidden-icon]')?.classList.toggle('hidden', isVisible);
});

const syncSelectRequiredAsterisk = (select) => {
    const wrapper = select.closest('[data-select-required]');
    const asterisk = wrapper?.querySelector('[data-select-required-asterisk]');
    const field = select.shadowRoot?.querySelector('[part="field"]');
    const label = field?.shadowRoot?.querySelector('.label:not(.hidden)');

    if (!wrapper || !asterisk || !label) {
        return;
    }

    const wrapperRect = wrapper.getBoundingClientRect();
    const labelRect = label.getBoundingClientRect();
    const labelStyle = window.getComputedStyle(label);

    asterisk.style.left = `${labelRect.right - wrapperRect.left + 4}px`;
    asterisk.style.top = `${labelRect.top - wrapperRect.top}px`;
    asterisk.style.fontSize = labelStyle.fontSize;
    asterisk.style.lineHeight = labelStyle.lineHeight;
    asterisk.style.fontWeight = labelStyle.fontWeight;
    asterisk.style.visibility = 'visible';
};

const scheduleSelectRequiredAsterisk = (select) => {
    requestAnimationFrame(() => {
        syncSelectRequiredAsterisk(select);
        window.setTimeout(() => syncSelectRequiredAsterisk(select), 170);
    });
};

const selectWithRequiredAsterisk = (target) => target instanceof Element
    ? target.closest('md-outlined-select')?.closest('[data-select-required]')?.querySelector('md-outlined-select')
    : null;

document.querySelectorAll('[data-select-required] md-outlined-select').forEach(scheduleSelectRequiredAsterisk);

['focusin', 'focusout', 'input', 'change'].forEach((eventName) => {
    document.addEventListener(eventName, (event) => {
        const select = selectWithRequiredAsterisk(event.target);

        if (select) {
            scheduleSelectRequiredAsterisk(select);
        }
    }, true);
});

window.addEventListener('resize', () => {
    document.querySelectorAll('[data-select-required] md-outlined-select').forEach(syncSelectRequiredAsterisk);
});

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

document.querySelectorAll('[data-dialog-auto-open]').forEach((dialog) => {
    if (dialog instanceof HTMLDialogElement) {
        dialog.showModal();
    }
});

const locationForm = document.querySelector('[data-location-form]');

if (locationForm) {
    const methodInput = locationForm.querySelector('[data-location-method]');
    const submitLabel = locationForm.querySelector('[data-location-submit-label]');
    const storeAction = locationForm.dataset.locationStoreAction;

    const locationFields = ['nome', 'descricao', 'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'uf'];

    const setLocationField = (name, value = '') => {
        const field = locationForm.querySelector(`[name="${name}"]`);

        if (field) {
            field.value = value;
            field.dispatchEvent(new Event('input', { bubbles: true }));
            field.dispatchEvent(new Event('change', { bubbles: true }));
        }
    };

    const resetLocationForm = () => {
        locationForm.action = storeAction;
        if (methodInput) {
            methodInput.disabled = true;
        }
        locationFields.forEach((field) => setLocationField(field, ''));
        if (submitLabel) {
            submitLabel.textContent = 'Salvar local';
        }
    };

    document.querySelectorAll('[data-location-edit]').forEach((button) => {
        button.addEventListener('click', () => {
            locationForm.action = button.dataset.locationUpdateAction;
            if (methodInput) {
                methodInput.disabled = false;
            }
            locationFields.forEach((field) => setLocationField(field, button.dataset[`location${field.charAt(0).toUpperCase()}${field.slice(1)}`] || ''));
            if (submitLabel) {
                submitLabel.textContent = 'Salvar alterações';
            }
            locationForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            locationForm.querySelector('[name="nome"]')?.focus();
        });
    });

    locationForm.querySelector('[data-location-reset]')?.addEventListener('click', resetLocationForm);
}

document.querySelectorAll('[data-entity-form]').forEach((entityForm) => {
    const methodInput = entityForm.querySelector('[data-entity-method]');
    const submitLabel = entityForm.querySelector('[data-entity-submit-label]');
    const storeAction = entityForm.dataset.entityStoreAction;
    const fields = (entityForm.dataset.entityFields || '').split(',').filter(Boolean);

    const setField = (name, value = '') => {
        const field = entityForm.querySelector(`[name="${name}"]`);

        if (field) {
            field.value = value;
            field.dispatchEvent(new Event('input', { bubbles: true }));
            field.dispatchEvent(new Event('change', { bubbles: true }));
        }
    };

    const resetForm = () => {
        entityForm.action = storeAction;
        methodInput?.setAttribute('disabled', '');
        fields.forEach((field) => setField(field));
        if (submitLabel) {
            submitLabel.textContent = `Salvar ${entityForm.closest('dialog')?.dataset.entityLabel || 'item'}`;
        }
    };

    entityForm.closest('dialog')?.querySelectorAll('[data-entity-edit]').forEach((button) => {
        button.addEventListener('click', () => {
            entityForm.action = button.dataset.entityUpdateAction;
            methodInput?.removeAttribute('disabled');
            fields.forEach((field) => setField(field, button.dataset[`entity${field.charAt(0).toUpperCase()}${field.slice(1)}`] || ''));
            if (submitLabel) {
                submitLabel.textContent = 'Salvar alterações';
            }
            entityForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            entityForm.querySelector('[name="nome"]')?.focus();
        });
    });

    entityForm.querySelector('[data-entity-reset]')?.addEventListener('click', resetForm);
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

const attendanceForm = document.querySelector('[data-attendance-form]');
const attendanceStatusSelect = document.querySelector('[data-attendance-status-select]');
const attendanceClinicalFields = document.querySelector('[data-attendance-clinical-fields]');

if (attendanceStatusSelect && attendanceClinicalFields) {
    const syncAttendanceClinicalFields = () => {
        const selectedStatus = attendanceStatusSelect.value
            || attendanceStatusSelect.querySelector('md-select-option[selected]')?.getAttribute('value')
            || attendanceStatusSelect.dataset.initialStatus;

        attendanceClinicalFields.classList.toggle('hidden', selectedStatus !== 'realizado');
    };

    attendanceStatusSelect.addEventListener('change', syncAttendanceClinicalFields);
    syncAttendanceClinicalFields();
}

if (attendanceForm) {
    const beneficiarySelect = attendanceForm.querySelector('[data-attendance-beneficiary]');
    const childSelect = attendanceForm.querySelector('[data-attendance-child]');

    const selectedValue = (select) => select?.value
        || select?.querySelector('md-select-option[selected]')?.getAttribute('value')
        || '';

    const setChildOptions = (children, selectedChild = '') => {
        if (!childSelect) return;

        const options = children.map((child) => {
            const option = document.createElement('md-select-option');
            option.value = child.value;
            if (String(child.value) === String(selectedChild)) option.setAttribute('selected', '');

            const headline = document.createElement('div');
            headline.slot = 'headline';
            headline.className = 'text-sm font-normal leading-5 text-[#111827]';
            headline.style.fontFamily = 'Instrument Sans, ui-sans-serif, system-ui, sans-serif';
            headline.textContent = child.label;
            option.append(headline);

            return option;
        });

        childSelect.replaceChildren(...options);
    };

    const loadChildren = async (preserveSelection = false) => {
        const beneficiaryId = selectedValue(beneficiarySelect);
        const selectedChild = preserveSelection ? childSelect?.dataset.initialChild || selectedValue(childSelect) : '';

        if (!beneficiaryId) {
            setChildOptions([], '');
            return;
        }

        try {
            const response = await fetch(attendanceForm.dataset.childrenEndpoint.replace('__beneficiary__', beneficiaryId));
            setChildOptions(response.ok ? await response.json() : [], selectedChild);
        } catch {
            setChildOptions([], '');
        }
    };

    beneficiarySelect?.addEventListener('change', () => loadChildren(false));
    loadChildren(true);
}

const confirmationDialog = document.getElementById('attendance-finalize-confirmation');
const attendanceSubmissionForm = document.querySelector('[data-attendance-form], [data-attendance-continuation-form]');

if (confirmationDialog && attendanceSubmissionForm) {
    let confirmationAccepted = false;

    attendanceSubmissionForm.addEventListener('submit', (event) => {
        const submitter = event.submitter;
        const isFinalSubmission = submitter?.value === 'final';
        const status = attendanceStatusSelect?.value
            || attendanceStatusSelect?.dataset.initialStatus
            || 'em_atendimento';

        if (!isFinalSubmission || confirmationAccepted || (status !== 'realizado' && !attendanceSubmissionForm.matches('[data-attendance-continuation-form]'))) return;

        event.preventDefault();
        confirmationDialog.showModal();
    });

    confirmationDialog.addEventListener('confirm-dialog:confirmed', () => {
        confirmationAccepted = true;
        attendanceSubmissionForm.querySelector('[data-attendance-finalization-confirmation]')?.setAttribute('value', '1');
        const finalButton = attendanceSubmissionForm.querySelector('[data-attendance-final-submit]');
        attendanceSubmissionForm.requestSubmit(finalButton);
    });
}
