---
Title: Installing Kylix 3 Open Edition on Mandrake 9
Date: 01.01.2007
---


Installing Kylix 3 Open Edition on Mandrake 9
=============================================

::: {.date}
01.01.2007
:::

How can I get Kylix 3 Open Edition installed and running on Mandrake 9?

Open a Super User Terminal, select "Sessions/New Root Midnight
Commander" and in "/", create a directory "temp"

Download or copy the file kylix3\_open.tar.gz into the "temp"
directory you just created.

Check that all necessary programs are installed on your system:

Open kmenu/configuration/packaging/Remove Software or kpackage

Check for installation of the following:

kernel =\> 2.2 (mdk9.0 uses 2.4)

libgtk =\> 1.2 (mdk 9.0 uses 1.2-1.2.10-29)

libjpeg =\> 6.2 (mdk 9.0 uses 6.-66-25)

XIIR6 (XFree86) (mdk uses 4.2.1-3)

XFree86-dev (mdk9.0 uses 4.2.1-3)

glibc-dev (mdk9.0 uses 2.2.5-16)

Once you have verified that you have all of the necessary programs do
the following:

In a Super User Terminal do:

cd /temp

tar zxf kylix3\_open.tar.gz

In user terminal (NOT as root):

cd /temp/kylix3\_open

./setup.sh

In Gui select "I Agree"

Now select "install"

Logout and log back in as same user to get the Borland Kylix entry in
the KDE menu

In Borland Kylix 3 menu, select "register now"

In the Gui select "next"

In the Gui select \'Finish"

The Gui disappears and the registration process has completed.

The Kylix Delphi and Kylix C++ IDE\'s can now be run.
