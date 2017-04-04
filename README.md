# UW Two Clicks
This extension can be used to show foreign contents on a website with a disclaimer before the user is able to see them. At the moment only
YouTube videos are supported. Google maps and Google Calendars are in evaluation phase.

## Installation
To install the extension, you need a Typo3 installation with the version higher than 7.xx. This extension is based
on extbase and fluid. For the Api queries you need the CURL library. 
For the install simply clone this repository in `/typo3conf/ext`.

## Configuration
For the configuration you should use the extension manager configuration tab. Go to Extensions and find Two Clicks. Click on the cog
button and you will see two tabs available. 

### Youtube Configuration
#### youtube.yt.apiUrl
This is the api url of the Youtube, at the `v3` you should use:
`https://www.googleapis.com/youtube/v3/videos`

#### youtube.yt.apiToken
The api token to connect to YouTube api. You can get it from here [here](https://developers.google.com/youtube/v3/). To avoid
missuses limit the api to respond to your Typo3 IPs.

#### youtube.yt.autoPlay
With this you can make the extension automatically play the videos after the disclaimer is accepted. It is off by default. It also
can be set per video.

#### youtube.yt.width
This sets the width of the video for the given page. The default value is here `600px`. This setting can also be done per video.

#### youtube.yt.height
This set the height of the video for the given page. The default value is here `400px`. This setting can be also done per video.

#### youtube.yt.disclaimer
This is the disclaimer that is going to be shown on the video. This is set once for all YouTube video. It can be a simple html text i multiple languages. If it is longer than the video width it will be shown with scroll-bar.

#### youtube.yt.forward
This is text that is used on the button to go the next step after accepting. This should be set, the default value is empty.

### Files Configuration
This settings should be changed with care. Consider setting them once at the start. Changing them without the same changes to the
filesystem causes problem for the existing contents.

#### files.files.defaultMountPoint
The default mount point is the mount point on the system that should be used to save all the files and folders created by this plugin
this is empty by default. This mean the root is the mount point unless it is set to something else. This only will be used in simple mode.

#### files.files.mountPointType
This is the mode that the files should be saved on the system. This one should be considered at the start and should be set. It can have one of the two values `simple` or `group`. If you have small Typo3 installation the `simple` mode can be the best solution for you. This will save all the files and folders generated by the extension in a single folder on the filesystem. The folder in default would be the `files.files.defaultMountPoint/files.files.storeFolder` which is translated to `/TwoClicksImage`.
The `group` mode will gain the mount point from the group the page belongs too. Normally the user who can add content to a page is also capable to write to the folder mounted to the group. it is good for the bigger Typo3 with several groups and branches.

#### files.files.storeFolder
It is the folder the images from the providers are saved inside. If there is change in this after running the plugin for a while. The default value for this is `TwoClicksImage`

### Typo3 Configuration
The admin user can create this kind of content without restriction. If you want to allow your users to create two click elements you should change some settings. If you have group of users which you want to allow to create this kind of content, go to the group settings on the Access tab allow `listing` and `modify` to the `UW Two Clicks Table`. If you use simple file system mode, you should allow the user to write to the Folder by adding it as a mount point on for the given group. The same setting can also be done for users, if you have much smaller Typo3 installation. For the group file system mode you only need to allow table settings, the file system write permission is granted automatically.

## Bug reports and Pull Requests
Both bug reports and pull requests are accepted. When reporting the bug please tell me the Typo3 Version, PHP version and also your file
system configuration (all the settings from file tab). 

## License
See LICENSE file