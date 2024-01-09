<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div class="p-8 sm:ml-64">
    <main class="container mx-auto mt-8">
        <div class="flex flex-wrap justify-between">
            <div class="w-full md:w-8/12 px-4 mb-8 flex flex-col gap-8">
                <div class="mt-4 my-8">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Add Wiki</button>
                </div>
                <div class=" flex flex-col g-10 border-b-2 pb-8 border-gray-400">
                    <img src="https://via.placeholder.com/1200x600" alt="Featured Image" class="w-full h-64 object-cover rounded">
                    <h2 class="text-4xl font-bold mt-4 mb-2">My First Blog Post</h2>
                    <p class="text-gray-700 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <p class="text-gray-700 mb-4">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                        eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                        deserunt mollit anim id est laborum.</p>
                    <p class="text-gray-700 mb-4">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                        doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
                        architecto beatae vitae dicta sunt explicabo.</p>

                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="bg-gray-300 p-2 rounded">Tag 1</span>
                        <span class="bg-gray-300 p-2 rounded">Tag 2</span>

                    </div>

                    <div class="mt-4">
                        <span class="bg-blue-300 p-2 rounded">Category 1</span>
                    </div>
                </div>
                <div class=" flex flex-col g-10">
                    <img src="https://via.placeholder.com/1200x600" alt="Featured Image" class="w-full h-64 object-cover rounded">
                    <h2 class="text-4xl font-bold mt-4 mb-2">My First Blog Post</h2>
                    <p class="text-gray-700 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <p class="text-gray-700 mb-4">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                        eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                        deserunt mollit anim id est laborum.</p>
                    <p class="text-gray-700 mb-4">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                        doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
                        architecto beatae vitae dicta sunt explicabo.</p>
                </div>
            </div>
            <div class="w-full md:w-1/4 px-4">
                <div class="sticky top-20">
                <div class="bg-gray-100 p-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Posts</h2>
                    <ul class="list-none">
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900">Blog Post 1</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900">Blog Post 2</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900">Blog Post 3</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900">Blog Post 4</a>
                        </li>
                    </ul>
                </div>
                <div class="bg-gray-100 p-4 mt-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Categories</h2>
                    <ul class="list-none">
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900">Category 1</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900">Category 2</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900">Category 3</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-gray-700 hover:text-gray-900">Category 4</a>
                        </li>
                    </ul>
                </div>
             </div>
            </div>
        </div>
    </main>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
