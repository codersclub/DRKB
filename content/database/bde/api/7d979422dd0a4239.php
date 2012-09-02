<h1>Поддержка курсоров</h1>
<div class="date">01.01.2007</div>


<p>Each function listed below returns information about a cursor, or performs a task that performs a cursor-related task such as positioning of a cursor, linking of cursors, creating and closing cursors, counting of records associated with a cursor, filtering, setting and comparing bookmarks, and refreshing all buffers associated with a cursor.</p>


<p>DbiActivateFilter:</p>
<p>Activates a filter.</p>

<p>DbiAddFilter:</p>
<p>Adds a filter to a table, but does not activate the filter (the record set is not yet altered).</p>

<p>DbiApplyDelayedUpdates:</p>
<p>When cached updates cursor layer is active, writes all modifications made to cached data to the</p>
<p>underlying database.</p>

<p>DbiBeginDelayedUpdates:</p>
<p>Creates a cached updates cursor layer so that users can make extended changes to temporarily</p>
<p>cached table data without writing to the actual table, thereby minimizing resource locking.</p>

<p>DbiBeginLinkMode:</p>
<p>Converts a cursor to a link cursor. Given an open cursor, prepares for linked access. Returns a</p>
<p>new cursor.</p>

<p>DbiCloneCursor:</p>
<p>Creates a new cursor (clone cursor) which has the same result set as the given cursor</p>
<p>(source cursor).</p>

<p>DbiCloseCursor:</p>
<p>Closes a previously opened cursor.</p>

<p>DbiCompareBookMarks:</p>
<p>Compares the relative positions of two bookmarks in the result set associated with the cursor.</p>

<p>DbiDeactivateFilter:</p>
<p>Temporarily stops the specified filter from affecting the record set by turning the filter off.</p>

<p>DbiDropFilter:</p>
<p>Deactivates and removes a filter from memory, and frees all resources.</p>

<p>DbiEndDelayedUpdates:</p>
<p>Closes a cached updates cursor layer ending the cached updates mode.</p>

<p>DbiEndLinkMode:</p>
<p>Ends linked cursor mode, and returns the original cursor.</p>

<p>DbiExtractKey:</p>
<p>Retrieves the key value for the current record of the given cursor or from the supplied record buffer.</p>

<p>DbiForceRecordReread:</p>
<p>Rereads a single record from the server on demand, refreshing one row only, rather than clearing</p>
<p>the cache.</p>

<p>DbiForceReread:</p>
<p>Refreshes all buffers associated with the cursor, if necessary.</p>

<p>DbiFormFullName:</p>
<p>Returns the fully qualified table name.</p>

<p>DbiGetBookMark:</p>
<p>Saves the current position of a cursor to the client-supplied buffer called a bookmark.</p>

<p>DbiGetCursorForTable:</p>
<p>Finds the cursor for the given table.</p>

<p>DbiGetCursorProps:</p>
<p>Returns the properties of the cursor.</p>

<p>DbiGetExactRecordCount:</p>
<p>Retrieves the current exact number of records associated with the cursor. NEW FUNCTION BDE 4.0</p>

<p>DbiGetFieldDescs:</p>
<p>Retrieves a list of descriptors for all the fields in the table associated with the cursor.</p>

<p>DbiGetLinkStatus:</p>
<p>Returns the link status of the cursor.</p>

<p>DbiGetNextRecord:</p>
<p>Retrieves the next record in the table associated with the cursor.</p>

<p>DbiGetPriorRecord:</p>
<p>Retrieves the previous record in the table associated with the given cursor.</p>

<p>DbiGetProp:</p>
<p>Returns a property of an object.</p>

<p>DbiGetRecord:</p>
<p>Retrieves the current record, if any, in the table associated with the cursor.</p>

<p>DbiGetRecordCount:</p>
<p>Retrieves the current number of records associated with the cursor.</p>

<p>DbiGetRecordForKey:</p>
<p>Finds and retrieves a record matching a key and positions the cursor on that record.</p>

<p>DbiGetRelativeRecord:</p>
<p>Positions the cursor on a record in the table relative to the current position of the cursor.</p>

<p>DbiGetSeqNo:</p>
<p>Retrieves the sequence number of the current record in the table associated with the cursor.</p>

<p>DbiLinkDetail:</p>
<p>Establishes a link between two tables such that the detail table has its record set limited to the</p>
<p>set of records matching the linking key values of the master table cursor.</p>

<p>DbiLinkDetailToExp:</p>
<p>Links the detail cursor to the master cursor using an expression.</p>

<p>DbiMakePermanent:</p>
<p>Changes a temporary table created by DbiCreateTempTable into a permanent table.</p>

<p>DbiOpenTable:</p>
<p>Opens the given table for access and associates a cursor handle with the opened table.</p>

<p>DbiResetRange:</p>
<p>Removes the specified table's limited range previously established by the function DbiSetRange.</p>

<p>DbiSaveChanges:</p>
<p>Forces all updated records associated with the cursor to disk.</p>

<p>DbiSetFieldMap:</p>
<p>Sets a field map of the table associated with the given cursor.</p>

<p>DbiSetProp:</p>
<p>Sets the specified property of an object to a given value.</p>

<p>DbiSetRange:</p>
<p>Sets a range on the result set associated with the cursor.</p>

<p>DbiSetToBegin:</p>
<p>Positions the cursor to BOF (just before the first record).</p>

<p>DbiSetToBookMark:</p>
<p>Positions the cursor to the location saved in the specified bookmark.</p>

<p>DbiSetToCursor:</p>
<p>Sets the position of one cursor (the destination cursor) to that of another (the source cursor).</p>

<p>DbiSetToEnd:</p>
<p>Positions the cursor to EOF (just after the last record).</p>

<p>DbiSetToKey:</p>
<p>Positions an index-based cursor on a key value.</p>

<p>DbiSetToRecordNo:</p>
<p>Positions the cursor of a dBASE table to the given physical record number.</p>

<p>DbiSetToSeqNo:</p>
<p>Positions the cursor to the specified sequence number of a Paradox table.</p>

<p>DbiUnlinkDetail:</p>
<p>Removes a link between two cursors.</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
