<h1>Поддержка блокировок</h1>
<div class="date">01.01.2007</div>


<p>Each function listed below returns information about lock status or acquires or releases a lock at the table or record level.</p>


<p>DbiAcqPersistTableLock:</p>
<p>Acquires an exclusive persistent lock on the table preventing other users from using the table</p>
<p>or creating a table of the same name.</p>

<p>DbiAcqTableLock:</p>
<p>Acquires a table-level lock on the table associated with the given cursor.</p>

<p>DbiGetRecord:</p>
<p>Record positioning functions have a lock parameter.</p>

<p>DbiIsRecordLocked:</p>
<p>Checks the lock status of the current record.</p>

<p>DbiIsTableLocked:</p>
<p>Returns the number of locks of a specified type acquired on the table associated with the</p>
<p>given session.</p>

<p>DbiIsTableShared:</p>
<p>Determines whether the table is physically shared or not.</p>

<p>DbiOpenLockList:</p>
<p>Creates an in-memory table containing a list of locks acquired on the table.</p>

<p>DbiOpenUserList:</p>
<p>Creates an in-memory table containing a list of users sharing the same network file.</p>

<p>DbiRelPersistTableLock:</p>
<p>Releases the persistent table lock on the specified table.</p>

<p>DbiRelRecordLock:</p>
<p>Releases the record lock on either the current record of the cursor or only the locks acquired</p>
<p>in the current session.</p>

<p>DbiRelTableLock:</p>
<p>Releases table locks of the specified type associated with the current session (the session in</p>
<p>which the cursor was created).</p>

<p>DbiSetLockRetry:</p>
<p>Sets the table and record lock retry time for the current session.</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
