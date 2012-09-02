<h1>Доступ к данным</h1>
<div class="date">01.01.2007</div>


<p>Each function listed below accesses data in a table, such as retrieving data from a specified BLOB field or from the record buffer.</p>


<p>DbiAppendRecord:</p>
<p>Appends a record to the end of the table associated with the given cursor.</p>

<p>DbiDeleteRecord:</p>
<p>Deletes the current record of the given cursor.</p>

<p>DbiFreeBlob:</p>
<p>Closes the BLOB handle located within the specified record buffer.</p>

<p>DbiGetBlob:</p>
<p>Retrieves data from the specified BLOB field.</p>

<p>DbiGetBlobHeading:</p>
<p>Retrieves information about a BLOB field from the BLOB heading in the record buffer.</p>

<p>DbiGetBlobSize:</p>
<p>Retrieves the size of the specified BLOB field in bytes.</p>

<p>DbiGetField:</p>
<p>Retrieves the data contents of the requested field from the record buffer.</p>

<p>DbiGetFieldDescs:</p>
<p>Retrieves a list of descriptors for all the fields in the table associated with the cursor.</p>

<p>DbiGetFieldTypeDesc:</p>
<p>Retrieves a description of the specified field type.</p>

<p>DbiInitRecord:</p>
<p>Initializes the record buffer to a blank record according to the data types of the fields.</p>

<p>DbiInsertRecord:</p>
<p>Inserts a new record into the table associated with the given cursor.</p>

<p>DbiModifyRecord:</p>
<p>Modifies the current record of table associated with the cursor with the data supplied.</p>

<p>DbiOpenBlob:</p>
<p>Prepares the cursor's record buffer to access a BLOB field.</p>

<p>DbiPutBlob:</p>
<p>Writes data into an open BLOB field.</p>

<p>DbiPutField:</p>
<p>Writes the field value to the correct location in the supplied record buffer.</p>

<p>DbiReadBlock:</p>
<p>Reads a specified number of records (starting from the next position of the cursor) into a buffer.</p>

<p>DbiSaveChanges:</p>
<p>Forces all updated records associated with the cursor to disk.</p>

<p>DbiSetFieldMap:</p>
<p>Sets a field map of the table associated with the given cursor.</p>

<p>DbiTruncateBlob:</p>
<p>Shortens the size of the contents of a BLOB field, or deletes the contents of a BLOB field</p>
<p>from the record, by shortening it to zero.</p>

<p>DbiUndeleteRecord:</p>
<p>Undeletes a dBASE record that has been marked for deletion (a "soft" delete).</p>

<p>DbiVerifyField:</p>
<p>Verifies that the data specified is a valid data type for the field specified, and that all validity</p>
<p>checks in place for the field are satisfied. It can also be used to check if a field is blank.</p>

<p>DbiWriteBlock:</p>
<p>Writes a block of records to the table associated with the cursor.</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
