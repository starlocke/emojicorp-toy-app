#!/bin/bash

mysql --host 127.0.0.1 -u emojiuser -pemojipass < /schema/reset.sql
mysql --host 127.0.0.1 -u emojiuser -pemojipass emojicorp < /schema/emoji_tables.sql
