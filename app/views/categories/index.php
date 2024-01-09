<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div class="p-8 sm:ml-64">
    <div class="flex justify-between items-center mb-8 my-16">
        <h1 class="text-2xl font-bold">Categories</h1>
        <a href="#" onclick="openAddCategoryModal()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">+Add Category</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
        <?php foreach ($data['categories'] as $category) :?>
            <div class="bg-white rounded-lg shadow-md p-4">
                <h2 class="text-xl font-bold mb-2"><?php echo $category->CategoryName; ?></h2>

                <div class="flex space-x-4">
                    <a href="<?php echo URLROOT; ?>/categories/delete/<?php echo $category->CategoryID; ?>"
                       class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</a>
                    <button onclick="openUpdateCategoryModal('<?php echo $category->CategoryID; ?>', '<?php echo $category->CategoryName; ?>')"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded-md shadow-md">
        <h2 class="text-2xl font-bold mb-4">Add Category</h2>

        <!-- Category Form -->
        <form action="<?php echo URLROOT; ?>/categories/add" method="post">
            <div class="mb-4">
                <label for="categoryName" class="block text-gray-700 font-semibold mb-2">Category Name</label>
                <input type="text" id="categoryName" name="categoryName" class="w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeAddCategoryModal()" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                <button type="submit" name="Submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Category</button>
            </div>
        </form>
    </div>
</div>
<?php if (isset($data['modal']) && $data['modal']) : ?>
    <div id="updateCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-md shadow-md">
            <h2 class="text-2xl font-bold mb-4">Update Category</h2>
            <form action="<?php echo URLROOT; ?>/categories/edit" method="post">
                <input type="hidden" id="updateCategoryId" name="categoryId" value="">
                <div class="mb-4">
                    <label for="updateCategoryName" class="block text-gray-700 font-semibold mb-2">Category Name</label>
                    <input type="text" id="updateCategoryName" name="categoryName" class="w-full p-2 border border-gray-300 rounded-md">
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeUpdateCategoryModal()" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                    <button type="submit" name="Submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Category</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<script>
    function openAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.remove('hidden');
    }

    function closeAddCategoryModal() {
        document.getElementById('addCategoryModal').classList.add('hidden');
    }
    function openUpdateCategoryModal(categoryId, categoryName) {
        document.getElementById('updateCategoryId').value = categoryId;
        document.getElementById('updateCategoryName').value = categoryName;
        document.getElementById('updateCategoryModal').classList.remove('hidden');
    }

    function closeUpdateCategoryModal() {
        document.getElementById('updateCategoryModal').classList.add('hidden');
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
