function openDetail() {
    document.getElementById("detailBatch").classList.remove("hidden");
    document.getElementById("detailBatch").classList.add("flex");
}

function closeDetail() {
    document.getElementById("detailBatch").classList.add("hidden");
    document.getElementById("detailBatch").classList.remove("flex");
}

document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('role');
    const tokenField = document.getElementById('tokenCreateUser');
    const tokenInput = document.getElementById('tokenInputUser');

    if (!select || !tokenField || !tokenInput) return;

    function toggleTokenCreateUser() {
        const selectedOption = select.options[select.selectedIndex];
        const requireToken = selectedOption?.dataset?.requireToken;

        if (requireToken === '1') {
            tokenField.classList.remove('hidden');
            tokenInput.required = true;
        } else {
            tokenField.classList.add('hidden');
            tokenInput.required = false;
            tokenInput.value = '';
        }
    }

    // ✅ EVENT CHANGE
    select.addEventListener('change', toggleTokenCreateUser);

    // ✅ RESET SAAT PAGE LOAD
    toggleTokenCreateUser();
});
