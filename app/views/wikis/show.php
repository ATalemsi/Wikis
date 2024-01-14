<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div class="p-8 sm:ml-64">
    <main class="container mx-auto mt-8">
        <div class="flex flex-wrap justify-between">

            <div id="wikis" class="w-full md:w-8/12 px-4 mb-8 flex flex-col gap-8">
                    <div class=" flex flex-col g-10 border-b-2 pb-8 border-gray-400">
                        <h2 class="text-4xl font-bold mt-4 mb-2"><?= $data['wikis']->Title; ?></h2>
                        <p class="text-gray-700 mb-4"><?= $data['wikis'] ->Content; ?>.</p>
                        <p class="text-gray-500 mb-2">By <?= $data['wikis']->FirstName; ?> <?= $data['wikis']->LastName; ?></p>

                        <?php if (!empty($data['wikis'] ->TagNames)) : ?>
                            <div class="flex flex-wrap gap-2 mt-4">
                                <?php
                                $tags = explode(", ", $data['wikis'] ->TagNames);
                                foreach ($tags as $tag) : ?>
                                    <span class="bg-gray-300 p-2 rounded"><?= $tag; ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mt-4">
                            <span class="bg-blue-300 p-2 rounded"><?= $data['wikis'] ->CategoryName; ?></span>
                        </div>
                        <p class="text-gray-500 mt-2">Created on <?= date('Y/m/d', strtotime($data['wikis']->CreationDate)); ?></p>
                        <div class="mt-4 ml-auto">
                            <?php if ( isset($_SESSION['user_id']) && $data['wikis']->AuthorID === $_SESSION['user_id'] && $_SESSION['UserRole'] == 'autheur') : ?>
                                <a href="<?= URLROOT . '/wikis/edit/' . $data['wikis']->WikiID; ?>" class="bg-green-500 text-white p-2 rounded">Update</a>
                                <a href="<?= URLROOT . '/wikis/delete/' . $data['wikis']->WikiID; ?>" class="bg-red-500 text-white p-2 rounded">Delete</a>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['UserRole']) && $_SESSION['UserRole'] == 'admin')   : ?>
                                <a href="<?= URLROOT . '/wikis/archiver/' . $data['wikis']->WikiID; ?>" class="bg-violet-500 text-white p-2 rounded">Archive</a>
                            <?php endif; ?>
                        </div>
                    </div>
            </div>
        </div>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>