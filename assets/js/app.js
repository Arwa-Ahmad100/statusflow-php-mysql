const form = document.getElementById('personForm');
const submitBtn = document.getElementById('submitBtn');
const formMessage = document.getElementById('formMessage');
const recordsBody = document.getElementById('recordsBody');
const recordCount = document.getElementById('recordCount');

function escapeHtml(value) {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function updateCount() {
    const count = recordsBody.querySelectorAll('tr[data-id]').length;
    recordCount.textContent = `${count} record${count === 1 ? '' : 's'}`;
}

function buildRow(user) {
    const tr = document.createElement('tr');
    tr.dataset.id = user.id;
    tr.innerHTML = `
        <td class="id-cell">#${Number(user.id)}</td>
        <td class="name-cell">${escapeHtml(user.name)}</td>
        <td>${Number(user.age)}</td>
        <td>
            <span class="status-badge ${Number(user.status) === 1 ? 'status-on' : 'status-off'}" data-status>
                ${Number(user.status)}
            </span>
        </td>
        <td>
            <button class="toggle-btn" type="button" data-toggle-id="${Number(user.id)}">Toggle</button>
        </td>
    `;
    return tr;
}

function showMessage(text, type = '') {
    formMessage.textContent = text;
    formMessage.className = `message ${type}`.trim();
}

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    showMessage('');

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const formData = new FormData(form);
    submitBtn.disabled = true;
    submitBtn.classList.add('loading');

    try {
        const response = await fetch('api/create.php', {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Unable to add the record.');
        }

        document.getElementById('emptyRow')?.remove();
        recordsBody.prepend(buildRow(data.user));
        form.reset();
        document.getElementById('name').focus();
        updateCount();
        showMessage('Record added successfully.', 'success');
    } catch (error) {
        showMessage(error.message || 'Something went wrong. Please try again.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.classList.remove('loading');
    }
});

recordsBody.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-toggle-id]');
    if (!button) return;

    const id = button.dataset.toggleId;
    const row = button.closest('tr');
    const badge = row.querySelector('[data-status]');

    button.disabled = true;
    button.textContent = 'Updating…';

    const formData = new FormData();
    formData.append('id', id);

    try {
        const response = await fetch('api/toggle.php', {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Unable to update status.');
        }

        const status = Number(data.user.status);
        badge.textContent = status;
        badge.classList.toggle('status-on', status === 1);
        badge.classList.toggle('status-off', status === 0);
    } catch (error) {
        alert(error.message || 'Something went wrong. Please try again.');
    } finally {
        button.disabled = false;
        button.textContent = 'Toggle';
    }
});
