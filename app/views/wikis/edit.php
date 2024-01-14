<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div class="p-8 sm:ml-64">
    <div id="formWiki" class="lg:mt-16 grid max-w-screen-xl grid-cols-1 gap-8 px-8 py-16 mx-auto rounded-lg md:grid-cols-2 md:px-12 lg:px-16 xl:px-32 items-center">
        <div class="flex flex-col justify-between">
            <div class="space-y-2">
                <h2 class="text-4xl font-bold leading-lg lg:text-5xl">Let's share knowledge!</h2>
                <div class="text-gray-600 dark:text-gray-400">Vivamus in nisl metus? Phasellus.</div>
            </div>
            <img src="<?= URLROOT; ?>/public/img/wikiLOGO.png" alt="Wiki Logo" class="p-6 h-52 md:h-64">
        </div>
        <form method="post" action="<?= URLROOT; ?>/wikis/edit/<?php echo $data['wiki']->WikiID ?>" class="space-y-6 border h-fit p-4 rounded border-black">



            <div class="w-full">
                <label class="block text-lg font-semibold mb-2 text-black" for="grid-state">
                    Choose new Categories
                </label>
                <div class="relative">
                    <select name="categorieID" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required id="grid-state">
                        <option value="">Sélectionnez une catégorie</option>
                        <?php foreach ($data['categories'] as $categorie) : ?>
                            <option value="<?= $categorie->CategoryID; ?>" <?php echo ($categorie->CategoryID == $data['mycategories']->CategoryID) ? 'selected'  : ''; ?>><?= $categorie->CategoryName; ?> </option>
                        <?php endforeach; ?>
                    </select>

                </div>
            </div>



            <div class="w-full">
                <label class="block text-lg font-semibold mb-2 text-black" for="grid-state-tags">
                    Choose Your  new Tags
                </label>
                <div class="relative">
                    <select name="tagname" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state-tags">
                        <option value="">Sélectionnez un tag</option>
                        <?php foreach ($data['tags'] as $tag) : ?>
                            <option value="<?= $tag->TagID; ?>"><?= $tag->TagName; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <input type="hidden" id="selected_tag_id" name="selected_tag_id" value="">
            <div id="selected-tag-names"></div>
            <div class="mt-4">
                <label class="block text-sm font-semibold text-gray-700" for="titre">Title</label>
                <input type="text" name="titre" class="w-full p-3 border rounded border-black bg-white bg-gray-800 text-gray-800 <?php echo (!empty($data['titre_err'])) ? 'invalid:border-red-500' : ''; ?> " value="<?php echo $data['wiki']->Title; ?>">
                <span class="mt-2 text-sm text-red-500 <?php echo (!empty($data['titre_err'])) ? 'block' : 'hidden'; ?>"><?php echo $data['titre_err']; ?></span>
            </div>

            <div class="mt-4">
                <label for="content" class="block text-sm font-semibold text-gray-700">Description</label>
                <textarea id="content" name="content" rows="3" class="w-full p-3 border rounded border-black bg-white bg-gray-800 text-gray-800 <?php echo (!empty($data['content_err'])) ? 'invalid:border-red-500' : ''; ?> "><?php echo $data['wiki']->Content; ?></textarea>
                <span class="mt-2 text-sm text-red-500 <?php echo (!empty($data['content_err'])) ? 'block' : 'hidden'; ?>"><?php echo $data['content_err']; ?></span>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white text-sm font-bold uppercase rounded hover:bg-blue-600 dark:bg-gray-800 text-gray-900 py-3">
                update your wiki
            </button>
        </form>
    </div>


    <script>

        document.addEventListener("DOMContentLoaded", function(event) {
            var selectedTagIds = [];

            <?php

            foreach ($data['mytags'] as $tag) { ?>
            selectedTagIds.push(JSON.stringify(<?php echo ($tag->TagID); ?>))
            updateDisplayedTags()
            <?php  } ?>

                function updateDisplayedTags() {
                    event.preventDefault();
                    var tagsContainer = document.getElementById("selected-tag-names");
                    var selectedTagIdInput = document.getElementById("selected_tag_id");
                    tagsContainer.innerHTML = "";

                    selectedTagIds.forEach(function(tagId) {
                        var tagName = getTagNameById(tagId);
                        // Fonction pour récupérer le nom du tag
                        var tag = document.createElement("span");
                        tag.className = "selected-tag";
                        tag.innerHTML = "<span class='bg-blue-500 text-white p-1 rounded-md m-1'>" + tagName + "</span><button class='text-red-500' data-tag-id=\"" + tagId + "\">Remove</button>";
                        tagsContainer.appendChild(tag);

                        // Attach the click event to the Remove button
                        var removeButton = tag.querySelector("button");
                        removeButton.addEventListener("click", removeTag);
                    });


                    selectedTagIdInput.value = JSON.stringify(selectedTagIds);
                    console.log(selectedTagIdInput.value);
                }

                function getTagNameById(tagId) {
                    // Fonction pour récupérer le nom du tag à partir du tableau de données des tags
                    var tag = <?php echo json_encode($data['tags']); ?>;
                for (var i = 0; i < tag.length; i++) {
                    if (tag[i].TagID == tagId) {
                        return tag[i].TagName;
                    }
                }
                return "";
            }

            function removeTag(event) {
                var tagId = event.target.dataset.tagId;
                var index = selectedTagIds.indexOf(tagId);
                if (index !== -1) {
                    selectedTagIds.splice(index, 1);
                    updateDisplayedTags();
                }
            }

            // Event listener for the select element
            var selectElement = document.getElementById("grid-state-tags");
            selectElement.addEventListener("change", function() {
                var selectedTagId = selectElement.value;
                if (selectedTagId && !selectedTagIds.includes(selectedTagId)) {
                    selectedTagIds.push(selectedTagId);
                    updateDisplayedTags();
                }
            });
        });
        var titleInput = document.getElementById('title');
        var contentInput = document.getElementById('content');

        function validateWikiForm() {
            // Validate Title
            var titleValue = titleInput.value.trim();
            if (!/^[a-zA-Z0-9](?:[a-zA-Z0-9 ]*[a-zA-Z0-9])?$/.test(titleValue) || titleValue.length < 3) {
                alert('Invalid title  must be at least 3 characters.  ');
                return false;

            }
            // Validate Content
            var contentValue = contentInput.value.trim();
            if (contentValue.length < 30) {
                alert('Content must be at least 30 characters.');
                return false;
            }
            // Return true if all validations pass
            return true;
        }
    </script>
    <?php require APPROOT . '/views/inc/footer.php'; ?>

