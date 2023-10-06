<?php
/* ====================
[BEGIN_COT_EXT]
Code=thanks
Name=Thanks
Category=community-social
Description=Users can thank each other for pages, posts and comments
Version=1.48b
Date=2015-02-17
Author=Trustmaster
Copyright=All rights reserved (c) Vladimir Sibirov 2011-2015
Notes=BSD License
SQL=
Auth_guests=R
Lock_guests=12345A
Auth_members=RW
Lock_members=12345
Requires_modules=
Requires_plugins=cotlib
Recommends_modules=page,forums
Recommends_plugins=comments
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
limits=00:separator:::
maxday=01:string::10:Max thanks a user can give a day
maxuser=02:string::5:Max thanks a day a user can give to a particular user
maxthanked=03:string::10:Max number of users that thanked for an item

pagination=10:separator:::
usersperpage=11:string::20:Max users per page
nozero=12:radio::1:No zero-thanked users in the list
thanksperpage=13:string::20:Max thanks per page
ajax=14:radio::0:Use ajax
encrypt_ajax_urls=15:radio::0:Encrypt ajax URLs
encrypt_key=16:string::1234567890123456:Secret Key
encrypt_iv=17:string::1234567890123456:Initialization Vector


page=20:separator:::
page_on=21:radio::1:Turn on thanks for pages
page_class=23:string::btn btn-primary d-block mb-4: Class attribute for page thanks link

forums=30:separator:::
forums_on=31:radio::1:Turn on thanks for forums (posts)
forums_class=32:string::: Class attribute for post thanks link

comments=40:separator:::
comments_on=41:radio::1:Turn on thanks for comments
comments_class=42:string::: Class attribute for comment thanks link
comments_order=43:radio::0:Sort comments by thanks

misc=50:separator:::
short=51:radio::0: Short string - only user name, no date stamp
page_on_result=52:radio::0: Display page after thanks or simply redirect to referer



[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');
