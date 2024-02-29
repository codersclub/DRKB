---
Title: Поддержка блокировок
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Поддержка блокировок
====================

Each function listed below returns information about lock status or
acquires or releases a lock at the table or record level.

DbiAcqPersistTableLock
: Acquires an exclusive persistent lock on the table preventing other
users from using the table
or creating a table of the same name.

DbiAcqTableLock
: Acquires a table-level lock on the table associated with the given
cursor.

DbiGetRecord
: Record positioning functions have a lock parameter.

DbiIsRecordLocked
: Checks the lock status of the current record.

DbiIsTableLocked
: Returns the number of locks of a specified type acquired on the table
associated with the given session.

DbiIsTableShared
: Determines whether the table is physically shared or not.

DbiOpenLockList
: Creates an in-memory table containing a list of locks acquired on the
table.

DbiOpenUserList
: Creates an in-memory table containing a list of users sharing the same
network file.

DbiRelPersistTableLock
: Releases the persistent table lock on the specified table.

DbiRelRecordLock
: Releases the record lock on either the current record of the cursor or
only the locks acquired in the current session.

DbiRelTableLock
: Releases table locks of the specified type associated with the current
session (the session in which the cursor was created).

DbiSetLockRetry
: Sets the table and record lock retry time for the current session.

