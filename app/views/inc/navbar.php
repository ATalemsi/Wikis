<nav class="w-screen bg-teal-500 h-fit overflow-hidden">
    <div class="py-4 lg:px-8 px-4 max-w-[1280px] h-16 m-auto text-white flex items-center justify-between">
        <div>
            <h1 class="lg:text-2xl text-xl uppercase tracking-wider cursor-pointer font-bold"><a href="#" class="text-white">Wiki Platform</a></h1>
        </div>
        <div class="flex lg:gap-8 gap-6 uppercase tracking-wider cursor-pointer text-lg items-center" id="navItems">
            <a href="#categories" class="group">
                Categories
                <div class="w-0 group-hover:w-full h-0.5 bg-white ease-in-out duration-500"></div>
            </a>
            <a href="#tags" class="group">
                Tags
                <div class="w-0 group-hover:w-full h-0.5 bg-white ease-in-out duration-500"></div>
            </a>
            <a href="#wikis" class="group">
                Wikis
                <div class="w-0 group-hover:w-full h-0.5 bg-white ease-in-out duration-500"></div>
            </a>
            <a href="#dashboard" class="group">
                Dashboard
                <div class="w-0 group-hover:w-full h-0.5 bg-white ease-in-out duration-500"></div>
            </a>
            <a href="#login-register" class="group">
                Login/Register
                <div class="w-0 group-hover:w-full h-0.5 bg-white ease-in-out duration-500"></div>
            </a>
        </div>

        <!-- Responsive Menu Toggle Button (Hamburger Menu) -->
        <div id="hamburger" class="lg:hidden cursor-pointer">
            <div class="fa fa-bars text-xl"></div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileNav" class="hidden lg:hidden fixed flex flex-col gap-8 pt-16 px-4 text-xl uppercase bg-teal-500 h-full inset-0 top-16 w-[70%] left-[-70%] ease-in-out duration-500 cursor-pointer">
            <a href="#categories">Categories</a>
            <a href="#tags">Tags</a>
            <a href="#wikis">Wikis</a>
            <a href="#dashboard">Dashboard</a>
            <a href="#login-register">Login/Register</a>
        </div>
    </div>
</nav>
