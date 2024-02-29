---
Title: Доступ к данным
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Доступ к данным
===============

Each function listed below accesses data in a table, such as retrieving
data from a specified BLOB field or from the record buffer.

DbiAppendRecord
: Appends a record to the end of the table associated with the given
cursor.

DbiDeleteRecord
: Deletes the current record of the given cursor.

DbiFreeBlob
: Closes the BLOB handle located within the specified record buffer.

DbiGetBlob
: Retrieves data from the specified BLOB field.

DbiGetBlobHeading
: Retrieves information about a BLOB field from the BLOB heading in the
record buffer.

DbiGetBlobSize
: Retrieves the size of the specified BLOB field in bytes.

DbiGetField
: Retrieves the data contents of the requested field from the record
buffer.

DbiGetFieldDescs
: Retrieves a list of descriptors for all the fields in the table
associated with the cursor.

DbiGetFieldTypeDesc
: Retrieves a description of the specified field type.

DbiInitRecord
: Initializes the record buffer to a blank record according to the data
types of the fields.

DbiInsertRecord
: Inserts a new record into the table associated with the given cursor.

DbiModifyRecord
: Modifies the current record of table associated with the cursor with the
data supplied.

DbiOpenBlob
: Prepares the cursor\'s record buffer to access a BLOB field.

DbiPutBlob
: Writes data into an open BLOB field.

DbiPutField
: Writes the field value to the correct location in the supplied record
buffer.

DbiReadBlock
: Reads a specified number of records (starting from the next position of
the cursor) into a buffer.

DbiSaveChanges
: Forces all updated records associated with the cursor to disk.

DbiSetFieldMap
: Sets a field map of the table associated with the given cursor.

DbiTruncateBlob
: Shortens the size of the contents of a BLOB field, or deletes the
contents of a BLOB field
from the record, by shortening it to zero.

DbiUndeleteRecord
: Undeletes a dBASE record that has been marked for deletion (a "soft"
delete).

DbiVerifyField
: Verifies that the data specified is a valid data type for the field
specified, and that all validity
checks in place for the field are satisfied. It can also be used to
check if a field is blank.

DbiWriteBlock
: Writes a block of records to the table associated with the cursor.
