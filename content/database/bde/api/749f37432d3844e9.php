<h1>Конфигурация и настройка</h1>
<div class="date">01.01.2007</div>


<p>Each function listed below returns information about the client application environment, such as the supported table, field and index types for the driver type, or the available driver types. Functions in this category can also perform tasks that affect the client application environment, such as loading a driver.</p>


<p>DbiAddAlias:</p>
<p>Adds an alias to the BDE configuration file (IDAPI.CFG).</p>

<p>DbiAddDriver:</p>
<p>Adds a driver to the BDE configuration file (IDAPI.CFG). NEW FUNCTION BDE 4.0</p>

<p>DbiAnsiToNative:</p>
<p>Multipurpose translate function.</p>

<p>DbiDebugLayerOptions:</p>
<p>Activates, deactivates, or sets options for the BDE debug layer. OBSOLETE FUNCTION BDE 4.0</p>

<p>DbiDeleteAlias:</p>
<p>Deletes an alias from the BDE configuration file (IDAPI.CFG).</p>

<p>DbiDeleteDriver:</p>
<p>Deletes a driver from the BDE configuration file (IDAPI.CFG). NEW FUNCTION BDE 4.0</p>

<p>DbiDllExit:</p>
<p>Prepares the BDE to be disconnected within a DLL. NEW FUNCTION BDE 4.0</p>

<p>DbiExit:</p>
<p>Disconnects the client application from BDE.</p>

<p>DbiGetClientInfo:</p>
<p>Retrieves system-level information about the client application environment.</p>

<p>DbiGetDriverDesc:</p>
<p>Retrieves a description of a driver.</p>

<p>DbiGetLdName:</p>
<p>Retrieves the name of the language driver associated with the specified object name (table name).</p>

<p>DbiGetLdObj:</p>
<p>Retrieves the language driver object associated with the given cursor.</p>

<p>DbiGetNetUserName:</p>
<p>Retrieves the user's network login name. User names should be available for all networks</p>
<p>supported by Microsoft Windows.</p>

<p>DbiGetProp:</p>
<p>Returns a property of an object.</p>

<p>DbiGetSysConfig:</p>
<p>Retrieves BDE system configuration information.</p>

<p>DbiGetSysInfo:</p>
<p>Retrieves system status and information.</p>

<p>DbiGetSysVersion:</p>
<p>Retrieves the system version information, including the BDE version number, date, and time,</p>
<p>and the client interface version number.</p>

<p>DbiInit:</p>
<p>Initializes the BDE environment.</p>

<p>DbiLoadDriver:</p>
<p>Load a given driver.</p>

<p>DbiNativeToAnsi:</p>
<p>Translates a string in the native language driver to an ANSI string.</p>

<p>DbiOpenCfgInfoList:</p>
<p>Returns a handle to an in-memory table listing all the nodes in the configuration file</p>
<p>accessible by the specified path.</p>

<p>DbiOpenDriverList:</p>
<p>Creates an in-memory table containing a list of driver names available to the client application.</p>

<p>DbiOpenFieldTypesList:</p>
<p>Creates an in-memory table containing a list of field types supported by the table type for</p>
<p>the driver type.</p>

<p>DbiOpenFunctionArgList:</p>
<p>Returns a list of arguments to a data source function.</p>

<p>DbiOpenFunctionList:</p>
<p>Returns a description of a data source function.</p>

<p>DbiOpenIndexTypesList:</p>
<p>Creates an in-memory table containing a list of all supported index types for the driver type.</p>

<p>DbiOpenLdList:</p>
<p>Creates an in-memory table containing a list of available language drivers.</p>

<p>DbiOpenTableList:</p>
<p>Creates an in-memory table with information about all the tables accessible to the client application.</p>

<p>DbiOpenTableTypesList:</p>
<p>Creates an in-memory table listing table type names for the given driver.</p>

<p>DbiOpenUserList:</p>
<p>Creates an in-memory table containing a list of users sharing the same network file.</p>

<p>DbiSetProp:</p>
<p>Sets the specified property of an object to a given value.</p>

<p>DbiUseIdleTime:</p>
<p>Allows BDE to accomplish background tasks during times when the client application is idle.</p>
<p>OBSOLETE FUNCTION BDE 4.0</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
