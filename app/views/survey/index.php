<div class="mx-auto max-w-7xl p-4 py-10">
  <h1 class="text-xl font-semibold leading-7 text-gray-900 text-center my-4">
    Surveys
  </h1>
  <table class="border-collapse table-auto w-full text-sm">
    <thead>
      <tr>
        <th
          class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-left"
        >
          Title
        </th>
        <th
          class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-left"
        >
          Description
        </th>
        <th
          class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-left"
        >
          Opening Message
        </th>
        <th
          class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-left"
        >
          Date
        </th>
        <th
          class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-left"
        ></th>
      </tr>
    </thead>
    <tbody class="">
      <?php foreach ($surveys as $index =>
      $survey): ?>
      <tr class="<?php $index % 2 === 0 ? 'bg-gray-50' : '' ?>">
        <td
          class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500"
        >
          <?php echo htmlspecialchars($survey['title']); ?>
        </td>
        <td
          class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500"
        >
          <?php echo htmlspecialchars($survey['description']); ?>
        </td>
        <td
          class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500"
        >
          <?php echo htmlspecialchars($survey['opening_message']); ?>
        </td>
        <td
          class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500"
        >
          <?php echo htmlspecialchars($survey['created_at']); ?>
        </td>
        <td
          class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500"
        >
          <a
            href="/survey/responses/<?php echo $survey['id']; ?>"
            class="text-sm font-semibold leading-6 text-gray-900"
          >
            View Responses
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
