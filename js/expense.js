document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('transactionForm');
  const tableBody = document.getElementById('transactionTableBody');
  const idField = document.getElementById('transactionId');

  fetchTransactions();

  // Handle form submit
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = {
      type: form.type.value,
      category: form.category.value.trim(),
      amount: parseFloat(form.amount.value),
      note: form.note.value.trim(),
      date: form.date.value,
      id: idField.value || null
    };

    const url = data.id ? 'php/edit-transaction.php' : 'php/add-transaction.php';

    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify(data)
    });

    const result = await res.json();
    if (result.success) {
      form.reset();
      idField.value = '';
      fetchTransactions();
    } else {
      alert(result.error || 'Failed to save transaction.');
    }
  });

  // Fetch all transactions
  async function fetchTransactions() {
    const res = await fetch('php/get-transactions.php', { credentials: 'include' });
    const result = await res.json();
    tableBody.innerHTML = '';

    if (result.transactions && result.transactions.length > 0) {
      result.transactions.forEach(tx => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${tx.type}</td>
          <td>${tx.category}</td>
          <td>${tx.amount}</td>
          <td>${tx.note || ''}</td>
          <td>${tx.date}</td>
          <td class="actions">
            <button class="edit" data-id="${tx.id}">Edit</button>
            <button class="delete" data-id="${tx.id}">Delete</button>
          </td>
        `;
        tableBody.appendChild(tr);
      });

      addEventListeners();
    } else {
      tableBody.innerHTML = `<tr><td colspan="6">No transactions found.</td></tr>`;
    }
  }

  function addEventListeners() {
    document.querySelectorAll('.edit').forEach(button => {
      button.addEventListener('click', async () => {
        const id = button.dataset.id;
        const res = await fetch(`php/get-transactions.php?id=${id}`, { credentials: 'include' });
        const data = await res.json();
        if (data.transaction) {
          const tx = data.transaction;
          form.type.value = tx.type;
          form.category.value = tx.category;
          form.amount.value = tx.amount;
          form.note.value = tx.note;
          form.date.value = tx.date;
          idField.value = tx.id;
        }
      });
    });

    document.querySelectorAll('.delete').forEach(button => {
      button.addEventListener('click', async () => {
        const id = button.dataset.id;
        if (confirm('Delete this transaction?')) {
          const res = await fetch('php/delete-transaction.php', {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
          });
          const result = await res.json();
          if (result.success) fetchTransactions();
          else alert('Delete failed.');
        }
      });
    });
  }
});
