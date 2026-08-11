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
