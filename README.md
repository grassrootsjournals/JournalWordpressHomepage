# Grassroots Journals

This is the code of the custom Wordpress child theme that is used to create a Grassroots Journal.

Wordpress is a content management system published under a GNU Public License. You can find its code and community under:
https://wordpress.org/
This is not to be confused with Wordpress.com, a blog hosting site using Wordpress and operated by the main company that works on the Open Source code. At Wordpress.com you will not be able to install a custom Wordpress theme.

I currently use Wordpress Multisite to host the main page and all the journals in subdomains, but you can also simply install this theme to generate one Grassroots Journal. Below is the recipe for such a single-site installation. People installing multi-site will hopefully know how to adapt it. Instructions can be found here:
https://wordpress.org/support/article/how-to-install-wordpress/

## Install
To install it you first need to install Wordpress. You can do this on a webserver or locally after installing XAMP (X stands for any Operating System (W for Windows, L for Linux, M for Mac), A for Apache, M for the MySQL database and P for PHP).

This is a child theme of the Wordpress Twentysixteen theme. If this is not automatically installed as well (it currently is) you will need to add this theme first under Appearance | Themes.

Go to the directory with the themes of your Wordpress installation. It currently is in the subdirectory:
wp-content/themes/

Here make the sub directory twentysixteen-child/ and move the code in this repository into it.

In the administration panel of Wordpress activate the Grassroots Journal Twenty Sixteen Child theme under Appearance | Themes.

## Optional
On most web hosting companies you will need to install a STMP Wordpress plugin to get notifications of new comments.

It is highly recommended to install a Wordpress plugin to reduce SPAM comments. For example SpamBee or Akismet Anti-Spam.

You will need to write a privacy policy.

## Coding
Help with the coding of the grassroots journals is highly appreciated. Wordpress is written in PHP and it being a web application you will need to know about HTML and CSS. Most can be done without knowing JavaScript.

Files and functions of the child theme override those of the parent theme. By making a child theme rather than adapting the parent theme any new versions (bug fixes) of the theme are in most cases automatically updated.

The main file with new functions and when they are called is in functions.php. Most of the code is in the subdirectory inc/.
