<h1>Hayden's Garage Booking System</h1>

<p>Welcome to Hayden's Garage Booking System! This document will guide you through the steps needed to get the project up and running.</p>

<h2>Getting Started</h2>

<strong>Api routes  are specified in the Documentation.yaml file in the root directory of the project. This file can be pasted into https://editor.swagger.io which will display the documentation and all endpoints which are available.</strong>

<p>Follow these steps to set up the project:</p>

<ol>
    <li><strong>Clone the repository:</strong> Run <code>git clone</code> to clone the repository to your local machine.</li>
    <li><strong>Set up the environment:</strong> Copy <code>.env.example</code> to <code>.env</code> and update the environment variables as necessary.</li>
    <li><strong>Create the SQLite database file:</strong> Create a SQLite database file in your preferred location and update the <code>DB_DATABASE</code> variable in the <code>.env</code> file with its path.</li>
    <li><strong>Set up Email:</strong> Update the email-related environment variables in the <code>.env</code> file as necessary.</li>
    <li><strong>Queue Worker:</strong> The emails are dispatched in queues. Therefore, a queue worker will need to be running in order for the emails to be sent.</li>
    <li><strong>Vue env:</strong> Add a vue .env to the path: "/frontend/.env" using the example in "/frontend/.env.example"</li>
    <li><strong>Start Docker containers:</strong> Run <code>docker-compose up -d --build</code> to start the Docker containers.</li>
    <li><strong>Enter the Docker container:</strong> Use the command <code>docker-compose exec -it booking_php sh </code> to enter the PHP Docker container.</li>
    <li><strong>Install PHP dependencies:</strong> Run <code>composer install</code> to install the necessary PHP dependencies.</li>
    <li><strong>Run migrations:</strong> Use <code>php artisan migrate:fresh --seed</code> to run the migrations and create the necessary tables in the database.</li>
    <li><strong>Admin Interface:</strong> There is no link to admin for security but it is  located at <code>/admin</code> path . Please note that only users who are admins can access this page.</li>
    <li><strong>Creating an Admin User:</strong> A user can be made admin by updating the <code>is_admin</code> column in the <code>users</code> table to <code>1</code>.</li>
</ol>

<h2>Contact</h2>

<p>Please get in touch with the creator of this project at <a href="mailto:adeyinka.giwa36@gmail.com">adeyinka.giwa36@gmail.com</a> for any questions or queries.</p>

<h2>Enjoy!</h2>

<p>Remember to have fun with the system, and don't hesitate to reach out if you have any issues.</p>
