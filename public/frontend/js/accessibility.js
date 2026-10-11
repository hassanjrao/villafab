(function () {
    'use strict';
    var activeDialog = null;
    var returnFocus = null;
    var isolated = [];
    function focusable(root) {
        return Array.from(root.querySelectorAll('button, a[href], input, select, textarea, [tabindex="0"]'))
            .filter(function (el) { return !el.disabled && el.getClientRects().length; });
    }
    window.VillaAccessibility = {
        labelCalendar: function (root) {
            root.querySelectorAll('.button-previous-month').forEach(function (button) { button.setAttribute('aria-label', 'Previous month'); });
            root.querySelectorAll('.button-next-month').forEach(function (button) { button.setAttribute('aria-label', 'Next month'); });
        },
        openDialog: function (dialog) {
            returnFocus = document.activeElement;
            activeDialog = dialog;
            dialog.setAttribute('role', 'dialog');
            dialog.setAttribute('aria-modal', 'true');
            // Isolate siblings at each level, including a parent Bootstrap modal.
            var branch = dialog;
            while (branch.parentElement && branch !== document.body) {
                Array.from(branch.parentElement.children).forEach(function (sibling) {
                    if (sibling !== branch && !sibling.inert) {
                        sibling.inert = true;
                        isolated.push(sibling);
                    }
                });
                branch = branch.parentElement;
            }
            (focusable(dialog)[0] || dialog).focus();
        },
        closeDialog: function () {
            isolated.forEach(function (el) { el.inert = false; });
            isolated = [];
            activeDialog = null;
            if (returnFocus && returnFocus.isConnected) returnFocus.focus();
        }
    };
    document.addEventListener('keydown', function (event) {
        if (!activeDialog) return;
        // Keep Bootstrap's modal focus and Escape handlers out of a nested lightbox.
        event.stopImmediatePropagation();
        if (event.key === 'Escape') {
            event.preventDefault();
            activeDialog.querySelector('.glb-close, .lb-close').click();
        } else if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
            event.preventDefault();
            activeDialog.querySelector(event.key === 'ArrowLeft' ? '.glb-prev, .lb-prev' : '.glb-next, .lb-next').click();
        } else if (event.key === 'Tab') {
            var items = focusable(activeDialog);
            var first = items[0], last = items[items.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault(); last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault(); first.focus();
            }
        }
    }, true);
    document.addEventListener('focusin', function (event) {
        if (activeDialog && !activeDialog.contains(event.target)) {
            event.stopImmediatePropagation();
            (focusable(activeDialog)[0] || activeDialog).focus();
        }
    }, true);
    document.querySelectorAll('div[onclick], img[onclick], .gallery-grid-image').forEach(function (el) {
        // A tile containing the existing photo button uses that button instead.
        if (el.querySelector('button')) return;
        el.setAttribute('role', 'button');
        el.setAttribute('tabindex', '0');
        el.setAttribute('aria-label', 'View photo: ' + (el.alt || (el.querySelector('img') || {}).alt || 'Villa Fabulosa'));
        el.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault(); el.click();
            }
        });
    });
    document.querySelectorAll('.nav-link[href]').forEach(function (link) {
        if (link.pathname === location.pathname && link.getAttribute('href') !== '#') link.setAttribute('aria-current', 'page');
    });
    document.querySelectorAll('.booking-date-input').forEach(function (input) {
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); input.click(); }
        });
    });
    document.querySelectorAll('a[role="button"]').forEach(function (link) {
        link.addEventListener('keydown', function (event) {
            if (event.key === ' ') { event.preventDefault(); link.click(); }
        });
    });
    document.querySelectorAll('.bn-edit-link[aria-controls]').forEach(function (control) {
        var panel = document.getElementById(control.getAttribute('aria-controls'));
        if (!panel) return;
        new MutationObserver(function () {
            var open = panel.style.display !== 'none';
            control.setAttribute('aria-expanded', String(open));
            if (open) {
                var first = focusable(panel)[0];
                if (first) first.focus();
            } else if (panel.contains(document.activeElement)) {
                control.focus();
            }
        }).observe(panel, { attributes: true, attributeFilter: ['style'] });
    });
    if (window.jQuery) {
        var photoOpener;
        jQuery('#photoTourModal').on('show.bs.modal', function () { photoOpener = document.activeElement; })
            .on('hidden.bs.modal', function () { if (photoOpener) photoOpener.focus(); });
    }
    // Associate visible errors with their fields, including server validation.
    document.querySelectorAll('.cf-field, .bn-field').forEach(function (group) {
        var input = group.querySelector('input, textarea, select');
        if (!input) return;
        var errors = Array.from(group.querySelectorAll('.cf-error, .bn-field-error'));
        errors.forEach(function (error, index) {
            if (!error.id) error.id = input.id + '-error-' + index;
            error.setAttribute('aria-live', 'polite');
        });
        if (errors.length) input.setAttribute('aria-describedby', errors.map(function (el) { return el.id; }).join(' '));
        function sync() { input.setAttribute('aria-invalid', input.classList.contains('is-invalid') ? 'true' : 'false'); }
        sync();
        new MutationObserver(sync).observe(input, { attributes: true, attributeFilter: ['class'] });
    });
    var invalid = document.querySelector('#requestform .is-invalid');
    if (invalid) invalid.focus();
})();
