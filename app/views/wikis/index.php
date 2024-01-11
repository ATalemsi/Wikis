<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div class="p-8 sm:ml-64">
    <main class="container mx-auto mt-8">
        <div class="flex flex-wrap justify-between">
            <div id="search-results" class="mt-4"></div>
            <div class="w-full md:w-8/12 px-4 mb-8 flex flex-col gap-8">
                <?php foreach ($data['wikis'] as $wiki) : ?>
                <div class=" flex flex-col g-10 border-b-2 pb-8 border-gray-400">
                    <h2 class="text-4xl font-bold mt-4 mb-2"><?= $wiki->Title; ?></h2>
                    <p class="text-gray-700 mb-4"><?= $wiki->Content; ?>.</p>

                    <?php if (!empty($wiki->TagNames)) : ?>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <?php
                        $tags = explode(", ", $wiki->TagNames);
                        foreach ($tags as $tag) : ?>
                            <span class="bg-gray-300 p-2 rounded"><?= $tag; ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="mt-4">
                        <span class="bg-blue-300 p-2 rounded"><?= $wiki->CategoryName; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="w-full md:w-1/4 px-4">
                <div class="sticky top-20">
                <div class="bg-gray-100 p-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Posts</h2>
                    <ul class="list-none">
                        <?php foreach ($data['recentPosts'] as $post) : ?>
                            <li class="mb-2">
                                <a href="<?php echo URLROOT?>/wikis/show/<?php $post->WikiID ?>" class="text-gray-700 hover:text-gray-900"><?= $post->Title; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    </ul>
                </div>
                <div class="bg-gray-100 p-4 mt-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Categories</h2>
                    <ul class="list-none">
                        <?php foreach ($data['recentCategories'] as $category) : ?>
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900"><?= $category->CategoryName; ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
             </div>
            </div>
        </div>
    </main>
</div>
<script>
    $(document).ready(function () {
        const searchInput = $('#search-navbar');
        const searchResultsContainer = $('#search-results');

        // Function to handle search
        function handleSearch() {
            const searchTerm = searchInput.val().trim();
            console.log('Search Term:', searchTerm)

            if (searchTerm.length > 0) {
                // Perform AJAX request to search endpoint in your controller
                $.ajax({
                    url: `/wikis/search/${searchTerm}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function (results) {
                        console.log('search Wikis Results:', results);
                        updateSearchResults(results);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', status, error);
                        console.log('Response Text:', xhr.responseText); // Log the response text
                    }
                });
            } else {
                // If search term is empty, show all wikis
                $.ajax({
                    url: '/wikis/index', // Adjust the URL based on your routing
                    method: 'GET',
                    dataType: 'html',
                    success: function (results) {
                        console.log('All Wikis Results:', results);
                        updateSearchResults(results);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });
            }
        }

        // Event listener for search input
        searchInput.on('input', handleSearch);

        // Initial call to load all wikis
        handleSearch();

        // Function to update search results
        function updateSearchResults(results) {
            // Update the search results container
            let html = '';

            if (results.length > 0) {
                $.each(results, function (index, result) {
                    html += `<div class="search-result">
                            <h2 class="text-4xl font-bold mt-4 mb-2">${result.Title}</h2>
                            <p class="text-gray-700 mb-4">${result.Content}.</p>
                            <div class="flex flex-wrap gap-2 mt-4">
                                ${result.TagNames ? result.TagNames.split(', ').map(tag => `<span class="bg-gray-300 p-2 rounded">${tag}</span>`).join('') : ''}
                            </div>
                            <div class="mt-4">
                                <span class="bg-blue-300 p-2 rounded">${result.CategoryName}</span>
                            </div>
                        </div>`;
                });
            } else {
                html = '<div>No results found</div>';
            }

            searchResultsContainer.html(html);
        }
    });

</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
