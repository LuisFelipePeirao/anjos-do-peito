export const shouldConfirmUnsavedNavigation = ({
    isDirty,
    href,
    currentHref,
    target = '',
    hasModifier = false,
    download = false,
    isConfirmationOpener = false,
    isInClosedDialog = false,
}) => {
    if (!isDirty || isInClosedDialog || !href || target || hasModifier || download || isConfirmationOpener) {
        return false;
    }

    const destination = new URL(href, currentHref);
    const current = new URL(currentHref);

    return destination.origin !== current.origin
        || destination.pathname !== current.pathname
        || destination.search !== current.search;
};

export const shouldConfirmFormDismissal = ({ isDirty, isAbandonmentDialogOpen = false }) => isDirty && !isAbandonmentDialogOpen;
