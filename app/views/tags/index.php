<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div class="p-8 sm:ml-64">
    <div class="flex justify-between items-center mb-8 my-16">
        <h1 class="text-2xl font-bold">Tags</h1>
        <a href="#" onclick="openAddTagModal()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">+Add Tag</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
        <?php foreach ($data['tags'] as $tag) : ?>
            <div class="bg-white rounded-lg shadow-md p-4">
                <h2 class="text-xl font-bold mb-2"><?php echo $tag->TagName; ?></h2>

                <div class="flex space-x-4">
                    <a href="<?php echo URLROOT; ?>/tags/delete/<?php echo $tag->TagID; ?>"
                       class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</a>
                    <button onclick="openUpdateTagModal('<?php echo $tag->TagID; ?>', '<?php echo $tag->TagName; ?>')"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Add Tag Modal -->
<div id="addTagModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded-md shadow-md">
        <h2 class="text-2xl font-bold mb-4">Add Tag</h2>

        <!-- Tag Form -->
        <form action="<?php echo URLROOT; ?>/tags/add" method="post" onsubmit="return validateTagsForm()">
            <div class="mb-4">
                <label for="tagName" class="block text-gray-700 font-semibold mb-2">Tag Name</label>
                <input type="text" id="tagName" name="tagName" class="w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeAddTagModal()" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                <button type="submit" name="Submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add Tag</button>
            </div>
        </form>
    </div>
</div>

<!-- Update Tag Modal -->
<div id="updateTagModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded-md shadow-md">
        <h2 class="text-2xl font-bold mb-4">Update Tag</h2>
        <form action="<?php echo URLROOT; ?>/tags/edit" method="post" onsubmit="return validateUpdateTagsForm()" >
            <input type="hidden" id="updateTagId" name="tagId" value="">
            <div class="mb-4">
                <label for="updateTagName" class="block text-gray-700 font-semibold mb-2">Tag Name</label>
                <input type="text" id="updateTagName" name="tagName" class="w-full p-2 border border-gray-300 rounded-md">
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeUpdateTagModal()" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                <button type="submit" name="Submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Tag</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddTagModal() {
        document.getElementById('addTagModal').classList.remove('hidden');
    }

    function closeAddTagModal() {
        document.getElementById('addTagModal').classList.add('hidden');
    }

    function openUpdateTagModal(tagId, tagName) {
        document.getElementById('updateTagId').value = tagId;
        document.getElementById('updateTagName').value = tagName;
        document.getElementById('updateTagModal').classList.remove('hidden');
    }

    function closeUpdateTagModal() {
        document.getElementById('updateTagModal').classList.add('hidden');
    }
    function validateTagsForm() {
        var tagNameInput = document.getElementById('tagName').value;
        if (!/^[a-zA-Z0-9](?:[a-zA-Z0-9 ]*[a-zA-Z0-9])?$/.test(tagNameInput)) {
            // Invalid input, display error message or prevent form submission
            alert('Invalid Tag Name');
            return false;
        }
        return true;
    }
    function validateUpdateTagsForm() {
        var tagUpdateName = document.getElementById('updateTagName').value;

        if (!/^[a-zA-Z0-9](?:[a-zA-Z0-9 ]*[a-zA-Z0-9])?$/.test(tagUpdateName)) {
            // Invalid input, display error message or prevent form submission
            alert('Invalid Tag Name');
            return false;
        }
        return true;
    }
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
