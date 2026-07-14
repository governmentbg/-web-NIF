export function initMultiSelectForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    const containers = form.querySelectorAll(".dropdown-multiselect");

    containers.forEach((container) => {
        const button = container.querySelector("button");
        const checkboxes = container.querySelectorAll("input[type='checkbox']");

        // Placeholder = първоначалния текст
        const placeholderText = button.textContent.trim();

        // Шаблон за избрани
        const selectedTextTemplate =
            button.dataset.selectedText || "{count} selected";

        function updateButton() {
            const checkedCount = Array.from(checkboxes).filter(
                (cb) => cb.checked,
            ).length;

            if (checkedCount === 0) {
                button.textContent = placeholderText;
                button.classList.add("text-secondary");
            } else {
                button.textContent = selectedTextTemplate.replace(
                    "{count}",
                    checkedCount,
                );
                button.classList.remove("text-secondary");
            }
        }

        // Change
        checkboxes.forEach((cb) => {
            cb.addEventListener("change", updateButton);
        });

        // Reset
        form.addEventListener("reset", () => {
            setTimeout(updateButton, 0);
        });

        // Initial state
        updateButton();
    });
}
