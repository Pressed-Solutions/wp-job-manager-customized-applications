#Introduction
This plugin brings [Ninja Forms](https://wordpress.org/plugins/ninja-forms/) and [WP Job Manager Applications](https://wpjobmanager.com/add-ons/applications/) together to allow for custom questions for each job listing.

#Requirements
- [WP Job Manager Applications plugin](https://wpjobmanager.com/add-ons/applications/)
- [Ninja Forms plugin](https://wordpress.org/plugins/ninja-forms/)

#Installation Instructions
1. Install both plugins.
1. Copy the `templates/application-form.php` file to the `/wp-content/plugins/wp-job-manager-applications/templates/` folder, replacing the existing file. Without this step, the Ninja Form content will not be displayed.
1. Copy the `inc/wp-job-manager-applications-functions.php` file to `/wp-content/plugins/wp-job-manager-applications/includes/` folder, replacing the existing file. Without this step, custom question responses will not be shown.
1. Copy the `template/job-applications.php` file to the `/wp-content/plugins/wp-job-manager/applications/templates/` folder, replacing the existing file. Without this step, you will be unable to filter the dashboard by whether or not applicants entered answers in the custom questions.

If the WP Job Manager Applications plugin updates, complete steps 2–4 again.

#Usage Instructions
1. Create a Ninja form for each job application that needs customized application fields; make sure to name it descriptively so you can choose it from a list easily. You only need to create the custom question fields; the Job Manager Applications plugin will ask for their name, email address, cover letter, and resume.
1. Create the job posting and choose the Ninja form from the dropdown list on the right-hand side of the page.


#Special Role
- To set up a user who can manage jobs and nothing else, take a look at [this plugin](https://github.com/Pressed-Solutions/WP-Job-Manager-Custom-Management-Role).
