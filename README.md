Vote Anonymous for Drupal 8
=================

Contents:
 * Introduction
 * History and Maintainers
 * Installation
 * Configuration

Introduction
------------

The Vote Anonymous module allows you to setup voting feature for anonymous users on
node entity type. Sometime we have requirement that anonymous user can give only one vote among the listing on nodes or only one vote for one node. Although this functionality can be achieve by <a href="https://www.drupal.org/project/flag">flag</a> module but using this module we can manage voting very easily. There is an admin setting where we can configure messages, cookie, content type & other settings. On the basis of user this cookie we can controlle the voting entry in database.

If session/cookie already exist then module display a message that 'You have already submitted!'. We can also disable voting link if user has already voted. For this there is a setting in admin configuration.

Voting can be configure on global level or individual node level. 

For global level voting, keep uncheck "Single Node Voting". Now a user cannot vote on any node if already voted even at single node of select content type.

For node level voting, keep checked "Single Node Voting". Now a user can vote on the node if not voted yet.

History and Maintainers
-----------------------

There are other contrib modules which also provide voting feature but this one is easy to implement so I have developed & will try to improve.

Current Vote Anonymous Maintainers:
 * Devendra Kumar Mishra

Installation
------------

Vote Anonymous 8.x can be installed easily

1. Download the module to your DRUPAL_ROOT/modules/contribe/ directory, or where ever you
install contrib modules on your site.
2. Go to Admin > Extend and enable the module.

Configuration
-------------

Configuration of Vote Anonymous module.

1. Go to Admin > Configuration > Vote Configuration Form.
2. Fill the message which trigger after voting
3. Put some name for Voting cookie.
4. Select content type.
5. Click "Save Configuration".
