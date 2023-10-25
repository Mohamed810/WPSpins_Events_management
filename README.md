# WPSpins_Events_management

Event Manager WordPress Plugin

This WordPress plugin allows you to manage events with an interest feature. Follow the steps below to set up and utilize the plugin.

# Installation

Download the plugin folder from the repository.
Upload the entire event-manager folder to the wp-content/plugins directory of your WordPress installation.
Activate the plugin through the WordPress dashboard.

# Features

1- Custom Post Type:

A custom post type named "Events" is added to the WordPress site.
Events can be created, edited, and deleted like standard posts.
Event Details Metabox:

In the editor screen for events, you'll find a metabox labeled "Event Details" where you can input additional information about the event.

2- Custom Fields:

The metabox includes custom fields for "Event Date", "Event Location", and "Event Description".
Admin Column:

An admin column named "Event Date" is added to the Events list in the dashboard. It displays the event date for each event.

3- Custom Page Template:

A custom page template named single-event.php is provided to display individual event details.

4- Modal Window:

When viewing an event, click the "Popup" button to open a modal window displaying event details.

5- Interested Functionality:

In the modal window, click "I'm Interested" to express interest in the event.

6- User List Management:

If more than three users are interested, additional usernames are collapsed. Use "See More" and "See Less" buttons to expand and collapse the list.

7- Cron Job for Exporting Users:

A cron job runs twice daily to export the top 10 users interested in events to a CSV file.
The CSV file is stored in the Events-Top-Interested-users directory within the plugin.

# Usage

Create a new event by navigating to the Events menu in the WordPress dashboard.
Fill in the event details including date, location, and description in the provided metabox.
Save or update the event to automatically trigger the interest functionality.
View the Events list to see the "Event Date" column and manage your events.
When viewing an event, click "Popup" to open the modal window displaying event details. Express interest by clicking "I'm Interested".
That's it! You've successfully set up and utilized the Event Manager plugin.
