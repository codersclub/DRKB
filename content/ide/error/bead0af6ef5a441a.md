Where are my components?
========================

::: {.date}
01.01.2007
:::

Windows NT and 2000:

Most likely Delphi was installed by an administrator or a user with
administrator rights and the user currently logged on does not have
administrator rights. The component library is failing to load because
it does not have the registry keys available that indicate where the
packages are located. Install first as Admin, then do a \'Registry
Settings Only\' install for each user to get all the necessary DLL\'s
and registry key entries to run Delphi under a specific user profile.

To do this login as the user and run the Delphi install. Around 3
screens in you\'ll get to the screen where you need to choose the
install directories. At the bottom of this screen is a check box to
select for Registry Settings Only. Complete the install as usual. It
should be much faster since no files are copied.

If it looks like the components are there but the bitmap images are
missing then try unistalling and reinstalling each package. This can be
done very easily by going into the Delphi menu option Component \|
Install Packages. Uncheck each of the packages and then check it again.
Say \"Yes\" to any message boxes that appear asking about the removal of
related packages. I recommend you start by removing \"Borland Database
Components\" since this will remove several others as well.
