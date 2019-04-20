These are the instructions on how to use `mock.sql` to populate your local database for testing/demo purposes.

# Steps
1. On your cmd, run `php artisan migrate:fresh`. 
2. Run `yarn run frontend` and login with a student @itesm account. This will create a new, registered student user with id #1, which we'll use as owner of the teams that get created further on (`leader_id` attribute on the `teams` table).
3. Go to your MySQL admin tool (phpMyAdmin). 
4. Run the `mock.sql` script on the tool.
5. Done!

# Available mock data
The `mock.sql` script currently contains mock data for the following tables:
- users (teacher mock data only)
- projects
- courses
- tags (includes skills and labels) 
- course_user (teacher mock data only)
- tag_project
- client_supplier_course

# Considerations
- For a student/system admin account, you can use your own itesm account. Login on the app after steps 1-4 so that you can use your account to navigate the system. Adjust the role of this account according to your use case directly on your MySQL admin tool. 
