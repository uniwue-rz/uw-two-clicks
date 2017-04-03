# UW Two Clicks
This extension can be used to show contents with a disclaimer before the user is able to see them. At the moment only
YouTube videos are supported. Google map and Google calendar are in evaluation phase.

## Installation
To install the extension, you need a typo3 installation with the version higher than 7.xx. This extension is based
on extbase and fluid. For the Api queries you need CURL library. For the install clone this repository in `/typo3conf/ext`.

## Configuration
There are several configuration you need to do to make the extension work. First is to get youtube API token for the queries:
here is the link to the Api docs:

https://www.googleapis.com/youtube/v3/videos

The youtube api used by this is the v3:

https://www.googleapis.com/youtube/v3/videos

The default width and height should also be set accordingly. The disclaimer you want to show comes at last, this can be in multiple
language and can contain html tags, whatever you write here will be shown to the user before every video so take care about the
contents of this option.

On the File tab there are several ways to save the images on the typo3 platform. The simple form will save all the files
in the same folder. If you have group based file system, you can use the group. In every group's folder there will be `TwoClicksImage` folder
which the images from youtube are save. To make less queries to YouTube, this application caches the query results to YouTube.

## Bug reports and Pull Requests
Both bug reports and pull requests are accepted. When reporting the bug please tell me the Typo3 Version, PHP version and also your file
system configuration (all the settings from file tab). 

## License
See LICENSE file