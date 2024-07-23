</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Customer Satisfation Survey</title>
</head>

<body class="bg-gray-100">
    <nav class="bg-gray-800 p-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between h-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="text-white text-lg font-semibold flex gap-1 items-center"><svg
                                xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M10 1.5l1.902 5.797h6.146L12.9 9.552 14.804 15 10 11.5 5.196 15l1.904-5.448L1.951 7.297h6.146L10 1.5z" />
                            </svg>


                            Customer Satisfation Survey</a>
                    </div>
                </div>
                <div class="md:block">
                    <div class="ml-4 flex items-center md:ml-6">

                        <a href="/survey/create"
                            class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Create
                        </a>
                        <a href="/survey/"
                            class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">View
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <div class="max-w-7xl mx-auto p-4">
        <div class="bg-white">
            <?php echo isset($content) ? $content : ''; ?>
        </div>
    </div>

    <!-- Include your JavaScript files here -->
</body>

</html>