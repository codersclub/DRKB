<h1>Работа с запросами</h1>
<div class="date">01.01.2007</div>


<p>Each function listed below performs a query task, such as preparing and executing a SQL or QBE query.</p>


<p>DbiGetProp:</p>
<p>Returns a property of an object.</p>

<p>DbiQAlloc:</p>
<p>Allocates a new statement handle for a prepared query.</p>

<p>DbiQExec:</p>
<p>Executes the previously prepared query identified by the supplied statement handle and</p>
<p>returns a cursor to the result set, if one is generated.</p>

<p>DbiQExecDirect:</p>
<p>Executes a SQL or QBE query and returns a cursor to the result set, if one is generated.</p>

<p>DbiQExecProcDirect:</p>
<p>Executes a stored procedure and returns a cursor to the result set, if one is generated.</p>

<p>DbiQFree:</p>
<p>Frees the resources associated with a previously prepared query identified by the supplied</p>
<p>statement handle.</p>

<p>DbiQGetBaseDescs:</p>
<p>Returns the original database, table, and field names of the fields that make up the result</p>
<p>set of a query.</p>

<p>DbiQInstantiateAnswer:</p>
<p>Creates a permanent table from the cursor to the result set.</p>

<p>DbiQPrepare:</p>
<p>Prepares a SQL or QBE query for execution, and returns a handle to a statement containing</p>
<p>the prepared query.</p>

<p>DbiQPrepareProc:</p>
<p>Prepares and optionally binds parameters for a stored procedure.</p>

<p>DbiQSetParams:</p>
<p>Associates data with parameter markers embedded within a prepared query.</p>

<p>DbiQSetProcParams:</p>
<p>Binds parameters for a stored procedure prepared with DbiQPrepareProc.</p>

<p>DbiSetProp:</p>
<p>Sets the specified property of an object to a given value.</p>

<p>DbiValidateProp:</p>
<p>Validates a property.</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
