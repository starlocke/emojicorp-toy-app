#!/bin/bash

mysql -u emojiuser -pemojipass --table emojicorp < /schema/inspect.sql
