<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div class="p-8 sm:ml-64">
    <form action="/your-submit-endpoint" method="post" class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
        <div class="mb-4">
            <label for="title" class="block text-sm font-semibold text-gray-600">Title:</label>
            <input type="text" id="title" name="title" required
                   class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold text-gray-600">Description:</label>
            <textarea id="description" name="description" rows="4" required
                      class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>
        </div>

        <div class="mb-4">
            <label for="category" class="block text-sm font-semibold text-gray-600">Category:</label>
            <select id="category" name="category" onchange="showTags(this.value)" required
                    class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:border-blue-500">
                <option value="" disabled selected>Select Category</option>
                <option value="science">Science</option>
                <option value="technology">Technology</option>
                <option value="history">History</option>
                <!-- Add more categories as needed -->
            </select>
        </div>

        <div id="tagsContainer" style="display: none" class="mb-4">
            <label for="tags" class="block text-sm font-semibold text-gray-600">Tags:</label>
            <select id="tags" name="tags[]" multiple
                    class="w-full mt-1 p-2 border rounded-md focus:outline-none focus:border-blue-500">
                <!-- Tags will be dynamically added here based on the selected category -->
            </select>
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
            Add Wiki
        </button>
    </form>

</div>
    <script>
        var categoryTags = {
            science: ["biology", "physics", "chemistry"],
            technology: ["programming", "web-development", "artificial-intelligence"],
            history: ["ancient-history", "modern-history"]
            // Add more relationships as needed
        };

        function showTags(selectedCategory) {
            var tagsContainer = document.getElementById('tagsContainer');
            var tagsSelect = document.getElementById('tags');

            // Clear existing options
            tagsSelect.innerHTML = '';

            if (selectedCategory) {
                // Get tags for the selected category
                var categoryRelationship = categoryTags[selectedCategory];

                if (categoryRelationship) {
                    // Populate the tags dropdown with options
                    categoryRelationship.forEach(function(tag) {
                        var option = document.createElement('option');
                        option.value = tag;
                        option.text = tag;
                        tagsSelect.add(option);
                    });
                }

                // Display the tags container
                tagsContainer.style.display = 'block';
            } else {
                // Hide the tags container if no category is selected
                tagsContainer.style.display = 'none';
            }
        }
    </script>
<?php require APPROOT . '/views/inc/footer.php'; ?>

