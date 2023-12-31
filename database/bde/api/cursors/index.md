---
Title: Поддержка курсоров
Date: 01.01.2007
---


Поддержка курсоров
==================

::: {.date}
01.01.2007
:::

Each function listed below returns information about a cursor, or
performs a task that performs a cursor-related task such as positioning
of a cursor, linking of cursors, creating and closing cursors, counting
of records associated with a cursor, filtering, setting and comparing
bookmarks, and refreshing all buffers associated with a cursor.

DbiActivateFilter:

Activates a filter.

DbiAddFilter:

Adds a filter to a table, but does not activate the filter (the record
set is not yet altered).

DbiApplyDelayedUpdates:

When cached updates cursor layer is active, writes all modifications
made to cached data to the

underlying database.

DbiBeginDelayedUpdates:

Creates a cached updates cursor layer so that users can make extended
changes to temporarily

cached table data without writing to the actual table, thereby
minimizing resource locking.

DbiBeginLinkMode:

Converts a cursor to a link cursor. Given an open cursor, prepares for
linked access. Returns a

new cursor.

DbiCloneCursor:

Creates a new cursor (clone cursor) which has the same result set as the
given cursor

(source cursor).

DbiCloseCursor:

Closes a previously opened cursor.

DbiCompareBookMarks:

Compares the relative positions of two bookmarks in the result set
associated with the cursor.

DbiDeactivateFilter:

Temporarily stops the specified filter from affecting the record set by
turning the filter off.

DbiDropFilter:

Deactivates and removes a filter from memory, and frees all resources.

DbiEndDelayedUpdates:

Closes a cached updates cursor layer ending the cached updates mode.

DbiEndLinkMode:

Ends linked cursor mode, and returns the original cursor.

DbiExtractKey:

Retrieves the key value for the current record of the given cursor or
from the supplied record buffer.

DbiForceRecordReread:

Rereads a single record from the server on demand, refreshing one row
only, rather than clearing

the cache.

DbiForceReread:

Refreshes all buffers associated with the cursor, if necessary.

DbiFormFullName:

Returns the fully qualified table name.

DbiGetBookMark:

Saves the current position of a cursor to the client-supplied buffer
called a bookmark.

DbiGetCursorForTable:

Finds the cursor for the given table.

DbiGetCursorProps:

Returns the properties of the cursor.

DbiGetExactRecordCount:

Retrieves the current exact number of records associated with the
cursor. NEW FUNCTION BDE 4.0

DbiGetFieldDescs:

Retrieves a list of descriptors for all the fields in the table
associated with the cursor.

DbiGetLinkStatus:

Returns the link status of the cursor.

DbiGetNextRecord:

Retrieves the next record in the table associated with the cursor.

DbiGetPriorRecord:

Retrieves the previous record in the table associated with the given
cursor.

DbiGetProp:

Returns a property of an object.

DbiGetRecord:

Retrieves the current record, if any, in the table associated with the
cursor.

DbiGetRecordCount:

Retrieves the current number of records associated with the cursor.

DbiGetRecordForKey:

Finds and retrieves a record matching a key and positions the cursor on
that record.

DbiGetRelativeRecord:

Positions the cursor on a record in the table relative to the current
position of the cursor.

DbiGetSeqNo:

Retrieves the sequence number of the current record in the table
associated with the cursor.

DbiLinkDetail:

Establishes a link between two tables such that the detail table has its
record set limited to the

set of records matching the linking key values of the master table
cursor.

DbiLinkDetailToExp:

Links the detail cursor to the master cursor using an expression.

DbiMakePermanent:

Changes a temporary table created by DbiCreateTempTable into a permanent
table.

DbiOpenTable:

Opens the given table for access and associates a cursor handle with the
opened table.

DbiResetRange:

Removes the specified table\'s limited range previously established by
the function DbiSetRange.

DbiSaveChanges:

Forces all updated records associated with the cursor to disk.

DbiSetFieldMap:

Sets a field map of the table associated with the given cursor.

DbiSetProp:

Sets the specified property of an object to a given value.

DbiSetRange:

Sets a range on the result set associated with the cursor.

DbiSetToBegin:

Positions the cursor to BOF (just before the first record).

DbiSetToBookMark:

Positions the cursor to the location saved in the specified bookmark.

DbiSetToCursor:

Sets the position of one cursor (the destination cursor) to that of
another (the source cursor).

DbiSetToEnd:

Positions the cursor to EOF (just after the last record).

DbiSetToKey:

Positions an index-based cursor on a key value.

DbiSetToRecordNo:

Positions the cursor of a dBASE table to the given physical record
number.

DbiSetToSeqNo:

Positions the cursor to the specified sequence number of a Paradox
table.

DbiUnlinkDetail:

Removes a link between two cursors.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
