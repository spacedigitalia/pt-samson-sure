//===================== About =====================//
let itemCount = 0;

function addItem(title = "", description = "") {
  itemCount++;
  const container = document.getElementById("itemsContainer");
  const itemDiv = document.createElement("div");
  itemDiv.className = "rounded-xl border border-slate-200 bg-slate-50 p-4";
  itemDiv.innerHTML = `
        <div class="flex items-start justify-between mb-3">
            <h4 class="text-sm font-semibold text-slate-700">Item #${itemCount}</h4>
            <button type="button" onclick="removeItem(this)" class="text-red-500 hover:text-red-700 transition-colors">
                <i class='bx bx-trash text-lg'></i>
            </button>
        </div>
        <div class="space-y-3">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Title</label>
                <input type="text" name="items[${itemCount}][title]" value="${title}" required 
                    placeholder="Masukkan title..."
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Description</label>
                <textarea name="items[${itemCount}][description]" rows="3" required 
                    placeholder="Masukkan description..."
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">${description}</textarea>
            </div>
        </div>
    `;
  container.appendChild(itemDiv);
}

function removeItem(button) {
  button.closest(".rounded-xl").remove();
  updateItemNumbers();
}

function updateItemNumbers() {
  const items = document.querySelectorAll("#itemsContainer > div");
  items.forEach((item, index) => {
    const titleElement = item.querySelector("h4");
    if (titleElement) {
      titleElement.textContent = `Item #${index + 1}`;
    }
  });
}

// Inisialisasi item pertama saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
  addItem();
});
