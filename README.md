# WLANderlust
*Not all those who WLANder have lost connection*

This package configures a fresh Raspbian Stretch Lite installation to be a
roaming WiFi repeater with advanced features. Other Debian distributions might
work. Making the Captive Portal solving work on all Unices is work in progress.

WLANderlust is developed with travelers in mind; Campers who want to connect to
the campsite WiFi, backpackers who want to connect to the hostel WiFi, sailors
who want to connect to the harbours WiFi, etc.

## Current functionality:
- Connect to open WiFi Access Points
- Detect Captive Portals and tries to solve them
- Logs in to Fon routers with Fon credentials
- Configures firewall and NAT
- Configures encrypted WiFi spots
- Supports IP over DNS routing for situations where internet access is obstructed, but DNS queries are allowed.
- IP over SSH VPN support

### Feature wishlist:
- Stable WiFi Roaming, to connect to the best available WiFi Access Point
- WISPr authentication (some work has already been done)
- Support for other Fon services like Telekom_FON and BT Fon (some work has already been done)
- Support for MikroTik MD5 client side encrypted passwords (some work has already been done)
- Support for form based username/password Captive Portals (some work has already been done)
- Support for social media Captive Portals
- Better stealth firewall
- Support other WiFi services like T-Mobile Hotspots
- Support 3G dongles
- GPS support for logging connections (some work has already been done)
- GPS support for logging your location to online services
- Support for more VPN types (some work has already been done)
- Support for Tor
- Transparent proxy with add blocker
- Network Time server for the local network if RTC or GPS is configured
- Retrieve password database from external source, like Wifi Map or Instabridge
- Download Raspbian updates when successfully connected
- Web interface
- Configure Real Time Clock

## Required Hardware
- Raspberry pi 
- (Outdoor) USB WiFi antenna

### Optional Hardware
- i2c Real Time Clock module
- External USB GPS

### Some remarks on Raspberry Pi power usage
The Raspberry Pi Zero W and Raspberry Pi 3 model B seem to be very sensitive to
power fluctuations. A good, stable, power supply is thus needed.

For the car I have not yet found a trustworthy power supply that delivers stable
to power those devices. A 10 Amps @ 5 Volts car USB plug seems not to be enough,
also an other one I have, 3.1 Amps @ 5 Volts, doesn't give a stable connection.

2.1 Amps @ 5 Volts power bank is also not sufficient.

I get the following under-voltage kernel messages on a Raspberry Pi 3 model B:  
```
[    6.231593] Under-voltage detected! (0x00050005)
[   14.551539] Voltage normalised (0x00000000)
[  341.111583] Under-voltage detected! (0x00050005)
[  347.351544] Voltage normalised (0x00000000)
```

The official Raspberry Pi power brick outputs 2.5 Amps at 5.1 Volts, but I don't
have one available so can't tell if that one gives a stable result. Supposedly
the 5.1 Volts vs 5 Volts makes the difference.

Update Januari 2019:  
In the meantime I have bought a RuiDeng UM25C USB Power Tester and poor quality
USB cables seemed to be the problem, creating a voltage drop of about 0.5
Volts. Using other USB cables solved the under-voltage kernel messages.

### Some remarks on Raspberry Pi onboard WiFi
I can't get it to work reliable, I have to dig deeper into this, for now I'm
using a second external USB WiFi module.

### (Outdoor) USB WiFi antenna
Technically any USB WiFi antenna which is supported by Linux/Raspbian should
work, and depending on your means of travel your selection criteria may vary.
I'm using an Alfa Networks Tube-UN outdoor USB WiFi antenna which is mounted on
my car and I'm very pleased with it. It recevies signals from multiple
kilometers away if you're having a direct line of sight.

### Real Time Clock support
I'm using a i2c DS3231 RTC which you can get for less than $2 including shipping
from eBay:  
http://bit.ly/RaspberryPiDS3231

### External USB GPS
Any GPS which is supported by GPSd should work.

## Installation instructions
You should feel a minimum comforatble with working with the command line. First
you need to create a fresh installation of Raspbian Stretch Lite on a Micro SD
card.

