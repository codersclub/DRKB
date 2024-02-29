---
Title: Работа с запросами
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Работа с запросами
==================

Each function listed below performs a query task, such as preparing and
executing a SQL or QBE query.

DbiGetProp
: Returns a property of an object.

DbiQAlloc
: Allocates a new statement handle for a prepared query.

DbiQExec
: Executes the previously prepared query identified by the supplied
statement handle and
returns a cursor to the result set, if one is generated.

DbiQExecDirect
: Executes a SQL or QBE query and returns a cursor to the result set, if
one is generated.

DbiQExecProcDirect
: Executes a stored procedure and returns a cursor to the result set, if
one is generated.

DbiQFree
: Frees the resources associated with a previously prepared query
identified by the supplied statement handle.

DbiQGetBaseDescs
: Returns the original database, table, and field names of the fields that
make up the result set of a query.

DbiQInstantiateAnswer
: Creates a permanent table from the cursor to the result set.

DbiQPrepare
: Prepares a SQL or QBE query for execution, and returns a handle to a
statement containing the prepared query.

DbiQPrepareProc
: Prepares and optionally binds parameters for a stored procedure.

DbiQSetParams
: Associates data with parameter markers embedded within a prepared query.

DbiQSetProcParams
: Binds parameters for a stored procedure prepared with DbiQPrepareProc.

DbiSetProp
: Sets the specified property of an object to a given value.

DbiValidateProp
: Validates a property.

