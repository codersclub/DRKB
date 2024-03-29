---
Title: Работа с таблицами
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Работа с таблицами
==================

Each function listed below returns information about a specific table,
such as all the locks acquired on the table, all the referential
integrity links on the table, the indexes open on the table, or whether
or not the table is shared. Functions in this category can also perform
a table-wide operation, such as copying and deleting.

DbiBatchMove
: Appends, updates, subtracts, and copies records or fields from a source
table to a destination table.

DbiCopyTable
: Duplicates the specified source table to a destination table.

DbiCreateInMemTable
: Creates a temporary, in-memory table.

DbiCreateTable
: Creates a table.

DbiCreateTempTable
: Creates a temporary table that is deleted when the cursor is closed,
unless the call is followed by a call to DbiMakePermanent.

DbiDeleteTable
: Deletes a table.

DbiDoRestructure
: Changes the properties of a table.

DbiEmptyTable
: Deletes all records from the table associated with the specified table
cursor handle or table name.

DbiGetTableOpenCount
: Returns the total number of cursors that are open on the specified
table.

DbiGetTableTypeDesc
: Returns a description of the capabilities of the table type for the
driver type.

DbiIsTableLocked
: Returns the number of locks of a specified type acquired on the table
associated with the given session.

DbiIsTableShared
: Determines whether the table is physically shared or not.

DbiMakePermanent
: Changes a temporary table created by DbiCreateTempTable into a permanent
table.

DbiOpenFamilyList
: Creates an in-memory table listing the family members associated with a
specified table.

DbiOpenFieldList
: Creates an in-memory table listing the fields in a specified table and
their descriptions.

DbiOpenIndexList
: Opens a cursor on an in-memory table listing the indexes on a specified
table, along with their descriptions.

DbiOpenLockList
: Creates an in-memory table containing a list of locks acquired on the
table associated with the cursor.

DbiOpenRintList
: Creates an in-memory table listing the referential integrity links for a
specified table, along with their descriptions.

DbiOpenSecurityList
: Creates an in-memory table listing record-level security information
about a specified table.

DbiOpenTable
: Opens the given table for access and associates a cursor handle with the
opened table.

DbiPackTable
: Optimizes table space by rebuilding the table associated with the cursor
and releasing any free space.

DbiQInstantiateAnswer
: Creates a permanent table from a cursor handle.

DbiRegenIndexes
: Regenerates all out-of-date indexes on a given table.

DbiRenameTable
: Renames the table and all of its resources to the new name specified.

DbiSaveChanges
: Forces all updated records associated with the table to disk.

DbiSortTable
: Sorts an opened or closed table, either into itself or into a
destination table. There are options to
remove duplicates, to enable case-insensitive sorts and special sort
functions, and to control the number of records sorted.

