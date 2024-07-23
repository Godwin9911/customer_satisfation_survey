<div class="mx-auto max-w-7xl p-4 py-10">
    <h1 class="text-xl font-semibold leading-7 text-gray-900 text-center my-4">Responses</h1>
    <table class="border-collapse table-auto w-full text-sm">
        <thead>
            <tr>
                <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3  text-left">
                    Phone
                </th>
                <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3  text-left">
                    Question
                </th>
                <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3  text-left">
                    Rating
                </th>
                <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3  text-left">
                    Date
                </th>
            </tr>
        </thead>
        <tbody class="">
            <?php foreach ($customer_ratings as $index => $rating): ?>
                <tr class="<?php $index % 2 === 0 ? 'bg-gray-50' : '' ?>">
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4  text-slate-500 ">
                        <?php echo htmlspecialchars($rating['phone']);
                        ?>
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4  text-slate-500 ">
                        <?php echo htmlspecialchars($rating['question']); ?>
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4  text-slate-500 ">
                        <?php echo htmlspecialchars($rating['rating']); ?>
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4  text-slate-500 ">
                        <?php echo htmlspecialchars($rating['created_at']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>