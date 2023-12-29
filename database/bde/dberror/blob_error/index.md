---
Title: BLOB has been modified. Index is out of date
Date: 01.01.2007
---


BLOB has been modified. Index is out of date
============================================

::: {.date}
01.01.2007
:::

Объяснение от Борланд:

Index out Date ($2F02) is an error that occurs while using Paradox
tables when the data in a table and a corresponding index is not
consistent. In most cases (see below for the one exception), short of
malicious behavior such as renaming an index, adding some data to the
table, then renaming the index back, there is no programmatic way to
cause this error to occur. There is no way to determine which index is
out of date. All indexes must be recreated.

Blob has been modified ($3302) is an error that occurs when the Blob
portion of the record contained in the .DB file has become inconsistent
with the Blob portion in the .MB file. This could occur when the write
to the .DB file was successful but the .MB file did not get updated, or
visa-versa.

There are a few mechanisms to fix a table where these errors have
occurred. 

1\. First try re-starting the application. It is possible that the BDE
has become unstable and is reporting incorrect errors. Also try opening
the table with a different application.

2\. Use Paradox 7 or 8 to run the Table Repair utility. Please see
original documentation for more information.

3\. Run TUtility and rebuild the table. TUtility is an unsupported
utility available for download from the Borland web site in the
{Utilities, programs and updates section}.

4\. Delete all indexes and recreate them (Index out Date ($2F02) error
only). To do this you\'ll need to know the structure of all your indexes
(including primary) before recreating them, which means you need to know
the structure of all indexes before the error occurs.

There are 8 known possible causes for this error.

1\. Incorrectly setting the LOCAL SHARE property.

Most commonly this occurs via Peer-to-Peer networking. In this case the
two different database engines are on two CPUs, even though they may be
the same version. See { BDE setup for Peer-To-Peer(Non-Dedicated)
Networks} for additional information on Peer-to-Peer setup.

Another condition is when two different database engines execute on the
same CPU concurrently and access data locally. This would be true when
any combination of following are used concurrently: The Paradox Engine,
BDE 16 bit, BDE 32 bit, Paradox for DOS. In this case each engine must
set LOCAL SHARE to TRUE. Note that if use two applications which both
use the same database engine (for example: Delphi 3 and C++ Builder 3)
concurrently are run LOCAL SHARE does not need to be set to TRUE. In
this case, all locking and cached data is in a central memory pool which
all BDE applications have access to. Also, if two different database
engines use data remotely, LOCAL SHARE must be set to TRUE.

Code should be used at startup to check the setting of local share. Look
at the {DbiOpenCfgInfoList } BDE API function call for more information.

2\. Error transmitting data from the workstation to the server.

Most commonly, this occurs with bad network hardware (cable, card, hub,
etc.). This has been determined to be a problem even though there were
no other errors are detected in data transmission. To determine if this
is the cause for your error, try eliminating one CPU at a time from
using the data and see if the problem continues.

3\. Bad VREDIR.VXD on any client accessing tables Windows 95 ONLY:

Several versions (notably 4.00.1113 and 4.00.1114) of the file
VREDIR.VXD may need to be updated.

Reports have shown that using the original release of VREDIR.VXD
(4.00.950) and a new release (4.00.1116) do not result in the errors
\"Blob has been modified\" and/or \"Index is out of date.\" If any one
of the clients has a \"bad\" version of this device driver, the error
can occur on any machine, not just the machine with the bad driver.

This error most likely occurs in 16Bit versions of the Borland Database
Engine, although it still can occur in 32Bit versions.

For further information on the update of VREDIR.VXD, Please check the
following Microsoft Articles: {Q174371} and {Q165403}

4\. For Windows 95 clients only, when using data on Windows NT: Add the
following key in your registry:
HKEY\_LOCAL\_MACHINESystemCurrentControlSetServicesVxDVredir

Then create the string or Binary Value (either one works) with a name of
DiscardCacheonOpen and make it equal to 1.

Note that this an undocumented registry entry obtained from Microsoft.
Questions on its functionality should be directed to Microsoft.

5\. Problem with opportunistic locking Windows NT ONLY: Try turning off
opportunistic locking in the Windows NT registry: See Microsoft Article
{Q129202}

Note: Borland internal testing has not indicated this setting to be
significant. However, some Borland customers have indicated this to
solve the problem.

6\. Improperly closing files such as due to loss of power or restarting a
workstation or the server without closing files first may cause this
problem. Paradox tables are not designed to withstand such behavior. If
this is a possibility in your environment, we recommend you use a Client
Server database that can recover from such conditions.

7\. Extremely large numbers of indexes, especially involving Referential
Integrity can cause this problem and especially when using Windows NT as
the server. Borland recommends using a Client Server database under this
condition. However, if you are using Windows NT as your server,
switching to Novell Netware or Windows 95 as the server may resolve the
problem as well.

8\. The one programmatic way you can make this error occur is if you
attempt to post a duplicate value to a unique, non-primary index at the
same time you attempt to open the same table. This problem only occurs
if local share is set to False and only occurs on local drives.

Unverified solutions

1\. Windows 95 Only: Bring up the network properties screen on all
Workstations and enter the netBEUI properties screen. On the advanced
tab, make sure that \"Set this protocol to be the default protocol\" is
checked.

2\. Windows 95 Only: If the previous suggestion did not work, try
removing the following protocols in order. Remove one at a time and then
re-test your problem: 

   1. NETBIOS support for IPX/SPX-compatible Protocol

   2. TCP/IP

   3. IPX/SPX-compatible Protocol  If the problem disappears, attempt to
add back in all protocols except for the last one that was taken out.
Again, make sure netBEUI\'s default protocol check box is checked.

3\. Windows NT Only used as a Workstation: On the Network Bindings page
of the Network Properties, set the NetBEUI Protocol to be at the top of
all services. The TCP/IP stack is known for having a lot of overhead
that might cause timing problems. Since NT will send requests back in
the same protocol as it is sent, changing the bindings on a NT machine
used as a server will have no effect.

Other resources

1\. {The Delphi Magazine} has a number of interesting articles on this
subject as well. See { www.itecuk.com/Delmag/Paradox.htm} for details. 

------------------------------------------------------------------------

Примечание от Vit:

Обычно такие ошибки возникают из-за проблем с кэшированием измений в
базе данных, особенно при использовании BLOB/Memo полей и особенно при
многопользовательском доступе. В простейшем случае снизить частоту
возникновения этой ошибки на несколько порядков помогает вызов метода
FlushBuffers после каждого изменения таблицы:

Table1.post;

Table1.FlushBuffers;
