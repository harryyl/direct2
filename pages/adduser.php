<?php



if ($connection = OpenCon('direct2')) {

    echo '<h4>add user:</h4><form method="post"><label for="name">name:</label><input name="name" id="name" type="text"><label for="gender">gender:</label><select name="gender" id="gender"><option value="male">male</option><option value="female">female</option><option value="other">other</option></select><button type="submit">Submit</button></form>';

        if (array_key_exists('gender', $_POST)) {
            if (addUser($connection)) {
                echo '<h4>user added successfully</h4>';
            } else {
                echo '<h4>something went wrong</h4>';
            }
        }
        
        
    
    echo '<a href="/direct2"><button type="button">back home</button></a>';

}


?>