=== Flirty Leads ===
Author: sageshilling 
Tags: lead capture, call to action, email campaigns, direct dashboard media editing, MailChimp integration
Requires at least: 3.0
Tested up to: 4.7
Stable tag: 4.0
License: GPLv2 or later

Flirty Leads lets your site visitors respond your site images. Generate client lists, gain leads using your post/pages images.  Email form attaches to images, settings in media library.

== Description ==

Flirty Leads provides a way to attach a lead capture form to images in a WordPress post or page and increase signups. 
The Flirty Leads WordPress plugin allows clients to understand the ROI on each post as Flirty Leads provides options 
to include multiple CTAs on images used in posts and pages. 

Users retain complete control and the ability to customize image text and each call to action via the media library. 
Lead notification is emailed when defined by user and defaults to WordPress admin email when custom email field is left 
blank. Each image can route to individual emails per image when desired, as well. 

Flirty Leads simple indicator system shows which image, post or page referred the lead, making it easy 
to track lead's area of interest and engagement. 

[Preview Flirty Leads](https://drive.google.com/file/d/0B2Z5PPoQZyd3ZXZKZjVPTERYdDQ/preview)

*4.0 featuring email campaign building integration with MailChimp Mailing Lists.

demo http://peaceoftheocean.com/WordPressNotes/lorem-ipsum/
http://peaceoftheocean.com/paris/eiffel/  first lead capture uses MailChimp, second lead capture email sent to site owner
http://www.orcawebperformance.com/flirty-leads-a-wordpress-plugin/
== Installation ==


Upload the FlirtyLeads plugin to your blog, Activate it.

Upload an image to the media library, fill in the fields.  Make sure to change Show lead capture to 'yes'.

Insert image into page.


1, 2, 3: You're done!

== Screenshots ==

1. Can use multiple images with lead capture within the same post/page

2. Options to activate image lead capture on the media library page.  To activate set 'show lead capture form' to yes.

3. To Integrate leads to your existing MailChimp campaign mailing list, set option to send info to MailChimp list to 'yes' and enter the fields specific to your MailChimp campaign

4. http://kb.mailchimp.com/lists/signup-forms/host-your-own-signup-forms  In the page source for your MailChimp hosted signup form, you'll find the pieces of code that need to be added to the form code on your website.
First, copy and paste the form action and input information into the body of your custom signup form. Then, find the input type for each list field, and copy that information into the corresponding fields in your custom signup form code. All of these values must be copied to your custom signup form for the data transfer to work properly.
Browse or search the page for "form action" to find the first piece of code you need, and copy the lines that look something like this.

== Changelog ==
added uninstall
conditionals for loading
unique custom field names
php string functions to set lc alignment to be same as image in the post
php string to set flexbox for image container to be the width of the image in the post
email campaign building integration with MailChimp