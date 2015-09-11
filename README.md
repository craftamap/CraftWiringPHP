#CraftWiringPHP
##Introduction
###About
CraftWiringPHP - a project by Fabian Siegel

CraftWiringPHP provides a website for your Raspberry Pi, makes it able to control Relais over the GPIO.
This project requires wiringPi and and Apache-Server running PHP. 

The project also uses jQuery stored online.

##Setup the Software

Install wiringPi on your Raspberry Pi:

`user@raspberrypi ~ $ sudo apt-get install wiringpi`

Then setup an apache webserver with PHP. There are many tutorials out there, so just use some of them.

And thats basically it. Copy the Files you will get from git into `/var/www` and there you go.

Note: It's possible that the Apache-Server do not have the permission to write into the XML-File. In that case, change the permissions via `chmod` and `chown`.

##Setup the Hardware

There your own creativity is required. Basically, you can use everything you want.

Note: A better tutorial is comming here.

##Usage

To control the GPIO, you have to navigate your Webserver to the File gpio-2.php and give Args over the URL.

`http://your/pi/ip/here/CraftWiringPHP/gpio-2.php?pin=27&status=1`

CraftWiringPHP uses the BCM-Pins to control to GPIO. A table of these you can find by visiting `gpio-status.php`.

It is also possible to use the gpio for latching relays. Therefore, visit

`CraftWiringPHP/gpio-config.php`

On this page, you can create exceptions. Changing the mode to latching makes it possible to send short signals to the GPIO. The time is controlled via "Wert" in seconds.
Changing to none is basically like default.

If you are using this, the status isn't required anymore.

##What will the future bring us?

* Disable PINS
* a design
* Control Overlay
* wireless socket support
* Cookies (not sure if browsercookies or baked cookies)
