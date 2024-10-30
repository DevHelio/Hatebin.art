# 🎃Halloween special🎃
## Hatebin.art
 **The official Hatebin.art source code**

 Use it however you'd like, this project isn't complex and things don't need to be.
 
 Try it out! Maybe write a poem.
 
 http://hatebin.000.pe/
 
 or
 
 http://hatebin.art/

Hosting on the "Deep-web" might be a funny idea. If you know how, please inquiry me on:

Discord @i3crack

Telegram @devvingketamine

### How to set-up your MySQL db:

1. For this project create a DB named exactly "hatebinrchive" **!!make sure to not misspell it!!**
2. Copy and paste this query into your console/terminal/phpMyAdmin 
```mysql
CREATE TABLE `xfiles` (
  `ID` int(11) NOT NULL,
  `title` varchar(1100) NOT NULL,
  `message` text NOT NULL,
  `message_date` datetime NOT NULL DEFAULT current_timestamp(),
  `eyes` varchar(9) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `xfiles`
  ADD PRIMARY KEY (`ID`);
```

## Happy halloween!
