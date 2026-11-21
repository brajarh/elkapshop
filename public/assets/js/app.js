document.querySelectorAll('form[data-delete]').forEach(form => {
    form.addEventListener('submit', event => {
        if (!confirm('Hapus data ini?')) {
            event.preventDefault();
        }
    });
});
