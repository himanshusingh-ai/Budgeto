document.addEventListener("DOMContentLoaded", function () {
  fetchSummary();
  fetchCategorySummary();
  fetchBudget();

  const budgetForm = document.getElementById("budgetForm");
  budgetForm.addEventListener("submit", function (e) {
    e.preventDefault();
    saveBudget();
  });

  // Logout handler (optional enhancement)
  const logoutBtn = document.getElementById("logout-btn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", function (e) {
      e.preventDefault();
      window.location.href = "php/logout.php";
    });
  }
});

function fetchSummary() {
  fetch("php/get-summary.php", { credentials: 'include' })
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("totalIncome").textContent = `₹${data.total_income}`;
      document.getElementById("totalExpenses").textContent = `₹${data.total_expense}`;
      document.getElementById("currentBalance").textContent = `₹${data.balance}`;
    })
    .catch((err) => console.error("Error fetching summary:", err));
}

function fetchCategorySummary() {
  fetch("php/get-category-summary.php", {
    credentials: 'include'  // Make sure session cookie is sent
  })
    .then((res) => {
      if (!res.ok) {
        throw new Error(`HTTP error! status: ${res.status}`);
      }
      return res.json();
    })
    .then((data) => {
  console.log("Category summary data:", data);  // Debug log

  // Check for unauthorized error from backend
  if (data.error === "Unauthorized") {
    alert("Session expired or you are not logged in. Redirecting to login page.");
    window.location.href = "php/login.php";  // change this to your actual login page URL
    return;
  }

  if (!Array.isArray(data)) {
    console.error("Expected array but got:", data);
    return;  // Prevent calling drawPieChart on invalid data
  }

  drawPieChart(data);
})

    .catch((err) => console.error("Error fetching category summary:", err));
}

function drawPieChart(data) {
  const ctx = document.getElementById("spendingChart").getContext("2d");

  const categories = data.map((item) => item.category);
  const amounts = data.map((item) => item.total);
  const colors = [
    "#FF6384", "#36A2EB", "#FFCE56", "#2a9d8f", "#e76f51",
    "#6A4C93", "#F4A261", "#264653", "#A8DADC", "#E76F51"
  ];

  new Chart(ctx, {
    type: "pie",
    data: {
      labels: categories,
      datasets: [
        {
          data: amounts,
          backgroundColor: colors,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: "bottom",
        },
      },
    },
  });
}

function saveBudget() {
  const amount = document.getElementById("budgetAmount").value;

  fetch("php/save-budget.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `amount=${encodeURIComponent(amount)}`,
  })
    .then((res) => res.text())
    .then((msg) => {
      alert(msg);
      fetchBudget(); // Refresh budget display if needed
    })
    .catch((err) => console.error("Error saving budget:", err));
}

function fetchBudget() {
  fetch("php/get-budget.php", { credentials: 'include' })
    .then((res) => res.json())
    .then((data) => {
      if (data.amount) {
        document.getElementById("budgetAmount").value = data.amount;
      }
    })
    .catch((err) => console.error("Error fetching budget:", err));
}
