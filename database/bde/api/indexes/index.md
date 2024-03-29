---
Title: Работа с индексами
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Работа с индексами
==================

Each function listed below returns information about an index or
indexes, or performs a task that affects an index, such as dropping it,
deleting it, or adding it.

DbiAddIndex
: Creates an index on an existing table.

DbiCloseIndex
: Closes the specified index on a cursor.

DbiCompareKeys
: Compares two key values based on the current index of the cursor.

DbiDeleteIndex
: Drops an index on a table.

DbiExtractKey
: Retrieves the key value for the current record of the given cursor or
from the supplied record buffer.

DbiGetIndexDesc
: Retrieves the properties of the given index associated with the cursor.

DbiGetIndexDescs
: Retrieves index properties.

DbiGetIndexForField
: Returns the description of any useful index on the specified field.

DbiGetIndexSeqNo
: Retrieves the ordinal number of the index in the index list of the
specified cursor.

DbiGetIndexTypeDesc
: Retrieves a description of the index type.

DbiOpenIndex
: Opens the index for the table associated with the cursor.

DbiRegenIndex
: Regenerates an index to make sure that it is up-to-date (all records
currently in the table
are included in the index and are in the index order).

DbiRegenIndexes
: Regenerates all out-of-date indexes on a given table.

DbiSwitchToIndex
: Allows the user to change the active index order of the given cursor.

