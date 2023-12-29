---
Title: Установка Kylix под новые версии Linux (ядро 2.6)
Date: 01.01.2007
---


Установка Kylix под новые версии Linux (ядро 2.6)
=================================================

::: {.date}
01.01.2007
:::

Взято с <https://www.nux.co.za/>

Follow these steps to fix/patch kylix 3 work:

Step 1

Download the ilink and ilink.so patch provided by Andreas Hausladen
here:

[ilinkpatch](https://unvclx.sourceforge.net/downloads/ilinkPatch.tar.gz)
for more info on the patch go to
[unvclx.sourceforge.net](https://unvclx.sourceforge.net/)

To install just go to the download directory and run

./ilinkPatch /home/yourname/kylix

Step 2

Download the latest 3.6 clx patch provided by Andreas Hausladen from
[unvclx.sourceforge.net](https://unvclx.sourceforge.net/) or
[here](https://nux.co.za/media/k3patches.20040915.tar.bz2). Copy or save
this file to /tmp folder

Install the patch by executing the following from the shell

tar -jxf k3patches.20040915.tar.bz2

/tmp/k3patches/installpatch

Step 3

Download and install the older compatible glibc libraries for running
kylix apps from
[here](https://nux.co.za/media/compat-glibc-6.2-2.1.3.2.i386.rpm). Save
or copy it to /tmp.

Install by runing from the shell

rpm -i /tmp/compat-glibc-6.2-2.1.3.2.i386.rpm

Now the patching is complete.... now to run kylix do the following

Step 4

export LD\_ASSUME\_KERNEL=2.4.21

Step 5

Run/Start kylix via

/usr/local/kylix3/bin/startbcb

Step 6

Open your project and change your projects include directories via the
project options by adding

/usr/i386-glibc21-linux/include

/usr/include

as the very first include paths to that your include paths..

this will fix the error so that the correct \"time.h\" be included.

Step 7

Change your lib paths by adding (preferably in the beginning)

/usr/i386-glibc21-linux/lib and

/usr/lib

Finally:

Open the ThrdDemo (the c++ demo included with Kylix in the examples
directory) This sample demonstrates the use of threads and different
sort algorithms... (remember step 6+7 for this project).

Compile and run/debug....

Congatulations!!! your have done it!!!
