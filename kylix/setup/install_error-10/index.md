---
Title: Error «-10» when trying to install Kylix
Date: 01.01.2007
---


Error «-10» when trying to install Kylix
========================================

::: {.date}
01.01.2007
:::

The Error -10 is a generic install error. The usual cause of this is due
to a previous version of Kylix that wasn\'t uninstalled completely. You
will need to check the RPM database to see if there are still components
from Kylix installed. This can be done with command rpm -qa \| grep
kylix. For each of the resulting packages (if there are none, then Kylix
is completely uninstalled), use rpm -e PackageName to remove them. Then,
try reinstalling Kylix.

If you have Kylix completely uninstalled (the rpm -qa \| grep kylix
command returns nothing), and after choosing \"Begin Install\" from the
installation, the installer aborts with an error code -10, then the
problem may be do with the your locale settings. Typing the command
\"locale\" may show LC\_NUMERIC=\"de\_DE\" (the German locale, in this
case). Some versions of RPM (mostly newer ones) respect this setting and
will use a comma as the decimal separator. This causes a problem for the
Kylix installer. The installer needs a period as the decimal separator.
The workaround is to reset the LC\_NUMERIC environment like this:

        export LC\_NUMERIC=\"en\_US\"

Once installation is finished, you can reset this value by setting it to
the original locale. This problem can occur for any locale which does
not use a period as the decimal separator. 

It\'s possible that a previous version of Kylix was not uninstalled
completely or that there is a problem with the RPM. \[{more info}\].
There are a couple ways to work around this. The first is to install as
a user other than root. If you would rather not do this you can use the
\"-m\" option on the setup script. So you would enter: ./setup.sh -m 
from a vterm. This tells the script to not use the RPM.

Примечание от Vit

Обычно ошибка возникает при попытке установить Kylix от имени root и
разрешается простой установкой Kylix от имени обычного пользователя.
