<div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-20 lg:px-8">
  <div class="mx-auto max-w-2xl">
    <form method="POST">
      <?php if (isset($_SESSION['message'])): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
          <p class="font-bold">Success!</p>
          <p>
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
          </p>
        </div>
      <?php endif; ?>

      <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
          <h1 class="text-xl font-semibold leading-7 text-gray-900">Create:</h1>
          <p class="mt-1 text-sm leading-6 text-gray-600">
            Create your feedback survey
          </p>

          <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full">
              <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
              <div class="mt-2">
                <input id="title" name="title" type="title" autocomplete="title" placeholder="Enter Title"
                  value="Customer Satisfaction Survey" required
                  class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
              </div>
            </div>

            <div class="col-span-full">
              <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
              <div class="mt-2">
                <textarea id="about" name="description" rows="2" placeholder="Enter Description" required
                  class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6"></textarea>
              </div>
            </div>

            <hr class="col-span-full" />

            <div class="col-span-full">
              <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Opening Message:</label>
              <div class="mt-2">
                <textarea id="about" name="opening_message" rows="2" placeholder="Opening Message"
                  class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
Thank you for choosing our Service. Please rate each statement from 1 (very dissatisfied) to 5 (very satisfied) on your phone. Your feedback is important to us.</textarea>
              </div>
            </div>

            <div class="col-span-full">
              <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Question(s)</label>
              <div id="input-container">
                <div class="mt-2 flex gap-4 items-center input-item">
                  <span>1:</span>
                  <input type="text" name="questions[]" id="question-1" autocomplete="street-address"
                    placeholder="Question 1" value="How satisfied are you with our service overall?"
                    class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                  <button class="remove-button">✖️</button>
                </div>
              </div>
              <button id="add-input" type="button" class="text-sm font-semibold leading-6 text-gray-900 my-3">
                + Add
              </button>
            </div>

            <div class="col-span-4">
              <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Customer Phone
                Number(s)</label>

              <div id="phone-container">
                <div class="mt-2 flex gap-4 items-center phone-item">
                  <span>1:</span>
                  <input type="text" name="survey_customers[]" id="phone" autocomplete="phone" placeholder="Phone 1"
                    value="" required
                    class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                  <button class="remove-button">✖️</button>
                </div>
              </div>
              <button id="add-phone-input" type="button" class="text-sm font-semibold leading-6 text-gray-900 my-3">
                + Add
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-6 flex items-center justify-end gap-x-6">
        <button type="button" class="text-sm font-semibold leading-6 text-gray-900">
          Cancel
        </button>
        <button type="submit"
          class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
          Send Calls
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  window.addEventListener("load", () => {
    // Get reference to the container and the button
    const inputContainer = document.getElementById("input-container");
    const addButton = document.getElementById("add-input");

    // Counter to track the number of inputs (initialized to 1)
    let inputCount = 1;

    // Function to initialize the form with one input field
    function initializeForm() {
      const initialInput = inputContainer.querySelector(".input-item");
      initialInput.classList.remove("hidden"); // Show the initial input field

      // Add event listener to initial remove button
      const initialRemoveButton = initialInput.querySelector(".remove-button");
      initialRemoveButton.addEventListener("click", () => {
        initialInput.remove();
        updateLabels();
      });

      addButton.disabled = false; // Enable add button after initialization
    }

    // Function to add a new input field with remove button
    function addInput() {
      inputCount++;

      // Create a new div to hold the input and other elements
      const inputDiv = document.createElement("div");
      inputDiv.classList.add(
        "mt-2",
        "flex",
        "gap-4",
        "items-center",
        "input-item"
      );

      // Create a span element for the label
      const label = document.createElement("span");
      label.textContent = `${inputCount}:`;

      // Create the input element
      const newInput = document.createElement("input");
      newInput.type = "text";
      newInput.name = `questions[]`;
      newInput.id = `question-${inputCount}`;
      newInput.autocomplete = "street-address";
      newInput.placeholder = `Question ${inputCount}`;
      newInput.classList.add(
        "px-2",
        "block",
        "w-full",
        "rounded-md",
        "border-0",
        "py-1.5",
        "text-gray-900",
        "shadow-sm",
        "ring-1",
        "ring-inset",
        "ring-gray-300",
        "placeholder:text-gray-400",
        "focus:ring-2",
        "focus:ring-inset",
        "focus:ring-gray-600",
        "sm:text-sm",
        "sm:leading-6"
      );

      // Create the remove button
      const removeButton = document.createElement("button");
      removeButton.textContent = "✖️";
      removeButton.classList.add("remove-button");
      removeButton.addEventListener("click", () => {
        // Remove the entire inputDiv when removeButton is clicked
        inputDiv.remove();
        // Update labels after removal
        updateLabels();
      });

      // Append label, input, and remove button to the div
      inputDiv.appendChild(label);
      inputDiv.appendChild(newInput);
      inputDiv.appendChild(removeButton);

      // Append the new div to the container
      inputContainer.appendChild(inputDiv);

      // Function to update labels after removing an input
      function updateLabels() {
        // Select all input items
        const inputItems = inputContainer.querySelectorAll(".input-item");
        // Update labels based on their index
        inputItems.forEach((item, index) => {
          const label = item.querySelector("span");
          label.textContent = `${index + 1}:`;
          const input = item.querySelector("input");
          input.placeholder = `Question ${index + 1}`;
        });
      }
    }

    // Initialize the form with one input field
    initializeForm();

    // Event listener for the button click to add more inputs
    addButton.addEventListener("click", addInput);

    //=============================================================================

    // Get reference to the phone container and the add button
    const phoneContainer = document.getElementById("phone-container");
    const addPhoneButton = document.getElementById("add-phone-input");

    // Counter to track the number of phone inputs (initialized to 1)
    let phoneCount = 1;

    // Function to initialize the form with one phone input
    function initializePhoneForm() {
      const initialPhoneInput = phoneContainer.querySelector(".phone-item");
      initialPhoneInput.classList.remove("hidden"); // Show the initial phone input

      // Add event listener to initial remove button
      const initialRemoveButton =
        initialPhoneInput.querySelector(".remove-button");
      initialRemoveButton.addEventListener("click", () => {
        initialPhoneInput.remove();
        updatePhoneLabels();
      });

      addPhoneButton.disabled = false; // Enable add button after initialization
    }

    // Function to add a new phone input field with remove button
    function addPhoneInput() {
      phoneCount++;

      // Create a new div to hold the phone input and other elements
      const phoneDiv = document.createElement("div");
      phoneDiv.classList.add(
        "phone-item",
        "mt-2",
        "flex",
        "gap-4",
        "items-center"
      );

      // Create a span element for the label
      const label = document.createElement("span");
      label.textContent = `${phoneCount}:`;

      // Create the input element for phone number
      const newPhoneInput = document.createElement("input");
      newPhoneInput.type = "text";
      newPhoneInput.name = `survey_customers[]`;
      newPhoneInput.id = `phone-${phoneCount}`;
      newPhoneInput.autocomplete = "phone";
      newPhoneInput.placeholder = `Phone ${phoneCount}`;
      newPhoneInput.classList.add(
        "px-2",
        "block",
        "w-full",
        "rounded-md",
        "border-0",
        "py-1.5",
        "text-gray-900",
        "shadow-sm",
        "ring-1",
        "ring-inset",
        "ring-gray-300",
        "placeholder:text-gray-400",
        "focus:ring-2",
        "focus:ring-inset",
        "focus:ring-gray-600",
        "sm:text-sm",
        "sm:leading-6"
      );

      // Create the remove button for phone input
      const removePhoneButton = document.createElement("button");
      removePhoneButton.textContent = "✖️";
      removePhoneButton.classList.add("remove-button");
      removePhoneButton.addEventListener("click", () => {
        // Remove the entire phoneDiv when removePhoneButton is clicked
        phoneDiv.remove();
        // Update labels after removal
        updatePhoneLabels();
      });

      // Append label, phone input, and remove button to the phone div
      phoneDiv.appendChild(label);
      phoneDiv.appendChild(newPhoneInput);
      phoneDiv.appendChild(removePhoneButton);

      // Append the new phone div to the phone container
      phoneContainer.appendChild(phoneDiv);

      // Function to update labels after removing a phone input
      function updatePhoneLabels() {
        // Select all phone items
        const phoneItems = phoneContainer.querySelectorAll(".phone-item");
        // Update labels based on their index
        phoneItems.forEach((item, index) => {
          const label = item.querySelector("span");
          label.textContent = `${index + 1}:`;
          const input = item.querySelector("input");
          input.placeholder = `Phone ${index + 1}`;
        });
      }
    }

    // Initialize the form with one phone input field
    initializePhoneForm();

    // Event listener for the button click to add more phone inputs
    addPhoneButton.addEventListener("click", addPhoneInput);
  });
</script>