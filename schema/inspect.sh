#!/bin/bash

mysql --host 127.0.0.1 -u emojiuser -pemojipass --table emojicorp < /schema/inspect.sql
