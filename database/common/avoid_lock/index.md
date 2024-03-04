---
Title: Avoiding server side locking (including DEADLOCK)
Date: 01.01.2007
---


Avoiding server side locking (including DEADLOCK)
=================================================

>What can I do to help avoid server side locking (including DEADLOCK)
>problems when working with Microsoft SQL Server (DBLIB) and Sybase
>SQL Server (DBLIB)?

The following suggestions may help you tune your application and
server. The server side suggestions may not apply to all server
and database installations.

From the client application you may want to take greater control
over the size of results sets (this may mean using TQueries),
minimize the length of transactions (usually not an issue if the
SQLPASSTHRU MODE is set to ...AUTOCOMMIT), and only open dbaware
controls when necessary to help minimize resource drain on the
server and, possibly in this case, deadlock potential.

The means by which the BDE selects data from each of the supported
servers does not make assumptions about how each server chooses
to ensure data integrity.

**Delphi/BDE suggestions:**

Work with smaller result sets (TQueries, server views, etc.)
also see above form more info.

Check the SQL Links MSSQL Driver "TDS Packet Size" param
making sure that it is set to, at least, 4096.

- Minimize the length of transactions.
- Investigate creating appropriate indexes.
- Filter results before opening a dataset or use tqueries
(live or otherwise) to limit the number of rows selected.
- Investigate using the BDE SQL PASSTHRU MODE parameter
"NOT SHARED" (please see BDEADMIN.HLP and BDE32.HLP for
addtional information on the SQL PASSTHRU MODE parameter)

**Please note:**

BDE/SQL Links 4.01 will not only detect and raise a deadlock
error but it will "reset" its database transaction state when
it detects an MSSQL error 1205. It is not necessary to rollback
the explicit transaction (Database1.rollback) after the
deadlock has been detected.

The error 1205 signals to the client that the server has
"resolved" a deadlock and chosen one of the users to end the
deadlock. This user\'s transaction is automatically rolled back.

Please refer to the MS SQL Server documentation for more
information on deadlock detection and server error 1205.

MS SQL and Sybase Server topics: (the following is by no means a
comprehensive list. Please check your Sybase and MS SQL Server
docs for tips on optimizing your server and databases)

Create indexes on the remote tables where possible (the
server may require more locks for unindexed tables.)

TEXT and IMAGE columns can take up more pages (columns
can be omitted from a SELECT statement if working with TQueries
whose REQUEST LIVE property is false)

page sizes on the server can be adjusted to better match
expected row sizes (this can help prevent the server from locking
adjacent rows.)

The server will create a table lock if the LOCK ESCALATION
level is reached (part of sp\_configure)

**Please also see:**

MS SQl Server documentation (printed or Books Online)

If using TQueries:

- TABLOCKX
- UPDLOCK

For more information on the options above:
"Analyzing locks" Topic

(also see Database Developer\'s Companion Errata)
