# Link Saver by Braden Best

The Link Saver is a project I made to replace bookmarks and provide a clean UI instead. Cause in my opinion, browser bookmark systems suck.

## Version 6.0.0

This version utilizes SQL to a greater potential

## Setup

1. Create a MySQL database
2. import Link_Saver.sql
3. edit connect.php

## Data

  DB Link Saver{
    Table users{
      int id    -- user's id (auto increment)
      text name -- user's name
      text pass -- user's sha512 password
    }
    Table accounts{
      int uid    -- user's id
      text email -- user's email
      int rights -- user's rights (0 = unverified, 1 = verified, 2 = admin, etc)
    }
    Table links{
      int uid    -- user whom link belongs to
      int lid    -- link id (auto increment)
      text link  -- link's url
      text title -- link's title
      text tags  -- JSON formatted array containing tags
    }
  }
