---
Title: Why can't I connect to an Access database using the BDE and native MSACCESS driver?
Date: 01.01.2007
---


Why can't I connect to an Access database using the BDE and native MSACCESS driver?
===================================================================================

::: {.date}
01.01.2007
:::

Why can\'t I connect to an Access database using the BDE and native
MSACCESS driver?

Access 2000/XP:

You cannot connect to an Access 2000 database using the BDE\'s native
MSACCESS driver. It is recommended that you  use ADO. You could also
connect using the BDE with ODBC.

Access 95 or 97:

You may get the message "BDE error 13059" and "General SQL error".
If you are trying to connect to Access 95 or 97 databases using the
BDE\'s native MSACCESS driver, then you need to have DAO 3.0 installed
for Access 95 or DAO 3.5 for Access 97 (DAO = Data Access Objects for
Visual Basic). You can install the DAO by doing a custom installation of
MS Office and selecting only to install Data Access Objects for Visual
Basic. You must also have the correct DLL32 setting in the BDE
Administrator for the DAO you have installed: IDDA3532.DLL for Access
97, IDDAO32.DLL for Access 95.
