# NeoCode-YealinkConnector
Allow your File Maker 16 client capture and log call events. The Yealink Connector will allow you to set up a local 
web server that will translate and forward Yealink SIP phone Action URL events to a FileMaker Pro 16 client.

## FEATURES & LIMITATIONS
What the files will and will not do...

### FEATURE HIGHLIGHTS
* Track incoming call events from a Yealink SIP phone in a FileMaker database
* Ability to listen for or ignore call events
* Collect call details including
  * The SIP URI of the callee
  * The SIP URI of the caller
  * The caller ID
  * Unique ID of the call event
  * MAC address of the phone
  * The current IP address of the phone
* Call event logging in the web service and in FileMaker
* Phone setup assistant

### LIMITATIONS
Known bugs, incomplete and unsupported features.  This is essentially our to-do list. Not in any particular order.
* Does not currently track outbound calls.
* Does not currently allow for control of the phone (e.g. answer calls, reject calls, make busy) from FileMaker.
* Only tested on Yealink SIP T28P and SIP T32G
* A known bug that the SIP T32G will display a "File Format Error" with each event ([which is a known problem with this 
set](
http://forum.yealink.com/forum/showthread.php?tid=3127)).
* The unique ID of the call event sequence is reset when the phone is restarted.
* The FileMaker database must be open to receive call data.

## INSTALLATION
### Requirements
    FileMaker Pro 16
    YealinkEvents.fmp12
    Local web server such as XAMPP
    yealink_connector web services folder and contents

### Instructions
1. Set up local web server
1. Install `yealink_connector` in local web server
1. Set up Yealink Action URL link on your phone
1. Open `YealinkEvents.fmp12` file

See detailed instructions in the `Neo Code Yealink Connector Installation Guide.pdf` file

## LICENSE
MIT