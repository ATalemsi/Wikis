<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="min-h-screen flex items-center justify-center">
    <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg bg-gray-800 lg:max-w-4xl">
        <div class="hidden bg-cover lg:block lg:w-1/2" style="background-image: url('https://images.unsplash.com/photo-1606660265514-358ebbadc80d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1575&q=80');"></div>

        <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">
            <div class="flex justify-center mx-auto">
                <img class="w-auto h-7 sm:h-8" src="<?php echo  URLROOT?>/public/img/wikiLOGO.png" alt="">
            </div>

            <p class="mt-3 text-xl text-center text-gray-600 text-gray-200">
                Join us now!
            </p>
            <div class="flex items-center justify-between mt-4">
                <span class="w-1/5 border-b border-gray-600 lg:w-1/4"></span>

                <span class="text-xs text-center text-gray-500 uppercase text-gray-400 hover:underline">entre your inforamtion</span>

                <span class="w-1/5 border-b border-gray-400 lg:w-1/4"></span>
            </div>

            <form action="<?php echo URLROOT; ?>/users/register" method="post" class="mt-4" onsubmit="return validateRegistrationForm()">
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600 text-gray-200 " for="firstname">First Name</label>
                    <input id="firstname" name="firstname" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg bg-gray-800 text-gray-300 border-gray-600 focus:border-blue-400 focus:ring-opacity-40 focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300   <?php echo (!empty($data['firstname_err'])) ? 'invalid:border-red-500' : ''; ?>" value="<?php echo $data['firstname']; ?>" type="text" />
                    <span class="mt-2 text-sm text-red-500 <?php echo (!empty($data['firstname_err'])) ? 'block' : 'hidden'; ?>"><?php echo $data['firstname_err']; ?></span>
                </div>
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600 text-gray-200 " for="lastname">Last Name</label>
                    <input id="lastname" name="lastname" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg bg-gray-800 text-gray-300 border-gray-600 focus:border-blue-400 focus:ring-opacity-40 focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300    <?php echo (!empty($data['lastname_err'])) ? 'invalid:border-red-500' : ''; ?>" value="<?php echo $data['lastname']; ?>" type="text" />
                    <span class="mt-2 text-sm text-red-500 <?php echo (!empty($data['lastname_err'])) ? 'block' : 'hidden'; ?>"><?php echo $data['lastname_err']; ?></span>
                </div>
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600 text-gray-200 " for="RegisterEmailAddress">Email Address</label>
                    <input id="RegisterEmailAddress" name="email" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg bg-gray-800 text-gray-300 border-gray-600 focus:border-blue-400 focus:ring-opacity-40 focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300   <?php echo (!empty($data['email_err'])) ? 'invalid:border-red-500' : ''; ?>" value="<?php echo $data['Email']; ?>" type="text" />
                    <span class="mt-2 text-sm text-red-500 <?php echo (!empty($data['email_err'])) ? 'block' : 'hidden'; ?>"><?php echo $data['email_err']; ?></span>
                </div>

                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600 text-gray-200" for="RegisterPassword">Password</label>
                    <input id="RegisterPassword" name="password" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg bg-gray-800 text-gray-300 border-gray-600 focus:border-blue-400 focus:ring-opacity-40 focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300 <?php echo (!empty($data['password_err'])) ? 'invalid:border-red-500' : ''; ?>" value="<?php echo $data['password']; ?>" type="password" />
                    <span class="mt-2 text-sm text-red-500 <?php echo (!empty($data['password_err'])) ? 'block' : 'hidden'; ?>"><?php echo $data['password_err']; ?></span>
                </div>

                <div class="mt-6">
                    <button type="submit" name="Submit" class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        Sign In
                    </button>
                </div>
            </form>

            <div class="flex items-center justify-between mt-4">
                <span class="w-1/5 border-b border-gray-600 md:w-1/4"></span>

                <a href="<?php echo URLROOT; ?>/users/login" class="text-xs text-gray-500 uppercase text-gray-400 hover:underline">or login</a>

                <span class="w-1/5 border-b border-gray-600 md:w-1/4"></span>
            </div>
        </div>
    </div>
</div>
<script>
    function validateRegistrationForm() {

        var firstName = document.getElementById('firstname').value;
        var lastName = document.getElementById('lastname').value;
        var email = document.getElementById('RegisterEmailAddress').value;


        var nameRegex = /^[A-Za-z]{3,}$/;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


        if (!nameRegex.test(firstName)) {
            alert('Invalid First Name! It must contain only letters and be at least 3 characters long.');
            return false;
        }


        if (!nameRegex.test(lastName)) {
            alert('Invalid Last Name! It must contain only letters and be at least 3 characters long.');
            return false;
        }


        if (!emailRegex.test(email)) {
            alert('Invalid email address!');
            return false;
        }

        return true;
    }
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>

