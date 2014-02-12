<?php

# Transparent 1x1 gif
# See http://probablyprogramming.com/2009/03/15/the-tiniest-gif-ever

define('PIXEL', base64_decode("R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="));

define("MEMBER_OWNER", 0);
define("MEMBER_USER", 50);
define("MEMBER_SYSTEM", 100);

define("MAX_TAG_KEY_LENGTH", 32);
define("MAX_EVENT_ID_LENGTH", 32);
define("MAX_TAG_VALUE_LENGTH", 200);
define("MAX_CULPRIT_LENGTH", 200);
define("MAX_MESSAGE_LENGTH", 1024 * 10);

define("DEFAULT_LOG_LEVEL", 'error');