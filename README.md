# php-framework

> Almost every PHP developer has created a PHP Framework.

This is a little "framework" for APIs development that I had created in 2016, before I started to use PHP Frameworks, I've created it with a little inspiration in ASP.NET with some Java design patters (I was mixing everything I knew at this time hahaha), organizing folders with Models and Repositories, trying to use this idea on PHP.

I didn't know about PSRs or Composer at this time, so I've used spl_autoload_register to load classes and send all requests to a single file with the .htaccess to create pretty URLs.

I've used something like it on [gdg-sp back-end project](https://github.com/alefesouza/gdg-sp/tree/master/Back-end) without pretty URLs due to compatility of older version.

Maybe there's a lot of bad practices on this code, but whatever, it's just a framework created when I was a 19 years old guy without anyone to say what's bad.

## The Idea

The basics of this "framework" is:

* Configure the Apache webserver to send all requests to a single file ([routes.php](./routes.php)), which will trait the given URL, getting the first subdirecty as a controller and the second as a action.
* Database repositories and models, using PDO, every database action is a function on the repository.
* Authentication uses a token via header, and the JSON data comes via body.
* All actions execute a script, not a method of a controller class (I really don't know what I was thinking).

At the end, the script get the data, it usually execute a database task with a repository method, and show the results or if it was a success.
