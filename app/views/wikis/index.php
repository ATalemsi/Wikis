<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div class="p-8 sm:ml-64">
    <main class="container mx-auto mt-8">
        <div class="flex flex-wrap justify-between">
            <div id="search_result" class="w-full md:w-8/12 px-4 mb-8 flex flex-col gap-8"></div>
            <div id="wikis" class="w-full md:w-8/12 px-4 mb-8 flex flex-col gap-8">
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

                        <!-- Only show the buttons if the user is authenticated and owns the wiki -->
                    <div class="mt-4 ml-auto">
                        <?php if ($wiki->AuthorID === $_SESSION['user_id'] && $_SESSION['UserRole'] == 'autheur') : ?>
                            <a href="<?= URLROOT . '/wikis/edit/' . $wiki->WikiID; ?>" class="bg-green-500 text-white p-2 rounded">Update</a>
                            <a href="<?= URLROOT . '/wikis/delete/' . $wiki->WikiID; ?>" class="bg-red-500 text-white p-2 rounded">Delete</a>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['UserRole']) && $_SESSION['UserRole'] == 'admin')   : ?>
                            <a href="<?= URLROOT . '/wikis/archiver/' . $wiki->WikiID; ?>" class="bg-violet-500 text-white p-2 rounded">Archive</a>
                        <?php endif; ?>
                        <a href="<?= URLROOT . '/wikis/show/' . $wiki->WikiID; ?>" class="bg-blue-500 text-white p-2 rounded">Show More</a>
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
                           <?php if ($post->archive ==1): ?>
                            <li class="mb-2">
                                <a href="<?php echo URLROOT?>/wikis/show/<?php $post->WikiID ?>" class="text-gray-700 hover:text-gray-900"><?= $post->Title; ?></a>
                            </li>
                            <?php endif; ?>
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
    $("#search-navbar").keyup(function() {
        var input = $(this).val();
        console.log("bgggggg");


        if (input != "") {
            // alert(input);
            const fetchUrl = "<?php echo URLROOT . '/wikis/search'; ?>";
            $.ajax({
                url: fetchUrl,
                method: "POST",
                data: {

                    input: input
                },
                // dataType: 'json',
                success: function(tasks) {
                    console.log(tasks);
                    $("#search_result").html(tasks);


                },
                error: function(xhr, status, error) {
                    console.error('Error fetching tasks:', status, error);
                }
            });
            $("#wikis").hide();
            $("#search_result").show()

        } else {
            $("#wikis").show();
            $("#search_result").hide()

        }

    })

</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
