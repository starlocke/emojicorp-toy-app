#!/bin/bash

mysql -u emojiuser -pemojipass < /schema/reset.sql
mysql -u emojiuser -pemojipass emojicorp < /schema/emoji_tables.sql
