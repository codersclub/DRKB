<h1>Работа с таблицами</h1>
<div class="date">01.01.2007</div>


<p>Each function listed below returns information about a specific table, such as all the locks acquired on the table, all the referential integrity links on the table, the indexes open on the table, or whether or not the table is shared. Functions in this category can also perform a table-wide operation, such as copying and deleting.</p>


<p>DbiBatchMove:</p>
<p>Appends, updates, subtracts, and copies records or fields from a source table to a destination table.</p>

<p>DbiCopyTable:</p>
<p>Duplicates the specified source table to a destination table.</p>

<p>DbiCreateInMemTable:</p>
<p>Creates a temporary, in-memory table.</p>

<p>DbiCreateTable:</p>
<p>Creates a table.</p>

<p>DbiCreateTempTable:</p>
<p>Creates a temporary table that is deleted when the cursor is closed, unless the call is followed</p>
<p>by a call to DbiMakePermanent.</p>

<p>DbiDeleteTable:</p>
<p>Deletes a table.</p>

<p>DbiDoRestructure:</p>
<p>Changes the properties of a table.</p>

<p>DbiEmptyTable:</p>
<p>Deletes all records from the table associated with the specified table cursor handle or table name.</p>

<p>DbiGetTableOpenCount:</p>
<p>Returns the total number of cursors that are open on the specified table.</p>

<p>DbiGetTableTypeDesc:</p>
<p>Returns a description of the capabilities of the table type for the driver type.</p>

<p>DbiIsTableLocked:</p>
<p>Returns the number of locks of a specified type acquired on the table associated with the</p>
<p>given session.</p>

<p>DbiIsTableShared:</p>
<p>Determines whether the table is physically shared or not.</p>

<p>DbiMakePermanent:</p>
<p>Changes a temporary table created by DbiCreateTempTable into a permanent table.</p>

<p>DbiOpenFamilyList:</p>
<p>Creates an in-memory table listing the family members associated with a specified table.</p>

<p>DbiOpenFieldList:</p>
<p>Creates an in-memory table listing the fields in a specified table and their descriptions.</p>

<p>DbiOpenIndexList:</p>
<p>Opens a cursor on an in-memory table listing the indexes on a specified table, along with</p>
<p>their descriptions.</p>

<p>DbiOpenLockList:</p>
<p>Creates an in-memory table containing a list of locks acquired on the table associated with the cursor.</p>

<p>DbiOpenRintList:</p>
<p>Creates an in-memory table listing the referential integrity links for a specified table, along with</p>
<p>their descriptions.</p>

<p>DbiOpenSecurityList:</p>
<p>Creates an in-memory table listing record-level security information about a specified table.</p>

<p>DbiOpenTable:</p>
<p>Opens the given table for access and associates a cursor handle with the opened table.</p>

<p>DbiPackTable:</p>
<p>Optimizes table space by rebuilding the table associated with the cursor and releasing any free space.</p>

<p>DbiQInstantiateAnswer:</p>
<p>Creates a permanent table from a cursor handle.</p>

<p>DbiRegenIndexes:</p>
<p>Regenerates all out-of-date indexes on a given table.</p>

<p>DbiRenameTable:</p>
<p>Renames the table and all of its resources to the new name specified.</p>

<p>DbiSaveChanges:</p>
<p>Forces all updated records associated with the table to disk.</p>

<p>DbiSortTable:</p>
<p>Sorts an opened or closed table, either into itself or into a destination table. There are options to</p>
<p>remove duplicates, to enable case-insensitive sorts and special sort functions, and to control the</p>
<p>number of records sorted.</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
