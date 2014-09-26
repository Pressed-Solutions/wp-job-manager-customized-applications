#Introduction
This plugin brings [Ninja Forms](https://wordpress.org/plugins/ninja-forms/) and [WP Job Manager Applications](https://wpjobmanager.com/add-ons/applications/) together to allow for a customized application form for each job.

#Requirements
- [WP Job Manager Applications plugin](https://wpjobmanager.com/add-ons/applications/)
- [Ninja Forms plugin](https://wordpress.org/plugins/ninja-forms/)

#Installation Instructions
1. Install both plugins.
1. Create a Ninja form for each job application that needs customized application fields; make sure to name it descriptively so you can choose it from a list easily. You only need to create the custom question fields; the Job Manager Applications plugin will ask for their name, email address, cover letter, and resume.
1. Create the job posting and choose the Ninja form from the dropdown list on the right-hand side of the page.
1. Copy the `templates/application-form.php` file to the `/wp-content/plugins/wp-job-manager-applications/templates/` folder, replacing the existing file. Without this step, the Ninja Form content will not be displayed.
1. Copy the `inc/wp-job-manager-applications-functions.php` file to `/wp-content/plugins/wp-job-manager-applications/includes/` folder, replacing the existing file. Without this step, custom question responses will not be shown.

#ToDo
As of now, this plugin relies on the Ninja Form submission always being the post ID immediately preceding the WPJB application; in a high-use situation, this may not always be the case. See [commit f01c5d](https://github.com/macbookandrew/wp-job-manager-customized-applications/commit/f01c5d903c9a8bfc0b687777283dcddb835bdccc) for the first steps towards a better implementation.