### Installing Raspbian
There a plenty of instructions available on the web on how to create an SD card
with Raspbian. If you follow these instructions and want to continue the
installation of WLANderlust on your future router remotely, that is you want to
login on the device from an other computer instead of connecting a screen and
mouse/keyboard directly to the Raspberry PI, you should keep in mind to also
configure `wpa_supplicant.conf` and `ssh` in the `boot` directory of the SD
card. Also you need to have an SSH client installed on your computer, this is
most probalby already installed if you're using Linux or macOS.

If you're already a Linux user, or are usig macOS, you can use a utility script
to download the lates Raspbian Lite, install it on an SD card, configure the
WiFi and enable SSH. The utility script can be found in the `extra` directory
of the WLANderlust installation.

```
./extra/latestRaspbianLite2MicroSD
```

### Installing WLANderlust
After sucessfully installing Raspbian you login on your Raspberry Pi as user pi
with password raspbian and download the WLANderlust archive.

```
curl -L 'https://github.com/rrooggiieerr/WLANderlust/archive/master.tar.gz' -o WLANderlust.tar.gz
```

To configure your Raspbian as a roaming WiFi repeater unpack the WLANderlust
archive, execute the `installWLANderlust` installation script and follow the
instructions.

```
tar -xf WLANderlust.tar.gz
cd  WLANderlust-master
sudo ./installWLANderlust
```

## Using WLANderlust
After successful installation of WLANderlust the Raspberry Pi will automatically
interact with the application when new WiFi connections are being established.

You can use the command `WLANderlust` to get feedback on the connection status.
If you run the command as root `sudo WLANderlust` you can configure encrypted
WiFi credentials, IP over DNS tunneling, VPN and other settings.
```
WLANderlust
Not all those who WLANder have lost connection
Connected to "An Open WiFi network" (xx:xx:xx:xx:xx:xx), no encryption, channel 6, signal -44, roaming
Detecting Captive Portal.... Solved
Using WiFi interface wlan1 (b8:27:eb:8e:97:95), IP address: 192.168.1.194, netmask: 255.255.255.0, gateway: 192.168.1.1, external IP address: 123.123.123.123
IP over DNS tunnel is not active
VPN is not active
Host Access Point "WLANderlust_9929" (xx:xx:xx:xx:xx:xx) is active using interface wlan0, channel: 7, 20.00 dBm, IP address: 192.168.242.1, netmask: 255.255.255.0

Scanning

  1 🔒 65% 10 "An encrypted WiFi network"
  2   48% 11 "An Open WiFi network"
  3 🔒 58% 11 "Coffee please"
  4💾  38% 11 "OTE WiFi Fon"
  M Manual
  W Stop scanning for WiFi networks
  A Reassociate interface wlan1
  V Start VPN
  C Configure WLANderlust
  Q Quit

Network to configure or option:
```

Otherwise the command `./usr/local/bin/WLANderlust` should be portable and can
run independently to solve Captive Portals on any unix that supports the Bash
shell.

### Getting passwords for encrypted Access Points and Captive Portals
Of course you can always walk into a bar/restaurant/hotel/office and ask them
their WiFi password. Further I found the following two apps very usefull for
finding passwords of WiFi Access Points:
- WiFi Map
- Instabridge

Both apps are availale for Android and iOS and can be found in their app stores.

## About the author
I used to work as a freelance IT application developer and consultant and
always enjoyed traveling in between assignments. In 2014/2015 I made an overland
trip from Amsterdam to Cape Town with my Land Rover Defender, in 2017 I decided
to retire and start traveling the world indefenetly. It took a couple of months
to do all the preparations and in April 2018 I drove off, heading from Amsterdam
towards Sydney where I'll expect to arrive in 2023. This time I'm driving a
Toyota Land Cruiser.

Of course, although I'm traveling, I'm keeping my interest for IT and
technology. I packed a couple of Raspberry Pis, Arduinos, sensors and other
components to play with on the side. My need to be online inspired me to create
some scripts to automate logging in to Access Points. Over time more
functionality was added and I decided to share this efford with a larger
audience.

I'm always interested in short projects in the field of application development
to extend my travel budget. Contact me if you think my expertise can be of use
to our project.

You're invited to follow my adventures on the road on social media:  
https://www.instagram.com/seekingtheedge/  
https://www.facebook.com/seekingtheedge

### Contributors
I'm looking forward to your sugestions, improvements, bug fixes, support for
aditional authentication methods and new functionality.
