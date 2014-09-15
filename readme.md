#Introduction
This plugin brings [Ninja Forms](https://wordpress.org/plugins/ninja-forms/) and [WP Job Manager Applications](https://wpjobmanager.com/add-ons/applications/) together to allow for a customized application form for each job.

#Requirements
- [WP Job Manager Applications plugin](https://wpjobmanager.com/add-ons/applications/)
- [Ninja Forms plugin](https://wordpress.org/plugins/ninja-forms/)

#Usage Instructions
1. Install both plugins.
2. Create a Ninja form for each job application that needs customized application fields; make sure to name it descriptively so you can choose it from a list easily. You only need to create the custom question fields; the Job Manager Applications plugin will ask for their name, email address, cover letter, and resume.
3. Create the job posting and choose the Ninja form from the dropdown list on the right-hand side of the page.
4. Copy the `templates/application-form.php` to the `/wp-content/plugins/wp-job-manager-applications/templates/` folder, replacing the existing file. Without this step, the Ninja Form content will not be displayed.